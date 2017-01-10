<<<<<<< HEAD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
//starting the connection to db
include("include/connect.php");
mysqli_select_db($con,'meghbela_lcn_db_kol') or die("No database");
//making the search in db
$sql = "SELECT * FROM channel_tb,lcn_tb,package_tb WHERE channel_tb.lcn=lcn_tb.lcn AND channel_tb.sid=package_tb.sid ORDER BY lcn_tb.lcn";

$result = mysqli_query($con,$sql);
if (!$result) { // add this check.
    die('Invalid query: ' . mysqli_error());
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<title>Meghbela Digital LCN</title>
</head>

<body>
	<div class="datagrid">
<table align="center" class="auth">
<tr>
	<td align="left" valign="top">
		<td align="left" valign="top"><form autocomplete="off" id="login" action="./process/submit.php" method="post">
			<tr align="left" valign="top"><input type="text" name="user" value="" /></tr>
			<tr align="left" valign="top"><input type="password" name="pass" value="" /></tr>
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
    <th>SID</th>
    <th>CHANNEL NAME </th>
    <th>Bronze Digital </th>
    <th> Silver Digital </th>
    <th> Gold Digital </th>
    <th> Platinum Digital </th>
    <th> Power pack </th>
    <th> Price(&#8377) </th>
  </tr>";
  //sending the results to an array and printing
  while($row = mysqli_fetch_array($result)) { 
  $display.="<tr>
    <td>".$row['genre']."</td>
    <td>".$row['lcn']."</td>
    <td>".$row['sid']."</td>
    <td class=\"chn\">".$row['channel']."</td>
    <td>".$row['bronze']."</td>
    <td>".$row['silver']."</td>
    <td>".$row['gold']."</td>
    <td>".$row['platinum']."</td>
    <td>".$row['power']."</td>
    <td>".$row['price']."</td>
    
  </tr>";
  }
  $display.= "</table>";
  echo $display;
  
 ?>
</td>
<!--<td valign="top"><form action = "export.php" method = "get">
       <input type = "hidden" name = "body" value = "" >
       <input type = "submit" name = "submit" Value = "Export to excel">
    </form> 
</td> -->
</tr>
</table>

</div>
</body>
</html>
=======
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
//starting the connection to db
include("include/connect.php");
			
//making the search in db
$sql = "SELECT * FROM channel_tb,lcn_tb,package_tb WHERE channel_tb.lcn=lcn_tb.lcn AND channel_tb.sid=package_tb.sid ORDER BY lcn_tb.lcn";

$result = mysqli_query($con,$sql);
if (!$result) { // add this check.
    die('Invalid query: ' . mysqli_error());
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<title>Meghbela Digital LCN</title>
</head>

<body>
	<div class="datagrid">
<table align="center" class="auth">
<tr>
	<td align="left" valign="top">
		<td align="left" valign="top"><form autocomplete="off" id="login" action="./process/submit.php" method="post">
			<tr align="left" valign="top"><input type="text" name="user" value="" /></tr>
			<tr align="left" valign="top"><input type="password" name="pass" value="" /></tr>
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
    <th>SID</th>
    <th>CHANNEL NAME </th>
    <th>Bronze Digital </th>
    <th> Silver Digital </th>
    <th> Gold Digital </th>
    <th> Platinum Digital </th>
    <th> Power pack </th>
    <th> Price(&#8377) </th>
  </tr>";
  //sending the results to an array and printing
  while($row = mysqli_fetch_array($result)) { 
  $display.="<tr>
    <td>".$row['genre']."</td>
    <td>".$row['lcn']."</td>
    <td>".$row['sid']."</td>
    <td class=\"chn\">".$row['channel']."</td>
    <td>".$row['bronze']."</td>
    <td>".$row['silver']."</td>
    <td>".$row['gold']."</td>
    <td>".$row['platinum']."</td>
    <td>".$row['power']."</td>
    <td>".$row['price']."</td>
    
  </tr>";
  }
  $display.= "</table>";
  echo $display;
  
 ?>
</td>
<!--<td valign="top"><form action = "export.php" method = "get">
       <input type = "hidden" name = "body" value = "" >
       <input type = "submit" name = "submit" Value = "Export to excel">
    </form> 
</td> -->
</tr>
</table>

</div>
</body>
</html>
>>>>>>> lcn_md/master
