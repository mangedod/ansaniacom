<?php
$username = $_GET['username'];
$hlm = $_GET['hlm'];
$subaksi = $_GET['subaksi'];

if($username)
{
	$jumlah = sql_get_var("select count(*) as jml from tbl_notifikasi where tousername='$username' and status='0'");
	if($jumlah>0)
	{
		$pesan="Tidak ada notifikasi baru untuk Anda";
		$result['status']="ERROR";
		$result['message']=$pesan;
		$result['jumlahnotifikasi']=$jumlah;
	}
	else
	{
		$pesan="Jmlah notifikasi diketahui";
		$result['status']="OK";
		$result['message']=$pesan;
		$result['jumlahnotifikasi']=$jumlah;
	}
	echo json_encode($result);
	exit;
}

?>