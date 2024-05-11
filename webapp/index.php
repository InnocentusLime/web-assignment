<?php
require "blocks.php";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM test_table";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>

<?php begin_common_page("main"); ?>
<?php
echo '<p>Hello World! PHP WOOOORKS!!!! :)</p>';
if (!isset($_SESSION)) {
    echo "No session";
}
if (mysqli_num_rows($result) > 0) {
    // Outputting the data
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: " . $row["test_idx"] . " - amount: " . $row["amount"] . "</br>";
    }
} else {
    echo "0 results";
}
?>
<img src ="goth.jpg"/>

<?php end_common_page(); ?>