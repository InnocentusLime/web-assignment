<?php

require_once "blocks.php";

$dbconn;
$insert_item;

/**
 * Connects to the website database
 * @return void
 */
function connect_to_db() {
    global $dbconn;
    global $prod_name;
    global $prod_price;
    global $prod_desc;
    global $prod_img_url;
    global $insert_item;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hattrick";

    $dbconn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$dbconn) {
        respond_with_db_down();
        exit;
    }

    $insert_item = mysqli_prepare($dbconn, "INSERT INTO products(name, price, descr, img_url) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($insert_item, "siss", $prod_name, $prod_price, $prod_desc, $prod_img_url);
}

function disconnect_from_db() {
    if (!isset($dbconn)) {
        return;
    }

    mysqli_close($dbconn);
    unset($dbconn);
}

/**
 * Shortcut-function to report that the database is down
 */
function respond_with_db_down() {
    respond_with_just_code(500, "Database down");
}

/**
 * Gets item info by its ID.
 * @param int $item_id The item id
 * @return bool|array False if nothing found, data if item is found
 */
function get_item_info($item_id) {
    global $dbconn;

    $sql = "SELECT name, descr, price, img_url FROM products WHERE products.id = $item_id";
    $result = mysqli_query($dbconn,$sql);

    if (mysqli_num_rows($result) != 1) {
        return false;
    }

    return mysqli_fetch_assoc($result);
}

/**
 * Gets info for a tag.
 * @param int $tag_id The tag id
 * @return bool|array
 */
function get_tag_info($tag_id) {
    global $dbconn;

    $sql = "SELECT name, img_url FROM tags WHERE tags.id = $tag_id";
    $result = mysqli_query($dbconn,$sql);

    if (mysqli_num_rows($result) != 1) {
        return false;
    }

    return mysqli_fetch_assoc($result);
}

/**
 * Selects latest 10 items
 * @return array
 */
function get_latest_items10() {
    global $dbconn;

    $sql = "SELECT id, name, price, img_url from products order by id desc limit 10";
    $result = mysqli_query($dbconn, $sql);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Gets the latest used ID
 * @return int
 */
function get_next_item_id() {
    global $dbconn;

    $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = \"hattrick\"
            AND TABLE_NAME = \"products\"";
    $result = mysqli_query($dbconn, $sql);

    return mysqli_fetch_row($result)[0];
}

/**
 * Simply adds an item to the database. Unlike most function, this one is explicitly
 * resistent against SQL injections.
 * @param string $item_name
 * @param int $item_price
 * @param string $item_desc
 * @param string $img_url
 */
function insert_item_info($item_name, $item_price, $item_desc, $item_img) {
    global $dbconn;
    global $prod_name;
    global $prod_price;
    global $prod_desc;
    global $prod_img_url;
    global $insert_item;

    $prod_name = $item_name;
    $prod_price = $item_price;
    $prod_desc = $item_desc;
    $prod_img_url = $item_img;

    mysqli_stmt_execute($insert_item);
}