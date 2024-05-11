<?php

/**
 * Populates the session with default values
 * @return void
 */
function session_defaults() {
    $_SESSION["start"] = 0;
    $_SESSION["cart"] = [];
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