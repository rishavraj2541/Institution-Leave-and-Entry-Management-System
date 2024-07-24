<?php
session_start();
include "db_conn.php";
$id=$_GET['id'];
$status=$_GET['status'];

$query="update students set status=$status where id=$id";
$result=mysqli_query($conn,$query);
if($result){
  header("Location: admin_dashboard.php?success=Action saved");
  exit();
}else{
  header("Location: admin_dashboard.php?success=Action Failed");
  exit();
}


 ?>
