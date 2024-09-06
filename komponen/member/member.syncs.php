<?php
$subaksi = $var[4];
if($subaksi == "unconnect")
{
	$akun		= $var[5];

	$query	= "update tbl_member set $akun='' where username='$_SESSION[usernameresel]'";
	$hasil = sql($query);	
	
	if($hasil)
	{
		$tpl->assign("style","done");
		$tpl->assign("pesan","Your social media syncs settings successfully performed.");
	}
	else
	{
		$tpl->assign("style","error");
		$tpl->assign("pesan","Your social media syncs settings failed.");
	}
}

$perintah 	= "select fbcid,twcid,gpcid from tbl_member where username='$_SESSION[usernameresel]'";
$hasil 		= sql($perintah);
$data 		= sql_fetch_data($hasil);
sql_free_result($hasil);

$fbcid		= $data[fbcid];
$twid		= $data[twcid];
$gpcid		= $data[gpcid];

$tpl->assign("fbcid",$fbcid);
$tpl->assign("twid",$twid);
$tpl->assign("gpcid",$gpcid);
?>