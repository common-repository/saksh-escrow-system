<?php


 
   //  aistore_escrow_tab_button
     
     add_action('aistore_escrow_tab_button', 'aistore_escrow_transactions_tab_button' ); 
     
     
       
      /**
       * This function is used to transaction tabs button
      
       
     
      */
     function aistore_escrow_transactions_tab_button($escrow)
{
   
    ?>
      <button class="nav-link" id="nav-transactions-tab" data-bs-toggle="tab" data-bs-target="#nav-transactions" type="button" role="tab" aria-controls="nav-transactions" aria-selected="false">   Transactions</button>
      
      <?php
      
      
}




    add_action('aistore_escrow_tab_contents', 'aistore_escrow_transactions_tab_contents' ); 
     
      /**
       * 
       * This function is used to transactions escrow admin tab contents 
       * Create an admin transactions escrow report contents
      
       * 
       */ 
     function aistore_escrow_transactions_tab_contents($escrow)
{
   
    
    
    ?> 
     
   <div class="tab-pane fade show active" id="nav-transactions" role="tabpanel" aria-labelledby="nav-transactions-tab">
         
 <?php  //aistore_transaction_report($escrow); ?>
 
 
  </div>
      
      <?php
      
       
}




