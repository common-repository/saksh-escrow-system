<?php
/*
Plugin Name: Saksh Escrow File upload option
Version:  2.1
Stable tag: 2.1
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Saksh Escrow System is a plateform allow parties to complete safe payments.  


*/

 
add_filter("saksh_escrow_tables", "saksh_escrow_tables_file_uploads");

function saksh_escrow_tables_file_uploads($saksh_escrow_tables)
{
    global $wpdb;

    $table_escrow =
        "CREATE TABLE   IF NOT EXISTS  " .
        $wpdb->prefix .
        "escrow_documents (
  id int(100) NOT NULL  AUTO_INCREMENT,
  eid  int(100) NOT NULL,
  documents  varchar(100)  NOT NULL,
   ipaddress varchar(100)   NOT NULL,
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
   user_id  int(100) NOT NULL,
  documents_name  varchar(100)  DEFAULT NULL,
  PRIMARY KEY (id)
)  ";

    $saksh_escrow_tables[] = $table_escrow;

    return $saksh_escrow_tables;
}

add_filter("saksh_escrow_settings", "saksh_file_setting_form");

function saksh_file_setting_form($saksh_fields)
{
    $fields = [];

    $fields[] = [
        "name" => "escrow_file_type",
        "label" => "escrow_file_type",
        "type" => "select",
        "options" => ["pdf", "ppt", "doc"],
        "default" => "pdf",

        "required" => true,

        "description" => "",
    ];

    $saksh_fields["FileUpload"] = $fields;

    return $saksh_fields;
}
register_activation_hook(__FILE__, "aistore_file_upload_plugin_table_install");

/**
 *
 * This function is used to create file upload documents table
 * @params eid
 * @params documents
 * @params ipaddress
 * @params created_at
 * @params user_id
 * @params documents_name
 *
 */

function aistore_file_upload_plugin_table_install()
{
    global $wpdb;

    $table_escrow_documents =
        "CREATE TABLE   IF NOT EXISTS  " .
        $wpdb->prefix .
        "escrow_documents (
  id int(100) NOT NULL  AUTO_INCREMENT,
  eid  int(100) NOT NULL,
  documents  varchar(100)  NOT NULL,
   ipaddress varchar(100)   NOT NULL,
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
   user_id  int(100) NOT NULL,
  documents_name  varchar(100)  DEFAULT NULL,
  PRIMARY KEY (id)
)  ";

    require_once ABSPATH . "wp-admin/includes/upgrade.php";
    dbDelta($table_escrow_documents);
}

include "aistore_escrow_file_upload.php";

add_filter("aistore_escrow_extension", "AFU_extension_function");

add_filter("saksh_escrow_setting_form", "aistore_file_upload_setting_form");

function aistore_file_upload_setting_form($fields)
{
    $saksh = get_option("aistore_escrow_payment_optons");

    $fields[] = [
        "name" => "escrow_file_type",
        "label" => "escrow_file_type",
        "type" => "select",
        "options" => ["ppt", "pdf", "png"],

        "required" => true,
        "group" => "file_upload",
        "value" => aistore_checkvalue($saksh["escrow_file_type"]),

        "description" => "Python Software Foundation License",
    ];
    return $fields;
}

add_filter("saksh_escrow_reports", "saksh_file_uploads_reports");

function saksh_file_uploads_reports($saksh_reports_data)
{
    global $wpdb;

    $sql = "SELECT * FROM {$wpdb->prefix}escrow_documents      order by id desc limit 5 ";

    $results = $wpdb->get_results($sql);

    $saksh_reports_data["file_uploads"] = $results;

    return $saksh_reports_data;
}
