<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");	//redirect to index page if not logged in
}
//starting the connection to db
include("include/connect.php");


$swap_sid= $_POST['swap_sid'];
$new_sid= $_POST['new_sid'];

echo $swap_sid;
echo $new_sid;


?>