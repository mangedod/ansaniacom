<?php
if(isset($_POST['user']))
{
	$user 		= $_POST['user'];
	$user 		= str_replace("'","`",$user);
	$pass 		= $_POST['pass'];
	// $password 	= md5($pass."jcow");	
	$password 	= md5($pass);	
	$perintah	= "select userid,userfullname,username,userdirname,avatar,verified,fbcid,twcid,gpcid,refuserid from tbl_member where (username='$user' or useremail='$user') and userpassword='$password' and useractivestatus='1' and tipe='0'";
	$hasil 		= sql($perintah);
	
	if(sql_num_rows($hasil)<1)
	{	
		if($var[3]=='cart')
		{
			header("location: $fulldomain/user/cart/usernameerror");
			exit();
		}
		else
		{
			header("location: $fulldomain/user/usernameerror");
			exit();
		}
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
		$fbcid 			= $row['fbcid'];
		$twcid 			= $row['twcid'];
		$gpcid 			= $row['gpcid'];
		$refuserid 		= $row['refuserid'];
	   

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
		
		$views 	= "update tbl_transaksi set userid='$userid' where orderid='$_SESSION[orderid]'";
		$hsl 	= sql($views);
				
		if((!$_SESSION['last']) || ($_SESSION['last']=="/")) $pelempar = "$fulldomain/user"; 
		else $pelempar = $_SESSION['last'];
		
		
		header("Location: $pelempar");
		exit();


	}
}
?>	
