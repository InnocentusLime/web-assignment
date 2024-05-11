<?php

require_once "blocks.php";

if (!isset($_GET["item_id"])) {
    respond_with_error("CART_API_NO_ITEM_ID");
    exit;
}

$item_id = intval($_GET["item_id"]);
session_start_if_none();

if (remove_from_cart($item_id)) {
    respond_with_json_ok(null);
} else {
    respond_with_error("CART_API_NO_SUCH_ITEM_IN_CART");
}