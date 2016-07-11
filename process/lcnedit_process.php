<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");	//redirect to index page if not logged in
}
//starting the connection to db
require_once "../include/connect.php";
require_once "../include/hex_maker.php";
include '../include/log.php';


$new_lcn=$_POST['new_lcn'];
$edit_sid=$_POST['edit_sid'];

$new_lcn_hex=hex_convert($new_lcn);

$lcn_edit_sql="UPDATE channel_tb SET `lcn`='$new_lcn', `lcnhex`='$new_lcn_hex' WHERE sid='$edit_sid'";
$lcn_edit_result=mysqli_query($con, $lcn_edit_sql);
if ($lcn_edit_result) {
    write_log($edit_sid." updated lcn ".$new_lcn);
	header("location:../secure_page.php");
	$_SESSION['sidcounter'][]=$edit_sid;
} else {
	 die('Invalid query: ' . mysqli_error());
}

?>