<?php


/*
Plugin Name: Saksh Sell Crypto extension
Version:  2.2
Stable tag: 2.2
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Saksh Sell Crypto extension allow to sell bitcoin with escrow payment.  
 
*/




add_filter("saksh_escrow_settings", "saksh_sell_crypto_extension_form");

function saksh_sell_crypto_extension_form($saksh_fields)
{
    $fields = [];

    $page = [
        "post_title" => "Sell bitcoin now",
        "post_content" => "[sell_bitcoin_escrow_form]",
    ];

    $fields[] = [
        "name" => "Sell bitcoin now form",
        "label" => "sell_bitcoin_escrow_form",
        "type" => "pages",
        "required" => true,

        "default" => $page,

        "description" => "",
    ];

    $fields[] = [
        "name" => "crypto_selling_charges",
        "label" => "crypto_selling_charges",
        "type" => "string",
        "default" => "5",
        "required" => true,

        "description" => "crypto_selling_charges which we take from the user when he purchase",
    ];

    $saksh_fields["saksh_sell_crypto"] = $fields;

    return $saksh_fields;
}

 

add_shortcode("sell_bitcoin_escrow_form", "sell_bitcoin_escrow_form");

 function sell_bitcoin_escrow_form()
 {
     
     $Saksh_crypto_sell=new Saksh_crypto_sell();
     return $Saksh_crypto_sell->sell_bitcoin_escrow_form();
     
 }

 

include_once dirname(__FILE__) . "/Saksh_crypto_sell.class.php";
 
 
