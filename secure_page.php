<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");	
}
//starting the connection to db
include("include/connect.php");
//making the search in db
$sql = "SELECT * FROM channel_tb,lcn_tb WHERE channel_tb.lcn=lcn_tb.lcn ORDER BY lcn_tb.lcn";

//an alternative query
//$sql2 = "SELECT lcn_tb.genre,lcn_tb.lcn,channel_tb.channel FROM lcn_tb LEFT JOIN channel_tb ON lcn_tb.lcn=channel_tb.lcn";

$result = mysqli_query($con,$sql);
if (!$result) { // add this check.
    die('Invalid query: ' . mysqli_error());
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato"  />
<script src="jquery/jquery-2.2.3.js"></script>
<script>

</script>
<title>LCN edit Mode</title>


</head>

<body>

<table align="center">
<tr>
	<td align="left" valign="top">
		User logged in: <?php {echo $_SESSION['user'];} ?>
	</td>
	<td align="left" valign="top">
		<a href="logout.php"><input type="submit" name="logout" value="Logout"  /></a>
	</td>
<td>
<?php
//initializing the display variable to print the table on webpage
$display = "<table cellpadding=\"1\" align=\"center\">
  <tr>
    <th>GENRE</th>
    <th>LCN</th>
    <th>CHANNEL NAME </th>
  </tr>";
  //sending the results to an array and printing
  while($row = mysqli_fetch_array($result)) { 
  $display.="<tr>
    <td>".$row['genre']."</td>
    <td>".$row['lcn']."</td>
    <td>".$row['channel'].'</td>
    <td><input type="button" name="edit" value="Edit"></td>
    <td><input type="button" name="swap" value="Swap"></td>
    <td><input type="button" name="delete" value="Delete"></td>
  </tr>';
  }
  $display.= "</table>";
  echo $display;
 ?>
</td>
</tr>
</table>


</body>
</html>
