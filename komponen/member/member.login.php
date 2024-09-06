<?php
if(isset($_POST['user']))
{
	$user 		= $_POST['user'];
	$user 		= str_replace("'","`",$user);
	$pass 		= $_POST['pass'];
	$password 	= md5($pass);	
	$perintah	= "select userid,userfullname,username,useremail,userphonegsm,userpassword,userdirname,avatar,verified,fbcid,twcid,gpcid,tipe,resellerjenisid from tbl_member where (username='$user' or useremail='$user' or userphonegsm='$user') and userpassword='$password' and useractivestatus='1'";
	$hasil 		= sql($perintah);
	$row          = sql_fetch_data($hasil);

	$userid       = $row['userid'];
	$username     = $row['username'];
	$useremail    = $row['useremail'];
	$userphonegsm    = $row['userphonegsm'];
	$userpassword = $row['userpassword'];
	$userfullname = $row['userfullname'];
	$userdirname  = $row['userdirname'];
	$avatar       = $row['avatar'];
	$verified     = $row['verified'];
	$fbcid        = $row['fbcid'];
	$twcid        = $row['twcid'];
	$gpcid        = $row['gpcid'];
	$tipe        = $row['tipe'];

	$resellerjenisid        = $row['resellerjenisid'];

	if(($username != $user) && ($useremail != $user) && ($userphonegsm != $user))
	{
		$pesan = "<strong>Username</strong> or <strong>Email</strong> you have entered wrong. Please check back <strong>username</strong> You, if you still have trouble with the login, please contact Your System Administator";
		$tpl->assign("notifpesan",$pesan);
	}
	elseif($userpassword != $password)
	{
		$pesan = "<strong>Password</strong> you have entered wrong. Please check back <strong>password</strong> password, if you still have trouble to login, please contact Your System Administator";
		$tpl->assign("notifpesan",$pesan);
	}
	else
	{
		session_start();	
		$_SESSION['userid']       = $userid;
		$_SESSION['userfullname'] = $userfullname;
		$_SESSION['username']     = $username;
		$_SESSION['userdirname']  = $userdirname;
		$_SESSION['verified']     = $verified;
		$_SESSION['avatar']       = $avatar;
		$_SESSION['pss']          = $pass;
		$_SESSION['fbcid']        = $fbcid;
		$_SESSION['twcid']        = $twcid;
		$_SESSION['gpcid']        = $gpcid;
		$_SESSION['tipe']        = $tipe;
		$_SESSION['resellerjenisid']        = $resellerjenisid;
   
		
		$userlastloggedin = date("Y-m-d H:i:s");
		
		
		$views = "update tbl_member_stats set login=login+1 where userid='$userid'";
		$hsl = sql( $views);
		
		$lastip = $_SERVER['REMOTE_ADDR'];
		$views = "update tbl_member set userlastloggedin='$userlastloggedin',userlastactive='$userlastloggedin',lastip='$lastip' where userid='$userid'";
		$hsl = sql( $views);
				
		if((!$_SESSION['last']) || ($_SESSION['last']=="/")) $pelempar = "$fulldomain"."/member"; 
		else $pelempar = $_SESSION['last'];
		
		
		header("Location: $pelempar");
		exit();


	}
}
?>	
