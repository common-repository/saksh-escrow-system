<?php

function aistore_escrow_all_notification($contactmethods)
{
    $contactmethods["notification_list"] = "Notification";
    return $contactmethods;
}

add_filter("user_contactmethods", "aistore_escrow_all_notification", 10, 1);

function aistore_escrow_user_notification($column)
{
    $column["notification_list"] = "Notification";
    return $column;
}

add_filter("manage_users_columns", "aistore_escrow_user_notification");

function aistore_escrow_user_notification_list($val, $column_name, $user_id)
{
    switch ($column_name) {
        case "notification_list":
            $url = admin_url(
                "admin.php?page=all_notification&id=" . $user_id,
                "https"
            );

            $link = '<a href="' . esc_url($url) . '">Notification</a>';

            return $link;

        default:
    }

    return $val;
}

add_filter(
    "manage_users_custom_column",
    "aistore_escrow_user_notification_list",
    10,
    3
);

?>
