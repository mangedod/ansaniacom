<?php 
if($_SESSION['fbid'])
{
	$fbid         = $_SESSION['fbid'];
	$daftaremail  = $_SESSION['fbemail'];
	$daftarname   = $_SESSION['fbname'];
	$daftaravatar = $_SESSION['fbavatar'];
	
	$tpl->assign("fbid",$fbid);
	$tpl->assign("daftaremail",$daftaremail);
	$tpl->assign("daftarname",$daftarname);
	$tpl->assign("daftaravatar",$daftaravatar);
};

if($_SESSION['me'])
{
	$gdata          = $_SESSION['me'];
	$gpid           = $gdata['id'];
	$daftaremail    = $gdata['emails'][0]['value'];
	$daftarname     = $gdata['displayName'];
	$daftaravatar   = $gdata['twpicture'];
	$daftarusername = $gdata['twuname'];
	
	$tpl->assign("gpid",$gpid);
	$tpl->assign("daftaremail",$daftaremail);
	$tpl->assign("daftarname",$daftarname);
	$tpl->assign("daftaravatar",$daftaravatar);
	$tpl->assign("daftarusername",$daftarusername);
};
?>