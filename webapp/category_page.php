<?php
require_once "blocks.php";
require_once "db_utils.php";
require_once "price_utils.php";
?>

<?php
if (!isset($_GET["tag_id"])) {
    respond_with_just_code(400, "No tag id given");
    exit;
}

connect_to_db();
$tag_id = intval($_GET["tag_id"]);
$tag_data = get_tag_info($tag_id);

if (!$tag_data) {
    respond_with_just_code(404, "Tag not found");
    exit;
}

$items = get_items_for_tag($tag_id);
disconnect_from_db();
?>

<?php begin_common_page("Category Page"); ?>

<section class="category">
    <h2 class="category-name"><?php echo $tag_data["name"] ?></h2>
    <div class="product-grid">
<?php
foreach ($items as $item) {
    item_card($item);
}
?>
    </div>
</section>

<?php end_common_page(); ?>