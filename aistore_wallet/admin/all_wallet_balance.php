 <?php

            
  $users = get_users( );
  
  $wallet = new AistoreWallet();
  
  
//print_r($users);
        if ($users === null)
        {
           // _e("No User Found", 'aistore');

        }
        else
        {
            
            
?>
    <h1> <?php _e('User List', 'aistore') ?> </h1>
    
     <?php echo AistoregetSupportMsg(); ?>
     
<table id="example"  class="widefat striped fixed"   >
    
    
        <thead>
            <tr>
                   <th><?php _e('ID', 'aistore'); ?></th>
        <th><?php _e('Username', 'aistore'); ?></th>
		    <th><?php _e('Email', 'aistore'); ?></th>
          <th><?php _e('Balance', 'aistore'); ?></th> 
		  
	  
            </tr>
            
        </thead>
        
        <tbody>
            <?php
            
  
             foreach ($users as $row):
               //  print_r($users);
               
               $currencies = $wallet->aistore_wallet_currency();
    
            foreach ($currencies as $c)
            {
     $currency=$c->currency;
 
    
            
  $balance = $wallet->aistore_balance($row->ID, $currency);
  
  if($balance>0){
?>
            <tr>
            	   <td>  <?php echo esc_attr($row->ID); ?></td>
		  		   <td> 		   <?php echo esc_attr($row->user_login); ?> </td>
		  
		   
		   <td> 		   <?php echo esc_attr($row->user_email); ?> </td>
		  
		   <td> 		   <?php echo esc_attr($balance  ." ".$currency ); ?> </td>
		   
		 
		   </tr>
		   <?php
  }
  }
  
        
            endforeach;
        ?>
    
        </tbody>
        
      
        
        <tfoot>
            <tr>
         <th><?php _e('ID', 'aistore'); ?></th>
        <th><?php _e('Username', 'aistore'); ?></th>
		    <th><?php _e('Email', 'aistore'); ?></th>
          <th><?php _e('Balance', 'aistore'); ?></th> 
            </tr>
        </tfoot>
    </table>
      <?php } 
      
     