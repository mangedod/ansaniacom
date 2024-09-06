<?php
include_once "google-plus-access.php";
include '../../setingan/global.inc.php';
include '../../setingan/web.config.inc.php';

if(!$_SESSION['me'])
{
	$lokasi = $authUrl;
	header("location: $lokasi");
}
else
{
	// Redirection to login page twitter or facebook
	$data        = $_SESSION['me'];
	$displayname = $data['displayname'];
	$email       = $data['emails'][0]['value'];
	$url         = $data['url'];
	$avatar      = $data['image']['url'];
	$gpcid       = $data['id'];
	$url         = $data['url'];
	
	$_SESSION['gpid']     	= $gpcid;
	$_SESSION['gpname']   	= $displayname;
	$_SESSION['gpemail']  	= $email;
	$_SESSION['gpavatar'] 	= $avatar;
	$_SESSION['gplink'] 	= $url;
	
	$isusinggp = sql_get_var("SELECT COUNT(*) FROM tbl_member WHERE gpcid='$gpcid'");
	
	if($_SESSION['username'])
	{
		if(empty($isusinggp))
		{
			$perintah 	= "update tbl_member set gpcid='$gpcid',googleplus='$url' where username='$_SESSION[username]'";
			$hasil 		= sql($perintah);
			
			if($hasil)
				header("location:$fulldomain"."member/syncs");
		}
		else
		{
			$perintah 	= "SELECT userid,username,userfullname,userdirname,avatar,fbcid,gpcid from tbl_member where gpcid='$gpcid' and useractivestatus=1 order by userid desc limit 1";
			$hasil 		= sql($perintah);
			$row      	= sql_fetch_data($hasil);
			
				$userid  		= $row['userid'];
				$username 		= $row['username'];
				$userfullname 	= $row['userfullname'];
				$userdirname 	= $row['userdirname'];
				$avatar 		= $row['avatar'];
				$fbcid 			= $row['fbcid'];
				$gpcid 			= $row['gpcid'];
				
				$_SESSION['userid'] 		= $userid;
				$_SESSION['userfullname'] 	= $userfullname;
				$_SESSION['username'] 		= $username;
				$_SESSION['userdirname'] 	= $userdirname;
				$_SESSION['fbcid'] 			= $fbcid;
				$_SESSION['gpcid'] 			= $gpcid;
			
			sql_free_result($hasil);
			$userlastloggedin = date("y-m-d h:i:s");
		
			$views 	= "update tbl_member_stats set login=login+1 where userid='$userid'";
			$hsl 	= sql($views);
			
			$lastip = $_SERVER['REMOTE_ADDR'];
			$views 	= "update tbl_member set userlastloggedin='$userlastloggedin',lastip='$lastip' where userid='$userid'";
			$hsl 	= sql($views);
	
			if($uri and (!preg_match("member"."login/",$uri))) $pelempar = $uri;
			else if((!$_SESSION['last']) || ($_SESSION['last']=="/")) $pelempar = "$fulldomain"."member";
			else $pelempar = $_SESSION['last'];
			
			header("Location: $pelempar");
		
			exit();
		}
	}
	else
	{
		if(empty($isusinggp))
		{
			header("location: $fulldomain"."member/daftar");
			exit();
		}
		else
		{
			$perintah 	= "SELECT userid,username,userfullname,userdirname,avatar,fbcid,gpcid from tbl_member where gpcid='$gpcid' and useractivestatus=1 order by userid desc limit 1";
			$hasil 		= sql($perintah);
			$row      	= sql_fetch_data($hasil);
			
				$userid  		= $row['userid'];
				$username 		= $row['username'];
				$userfullname 	= $row['userfullname'];
				$userdirname 	= $row['userdirname'];
				$avatar 		= $row['avatar'];
				$fbcid 			= $row['fbcid'];
				$gpcid 			= $row['gpcid'];
				
				$_SESSION['userid'] 		= $userid;
				$_SESSION['userfullname'] 	= $userfullname;
				$_SESSION['username'] 		= $username;
				$_SESSION['userdirname'] 	= $userdirname;
				$_SESSION['fbcid'] 			= $fbcid;
				$_SESSION['gpcid'] 			= $gpcid;
			
			sql_free_result($hasil);
		
			$userlastloggedin = date("y-m-d h:i:s");
		
			$views 	= "update tbl_member_stats set login=login+1 where userid='$userid'";
			$hsl 	= sql($views);
		
			$views 	= "update tbl_member set userlastloggedin='$userlastloggedin' where userid='$userid'";
			$hsl 	= sql($views);
	
			if($uri and (!preg_match("member"."login/",$uri))) $pelempar = $uri;
			else if((!$_SESSION['last']) || ($_SESSION['last']=="/")) $pelempar = "$fulldomain"."member";
			else $pelempar = $_SESSION['last'];
			
			header("Location: $pelempar");
		
			exit();
		}
	}
}
?>
