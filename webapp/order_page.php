<?php
    require_once "db_utils.php";
    require_once "blocks.php";
    require_once "price_utils.php";
?>

<?php
    if (!isset($_GET["order_id"])) {
        respond_with_just_code(400, "No order id given");
        exit;
    }

    session_start_if_none();
    connect_to_db();
    check_login_or_nuke();

    $user_id = get_current_user_id();
    $order_id = intval($_GET["order_id"]);
    $order_data = get_order_info($order_id);

    if ($order_data != false && !is_null($order_data["user"]) && is_null($user_id)) {
        respond_with_redirect("/auth.php");
        exit;
    }
?>

<?php begin_common_page("Order Page"); ?>

<?php
$invalid_order_msg = "Invalid order id";
if (!$order_data) {
    echo $invalid_order_msg;
} else if (is_null($order_data["user"])) {
    echo $invalid_order_msg;
} else if (is_null($user_id)) {
    echo $invalid_order_msg;
} else if ($user_id != $order_data["user"]) {
    echo $invalid_order_msg;
} else {
    echo "Nice";
}
?>

<?php end_common_page(); ?>