<?php
/*
Plugin Name: Saksh Escrow Notification System
Version:  2.1
Stable tag: 2.1
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Saksh Escrow System is a plateform allow parties to complete safe payments.  


*/

if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

add_filter("saksh_escrow_reports", "saksh_notification_reports");

function saksh_notification_reports($saksh_reports_data)
{
    global $wpdb;

    $sql = "SELECT * FROM {$wpdb->prefix}escrow_notification      order by id desc limit 5 ";

    $results = $wpdb->get_results($sql);

    $saksh_reports_data["notification"] = $results;

    return $saksh_reports_data;
}

add_filter("saksh_escrow_settings", "saksh_notification_setting_form");

function saksh_notification_setting_form($saksh_fields)
{
    $fields = [];

    $page = [
        "post_title" => "Saksh Escrow System notification delivery log",
        "post_content" => "[aistore_notification]",
    ];

    $fields[] = [
        "name" => "notification_page",
        "label" => "notification_page",
        "type" => "pages",
        "required" => true,
        "default" => $page,

        "description" => "",
    ];

    $fields[] = [
        "name" => "created_escrow",
        "label" => "created_escrow",
        "type" => "string",
        "default" => "You have successfully created the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "partner_created_escrow",
        "label" => "partner_created_escrow",
        "type" => "string",
        "default" =>
            "Your partner have successfully created the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "accept_escrow",
        "label" => "accept_escrow",
        "type" => "string",
        "default" => "You have successfully  accepted the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "partner_accept_escrow",
        "label" => "partner_accept_escrow",
        "type" => "string",
        "default" =>
            "Your partner have successfully accepted the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "dispute_escrow",
        "label" => "dispute_escrow",
        "type" => "string",
        "default" => "You have successfully  disputed the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "partner_dispute_escrow",
        "label" => "partner_dispute_escrow",
        "type" => "string",
        "default" =>
            "Your partner have successfully disputed the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "release_escrow",
        "label" => "release_escrow",
        "type" => "string",
        "default" => "You have successfully  released the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "partner_release_escrow",
        "label" => "partner_release_escrow",
        "type" => "string",
        "default" =>
            "Your partner have successfully released the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "cancel_escrow",
        "label" => "cancel_escrow",
        "type" => "string",
        "default" => "You have successfully  cancelled the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "partner_cancel_escrow",
        "label" => "partner_cancel_escrow",
        "type" => "string",
        "default" =>
            "Your partner have successfully cancelled the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "shipping_escrow",
        "label" => "shipping_escrow",
        "type" => "string",
        "default" =>
            "you have updated the shipping details for the escrow# [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "partner_shipping_escrow",
        "label" => "partner_shipping_escrow",
        "type" => "string",
        "default" =>
            "Your partner has updated the shipping details for the escrow# [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "buyer_deposit",
        "label" => "buyer_deposit",
        "type" => "string",
        "default" => "Your payment  has been accepted for the escrow  # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "seller_deposit",
        "label" => "seller_deposit",
        "type" => "string",
        "default" =>
            "You have deposited the payment into  the escrow for  the transaction  escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "buyer_mark_paid",
        "label" => "buyer_mark_paid",
        "type" => "string",
        "default" => "You have successfully  marked escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "payment_refund",
        "label" => "payment_refund",
        "type" => "string",
        "default" =>
            "Payment for the escrow #[EID] has been  refunded/cancelled/denied by admin",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "payment_accepted",
        "label" => "payment_accepted",
        "type" => "string",
        "default" => "Payment for the escrow #[EID] has been approved by admin",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "admin_remove_payment_message",
        "label" => "admin_remove_payment_message",
        "type" => "string",
        "default" => "Payment for the escrow #[EID] has been removed by admin",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "admin_reject_payment_message",
        "label" => "admin_reject_payment_message",
        "type" => "string",
        "default" => "Payment for the escrow #[EID] has been rejected by admin",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "admin_accept_payment_message",
        "label" => "admin_accept_payment_message",
        "type" => "string",
        "default" => "Payment for the escrow #[EID] has been accepted by admin",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "escrow_fee_debit_by_admin_message",
        "label" => "escrow_fee_debit_by_admin_message",
        "type" => "string",
        "default" => "Fee for the escrow #[EID] has been debited by admin",
        "required" => true,

        "description" => "",
    ];

    $saksh_fields["notification"] = $fields;

    return $saksh_fields;
}

add_filter("saksh_escrow_tables", "saksh_escrow_tables_notifications");

function saksh_escrow_tables_notifications($saksh_escrow_tables)
{
    global $wpdb;

    $table_escrow_notification =
        "CREATE TABLE  IF NOT EXISTS  " .
        $wpdb->prefix .
        "escrow_notification  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  type varchar(100) NOT NULL,
   message  text  NOT NULL,
   user_email  varchar(100)   NOT NULL,
  url varchar(100)   NOT NULL,
  reference_id bigint(20)   NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

    $saksh_escrow_tables[] = $table_escrow_notification;

    return $saksh_escrow_tables;
}

add_action(
    "AistoreEscrow_Install",
    "aistore_notification_escrow_plugin_table_install"
);

/**
 *
 * This function is used to create escrow notification table
 * @params id
 * @params type
 * @params message
 * @params user_email
 * @params url
 * @params reference_id
 * @params created_at
 *
 */

function aistore_notification_escrow_plugin_table_install()
{
    //  aistore_notification_escrow_message();

    global $wpdb;

    $table_escrow_notification =
        "CREATE TABLE  IF NOT EXISTS  " .
        $wpdb->prefix .
        "escrow_notification  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  type varchar(100) NOT NULL,
   message  text  NOT NULL,
   user_email  varchar(100)   NOT NULL,
  url varchar(100)   NOT NULL,
  reference_id bigint(20)   NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";

    require_once ABSPATH . "wp-admin/includes/upgrade.php";

    dbDelta($table_escrow_notification);
}

register_activation_hook(
    __FILE__,
    "aistore_escrow_plugin_notification_table_install"
);

include_once dirname(__FILE__) . "/escrow_details_notification.php";

include_once dirname(__FILE__) . "/user_notification.php";

include_once dirname(__FILE__) . "/sendnotification.php";

include_once dirname(__FILE__) . "/notification_api.php";
