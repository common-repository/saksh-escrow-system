<?php

add_filter("saksh_escrow_settings", "saksh_withdraw_setting_form");

function saksh_withdraw_setting_form($saksh_fields)
{
    $fields = [];

    $page = [
        "post_title" => "withdrawal system",
        "post_content" => "[aistore_saksh_withdrawal_system]",
    ];

    $fields[] = [
        "name" => "aistore_saksh_withdrawal_system",
        "label" => "aistore_saksh_withdrawal_system",
        "type" => "pages",
        "required" => true,

        "default" => $page,

        "description" => "",
    ];

    $fields[] = [
        "name" => "withdraw_fee",
        "label" => "withdraw_fee",
        "type" => "string",
        "default" => "5",
        "required" => true,

        "description" => "",
    ];

    $saksh_fields["Withdraw"] = $fields;

    return $saksh_fields;
}

add_filter("saksh_escrow_tables", "saksh_escrow_tables_widthdraws");

function saksh_escrow_tables_widthdraws($saksh_escrow_tables)
{
    global $wpdb;

    $table_withdrawal_requests =
        "CREATE TABLE   IF NOT EXISTS  " .
        $wpdb->prefix .
        "widthdrawal_requests  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  amount double NOT NULL,
 
   method  varchar(100)   NOT NULL,   charges  varchar(100)   NOT NULL,
   username  varchar(100)   NOT NULL,
   currency  varchar(100)   NOT NULL,
  status  varchar(100)   NOT NULL DEFAULT 'pending',
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

    $saksh_escrow_tables[] = $table_withdrawal_requests;

    return $saksh_escrow_tables;
}

add_shortcode("aistore_bank_account", [
    "Aistore_WithdrawalSystem",
    "aistore_bank_account",
]);

add_shortcode("aistore_saksh_withdrawal_system", [
    "Aistore_WithdrawalSystem",
    "aistore_saksh_withdrawal_system",
]);

include_once dirname(__FILE__) . "/Aistore_WithdrawalSystem.class.php";

add_filter("saksh_escrow_setting_form", "aistore_withdraw_setting_form");

function aistore_withdraw_setting_form($fields)
{
    $saksh = get_option("aistore_escrow_payment_optons");

    $fields[] = [
        "name" => "withdraw_fee",
        "label" => "withdraw_fee",
        "type" => "string",

        "required" => true,
        "group" => "withdraw",
        "value" => aistore_checkvalue($saksh["withdraw_fee"]),

        "description" => "",
    ];
    return $fields;
}

add_filter("saksh_escrow_reports", "saksh_withdraw_reports");

function saksh_withdraw_reports($saksh_reports_data)
{
    global $wpdb;

    $sql = "SELECT * FROM {$wpdb->prefix}widthdrawal_requests      order by id desc limit 20 ";

    $results = $wpdb->get_results($sql);

    $saksh_reports_data["widthdrawal_requests"] = $results;

    return $saksh_reports_data;
}
