<?php
session_start();
include "db_conn.php";
$id=$_GET['id'];
$status=$_GET['status'];

$query="update staffs set status=$status where id=$id";
$result=mysqli_query($conn,$query);
if($result){
  header("Location: staff-list.php?success=Action saved");
  exit();
}else{
  header("Location: staff-list.php?success=Action Failed");
  exit();
}


 ?>
