<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
//starting the connection to db
include("include/connect.php");
			
//making the search in db
$sql = "SELECT * FROM channel_tb,lcn_tb WHERE channel_tb.lcn=lcn_tb.lcn ORDER BY lcn_tb.lcn";

$result = mysqli_query($con,$sql);
if (!$result) { // add this check.
    die('Invalid query: ' . mysqli_error());
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/main.css" />
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato"  />
<title>Meghbela Digital LCN</title>
</head>

<body>
<table align="center">
<tr>
	<td align="left" valign="top">
		<td align="left" valign="top"><form autocomplete="off" id="login" action="submit.php" method="post">
			<tr align="left" valign="top"><input type="text" name="user" value="" /></tr>
			<tr align="left" valign="top"><input type="text" name="pass" value="" /></tr>
			<tr align="left" valign="top"><input type="submit" name="submit" value="Submit" /></tr>
			
		</form>
			
		</td>
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
    <td>".$row['channel']."</td>
  </tr>";
  }
  $display.= "</table>";
  echo $display;
  
 ?>
</td>
<td valign="top"><form action = "export.php" method = "get">
       <input type = "hidden" name = "body" value = "" >
       <input type = "submit" name = "submit" Value = "Export to excel">
    </form> 
    </td>
</tr>
</table>


</body>
</html>
