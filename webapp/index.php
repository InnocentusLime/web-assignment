<?php
require "db_utils.php";
?>

<?php begin_common_page("main"); ?>

<?php connect_to_db(); ?>

<!-- Cover Page -->
<section class="cover-image">
    <img src="/img/cover-image.jpg" alt="Magazine Cover Image">
</section>
<section class="cover-page">
    <h2>Welcome to the Hattrick Magazine!</h2>
    <p>Discover the latest trends in hats, caps, and panamas.</p>
    <a href="#" class="button">Explore Now</a>
</section>

<!-- Recent Products -->
<section class="recent-products">
    <h2>Recent Products</h2>
    <div class="product-grid">
<?php
    foreach (get_latest_items10() as $item) {
        item_card($item);
    }
?>
    </div>
</section>

<!-- Products by Categories -->
<section class="products-by-categories">
    <h2>Products by Categories</h2>
    <div class="category-grid">
<?php
    $main_tags = array(3, 4);
    foreach ($main_tags as $tag_id) {
        $tag_data = get_tag_info($tag_id);
        if (!$tag_data) {
            continue;
        }
        echo "<article class=\"category-block\">";
        echo "<h3>" . $tag_data["name"] . "</h3>";
        echo "<img src=\"img/tag/" . $tag_data["img_url"] . "\" alt=\"" .
                $tag_data["name"] . "Products" . "\"/>";
        echo "<a href=\"/category_page.php?tag_id=" . $tag_id . "\" class=\"button\">Explore</a>";
        echo "</aritcle>";
    }
?>
    </div>
</section>

<?php disconnect_from_db(); ?>

<?php end_common_page(); ?>