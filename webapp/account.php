<?php
require "db_utils.php";
?>

<?php
    session_start_if_none();
    connect_to_db();
    check_login_or_nuke();

    if (is_null(get_current_user_id())) {
        respond_with_redirect("/auth.php");
        exit;
    }

    $user = get_user_info(get_current_user_id())
?>

<?php begin_common_page("Account"); ?>

<?php echo "Hello, " . $user["login"] . "<br/>"; ?>
<a href="/api/logout.php">Logout</a>

<?php end_common_page(); ?>