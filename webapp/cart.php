<?php
require_once "blocks.php";
?>

<?php begin_common_page("main"); ?>

Your items:

<?php
foreach (get_cart_items() as $item_id => $quant) {
    echo "ITEM($item_id) x $quant </br>";
}
?>

<?php end_common_page(); ?>