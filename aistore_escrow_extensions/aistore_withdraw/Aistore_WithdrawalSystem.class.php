<?php

class Aistore_WithdrawalSystem
{
    public static function aistore_bank_account()
    {
        do_action("Aistoreuserbank_details");
    }

    /**
       * 
       * This function is used to wWithdrawal Request form
       * Bank Account Details  
       * Bank Details and Deposit Instructions
       * Withdraw Report
       * Withdraw Id 
       * Withdraw Amount
       * Withdraw Charge 
       * Withdraw Currency
       * Withdraw Status
       * Withdraw Date
      
       * 
       */

    public static function aistore_saksh_withdrawal_system()
    {
        if (!is_user_logged_in()) {
            return "Please login to start ";
        }
        ob_start();

        global $wpdb;

        $wallet = new AistoreWallet();
        $object_escrow = new AistoreEscrowSystem();

        $user_id = get_current_user_id();

        if (
            isset($_POST["submit"]) and
            sanitize_text_field($_POST["action"]) == "withdrawal_request"
        ) {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
                exit();
            }

            $user_id = get_current_user_id();

            $description = "Withdraw Balance";

            $aistore_currency = sanitize_text_field(
                $_REQUEST["aistore_currency"]
            );

            $amount = intval(sanitize_text_field($_REQUEST["amount"]));

            $username = get_the_author_meta(
                "user_email",
                get_current_user_id()
            );

            $balance = $wallet->aistore_balance($user_id, $aistore_currency);

            $escrow_admin_user_id = get_option("escrow_user_id");

            if ($balance >= $amount) {
                $withdraw = floatval(get_option("withdraw_fee"));

                $withdraw_fee = ($withdraw / 100) * $amount;

                $new_amount = $amount - $withdraw_fee;

                $res = $wpdb->prepare(
                    "INSERT INTO {$wpdb->prefix}widthdrawal_requests ( amount,username,currency ,charges ) VALUES ( %s, %s, %s, %s)",
                    [$new_amount, $username, $aistore_currency, $withdraw_fee]
                );

                $wpdb->query($res);

                $wid = $wpdb->insert_id;

                $wallet->aistore_debit(
                    $user_id,
                    $amount,
                    $aistore_currency,
                    $description,
                    $wid
                );

                $description = "Withdraw Fee";

                $wallet->aistore_credit(
                    $escrow_admin_user_id,
                    $withdraw_fee,
                    $aistore_currency,
                    $description,
                    $wid
                );

                // email to sender

                $to = $username;
                $subject = "Withdrawal Request";

                $user_id = get_current_user_id();
                $user = get_user_by("id", $user_id);

                $withdraw_page_id_url = esc_url(
                    add_query_arg(
                        [
                            "page_id" => 449,
                            "wid" => $wid,
                        ],
                        home_url()
                    )
                );

                $body =
                    "Hello, <br>
 
     <h2> withdraw request have successfully for the withdraw ID " .
                    $wid .
                    " </h2>" .
                    "<br>Withdraw ID is: " .
                    $wid .
                    "<br>Amount: " .
                    $amount .
                    "<br>Withdraw Fee: " .
                    $withdraw_fee .
                    "<br>Process Withdraw system to :<br>" .
                    $withdraw_page_id_url .
                    "<br>";

                $body .=
                    " <br><h2> Bank Account  Details </h2><br>
   <table>
    <tr><td>Bank Details :</td></tr>
    <tr><td>" .
                    $user->user_bank_details .
                    "</td></tr>
    
    <tr><td>Deposit Instructions :</td></tr>
    <tr><td>" .
                    $user->user_deposit_instructions .
                    "</td></tr>

</table>

   ";

                //$body.=__( 'Your Recevier Email'.$receiver_email, 'aistore' );

                $headers = ["Content-Type: text/html; charset=UTF-8"];

                wp_mail($to, $subject, $body, $headers);

                _e("Withdraw Submitted succesfully", "aistore");
            } else {
                _e("Insufficient Balance", "aistore");
            }
            ?>
    
   

<?php
        } else {
             ?>

   <form method="POST" action="" name="withdrawal_request" enctype="multipart/form-data"> 

<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>

                
                 

<?php $user_id = get_current_user_id(); ?>
    <h6><?php _e("Withdrawal Request", "aistore"); ?> </h6>
  <label for="amount"><?php _e("Amount", "aistore"); ?></label><br>
  
  <input class="input" type="number" id="amount" name="amount"   required  class="form-control" step="any" style="width:100%;" ><br>

  <label for="title"><?php _e("Currency", "aistore"); ?></label><br>
  <?php
  global $wpdb;
  $wallet = new AistoreWallet();
  $results = $wallet->aistore_wallet_currency();
  ?>
       <select name="aistore_currency" id="aistore_currency" >
                <?php foreach ($results as $c) {
                    echo '	<option  value="' .
                        esc_attr($c->symbol) .
                        '">' .
                        esc_attr($c->currency) .
                        "</option>";
                } ?>
           
  
</select><br>
  <?php  ?>


<?php
_e("Account balance is:", "aistore");

global $wpdb;

$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}escrow_currency  order by id desc");
foreach ($results as $row):
    $currency = $row->currency;
    $wallet = new AistoreWallet();

    $balance = $wallet->aistore_balance($user_id, $currency);

    echo "<br>" . esc_attr($balance) . " " . esc_attr($currency);
endforeach;
?>
  
 


<br>
	<br>
<input 
 type="submit"  name="submit" value="<?php _e("Withdrawal", "aistore"); ?>"/>
<input type="hidden" name="action" value="withdrawal_request" />
</form> 



<?php
        }
        ?>





<br>
<hr>

<h6> <?php _e("Bank Account Details", "aistore"); ?></h6>
<?php
$user_id = get_current_user_id();
$user = get_user_by("id", $user_id);

if ($user->user_bank_details === "NULL") {
    _e("Please Add Bank Account Details", "aistore");
} else {
     ?>
<table>
    <tr><td><?php _e("Bank Details", "aistore"); ?> :</td></tr>
    <tr><td><?php echo esc_attr(
        get_the_author_meta("user_bank_detail")
    ); ?></td></tr>
    
    <tr><td><?php _e("Deposit Instructions", "aistore"); ?> :</td></tr>
    <tr><td><?php echo esc_attr(
        get_the_author_meta("user_deposit_instruction")
    ); ?></td></tr>
</table>
<?php
}
?>

<br>
<hr>
<h6><?php _e("Withdraw Report", "aistore"); ?></h6>
<?php
$current_user_email_id = get_the_author_meta(
    "user_email",
    get_current_user_id()
);

global $wpdb;

$results = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}widthdrawal_requests WHERE username=%s order by id desc limit 100",
        $current_user_email_id
    )
);

if ($results == null) {
    echo "<div class='no-result'>";

    _e("Withdrawal List Not Found", "aistore");
    echo "</div>";
} else {
     ?>
  
    <table class="table">
     
        <tr>
      
    <th><?php _e("ID", "aistore"); ?></th>
        <th><?php _e("Amount", "aistore"); ?></th>
        <th><?php _e("Charges", "aistore"); ?></th>
        
		    <th><?php _e("Status", "aistore"); ?></th>  
		    <th><?php _e("Date", "aistore"); ?></th>
		 
</tr>

    <?php foreach ($results as $row): ?>
 <tr>         		   <td> 
		   <?php echo esc_attr($row->id); ?></td>

   
		   
		  	   <td> 		   <?php echo esc_attr($row->amount) .
            " " .
            esc_attr($row->currency); ?>  </td>
		  	   <td> 		   <?php echo esc_attr($row->charges) .
            " " .
            esc_attr($row->currency); ?>  </td>
	
		    <td> 		   <?php echo esc_attr($row->status); ?> </td>
		    	   <td> 		   <?php echo esc_attr($row->created_at); ?> </td>

            </tr>
    <?php endforeach;
}
?>

    </table>
<?php return ob_get_clean();
    }
}

?>
