<?php
require "blocks.php";
?>

<?php begin_common_page("main"); ?>

<?php
foreach (get_cart_items() as $item_id => $quant) {
    echo "ITEM($item_id) x $quant </br>";
}
?>

Hello there!

<?php end_common_page(); ?>