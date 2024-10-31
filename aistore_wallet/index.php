<?php
/*
Plugin Name: Saksh Wallet System
Version:  2.1
Stable tag: 2.1
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Saksh Escrow System is a plateform allow parties to complete safe payments.  


*/

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}




add_filter( 'saksh_escrow_tables', 'saksh_escrow_tables_wallet' );
     
function saksh_escrow_tables_wallet( $saksh_escrow_tables  )
{
       
 global $wpdb;


       
  $table_aistore_wallet_transactions = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "aistore_wallet_transactions  (
   	transaction_id  bigint(20)  NOT NULL  AUTO_INCREMENT,
  user_id bigint(20)  NOT NULL,
   reference bigint(20)   NULL,
   type   varchar(100)  NOT NULL,
   amount  double    NOT NULL,
  balance  double    NOT NULL,
    description  text  NOT NULL,
   currency  varchar(100)   NOT NULL,
   created_by  	bigint(20) NOT NULL,
   date  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (transaction_id)
) ";

 $saksh_escrow_tables[]=$table_aistore_wallet_transactions;
   
 
    
    $table_aistore_wallet_balance = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "aistore_wallet_balance  (
     	id  bigint(20)  NOT NULL  AUTO_INCREMENT,
   	transaction_id  bigint(20)  NOT NULL,
  user_id bigint(20)  NOT NULL,
  balance  double    NOT NULL,
   currency  varchar(100)   NOT NULL,
   created_by  	bigint(20) NOT NULL,
   date  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

 $saksh_escrow_tables[]=$table_aistore_wallet_balance;
    
 
  $table_escrow_currency = "CREATE TABLE  IF NOT EXISTS  " . $wpdb->prefix . "escrow_currency  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  currency varchar(100) NOT NULL,
   symbol  varchar(100)   NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

    
 $saksh_escrow_tables[]=$table_escrow_currency;
 
 
 
  $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_currency ( currency, symbol  ) VALUES (  'USD' ,'USD')" ));
  
  
            
            
 
 
  return $saksh_escrow_tables;
  
  
}




register_activation_hook(__FILE__, 'aistore_wallet_plugin_table_install');



       
function aistore_wallet_install()
{
    global  $wpdb;
      $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}escrow_currency ( currency, symbol  ) VALUES (  'USD' ,'USD')" ));
  
    
}


add_action("AistoreEscrow_Install", "aistore_wallet_install",10,3);




       /**
       * 
       * This function is used to create wallet table
       * aistore_wallet_transactions
       * aistore_wallet_balance
       * escrow_currency
     
       * 
       */ 
       
function aistore_wallet_plugin_table_install()
{
    global $wpdb;


       /**
       * 
       * Wallet table name - aistore_wallet_transactions
       * @params transaction_id
       * @params user_id
       * @params reference
       * @params type
       * @params amount
       * @params balance
       * @params description
       * @params currency
       * @params created_at
       * 
       */ 
       
 

    /**
       * 
       * Wallet table name - aistore_wallet_balance
       * @params transaction_id
       * @params user_id
       * @params balance
       * @params currency
       * @params created_at
       * 
       */ 


   
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($table_aistore_wallet_transactions);

    dbDelta($table_aistore_wallet_balance);
    
  
    
    dbDelta($table_escrow_currency);


}


 include_once dirname(__FILE__) . '/transactions/aistore_transaction_report.php';

include_once dirname(__FILE__) . '/admin/user_transaction_list.php';
//include_once dirname(__FILE__) . '/admin/transaction_list.php';
include_once dirname(__FILE__) . '/admin/user_balance.php';
include_once dirname(__FILE__) . '/AistoreWallet.class.php';
//  include_once dirname(__FILE__) . '/Aistore_WithdrawalSystem.class.php';
//  include_once dirname(__FILE__) . '/Widthdrawal_requests.php';
 include_once dirname(__FILE__) . '/user_bank_details.php';
 include_once dirname(__FILE__) . '/menu.php';


add_shortcode('aistore_transaction_history', array(
    'AistoreWallet',
    'aistore_transaction_history'
));






    
     add_action('aistore_escrow_tab_button', 'aistore_escrow_transactions_tab_button' ); 
     
      /**
       * 
       * This function is used to transactions escrow admin tab button 
      
       * 
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
       * Create an admin transactions escrow report
      
       * 
       */ 
     function aistore_escrow_transactions_tab_contents($escrow)
{
   
    
    
    ?> 
     
   <div class="tab-pane fade show active" id="nav-transactions" role="tabpanel" aria-labelledby="nav-transactions-tab">
         
 <?php  aistore_transaction_report($escrow); ?>
 
 
  </div>
      
      <?php
      
       
}






add_filter( 'saksh_escrow_setting_form', 'saksh_wallet_setting_form' );
     
function saksh_wallet_setting_form( $fields  )
{
      
    $saksh = get_option('aistore_escrow_payment_optons');
    
   

        $fields[] = array(
    "name" => "transaction_history_page_id", 
     "label" => "transaction_history_page_id", 
    "type" => "pages", 
    "required" =>true,
        "group" => "wallet",
    "value" =>aistore_checkvalue($saksh['transaction_history_page_id'])  ,
    "description" =>   " "
    
);

 
  return $fields;
}








