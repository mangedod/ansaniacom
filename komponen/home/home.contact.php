<?php 
if($getdomain==$basedomain)
{
	if(!$_COOKIE['contactidx'])
	{	
			$contactid = sql_get_var("select userid from tbl_member where tipe!='0' and pilihan='1'  and verified='2' order by rand() limit 1");

		setcookie("contactidx","$contactid", time() + (86400 * 30 * 365), "/", ".sygmadayainsani.co.id"); // 86400 = 1 day
	}
	else
	{
		$contactid = $_COOKIE['contactidx'];
	}
}
else
{
	$contactid = sql_get_var("select userid from tbl_member where username='$userdomain'");
	if(empty($contactid))$contactid = sql_get_var("select userid from tbl_member where tipe!='0' and verified='2' and pilihan='1' order by rand() limit 1");
	
	setcookie("contactidx","$contactid", time() + (86400 * 30 * 365), "/", ".sygmadayainsani.co.id"); // 86400 = 1 day
		
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

$sql         = "select namadomain from tbl_domain where userid='$iduser' limit 1";
$hsl         = sql($sql);
$data        = sql_fetch_data($hsl);
$contactnamadomain    = $data['namadomain'];
sql_free_result($hsl);

$contactdomain = "$contactnamadomain";


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
$tpl->assign("contactdomain",$contactdomain);
?>