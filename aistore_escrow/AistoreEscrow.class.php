<?php
if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

class AistoreEscrow
{
    // This function is used to get escrow admin user id
    public function get_escrow_admin_user_id()
    {
        global $saksh;
        $escrow_admin_user_id =
            $saksh["escrow_settings"]["escrow_admin_user_id"];

        return $escrow_admin_user_id;
    }

    //This function is used to create escrow fee
    public function create_escrow_fee($amount)
    {
        global $saksh;

        $escrow_create_fee = $saksh["escrow_settings"]["escrow_create_fee"];

        $escrow_fee = ($escrow_create_fee / 100) * $amount;
        return $escrow_fee;
    }

    //This function is used to accept escrow fee
    public function accept_escrow_fee($amount)
    {
        global $saksh;

        $escrow_accept_fee = $saksh["escrow_settings"]["escrow_accept_fee"];

        $escrow_fee = ($escrow_accept_fee / 100) * $amount;
        return $escrow_fee;
    }

    //This function is used to create escrow
    function create_escrow($request)
    {
        global $saksh;
        global $wpdb;

        $title = sanitize_text_field($request["title"]);
        $amount = sanitize_text_field($request["amount"]);
        $create_escrow_fee = $this->create_escrow_fee($amount);
        $accept_escrow_fee = $this->accept_escrow_fee($amount);

        $receiver_email = sanitize_email($request["receiver_email"]);

      $term_condition ="";// sanitize_textarea_field(
        //  htmlentities($request["term_condition"])
   // );

        $escrow_currency = sanitize_text_field(
            $request["aistore_escrow_currency"]
        );

        $sender_email = $request["user_email"];

        $user = get_user_by("email", $sender_email);

        $sender_user_id = $user->ID;

        // add a column accept escrow fee and insert the fee as well

        $qr = $wpdb->prepare(
            "INSERT INTO {$wpdb->prefix}escrow_system ( title, amount, receiver_email,sender_email,sender_user_id ,term_condition ,create_escrow_fee,accept_escrow_fee ,currency ) VALUES ( %s, %s, %s, %s ,%s ,%s ,%s , %s,%s)",
            [
                $title,
                $amount,
                $receiver_email,
                $sender_email,
                $sender_user_id,
                $term_condition,
                $create_escrow_fee,
                $accept_escrow_fee,
                $escrow_currency,
            ]
        );

        $wpdb->query($qr);

        $eid = $wpdb->insert_id;

        $details_escrow_page_id =
            $saksh["escrow_page"]["details_escrow_page_id"];

        $details_escrow_page_id_url = esc_url(
            add_query_arg(
                [
                    "page_id" => $details_escrow_page_id,
                    "eid" => $eid,
                ],
                home_url()
            )
        );

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->prefix}escrow_system
    SET url = '%s'  WHERE id = '%d'",
                $details_escrow_page_id_url,
                $eid
            )
        );

        $request["id"] = $eid;
        $request["currency"] = $escrow_currency;
        $request["sender_email"] = $sender_email;
        $request["sender_user_id"] = $sender_email;

        $escrow = $this->AistoreGetEscrow($eid);

        $request["escrow"] = $escrow;

        do_action("AistoreEscrowCreatedRequest", $request);

        do_action("AistoreEscrowCreated", $escrow);

        return $escrow;
    }

    // This function is used to  escrow list by user email id
    public function AistoreEscrowList($emailId)
    {
        global $wpdb;

        $results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}escrow_system WHERE receiver_email=%s or sender_email=%s order by id desc ",
                $emailId,
                $emailId
            )
        );

        return $results;
    }

    // This function is used to escrow details by escrow id and an email
    public function AistoreEscrowDetail($eid, $email)
    {
        global $wpdb;

        $escrow = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}escrow_system where id=%d and ( receiver_email=%s or sender_email=%s ) ",
                $eid,
                $email,
                $email
            )
        );

        return $escrow;
    }

    // This function is used to get escrow details by escrow id
    public function AistoreGetEscrow($eid)
    {
        global $wpdb;

        $escrow = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}escrow_system where id=%d   ",
                $eid
            )
        );

        return $escrow;
    }

    // This function is used to get recent escrow details
    public function AistoreGetNewEscrow()
    {
        global $wpdb;

        $escrow = $wpdb->get_row(
            "SELECT * FROM {$wpdb->prefix}escrow_system  order by id desc limit 1  "
        );

        return $escrow;
    }

    // This function is used to send payment to user account with escrow id and payment status are paid
    public function AistoreEscrowMarkPaid($escrow)
    {
        global $saksh;

        $escrow_admin_user_id = $this->get_escrow_admin_user_id();

        $escrow_payment_credit_by_gateway =
            "Send Payment To User Account  with escrow id # " . $escrow->id;

        $escrow_wallet = new AistoreWallet();

        $description_amount_transfer =
            "Escrow amount for the created escrow with id #" . $escrow->id;

        $escrow_wallet->aistore_transfer(
            $escrow->sender_user_id,
            $escrow_admin_user_id,
            $escrow->amount,
            $escrow->currency,
            $description_amount_transfer,
            $escrow->id
        );

        $description_fee_transfer =
            "Escrow Fee for the created escrow with id #" . $escrow->id;

        $escrow_wallet->aistore_transfer(
            $escrow->sender_user_id,
            $escrow_admin_user_id,
            $escrow->create_escrow_fee,
            $escrow->currency,
            $description_fee_transfer,
            $escrow->id
        );

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->prefix}escrow_system
    SET payment_status = 'paid'  WHERE id = '%d' ",
                $escrow->id
            )
        );

        $escrow = $this->AistoreGetEscrow($escrow->id); // make sure we get updated escrow before pushing data to anyone

        do_action("AistoreEscrowPaymentAccepted", $escrow);

        return $escrow;
    }

    //  This function is used to dispute escrow with escrow id and status are disputed
    function DisputeEscrow($escrow, $user_email)
    {
        global $saksh;

        global $wpdb;

        if (!$this->dispute_escrow_btn_visible($escrow)) {
            return "";
        }

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->prefix}escrow_system
    SET status = '%s'  WHERE id = '%d' and payment_status='paid'",
                "disputed",
                $escrow->id
            )
        );

        $dispute_escrow_success_message = Aistore_process_placeholder_Text(
            $saksh["escrow_message"]["dispute_escrow_success_message"],
            $escrow
        );

        $escrow = $this->AistoreGetEscrow($escrow->id);
        do_action("AistoreEscrowDisputed", $escrow);

        return $dispute_escrow_success_message;
    }

    function CancelEscrow($escrow, $user_email)
    {
        if (!$this->cancel_escrow_btn_visible($escrow, $user_email)) {
            return "";
        }

        $escrow_wallet = new AistoreWallet();

        global $wpdb;
        global $saksh;

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->prefix}escrow_system
    SET status = 'cancelled'  WHERE (  receiver_email = %s   or  sender_email = %s    )  and  id =  %d ",
                $user_email,
                $user_email,
                $escrow->id
            )
        );

        $escrow_admin_user_id = $this->get_escrow_admin_user_id();

        if ($escrow->payment_status == "paid") {
            $message_payment_refunded_when_cancel =
                "Payment refunded when escrow was cancelled Escrow id " .
                $escrow->id;

            $escrow_wallet->aistore_transfer(
                $escrow_admin_user_id,
                $escrow->sender_user_id,
                $escrow->amount,
                $escrow->currency,
                $message_payment_refunded_when_cancel,
                $escrow->id
            );

            $cancel_escrow_fee = $saksh["escrow_settings"]["cancel_escrow_fee"];

            if ($cancel_escrow_fee == "yes") {
                $message_escrow_fee_refunded_when_cancel =
                    "Escrow fee refunded when escrow was cancelled Escrow id " .
                    $escrow->id;

                $escrow_wallet->aistore_transfer(
                    $escrow_admin_user_id,
                    $escrow->sender_user_id,
                    $escrow->accept_escrow_fee,
                    $escrow->currency,
                    $message_escrow_fee_refunded_when_cancel,
                    $escrow->id
                );
            }
        }

        $cancel_escrow_success_message = Aistore_process_placeholder_Text(
            $saksh["escrow_message"]["cancel_escrow_success_message"],
            $escrow
        );

        $escrow = $this->AistoreEscrowDetail($escrow->id, $user_email);

        do_action("AistoreEscrowCancelled", $escrow);

        return $cancel_escrow_success_message;
    }

    function ReleaseEscrow($escrow, $user_email)
    {
        global $saksh;

        $escrow_wallet = new AistoreWallet();

        if (!$this->release_escrow_btn_visible($escrow, $user_email)) {
            return "";
        }

        global $wpdb;
        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->prefix}escrow_system
    SET status = 'released'  WHERE  payment_status='paid' and  sender_email=%s and id = %d ",
                $user_email,
                $escrow->id
            )
        );

        $escrow_admin_user_id = $this->get_escrow_admin_user_id();

        $escrow_fee_deducted = $saksh["escrow_settings"]["escrow_fee_deducted"];

        if ($escrow_fee_deducted == "released") {
            $message_escrow_fee_taken_when_released =
                "Escrow fee taken when escrow was released Escrow id " .
                $escrow->id;

            $escrow_wallet->aistore_transfer(
                $escrow->receiver_user_id,
                $escrow_admin_user_id,
                $escrow->accept_escrow_fee,
                $escrow->currency,
                $message_escrow_fee_taken_when_released,
                $escrow->id
            );
        }

        $message_payment_transfer_when_released =
            "Payment transfer when escrow was released Escrow id " .
            $escrow->id;

        $escrow_wallet->aistore_transfer(
            $escrow_admin_user_id,
            $escrow->receiver_user_id,
            $escrow->amount,
            $escrow->currency,
            $message_payment_transfer_when_released,
            $escrow->id
        );

        $message_escrow_released_successfully =
            "Escrow released successfully Escrow Id " . $escrow->id;

        $escrow = $this->AistoreGetEscrow($escrow->id);
        do_action("AistoreEscrowReleased", $escrow);
        return $message_escrow_released_successfully;
    }

    function AcceptEscrow($escrow, $user_email)
    {
        global $saksh;
        if (!$this->accept_escrow_btn_visible($escrow, $user_email)) {
            return "";
        }

        $escrow_wallet = new AistoreWallet();

        $receiver_user_id = get_current_user_id();

        $escrow_fee_deducted = Aistore_process_placeholder_Text(
            $saksh["escrow_settings"]["escrow_fee_deducted"],
            $escrow
        );

        $escrow_admin_user_id = $this->get_escrow_admin_user_id();

        if ($escrow_fee_deducted == "accepted") {
            $message_fee_taken_when_escrow_accepted =
                "Escrow fee transfer when accepted escrow id " . $escrow->id;

            $escrow_wallet->aistore_transfer(
                $receiver_user_id,
                $escrow_admin_user_id,
                $escrow->accept_escrow_fee,
                $escrow->currency,
                $message_fee_taken_when_escrow_accepted,
                $escrow->id
            );
        }

        global $wpdb;

        $wpdb->query(
            $wpdb->prepare(
                "UPDATE {$wpdb->prefix}escrow_system
    SET status = '%s',  receiver_user_id ='%s'  WHERE  payment_status='paid' and  receiver_email = %s  and id = '%d'",
                "accepted",
                $receiver_user_id,
                $user_email,
                $escrow->id
            )
        );

        $message_when_escrow_accepted =
            "Escrow  accepted successfully escrow id " . $escrow->id;

        $escrow = $this->AistoreGetEscrow($escrow->id);
        do_action("AistoreEscrowAccepted", $escrow);

        return $message_when_escrow_accepted;
    }

    //  This function is used to dispute escrow button visible or not
    function dispute_escrow_btn_visible($escrow)
    {
        if ($escrow->payment_status != "paid") {
            return false;
        }

        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        } elseif ($escrow->status == "disputed") {
            return false;
        } elseif ($escrow->status == "pending") {
            return false;
        }

        return true;
    }

    // This function is used to release escrow button visible or not
    public function release_escrow_btn_visible($escrow, $user_email)
    {
        if ($escrow->payment_status != "paid") {
            return false;
        }

        if ($escrow->sender_email != $user_email) {
            return false;
        }

        //  if (aistore_isadmin() == $user_email) return "";

        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        } elseif ($escrow->status == "pending") {
            return false;
        }

        return true;
    }

    //   This function is used to cancel escrow button visible or not
    function cancel_escrow_btn_visible($escrow, $user_email)
    {
        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        }

        if ($escrow->sender_email == $user_email) {
            if ($escrow->status != "pending") {
                if ($escrow->payment_status == "paid") {
                    return false;
                }
            }
        }

        return true;
    }

    //   This function is used to accept escrow button visible or not
    function accept_escrow_btn_visible($escrow, $user_email)
    {
        if ($escrow->payment_status != "paid") {
            return false;
        }

        if ($escrow->sender_email == $user_email) {
            return false;
        }

        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        } elseif ($escrow->status == "disputed") {
            return false;
        } elseif ($escrow->status == "accepted") {
            return false;
        }

        return true;
    }

    // This function is used to make_payment escrow button visible or not
    function make_payment_btn_visible($escrow, $user_email)
    {
        if ($escrow->payment_status == "paid") {
            return false;
        }

        if ($escrow->payment_status == "cancelled") {
            return false;
        }

        if ($escrow->sender_email != $user_email) {
            return false;
        }

        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        } elseif ($escrow->status == "disputed") {
            return false;
        } elseif ($escrow->status == "accepted") {
            return false;
        }

        return true;
    }

    // This function is used to  Accept Button

    function accept_escrow_btn($escrow, $user_email)
    {
        if ($this->accept_escrow_btn_visible($escrow, $user_email)) { ?>

 <form method="POST" action="" name="accepted" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"  class="button button-primary  btn  btn-primary "   name="submit" value="<?php _e(
      "Accept",
      "aistore"
  ); ?>">
  <input type="hidden" name="action" value="accepted" />
</form> <?php }
    }

    // cancel button

    //   This function is used to  Cancel Button
    function cancel_escrow_btn($escrow, $user_email)
    {
        if ($this->cancel_escrow_btn_visible($escrow, $user_email)) { ?>

 <form method="POST" action="" name="cancelled" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"  name="submit"   class="button button-primary  btn  btn-primary "    value="<?php _e(
      "Cancel Escrow",
      "aistore"
  ); ?>">
  <input type="hidden" name="action" value="cancelled" />
</form> <?php }
    }

    //  This function is used to  Release Button
    // release button
    public function release_escrow_btn($escrow, $user_email)
    {
        if (!$this->release_escrow_btn_visible($escrow, $user_email)) {
            return "";
        } ?>

  
 <form method="POST" action="" name="released" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"    class="button button-primary  btn  btn-primary "    name="submit" value="<?php _e(
      "Release",
      "aistore"
  ); ?>">
  <input type="hidden" name="action" value="released" />
</form> <?php
    }

    // dispute button
    //  This function is used to  Dispute Button
    function dispute_escrow_btn($escrow, $user_email)
    {
        if (!$this->dispute_escrow_btn_visible($escrow, $user_email)) {
            return "";
        } ?>

 <form method="POST" action="" name="disputed" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"   class="button button-primary  btn  btn-primary "    name="submit" value="<?php _e(
      "Dispute",
      "aistore"
  ); ?>">
  <input type="hidden" name="action" value="disputed" />
</form> <?php
    }

    //This function is to escrow button action
    // like disputed, accepted,released,cancelled
    public function aistore_escrow_btn_actions()
    {
        $eid = sanitize_text_field($_REQUEST["eid"]);

        $user_id = get_current_user_id();

        $user_email = get_the_author_meta("user_email", $user_id);

        $escrow = $this->AistoreEscrowDetail($eid, $user_email);

        if (isset($_POST["submit"]) and $_POST["action"] == "disputed") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
            }

            $dispute_escrow_success_message = $this->DisputeEscrow(
                $escrow,
                $user_email
            );
            ?>
<div>
<strong> <?php echo esc_attr($dispute_escrow_success_message); ?></strong></div>
<?php
        }

        if (isset($_POST["submit"]) and $_POST["action"] == "accepted") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
            }

            $message_when_escrow_accepted = $this->AcceptEscrow(
                $escrow,
                $user_email
            );
            ?>
<div>
    
<strong> <?php echo esc_attr($message_when_escrow_accepted); ?></strong></div>
<?php
        }

        if (isset($_POST["submit"]) and $_POST["action"] == "released") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
            }

            $res = $this->ReleaseEscrow($escrow, $user_email);
            ?>
<div>
<strong> <?php echo esc_attr($res); ?></strong></div>
<?php
        }

        // Sender Create escrow  to excute cancel button
        // Receiver  accept or cancel escrow
        if (isset($_POST["submit"]) and $_POST["action"] == "cancelled") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
            }

            $cancel_escrow_success_message = $this->CancelEscrow(
                $escrow,
                $user_email
            );
            ?>
<div>
<strong><?php echo esc_attr($cancel_escrow_success_message); ?></strong></div>

<?php
        }
    }

    // This function is to get ip address
    function aistore_ipaddress()
    {
        $ipaddress = "";
        if (getenv("HTTP_CLIENT_IP")) {
            $ipaddress = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ipaddress = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_X_FORWARDED")) {
            $ipaddress = getenv("HTTP_X_FORWARDED");
        } elseif (getenv("HTTP_FORWARDED_FOR")) {
            $ipaddress = getenv("HTTP_FORWARDED_FOR");
        } elseif (getenv("HTTP_FORWARDED")) {
            $ipaddress = getenv("HTTP_FORWARDED");
        } elseif (getenv("REMOTE_ADDR")) {
            $ipaddress = getenv("REMOTE_ADDR");
        } else {
            $ipaddress = "UNKNOWN";
        }

        return $ipaddress;
    }
}