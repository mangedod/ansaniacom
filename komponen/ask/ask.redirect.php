<?php 
$alias = $var[4];

$sql = "select id,url from tbl_ask where alias='$alias'";
$hsl = sql($sql);

$dt = sql_fetch_data($hsl);
$url = $dt['url'];
$id = $dt['id'];

$ip = $_SERVER['REMOTE_ADDR'];
$date = date("Y-m-d H:i:s");
$browser =  $_SERVER['HTTP_USER_AGENT'];
$refer = $_SESSION['refer'];

$sql = "insert into tbl_ask_log(id,ipaddress,tanggal,browser,ref) values('$id','$ip','$date','$browser','$refer')";
$h = sql($sql);

if($h)
{
	unset($_SESSION['refer']);
	header("location: $url");
	exit();
}

?>