<?php
$userid = $_POST['userid'];
$usertipe = sql_get_var("select usertipe from tbl_member where userid='$userid'");
if($usertipe == '1')
{
	if($_POST['aksi']=="simpan")
	{
		$respon		= cleaninsert($_POST['respon']);
		$polsekid	= $_POST['polsekid'];
		$laporid	= $_POST['laporid'];
		$experience	= $_POST['experience'];
		
		$date		= date("Y-m-d H:i:s");	
				
		$salah = false;
		$pesan = array();
		
		if(empty($userid))
		{
			$result["message"] = "Anda harus login terlebih dahulu";
			echo json_encode($result);
			exit;
		}
		else if(empty($respon))
		{
			$result["message"] = "Keterangan respon harap diisi";
			echo json_encode($result);
			exit;
		}
	
		
		if(!$salah)
		{
		
			$query= "update tbl_lapor set respon='$respon',responuserid='$polsekid',tanggalrespon='$date',status='2', experience='$experience'
					 where laporid='$laporid'";
			
	
			$hasil = sql($query);
			
		   if($hasil)
		   {
		   	$uid = sql_get_var("select userid from tbl_lapor where laporid='$laporid'");
			sql("update tbl_member set experience=experience+'$experience' where userid='$uid'");
								   
			$result["message"] ="Selamat Data respon di $title telah berhasil diupdate.";
			$result["berhasil"] ="1";
			echo json_encode($result);
			exit;
			}
					
		}
		else
		{
			$result["message"] ="Penyimpanan respon gagal dilakukan ada beberapa kesalahan yang mesti diperbaiki, silahkan periksa kembali kesalahan dibawah ini";
			$result["berhasil"] ="0";
			echo json_encode($result);
			exit;
		}
	
	}
}
else
{
	$result["message"] = "Maaf Anda tidak mempunyai otoritas untuk halaman ini";
	echo json_encode($result);
	exit;
}
?>