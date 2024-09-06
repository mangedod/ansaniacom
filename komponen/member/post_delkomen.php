<?php 
$postid=$var[4];
$id=$var[5];
	
$perintah="delete from tbl_post_komen where username='$_SESSION[usernameresel]' and id='$id'";
$hasil= mysql_query($perintah);
if($hasil)
{
	$sql="select jmlKomen from tbl_post where postid='$postid'";
	$hsl= mysql_query($sql);
	
	$jmlKomen = sql_result($hsl,0,jmlKomen);	
	if($jmlKomen > 0)
	{
		$jumlah=$jmlKomen -1;
		
		$mysql="update tbl_post set jmlKomen='$jumlah' where postid='$postid'";
		$result= mysql_query($mysql);
		if($result)
			header("location:$fulldomain/member");
	}
}
?>