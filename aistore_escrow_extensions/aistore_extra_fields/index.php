<?php
/*
Plugin Name: Saksh Escrow extrafields
Version:  2.1
Stable tag: 2.1
Plugin URI: #
Author: susheelhbti
Author URI: #
Description: Saksh Escrow System is a plateform allow parties to complete safe payments.  


*/

 
add_filter("saksh_escrow_tables", "saksh_escrow_escrow_extrafields_table");

function saksh_escrow_escrow_extrafields_table($saksh_escrow_tables)
{
    global $wpdb;

    $table_escrow =
        "CREATE TABLE   IF NOT EXISTS  " .
        $wpdb->prefix .
        "escrow_extrafields (
  id int(100) NOT NULL  AUTO_INCREMENT,
  eid  int(100) NOT NULL,
  metafield  JSON  NOT NULL ,
  PRIMARY KEY (id)
)  ";

    $saksh_escrow_tables[] = $table_escrow;

    return $saksh_escrow_tables;
}







 