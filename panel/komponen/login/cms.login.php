<?php 
if($aksi=="login") 
{
	$user 	= $_POST['user'];
	$pass 	= md5($_POST['pass']);
	$query 	= "select userid,username,userpassword,userfullname,gid from tbl_cms_user where username='$user' and userstatus='1'";
	$result = sql($query);

	if(sql_num_rows($result) < 1)
	{
		header("location: ./index.php?aksi=error&auth=no&xx=0");
		exit();
	}
	else
	{	
		$row = sql_fetch_data($result);
		$pass2	= $row['userpassword'];
		if($pass != $pass2)
		{
			header("location: ./index.php?aksi=error&auth=no&xx=1");		
			exit();			
		}
		else
		{
			$userid 		= $row['userid'];
			$username 		= $row['username'];
			$gid			= $row['gid'];
			$userfullname	= $row['userfullname'];
	
			$perintah 	= "select namagroup,otoritas from tbl_cms_usergroup where gid='$gid'";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);
			$otoritas 	= $data['otoritas'];
			$namagroup 	= $data['namagroup'];
			
			session_start();
			
			$_SESSION['cms_userid'] 		= $userid;
			$_SESSION['cms_username'] 		= $username;
			$_SESSION['cms_gid'] 			= $gid;
			$_SESSION['cms_userfullname'] 	= $userfullname;
			$_SESSION['cms_otoritas'] 		= $otoritas;
			$_SESSION['cms_namagroup'] 		= $namagroup;
			
			header("location: ./index.php?kanal=dashboard");
			exit();
		
		}
	}
}

else if($aksi=="logout")
{
	unset($_SESSION['cms_userid'],$_SESSION['cms_username'],$_SESSION['cms_gid'],$_SESSION['cms_userfullname'],$_SESSION['cms_otoritas'],$_SESSION['cms_namagroup']);
	session_destroy();
	$lokasi	= "location: ./index.php";
	header($lokasi);
	exit();
	
}


else
{
	header("location: ./index.php?aksi=error&auth=no&xx=0");
	exit();
}
?>	
