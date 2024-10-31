<?php

if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

add_filter("saksh_escrow_tables", "saksh_escrow_tables_email");

function saksh_escrow_tables_email($saksh_escrow_tables)
{
    global $wpdb;

    $table_escrow_email =
        "CREATE TABLE  IF NOT EXISTS  " .
        $wpdb->prefix .
        "escrow_email  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  type varchar(100) NOT NULL,
   message  text  NOT NULL,
   user_email  varchar(100)   NOT NULL,
    partyr_email  varchar(100)   NOT NULL,
  url varchar(100)   NOT NULL,
  party_email varchar(100)   NOT NULL,
  
   reference_id bigint(20)   NULL,
   subject varchar(100)  NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

    $saksh_escrow_tables[] = $table_escrow_email;

    return $saksh_escrow_tables;
}
/*
add_action("AistoreEscrow_Install", "aistore_email_plugin_table_install");

//   This function is used to create email message
function aistore_email_plugin_table_install()
{
    //   aistore_email_message();
    global $wpdb;

    $table_escrow_email =
        "CREATE TABLE  IF NOT EXISTS  " .
        $wpdb->prefix .
        "escrow_email  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  type varchar(100) NOT NULL,
   message  text  NOT NULL,
   user_email  varchar(100)   NOT NULL,
    partyr_email  varchar(100)   NOT NULL,
  url varchar(100)   NOT NULL,
   reference_id bigint(20)   NULL,
   subject varchar(100)  NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

    require_once ABSPATH . "wp-admin/includes/upgrade.php";

    dbDelta($table_escrow_email);
}

register_activation_hook(__FILE__, "aistore_email_plugin_table_install");
*/