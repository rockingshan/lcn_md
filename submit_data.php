<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");	//redirect to index page if not logged in
}
//starting the connection to db
require_once "include/connect.php";

$ts_array=array();
$sid_un_array=array_unique($_SESSION['sidcounter']);
foreach($sid_un_array as $sid_value){
	$sid_sql="SELECT ts from sid_tb WHERE sid=$sid_value";
	$sid_result=mysqli_query($con, $sid_sql);
	$sid_res_row=mysqli_fetch_array($sid_result);
	$sid_array[]=$sid_res_row['ts'];
	
}

$ts_un_array=array_unique($sid_array);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato"  />
<script src="https://cdn.jsdelivr.net/clipboard.js/1.5.10/clipboard.min.js"></script>
<title>LCN submit data</title>
<script>(function(){
    new Clipboard('siddata');
})();</script> 
</head>
<body>
	
	<table align="center">
		<tr><th>TS Number</th><th>BAT Submition data</th></tr>
		
<?php
foreach($ts_un_array as $ts_value){
	$sidlcnout="";
	$ts_sql="SELECT sid FROM sid_tb WHERE ts=$ts_value";
	$ts_result=mysqli_query($con,$ts_sql);
	
	while($ts_res_row=mysqli_fetch_array($ts_result)){
		$sidlcn_sql="SELECT * from channel_tb,sid_tb WHERE channel_tb.sid='".$ts_res_row['sid']."' AND sid_tb.sid='".$ts_res_row['sid']."'";
		$sidlcn_result=mysqli_query($con,$sidlcn_sql);
		$sidlcn_row=mysqli_fetch_array($sidlcn_result);
		$sidlcnout=$sidlcnout.$sidlcn_row['sidhex']." ".$sidlcn_row['lcnhex']." ";
			}
	echo "<tr><td>".$ts_value;
	echo "<td id='siddata'>".$sidlcnout."</tr>";
}
?>
</table>
</body>
</html>