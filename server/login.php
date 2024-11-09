<?php
header('Access-Control-Allow-Origin: *');
$connection= new mysqli("localhost","root","","expense");
if($connection->connect_error) die();

$name=$_GET['name'];
$password=$_GET['password'];


$query = $connection->prepare("SELECT * FROM users WHERE name=?");
$query->bind_param("s", $name);

$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $check=password_verify($password, $user['password']);

    if ($check) {
        echo json_encode($user);
    } else {
        echo "Invalid password";
    }


}
else echo "Invalid password";
?>
