<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="images/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css" media="screen">
.modal a.close-modal[class*="icon-"] {
  top: -10px;
  right: -10px;
  width: 20px;
  height: 20px;
  color: #fff;
  line-height: 1.25;
  text-align: center;
  text-decoration: none;
  text-indent: 0;
  background: #900;
  border: 2px solid #fff;
  -webkit-border-radius:  26px;
  -moz-border-radius:     26px;
  -o-border-radius:       26px;
  -ms-border-radius:      26px;
  -moz-box-shadow:    1px 1px 5px rgba(0,0,0,0.5);
  -webkit-box-shadow: 1px 1px 5px rgba(0,0,0,0.5);
  box-shadow:         1px 1px 5px rgba(0,0,0,0.5);
}
</style>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->


<link rel="stylesheet" href="lib/bootstrap-table.css">

<script src="lib/login.js"></script>

<script src="lib/bootstrap-table.js"></script>
<script src="lib/bootstrap-table-toolbar.js"></script>

<script src="lib/jquery.modal.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="lib/jquery.modal.min.css">


<script>
function confirmAction(){
      var confirmed = confirm("Are you sure? This will remove this entry forever.");
      return confirmed;
}
</script>
<title>LCN edit Mode</title>


</head>

<body>
	<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Meghbela LCN</a>
    </div>
		<ul class="nav navbar-nav">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-floppy-save"></span> Download LCN
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="export.php">Download LCN file</a></li>
          <li><a href="create_master.php">Download Master LCN file</a></li>
        </ul>
      </li>
			<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-floppy-save"></span> Download Package details
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="export_package.php?par=bronze">Export Bronze package</a></li>
          <li><a href="export_package.php?par=silver">Export Silver package</a></li>
          <li><a href="export_package.php?par=gold">Export Gold package</a></li>
					<li><a href="export_package.php?par=platinum">Export Platinum package</a></li>
					<li><a href="export_package.php?par=power">Export Power package</a></li>
        </ul>
      </li>
      <li><a href="submit_data.php">Get BAT Submit Data</a></li>
      <li><a href="channel_add.php">Add new Channel</a></li>
    </ul>

    <ul class="nav navbar-nav navbar-right">
			<li><a href="db_select.php"><strong><span class="glyphicon glyphicon-send"></span> <?php echo $_SESSION['city'] ?></strong></a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
    </ul>
  </div>
</nav>
<!-- ALL MODAL START HERE -->


<div class="container">

<!--initializing the display variable to print the table on webpage -->
<table cellpadding="1" align="center"
data-toggle="table"
data-search="true"
data-id-table="advancedTable"
class="table table-striped">
<thead>
<tr>
	<th>GENRE</th>
	<th data-sortable="true">LCN</th>
	<th data-field="sid" data-sortable="true">SID</th>
	<th data-field="name">CHANNEL NAME</th>
	<th>Edit</th>
	<th>Swap</th>
	<th>Pack</th>
	<th>Delete</th>
</tr>
</thead>
<tbody>
<tr>
<?php
$display = '';
//sending the results to an array and printing
while($row = mysqli_fetch_array($result)) {
$display .="
	<td>".$row['genre']."</td>
	<td>".$row['lcn']."</td>
	<td>".$row['sid']."</td>
	<td><strong>".$row['channel']."</strong><a href=\"lcn_name_edit.php?sid=".$row['sid']."\" rel=\"modal:open\"><span class=\"pull-right\"><span class=\"glyphicon glyphicon-edit\" style=\"color:violet\"></span></span></a></td>
	<td><a href=\"lcn_edit.php?sid=".$row['sid']."\" data-toggle=\"tooltip\" title=\"Edit Channel LCN\" rel=\"modal:open\"><span class=\"glyphicon glyphicon-pencil\"></span></a></td>
	<td><a href=\"lcn_swap.php?sid=".$row['sid']."\" data-toggle=\"tooltip\" title=\"Swap LCN with other Channel\" rel=\"modal:open\"><span class=\"glyphicon glyphicon-transfer\" style=\"color:black\"></span></a></td>
	<td><a href=\"package_edit.php?sid=".$row['sid']."\" data-toggle=\"tooltip\" title=\"Edit Package\" rel=\"modal:open\"><span class=\"glyphicon glyphicon-scissors\" style=\"color:green\"></span></a></td>
	<td><a href=\"package_delete.php?sid=".$row['sid']."\" data-toggle=\"tooltip\" title=\"Delete Channel\" onclick=\"return confirmAction()\"><span class=\"glyphicon glyphicon-remove\" style=\"color:red\"></span></a></td>
</tr>";
}
echo $display;
?>
</tbody>
</table>
</div>


</body>
</html>
