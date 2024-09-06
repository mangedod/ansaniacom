<?php 
// if($_SESSION['userid'] && $aksi="profile")
if($_SESSION['userid'] && $aksi!="profile")
{
	//teman
	$log 		= $_SESSION['userid'];
	$namalog 	= $_SESSION['username'];
	$tgl_skrg 	= date('m');
	$Jumlah_komentar = 0;

	//profil photo
	$perintah	="select userid,userfullname,userdob,userlastloggedin,avatar,posting,follower,following,tema,usergender,useraddress,cityname,kotaid,userpostcode,userphonegsm,negaraid,useremail,header,fbcid,twcid
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
	$kotaid       = $profil['kotaid'];
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
		
	if(empty($FullNameuser) or empty($usergender) or empty($useraddress) or empty($kotaid) or (!preg_match("/^[a-z0-9]+([\w-])*(((?<![_-])\.(?![_-]))[\w-]*[a-z0-9])*@(?![-])([a-z0-9-]){2,}((?<![-])\.[a-z]{2,6})+$/i", $useremail)))// or empty($workid)
	{
		$salahcek = true;
	}
	
	if($salahcek)
	{
		$pesanhasilcek = "Your profile data is not complete, please fill out first.";
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

if(($aksi=="daftar") && (!$_SESSION['userid']))
{ 
	$nama_aksi = "Registration";
	// $file      = "member.daftar.php"; 
}
else if(($aksi=="login" || $aksi=="") && (!$_SESSION['userid']))
{ 
  	$nama_aksi 	= "Login";
  	// include("member.login.php");
	// $file 		= "member.login.php"; 
}
else if(($aksi=="logout"))
{ $nama_aksi = "Logout";
	// $file = "member.logout.php"; 
}
else if($aksi=="daftaranggota") 
{ 
	$nama_aksi = "Registration Data Delivery";
	// $file      = "member.daftaranggota.php"; 
}
else if($aksi=="registerfb") 
{ 
	$nama_aksi = "Registration Data Delivery";
	$file = "registerfb.php"; 
}
else if($aksi=="aktifasi") 
 { 
 		$nama_aksi = "Activation Registration";
 		// $file      = "member.aktifasi.php"; 
 }
else if($aksi=="masuk") 
 	{ $nama_aksi = "Selamat datang $_SESSION[nama] !";
	  $file = "muka.php"; }

//password
else if($aksi=="lupapassword") 
 	{ $nama_aksi = "Help Forgot Password";
	  // $file = "member.lupapassword.php"; 
	}
else if($aksi=="usernameerror") 
 	{ $nama_aksi = "Error Log";
	  $file = "salahlogin.php"; }

else if($aksi=="wishlist") 
{ 
	$nama_aksi 	= "Wishlist";
	$deskripsiaksi 	= "Product in Wishlist";
	// $file 		= "member.wishlist.php"; 
}
else if($aksi=="ticketing") 
{
	$nama_aksi 	= "Ticketing";
	$deskripsiaksi 	= "Please ask your questions here";
	// $file = "member.ticketing.php"; 
}   
else if($aksi=="addticketing") 
{
	$nama_aksi 	= "Add Ticketing";
	$deskripsiaksi 	= "Please ask your questions here";
	// $file = "member.addticketing.php"; 
}   
else if($aksi=="detailticketing") 
{
	$nama_aksi 	= "Detail Ticketing";
	$deskripsiaksi 	= "";
	// $file = "member.detailticketing.php"; 
}    
else if($aksi=="ordertracking") 
{ 
	$nama_aksi 	= "Order Tracking";
	$deskripsiaksi 	= "Please track your order on this page";
}

//member
else if($aksi=="profil") 
 	{ $nama_aksi = "Profil Member";
	  $file = "profile.php";
	   }
else if($aksi=="profile") 
 	{ $nama_aksi = "Profil Member";
	  $file = "member.profile.php";
	   }
   
else if($aksi=="setting") 
 	{ 
		$subaksi = $var[4];
		$tpl->assign("subaksi",$subaksi);
		
		if($subaksi=="gantipassword" || $subaksi=="changepass") 
		{ 
			$nama_aksi = "Setting";
			$deskripsiaksi 	= "Change Password";
		  	$file = "member.setting.changepass.php"; 
		}
		elseif($subaksi=="addressinfo") 
		{ 
			$nama_aksi = "Setting";
			$deskripsiaksi 	= "Address Information";
		  	$file = "member.setting.addressinfo.php"; 
		}
		elseif($subaksi=="deleteaddress") 
		{ 
			$nama_aksi = "Setting";
			$deskripsiaksi 	= "Delete Address";
		  	$file = "member.setting.deleteaddress.php"; 
		}
	  	elseif($subaksi=="" || $subaksi=="biodata")
		{
			$nama_aksi = "Setting";
			$deskripsiaksi 	= "Personal biographical data";
			$file = "member.setting.php"; 
		}
	}

//else
elseif($aksi == "")
{ 
	 $nama_aksi = "Dashboard";
	 if($aksi != "dashboard"){
	 $nama_aksi = "Dashboard";
	 $file = "member.dashboard.php";}
}
$tpl->assign("namaaksi",$nama_aksi);
$tpl->assign("deskripsiaksi",$deskripsiaksi);
if(!empty($file)){ include($file); }

if(file_exists($lokasiweb."komponen/member/member.$aksi.php")) include("member.$aksi.php");

if($aksi=="profile" || $aksi=="profil")
{
	$tpl->display("member-profile.html");
}
else
{
	if(!($_SESSION['username'])){ $tpl->display("member-login.html"); }
	else $tpl->display("member.html");
}


?>