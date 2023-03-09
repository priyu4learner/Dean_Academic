<?php
require 'connection.php';
$emplid=$password=$iderror=$pswderror=$error='';
if (isset($_POST["submit"])) {
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
 }
  $emplid=test_input($_POST["emplid"]);
  $password=test_input($_POST["inputPassword"]);
 $sql="SELECT * FROM admin where id='$emplid' and pswd='$password'";
 $result=mysqli_query($conn,$sql);
 //$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
 $count=mysqli_num_rows($result);
 if($count>0){
  echo "successful";
  $row=mysqli_fetch_assoc($result);
  $name=$row["name"];
  session_start();
  $_SESSION["id"]=$row["id"];
  $_SESSION["name"]=$name;
  header("Location: admin.php");
 }
 else{
  $error="You haven`t logged in.Check your id or password";
  header("Location: front.php");
 }
}
?>