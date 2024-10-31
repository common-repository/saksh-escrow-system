<?php
/*
Plugin Name: Saksh Escrow Email System
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

add_filter("saksh_escrow_reports", "saksh_email_reports");

function saksh_email_reports($saksh_reports_data)
{
    global $wpdb;


    $sql = "SELECT id, user_email , url, subject , reference_id ,created_at   FROM {$wpdb->prefix}escrow_email      order by id desc limit 50";

    $results = $wpdb->get_results($sql);

    $saksh_reports_data["email"] = $results;

    return $saksh_reports_data;
}

add_filter("saksh_escrow_settings", "saksh_email_setting_form");

function saksh_email_setting_form($saksh_fields)
{
    $fields = [];

    $page = [
        "post_title" => "Saksh Escrow System Email delivery log",
        "post_content" => "[saksh_system_emails]",
    ];

    $fields[] = [
        "name" => "email_page",
        "label" => "email_page",
        "type" => "pages",
        "required" => true,

        "default" => $page,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_created_escrow",
        "label" => "email_created_escrow",
        "type" => "wp_editor",
        "default" => "You have successfully created the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_partner_created_escrow",
        "label" => "email_partner_created_escrow",
        "type" => "wp_editor",
        "default" => "You have successfully created the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_accept_escrow",
        "label" => "email_accept_escrow",
        "type" => "wp_editor",
        "default" => "You have successfully  accepted the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_partner_accept_escrow",
        "label" => "email_partner_accept_escrow",
        "type" => "wp_editor",
        "default" =>
            "Your partner have successfully accepted the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_dispute_escrow",
        "label" => "email_dispute_escrow",
        "type" => "wp_editor",
        "default" => "You have successfully  disputed the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_partner_dispute_escrow",
        "label" => "email_partner_dispute_escrow",
        "type" => "wp_editor",
        "default" =>
            "Your partner have successfully disputed the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_release_escrow",
        "label" => "email_release_escrow",
        "type" => "wp_editor",
        "default" => "You have successfully  released the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_partner_release_escrow",
        "label" => "email_partner_release_escrow",
        "type" => "wp_editor",
        "default" =>
            "Your partner have successfully released the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_cancel_escrow",
        "label" => "email_cancel_escrow",
        "type" => "wp_editor",
        "default" => "You have successfully  cancelled the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_partner_cancel_escrow",
        "label" => "email_partner_cancel_escrow",
        "type" => "wp_editor",
        "default" =>
            "Your partner have successfully cancelled the escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_shipping_escrow",
        "label" => "email_shipping_escrow",
        "type" => "wp_editor",
        "default" =>
            "you have updated the shipping details for the escrow# [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_partner_shipping_escrow",
        "label" => "email_partner_shipping_escrow",
        "type" => "wp_editor",
        "default" =>
            "Your partner has updated the shipping details for the escrow# [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_buyer_deposit",
        "label" => "email_buyer_deposit",
        "type" => "wp_editor",
        "default" => "Your payment  has been accepted for the escrow  # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_seller_deposit",
        "label" => "email_seller_deposit",
        "type" => "wp_editor",
        "default" =>
            "You have deposited the payment into  the escrow for  the transaction  escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_Buyer_Mark_Paid",
        "label" => "email_Buyer_Mark_Paid",
        "type" => "wp_editor",
        "default" => "You have successfully  marked escrow # [EID]",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_payment_refund",
        "label" => "email_payment_refund",
        "type" => "wp_editor",
        "default" =>
            "Payment for the escrow #[EID] has been  refunded/cancelled/denied by admin",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_payment_accepted",
        "label" => "email_payment_accepted",
        "type" => "wp_editor",
        "default" => "Payment for the escrow #[EID] has been approved by admin",
        "required" => true,

        "description" => "",
    ];
    //body

    $fields[] = [
        "name" => "email_body_created_escrow",
        "label" => "email_body_created_escrow",
        "type" => "wp_editor",
        "default" => "Hi,

[ESCROWDATA]

Thanks",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_partner_created_escrow",
        "label" => "email_body_partner_created_escrow",
        "type" => "wp_editor",
        "default" => "Hi,

[ESCROWDATA]

Thanks",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_accept_escrow",
        "label" => "email_body_accept_escrow",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_partner_accept_escrow",
        "label" => "email_body_partner_accept_escrow",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_dispute_escrow",
        "label" => "email_body_dispute_escrow",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_partner_dispute_escrow",
        "label" => "email_body_partner_dispute_escrow",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_release_escrow",
        "label" => "email_body_release_escrow",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_partner_release_escrow",
        "label" => "email_body_partner_release_escrow",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_cancel_escrow",
        "label" => "email_body_cancel_escrow",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_partner_cancel_escrow",
        "label" => "email_body_partner_cancel_escrow",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_shipping_escrow",
        "label" => "email_body_shipping_escrow",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_partner_shipping_escrow",
        "label" => "email_body_partner_shipping_escrow",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_buyer_deposit",
        "label" => "email_body_buyer_deposit",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_seller_deposit",
        "label" => "email_body_seller_deposit",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_Buyer_Mark_Paid",
        "label" => "email_body_Buyer_Mark_Paid",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_payment_refund",
        "label" => "email_body_payment_refund",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "email_body_payment_accepted",
        "label" => "email_body_payment_accepted",
        "type" => "wp_editor",
        "default" => 'Hi,

[ESCROWDATA]

Thanks',
        "required" => true,

        "description" => "",
    ];

    $saksh_fields["email"] = $fields;

    return $saksh_fields;
}

include_once dirname(__FILE__) . "/aistore_email_install.php";

include_once dirname(__FILE__) . "/email_report.php";

include_once dirname(__FILE__) . "/send_email.php";
