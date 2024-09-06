<?php
session_start();
include '../../setingan/global.inc.php';
include '../../setingan/web.config.inc.php';


include 'login-facebook.php';

if(isset($_SESSION['fbid']))
{
    // Redirection to login page twitter or facebook
	$isusingfb = sql_get_var("SELECT COUNT(*) FROM tbl_member WHERE fbcid=$_SESSION[fbid]");
    
    if(empty($isusingfb))
	{
        header("location: $fulldomain/member/daftar");
		exit();
	}
    else
    {
        $perintah = 'SELECT userid,username,userfullname,userdirname,avatar,fbcid,twcid,verified from tbl_member where fbcid='.$_SESSION['fbid'].' and useractivestatus=1 order by userid desc limit 1';
       	
	    $hasil = sql($perintah);
        $row      = sql_fetch_data($hasil);
        
		$userid  		= $row['userid'];
		$username 		= $row['username'];
		$userfullname 	= $row['userfullname'];
		$userdirname 	= $row['userdirname'];
		$avatar 		= $row['avatar'];
		$fbcid 			= $row['fbcid'];
		$verified		= $row['verified'];
		

		$_SESSION['userid'] 		= $userid;
		$_SESSION['userfullname'] 	= $userfullname;
		$_SESSION['username'] 		= $username;
		$_SESSION['userdirname'] 	= $userdirname;
		$_SESSION['fbcid'] 			= $fbcid;
		$_SESSION['verified'] 		= $verified;
	
		$userlastloggedin = date("y-m-d h:i:s");
	
		$views 	= "update tbl_member_stats set login=login+1 where userid='$userid'";
		$hsl 	= sql($views);
	
		$views 	= "update tbl_member set userlastloggedin='$userlastloggedin' where userid='$userid'";
		$hsl 	= sql($views);

		if($uri and (!preg_match("member/login/",$uri))) $pelempar = $uri;
		else if((!$_SESSION['last']) || ($_SESSION['last']=="/")) $pelempar = "$fulldomain/member";
		else $pelempar = $_SESSION['last'];
		
		header("Location: $pelempar");
	
		exit();
    }
}


?>