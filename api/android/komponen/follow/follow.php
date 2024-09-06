<?php
	$request	= $_GET['userid'];
	$uname	= $_GET['username'];
	$follow = sql_get_var("select userid from tbl_member where username='$uname'");
	$tipe = sql_get_var("select usertipe from tbl_member where username='$uname'");

	if(empty($request) || empty($follow))
	{
		$result['status']="Error";
		$result['message']="Username tidak ditemukan.";

		echo json_encode($result);
		exit;
	}
	else
	{
		$jml	= sql_get_var("select count(*) as jml from tbl_follow where userid='$request' and fid='$follow'");
		
		if(empty($jml))
		{
			$perintah	= "insert into tbl_follow (userid,fid,tipe) values ('$request','$follow','$tipe')";
			$hasil		= sql($perintah);
		
			if ($hasil)
			{	
				$perintah	= "update tbl_member set follower=follower+'1' where userid='$follow'";
				$hasil		= sql($perintah);
				
				$perintah	= "update tbl_member set following=following+'1' where userid='$request'";
				$hasil		= sql($perintah);
				
				setlog($_SESSION['username'],$uname,"mengikuti anda di $title","$fulldomain/member/follower");
				
				$result['status']="OK";
				$result['message']="Terimakaih telah mengikuti $uname.";
				$result['username']= $uname;
				$result['userid']= $request;
				
				
				echo json_encode($result);
				exit;
			}
		}
		else
		{
			$result['status']="Error";
			$result['message']="Username sudah terdaftar.";
			
			
			echo json_encode($result);
			exit;
		}
	}
?>