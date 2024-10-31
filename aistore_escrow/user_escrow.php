<?php

//
function aistore_users($contactmethods)
{
    $contactmethods["escrow_list"] = "Escrow";
    return $contactmethods;
}
add_filter("user_contactmethods", "aistore_users", 10, 1);

function aistore_user_escrow($column)
{
    $column["escrow_list"] = "Escrow";
    return $column;
}

add_filter("manage_users_columns", "aistore_user_escrow");

//This is function is used to  escrow list in all users page

function aistore_user_escrow_list($val, $column_name, $user_id)
{
    switch ($column_name) {
        case "escrow_list":
            $url = admin_url(
                "admin.php?page=escrow_list&id=" . $user_id,
                "https"
            );

            $link = '<a href="' . esc_url($url) . '">Escrow List</a>';

            return $link;

        default:
    }

    return $val;
}

add_filter("manage_users_custom_column", "aistore_user_escrow_list", 10, 3);
