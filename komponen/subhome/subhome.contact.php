<?php 
if($getdomain==$basedomain)
{
	if(!$_COOKIE['contactid'])
	{	
		//$contactid = sql_get_var("select userid from tbl_member order by rand() limit 1");
		$contactid = 3;
		setcookie("contactid","$contactid", time() + (86400 * 30 * 365), "/", ".sygmadayainsani.co.id"); // 86400 = 1 day
	}
	else
	{
		$contactid = $_COOKIE['contactid'];
	}
}
else
{
	$contactid = sql_get_var("select userid from tbl_member where username='$userdomreseller'");
	if(empty($contactid)) $contactid = 3; //$contactid = sql_get_var("select userid from tbl_member order by rand() limit 1");
	
	setcookie("contactid","$contactid", time() + (86400 * 30 * 365), "/", ".sygmadayainsani.co.id"); // 86400 = 1 day
		
}


//profil photo
$perintah	="select userid,userfullname,avatar,posting,follower,following,tema,usergender,useraddress,cityname,useremail,userphonegsm from tbl_member where userid='$contactid' limit 1";
$hasil= sql($perintah);
$profil= sql_fetch_data($hasil);
sql_free_result($hasil);

$iduser = $profil['userid'];
$contactname = $profil['userfullname'];
$avatar = $profil['avatar'];
$contactuseremail = $profil['useremail'];
$contactuserphone = $profil['userphonegsm'];

$avatar = str_replace("-m.","-f.",$avatar);

$online = sql_get_var("select userid from tbl_useronline where userid='$contactid'");
if($online>0) $online = "1";

if ($avatar)
	$linkphoto="$fulldomain/uploads/avatars/$avatar";
else
	$linkphoto="$lokasiwebtemplate/images/no_pic.jpg";


$tpl->assign("contactphoto",$linkphoto);	
$tpl->assign("contactname",$contactname);
$tpl->assign("contactonline",$online);
$tpl->assign("contactid",$contactid);


?>