<?php 
$postid = $var[4];

$perintah	= "delete from tbl_post_komen where username='$_SESSION[usernameresel]' and postid='$postid'";
$hasil	=  sql($perintah);

if($hasil)
{
	$perintah2	= "delete from tbl_post where username='$_SESSION[usernameresel]' and postid='$postid'";
	$hasil2		=  sql($perintah2);
	
	if($hasil2)
	{
		$sqlp	= "update tbl_member set posting=posting-1 where username='$_SESSION[usernameresel]'";
		$qry = sql($sqlp);
		
		$perintah	= "delete from tbl_post_komen where postid='$postid'";
		header("location: $fulldomain/member");
		
	}
}
?>