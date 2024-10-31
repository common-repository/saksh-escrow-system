<?php
if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

include_once "AistoreEscrowAdmin.class.php";

class AistoreEscrowSystemAdmin extends AistoreEscrowAdmin
{
    // Escrow Details

    //   This function is used to  escrow deatils admin page
    public function aistore_admin_escrow_detail()
    {
        ob_start();

        global $wpdb;

        if (!isset($_REQUEST["eid"])) {
           // $escrow = $this->AistoreGetNewEscrow();
           // $eid = $escrow->id;
            
           
            
            echo "<br/><br/>No any escrow find please create 1 and test the system.<br/><br/><strong> Whatsapp +91 8840574997 or +91  9559190379 for any support </strong><br/><br/>  https://api.whatsapp.com/send?phone=919559190379&text=Hello%20via%20sakshstore.com <br/><br/> ";
            
            wp_die() ;
            
        } else {
            $eid = sanitize_text_field($_REQUEST["eid"]);
        }

        echo $this->aistore_escrow_btn_admin_actions($eid);
        $escrow = $this->AistoreGetEscrow($eid);

        echo "<h1>#" .
            esc_attr($escrow->id) .
            " " .
            esc_attr($escrow->title) .
            "</h1><br>";

        printf(__("Sender :  %s", "aistore"), $escrow->sender_email . "<br>");
        printf(
            __("Receiver : %s", "aistore"),
            $escrow->receiver_email . "<br>"
        );
        printf(__("Status : %s", "aistore"), $escrow->status . "<br>");
        printf(
            __("Payment Status : %s", "aistore"),
            $escrow->payment_status . "<br>"
        );
        printf(
            __("Amount : %s", "aistore"),
            $escrow->amount . " " . $escrow->currency . "<br><hr />"
        );

        $this->admin_cancel_escrow_btn($escrow);
        $this->admin_release_escrow_btn($escrow);
        $this->admin_accept_payment_escrow_btn($escrow);
        $this->admin_reject_payment_escrow_btn($escrow);

        echo $this->admin_remove_payment_escrow_btn($escrow);

        echo $this->aistore_escrow_detail_tabs($escrow);

        return ob_get_clean();
    }
}
