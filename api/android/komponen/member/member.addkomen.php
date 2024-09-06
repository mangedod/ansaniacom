<?php 
$postid	= $_POST['postid'];
$komentar	= cleaninsert($_POST['komentar']);
$tanggal = date("Y-m-d H:i:s");
$userid	= $_POST['userid'];

$datamember = sql_get_var_row("select userfullname,userid,username from tbl_member where userid='$userid'");
$username = $datamember['username'];

if($username)
{
	$perintah="insert into tbl_post_komen(postid,username,userfullname,userid,isi,tanggal) values ('$postid', '$username', '$datamember[userfullname]', '$datamember[userid]','$komentar', '$tanggal')";
	$hasil=  sql($perintah);

	if($hasil)
	{
		
		$uid = sql_get_var("select userid from tbl_post where postid='$postid'");
		$postUser = sql_get_var("select username from tbl_member where userid='$uid'");
		
		//Notifikasi
		if($postUser!=$username) setlog($username,$postUser,"mengomentari status anda","$basedomain/user/post/$postid");
		
		$jmlcomment = sql_get_var("select count(*) as jml from tbl_post_komen where postid='$postid'");
		$prnth	= "update tbl_post set jmlkomen='$jmlcomment' where postid='$postid'";
		$re		=  sql($prnth);
		
		$sql	= "select username from tbl_post_komen where postid='$postid' and username!='$username' and username!='$postUser' group by username";
		$query	=  sql($sql);
		while($row = sql_fetch_data($query))
		{
			$userName2	= $row['username'];
			setlog($username,$userName2,"mengomentari komentar $postUser","$basedomain/user/post/$postid","komentar");
		}
		$result["status"]  = "OK";
		$result["message"] = "$username berhasil mengomentari status $postUser";
		$result["username"] = $username;
		$result["id"] = $id;
		$result["postUser"] = $postUser;
		$result["komentar"] = $komentar;
		
		echo json_encode($result);
		exit;
	}
}
else
{
	$result["status"]  = "ERROR";
	$result["message"] = "$username gagal mengomentari status $postUser";
	
	echo json_encode($result);
	exit;
}
?>