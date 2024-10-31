<?php

global $wpdb;

if (isset($_POST["submit"]) and $_POST["action"] == "reject_withdrawal") {
    if (
        !isset($_POST["aistore_nonce"]) ||
        !wp_verify_nonce($_POST["aistore_nonce"], "aistore_nonce_action")
    ) {
        return _e("Sorry, your nonce did not verify", "aistore");
        exit();
    }

    $withdrawal_id = sanitize_text_field($_REQUEST["withdrawal_id"]);

    $wpdb->query(
        $wpdb->prepare(
            "UPDATE {$wpdb->prefix}widthdrawal_requests
    SET status = '%s'  WHERE id = '%d'",
            "Rejected",
            $withdrawal_id
        )
    );

    $widthdrawal = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}widthdrawal_requests WHERE id=%s ",
            $withdrawal_id
        )
    );

    $to = esc_attr($widthdrawal->username);
    $subject = "Withdrawal Request Rejected";

    $body =
        "Hello, <br>
 
     <h2>Your  withdrawal request is Rejected for the withdraw ID " .
        esc_attr($withdrawal_id) .
        " </h2>" .
        "<br>Withdraw ID is: " .
        esc_attr($withdrawal_id) .
        "<br>Rejected Withdraw system to :<br>";

    $headers = ["Content-Type: text/html; charset=UTF-8"];
    wp_mail($to, $subject, $body, $headers);
}

if (isset($_POST["submit"]) and $_POST["action"] == "approve_withdrawal") {
    if (
        !isset($_POST["aistore_nonce"]) ||
        !wp_verify_nonce($_POST["aistore_nonce"], "aistore_nonce_action")
    ) {
        return _e("Sorry, your nonce did not verify", "aistore");
        exit();
    }

    $withdrawal_id = sanitize_text_field($_REQUEST["withdrawal_id"]);

    $wpdb->query(
        $wpdb->prepare(
            "UPDATE {$wpdb->prefix}widthdrawal_requests
    SET status = '%s'  WHERE id = '%d'",
            "Approved",
            $withdrawal_id
        )
    );

    $widthdrawal = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}widthdrawal_requests WHERE id=%s ",
            $withdrawal_id
        )
    );

    $to = $widthdrawal->username;
    $subject = "Withdrawal Approved";

    $body =
        "Hello, <br>
 
     <h2> withdraw approved  successfully for the withdraw ID " .
        esc_attr($withdrawal_id) .
        " </h2>" .
        "<br>Withdraw ID is: " .
        esc_attr($withdrawal_id) .
        "<br>Approved Withdraw system to :<br>";

    //$body.=__( 'Your Recevier Email'.$receiver_email, 'aistore' );

    $headers = ["Content-Type: text/html; charset=UTF-8"];
    wp_mail($to, $subject, $body, $headers);
}

if (isset($_POST["submit"]) and $_POST["action"] == "delete_withdrawal") {
    if (
        !isset($_POST["aistore_nonce"]) ||
        !wp_verify_nonce($_POST["aistore_nonce"], "aistore_nonce_action")
    ) {
        return _e("Sorry, your nonce did not verify", "aistore");
        exit();
    }

    $withdrawal_id = sanitize_text_field($_REQUEST["withdrawal_id"]);

    $table = $wpdb->prefix . "widthdrawal_requests";
    $wpdb->delete($table, ["id" => $withdrawal_id]);
}
?>
       <div class="wrap">


		

       <?php
       $results = $wpdb->get_results(
           "SELECT * FROM {$wpdb->prefix}widthdrawal_requests"
       );

       if ($results == null) {
           echo "<div class='no-result'>";

           _e("No Withdraw Found", "aistore");
           echo "</div>";
       } else {
           foreach ($results as $row): ?>
 
          <div class="accordion" id="accordionExample">
              
  <div class="accordion-item">
    <h2 class="accordion-header" id="heading<?php echo esc_attr($row->id); ?>">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo esc_attr(
          $row->id
      ); ?>" aria-expanded="true" aria-controls="collapse<?php echo esc_attr(
    $row->id
); ?>">
        #<?php echo esc_attr($row->id); ?> :  <?php echo esc_attr(
     $row->username
 ); ?>
      </button>
    </h2>
    <div id="collapse<?php echo esc_attr(
        $row->id
    ); ?>" class="accordion-collapse collapse show" aria-labelledby="heading<?php echo esc_attr(
    $row->id
); ?>" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <table class="widefat fixed striped">
        
   
  <table class="widefat striped fixed">
    
      <tr>
      <th scope="row"><?php _e("Username", "aistore"); ?> :</th>
      <td>   <?php echo esc_attr($row->username); ?></td>
      
    </tr>
    
      <tr>
      <th scope="row"><?php _e("Amount", "aistore"); ?> :    </th>
      <td>       <?php echo esc_attr($row->amount) . " "; ?></td>
      
    </tr>
    
     <tr>
      <th scope="row"><?php _e("Status", "aistore"); ?> :</th>
      <td>   <?php echo esc_attr($row->status); ?></td>
      
    </tr>
    
   
    
     <tr>
      <th scope="row"><?php _e("Date", "aistore"); ?> :</th>
      <td>   <?php echo esc_attr($row->created_at); ?></td>
      
    </tr>
    
    
    <tr>
        <td>
      
<?php
$users = $wpdb->get_row(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}users WHERE user_email=%s ",
        $row->username
    )
);

$bank_account = esc_attr(get_the_author_meta("user_bank_detail", $users->ID));
$user_deposit_instructions = esc_attr(
    get_the_author_meta("user_deposit_instruction", $users->ID)
);
?>
<!-- Button trigger modal -->



 


  </td>
  
  <td>

 
 <form method="POST" action="" name="approve_withdrawal" enctype="multipart/form-data"> 

<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  
  <input class="input" type="hidden" id="withdrawal_id" name="withdrawal_id" value="<?php echo esc_attr(
      $row->id
  ); ?> ">
<input 
 type="submit" class="btn btn-primary btn-sm" name="submit" value="<?php _e(
     "Approve",
     "aistore"
 ); ?>"/>
<input type="hidden" name="action" value="approve_withdrawal" />
</form>

 

</td>

<td>

 
 <form method="POST" action="" name="reject_withdrawal" enctype="multipart/form-data"> 

<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  
  <input class="input" type="hidden" id="withdrawal_id" name="withdrawal_id" value="<?php echo esc_attr(
      $row->id
  ); ?> ">
<input 
 type="submit" class="btn btn-primary btn-sm" name="submit" value="<?php _e(
     "Reject",
     "aistore"
 ); ?>"/>
<input type="hidden" name="action" value="reject_withdrawal" />
</form>

 
</td>

<td>
 
 <form method="POST" action="" name="delete_withdrawal" enctype="multipart/form-data"> 

<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  
  <input class="input" type="hidden" id="withdrawal_id" name="withdrawal_id" value="<?php echo esc_attr(
      $row->id
  ); ?> ">
<input 
 type="submit" class="btn btn-primary btn-sm" name="submit" value="<?php _e(
     "Delete",
     "aistore"
 ); ?>"/>
<input type="hidden" name="action" value="delete_withdrawal" />
</form>

 

		   </td>
    </tr>

</table>
      </div>
    </div>
  </div>
    <?php endforeach;
       }
       ?>
    
  </div> 