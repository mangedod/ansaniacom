<?php
	session_start();
	require_once('twitteroauth/twitteroauth.php');
	require_once('config.php');
	include '../../setingan/global.inc.php';
	include '../../setingan/web.config.inc.php';
	
	/* If access tokens are not available redirect to connect page. */
	if(empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) 
	{
		if($_SESSION['username']) header("location: ./clearsessions.php?sess=$_SESSION[userid]");
		else header("location: ./clearsessions.php");
	}
	/* Get user access tokens out of the session. */
	$access_token = $_SESSION['access_token'];
	
	/* Create a TwitterOauth object with consumer/user tokens. */
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
	/* If method is set change API call made. Test is called by default. */
	$content 	= $connection->get('account/verify_credentials');
	$twid		= $content->id;
	$twname		= $content->name;
	$twpicture	= $content->profile_image_url;
	$twuname	= $content->screen_name;
	
	$isusingtw = sql_get_var("SELECT COUNT(*) FROM tbl_member WHERE twcid='$twid'");
	
	if(!empty($twid))
	{			
		$_SESSION['twid'] 			= $twid;
		$_SESSION['twname'] 		= $twname;
		$_SESSION['twpicture'] 		= $twpicture;
		$_SESSION['twuname'] 		= $twuname;
	
		if($_SESSION['username'])
		{
			if(empty($isusingtw))
			{
				$tw_token 	= $_SESSION['access_token']['oauth_token'];
				$tw_secret 	= $_SESSION['access_token']['oauth_token_secret'];
				
				$perintah 	= "update tbl_member set twcid='$twid',tw_token='$tw_token',tw_secret='$tw_secret',twitterid='@$twuname' where username='$_SESSION[username]'";
				$hasil 		= sql($perintah);
				if($hasil)
				{
					$_SESSION['twcid'] = $twid;
					header("location:$fulldomain/member/syncs");
					exit();
				}
			}
			else
			{
				$perintah 	= 'SELECT userid,username,userfullname,userDirname,avatar,fbcid,twcid,gpcid,verified from tbl_member where twcid='.$twid.' and userActiveStatus=1 
							order by userid desc limit 1';
				$hasil 		= sql($perintah);
				$row      	= sql_fetch_data($hasil);
				
					$userid  		= $row['userid'];
					$username 		= $row['username'];
					$userfullname 	= $row['userfullname'];
					$userdirname 	= $row['userDirname'];
					$avatar 		= $row['avatar'];
					$fbcid 			= $row['fbcid'];
					$twcid 			= $row['twcid'];
					$gpcid 			= $row['gpcid'];
					$verified		= $row['verified'];
		
					$_SESSION['userid'] 		= $userid;
					$_SESSION['userfullname'] 	= $userfullname;
					$_SESSION['username'] 		= $username;
					$_SESSION['userdirname'] 	= $userdirname;
					$_SESSION['fbcid'] 			= $fbcid;
					$_SESSION['twcid'] 			= $twcid;
					$_SESSION['gpcid'] 			= $gpcid;
					$_SESSION['verified'] 		= $verified;
				
				sql_free_result($hasil);
			
				$userlastloggedin = date("Y-m-d H:i:s");
			
				$views 	= "update tbl_member_stats set login=login+1 where userid='$userid'";
				$hsl 	= sql($views);
				
				$lastip = $_SERVER['REMOTE_ADDR'];
				$views 	= "update tbl_member set userlastloggedin='$userlastloggedin',lastip='$lastip' where userid='$userid'";
				$hsl 	= sql($views);
		
				if($uri and (!preg_match("member/login/",$uri))) $pelempar = $uri;
					else if((!$_SESSION['last']) || ($_SESSION['last']=="/")) $pelempar = "$fulldomain/member";
					else $pelempar = $_SESSION['last'];
				
				header("Location: $pelempar");
			
				exit();
			}
		}
		else
		{
			if(empty($isusingtw))
			{
				header("location: $fulldomain/member/daftar");
				exit();
			}
			else
			{
				$perintah 	= "SELECT userid,username,userfullname,userdirname,avatar,fbcid,twcid,gpcid,verified from tbl_member where twcid='$twid' and useractivestatus=1 
							order by userid desc limit 1";
				$hasil 		= sql($perintah);
				$row      	= sql_fetch_data($hasil);
        
					$userid  		= $row['userid'];
					$username 		= $row['username'];
					$userfullname 	= $row['userfullname'];
					$userdirname 	= $row['userdirname'];
					$avatar 		= $row['avatar'];
					$fbcid 			= $row['fbcid'];
					$twcid 			= $row['twcid'];
					$gpcid 			= $row['gpcid'];
					$verified		= $row['verified'];
		
					$_SESSION['userid'] 		= $userid;
					$_SESSION['userfullname'] 	= $userfullname;
					$_SESSION['username'] 		= $username;
					$_SESSION['userdirname'] 	= $userdirname;
					$_SESSION['fbcid'] 			= $fbcid;
					$_SESSION['twcid'] 			= $twcid;
					$_SESSION['gpcid'] 			= $gpcid;
					$_SESSION['verified'] 		= $verified;
					
				sql_free_result($hasil);
	
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
	}
	else
	{
		header("location: ./clearsessions.php");
		exit();
	}
?>