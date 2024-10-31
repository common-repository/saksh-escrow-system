<?php
 
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
} 


 

add_action( 'admin_menu', 'register_my_custom_menu_page' );

  
     /**
       * This function is used to Wallet register menu page
       * 'Wallet Account
       * Currency
       * All Wallet Balance
      */

function register_my_custom_menu_page() {
  
  
 add_menu_page( 'Wallet Account', 'Wallet Account', 'manage_options', 'aistore_debit_credit');

    
 add_submenu_page( 'aistore_debit_credit'  , 'Wallet Account', 'Debit/Credit', 'manage_options', 'aistore_debit_credit', 'aistore_debit_credit',  90 );

    
  add_submenu_page( 'aistore_debit_credit'  ,     'Wallet Account', 'Currency Setting', 'manage_options', 'currency_setting', 'currency_setting',  90 );
  
     
 add_submenu_page( 'aistore_debit_credit'  , 'Wallet Account', 'All Wallet Balance', 'manage_options', 'balance_list', 'balance_list',  90 );



    
}

function aistore_debit_credit(){
    
    
/**
       * This function is used to Wallet debit credit section
       * 'Users: 	
       * Account Type: 	
       * Currency: 	
       * Amount: 	
       * Description:
      */

    include dirname(__FILE__) . "/admin/debit_credit.php";

}

function currency_setting(){
    
    /**
       * This function is used to Wallet currency setting section
       * 'Add a currency : 	
       * Currency List: 	
       * Delete Currency: 	
     
      */

    include_once dirname(__FILE__) . '/admin/currency_setting.php';
}

function balance_list(){
    
    /**
       * This function is used to Wallet all wallet balance section
       * ID 
       * Username
       * Email: 	
       * Balance: 	
       * All user balance list and show user amount is greater than zero
      */


 include_once dirname(__FILE__) . '/admin/all_wallet_balance.php';


}




