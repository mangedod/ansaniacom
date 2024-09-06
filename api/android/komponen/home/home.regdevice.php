<?php
$deviceid = $_GET['deviceid'];

if(empty($deviceid))
{
	$result['status'] = "NOTOK";
	$result['message'] = "Device ID kosong";
	echo json_encode($result);
	exit();

}

$cek = sql_get_var("select count(*) as jml from tbl_device where deviceid='$deviceid'");

if($cek<1)
{

	$date = date("Y-m-d H:i:s");
	$dt = sql("insert into tbl_device(deviceid,create_date) values('$deviceid','$date')");

	$result['status'] = "OK";
	$result['message'] = "Perangkat berhasil didaftarkan";

}
else
{
	$result['status'] = "OK";
	$result['message'] = "Telah Terdaftar";

}

echo json_encode($result);
?>