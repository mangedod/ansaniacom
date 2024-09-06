<?php 
if($_SESSION['fbid'])
{
	$fbid         = $_SESSION['fbid'];
	$daftaremail  = $_SESSION['fbemail'];
	$daftarname   = $_SESSION['fbname'];
	$daftaravatar = $_SESSION['fbavatar'];
	
	$tpl->assign("fbid",$fbid);
	$tpl->assign("daftaremail",$daftaremail);
	$tpl->assign("daftarname",$daftarname);
	$tpl->assign("daftaravatar",$daftaravatar);
};

if($_SESSION['me'])
{
	$gdata          = $_SESSION['me'];
	$gpid           = $gdata['id'];
	$daftaremail    = $gdata['emails'][0]['value'];
	$daftarname     = $gdata['displayName'];
	$daftaravatar   = $gdata['twpicture'];
	$daftarusername = $gdata['twuname'];
	
	$tpl->assign("gpid",$gpid);
	$tpl->assign("daftaremail",$daftaremail);
	$tpl->assign("daftarname",$daftarname);
	$tpl->assign("daftaravatar",$daftaravatar);
	$tpl->assign("daftarusername",$daftarusername);
};

$username         = clean($_POST['username']);
$userpassword     = $_POST['userpassword'];
$userpasswordconf = $_POST['userpasswordconf'];
$userfullname     = clean($_POST['userfullname']);
$useremail        = clean($_POST['useremail']);
$userphonegsm     = clean($_POST['userphonegsm']);
$fbid             = clean($_POST['fbid']);
$twid             = clean($_POST['twid']);
$gpid             = clean($_POST['gpid']);
$pass             = md5($userpassword);

$salah = false;
$pesan = array();

if($fromcart==1)
{
	$username = strtolower(trim($userfullname));
	$username = str_replace(" ","",$username).date("Y");
}

$jumlah      = sql_get_var("select count(*) as jumlah from tbl_member where username='$username'");
$jumlahemail = sql_get_var("select count(*) as jumlah from tbl_member where useremail='$useremail'");
$ceklogin    = sql_get_var("select userid from tbl_member where useremail='$useremail' and userpassword='$pass' and useractivestatus='1' and verified='1'");

if($ceklogin>0)
{
	//Login dan Update FBI
	$perintah	= "select userid,userfullname,username,userdirname,avatar,verified,fbcid,twcid,gpcid,useremail from tbl_member where userid='$ceklogin'";
	$hasil 		= sql($perintah);
	
	if(sql_num_rows($hasil)<1)
	{
		$pesan[1] = array("pesan"=>"Mohon maaf Login Anda gagal dilakukan, kemungkian email dan Password yang Anda masukan salah, Jika
				 Anda belum menjadi member, silahkan daftar terlebih dahulu");
		$salah = true;
		/*header("location: $fulldomain"."/member/usernameerror");
		exit();*/
	}
	else
	{
		$row 			= sql_fetch_data($hasil);
 		$userid  		= $row['userid'];
		$username 		= $row['username'];
		$userfullname 	= $row['userfullname'];
		$userdirname 	= $row['userdirname'];
		$avatar 		= $row['avatar'];
		$verified 		= $row['verified'];
		// $usertipe 		= $row['usertipe'];
		$fbcid 			= $row['fbcid'];
		$gpcid 			= $row['gpcid'];
		

		session_start();	
		$_SESSION['userid'] 		= $userid;
		$_SESSION['userfullname'] 	= $userfullname;
		$_SESSION['username'] 		= $username;
		$_SESSION['userdirname'] 	= $userdirname;
		// $_SESSION['usertipe'] 		= $usertipe;
		$_SESSION['verified'] 		= $verified;
		$_SESSION['avatar'] 		= $avatar;
		
		$userlastloggedin = date("Y-m-d H:i:s");
		
		if(!empty($fbid))
		{
			$views = "update tbl_member set fbcid='$fbid' where userid='$userid'";
			$hsl = sql( $views);
		}
		
		if(!empty($gpid))
		{
			$views = "update tbl_member set gpcid='$gpid' where userid='$userid'";
			$hsl = sql( $views);
		}

		$views = "update tbl_member_stats set login=login+1 where userid='$userid'";
		$hsl = sql( $views);
		
		$views = "update tbl_member set userlastloggedin='$userlastloggedin',userlastactive='$userlastloggedin' where userid='$userid'";
		$hsl = sql( $views);
		
		$views 	= "update tbl_transaksi set userid='$userid' where orderid='$_SESSION[orderid]'";
		$hsl 	= sql($views);
				
		if((!$_SESSION['last']) || ($_SESSION['last']=="/")) $pelempar = "$fulldomain"."/member"; 
		else $pelempar = $_SESSION['last'];
		
		
		header("Location: $pelempar");
		exit();
	}
}

if(empty($userpassword))
{
	$pesan[3] = array("pesan"=>"Password is empty, please fill preemptively.");
	$salah    = true;
}
else if($userpassword!=$userpasswordconf)
{
	$pesan[4] = array("pesan"=>"The first password is not the same as a second password, please try again.");
	$salah    = true;
}
else if(empty($userfullname))
{
	$pesan[6] = array("pesan"=>"Full Name is empty, please fill preemptively.");
	$salah    = true;
}
else if(!preg_match("/^[a-z0-9]+([\w-])*(((?<![_-])\.(?![_-]))[\w-]*[a-z0-9])*@(?![-])([a-z0-9-]){2,}((?<![-])\.[a-z]{2,6})+$/i", $useremail))
{
	$pesan[17] = array("pesan"=>"Email is empty or writing emails less true, please use preemptively.");
	$salah     = true;
}
else if($jumlahemail > 0)
{
	$pesan[20] = array("pesan"=>"Address <strong>$useremail</strong> is already being used by someone else, please choose another.");
	$salah     = true;
}
else if(!preg_match('/^[a-zA-z0-9_]{3,25}$/',$username) && !empty($username))
{
	$pesan[1] = array("pesan"=>"One writing username, Username can only use letters, numbers and signs (-). Not less than 3 letters and no more than 25 characters.");
	$salah    = true;
}
else if(empty($username))
{
	$pesan[2] = array("pesan"=>"Username Name is empty, please fill preemptively.");
	$salah    = true;
}
else if($jumlah > 0)
{
	$pesan[19] = array("pesan"=>"Username <strong>$username</strong> is already being used by someone else, please choose another.");
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
	
    $query = "insert into tbl_member (userid,username,userfullname,userpassword,useremail,userphonegsm,cityname,usercreateddate,fbcid,gpcid,tw_token,tw_secret,useractivestatus)
			 values ('$baru','$username','$userfullname','$userpassword1','$useremail','$userphonegsm','$cityname','$tanggal','$fbid','$gpid','$tw_token','$tw_secret','1')";
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
		
		//kirimSMS($userphonegsm,"Terima kasih sudah mendaftar di $title, kami akan periksa keanggotaan Anda terlebih dahulu sebelum Anda bisa login");

			$isi = "Email Registration Confirmation $title
			=========================================================================

			Dear. $userfullname,

			Congratulations Your registration has been successfully carried out, but
			you can not directly login. You must first confirm
			registration by clicking the following URL:

			$fulldomain"."/member/aktifasi/$code

			Username : $username / $useremail
			Password : $userpassword

			After you confirm you can log in and can immediately
			complements the identity and other information about your $title
			so you can enjoy all the facilities provided.

			Thank you
			$owner";

			$isihtml = "<br />
			<strong>Email Registration Confirmation $title</strong>
			=========================================================================<br />
			Dear. $userfullname,<br />
			Congratulations Your registration has been successfully carried out, but
			you can not directly login. You must first confirm
			registration by clicking the following URL:<br />
			<br />

			<a href='$fulldomain"."/member/aktifasi/$code'>$fulldomain"."/member/aktifasi/$code</a>
			<br />
			<br />

			Username : $username / $useremail<br />
			Password : $userpassword
			<br />
			<br />

			After you confirm you can log in and can immediately
			complements the identity and other information about your $title
			so you can enjoy all the facilities provided.
			<br />
			<br />

			Thank you<br />

			$owner";

			$subject = "Account $title, continue your registration process.";

			sendmail($userfullname,$useremail,$subject,$isi,$isihtml);
		
			//Jika dari cart
			if($fromcart=="1")
			{
				$perintah	= "select userid,userfullname,username,userdirname,avatar,verified,fbcid,twcid,gpcid,refuserid,tipe from tbl_member where username='$username'";
				$hasil 		= sql($perintah);
				
				
				if(sql_num_rows($hasil)<1)
				{
					header("location: $fulldomain/user/usernameerror");
					exit();
				}
				else
				{
					$row          = sql_fetch_data($hasil);
					$userid       = $row['userid'];
					$username     = $row['username'];
					$userfullname = $row['userfullname'];
					$userdirname  = $row['userdirname'];
					$avatar       = $row['avatar'];
					$verified     = $row['verified'];
					$fbcid        = $row['fbcid'];
					$twcid        = $row['twcid'];
					$gpcid        = $row['gpcid'];
					$refuserid    = $row['refuserid'];
					$tipe         = $row['tipe'];
					
				   
					session_start();	
					$_SESSION['userid'] 		= $userid;
					$_SESSION['userfullname'] 	= $userfullname;
					$_SESSION['username'] 		= $username;
					$_SESSION['userdirname'] 	= $userdirname;
					$_SESSION['verified'] 		= $verified;
					$_SESSION['avatar'] 		= $avatar;
					$_SESSION['pss'] 			= $pass;
					$_SESSION['fbcid'] 			= $fbcid;
					$_SESSION['twcid'] 			= $twcid;
					$_SESSION['gpcid'] 			= $gpcid;
					$_SESSION['contactid'] 		= $refuserid;
					$_SESSION['usertipe'] 		= $tipe;
					
					if($refuserid>0)
					{
						setcookie("contactid","$refuserid", time() + (86400 * 30 * 365), "/", ".sygmadayainsani.co.id"); // 86400 = 1 day
					}
					else
					{
						setcookie("contactid","$userid", time() + (86400 * 30 * 365), "/", ".sygmadayainsani.co.id"); // 86400 = 1 day
					}
			   
					
					$userlastloggedin = date("Y-m-d H:i:s");
					
					
					$views = "update tbl_member_stats set login=login+1 where userid='$userid'";
					$hsl = sql( $views);
					
					$views = "update tbl_member set userlastloggedin='$userlastloggedin',userlastactive='$userlastloggedin' where userid='$userid'";
					$hsl = sql( $views);
					
					$views 	= "update tbl_transaksi set userid='$userid' where orderid='$_SESSION[orderid]'";
					$hsl 	= sql($views);
							
					if((!$_SESSION['last']) || ($_SESSION['last']=="/")) $pelempar = "$fulldomain/user"; 
					else $pelempar = $_SESSION['last'];
					
					
					header("location: $fulldomain/cart/checkout");
					exit();
					
				}

			}
		$pesanhasil = "Congratulations you have been registered in the $title, username that you can use is <b>$username</b> and password as you have set and <b>we've sent to your email</b>, 
	   		Keep your password and do not forget. <b>please open your email.</b>";
		$berhasil = 1;
		session_destroy(); 
	}
			
}
else
{
	$pesanhasil = "Failing to do your registration possibilities There are some errors that should be fixed first, please check back errors below.";
	$berhasil = "0";
}	
$tpl->assign("pesan",$pesan);
$tpl->assign("pesanhasil",$pesanhasil);
$tpl->assign("berhasil",$berhasil);
?>