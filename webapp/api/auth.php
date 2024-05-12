<?php

require_once "db_utils.php";

session_start_if_none();
if (get_current_user_id() != null) {
    respond_with_error("AUTH_API_LOGGED_IN");
    exit;
}

if (!isset($_GET["login"])) {
    respond_with_error("AUTH_API_NO_LOGIN");
    exit;
}

if (!isset($_GET["passwd"])) {
    respond_with_error("AUTH_API_NO_PASSWD");
    exit;
}

if (!isset($_GET["new"])) {
    respond_with_error("AUTH_API_NO_NEW_BIT");
    exit;
}

$login = $_GET["login"];
$passwd_raw = $_GET["passwd"];
$new = boolval($_GET["new"]);

connect_to_db();
$info = get_user_info_by_login($login);

if ($new) {
    if (!$info) {
        $res = register_user($login, $passwd_raw);
        unset($login);
        unset($passwd_raw);
        if ($res) {
            respond_with_json_ok("AUTH_API_REGISTER_OK");
        } else {
            respond_with_error("AUTH_API_BACKEND_ERROR");
        }
    } else {
        respond_with_error("AUTH_API_LOGIN_IN_USE");
    }
} else {
    $login_invalid_code = "AUTH_API_INVALID_LOGIN";
    if (!$info) {
        respond_with_error($login_invalid_code);
    } else {
        if (password_verify($passwd_raw, $info["passwd"])) {
            set_current_user_id($info["id"]);
            respond_with_json_ok("AUTH_API_LOGIN_OK");
        } else {
            respond_with_error($login_invalid_code);
        }
    }
}

disconnect_from_db();