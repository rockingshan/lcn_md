<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");	//redirect to index page if not logged in
}
//starting the connection to db
require_once "include/connect.php";
mysqli_select_db($con,$_SESSION['select_db']) or die("No database");

$new_lcn=$_POST['new_lcn'];
$edit_sid=$_POST['edit_sid'];

$get_hex_sql="SELECT lcnhex FROM `lcn_tb` WHERE lcn='$new_lcn' ";
$get_hex_row=mysqli_fetch_array(mysqli_query($con, $get_hex_sql));
$new_lcn_hex=$get_hex_row['lcnhex'];

$lcn_edit_sql="UPDATE channel_tb SET `lcn`='$new_lcn', `lcnhex`='$new_lcn_hex' WHERE sid='$edit_sid'";
$lcn_edit_result=mysqli_query($con, $lcn_edit_sql);
if ($lcn_edit_result) {
	header("location:secure_page.php");
	$_SESSION['sidcounter'][]=$edit_sid;
} else {
	 die('Invalid query: ' . mysqli_error());
}

?>