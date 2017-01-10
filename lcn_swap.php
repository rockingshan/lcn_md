<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");	//redirect to index page if not logged in
}
//starting the connection to db
require_once "include/connect.php";
include 'include/log.php';
mysqli_select_db($con,$_SESSION['select_db']) or die("No database");

$swap_sid=$_GET['sid'];
$edit_sql= "SELECT * from channel_tb WHERE sid='$swap_sid'";
$edit_result = mysqli_query($con,$edit_sql);
if (!$edit_result) { // add this check.
    die('Invalid query: ' . mysqli_error());
}
$edit_row = mysqli_fetch_array($edit_result);

$swap_sql= "SELECT * from channel_tb WHERE sid<>'$swap_sid' ORDER BY lcn";
$swap_result=mysqli_query($con, $swap_sql);

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
		<h1 align="center">Swap LCN here</h1>
		<link rel="stylesheet" type="text/css" href="style/main.css" />
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato"  />
	</head>
	
	<body>
		<form action="./process/swap_process.php" method="post">
		<table align="center" cellspacing="3" cellpadding="3">
			<tr>
				<th>SID</th><th>CHANNEL</th><th>LCN</th>
			</tr>
			<tr>
				<td align="center"><?php echo $edit_row['sid'] ?></td>
				<td align="center"><?php echo $edit_row['channel'] ?></td>
				<td align="center"><?php echo $edit_row['lcn'] ?></td>	
			</tr>
			<tr align="center">
				<th></th><th>Select Swapping LCN</th>
			</tr>
			<tr>
				
				<td colspan="3" align="center">
					<?php
						echo '<select name="swap_sid">';
						while($swap_row=mysqli_fetch_array($swap_result))
						{
							echo "<option value=".$swap_row['sid'].">".$swap_row['sid']."   ||   ".$swap_row['channel']."   ||   ".$swap_row['lcn']."</option>";
						}
						echo "</select>";
						?>
				</td>
				</tr>
				<tr>
				<td colspan="1" align="center">
					<input type="hidden" name="old_sid" value="<?php echo $edit_row['sid']; ?>" />
					<input class="btn" type="submit" value="Swap LCN" />
				</td>
				<td align="center"><a href="secure_page.php"><input type="button" class="btn" name="edit" value="Overview"></a></td>
			</tr>
			
		</table>
		</form>
		
		
		
	</body>
</html>