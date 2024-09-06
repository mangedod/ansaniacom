<?php 
	$userPassword		= $_POST[userPassword];
	$userNewPassword	= $_POST[userNewPassword];
	$userRePassword		= $_POST[userRePassword];
	$userName 		= $_POST[userName];
	$pesan = array();

	if(!empty($userPassword) || !empty($userRePassword) || !empty($userNewPassword))
	
	{
		$password = true;
		
		//Cek sudah terdaftar atau belum
		$perintah = "select userPassword from tbl_member where userName='$_SESSION[usernameresel]'";
		$hasil = mysql_db_query ($database, $perintah);
		$passLama = sql_result($hasil,0,userPassword);
			  
		if(md5($userPassword)!=$passLama)
			{
			$pesan[3] = array("pesan"=>"Sepertinya Password lama Anda kurang benar, silahkan dicoba kembali");
			$salah = true;
			}
		else if(empty($userPassword))
			{
			$pesan[4] = array("pesan"=>"Password Lama Masih kosong, silahkan isi Terlebih Dahulu");
			$salah = true;
			}
		else if(empty($userNewPassword))
			{
			$pesan[5] = array("pesan"=>"Password Baru masih kosong, silahkan isi Terlebih Dahulu");
			$salah = true;
			}
		else if(empty($userRePassword))
			{
			$pesan[6] = array("pesan"=>"Password kedua masih kosong, silahkan isi Terlebih Dahulu");
			$salah = true;
			}
		else if($userNewPassword!=$userRePassword)
			{
			$pesan[7] = array("pesan"=>"Password Baru yang pertama dan kedua tidak sama, silahkan isi Terlebih Dahulu");
			$salah = true;
			}
		else
			{ $salah = false; }
		
		
		if(!$salah)
		{
			if($password)
			{
				$userNewPassword = md5($userNewPassword);
				$tanggal = date("Y-m-d H:i:s");   
				$query=("update tbl_member set userPassword='$userNewPassword',userLastActive='$tanggal' where userName='$_SESSION[usernameresel]'");
				$hasil = mysql_query($query);
				$pesanhasil = "Penyimpanan setting berhasil dilakukan.";
				$berhasil = "1";
			}
		}
		else
		{
			$pesanhasil = "Penyimpanan setting gagal dilakukan ada beberapa kesalahan yang mesti diperbaiki, silahkan periksa kembali kesalahan dibawah ini";
			$berhasil = "0";
		}
	}
$tpl->assign("pesan",$pesan);
$tpl->assign("pesanhasil",$pesanhasil);
$tpl->assign("berhasil",$berhasil);
?>