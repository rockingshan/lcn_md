<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");	//redirect to index page if not logged in
}
//starting the connection to db
include("include/connect.php");
include 'include/log.php';
$edit_sid=$_GET['sid'];
$edit_sql= "SELECT * from channel_tb WHERE sid='$edit_sid'";
$edit_result = mysqli_query($con,$edit_sql);
if (!$edit_result) { // add this check.
    die('Invalid query: ' . mysqli_error());
}
$edit_row = mysqli_fetch_array($edit_result);

$blank_lcn_sql="SELECT * from lcn_tb WHERE lcn_tb.lcn NOT IN (SELECT lcn FROM channel_tb)";
$blank_lcn_result=mysqli_query($con,$blank_lcn_sql);
if (!$blank_lcn_result) { // add this check.
    die('Invalid query: ' . mysqli_error());
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
		<h1 align="center">Edit LCN here</h1>
		<link rel="stylesheet" type="text/css" href="style/main.css" />
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato"  />
	</head>
	
	<body>
		<form action="./process/lcnedit_process.php" method="post">
			<div class="datagrid">
		<table align="center" cellspacing="3" cellpadding="3">
			<tr>
				<th>SID</th><th>CHANNEL</th><th>LCN</th>
			</tr>
			<tr>
				<td align="center"><?php echo $edit_row['sid'] ?></td>
				<td align="center"><?php echo $edit_row['channel'] ?></td>
				<td align="center"><?php echo $edit_row['lcn'] ?></td>	
				<td align="center"><a href="lcn_name_edit.php?sid='<?php echo $edit_row['sid'] ?>'"><input type="button" class="btn" name="edit" value="Edit Name"></a></td>
			</tr>
			<tr align="center">
				<th></th><th>Select new LCN</th>
			</tr>
			<tr>
				<td></td>
				<td>
					<?php
						echo '<select name="new_lcn">';
						while($blank_lcn_row=mysqli_fetch_array($blank_lcn_result))
						{
							echo "<option value=".$blank_lcn_row['lcn'].">".$blank_lcn_row['genre']."   ||   ".$blank_lcn_row['lcn']."</option>";
						}
						echo "</select>";
						?>
				</td>
				<td>
					<input type="hidden" name="edit_sid" value="<?php echo $edit_row['sid']; ?>" />
					<input type="submit" class="btn" value="Change LCN" />
				</td>
				<td align="center"><a href="secure_page.php"><input type="button" class="btn" name="edit" value="Get Back to Overview"></a></td>
			</tr>
			
		</table>
		</div>
		</form>
		
		
		
	</body>
</html>