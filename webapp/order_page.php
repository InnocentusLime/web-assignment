<?php
    require_once "db_utils.php";
    require_once "blocks.php";
    require_once "price_utils.php";
?>

<?php
    if (!isset($_GET["order_id"])) {
        respond_with_just_code(400, "No order id given");
        exit;
    }

    session_start_if_none();
    connect_to_db();
    check_login_or_nuke();

    $user_id = get_current_user_id();
    $order_id = intval($_GET["order_id"]);
    $order_data = get_order_info($order_id);

    if ($order_data != false && !is_null($order_data["user"]) && is_null($user_id)) {
        respond_with_redirect("/auth.php");
        exit;
    }

    $order_items = get_order_items($order_id);
    if (!$order_items) {
        respond_with_just_code(500, "Order query error");
        exit;
    }
?>

<?php begin_common_page("Order Page"); ?>

<?php
$invalid_order_msg = "Invalid order id";
$good = false;
if (!$order_data) {
    echo $invalid_order_msg;
} else if (is_null($order_data["user"])) {
    echo $invalid_order_msg;
} else if (is_null($user_id)) {
    echo $invalid_order_msg;
} else if ($user_id != $order_data["user"]) {
    echo $invalid_order_msg;
} else {
    $good = true;
}
?>

<section class="cart">
<h2>My Order</h2>
<div class="cart-info"/>
    <div class="cart-items">
<?php
foreach ($order_items as $order_item) {
    $item_id = $order_item["product_id"];
    $quant = $order_item["quant"];
    $item_data = get_item_info($item_id);
    if (!$item_data) {
        // TODO better response to item absense
        continue;
    }
    cart_item($item_data, $quant, $item_id, false);
}
?>
    </div>
    <div class="cart-total">
        <p class="ship-address">Address: <?php echo $order_data["delivery_address"] ?></p>
        <p>Delivery: <?php echo format_price($order_data["delivery_price"]) ?></p>
        <p>Total: <?php echo format_price(get_order_price($order_id)) ?></p>
    </div>
</section>

<?php end_common_page(); ?>