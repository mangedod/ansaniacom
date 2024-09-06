<?php 
$userid=$_POST['userid'];

if(isset($userid))
{
	$pvemail=$_POST['pvemail'];
	$pvphonegsm=$_POST['pvphonegsm'];
	$pvnotif=$_POST['pvnotif'];
	$pvaddress=$_POST['pvaddress'];
	
	$perintah = "update tbl_member set update_date='$date',pvemail='$pvemail',pvphonegsm='$pvphonegsm',pvaddress='$pvaddress',pvnotif='$pvnotif' where userid='$userid'";
	$hasil = sql($perintah);
	
	if($hasil)
	{
		$result['status'] = "OK"; 
		$result["message"] ="Pengaturan notifikasi berhasil dilakukan.";	
	}
	else
	{
		$result['status'] = "ERROR"; 
		$result["message"] ="Pengaturan notifikasi gagal dilakukan, ada beberapa kesalahan yang mesti diperbaiki";
	}
}
else
{
	$result['status'] = "Error"; 
	$result["message"] ="Pengaturan notifikasi gagal dilakukan, ada beberapa kesalahan yang mesti diperbaiki";		
}
echo json_encode($result);
exit;
?>