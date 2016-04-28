<?php
//starting the connection to db
include("include/connect.php");

$user=$_POST['user'];
$pass=$_POST['pass'];
echo $_POST['user'];
echo $pass;

$sql_submit="SELECT * from auth_tb WHERE user='$user' and pass='$pass'";
echo $sql_submit;
$res_submit=mysqli_query($con,$sql_submit);
if ($res_submit) {
	session_register("user");
	session_register("pass");
	header("location:secure_page.php");
	
} else {
	echo "Wrong username/password";
	
}


?>