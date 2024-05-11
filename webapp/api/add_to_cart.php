<?php

require_once "db_utils.php";

if (!isset($_GET["item_id"])) {
    respond_with_error("CART_API_NO_ITEM_ID");
    exit;
}

$item_id = intval($_GET["item_id"]);

connect_to_db();
if (!get_item_info($item_id)) {
    respond_with_error("CART_API_NO_SUCH_ITEM");
    exit;
}
disconnect_from_db();

session_start_if_none();
add_to_cart($item_id);
respond_with_json_ok(null);