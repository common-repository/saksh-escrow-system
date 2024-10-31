<?php

 
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


    return $aep->payment_form($escrow);
}



class AistoreEscrowPayment
{
    function payment_form($escrow)
    {
        $payable_amount = $escrow->amount + $escrow->create_escrow_fee;

        $details_escrow_page_id_url = esc_url($escrow->url);

        $currency = $escrow->currency;

       
 global $saksh;

        $AccountDetails= $saksh["bank_payment"]["AccountDetails"];
        

        echo "<hr>";

        echo "Send Payment To : ". $AccountDetails   ;

        echo "<hr>";

        $details_escrow_page_id_url = esc_url($escrow->url);

        echo "Payable Amount " . $payable_amount ." ".$currency;
        echo "<hr>";
        echo '<a href="' .
            esc_url($details_escrow_page_id_url) .
            '"> I Have completed the payment </a>';

        // echo "</div>";
    }

    
 
}











// setting section 


add_filter("saksh_escrow_settings", "saksh_bank_payment_setting_form");

function saksh_bank_payment_setting_form($saksh_fields)
{
    $fields = [];
 
    $fields[] = [
        "name" => "AccountDetails",
        "label" => "Account Details",
        "type" => "wp_editor",
 "default" => "",
        "required" => true,

        "description" =>"Bank Account Details",
    ];

    $saksh_fields["bank_payment"] = $fields;

    return $saksh_fields;
}


