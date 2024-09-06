<?php
$viewer = $_GET['viewer'];
$userid = $var[4];

$perintah 	= "select userid,userdob,usergender,username,userfullname,useraddress,userphone,userphonegsm,useraddress,propinsiid,kotaid,kecid,
					useremail,userpostcode,negaraid,propinsiid,userstatus,avatar,userlastactive,userlastloggedin,useractivestatus,point,aboutme from tbl_member where userid='$userid'";

$hasil		= sql($perintah);
$data 		= sql_fetch_data($hasil);

$result['status'] = "OK"; 
$result['message'] = "Profil member berhasil diload";


if($viewer!==$data['username'])
{
	$vid = sql_get_var("select userid from tbl_member where username='$viewer'");
	
	//cek teman or bukan
	$jumfollow	= sql_get_var("select count(*) as jml from tbl_follow where userid='$vid' and fid='$data[userid]'");

	if ($jumfollow > 0) 
		$statusteman	= 1; //liat profil temen -> teman
	else 
		$statusteman	= 0; //bukan temen
}
else
	$statusteman	= 2; //liat profil sendiri
	
if($statusteman==1)
	$isFollow="Yes";
else if($statusteman==0)
	$isFollow="No";
else if ($statusteman==2)
	$isFollow="My Profile";

$userdob = $data['userdob'];
$dob = explode("-",$userdob);

$result['userdob'] = "$dob[2]/$dob[1]/$dob[0]";

$result['user_id'] = $data['userid'];	
$result['user_type'] = $tipe;
$result['username'] = $data['username'];
$result['userfullname'] = $data['userfullname'];
$result['useremail'] = $data['useremail'];
$result['usergender'] = $data['usergender'];

$result['useraddress']		= $data['useraddress'];
$result['userabout']		= $data['aboutme'];
$result['userpostcode']		= $data['userpostcode'];
$result['point']		= $data['point'];
$result['propinsiid']		= $data['propinsiid'];
$result['kotaid']		= $data['kotaid'];
$result['kecid']		= $data['kecid'];


$result['userphone']			= $data['userphone'];
$result['userphonegsm']		= $data['userphonegsm'];
if($data['userstatus'])
	$result['userstatus']			= $data['userstatus'];
else
	$result['userstatus']	="";
$avatar = $data['avatar'];
if(empty($avatar))
{ 
	$avatar = "$domainmedia/gambar/avatar-default.png"; 
}
else
{
	$avatar = str_replace("-m","-f",$avatar);				
	$avatar = "$domainmedia/avatars/$avatar"."?".strtotime("now");
}
$result['avatar']=$avatar;
$result["activestatus"] =  $data['useractivestatus'];
if($data['useractivestatus']==0)
	$notifikasi="Anda belum melakukan konfirmasi akun. Lakukan konfirmasi akun untuk dapat menikmati fasilitas";
else
	$notifikasi="";
$result["notifikasiakun"] =  $notifikasi;
$result["lastloggedin"] =  tanggal($data['userlastloggedin']);
$result["lastactive"] =  $data['userlastactive'];
$result["createdate"] = tanggalonly($data['create_date']);
$result["updatedate"] =  $data['update_date'];

$uid=$data['userid'];

if($statsupdate==0)
{
	$follower	= sql_get_var("select count(*) as jml from tbl_follow where fid='$uid'");
	$following	= sql_get_var("select count(*) as jml from tbl_follow where userid='$uid'");
	
	if(!empty($uid))
	{
		$insert  = "update tbl_member set follower='$follower',following='$following',posting='$posting',statsupdate='1' where userid='$uid'";
		$sinsert = sql($insert);
	}
}
$result['follower'] 			= $follower;
$result['following'] 			= $following;

$result['posting']	= sql_get_var("select count(*) as jml from tbl_post where userid='$uid'");

$result['jmlnotif']	= sql_get_var("select count(*) as jml from tbl_notifikasi where tousername='$data[username]' and status='0'");



$result['likeposting'] = $jumlike;
$result['isFollow'] = $isFollow;

echo json_encode($result);
?>