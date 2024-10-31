<?php

add_action("aistore_escrow_tab_button", "aistore_escrow_emails_tab_button");

// This function is used to escrow emails tab button

function aistore_escrow_emails_tab_button($escrow)
{
    ?>
      <button class="nav-link" id="nav-emails-tab" data-bs-toggle="tab" data-bs-target="#nav-emails" type="button" role="tab" aria-controls="nav-emails" aria-selected="false">   Emails</button>
      
      <?php
}

add_action("aistore_escrow_tab_contents", "aistore_escrow_emails_tab_contents");

function aistore_escrow_emails_tab_contents($escrow)
{
    ?> 
     
   <div class="tab-pane fade    " id="nav-emails" role="tabpanel" aria-labelledby="nav-emails-tab">
         
 <?php aistore_email_report($escrow); ?>
 
 
  </div>
      
      <?php
}

function aistore_email_report($escrow)
{
    ?>
   
           <h1> <?php _e("System Escrow Email", "aistore"); ?> </h1>  <br>
  <?php
  $eid = $escrow->id;
  global $wpdb;

  $sql =
      "SELECT * FROM {$wpdb->prefix}escrow_email WHERE   reference_id=" .
      $eid .
      " order by id desc ";

  $results = $wpdb->get_results($sql);
  if ($results == null) {
      _e("No Email Found", "aistore");
  } else {
       ?>
         <div class="accordion" id="accordionExample">
         
     <?php foreach ($results as $row): ?> 

  <div class="accordion-item">
    <h2 class="accordion-header" id="heading<?php echo esc_attr($row->id); ?>">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo esc_attr(
          $row->id
      ); ?>" aria-expanded="true" aria-controls="collapseOne">
         <?php echo esc_attr($row->user_email) .
             " --- " .
             esc_attr($row->created_at) .
             "     --- " .
             esc_attr($row->subject); ?>
      </button>
    </h2>
    <div id="collapse<?php echo esc_attr(
        $row->id
    ); ?>" class="accordion-collapse collapse " aria-labelledby="heading<?php echo esc_attr(
    $row->id
); ?>" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>Subject:  <?php echo esc_attr(
            $row->subject
        ); ?></strong> <br>Message: <?php echo html_entity_decode(
    $row->message
); ?><br><code><?php echo esc_attr($row->created_at); ?></code>
      </div>
    </div>
  </div>
  

    <?php endforeach; ?>
    
     </div>
        
        <?php
  }
}

add_shortcode("saksh_system_emails", "aistore_users_email_report");

function aistore_users_email_report()
{   ob_start();

  
  global $wpdb;

  $user_id = get_current_user_id();
  $email = get_the_author_meta("user_email", $user_id);

  $sql =
      "SELECT * FROM {$wpdb->prefix}escrow_email WHERE  user_email  ='" .
      $email ."' order by id desc ";

//echo     $sql ;
    
    
    $results = $wpdb->get_results($sql);
  
  if ($results == null) {
      _e("No Email Found", "aistore");
  } else {
       ?>
         <div class="accordion" id="accordionExample">
         
     <?php foreach ($results as $row): ?> 

  <div class="accordion-item">
    <h2 class="accordion-header" id="heading<?php echo esc_attr($row->id); ?>">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo esc_attr(
          $row->id
      ); ?>" aria-expanded="true" aria-controls="collapseOne">
         <?php echo esc_attr($row->user_email) .
             " --- " .
             esc_attr($row->created_at) .
             "     --- " .
             esc_attr($row->subject); ?>
      </button>
    </h2>
    <div id="collapse<?php echo esc_attr(
        $row->id
    ); ?>" class="accordion-collapse collapse " aria-labelledby="heading<?php echo esc_attr(
    $row->id
); ?>" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>Subject:  <?php echo esc_attr(
            $row->subject
        ); ?></strong> <br>Message: <?php echo html_entity_decode(
    $row->message
); ?><br><code><?php echo esc_attr($row->created_at); ?></code>
      </div>
    </div>
  </div>
  

    <?php endforeach; ?>
    
     </div>
        
        <?php
  }
  
  
   return ob_get_clean();
   
   
}
