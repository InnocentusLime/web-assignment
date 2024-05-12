<?php
require_once "session_utils.php";
require_once "price_utils.php";

/**
 * Just to begin the html
 * @param string $title Page title
 * @return void
 */
function begin_common_html_with_head($title = "") {
    echo "<!DOCTYPE html>";
    echo "<html lang=\"en\"><head>";
    readfile("../components/preamble.html");
    echo "<title>$title</title>";
    echo "</head>";
    echo "<body>";
}

/**
 * Just to end the html
 * @return void
 */
function end_common_html() {
    echo "</body>";
    echo "</html>";
}

/**
 * Does some repeatable things like adding the html opening, creating
 * a session, opening the main tag and adding a header.
 * @param string $title Page title
 * @return void
 */
function begin_common_page($title = "") {
    begin_common_html_with_head($title);
    readfile("../components/header.html");
    echo "<main>";
    session_start_if_none();
}

/**
 * Closes all the tags opened by begin_common_page
 * @return void
 */
function end_common_page() {
    echo "</main>";
    readfile("../components/footer.html");
    end_common_html();
}

/**
 * Instead of constructing an HTML page, allows you to
 * respond with a JSON string, that indicates success.
 * @param mixed $data The data to serialise
 * @return void
 */
function respond_with_json_ok($data) {
    $body = array();
    $body["status"] = "ok";
    $body["data"] = $data;

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($body);
}

/**
 * Instead of constructing an HTML page, allows you to
 * respond with a JSON string, that indicates failure.
 * @param string $err_code The error code
 * @return void
 */
function respond_with_error($err_code) {
    $body = array();
    $body["status"] = "err";
    $body["code"] = $err_code;

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($body);
}

/**
 * Shortcut to send just a status code and nothing else.
 * @param int $status The status code
 * @param string $extra Specify the extra
 * @return void
 */
function respond_with_just_code($status, $extra = "") {
    header($_SERVER["SERVER_PROTOCOL"] . " $status " . $extra);
}

/**
 * Redirects the user to a different url
 * @param string $url the new url
 * @return void
 */
function respond_with_redirect($url) {
    header('Location: '. $url);
}

/**
 * Prints HTML code used to render a product item in a grid
 * @param array $item_data the item data. Required attributes: id, name, price, img_url
 * @return void
 */
function item_card($item_data) {
    echo "<article class=\"product-card\">";
    echo "<div class=\"product-card-img\">";
    echo "<img src=\"img/product/" . $item_data["img_url"] . "\" alt=\"Product " .
            $item_data["id"] . "\"/>";
    echo "</div>";
    echo "<h3>" . $item_data["name"] . "</h3>";
    echo "<a href=\"/product_page.php?item_id=" . $item_data["id"] .
            "\" class=\"button\">View Details</a>";
    echo "</article>";
}

/**
 * Prints HTML code used to render a cart item
 * @param array $item_data The item data. Required attributes: id, name, price, img_url
 * @param int $quant Item quanity
 * @param int $item_id Item id in the DB
 * @param bool $for_cart If the item is rendered for the cart
 * @return void
 */
function cart_item($item_data, $quant, $item_id, $for_cart) {
    echo "<div class=\"cart-item\">";
    echo "<img src=\"/img/product/" . $item_data["img_url"] . "\"/>";
    echo "<div class=\"item-details\">";
    echo "<h3>" . $item_data["name"] . "</h3>";
    echo "<p>Price: " . format_price($item_data["price"]) . " x " . $quant . "</p>";
    if ($for_cart) {
        echo "<a class=\"button\" href=\"javascript:void(0)\" onClick=\"javascript:remove_from_cart(" . $item_id . ")\">Remove</a>";
    } else {
        echo "<a class=\"button\" href=\"/product_page.php?item_id=" . $item_id . "\">View</a>";
    }
    echo "</div>";
    echo "</div>";
}