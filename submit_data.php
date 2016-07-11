<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("location:index.php");	//redirect to index page if not logged in
}
//starting the connection to db
require_once "include/connect.php";
include 'include/log.php';
date_default_timezone_set('Asia/Kolkata');

$ts_array=array();
$sid_un_array=array_unique($_SESSION['sidcounter']);
foreach($sid_un_array as $sid_value){
	$sid_sql="SELECT ts from sid_tb WHERE sid=$sid_value";
	$sid_result=mysqli_query($con, $sid_sql);
	$sid_res_row=mysqli_fetch_array($sid_result);
	$ts_array[]=$sid_res_row['ts'];
	
}

$ts_un_array=array_unique($ts_array);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato"  />
<script src="https://cdn.jsdelivr.net/clipboard.js/1.5.10/clipboard.min.js"></script>
<title>LCN submit data</title>
<script>(function(){
    new Clipboard('siddata');
})();</script> 
</head>
<body>
	<div class="datagrid">
	<table align="center">
		<tr><th>TS Number</th><th>BAT Submition data</th></tr>
		
<?php
foreach($ts_un_array as $ts_value){
	$sidlcnout="";
	$ts_sql="SELECT sid FROM sid_tb WHERE ts=$ts_value";
	$ts_result=mysqli_query($con,$ts_sql);
	
	while($ts_res_row=mysqli_fetch_array($ts_result)){
		$sidlcn_sql="SELECT * from channel_tb,sid_tb WHERE channel_tb.sid='".$ts_res_row['sid']."' AND sid_tb.sid='".$ts_res_row['sid']."'";
		$sidlcn_result=mysqli_query($con,$sidlcn_sql);
		$sidlcn_row=mysqli_fetch_array($sidlcn_result);
		$sidlcnout=$sidlcnout.$sidlcn_row['sidhex']." ".$sidlcn_row['lcnhex']." ";
			}
	echo "<tr><td>".$ts_value;
	echo "<td id='siddata'>".$sidlcnout."</tr>";
}

// 
//
//Autosave Excel data LCN backup block ---- start
//
require_once 'Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Meghbela Digital")
							 ->setLastModifiedBy("Meghbela")
							 ->setTitle("MeghbelaLCN")
							 ->setSubject("Meghbela LCN")
							 ->setDescription("Meghbela LCN")
							 ->setKeywords("LCN Excel")
							 ->setCategory("LCN");
// Add Heading
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'GENRE')
            ->setCellValue('B1', 'LCN')
            ->setCellValue('C1', 'CHANNEL NAME');

$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray(
		array(
			'font'    => array(
				'bold'      => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			),
			'borders' => array(
				'top'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			),
			'fill' => array(
	 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	  			'rotation'   => 90,
	 			'startcolor' => array(
	 				'argb' => 'FFA0A0A0'
	 			),
	 			'endcolor'   => array(
	 				'argb' => 'FFFFFFFF'
	 			)
	 		)
		)
);
			
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);	
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//making the search in db
$sql = "SELECT * FROM channel_tb,lcn_tb WHERE channel_tb.lcn=lcn_tb.lcn ORDER BY lcn_tb.lcn";

$result = mysqli_query($con,$sql);
if (!$result) { // add this check.
    die('Invalid query: ' . mysqli_error());
}
$rowcount=2;
while($row = mysqli_fetch_array($result)){
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowcount, $row['genre']);
  $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowcount, $row['lcn']);
  $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowcount, $row['channel']);
  $rowcount++;
}
$file_name="LCN ".Date('Ymd').".xlsx";
$full_file_name="D:/MEGA/LCN BACKUP/".$file_name;
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace(__FILE__,$full_file_name,__FILE__));

// 
//
//Autosave Excel data LCN backup block ---- stop
//

?>
</table>
</div>
<h4 align="center"><a href="secure_page.php">Get back to Edit Mode</a></h3>
</body>
</html>