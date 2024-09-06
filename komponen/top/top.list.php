<?php 
$sql = "select id,url from tbl_top where id='$id'";
$hsl = sql($sql);
$dt = sql_fetch_data($hsl);
$url = $dt['url'];
$id = $dt['id'];

if(empty($id)) exit("Unknown target");

$sql = "update tbl_top set click=click+1 where id='$id'";
$h = sql($sql);

if($h)
{
	header("location: $url");
	exit();
}

?>