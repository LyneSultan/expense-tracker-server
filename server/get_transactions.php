<?php
header('Access-Control-Allow-Origin: *');
$host="localhost";
$username="root";
$password="";
$database_name="expense";
$connection= new mysqli($host,$username,$password,$database_name);
if($connection->connect_error)
{
  echo "error in the connection";
}
$transaction_id = $_GET["transaction_id"] ?? null;
$user_id = $_GET["user_id"]  ?? null ;

if($transaction_id==null){
  $query=$connection->prepare("SELECT * FROM user_transactions WHERE user_id=$user_id");
  $query->execute();
  $result = $query->get_result();


  if($result->num_rows >0){
      $allTransactions=[];

    while($row=$result->fetch_assoc()){
      $allTransactions[]=$row;
    }
    echo json_encode($allTransactions);
  }
  else{
    echo "empty table";
  }
}
else{
  $query=$connection->prepare("SELECT * FROM user_transactions WHERE id=$transaction_id");
  $query->execute();
  $result = $query->get_result();

  $transaction = $result->fetch_assoc();

  echo json_encode($transaction);
}

?>

