<?php
require_once "db_utils.php";
?>

<?php begin_common_page("main"); ?>

<?php connect_to_db(); ?>

<!-- Cover Page -->
<section class="cover-image">
    <!-- <img src="/img/cover-img.png" alt="Shop Cover Image"> -->
</section>
<section class="cover-page">
    <h2>Welcome to the Hattrick Shop!</h2>
    <p>Discover the all possible trends in hats, caps, and panamas!</p>
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
        echo "<div class=\"category-block-img\">";
        echo "<img src=\"img/tag/" . $tag_data["img_url"] . "\" alt=\"" .
                $tag_data["name"] . "Products" . "\"/>";
        echo "</div>";
        echo "<h3>" . $tag_data["name"] . "</h3>";
        echo "<a href=\"/category_page.php?tag_id=" . $tag_id . "\" class=\"button\">Explore</a>";
        echo "</article>";
    }
?>
    </div>
</section>

<?php disconnect_from_db(); ?>

<?php end_common_page(); ?>