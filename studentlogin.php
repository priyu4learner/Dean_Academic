<?php
require 'connection.php';
$regno=$password=$iderror=$pswderror=$error='';
if (isset($_POST["submit"])) {
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
 }
$regno=test_input($_POST["regno"]);
$password=test_input($_POST["inputPassword"]);
$sql="SELECT * FROM student where regno='$regno' and password='$password'";
$result=mysqli_query($conn,$sql);
 //$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
 $count=mysqli_num_rows($result);
 if($count>0){
  echo "successful";
  $row=mysqli_fetch_assoc($result);
  $name=$row["name"];
  session_start();
  $_SESSION["id"]=$row["regno"];
  $_SESSION["name"]=$name;
  header("Location: student.php");
 }
 else{
  $error="You haven`t logged in.Check your id or password";
  header("Location: front.php");
 }
}
?>