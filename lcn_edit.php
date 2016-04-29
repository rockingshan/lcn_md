<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");	//redirect to index page if not logged in
}
//starting the connection to db
include("include/connect.php");
$edit_sid=$_GET['sid'];
$edit_sql= "SELECT * from channel_tb WHERE sid='$edit_sid'";
$edit_result = mysqli_query($con,$edit_sql);
if (!$edit_result) { // add this check.
    die('Invalid query: ' . mysqli_error());
}
$edit_row = mysqli_fetch_array($edit_result)

$blank_lcn_sql=""
?>

<html>
	<head>
		<h1 align="center">Edit LCN here</h1>
	</head>
	
	<body>
		<table align="center" cellspacing="3" cellpadding="3">
			<tr>
				<th>SID</th><th>CHANNEL</th><th>LCN</th>
			</tr>
			<tr>
				<td><?php echo $edit_row['sid'] ?></td>
				<td><?php echo $edit_row['channel'] ?></td>
				<td align="center"><?php echo $edit_row['lcn'] ?></td>
				
				
			</tr>
			
			
			
		</table>
		
		
		
		
	</body>
</html>