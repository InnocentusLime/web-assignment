<?php
require_once "blocks.php";
require_once "db_utils.php"
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

foreach (get_cart_items() as $item_id => $quant) {
    echo "<img width=100 height=100 src=\"/img/product/" . $items[$item_id]["img_url"] . "\"/>";
    echo " -- " . $items[$item_id]["name"];
    echo " x $quant </br>";
}
?>

<?php end_common_page(); ?>