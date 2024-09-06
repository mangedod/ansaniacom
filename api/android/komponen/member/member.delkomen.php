<?php 
$postid = $var[5];
$userid = $var[4];
$id = $var[6];

	
$perintah="delete from tbl_post_komen where userid='$userid' and postid='$postid' and id='$id'";
$hasil= sql($perintah);

if($hasil)
{
	$jmlcomment = sql_get_var("select count(*) as jml from tbl_post_komen where postid='$postid'");

	$mysql="update tbl_post set jmlkomen='$jmlcomment' where postid='$postid'";
	$result= sql($mysql);
	
	if($result)
	{
		$result1['status'] = "OK";
		$result1['message'] = "Hapus Komentar posting berhasil.";

		
		echo json_encode($result1);
		exit;
	}
}
else
{
	$result1['status'] = "ERROR";
	$result1['message'] = "Hapus Komentar posting gagal.";
	
	
	echo json_encode($result1);
	exit;
}
?>