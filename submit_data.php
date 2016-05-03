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
	$sid_result=mysqli_query($con, $sid_sql);
	$sid_res_row=mysqli_fetch_array($sid_result);
	$sid_array[]=$ts_res_row['ts'];
	
}

$ts_un_array=array_unique($sid_array);

foreach($ts_un_array as $ts_value){
	$ts_sql="SELECT * FROM sid_tb WHERE ts=$ts_value";
	$ts_result=mysqli_result($con,$ts_sql);
	$ts_res_row=mysqli_fetch_array($ts_result);
	
	
	
	
}

?>