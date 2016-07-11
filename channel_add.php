<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");
	//redirect to index page if not logged in
}
//starting the connection to db
include ("include/connect.php");
include 'include/hex_maker.php';
include 'include/log.php';

$blank_lcn_sql = "SELECT * from lcn_tb WHERE lcn_tb.lcn NOT IN (SELECT lcn FROM channel_tb)";
$blank_lcn_result = mysqli_query($con, $blank_lcn_sql);
if (!$blank_lcn_result) {// add this check.
	die('Invalid query: ' . mysqli_error());
}
if (isset($_GET['edit_flag'])) {
	$new_name = $_GET['channel'];
	$new_sid = $_GET['sid'];
	$new_lcn = $_GET['new_lcn'];
	$new_lcn_hex = hex_convert($new_lcn);
	$new_sid_hex = hex_convert($new_sid);
    if($new_sid[1]==0){
        $new_ts = $new_sid[2];
    }else{
        $new_ts = $new_sid[1].$new_sid[2];
    }
	$sql1 = "INSERT INTO `channel_tb`(`sid`, `channel`, `lcn`, `lcnhex`) VALUES ('$new_sid','$new_name','$new_lcn','$new_lcn_hex')";
	$sql2 = "INSERT INTO `sid_tb` (`sid`, `ts`, `sidhex`) VALUES ('$new_sid','$new_ts','$new_sid_hex')";
    $sql3 = "INSERT INTO `package_tb`(`sid`, `bronze`, `silver`, `gold`, `platinum`, `power`, `price`) VALUES ('$new_sid','','','','','','')";
    $er_res = mysqli_query($con, $sql1);
    $er_res = mysqli_query($con, $sql2);
	$er_res = mysqli_query($con, $sql3);
	
	if (!$er_res) {// add this check.
		die('Invalid query: ' . mysqli_error($con));
	}
    
    $_SESSION['sidcounter'][]=$new_sid;
    write_log($new_sid." '".$new_name."' position ".$new_lcn." added");
header("location:secure_page.php");

}
?>


<html>
	<head>
		<link rel="icon" type="image/png" sizes="192x192"  href="images/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="/images/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="images/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
		<h1 align="center">Add New Channel</h1>
		<link rel="stylesheet" type="text/css" href="style/main.css" />
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato"  />
<script src="jquery/jquery-2.2.3.js"></script>
<script>
	$(document).on('keyup', '.numeric-only', function(event) {
		var v = this.value;
		if ($.isNumeric(v) === false) {
			//chop off the last char entered
			this.value = this.value.slice(0, -1);
		}
	});
	​​
</script>
	</head>
	
<body>
	<div align="center">
		<form action="channel_add.php" method="get">
		<table>
			<tr><td>New SID</td><td><input type="number" name="sid" class="numeric-only" maxlength="5" /></td></tr>
			<tr><td>New channel Name</td><td><input type="text" name="channel" class="cap_chn" />
			<tr><td>Select Posiiton</td><td><?php
			echo '<select name="new_lcn">';
			while ($blank_lcn_row = mysqli_fetch_array($blank_lcn_result)) {
				echo "<option value=" . $blank_lcn_row['lcn'] . ">" . $blank_lcn_row['genre'] . "   ||   " . $blank_lcn_row['lcn'] . "</option>";
			}
			echo "</select>";
						?></td></tr>
			</td></tr>
			<input type="hidden" name="edit_flag" value="1" />
			<tr><td colspan="2"><input type="submit" class="btn" name="submit" value="Add Channel" /><a href="secure_page.php"><input type="button" class="btn" name="edit" value="Get Back to Overview"></a></td></tr>
		</table>
		</form>
	</div>
	                                               
</body>
</html>