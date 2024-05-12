<?php

/**
 * Populates the session with default values
 * @return void
 */
function session_defaults() {
    $_SESSION["start"] = 0;
    $_SESSION["user_id"] = null;
    $_SESSION["cart"] = [];
}

/**
 * Empties the cart
 * @return void
 */
function empty_cart() {
    $_SESSION["cart"] = [];
}

/**
 * Resets session user to null. This effectively logs
 * the user out.
 * @return void
 */
function nuke_session_user() {
    $_SESSION["user_id"] = null;
}

/**
 * Gets current user id. Note that it is not guaranteed to be
 * a valid user id.
 * @return int|null
 */
function get_current_user_id() {
    return $_SESSION["user_id"];
}

/**
 * Sets current user id. As you can see, it is pretty easy. So
 * please do not trust the user id.
 * @param int $user_id
 */
function set_current_user_id($user_id) {
    $_SESSION["user_id"] = $user_id;
}

/**
 * Makes sure the session is setup
 * @return void
 */
function session_start_if_none() {
    if (isset($_SESSION)) {
        return;
    }

    session_start(); assert(isset($_SESSION));

    if (!isset($_SESSION["start"])) {
        session_defaults();
    }
}

/**
 * Adds an item to cart
 * @param int $item_id the item id
 * @return void
 */
function add_to_cart($item_id) {
    if (isset($_SESSION["cart"][$item_id])) {
        $_SESSION["cart"][$item_id] += 1;
        return;
    }

    $_SESSION["cart"][$item_id] = 1;
}

/**
 * Gets all items in the cart
 * @return array
 */
function get_cart_items() {
    if (isset($_SESSION["cart"])) {
        return $_SESSION["cart"];
    }

    return [];
}

/**
 * Completely cuts the item out of the cart, ignoring the quanitity.
 * @return void
 */
function nuke_from_cart($item_id) {
    if (isset($_SESSION["cart"][$item_id])) {
        unset($_SESSION["cart"][$item_id]);
    }
}

/**
 * Removes an item from the cart
 * @param int $item_id the item id
 * @return bool true on success, false if there
 *              was no such item in the cart
 */
function remove_from_cart($item_id) {
    if (isset($_SESSION["cart"][$item_id])) {
        $_SESSION["cart"][$item_id] -= 1;
        if ($_SESSION["cart"][$item_id] == 0) {
            unset($_SESSION["cart"][$item_id]);
        }

        return true;
    }

    return false;
}