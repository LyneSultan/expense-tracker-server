<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$host="localhost";
$username="root";
$password="";
$db_name="expense";

$title=$_POST['title'];
$amount=$_POST['amount'];
$type=$_POST['type'];
$date=$_POST['date'];
$notes=$_POST['notes'];
$id=$_POST['id'];

$connection= new mysqli($host,$username,$password,$db_name);
if($connection->connect_error) die();

$query=$connection->prepare("UPDATE user_transactions set title=?,amount=?,type=?,date=?,notes=? where id=?");

$query->bind_param("sisssi", $title,$amount,$type,$date,$notes,$id);
$query->execute();

echo $title;

?>


