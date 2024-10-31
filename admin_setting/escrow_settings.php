<?php

add_filter("saksh_escrow_settings", "aistore_escrow_setting_form");

function aistore_escrow_setting_form($saksh_fields)
{
    $fields = [];

    // field should be escrow_admin_user_id
    $fields[] = [
        "name" => "escrow_admin_user_id",
        "label" => "escrow_admin_user_id",
        "type" => "string",
        "default" => 1,
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "cancel_escrow_fee",
        "label" => "cancel_escrow_fee",
        "type" => "string",
        "default" => 10,
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "escrow_fee_deducted",
        "label" => "escrow_fee_deducted",
        "type" => "string",
        "default" => "yes",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "escrow_create_fee",
        "label" => "escrow_create_fee",
        "type" => "string",

        "required" => true,
        "default" => 10,

        "description" => "",
    ];

    $fields[] = [
        "name" => "escrow_accept_fee",
        "label" => "escrow_accept_fee",
        "type" => "string",
        "default" => "5",
        "required" => true,

        "description" => "",
    ];

    $fields[] = [
        "name" => "escrow_fee_deducted",
        "label" => "escrow_fee_deducted",
        "type" => "select",
        "options" => ["release", "accepted"],
        "default" => "accepted",

        "required" => true,

        "description" => "",
    ];

    $saksh_fields["escrow_settings"] = $fields;

    return $saksh_fields;
}
