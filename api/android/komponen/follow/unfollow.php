<?php
$user		= $_GET['userid'];
$uname		= $_GET['username'];
$foll = sql_get_var("select userid from tbl_member where username='$uname'");

	if(empty($user) || empty($foll))
	{
		$result['status']="Error";
		$result['message']="Username tidak ditemukan.";
		
		echo json_encode($result);
		exit;
	}
	else
	{
		$perintah3	= "delete from tbl_follow where fid='$foll' and userid='$user'";
		$hasil3		= sql($perintah3);
		if($hasil3)
		{
			$perintah1	= "update tbl_member set follower=follower-'1' where userid='$foll'";
			$hasil1		= sql($perintah1);
			
			$perintah2	= "update tbl_member set following=following-'1' where userid='$user'";
			$hasil2		= sql($perintah2);
					
			$result['status']="OK";
			$result['message']="Anda telah berhenti mengikuti $uname.";
			$result['username']= $uname;
			$result['userid']= $request;
			
			
			echo json_encode($result);
			exit;
		}
	}
?>