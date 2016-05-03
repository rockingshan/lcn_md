<?php
if (!isset($_SESSION['user'])) {
	header("location:index.php");	//redirect to index page if not logged in
}
//starting the connection to db
include("include/connect.php");

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
		<h1 align="center">Swap LCN here</h1>
	</head>
	
	<body>
		<form action="swap_process.php" method="post">
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
				<td colspan="3" align="center">
					<input type="hidden" name="old_sid" value="<?php echo $edit_row['sid']; ?>" />
					<input type="submit" value="Swap LCN" />
				</td>
			</tr>
			
		</table>
		</form>
		
		
		
	</body>
</html>