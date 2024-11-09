<?php
header('Access-Control-Allow-Origin: *');
$host = "localhost";
$username = "root";
$password = "";
$db_name = "expense";

$connection = new mysqli($host, $username, $password, $db_name);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$id = $_GET['id'];

$query = $connection->prepare("DELETE FROM user_transactions WHERE id=?;");
$query->bind_param("i", $id);

if ($query->execute()) {
    echo "Transaction deleted successfully!";
} else {
    echo "Error deleting transaction: " . $query->error;
}
?>
