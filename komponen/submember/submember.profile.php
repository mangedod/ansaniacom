<?php 
if(!$_SESSION['username']) { header("location: $fulldomain/member/haruslogin"); }	
$perintah = "select * from tbl_member where userid='$var[4]' or username='$var[4]'";
$hasil    = sql($perintah);
$data     = sql_fetch_data($hasil);
sql_free_result($hasil);

$userName         = $data['username'];
$tahun            = $data['tahun'];
$profilId         = $data['userid'];
$userFullName     = ucwords($data['userfullname']);
$userAddress      = $data['useraddress'];
$cityName         = $data['cityname'];
$userPhone        = $data['userphone'];
$userPhoneGSM     = $data['userphonegsm'];
$userHomepage     = $data['userhomepage'];
$userEmail        = str_replace("@","(at)",$data['useremail']);
$aboutme          = bersih($data['aboutme']);
$userGender       = $data['usergender'];
$userReligion     = $data['userreligion'];
$userPostCode     = $data['userpostcode'];
$DirNameuser      = $data['userdirname'];
$negaraId         = $data['negaraid'];
$propinsiId       = $data['propinsiid'];
$affiliations     = $data['affiliations'];
$companies        = $data['companies'];
$schools          = $data['schools'];
$wiseword         = $data['wiseword'];
$marriageStatusId = $data['marriagestatusid'];
$YMId             = $data['ymid'];
$fbid             = $data['fbid'];
$twitterid        = $data['twitterid'];
$userHobi         = $data['userhobi'];
$avatar           = $data['avatar'];
$DOB              = tanggaltok($data['userdob']);

//Negara
$datanegara = array();
$pnegara = "select id,namanegara from tbl_negara where id='$negaraId'";
$hnegara = sql($pnegara);
$dnegara= sql_fetch_data($hnegara);
$negaraId = $dnegara['negara'];

//propinsi
$datapropinsi = array();
$ppropinsi = "select propid,namapropinsi from tbl_propinsi where propid='$propinsiId'";
$hpropinsi = sql($ppropinsi);
$dpropinsi= sql_fetch_data($hpropinsi);
$propinsiId = $dpropinsi['namapropinsi'];
sql_free_result($hpropinsi);

if(!empty($userHomepage) && !preg_match("/http/i",$userHomepage))
{
	$userHomepage = "http://$userHomepage";
}

$tpl->assign("p_userName",$userName);
$tpl->assign("p_tahun",$tahun);
$tpl->assign("p_userFullName",$userFullName);
$tpl->assign("p_userAddress",ucwords($userAddress));
$tpl->assign("p_userDOB",$DOB);
$tpl->assign("p_cityName",ucwords($cityName));
$tpl->assign("p_userPhone",$userPhone);
$tpl->assign("p_userPhoneGSM",$userPhoneGSM);
$tpl->assign("p_userFlexiPhone",$userFlexiPhone);
$tpl->assign("p_userHomepage",$userHomepage);
$tpl->assign("p_userEmail",$userEmail);
$tpl->assign("p_aboutme",$aboutme);
$tpl->assign("p_userGender",ucwords($userGender));
$tpl->assign("p_userReligion",$userReligion);
$tpl->assign("p_userPostCode",$userPostCode);
$tpl->assign("p_negaraId",$negaraId);
$tpl->assign("p_propinsiId",$propinsiId);
$tpl->assign("p_marriageStatusId",ucwords($marriageStatusId));
$tpl->assign("p_companies",$companies);
$tpl->assign("p_schools",$schools);
$tpl->assign("p_wiseword",$wiseword);
$tpl->assign("p_affiliations",$affiliations);
$tpl->assign("p_YMId",$YMId);
$tpl->assign("p_userHobi",$userHobi);
$tpl->assign("p_fbid",$fbid);
$tpl->assign("p_twitterid",$twitterid);


//profesi
$dataprofesi = array();
$pprofesi = "select id,profesi from tbl_work order by profesi asc";
$hprofesi = sql($pprofesi);
while($dprofesi= sql_fetch_data($hprofesi))
{
	$dataprofesi[$dprofesi['id']] = array("id"=>$dprofesi['id'],"profesi"=>$dprofesi['profesi']);
}
sql_free_result($hprofesi);
$tpl->assign("dataprofesi",$dataprofesi);

	
	
if($avatar)
	$linkphoto="$fulldomain/uploads/avatars/$avatar";
else
$linkphoto="$lokasiwebtemplate/images/no_pic.jpg";
$tpl->assign("p_avatar",$linkphoto);	


?>