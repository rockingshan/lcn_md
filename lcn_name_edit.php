<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");	//redirect to index page if not logged in
}
//starting the connection to db
require_once "include/connect.php";
include 'include/log.php';
if (isset($_GET['edit_flag'])){
	$new_name=$_GET['new_name'];
	$old_sid=$_GET['editname_sid'];
	$name_update_sql="UPDATE channel_tb SET channel='$new_name' WHERE sid='$old_sid'";
	$editname_result=mysqli_query($con,$name_update_sql);
	if (!$editname_result) { // add this check.
    die('Error: ' . mysqli_error($con));
    }
    write_log($old_sid." name changed to '".$new_name."'");
	header("location:lcn_edit.php?sid=$old_sid");
}else{
$edit_sid=$_GET['sid'];
$editname_sql= "SELECT * from channel_tb WHERE sid=$edit_sid";
$editname_result = mysqli_query($con,$editname_sql);
if (!$editname_result) { // add this check.
    die('Error: ' . mysqli_error($con));
}
$editname_row = mysqli_fetch_array($editname_result);
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
		<link rel="stylesheet" type="text/css" href="style/main.css" />
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato"  />
		<h1 align="center">Edit Channel Name here</h1>
		<script type="text/javascript">
alert("Changing name here will not update name in PSI/SI. You will have to update name again in PSI/SI");
</script>
	</head>
	
	<body><form action="lcn_name_edit.php" method="get">
		<table align="center">
			<tr>
				<th>Old Channel Name</th><th>New channel Name</th>
			</tr>
			<tr>
				<td align="center"><?php echo $editname_row['channel'] ?></td>
				<td align="center"><input type="text" name="new_name"/></td>
				<input type="hidden" name="editname_sid" value="<?php echo $editname_row['sid']; ?>" />
				<input type="hidden" name="edit_flag" value="1" />
				<td align="center"><input type="submit" value="Change Name" /></td>
			</tr>
		</table>
		</form>
</body>
</html>