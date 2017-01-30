<?php
include("include/connect.php");
if(!isset($_SESSION['select_db']) || !isset($_SESSION['city'])){
	$_SESSION['select_db'] = 'meghbela_lcn_db_kol';
	$_SESSION['city'] = 'Kolkata';
}
mysqli_select_db($con,$_SESSION['select_db']) or die("No database");

?>
<html>
<head>
</head>

<body>
  <table>


<?php
$rowcount=2;
//BUSINESS LOGIC HERE
  $sid_sql="SELECT * from sid_tb";
  $sid_result=mysqli_query($con, $sid_sql);
  while ($sid_res_row=mysqli_fetch_array($sid_result)) {
    $ts_array[]=$sid_res_row['ts'];
  }

  $ts_un_array=array_unique($ts_array);
  foreach($ts_un_array as $ts_value){
    $sidlcnout="";
    $ts_sql="SELECT sid FROM sid_tb WHERE ts=$ts_value";
    $ts_result=mysqli_query($con,$ts_sql);

    while($ts_res_row=mysqli_fetch_array($ts_result)){
      $sidlcn_sql="SELECT * from channel_tb,sid_tb WHERE channel_tb.sid='".$ts_res_row['sid']."' AND sid_tb.sid='".$ts_res_row['sid']."'";
      $sidlcn_result=mysqli_query($con,$sidlcn_sql);
      $sidlcn_row=mysqli_fetch_array($sidlcn_result);
      if($sidlcn_row == NULL){
        continue;
      }
      echo "<tr><td>".$sidlcn_row['channel']."</td>";
      echo "<td>".$sidlcn_row['sid']."</td>";
      echo "<td>".$sidlcn_row['sidhex']."</td>";
      echo "<td>".$sidlcn_row['lcnhex']."</td>";
      $sidlcnout=$sidlcnout.$sidlcn_row['sidhex']." ".$sidlcn_row['lcnhex']." ";
      $rowcount++;
        }
        echo "<td>".$sidlcnout."</td></tr>";
        $rowcount++;

}

?>


</table>
</body>
</html>
