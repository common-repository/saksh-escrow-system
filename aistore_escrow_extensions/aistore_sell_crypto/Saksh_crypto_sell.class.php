<?php


 
include_once SAKSH_ESCROW_DIR."/aistore_escrow/AistoreEscrow.class.php";


class Saksh_crypto_sell extends AistoreEscrow
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

    public static function sell_bitcoin_escrow_form11111()
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
 
 
        } else { 

    }
    
      return ob_get_clean();
    }
    
    
    
    
    
    
    
    
    
    
    
    
   
    // create escrow System
    // This function is used to escrow form and create escrow
    
    
    
       public   function sell_bitcoin_escrow_form()
    {
        
        ob_start();
        
        
        if (!is_user_logged_in())
        {
            return "<div class='loginerror'>Kindly login and then visit this page</div>";
        }
        
        

        global $saksh;

     
        echo "<div>";

        $wallet = new AistoreWallet();

        $user_id = get_current_user_id();

        if (isset($_POST["submit"]) and $_POST["action"] == "escrow_system") {
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

            $_REQUEST["user_email"] = get_the_author_meta(
                "user_email",
                $user_id
            );

$_REQUEST["title"] ="Sell bitcoin for the online";

$_REQUEST["aistore_escrow_currency"] ="BTC";


$terms_conditions="<br> Amount in BTC ". $_REQUEST["amount"];

$terms_conditions .="<br> Amount in usd ". $_REQUEST["amount_usd"];

$terms_conditions .="<br> Bank details ". $_REQUEST["bank_account"];

$terms_conditions .="<br> Others Information ". $_REQUEST["term_condition"];


 

$_REQUEST["term_condition"] =$terms_conditions;



            $escrow = $this->create_escrow($_REQUEST);

            $details_escrow_page_id =
                $saksh["escrow_page"]["details_escrow_page_id"];

            $details_escrow_page_id = esc_url(
                add_query_arg(
                    [
                        "page_id" => $details_escrow_page_id,
                        "eid" => $escrow->id,
                    ],
                    home_url()
                )
            );

            $data = [];
            $data["escrow"] = $escrow;
            $data["files"] = $_FILES;
            $data["request"] = $_REQUEST;
            $data["get"] = $_GET;
            $data["post"] = $_POST;
            $data["server"] = $_SERVER;

            do_action("AistoreEscrowCreatedafter", $data);

           // echo $details_escrow_page_id;

       
?>
<meta http-equiv="refresh" content="0; URL=<?php echo esc_url($details_escrow_page_id); ?>" />


<?php
 
        } else {
             ?>
    
    <form method="POST" action="" name="escrow_system" enctype="multipart/form-data"> 

<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>

        
  
  <label for="receiver_email"><?php _e(
    "BTC Buyer Email",
    "aistore"
); ?>:</label><br>
  <input class="input" type="email" id="receiver_email" name="receiver_email" required><br>
   

  <label for="amount"><?php _e("Amount in BTC", "aistore"); ?></label><br>
  
  
  
  <input class="input" type="text" id="amount" name="amount"   required><br>
 
 

  <label for="amount_usd"><?php _e("Amount ", "aistore"); ?></label><br>
  
  
  
  <input class="input" type="text" id="amount_usd" name="amount_usd"   required><br>
 
 <label for="title"><?php _e("Currency", "aistore"); ?></label><br>
  
  
  
  
  <?php
  
  
  global $wpdb;
  
  
  $escrow_wallet = new AistoreWallet();
  
  
  $results = $escrow_wallet->aistore_wallet_currency();
  
  
  ?>
      
      
      
       <select name="aistore_escrow_currency" id="aistore_escrow_currency" >
                <?php foreach ($results as $c) {
                    echo '	<option  value="' .
                        esc_attr($c->symbol) .
                        '">' .
                        esc_attr($c->currency) .
                        "</option>";
                } ?>
           
  
</select>

  
  
  
  
   <label for="term_condition"> <?php _e(
       "Bank details  ",
       "aistore"
   ); ?></label><br>
   
  <?php
  $content = "";
  $editor_id = "bank_account";

  $settings = [
      "tinymce" => [
          "toolbar1" =>
              "bold,italic,underline,separator,alignleft,aligncenter,alignright   ",
          "toolbar2" => "",
          "toolbar3" => "",
      ],
      "textarea_rows" => 1,
      "teeny" => true,
      "quicktags" => false,
      "media_buttons" => false,
      "remove_linebreaks" => false,
  ];

  wp_editor($content, $editor_id, $settings);
  
  ?>
  
   <label for="term_condition"> <?php _e(
       "Terms and conitions",
       "aistore"
   ); ?></label><br>
   
  <?php
  $content = "";
  $editor_id = "term_condition";

  $settings = [
      "tinymce" => [
          "toolbar1" =>
              "bold,italic,underline,separator,alignleft,aligncenter,alignright   ",
          "toolbar2" => "",
          "toolbar3" => "",
      ],
      "textarea_rows" => 1,
      "teeny" => true,
      "quicktags" => false,
      "media_buttons" => false,
      "remove_linebreaks" => false,
  ];

  wp_editor($content, $editor_id, $settings);

 
  ?>



<input 
 type="submit" class="button button-primary  btn  btn-primary "   name="submit" value="<?php _e(
     "Create Escrow for the Sell of the bitcoin",
     "aistore"
 ); ?>"/>
 
 
<input type="hidden" name="action" value="escrow_system" />
</form> 
<?php
        }
        ?>
</div>
<?php return ob_get_clean();
    }
    
    
    
    
    
    
}