<?php

add_action(
    "aistore_escrow_tab_button",
    "aistore_escrow_notifications_tab_button"
);

// This function is used to escrow emails tab button

function aistore_escrow_notifications_tab_button($escrow)
{
    ?>
  
      
      
      
      <button class="nav-link" id="nav-notifications-tab" data-bs-toggle="tab" data-bs-target="#nav-notifications" type="button" role="tab" aria-controls="nav-notifications" aria-selected="false">   Notification</button>
      
      
      <?php
}

add_action(
    "aistore_escrow_tab_contents",
    "aistore_escrow_notifications_tab_contents"
);

function aistore_escrow_notifications_tab_contents($escrow)
{
    ?> 
     
   <div class="tab-pane fade    " id="nav-notifications" role="tabpanel" aria-labelledby="nav-notifications-tab">
          
 <?php aistore_notification_report($escrow); ?>
 
 
  </div>
      
      <?php
}
