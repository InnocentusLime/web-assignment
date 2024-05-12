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

    $user_id = get_current_user_id();
    $user = get_user_info($user_id);
?>

<?php begin_common_page("Account"); ?>

<?php echo "Hello, " . $user["login"] . "<br/>"; ?>
<a href="javascript:void(0)" onClick="javascript:logout()">Logout</a>

<table>
    <thead>
        <tr>
            <th>date</th>
            <th>address</th>
            <th>delivery price</th>
            <th>full price</th>
            <th>state</th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach (get_user_orders($user_id) as $order) {
        echo "<tr>";
        echo "<td>" . $order["date"] . "</td>";
        echo "<td>" . $order["delivery_address"] . "</td>";
        echo "<td>" . $order["delivery_price"] . "</td>";
        echo "<td>" . "TODO" . "</td>";
        echo "<td>" . $order["state"] . "</td>";
        echo "</tr>";
    }
?>
    </tbody>
</table>

<?php end_common_page(); ?>