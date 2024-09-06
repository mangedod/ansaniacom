<?php
$laporid		= $_GET['laporid'];
$username		= $_GET['username'];

if((!empty($laporid)) and (!empty($username)))
{
	$userid = sql_get_var("select userid from tbl_member where username='$username'");
	
	$mysql="update tbl_lapor set jmlshare=jmlshare+1 where laporid='$laporid'";
	$result= sql($mysql);
	
	$url = "http://www.halopolisi.id/laporan/$laporid";
			
	$result1['status']="OK";
	$result1['message']="Share Laporan Berhasil.";
	$result1['url'] = $url;
	$result1['username'] = $username;
	$result1['laporid'] = $laporid;
		
	echo json_encode($result1);
	exit;
	
}
else
{
	$result1['status'] = "ERROR";
	if(empty($laporid))
		$result1['message']="ID Lapor kosong. Silahkan isi terlebih dahulu.";
	else if(empty($username))
		$result1['message']="Username kosong. Silahkan isi terlebih dahulu.";
		
	echo json_encode($result1);
	exit;
}
?>