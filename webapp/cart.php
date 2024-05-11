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

Your items:</br>

<?php
foreach ($to_delete as $item_id) {
    echo "ITEM($item_id) no longer avaliable </br>";
}

$total = 0;
foreach (get_cart_items() as $item_id => $quant) {
    echo "<img width=100 height=100 src=\"/img/product/" . $items[$item_id]["img_url"] . "\"/>";
    echo " -- " . $items[$item_id]["name"];
    echo ": " . format_price($items[$item_id]["price"]) . " x $quant </br>";

    $total += $items[$item_id]["price"] * $quant;
}

echo "Your total: " . format_price($total);
?>

<?php end_common_page(); ?>