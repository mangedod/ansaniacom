<?php 
$postid = $var[5];
$userid = $var[4];

//Hapus Media
$media = sql_get_var("select media from tbl_post where userid='$userid' and postid='$postid'");

if(!empty($media))
{
	$media = unserialize($media);
	$mediaid = $media['mediaid'];
	$mcontent = $media['gambar'];
	$mlokasi = $media['lokasi'];
	$mcontent = $media['media'];
	$myoutubeid = $media['youtubeid'];
	$mnama = $media['nama'];
	$mcontent = "$fulldomain/$mcontent";
	$murl = $media['url'];	
	
	$medias = sql_get_var_row("select gambar,gambar_s,gambar_m,gambar_l,gambar_f from tbl_post_media where userid='$userid' and mediaid='$mediaid'");
	
	$lokasi = "$lokasimember/userfiles/$mlokasi/";
	
	if(file_exists("$lokasi/$medias[gambar]")) { unlink("$lokasi/$medias[gambar]"); }
	if(file_exists("$lokasi/$medias[gambar_s]")) { unlink("$lokasi/$medias[gambar_s]"); }
	if(file_exists("$lokasi/$medias[gambar_m]")) { unlink("$lokasi/$medias[gambar_m]"); }
	if(file_exists("$lokasi/$medias[gambar_l]")) { unlink("$lokasi/$medias[gambar_l]"); }
	if(file_exists("$lokasi/$medias[gambar_f]")) { unlink("$lokasi/$medias[gambar_f]"); }
	
	$perintah	= "delete from tbl_post_media where usrerid='$userid' and mediaid='$mediaid'";
	$hasil	=  sql($perintah);

}

$perintah	= "delete from tbl_post_komen where postid='$postid'";
$hasil	=  sql($perintah);

if($hasil)
{
	$perintah2	= "delete from tbl_post where userid='$userid' and postid='$postid'";
	$hasil2		=  sql($perintah2);
	
	if($hasil2)
	{
		$sqlp	= "update tbl_member set posting=posting-1 where username='$_SESSION[username]'";
		$qry = sql($sqlp);
		
		$perintah	= "delete from tbl_post_komen where postid='$postid'";
		$hasil	=  sql($perintah);
		
	}
}
$result['status']="OK";
$result['message']="Data berhasil di delete";

echo json_encode($result);
?>