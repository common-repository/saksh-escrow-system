<?php

add_filter("saksh_escrow_settings", "aistore_escrow_page_setting_form");

function aistore_escrow_page_setting_form($saksh_fields)
{
    $fields = [];

    $page = [
        "post_title" => "Create Escrow",
        "post_content" => "[aistore_escrow_system]",
    ];

    $fields[] = [
        "name" => "add_escrow_page_id",
        "label" => "add_escrow_page_id",
        "type" => "pages",
        "required" => true,
        "default" => $page,

        "description" => "",
    ];


   

    $page = [
        "post_title" => "Escrow List",

        "post_content" => "[aistore_escrow_list] ",
    ];

    $fields[] = [
        "name" => "escrow_list",
        "label" => "escrow_list",
        "type" => "pages",
        "required" => true,
        "default" => $page,

        "description" => "",
    ];

    $page = [
        "post_title" => "Escrow Detail",
        "post_content" => "[aistore_escrow_detail]",
    ];

    $fields[] = [
        "name" => "details_escrow_page_id",
        "label" => "details_escrow_page_id",
        "type" => "pages",
        "required" => true,
        "default" => $page,

        "description" => "",
    ];

    $page = [
        "post_title" => "Payment method list",
        "post_content" => "[payment_method_list]",
    ];

    $fields[] = [
        "name" => "payment_method_list_page_id",
        "label" => "payment_method_list_page_id",
        "type" => "pages",
        "required" => true,
        "default" => $page,

        "description" => "",
    ];

    $page = [
        "post_title" => "Aistore transaction history",
        "post_content" => "[aistore_transaction_history]",
    ];

    $fields[] = [
        "name" => "aistore_transaction_history_page_id",
        "label" => "aistore_transaction_history_page_id",
        "type" => "pages",
        "default" => $page,
        "required" => true,

        "description" => "",
    ];

    $saksh_fields["escrow_page"] = $fields;

    return $saksh_fields;
}
