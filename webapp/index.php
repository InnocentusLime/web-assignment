<!DOCTYPE html>

<?php
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

<html>
    <head>
        <title>PHP Test</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php echo '<p>Hello World! PHP WOOOORKS!!!!</p>'; ?>
        <?php
        // Checking if the query was successful
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
    </body>
</html>