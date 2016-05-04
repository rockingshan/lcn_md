<?php
session_start();
$_SESSION['sidcounter']=array();
//starting the connection to db
require_once "include/connect.php";

$user=$_POST['user'];
$pass=$_POST['pass'];

$sql_submit="SELECT * from auth_tb WHERE user='$user' and pass='$pass'";
$res_submit=mysqli_query($con,$sql_submit);
$res_data=mysqli_fetch_array($res_submit);
if ($res_data) {
	$_SESSION['user']=$user;
	$_SESSION['pass']=$pass;
	header("location:secure_page.php");
} else {
	echo "Wrong username/password";
	
}


?>