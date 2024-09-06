<?php
$username = $_GET['username'];
$notifikasiid = $_GET['id'];

if($username)
{
	$jumlah = sql_get_var("select count(*) as jml from tbl_notifikasi where tousername='$username' and id='$notifikasiid'");
	if($jumlah>0)
	{
		$sql = sql("update tbl_notifikasi set status='1' where tousername='$username' and id='$notifikasiid'");
		$pesan="Notifikasi berhasil di baca";
		$result['status']="OK";
		$result['message']=$pesan;
	}
	else
	{
		$pesan="Notifikasi tidak terbaca";
		$result['status']="ERROR";
		$result['message']=$pesan;
	}
	echo json_encode($result);
	exit;
}

?>