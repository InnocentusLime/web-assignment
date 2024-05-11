<?php

require_once "blocks.php";

if (!isset($_GET["item_id"])) {
    respond_with_error("CART_API_NO_ITEM_ID");
}

$item_id = intval($_GET["item_id"]);
session_start_if_none();
add_to_cart($item_id);
respond_with_json_ok(null);