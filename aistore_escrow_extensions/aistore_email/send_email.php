<?php

add_action("AistoreEscrowCreated", "sendEmailCreated", 10, 3);
add_action("AistoreEscrowAccepted", "sendEmailAccepted", 10, 3);
add_action("AistoreEscrowCancelled", "sendEmailCancelled", 10, 3);
add_action("AistoreEscrowDisputed", "sendEmailDisputed", 10, 3);
add_action("AistoreEscrowReleased", "sendEmailReleased", 10, 3);
add_action("AistoreEscrowPaymentAccepted", "sendEmailPaymentAccepted", 10, 3);
add_action(
    "AistoreEscrowPaymentRefund",
    "aistore_escrow_sendEmailAdminPaymentRefund",
    10,
    3
);
add_action(
    "AistoreEscrowAdminPaymentAccepted",
    "aistore_escrow_sendEmailAdminPaymentAccepted",
    10,
    3
);
add_action(
    "AistoreEscrowAdminReleased",
    "aistore_escrow_sendEmailAdminReleased",
    10,
    3
);
add_action(
    "AistoreEscrowAdminCancelled",
    "aistore_escrow_sendEmailAdminCancelled",
    10,
    3
);
add_action(
    "AistoreEscrowAdminPaymentRejected",
    "aistore_escrow_sendEmailPaymentRejected",
    10,
    3
);
add_action(
    "AistoreEscrowAdminRemovePayment",
    "aistore_escrow_sendEmailRemovePayment",
    10,
    3
);

function aistore_escrow_sendEmailRemovePayment($escrow)
{
    $eid = $escrow->id;
    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    $msg = "Admin removed the payment for the escrow Id " . $eid;

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $n["email"] = $party_email;

    $n["subject"] = $msg;

    $n["party_email"] = $n["email"];
    aistore_send_email($n);

    $n["email"] = $user_email;
    aistore_send_email($n);
}
function aistore_escrow_sendEmailPaymentRejected($escrow)
{
    $eid = $escrow->id;
    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    $msg = "Admin rejected the payment for the escrow Id " . $eid;

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $n["email"] = $party_email;

    $n["subject"] = $msg;

    $n["party_email"] = $n["email"];
    aistore_send_email($n);

    $n["email"] = $user_email;
    aistore_send_email($n);
}

function aistore_escrow_sendEmailAdminCancelled($escrow)
{
    $eid = $escrow->id;
    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    $msg = "Admin cancelled the escrow for the escrow Id " . $eid;

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $n["email"] = $party_email;

    $n["subject"] = $msg;

    $n["party_email"] = $n["email"];
    aistore_send_email($n);

    $n["email"] = $user_email;
    aistore_send_email($n);
}
function aistore_escrow_sendEmailAdminReleased($escrow)
{
    $eid = $escrow->id;
    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    $msg = "Admin released the payment for the escrow Id " . $eid;

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $n["email"] = $party_email;

    $n["subject"] = $msg;

    $n["party_email"] = $n["email"];
    aistore_send_email($n);

    $n["email"] = $user_email;
    aistore_send_email($n);
}

function aistore_escrow_sendEmailAdminPaymentAccepted($escrow)
{
    $eid = $escrow->id;
    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    $msg = "Admin Accepted the payment for the escrow Id " . $eid;

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $n["email"] = $party_email;

    $n["subject"] = $msg;

    $n["party_email"] = $n["email"];

    aistore_send_email($n);

    $n["email"] = $user_email;
    aistore_send_email($n);
}

function aistore_escrow_sendEmailAdminPaymentRefund($escrow)
{
    $eid = $escrow->id;
    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    $msg = "Admin refunded the payment for the escrow Id " . $eid;

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $n["email"] = $party_email;

    $n["subject"] = $msg;

    $n["party_email"] = $n["email"];

    aistore_send_email($n);

    $n["email"] = $user_email;
    aistore_send_email($n);
}

/**
       * This function is used to created escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */

function sendEmailCreated($escrow)
{
    global $saksh;

    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    $subject = $saksh["email"]["email_created_escrow"];

    $subject = Aistore_process_placeholder_Text($subject, $escrow);

    $msg = $saksh["email"]["email_body_created_escrow"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["subject"] = $subject;
    $n["escrow"] = $escrow;
    $n["reference_id"] = $escrow->id;
    $n["url"] = $details_escrow_page_id_url;
    $n["email"] = $user_email;
    $n["party_email"] = $party_email;

    aistore_send_email($n);

    $msg = $saksh["email"]["email_body_partner_created_escrow"];

    $subject = $saksh["email"]["email_partner_created_escrow"];
    $subject = Aistore_process_placeholder_Text($subject, $escrow);

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n["message"] = $msg;

    $n["subject"] = $subject;

    $n["email"] = $party_email;
    $n["party_email"] = $user_email;

    aistore_send_email($n);
}

/**
       * This function is used to accept escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */
function sendEmailAccepted($escrow)
{
    global $saksh;

    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    $subject = $saksh["email"]["email_accept_escrow"];
    $subject = Aistore_process_placeholder_Text($subject, $escrow);

    $msg = $saksh["email"]["email_body_accept_escrow"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["subject"] = $subject;
    $n["escrow"] = $escrow;
    $n["reference_id"] = $escrow->id;
    $n["url"] = $details_escrow_page_id_url;
    $n["email"] = $party_email;
    $n["party_email"] = $user_email;

    aistore_send_email($n);

    $msg = $saksh["email"]["email_body_partner_accept_escrow"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $subject == $saksh["email"]["email_partner_accept_escrow"];
    $subject = Aistore_process_placeholder_Text($subject, $escrow);

    $n["message"] = $msg;
    $n["subject"] = $subject;
    $n["email"] = $user_email;
    $n["party_email"] = $party_email;

    aistore_send_email($n);
}

/**
       * This function is used to cancel escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */
function sendEmailCancelled($escrow)
{
    global $saksh;

    $details_escrow_page_id_url = $escrow->url;

    $user_id = get_current_user_id();
    $email = get_the_author_meta("user_email", $user_id);

    $party_email = aistore_escrow_getpartner($email, $escrow);

    // send email to party

    $subject = $saksh["email"]["email_cancel_escrow"];
    $subject = Aistore_process_placeholder_Text($subject, $escrow);

    $msg = $saksh["email"]["email_body_cancel_escrow"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["subject"] = $subject;
    $n["escrow"] = $escrow;
    $n["reference_id"] = $escrow->id;
    $n["url"] = $details_escrow_page_id_url;
    $n["email"] = $email;
    $n["party_email"] = $party_email;

    aistore_send_email($n);

    $msg = $saksh["email"]["email_body_partner_cancel_escrow"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $subject = $saksh["email"]["email_partner_cancel_escrow"];
    $subject = Aistore_process_placeholder_Text($subject, $escrow);

    $n["message"] = $msg;
    $n["subject"] = $subject;
    $n["email"] = aistore_escrow_getpartner($email, $escrow); //$party_email;
    $n["party_email"] = $email;

    aistore_send_email($n);
}

/**
       * This function is used to dispute escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */
function sendEmailDisputed($escrow)
{
    global $saksh;

    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    // send email to party

    $subject = $saksh["email"]["email_dispute_escrow"];
    $subject = Aistore_process_placeholder_Text($subject, $escrow);

    $msg = $saksh["email"]["email_body_dispute_escrow"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["subject"] = $subject;
    $n["escrow"] = $escrow;
    $n["reference_id"] = $escrow->id;
    $n["url"] = $details_escrow_page_id_url;

    $user_id = get_current_user_id();
    $email = get_the_author_meta("user_email", $user_id);

    $n["email"] = $email;

    $n["party_email"] = $party_email;

    aistore_send_email($n);

    $msg = $saksh["email"]["email_body_partner_dispute_escrow"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $subject = $saksh["email"]["email_partner_dispute_escrow"];
    $subject = Aistore_process_placeholder_Text($subject, $escrow);

    $n["message"] = $msg;
    $n["subject"] = $subject;
    //$n['email'] = $party_email;
    $n["email"] = aistore_escrow_getpartner($party_email, $escrow);

    $n["party_email"] = $user_email;

    aistore_send_email($n);
}

/**
       * This function is used to release escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */
function sendEmailReleased($escrow)
{
    global $saksh;

    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    // send email to party

    $subject = $saksh["email"]["email_release_escrow"];
    $subject = Aistore_process_placeholder_Text($subject, $escrow);
    $msg = $saksh["email"]["email_body_release_escrow"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $user_id = get_current_user_id();
    $email = get_the_author_meta("user_email", $user_id);

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["subject"] = $subject;
    $n["escrow"] = $escrow;
    $n["reference_id"] = $escrow->id;
    $n["url"] = $details_escrow_page_id_url;
    $n["email"] = $email;
    $n["party_email"] = $party_email;

    aistore_send_email($n);

    ob_start();

    $msg = $saksh["email"]["email_body_partner_release_escrow"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $subject = $saksh["email"]["email_partner_release_escrow"];
    $subject = Aistore_process_placeholder_Text($subject, $escrow);
    $n["message"] = $msg;
    $n["subject"] = $subject;
    //   $n['email'] = $party_email;

    $n["email"] = aistore_escrow_getpartner($party_email, $escrow);

    $n["party_email"] = $user_email;

    aistore_send_email($n);
}

/**
       * This function is used to payment accepted escrow email
       * @param string sender_email
       * @param string receiver_email
       
      */
function sendEmailPaymentAccepted($escrow)
{
    global $saksh;
    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    // send email to party

    $subject = $saksh["email"]["email_buyer_deposit"];
    $subject = Aistore_process_placeholder_Text($subject, $escrow);
    $msg = $saksh["email"]["email_body_buyer_deposit"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["subject"] = $subject;
    $n["escrow"] = $escrow;
    $n["reference_id"] = $escrow->id;
    $n["url"] = $details_escrow_page_id_url;
    $n["email"] = $user_email;
    $n["party_email"] = $party_email;

    aistore_send_email($n);

    ob_start();

    $msg = $saksh["email"]["email_body_seller_deposit"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $subject = $saksh["email"]["email_seller_deposit"];
    $subject = Aistore_process_placeholder_Text($subject, $escrow);

    $n["message"] = $msg;
    $n["subject"] = $subject;
    $n["email"] = $party_email;
    $n["party_email"] = $user_email;

    aistore_send_email($n);
}

/**
       * This function is used to send an email
       * @param string message
       * @param string type
       * @param string user_email
       * @param string party_email
       * @param string url
       * @param string reference_id
       * @param string subject
       
      */
function aistore_send_email($n)
{
    global $wpdb;

    $headers = ["Content-Type: text/html; charset=UTF-8"];

    ob_start();
    include dirname(__FILE__) . "/email_template.php";
    $message = ob_get_clean();

    $body = str_replace("[message]", $n["message"], $message);

    wp_mail($n["email"], $n["subject"], $body, $headers);

    $q1 = $wpdb->prepare(
        "INSERT INTO {$wpdb->prefix}escrow_email (message,type, user_email,party_email,url ,reference_id,subject) VALUES ( %s, %s, %s,%s, %s, %s ,%s) ",
        [
            $n["message"],
            $n["type"],
            $n["email"],
            $n["party_email"],
            $n["url"],
            $n["reference_id"],
            $n["subject"],
        ]
    );

  //  qr_to_log(__LINE__, $q1);

    $wpdb->query($q1);
}
