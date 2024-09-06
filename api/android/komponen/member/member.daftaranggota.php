<?php 
$username			= clean($_POST['username']);
$userpassword		= $_POST['userpassword'];
$userfullname		= clean($_POST['userfullname']);
$useremail			= clean($_POST['useremail']);
$userphonegsm		= $_POST['userphonegsm'];

$salah = false;
$pesan = array();

$jumlah = sql_get_var("select count(*) as jumlah from tbl_member where username='$username'");
$jumlahemail = sql_get_var("select count(*) as jumlah from tbl_member where useremail='$useremail'");

	  
if(!preg_match('/^[a-zA-z0-9_]{3,25}$/',$username))
{
	$result['status'] = "ERROR"; 
	$result['message']="Salah penulisan username, Username hanya bisa menggunakan huruf,angka dan tanda (-). Tidak kurang dari 3 huruf dan tidak lebih dari 25 huruf";
	echo json_encode($result);
	exit;
}
else if(empty($username))
{
	$result['status'] = "ERROR"; 
	$result['message']="Username Name masih kosong, silahkan isi Terlebih Dahulu";
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
else if($jumlah > 0)
{
	$result['status'] = "ERROR"; 
	$result['message']="Username $username sudah digunakan oleh orang lain, silahkan pilih yang lain";
	echo json_encode($result);
	exit;
}
else if($jumlahemail > 0)
{
	$result['status'] = "ERROR"; 
	$result['message']="Email $useremail sudah digunakan oleh orang lain, silahkan pilih yang lain";
	echo json_encode($result);
	exit;
}
else
{

	$userpassword1 = md5($userpassword);
	$username = strtolower($username); 
   
  	$perintah = "select max(userid) as baru from tbl_member";
	$hasil = sql($perintah);
	$data = sql_fetch_data($hasil);
	$baru = $data['baru']+1;
	
	$tanggal = date("Y-m-d H:i:s");
	
    $query = "insert into tbl_member (userid,username,userfullname,userpassword,useremail,usercreateddate,useractivestatus,userphonegsm,fbcid,twcid,gpcid,tw_token,tw_secret,create_date)
			 values ('$baru','$username','$userfullname','$userpassword1','$useremail','$tanggal','1','$userphonegsm','$fbid','$twid','$gpid','$tw_token','$tw_secret', now())";
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
		
		$isi = "Email Konfirmasi Pendaftaran $title
		=========================================================================
		
		Yth. $userfullname,
		
		Selamat pendaftaran anda telah berhasil dilakukan. Berikut informasi akun Anda dibawah ini :
		
		Username : $username
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
		
		Username : $username<br />
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
		
		earnpoin("register",$baru);
		
		sendmail($userfullname,$useremail,$subject,$isi,$isihtml);
		
		$result['status'] = "OK"; 
		$result['message']= "Proses registrasi berhasil";
		$result['username'] = $username;	
		$result['useremail'] = $useremail;		

		echo json_encode($result);
   	}
	else
	{
		$result['status'] = "ERROR"; 
		$result['message']= "Proses registrasi gagal";
		
		echo json_encode($result);
	}
}
?>
