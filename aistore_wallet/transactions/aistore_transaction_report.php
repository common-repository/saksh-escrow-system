<?php
 add_filter( 'after_aistore_escrow_transaction', 'aistore_transaction_report' );
   /**
       * 
       * This function is used to transactions admin report
       * Id
       * Email
       * Balance
       * Amount
       * Type
       * Description
       * Date
     
       * 
       */ 
     function  aistore_transaction_report($escrow){
         
  

	global $wpdb;
  $user_id = get_current_user_id();
           	$eid=$escrow->id;
           	
           	        // $escrow_admin_user_id = get_option('escrow_user_id');
           	        
           	        if(aistore_isadmin())
           	        {
     	$sql = "SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions  t  INNER JOIN {$wpdb->prefix}users u ON  t.user_id=u.ID WHERE t.reference=".$eid. "     ORDER BY transaction_id desc";
     	
           	        }
           	        else
           	        {
           	            
           	            	$sql = "SELECT * FROM {$wpdb->prefix}aistore_wallet_transactions  t  INNER JOIN {$wpdb->prefix}users u ON  t.user_id=u.ID WHERE t.reference=".$eid. "  and t.user_id= $user_id  ORDER BY transaction_id desc";
           	        }
 
     	
     	 $results = $wpdb->get_results($sql);
           ?>
       <h1> <?php _e('Transaction Report', 'aistore') ?> </h1>
   
    
    

            <?php
            
  
        if ($results == null)
        {
            _e("No transactions Found", 'aistore');

        }
        else
        {
            ?>
            
<table id="example" class="widefat striped fixed" >
        <thead>
            <tr>
                   <th><?php _e('ID', 'aistore'); ?></th>
      
		    <th><?php _e('Email', 'aistore'); ?></th>
          <th><?php _e('Balance', 'aistore'); ?></th> 
		  
	    <th><?php _e('Amount', 'aistore'); ?></th> 
	    <th><?php _e('Type', 'aistore'); ?></th> 
	    <th><?php _e('Description', 'aistore'); ?></th> 
	      <th><?php _e('Date', 'aistore'); ?></th> 
            </tr>
            
        </thead>
        
        <tbody>
            <?php
             foreach ($results as $row):
             
?>
            <tr>
            	   <td>  <?php echo esc_attr($row->transaction_id); ?></td>
	
		  
		   
		   <td> 		   <?php echo esc_attr($row->user_email); ?> </td>
		  
		   <td> 		   <?php echo esc_attr($row->balance); ?> </td>
		   
		   <td> 		   <?php echo esc_attr($row->amount." ".$row->currency); ?> </td>
		   
		  <td> 		   <?php echo esc_attr($row->type); ?> </td>
		  
		   <td> 		   <?php echo esc_attr($row->description); ?> </td>
		   
		   	   <td> 		   <?php echo esc_attr($row->date); ?> </td>
		   </tr>
		   <?php
            endforeach;
        ?>
    
        </tbody>
        
 
    </table>
    
    
        <?php 
        
        
        }
    
     
     }  