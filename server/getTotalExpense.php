<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$connection = new mysqli("localhost", "root", "", "expense");

$user_id=$_POST['id'];

$query = $connection->prepare("SELECT SUM(amount) AS total_amount FROM user_transactions WHERE user_id = ? and type='Expense'");
$query->bind_param("i",$user_id);
$query->execute();

$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row['total_amount'];
    $response = ['status' => 'success', 'total_amount' => $total];
    echo json_encode( $response);
} else {
    echo "No data found";
}

?>
