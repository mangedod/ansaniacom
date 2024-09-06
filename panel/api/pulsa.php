<?php
date_default_timezone_set('Asia/Jakarta');

include("../../setingan/global.inc.php");
include("../../setingan/web.config.inc.php");

$pulsasms = $_POST['pulsasms'];
$pulsa = $_POST['pulsa'];
$date = date("Y-m-d H:i:s");

$ip = $_SERVER['REMOTE_ADDR'];
$data = date('Y-m-d H:i:s')." | $ip | $pulsa | $pulsasms\r\n";
$file = "$lokasiweb/logs/backlogsmspulsa.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);

if(!empty($pulsasms))
{
	$perintah = "update tbl_modem set pulsasms='$pulsasms',lastupdate='$date'";
	$hasil = sql($perintah);
}
if(!empty($pulsa))
{
	$perintah = "update tbl_modem set pulsa='$pulsa',lastupdate='$date'";
	$hasil = sql($perintah);
}

?>