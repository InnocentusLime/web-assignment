<?php
require_once "session_utils.php";

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
 * Prints HTML code used to render a product item in a grid
 * @param array $item_data the item data. Required attributes: id, name, price, img_url
 * @return void
 */
function item_card($item_data) {
    echo "<article class=\"product-card\">";
    echo "<img src=\"img/product/" . $item_data["img_url"] . "\" alt=\"Product " .
            $item_data["id"] . "\"/>";
    echo "<h3>" . $item_data["name"] . "</h3>";
    echo "<a href=\"/product_page.php?item_id=" . $item_data["id"] .
            "\" class=\"button\">View Details</a>";
    echo "</article>";
}