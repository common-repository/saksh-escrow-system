<?php

include "crypto_setting.php";
// this include 2 section

// section 1 show form

// section 2 notification handling so that form status can be updated

add_filter("payment_method_list", "aistore_escrow_payment_method_list");

function aistore_escrow_payment_method_list($escrow)
{
    $aep = new AistoreEscrowPayment();
    $eid = sanitize_text_field($_REQUEST["eid"]);

    $object_escrow = new AistoreEscrowSystem();

    $escrow = $object_escrow->AistoreGetEscrow($eid);


//var_dump($escrow);
    return $aep->payment_form($escrow);
}

class AistoreEscrowPayment
{
    function payment_form($escrow)
    {
        $payable_amount = $escrow->amount + $escrow->create_escrow_fee;

        $details_escrow_page_id_url = esc_url($escrow->url);

        $currency = $escrow->currency;

        $amount_in_btc = file_get_contents(
            "https://blockchain.info/tobtc?currency=" .
                $escrow->currency .
                "&value=" .
                $payable_amount
        );

        echo "<hr/> Amount in BTC " . $amount_in_btc;

        $address = $this->getNewAddress($escrow);

        echo "<hr>";

        echo "Send Payment To : " . $address;

        echo "<hr>";

        $details_escrow_page_id_url = esc_url($escrow->url);

        echo "Payable Amount " . $payable_amount;
        echo "<hr>";
        echo '<a href="' .
            esc_url($details_escrow_page_id_url) .
            '"> I Have completed the payment </a>';

        // echo "</div>";
    }

    function getNewAddress($escrow)
    {
        // setting fields   $hash ,  secret , xpub , api key ,

        $hash = "ZzsMLGZzsMLGZzsMLGZzsMLGKzsMLGZzsMLGKGZzsMLGK";

        $notify_url =
            admin_url("admin-ajax.php") .
            "?action=payment_nofity_url&invoice_id=" .
            $escrow->id .
            "&hash=" .
            $hash;

        global $saksh;

        $secret = $saksh["saksh_crypto_payment_setting"]["secret"];
        $my_api_key = $saksh["saksh_crypto_payment_setting"]["my_api_key"];

        $my_xpub = $saksh["saksh_crypto_payment_setting"]["my_xpub"];

        $root_url = "https://api.blockchain.info/v2/receive";

        $parameters =
            "xpub=" .
            $my_xpub .
            "&callback=" .
            urlencode($notify_url) .
            "&key=" .
            $my_api_key;

        $response = file_get_contents($root_url . "?" . $parameters);

        $object = json_decode($response);

        return $object->address;
    }

    // this will run in the background and update the escrow payment status
    function webhook()
    {
        $eid = sanitize_text_field($_REQUEST["ecsrow_id"]);

        $object_escrow = new AistoreEscrowSystem();

        $escrow = $object_escrow->AistoreGetEscrow($eid);

        //$sender = get_user_by('email', $escrow->sender_email);

        $escrow_wallet = new AistoreWallet();

        $new_amount = $escrow->escrow_fee + $escrow->amount;

        $escrow_wallet->aistore_credit(
            $escrow->sender_user_id,
            $new_amount,
            $escrow->currency,
            "Deposit Payment To User Account  with escrow id # " . $eid,
            $eid
        );

        //$escrow_wallet->aistore_credit($sender->id, 1000000, $escrow->currency, 'Deposit Payment To User Account  with escrow id test # ' . $eid,  1);

        $object_escrow->AistoreEscrowMarkPaid($escrow);

        echo '  <meta http-equiv = "refresh" content = "0; url = ' .
            $escrow->url .
            '" />';
    }
}
