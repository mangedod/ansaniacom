<?php 
$tpl->assign("register_member","Register");
if($_SESSION['fbid'])
{
	$fbid = $_SESSION['fbid'];
	$daftaremail = $_SESSION['fbemail'];
	$daftarname = $_SESSION['fbname'];
	$daftaravatar = $_SESSION['fbavatar'];
	
	$tpl->assign("fbid",$fbid);
	$tpl->assign("daftaremail",$daftaremail);
	$tpl->assign("daftarname",$daftarname);
	$tpl->assign("daftaravatar",$daftaravatar);
};

if($_SESSION['twid'])
{
	$twid = $_SESSION['twid'];
	$daftaremail = $_SESSION['fbemail'];
	$daftarname = $_SESSION['twname'];
	$daftaravatar = $_SESSION['twpicture'];
	$daftarusername = $_SESSION['twuname'];
	
	$tw_token = $_SESSION['access_token']['oauth_token'];
	$tw_secret = $_SESSION['access_token']['oauth_token_secret'];

	
	$tpl->assign("twid",$twid);
	$tpl->assign("daftaremail",$daftaremail);
	$tpl->assign("daftarname",$daftarname);
	$tpl->assign("daftaravatar",$daftaravatar);
	$daftarusername = strtolower($_SESSION['twuname']);
};

if($_SESSION['me'])
{
	$gdata = $_SESSION['me'];
	$gpid = $gdata['id'];
	$daftaremail = $gdata['emails'][0]['value'];
	$daftarname = $gdata['displayName'];
	$daftaravatar = $gdata['twpicture'];
	$daftarusername = $gdata['twuname'];
	
	$tpl->assign("gpid",$gpid);
	$tpl->assign("daftaremail",$daftaremail);
	$tpl->assign("daftarname",$daftarname);
	$tpl->assign("daftaravatar",$daftaravatar);
	$tpl->assign("daftarusername",$daftarusername);
};

if(isset($_POST['username']))
{

	$username         = clean($_POST['username']);
	$userpassword     = $_POST['userpassword'];
	$userpasswordconf = $_POST['userpasswordconf'];
	$userfullname     = clean($_POST['userfullname']);
	$useremail        = clean($_POST['useremail']);
	$userphonegsm     = clean($_POST['userphonegsm']);
	$cityname         = clean($_POST['cityname']);
	$fromcart         = clean($_POST['fromcart']);
	$resellerjenisid         = clean($_POST['resellerjenisid']);
	
	cekspam($useremail);
	
	
	$salah = false;
	$pesan = array();
	if($fromcart==1)
	{
		$username = strtolower(trim($userfullname));
		$username = str_replace(" ","",$username).date("Y");
	}
	
	$jumlah      = sql_get_var("select count(*) as jumlah from tbl_member where username='$username'");
	$jumlahemail = sql_get_var("select count(*) as jumlah from tbl_member where useremail='$useremail'");
		  
	if(!preg_match('/^[a-zA-z0-9_]{3,25}$/',$username))
	{
		$pesan[1] = array("pesan"=>"Salah penulisan username, Username hanya bisa menggunakan huruf,angka dan tAnda (-). Tidak kurang dari 3 huruf dan tidak lebih dari 25 huruf");
		$salah    = true;
	}
	else if(empty($username))
	{
		$pesan[2] = array("pesan"=>"Username Name masih kosong, silahkan isi Terlebih Dahulu");
		$salah    = true;
	}
	else if(empty($userpassword))
	{
		$pesan[3] = array("pesan"=>"Password masih kosong, silahkan isi Terlebih Dahulu");
		$salah    = true;
	}
	else if($userpassword!=$userpasswordconf)
	{
		$pesan[3] = array("pesan"=>"Password pertama tidak sama dengan password kedua, silahkan coba lagi.");
		$salah    = true;
	}
	else if(empty($userfullname))
	{
		$pesan[6] = array("pesan"=>"Nama Lengkap masih kosong, silahkan isi Terlebih Dahulu");
		$salah    = true;
	}
	else if(!preg_match("/^[a-z0-9]+([\w-])*(((?<![_-])\.(?![_-]))[\w-]*[a-z0-9])*@(?![-])([a-z0-9-]){2,}((?<![-])\.[a-z]{2,6})+$/i", $useremail))
	{
		$pesan[17] = array("pesan"=>"Email masih kosong atau penulisan email kurang benar, silahkan isi Terlebih Dahulu");
		$salah     = true;
	}
	else if($jumlah > 0)
	{
		$pesan[19] = array("pesan"=>"Username <strong>$username</strong> sudah digunakan oleh orang lain, silahkan pilih yang lain");
		$salah     = true;
	}
	else if($jumlahemail > 0)
	{
		$pesan[20] = array("pesan"=>"Alamat <strong>$useremail</strong> sudah digunakan oleh orang lain, silahkan pilih yang lain");
		$salah     = true;
	}
	
	else{ $salah = false; }
	
	
	if(!$salah)
	{
	
		$userpassword1 = md5($userpassword);
		$username      = strtolower($username); 
	   
		$perintah = "select max(userid) as baru from tbl_member";
		$hasil = sql($perintah);
		$data  = sql_fetch_data($hasil);
		$baru  = $data['baru']+1;
		
		$tanggal = date("Y-m-d H:i:s");
		
		$query = "insert into tbl_member(userid,tipe,resellerjenisid,username,userfullname,userpassword,useremail,userphonegsm,cityname,usercreateddate,fbcid,twcid,gpcid,tw_token,tw_secret,useractivestatus)
				 values ('$baru','1','$resellerjenisid','$username','$userfullname','$userpassword1','$useremail','$userphonegsm','$cityname','$tanggal','$fbid','$twid','$gpid','$tw_token','$tw_secret','1')";
		$hasil = sql($query);
		
		$query=("insert into tbl_member_stats(userid,login) values ('$baru','1')");
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
			
				kirimSMS($userphonegsm,"Terima kasih sudah mendaftar menjadi reseller di $title, silahkan lanjutkan belanja sesuai ketentuan untuk menjadi reseller terverifikasi");
	
			
				$isi = "Email Konfirmasi Pendaftaran $title
				=========================================================================
	
				Yth. $userfullname,
	
				Selamat pendaftaran Anda sebagai Reseller telah berhasil dilakukan,
				username dan password yang Anda gunakan adalah sebagai berikut : 
	
				Username : $username / $useremail
				Password : $userpassword
	
				Anda bisa langsung login menggunakan akun yang anda miliki tetapi
				status reseller anda masih belum terverifikasi sampai anda melakukakan belanja
				dengan jumlah yang ditentukan, selanjutnya anda akan divalidasi terlebih
				dahulu. Kami akan menginformasikan kembali bila status reseller anda
				sudah aktif
	
				Terima Kasih
				$owner";
	
				$isihtml = "<br />
				<strong>Email Konfirmasi Pendaftaran $title</strong>
				=========================================================================<br />
				Yth. $userfullname,<br />
				Selamat pendaftaran Anda sebagai Reseller telah berhasil dilakukan,
				username dan password yang Anda gunakan adalah sebagai berikut :<br />
				<br />
	
				Username : $username<br />
				Password : $userpassword
				<br />
				<br />
	
				Anda bisa langsung login menggunakan akun yang anda miliki tetapi
				status reseller anda masih belum terverifikasi sampai anda melakukan belanja
				dengan jumlah yang ditentukan, selanjutnya anda akan divalidasi terlebih
				dahulu. Kami akan menginformasikan kembali bila status reseller anda
				sudah aktif
	
				<br />
				<br />
	
				Terima Kasih<br />
	
				$owner";
	
				$subject = "Terima Kasih Sudah Mendaftar, Silahkan login";
	
				sendmail($userfullname,$useremail,$subject,$isi,emailhtml($isihtml));
			
			$pesanhasil = "Selamat Anda telah terdaftar di $title dan dapat langsung login, username yang dapat Anda gunakan adalah <b>$username</b> dan passwordnya seperti yang telah Anda tentukan dan <b>telah kami kirim ke email Anda</b>, 
				Jaga kerahasiaan password Anda dan jangan lupa. <b>silahkan buka email Anda.</b>";
			$berhasil = "1";
			
		}
				
	}
	else
	{
		$pesanhasil = "Pendaftaran Anda Gagal dilakukan kemungkinan Ada beberapa kesalahan yang harus diperbaiki terlebih dahulu, silahkan periksa kembali kesalahan dibawah ini.";
		$berhasil = "0";
	}	
	$tpl->assign("pesan",$pesan);
	$tpl->assign("pesanhasil",$pesanhasil);
	$tpl->assign("berhasil",$berhasil);

}

?>