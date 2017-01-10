<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
session_start();

if (!isset($_SESSION['user'])) {
	header("location:index.php");	
}
if(isset($_POST['selectdb'])){
if ($_POST['selectdb']=='db_1') {
  $_SESSION['select_db'] = 'meghbela_lcn_db_alpha';
  $_SESSION['city'] = 'Kolkata';
}elseif ($_POST['selectdb']=='db_2') {
  $_SESSION['select_db'] = 'meghbela_lcn_db_bpc';
  $_SESSION['city'] = 'Berhampore';
}elseif ($_POST['selectdb']=='db_3') {
  $_SESSION['select_db'] = 'meghbela_lcn_db_hlz';
  $_SESSION['city'] = 'Haldia';
}elseif ($_POST['selectdb']=='db_4') {
  $_SESSION['select_db'] = 'meghbela_lcn_db_bqa';
  $_SESSION['city'] = 'Bankura';
}
}
//starting the connection to db
require_once "include/connect.php";
include 'include/log.php';
//Seleceting the database

mysqli_select_db($con,$_SESSION['select_db']) or die("No database");
//making the search in db
$sql = "SELECT * FROM channel_tb,lcn_tb WHERE channel_tb.lcn=lcn_tb.lcn ORDER BY lcn_tb.lcn";

//an alternative query
//$sql2 = "SELECT lcn_tb.genre,lcn_tb.lcn,channel_tb.channel FROM lcn_tb LEFT JOIN channel_tb ON lcn_tb.lcn=channel_tb.lcn";

$result = mysqli_query($con,$sql);
if (!$result) { // add this check.
    die('Invalid query: ' . mysqli_error());
}
?>
<link rel="icon" type="image/png" sizes="192x192"  href="images/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
<link rel="manifest" href="/images/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="images/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
<link rel="stylesheet" type="text/css" href="style/menustyle.css" />

<script src="jquery/jquery-2.2.3.js"></script>
<script>
function confirmAction(){
      var confirmed = confirm("Are you sure? This will remove this entry forever.");
      return confirmed;
}
</script>
<title>LCN edit Mode</title>


</head>

<body>
<table align="left" class="auth">
<tr>
	<td align="left" valign="top" class="authtd">
		User logged in: <?php {echo $_SESSION['user'];} ?>
	</td>
	<td align="left" valign="top" class="authtd">
		<a href="logout.php"><input type="submit" name="logout" value="Logout"  /></a>
	</td>
</tr>
<tr><td style="font-weight:bold;font-size:20px;">Current city : <?php echo $_SESSION['city'] ?></td></tr>
<tr><td><a href="export.php">Export LCN</a></td></tr>
<tr><td><a href="export_package.php?par=bronze">Export Bronze package</a></td></tr>
<tr><td><a href="export_package.php?par=silver">Export Silver package</a></td></tr>
<tr><td><a href="export_package.php?par=gold">Export Gold package</a></td></tr>
<tr><td><a href="export_package.php?par=platinum">Export Platinum package</a></td></tr>
<tr><td><a href="export_package.php?par=power">Export Power package</a></td></tr>
<tr><td><a href="submit_data.php">Get BAT Submition data</a></td></tr>
<tr><td><a href="channel_add.php">Add a new channel</a></td></tr>
<tr><td><a href="create_master.php">Create LCN Master file</a></td></tr>

</table>
<div class="datagrid">
<table align="center">
	<tr>
<td>
<?php
//initializing the display variable to print the table on webpage
$display = "<table cellpadding=\"1\" align=\"center\">
  <tr>
    <th>GENRE</th>
    <th>LCN</th>
    <th>SID</th>
    <th>CHANNEL NAME </th>
    <th colspan=\"4\" align=\"center\">Editing options</th>
  </tr>";
  //sending the results to an array and printing
  while($row = mysqli_fetch_array($result)) { 
  $display.="<tr>
    <td>".$row['genre']."</td>
    <td>".$row['lcn']."</td>
    <td>".$row['sid']."</td>
    <td class=\"chn\">".$row['channel'].'</td>
    <td><a href="lcn_edit.php?sid='.$row['sid'].'"><input type="button" class="btn" name="edit" value="Edit"></a></td>
    <td><a href="lcn_swap.php?sid='.$row['sid'].'"><input type="button" class="btn" name="swap" value="Swap"></a></td>
    <td><a href="package_edit.php?sid='.$row['sid'].'"><input type="button" class="btn" name="packagedit" value="Package Edit"></a></td>
    <td><a href="package_delete.php?sid='.$row['sid'].'" onclick="return confirmAction()"><input type="button" class="btn" name="delete" value="Delete"></a></td>
  </tr>';
  }
  $display.= "</table>";
  echo $display;
 ?>
</td>
</tr>
</table>
</div>


</body>
</html>
