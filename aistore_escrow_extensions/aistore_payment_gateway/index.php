<?php
/*
Plugin Name: Saksh Escrow Payment Gatway System
Version:  2.1
Stable tag: 2.1
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Saksh Escrow System is a plateform allow parties to complete safe payments.  


*/

include "crypto_deposit.php";

add_action(
    "wp_ajax_nopriv_payment_nofity_url",
    "aistore_escrow_payment_nofity_url"
);

add_action("wp_ajax_payment_nofity_url", "aistore_escrow_payment_nofity_url");

function aistore_escrow_payment_nofity_url()
{
    $real_secret = "ZzsMLGKe162CfA5EcG6j";

    $transaction_hash = $_GET["transaction_hash"];
    $value_in_satoshi = $_GET["value"];

    $value_in_btc = $value_in_satoshi / 100000000;

    $eid = sanitize_text_field($_REQUEST["invoice_id"]);

    $object_escrow = new AistoreEscrowSystem();

    $escrow = $object_escrow->AistoreGetEscrow($eid);

    $sender = get_user_by("email", $escrow->sender_email);

    $escrow_wallet = new AistoreWallet();

    $new_amount = $escrow->create_escrow_fee + $escrow->amount;

    $amount_in_btc = file_get_contents(
        "https://blockchain.info/tobtc?currency=" .
            $escrow->currency .
            "&value=" .
            $new_amount
    );

    $escrow_wallet->aistore_credit(
        $sender->id,
        $new_amount,
        $escrow->currency,
        "Deposit Payment  transaction hash  " .
            $transaction_hash .
            " To User Account  with escrow id # " .
            $eid,
        $eid
    );

    if ($value_in_btc == $value_in_btc) {
        $object_escrow->AistoreEscrowMarkPaid($escrow);
    }

    echo "*ok*";

    wp_die();
}
