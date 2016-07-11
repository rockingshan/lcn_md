<?php

include("include/connect.php");
include 'include/log.php';
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Kolkata');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
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
							 
//SET header & Footer
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HMeghbela Channel Package');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

// Add a drawing to the header
$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
$objDrawing->setName('Meghbela logo');
$objDrawing->setPath('images/android-icon-72x72.png');
$objDrawing->setHeight(36);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
							 
// Add Heading
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'GENRE')
            ->setCellValue('B1', 'LCN')
            ->setCellValue('C1', 'CHANNEL NAME')
			->setCellValue('D1', 'LCN HEX')
			->setCellValue('E1', 'LCN')
			->setCellValue('F1', 'SID');
			

$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray(
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
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);	
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);		
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//making the search in db
$sql = "SELECT 
lcn_tb.lcn as lcn_tb_lcn,lcn_tb.lcnhex as lcn_tb_lcnhex,lcn_tb.genre as lcn_tb_genre,
channel_tb.channel as ch_tb_channel,channel_tb.sid as ch_tb_sid
 FROM lcn_tb 
 LEFT OUTER JOIN channel_tb ON channel_tb.lcn = lcn_tb.lcn 
 ORDER BY lcn_tb.lcn";

$result = mysqli_query($con,$sql);
if (!$result) { // add this check.
    die('Invalid query: ' . mysqli_error());
}
$rowcount=2;
while($row = mysqli_fetch_array($result)){
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowcount, $row['lcn_tb_genre']);
  $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowcount, $row['lcn_tb_lcn']);
  $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowcount, $row['ch_tb_channel']);
  $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowcount, $row['lcn_tb_lcnhex']);
  $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowcount, $row['lcn_tb_lcn']);
  $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowcount, $row['ch_tb_sid']);
  $rowcount++;
}

$file_name="LCN.xlsx";
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='.$file_name.'');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');


?>
