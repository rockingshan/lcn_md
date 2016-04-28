<?php
session_start();
//starting the connection to db
include("include/connect.php");

$user=$_POST['user'];
$pass=$_POST['pass'];

$sql_submit="SELECT * from auth_tb WHERE user='$user' and pass='$pass'";
$res_submit=mysqli_query($con,$sql_submit);
if ($res_submit) {
	$_SESSION['user']=$user;
	$_SESSION['pass']=$pass;
	header("location:secure_page.php");
	
} else {
	echo "Wrong username/password";
	
}


?>