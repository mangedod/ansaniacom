<?php
/*if(!empty($_SESSION['secid']))
{ 

$secid = $_SESSION['secid']; 

if($_SESSION['secid'] == 1)
{
	$pengumumanreseller = sql_get_var("select pengumuman from tbl_static_reseller limit 1");
	$tpl->assign("pengumumanreseller",$pengumumanreseller); 
}

$tpl->assign("secid",$secid); 

}*/
if($_SESSION['userid'] && $aksi!="profile")
{
	//teman
	$log 		= $_SESSION['userid'];
	$namalog 	= $_SESSION['username'];
	$tgl_skrg 	= date('m');
	$Jumlah_komentar = 0;

	//profil photo
	$perintah	="select userid,userfullname,userdob,userlastloggedin,avatar,posting,follower,following,tema,usergender,useraddress,cityname,userpostcode,userphonegsm,negaraid,workid,useremail,header,fbcid,twcid
			from tbl_member where userid='$_SESSION[userid]'";
	$hasil= sql($perintah);
	$profil= sql_fetch_data($hasil);
	sql_free_result($hasil);

	$Iduser       = $profil['userid'];
	$FullNameuser = $profil['userfullname'];
	$userDOB      = $profil['userdob'];
	$avatar       = $profil['avatar'];
	$posting      = number_format($profil['posting'],0,".",".");
	$follower     = number_format($profil['follower'],0,".",".");
	$following    = number_format($profil['following'],0,".",".");
	$tema         = $profil['tema'];
	$usergender   = $profil['usergender'];
	$useraddress  = $profil['useraddress'];
	$cityname     = $profil['cityname'];
	$userpostcode = $profil['userpostcode'];
	$userphonegsm = $profil['userphonegsm'];
	$negaraid     = $profil['negaraid'];
	$workid       = $profil['workid'];
	$useremail    = $profil['useremail'];
	$header       = $profil['header'];
	$fbcid        = $profil['fbcid'];
	$twcid        = $profil['twcid'];
	
	if ($avatar)
		$linkphoto="$fulldomain/uploads/avatars/$avatar";
	else
		$linkphoto="$lokasiwebtemplate/images/no_pic.jpg";

	if(empty($header))
		$header = "$lokasiwebtemplate/images/cover.jpg";

	$tpl->assign("linkphoto",$linkphoto);	
	$tpl->assign("FullNameuser",$FullNameuser);
	$tpl->assign("tahun",$tahun);
	$tpl->assign("posting",$posting);	
	$tpl->assign("follower",$follower);
	$tpl->assign("following",$following);
	$tpl->assign("tema",$tema);
	$tpl->assign("header",$header);
	$tpl->assign("headermember",$header);
	$tpl->assign("fbcid",$fbcid);
	$tpl->assign("twid",$twcid);
	
	$salahcek	= false;	
		
	if(empty($FullNameuser) or  (!preg_match("/^[a-z0-9]+([\w-])*(((?<![_-])\.(?![_-]))[\w-]*[a-z0-9])*@(?![-])([a-z0-9-]){2,}((?<![-])\.[a-z]{2,6})+$/i", $useremail)) )
	{
		$salahcek = true;
	}
	
	if($salahcek)
	{
		$pesanhasilcek = "Data profil Anda belum lengkap, silahkan lengkapi terlebih dahulu.";
		$berhasilcek = "1";
	}
	
	$tpl->assign("pesancek",$pesancek);
	$tpl->assign("pesanhasilcek",$pesanhasilcek);
	$tpl->assign("berhasilcek",$berhasilcek);
	
	
	//Cek Jumlah Follow
	$jumunfollow = sql_get_var("select count(*) as jml from tbl_subscriber where status='0' and refuserid='$_SESSION[userid]'");
	$tpl->assign("jumunfollow",$jumunfollow);
	
	//Cek Jumlah Message
	$jmlmessage = sql_get_var("select count(*) as jml from tbl_pesan where baca='0' and penerima='$_SESSION[userid]'");
	$tpl->assign("jmlmessage",$jmlmessage);
	
}


if(!$_SESSION['userid']) {
	if(empty($aksi)) $aksi = "login";
}   
else if($aksi=="wishlist") 
{
	  	$file = "submember.wishlist.php"; 
}    
else if($aksi=="ticketing") 
{
	  	$file = "submember.ticketing.php"; 
}   
else if($aksi=="addticketing") 
{
	  	$file = "submember.addticketing.php"; 
}   
else if($aksi=="detailticketing") 
{
	  	$file = "submember.detailticketing.php"; 
}    
//password
else if($aksi=="lupapassword") 
{ 
	$nama_aksi = "Bantuan Lupa Password";
  	$file = "submember.lupapassword.php"; 
}
//profile member
else if($aksi=="profile") 
 	{ $nama_aksi = "Profil Member";
	  $file = "submember.profile.php";
	   }
else if($aksi=="usernameerror") 
{ 	
	$nama_aksi = "Kesalahan Login";
	$file = "submember.salahlogin.php"; 
		$subaksi = $var[4];
		if($subaksi=="usernameerror") 
		{ 
			$file = "submember.salahlogin.php"; 
		} 
}
else if($aksi=="setting") 
{ 
	$subaksi = $var[4];
	$tpl->assign("subaksi",$subaksi);
	
	if($subaksi=="gantipassword") 
	{ 
		$nama_aksi = "Ubah Password";
	  	$file = "submember.gantipassword.php"; 
	}
	elseif($subaksi=="profile") 
	{ 
		$nama_aksi = "Pengaturan Profile";
	  	$file = "submember.setting.profile.php"; 
	}
	elseif($subaksi=="avatar") 
	{ 
		$nama_aksi = "Ganti Photo Profile";
	  	$file = "submember.setting.avatar.php"; 
	}
	elseif($subaksi=="tampilan") 
	{ 
		$nama_aksi = "Ganti Gambar Latar Belakang";
	  	$file = "submember.setting.tampilan.php"; 
	}
	elseif($subaksi=="privacy") 
	{ 
		$nama_aksi = "Keamanan Privacy";
	  	$file = "submember.setting.privacy.php"; 
	}
	elseif($subaksi=="notifikasiemail") 
	{ 
		$nama_aksi = "Notifikasi Email";
	  	$file = "submember.setting.notifikasiemail.php"; 
	}
  	else
	{
		$nama_aksi = "Perubahan Profil";
		$file = "submember.setting.php"; 
	}
}
else
{
if(empty($aksi)) $aksi = "dashboard";
}
$tpl->assign("namaaksi",$nama_aksi);
if(!empty($file)){ include($file); }

// include($lokasiweb."komponen/submember/".$file);

if(file_exists($lokasiweb."komponen/submember/submember.$aksi.php")) include("submember.$aksi.php");
// else{ $aksi = "list";  include("$kanal.list.php"); }

if($_SESSION['fbcid'])
{
	$fbcid 			= $_SESSION['fbcid'];
	$daftaremail 	= $_SESSION['fbemail'];
	$daftarname 	= $_SESSION['fbname'];
	$daftaravatar 	= $_SESSION['fbavatar'];
	$first_name		= $_SESSION['first_name'];
	$last_name		= $_SESSION['last_name'];
	
	$tpl->assign("fbcid",$fbcid);
	$tpl->assign("daftaremail",$daftaremail);
	$tpl->assign("daftarname",$daftarname);
	$tpl->assign("daftaravatar",$daftaravatar);
	$tpl->assign("first_name",$first_name);
	$tpl->assign("last_name",$last_name);
}

if($_SESSION['twcid'])
{
	$twcid 			= $_SESSION['twcid'];
	$daftaremail 	= $_SESSION['fbemail'];
	$daftarname 	= $_SESSION['twname'];
	$daftaravatar 	= $_SESSION['twpicture'];
	$daftarusername = strtolower($_SESSION['twuname']);
	
	$tpl->assign("twcid",$twcid);
	$tpl->assign("daftaremail",$daftaremail);
	$tpl->assign("daftarname",$daftarname);
	$tpl->assign("daftaravatar",$daftaravatar);
	$tpl->assign("daftarusername",$daftarusername);
	$tpl->assign("first_name",$daftarname);
}
include($lokasiweb."/komponen/subhome/subhome.all.php");

if($aksi=="pay")
{
	$tpl->display("pay.html");
}
elseif(!$_SESSION['userid']) {
	$tpl->display('user-login.html');
}
else $tpl->display('user.html');
?>