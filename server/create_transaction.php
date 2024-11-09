<?php
$host = "localhost";
$username = "root";
$password = "";
$db_name = "expense";

$connection = new mysqli($host, $username, $password, $db_name);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

  /*$title = $_GET['title'];
  $amount=$_GET['amount'];
  $type=$_GET['type'];
  $date=$_GET['date'];
  $note=$_GET['notes'];*/

  $user_ID=(float)$_POST['userId'];
  $title = $_POST['title'];
  $amount = (float)$_POST['amount'];
  $type=$_POST['type'];
  $date=$_POST['date'];
  $note=$_POST['notes'];
  echo json_encode($user_ID);

  $query = $connection->prepare("INSERT INTO user_transactions (title, amount, type, date, notes,user_id) VALUES (?, ?, ?, ?, ?,?)");

  $query->bind_param("sdsssi", $title, $amount, $type, $date, $notes,$user_ID);

  if ($query->execute()) {
      echo $title;
  } else {
      echo "Error: " . $query->error;
  }
  echo json_encode($query);

?>
