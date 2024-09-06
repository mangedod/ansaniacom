<?php 
$userpassword		= $_POST['userpassword'];
$userfullname		= clean($_POST['userfullname']);
$useremail			= clean($_POST['useremail']);
$userphonegsm		= $_POST['userphonegsm'];
$username		= $_POST['username'];

$salah = false;
$pesan = array();

$jumlahemail = sql_get_var("select count(*) as jumlah from tbl_member where useremail='$useremail'");
$jumlahhp = sql_get_var("select count(*) as jumlah from tbl_member where userphonegsm='$userphonegsm'");

	  
if(empty($userfullname))
{
	$result['status'] = "ERROR"; 
	$result['message']="Nama Lengkap masih kosong, silahkan isi Terlebih Dahulu";
	echo json_encode($result);
	exit;
}
if(empty($userphonegsm))
{
	$result['status'] = "ERROR"; 
	$result['message']="Nomor Handphone kosong, silahkan isi Terlebih Dahulu";
	echo json_encode($result);
	exit;
}

else if(empty($userpassword))
{
	$result['status'] = "ERROR"; 
	$result['message']="Password masih kosong, silahkan isi Terlebih Dahulu";
	echo json_encode($result);
	exit;
}
else if(!preg_match("/^[a-z0-9]+([\w-])*(((?<![_-])\.(?![_-]))[\w-]*[a-z0-9])*@(?![-])([a-z0-9-]){2,}((?<![-])\.[a-z]{2,6})+$/i", $useremail))
{
	$result['status'] = "ERROR"; 
	$result['message']="Email masih kosong atau penulisan email kurang benar, silahkan isi Terlebih Dahulu";
	echo json_encode($result);
	exit;
}
else if($jumlahemail > 0)
{
	$result['status'] = "ERROR"; 
	$result['message']="Alamat email $useremail sudah digunakan oleh orang lain, silahkan pilih yang lain";
	echo json_encode($result);
	exit;
}
else if($jumlahhp > 0)
{
	$result['status'] = "ERROR"; 
	$result['message']="Nomor handphone $userphonegsm sudah digunakan oleh orang lain, silahkan pilih yang lain";
	echo json_encode($result);
	exit;
}

else
{

	$userpassword1 = md5($userpassword);
   
  	$perintah = "select max(userid) as baru from tbl_member";
	$hasil = sql($perintah);
	$data = sql_fetch_data($hasil);
	$baru = $data['baru']+1;
	
	$tanggal = date("Y-m-d H:i:s");
	
    $query = "insert into tbl_member (userid,username,userfullname,userpassword,useremail,usercreateddate,useractivestatus,userphonegsm)
			 values ('$baru','$username','$userfullname','$userpassword1','$useremail','$tanggal','1','$userphonegsm')";
    $hasil = sql($query);
	
   if($hasil)
   {
		// buat recod untuk konfirmasi
		$code = "$baru"."$username".date("YmdHis");
		$code = md5($code);
		$perintah4= "insert into tbl_member_konfirmasi(userid,username,code) values ('$baru','$username','$code')";
		$hasil4 = sql($perintah4);
		
		$perintah5= "update tbl_konfigurasi set nummember=nummember+1";
		$hasil5 = sql($perintah5);
		
		$perintah1 = sql("update tbl_member set useractivestatus='1' where useremail='$useremail'");
		
		$isi = "Email Konfirmasi Pendaftaran $title
		=========================================================================
		
		Yth. $userfullname,
		
		Selamat pendaftaran anda telah berhasil dilakukan. Berikut informasi akun Anda dibawah ini :
		
		Email : $useremail
		Password : $userpassword
		
		Anda bisa login dan bisa langsung melengkapi identitas dan informasi lain tentang anda di $title
		supaya dapat menikmati semua fasilitas yang disediakan.
		
		Terima Kasih
		$owner";

		$isihtml = "<br />
		<strong>Email Konfirmasi Pendaftaran $title</strong>
		=========================================================================<br />
		Yth. $userfullname,<br />
		Selamat pendaftaran anda telah berhasil dilakukan. Berikut informasi akun Anda dibawah ini :<br />
		<br />
		<br />
		
		Email : $useremail<br />
		Password : $userpassword
		<br />
		<br />
		
		Anda bisa login dan bisa langsung melengkapi identitas dan informasi lain tentang anda di $title
		supaya dapat menikmati semua fasilitas yang disediakan.
		<br />
		<br />
		
		Terima Kasih<br />
		
		$owner";

		$subject = "Account $title, Pendaftaran Berhasil";
		
		sendmail($userfullname,$useremail,$subject,$isi,$isihtml);
		
		earnpoin("register",$baru);
		
	
		$result['status'] = "OK"; 
		$result['message']="Selamat anda telah terdaftar di $title, username yang dapat anda gunakan adalah email anda dan passwordnya seperti yang telah anda tentukan dan telah kami kirim ke email anda, Jaga kerahasiaan password anda dan jangan lupa.";
		echo json_encode($result);
   	}
	else
	{
		$result['message']="Pendaftaran Anda Gagal dilakukan kemungkinan Ada beberapa kesalahan yang harus diperbaiki terlebih dahulu, silahkan periksa kembali kesalahan dibawah ini";
		$result['status'] = "ERROR"; 
		
		echo json_encode($result);
	}
}
?>
