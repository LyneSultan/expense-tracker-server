<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST,GET');

$connection= new mysqli("localhost","root","","expense");
if($connection->connect_error) die();

$name=$_GET['name'];
$password=$_GET['password'];

$hashed=password_hash($password,PASSWORD_DEFAULT);

$query = $connection->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
$query->bind_param("ss", $name, $hashed);

$query->execute();
echo $connection->insert_id;

?>
