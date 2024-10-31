<?php

add_filter("saksh_escrow_settings", "saksh_escrow_message_setting_form");

function saksh_escrow_message_setting_form($saksh_fields)
{
    $fields = [];

    $fields[] = [
        "name" => "created_escrow_message",
        "label" => "created_escrow_message",
        "type" => "string",

        "default" =>
            "Payment transaction for the created escrow with escrow id  # [EID]",

        "required" => true,

        "description" => "",
    ];
    $fields[] = [
        "name" => "created_escrow_success_message",
        "label" => "created_escrow_success_message",
        "type" => "string",

        "default" => "Created Successfully escrow id  # [EID]",

        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "accept_escrow_message",
        "label" => "accept_escrow_message",
        "type" => "string",

        "default" =>
            "Payment transaction for the accepted escrow with escrow id  # [EID]",

        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "dispute_escrow_message",
        "label" => "dispute_escrow_message",
        "type" => "string",

        "default" =>
            "Payment transaction for the disputed escrow with escrow id  # [EID]",

        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "dispute_escrow_success_message",
        "label" => "dispute_escrow_success_message",
        "type" => "string",

        "default" => "Disputed Successfully escrow id  # [EID]",

        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "release_escrow_message",
        "label" => "release_escrow_message",
        "type" => "string",

        "default" =>
            "Payment transaction for the released escrow with escrow id  # [EID]",

        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "release_escrow_success_message",
        "label" => "release_escrow_success_message",
        "type" => "string",

        "default" => "Released Successfully escrow id  # [EID]",

        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "cancel_escrow_message",
        "label" => "cancel_escrow_message",
        "type" => "string",

        "default" =>
            "Payment transaction for the cancelled escrow with escrow id  # [EID]",

        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "cancel_escrow_success_message",
        "label" => "cancel_escrow_success_message",
        "type" => "string",

        "default" => "Cancelled Successfully escrow id  # [EID]",

        "required" => true,

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
        "name" => "dispute_escrow",
        "label" => "dispute_escrow",
        "type" => "string",
        "default" => "You have successfully  disputed the escrow # [EID]",
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
        "name" => "cancel_escrow",
        "label" => "cancel_escrow",
        "type" => "string",
        "default" => "You have successfully  cancelled the escrow # [EID]",
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

    $saksh_fields["escrow_message"] = $fields;

    return $saksh_fields;
}
