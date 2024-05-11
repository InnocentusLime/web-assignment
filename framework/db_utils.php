<?php

require_once "blocks.php";

$dbconn;

/**
 * Connects to the website database
 * @return void
 */
function connect_to_db() {
    global $dbconn;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hattrick";

    $dbconn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$dbconn) {
        respond_with_db_down();
        exit;
    }
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