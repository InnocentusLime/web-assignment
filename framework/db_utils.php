<?php

require_once "blocks.php";

$dbconn;
$insert_user;
$get_user_by_login;
$insert_item;

/**
 * Connects to the website database
 * @return void
 */
function connect_to_db() {
    global $dbconn;
    global $insert_user;
    global $get_user_by_login;
    global $user_login;
    global $user_id;
    global $user_passwd;
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
    $insert_user = mysqli_prepare($dbconn, "INSERT INTO users(login, passwd) VALUES (?, ?)");
    mysqli_stmt_bind_param($insert_user, "ss", $user_login, $user_passwd);
    $get_user_by_login = mysqli_prepare($dbconn, "SELECT id, passwd FROM users WHERE login = ?");
    mysqli_stmt_bind_param($get_user_by_login, "s", $user_login);
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
 * @return array Array where each item is an assoc array
 */
function get_latest_items10() {
    global $dbconn;

    $sql = "SELECT id, name, price, img_url from products order by id desc limit 10";
    $result = mysqli_query($dbconn, $sql);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Selects all items from the specified category
 * @return array Array where each item is an assoc array
 */
function get_items_for_tag($tag_id) {
    global $dbconn;

    $sql = "SELECT p.id, p.name, p.price, p.img_url from products p
            JOIN product_tagging pt ON p.id = pt.product_id
            JOIN tags t ON t.id = pt.tag_id
            WHERE t.id = $tag_id";
    $result = mysqli_query($dbconn, $sql);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Gets the user from the database. This function does NOT compromise
 * much about the user. The only valuable piece of information from user
 * table is the admin bit and it is not fetched by this function.
 * @return bool|array
 */
function get_user_info($user_id) {
    global $dbconn;

    $sql = "SELECT login,passwd FROM users WHERE id=$user_id";
    $result = mysqli_query($dbconn, $sql);

    if (mysqli_num_rows($result) != 1) {
        return false;
    }

    return mysqli_fetch_assoc($result);
}

/**
 * Consults the current session and database to see if the user is logged in.
 * If the user id in the session does not exist in the database -- the function
 * clear the user id.
 */
function check_login_or_nuke() {
    global $dbconn;

    $user_id = get_current_user_id();
    if (is_null($user_id)) {
        return false;
    }

    if (!get_user_info($user_id)) {
        nuke_session_user();
        return false;
    }

    return true;
}

/**
 * Fetches user by login. This function has SQL injection protection
 * @param string The login
 * @return array|bool
 */
function get_user_info_by_login($login) {
    global $dbconn;
    global $get_user_by_login;
    global $user_login;

    $user_login = $login;
    mysqli_stmt_execute($get_user_by_login);
    $result = mysqli_stmt_get_result($get_user_by_login);

    if (mysqli_num_rows($result) != 1) {
        return false;
    }

    return mysqli_fetch_assoc($result);
}

/**
 * Registers the user by adding them to the database.
 * @param string $login The login
 * @param string $passwd_raw The raw password
 * @return bool
 */
function register_user($login, $passwd_raw) {
    global $dbconn;
    global $insert_user;
    global $user_login;
    global $user_passwd;

    $user_login = $login;
    $user_passwd = password_hash($passwd_raw, PASSWORD_DEFAULT);
    unset($passwd_raw);

    mysqli_stmt_execute($insert_user);
    $result = mysqli_stmt_get_result($insert_user);

    if (!$result && mysqli_errno($dbconn) != 0) {
        return false;
    }

    return true;
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