<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");	//redirect to index page if not logged in
}
//starting the connection to db
include("include/connect.php");

$ts_array=array();
$sid_un_array=array_unique($_SESSION['sidcounter']);

foreach($sid_un_array as $sid_value){
	$sid_sql="SELECT ts from sid_tb WHERE sid=$sid_value";
	$ts_result=mysqli_query($con, $sid_sql);
	$ts_res_row=mysqli_fetch_array($ts_result);
	$ts_array[]=$ts_res_row['ts'];
	
}

$ts_un_array=array_unique($ts_array);


?>