<?php
require_once "blocks.php";
require_once "db_utils.php";
require_once "price_utils.php";
?>

<?php
if (!isset($_GET["item_id"])) {
    respond_with_just_code(400, "No item id given");
    exit;
}

connect_to_db();
$item_id = intval($_GET["item_id"]);
$item_data = get_item_info($item_id);
disconnect_from_db();

if (!$item_data) {
    respond_with_just_code(404, "Item not found");
    exit;
}
?>

<?php begin_common_page("Product Page"); ?>

<article class="product">
<img src="/img/product/<?php echo $item_data["img_url"] ?>" alt="Product Image">
    <div class="product-details">
        <h2><?php echo $item_data["name"] ?></h2>
        <p><?php echo $item_data["descr"] ?></p>
        <p>Price: <?php echo format_price(intval($item_data["price"])) ?></p>
        <a class="button" href="/api/add_to_cart.php?item_id=<?php echo $item_id ?>">Add to Cart</a>
    </div>
</article>

<?php end_common_page(); ?>