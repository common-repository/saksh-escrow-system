<?php
if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}
 

class AistoreEscrowSystem extends AistoreEscrow
{
    // This function is used to  bank make payment and payment method list
    public static function payment_method_list()
    {
        ob_start();

        echo "<div class='saksh_payment_list  b5'>"; //do_action("Aistorebank_makepayment");
        do_action("payment_method_list");

        echo "</div>";
        return ob_get_clean();
    }

   
   
   
   
   
   
   
   
   
   
   
   
   
   
    // create escrow System
    // This function is used to escrow form and create escrow
    public function aistore_escrow_system()
    {
        ob_start();

        global $saksh;

        $escrow_admin_user_id = $this->get_escrow_admin_user_id(); // change variable name

        echo "<div class='b5'>";

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

           echo $details_escrow_page_id;

    /*   
?>
<meta http-equiv="refresh" content="0; URL=<?php echo esc_url($details_escrow_page_id); ?>" />


<?php

*/
 
        } else {
             ?>
     

    <form method="POST" action="" name="escrow_system" enctype="multipart/form-data"> 

<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>

                
                 
<label for="title"><?php _e("Title", "aistore"); ?></label><br>
  <input class="input" type="text" id="title" name="title" required><br>

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
           
  
</select><br>
 

  <label for="amount"><?php _e("Amount", "aistore"); ?></label><br>
  <input class="input" type="text" id="amount" name="amount"   required><br>
 
 
 
  
<label for="receiver_email"><?php _e(
    "Receiver Email",
    "aistore"
); ?>:</label><br>
  <input class="input" type="email" id="receiver_email" name="receiver_email" required><br>
  
 
   
  <?php
 





  do_action("after_aistore_escrow_form", $_REQUEST);
  
  
  
  
    $saksh_create_escrow_form = array();

    $saksh_create_escrow_form = apply_filters('saksh_create_escrow_form', $saksh_create_escrow_form);
  
 // echo "<pre>";
 // var_dump($saksh_create_escrow_form);
 
 
 
 // echo "</pre>";
  
  
  
  $saksh = array();
        foreach ($saksh_create_escrow_form as $group => $fields)
        {
      
          saksh_print_form($group, $fields,$saksh);

        }
        
        
  ?>
	 
<input 
 type="submit" class="button button-primary  btn  btn-primary "   name="submit" value="<?php _e(
     "Create Escrow",
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    // Escrow List
    //  This function is used to escrow list
    public function aistore_escrow_list()
    {
        $object_escrow_currency = new AistoreEscrowSystem();

        $user_id = get_current_user_id();
        $current_user_email_id = get_the_author_meta("user_email", $user_id);

        global $wpdb;

        $results = $this->AistoreEscrowList($current_user_email_id);

        ob_start();

        echo "<div class='b5'>";
        do_action("aistore_escrow_list_top", $current_user_email_id);
        ?>
     
<h3><u><?php _e("Top  Escrow", "aistore"); ?></u> </h3>
<?php if ($results == null) {
    echo "<div class='no-result'>";

    _e("No Escrow Found", "aistore");
    echo "</div>";
} else {
     ?>
 <div class="aistore_message" ><center> If you don't see your escrow then system need to clear the cache for this.</center></div>
    <table class="table">
     
        <tr>
      
    <th><?php _e("Id", "aistore"); ?></th>
        <th><?php _e("Title", "aistore"); ?></th>
         <th><?php _e("Role", "aistore"); ?></th>
          <th><?php _e("Amount", "aistore"); ?></th> 
		  <th><?php _e("Sender", "aistore"); ?></th>
		  <th><?php _e("Receiver", "aistore"); ?></th>
		    <th><?php _e("Payment Status", "aistore"); ?></th>
		 	    <th><?php _e("Status", "aistore"); ?></th>
</tr>

    <?php foreach ($results as $row):
        $details_escrow_page_id_url = esc_url($row->url); ?>
 
 
      
    
      <tr>
           
		 
		   
	
	  <td> 	<a href="<?php echo esc_url($details_escrow_page_id_url); ?>" >

		   <?php echo esc_attr($row->id); ?> </a> </td>
  <td> 		   <?php echo esc_attr($row->title); ?> </td>
    <td> 	

  <?php
  if ($row->sender_email == $current_user_email_id) {
      $role = "Sender";
      $email = $row->receiver_email;
  } else {
      $role = "Receiver";
      $email = $row->sender_email;
  }
  echo esc_attr($role);
  ?>
</td>
		   

  <td> 		   <?php echo esc_attr($row->amount) .
      " " .
      esc_attr($row->currency); ?> </td>
		   <td> 		   <?php echo esc_attr($row->sender_email); ?> </td>
		   <td> 		   <?php echo esc_attr($row->receiver_email); ?> </td>
		    <td> 		   <?php echo esc_attr($row->payment_status); ?> </td>
   <td> 		   <?php echo esc_attr($row->status); ?> </td>
            </tr>
    <?php
    endforeach;
} ?>

    </table>
	
	
	
	
	</div>

    <?php
    
    
    do_action("aistore_escrow_list_bottom", $current_user_email_id);

    return ob_get_clean();
    }




































    // Escrow Details
    //  This function is used to escrow deatils page
    public function aistore_escrow_detail()
    {
        ob_start();

        global $saksh;
        $add_escrow_page_id = $saksh["escrow_page"]["add_escrow_page_id"];

        if (!sanitize_text_field($_REQUEST["eid"])) {

            $add_escrow_page_url = esc_url(
                add_query_arg(
                    [
                        "page_id" => $add_escrow_page_id,
                    ],
                    home_url()
                )
            );

            echo $add_escrow_page_url;
            ?>
    
   
<meta http-equiv="refresh" content="0; URL=<?php echo esc_url(
    $add_escrow_page_url
); ?>" /> 
  
 <?php
        }
        global $wpdb;
        $eid = sanitize_text_field($_REQUEST["eid"]);

        do_action("before_aistore_escrow", $eid);

        //    $aistore_escrow_btns = new AistoreEscrowBTN();

        $this->aistore_escrow_btn_actions();

        //    $object_escrow = new AistoreEscrowSystem();

        $escrow_admin_user_id = $this->get_escrow_admin_user_id();

        $user_id = get_current_user_id();

        $email_id = get_the_author_meta("user_email", $user_id);

        $escrow = $this->AistoreEscrowDetail($eid, $email_id);

 


        $user_email = $email_id;
        ?>
<div class='b5'>
	       <div class="alert alert-success" role="alert">
 <strong>  <?php _e("Status ", "aistore"); ?>   <?php echo esc_attr(
       $escrow->status
   ); ?></strong>
  </div>
	  
	  
	    <div class="alert alert-success" role="alert">
 <strong><?php _e("Payment Status ", "aistore"); ?>   <?php echo esc_attr(
       $escrow->payment_status
   ); ?></strong>
  </div>
  
 
  
  
  <?php if ($this->make_payment_btn_visible($escrow, $user_email)) {

      global $saksh;
      $payment_method_list_page_id =
          $saksh["escrow_page"]["payment_method_list_page_id"];

      $payment_method_list_page_id_url = esc_url(
          add_query_arg(
              [
                  "page_id" => $payment_method_list_page_id,
                  "eid" => $eid,
              ],
              home_url()
          )
      );
      ?>

<div>   Don't ship the product.  </div><br>




<a href="<?php echo esc_url(
    $payment_method_list_page_id_url
); ?>"><input  class="button button-primary  btn  btn-primary "  type="submit" name="submit" value="<?php _e(
    "Make Payment",
    "aistore"
); ?>"/></a>



 
  <br>
<?php
  } ?>



  <?php
  echo "<h1>#" .
      esc_attr($escrow->id) .
      " " .
      esc_attr($escrow->title) .
      "</h1><br>";

  printf(__("Sender :  %s", "aistore"), $escrow->sender_email . "<br>");
  printf(__("Receiver : %s", "aistore"), $escrow->receiver_email . "<br>");
  printf(__("Status : %s", "aistore"), $escrow->status . "<br>");
  printf(
      __("Amount : %s", "aistore"),
      $escrow->amount . " " . $escrow->currency . "<br><hr />"
  );

  $this->accept_escrow_btn($escrow, $user_email);
  $this->cancel_escrow_btn($escrow, $user_email);
  $this->release_escrow_btn($escrow, $user_email);
  $this->dispute_escrow_btn($escrow, $user_email);

  echo $this->aistore_escrow_detail_tabs($escrow);

  do_action("after_aistore_escrow", $escrow);

  do_action("aistore_details_bottom_section", $escrow);

  return ob_get_clean();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    //   This function is used to escrow deatils page and create a tabs like Term and Condition
    public function aistore_escrow_detail_tabs($escrow)
    {
        ob_start(); ?>
 




<nav>
  <div class="nav nav-tabs  mb-3" id="nav-tab" role="tablist">
   
   
    
    
    
     <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-term" type="button" role="tab" aria-controls="nav-term" aria-selected="false">Term and Condition</button>
     
     
  
  
     <?php do_action("aistore_escrow_tab_button", $escrow); ?>
     
     
  </div>
  
  
  
</nav>



<div class="tab-content" id="nav-tabContent">
   
  
    <div class="tab-pane fade" id="nav-term" role="tabpanel" aria-labelledby="nav-term-tab">
    
    
    <?php do_action("aistore_escrow_first_tab", $escrow); ?>
    
    
    </div>
  
   
    <?php do_action("aistore_escrow_tab_contents", $escrow); ?>
  
  
</div>


      

  
  <?php return ob_get_clean();
    }
}
