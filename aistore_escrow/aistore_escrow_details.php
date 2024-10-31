<?php

add_action( 'admin_menu', 'aistore_escrow_details_menuq' );


function aistore_escrow_details_menuq() {
    
    


  add_menu_page( 'Saksh Escrow', 'Saksh Escrow', 'manage_options',  'aistore_escrow_details',   'aistore_escrow_details'  );
  
 
  
	
  
	
	
	
  
  remove_menu_page('aistore_escrow_details');
  
  
    
}
function aistore_escrow_details()
{
       

 
 
        $object_escrow = new AistoreEscrowSystemAdmin();
        
         
      
        
     echo  $object_escrow->aistore_admin_escrow_detail( );
      
       
 
}

?>