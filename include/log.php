<?php
function write_log ($data =''){

$write_data = $data;
$file_name=$_SESSION['city']."_LCN_".Date('Y-m-d').".txt";
$file_name_full="F:/MEGA/LCN BACKUP/log/".$file_name;
if(!file_exists($file_name_full)){
    $handle = fopen($file_name_full, 'w');
}else{
    $handle = fopen($file_name_full, 'a');
}
$file_write_data = date('Y-F-d::H:i:s  ').$write_data."\r\n";
fwrite($handle, $file_write_data);
fclose($handle);

}
?>
