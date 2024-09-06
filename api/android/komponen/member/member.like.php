<?php
$userid = $var[4];
$postid = $var[5];

$datamember = sql_get_var_row("select userfullname,userid,username from tbl_member where userid='$userid'");
$username = $datamember['username'];

if((!empty($id)) and (!empty($username)))
{
	$userid = sql_get_var("select userid from tbl_member where username='$username'");
	

	if($aksi=="like")
	{
		$perintah	= "select userid from tbl_post where postid='$postid'";
		$hasil		= sql($perintah);
		$data		= sql_fetch_data($hasil);
		$userid2		= $data['userid'];
		$tanggal	= date("Y-m-d H:i:s");
		
		$postuser = sql_get_var("select username from tbl_member where userid='$userid2'");
			
		$query	= "insert into tbl_post_like (postid,username,tanggal) values ('$postid','$username','$tanggal')";
		$hsl	= sql($query);
		if($hsl)
		{
			$mysql="update tbl_post set jmllike=jmllike+1 where postid='$postid'";
			$result= sql($mysql);
		
			if ($postuser!=$username)
			{
				setlog($username,$postuser,"menyukai status anda","$fulldomain/user/post/$postid","like");
			}
			
			$result1['status'] = "OK";
			$result1['message'] = "Like komentar berhasil.";
			$result1['username'] = $username;
			$result1['id'] = $id;
			
			
			echo json_encode($result1);
			exit;
		}
	}
	else if($aksi=="unlike")
	{
		$query	= "delete from tbl_post_like where postid='$postid' and username='$username'";
		$hsl	= sql($query);
		if($hsl)
		{
			$jmllike = sql_get_var("select count(*) as jml from tbl_post_like where postid='$postid'");

			$mysql="update tbl_post set jmllike='$jmllike' where postid='$postid'";
			$result= sql($mysql);
			
			$result1['status']="OK";
			$result1['message']="Unlike status berhasil.";
			$result1['username'] = $username;
			$result1['id'] = $id;
			
			echo json_encode($result1);
			exit;
		}
	}
}
else
{
	$result1['status'] = "ERROR";
	if(empty($id))
		$result1['message']="ID Posting kosong. Silahkan isi terlebih dahulu.";
	else if(empty($username))
		$result1['message']="Username kosong. Silahkan isi terlebih dahulu.";
		
	echo json_encode($result1);
	exit;
}
?>