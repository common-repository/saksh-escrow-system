<?php
add_filter("saksh_escrow_settings", "saksh_crypto_payment_setting_form");

function saksh_crypto_payment_setting_form($saksh_fields)
{
    $fields = [];

    $fields[] = [
        "name" => "secret",
        "label" => "secret",
        "type" => "string",
 "default" => "",
        "required" => true,
 "description" =>
            "Review https://www.blockchain.com/api/api_receive or support to +91 8840574997",
    ];

    $fields[] = [
        "name" => "my_api_key",
        "label" => "my_api_key",
        "type" => "string",
 "default" => "",
        "required" => true,

        "description" =>
            "Review https://www.blockchain.com/api/api_receive or support to +91 8840574997",
    ];

    $fields[] = [
        "name" => "my_xpub",
        "label" => "my_xpub",
        "type" => "string",
 "default" => "",
        "required" => true,

        "description" =>
            "Review https://www.blockchain.com/api/api_receive or support to +91 8840574997",
    ];

    $saksh_fields["saksh_crypto_payment_setting"] = $fields;

    return $saksh_fields;
}
