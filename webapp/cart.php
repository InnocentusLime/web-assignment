<?php
require_once "db_utils.php";
require_once "price_utils.php";
?>

<?php
session_start_if_none();

$items = array();
$to_delete = array();

connect_to_db();
foreach (get_cart_items() as $item_id => $quant) {
    $item_data = get_item_info($item_id);
    if (!$item_data) {
        array_push($to_delete, $item_id);
    } else {
        $items[$item_id] = $item_data;
    }
}
disconnect_from_db();

foreach ($to_delete as $item_id) {
    nuke_from_cart($item_id);
}
?>

<?php begin_common_page("main"); ?>

<section class="cart">
<h2>My Cart</h2>
<div class="cart-info"/>
<?php
    foreach ($to_delete as $item_id) {
        echo "ITEM($item_id) no longer avaliable </br>";
    }
?>
    <div class="cart-items">
<?php
$total = 0;
foreach (get_cart_items() as $item_id => $quant) {
    cart_item($items[$item_id], $quant, $item_id, true);

    $total += $items[$item_id]["price"] * $quant;
}
?>
    </div>
    <div class="cart-total">
        <p>Total: <?php echo format_price($total) ?></p>
        <button class="button">Checkout</button>
    </div>
</section>

<?php end_common_page(); ?>