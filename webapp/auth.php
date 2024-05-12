<?php
require "blocks.php";
?>

<?php
session_start_if_none();
if (!is_null(get_current_user_id())) {
    respond_with_redirect("/account.php");
    exit;
}

$new = false;
if (isset($_GET["new"])) {
    $new = boolval($_GET["new"]);
}
?>

<?php begin_common_page("Authentication"); ?>

<?php
    if ($new) {
        readfile("../components/register.html");
    } else {
        readfile("../components/login.html");
    }
?>

<?php end_common_page(); ?>