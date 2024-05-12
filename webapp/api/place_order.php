<?php

require_once "db_utils.php";

if (!isset($_GET["delivery_address"])) {
    respond_with_error("ORDER_API_NO_ADDRESS");
    exit;
}
$delivery_address = $_GET["delivery_address"];

session_start_if_none();
connect_to_db();

$user = get_current_user_id();
if (!check_login_or_nuke()) {
    $user = null;
}

$good = true;
if (!add_order($user, 2000, $delivery_address)) {
    $good = false;
    respond_with_error("ORDER_API_START_ERROR");
}
$order_id = get_last_insert();

if ($good) {
    // TODO properly check item precense
    foreach (get_cart_items() as $item_id => $quant) {
        if (!add_order_item($order_id, $item_id, $quant)) {
            $good = false;
            respond_with_error("ORDER_API_ITEM_ERROR");
            break;
        }
    }
}

if ($good) {
    commit_transaction();

    $result = array();
    $result["order_id"] = $order_id;
    respond_with_json_ok($result);
} else {
    abort_transaction();
}

disconnect_from_db();
empty_cart();