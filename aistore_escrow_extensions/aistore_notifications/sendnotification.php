<?php
add_action(
    "AistoreEscrowCreated",
    "aistore_escrow_sendNotificationCreated",
    10,
    3
);
add_action(
    "AistoreEscrowAccepted",
    "aistore_escrow_sendNotificationAccepted",
    10,
    3
);
add_action(
    "AistoreEscrowCancelled",
    "aistore_escrow_sendNotificationCancelled",
    10,
    3
);
add_action(
    "AistoreEscrowDisputed",
    "aistore_escrow_sendNotificationDisputed",
    10,
    3
);
add_action(
    "AistoreEscrowReleased",
    "aistore_escrow_sendNotificationReleased",
    10,
    3
);

add_action(
    "AistoreEscrowPaymentRefund",
    "aistore_escrow_sendNotificationAdminPaymentRefund",
    10,
    3
);

add_action(
    "AistoreEscrowAdminPaymentAccepted",
    "aistore_escrow_sendNotificationAdminPaymentAccepted",
    10,
    3
);

add_action(
    "AistoreEscrowAdminReleased",
    "aistore_escrow_sendNotificationAdminReleased",
    10,
    3
);

add_action(
    "AistoreEscrowAdminCancelled",
    "aistore_escrow_sendNotificationAdminCancelled",
    10,
    3
);

add_action(
    "AistoreEscrowAdminPaymentRejected",
    "aistore_escrow_sendNotificationPaymentRejected",
    10,
    3
);

add_action(
    "AistoreEscrowAdminRemovePayment",
    "aistore_escrow_sendNotificationRemovePayment",
    10,
    3
);

function aistore_escrow_sendNotificationRemovePayment($escrow)
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

    aistore_notification_new($n);

    $n["email"] = $user_email;
    aistore_notification_new($n);
}
function aistore_escrow_sendNotificationPaymentRejected($escrow)
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

    aistore_notification_new($n);

    $n["email"] = $user_email;
    aistore_notification_new($n);
}

function aistore_escrow_sendNotificationAdminCancelled($escrow)
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

    aistore_notification_new($n);

    $n["email"] = $user_email;
    aistore_notification_new($n);
}
function aistore_escrow_sendNotificationAdminReleased($escrow)
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

    aistore_notification_new($n);

    $n["email"] = $user_email;
    aistore_notification_new($n);
}

function aistore_escrow_sendNotificationAdminPaymentAccepted($escrow)
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

    aistore_notification_new($n);

    $n["email"] = $user_email;
    aistore_notification_new($n);
}

function aistore_escrow_sendNotificationAdminPaymentRefund($escrow)
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

    aistore_notification_new($n);

    $n["email"] = $user_email;
    aistore_notification_new($n);
}

/**
       * This function is used to created escrow notification
       * @param string sender_email
       * @param string receiver_email
       
      */

function aistore_escrow_sendNotificationCreated($escrow)
{
    $eid = $escrow->id;

    $details_escrow_page_id_url = $escrow->url;

    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;

    global $saksh;

    $msg = $saksh["notification"]["created_escrow"];
    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $email = $user_email;

    $n["email"] = $user_email;

    aistore_notification_new($n);
    $msg = $saksh["notification"]["partner_created_escrow"];
    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n["message"] = $msg;
    $n["email"] = $party_email;
    aistore_notification_new($n);
}

/**
       * This function is used to accept escrow notification
       * @param string sender_email
       * @param string receiver_email
       
      */

function aistore_escrow_sendNotificationAccepted($escrow)
{
    global $saksh;
    $eid = $escrow->id;

    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    $msg = $saksh["notification"]["accept_escrow"];
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $user_id = get_current_user_id();
    $email = get_the_author_meta("user_email", $user_id);

    $n["email"] = $email;
    aistore_notification_new($n);

    $msg = $saksh["notification"]["partner_accept_escrow"];
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n["message"] = $msg;
    $n["email"] = aistore_escrow_getpartner($email, $escrow);
    aistore_notification_new($n);
}

/**
       * This function is used to cancel escrow notification
       * @param string sender_email
       * @param string receiver_email
       
      */

function aistore_escrow_sendNotificationCancelled($escrow)
{
    global $saksh;
    $eid = $escrow->id;

    $details_escrow_page_id_url = $escrow->url;

    $msg = $saksh["notification"]["cancel_escrow"];
    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $user_id = get_current_user_id();
    $email = get_the_author_meta("user_email", $user_id);

    $n["email"] = $email;
    aistore_notification_new($n);

    $msg = $saksh["notification"]["partner_cancel_escrow"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n["message"] = $msg;
    $n["email"] = aistore_escrow_getpartner($email, $escrow);
    aistore_notification_new($n);
}

/**
       * This function is used to dsipute escrow notification
       * @param string sender_email
       * @param string receiver_email
       
      */

function aistore_escrow_sendNotificationDisputed($escrow)
{
    global $saksh;
    $eid = $escrow->id;

    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    $msg = $saksh["notification"]["dispute_escrow"];
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $user_id = get_current_user_id();
    $email = get_the_author_meta("user_email", $user_id);

    $n["email"] = $email;

    aistore_notification_new($n);

    $msg = $saksh["notification"]["partner_dispute_escrow"];
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n["message"] = $msg;

    $n["email"] = aistore_escrow_getpartner($email, $escrow);

    aistore_notification_new($n);
}

/**
       * This function is used to release escrow notification
       * @param string sender_email
       * @param string receiver_email
       
      */

function aistore_escrow_sendNotificationReleased($escrow)
{
    global $saksh;
    $eid = $escrow->id;

    $details_escrow_page_id_url = $escrow->url;
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    $msg = $saksh["notification"]["release_escrow"];
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $user_id = get_current_user_id();
    $email = get_the_author_meta("user_email", $user_id);

    $n["email"] = $email;

    aistore_notification_new($n);
    $msg = $saksh["notification"]["partner_release_escrow"];
    $msg = Aistore_process_placeholder_Text($msg, $escrow);
    $n["message"] = $msg;

    $n["email"] = aistore_escrow_getpartner($email, $escrow);

    aistore_notification_new($n);
}

/**
       * This function is used to send payment escrow notification
       * @param string sender_email
       * @param string receiver_email
       
      */

function aistore_escrow_sendNotificationPaymentRefund($escrow)
{
    global $saksh;
    $eid = $escrow->id;

    $details_escrow_page_id_url = $escrow->url;

    $msg = $saksh["notification"]["PaymentRefund"];
    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $user_id = get_current_user_id();
    $email = get_the_author_meta("user_email", $user_id);

    $n["email"] = $email;

    aistore_notification_new($n);

    $msg = $saksh["notification"]["PaymentRefund"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n["message"] = $msg;

    $n["email"] = aistore_escrow_getpartner($email, $escrow);

    aistore_notification_new($n);
}

/**
       * This function is used to accept payment escrow notification
       * @param string sender_email
       * @param string receiver_email
       
      */

function aistore_escrow_sendNotificationPaymentAccepted($escrow)
{
    //global $wpdb;

    global $saksh;

    $eid = $escrow->id;
    //$escrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}escrow_system WHERE   id=%d ", $eid));

    $details_escrow_page_id_url = $escrow->url;

    $msg = $saksh["notification"]["payment_accepted"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n = [];
    $n["message"] = $msg;
    $n["type"] = "success";
    $n["reference_id"] = $eid;
    $n["url"] = $details_escrow_page_id_url;

    $user_id = get_current_user_id();
    $email = get_the_author_meta("user_email", $user_id);

    $n["email"] = $email;

    aistore_notification_new($n);

    $msg = $saksh["notification"]["payment_accepted"];

    $msg = Aistore_process_placeholder_Text($msg, $escrow);

    $n["message"] = $msg;

    $n["email"] = aistore_escrow_getpartner($email, $escrow);

    aistore_notification_new($n);
}

/**
       * This function is used to add a notification
       * @param string message
       * @param string type
       * @param string user_email
       * @param string url
       * @param string reference_id
       
      */

function aistore_notification_new($n)
{
    global $wpdb;
    $q1 = $wpdb->prepare(
        "INSERT INTO {$wpdb->prefix}escrow_notification (  message,type, user_email,url ,reference_id) VALUES ( %s, %s, %s, %s, %s ) ",
        [$n["message"], $n["type"], $n["email"], $n["url"], $n["reference_id"]]
    );
    // qr_to_log($q1);
    $wpdb->query($q1);
}
