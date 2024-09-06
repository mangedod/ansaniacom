<?php 
if(isset($_POST['userfullname']))
{
	$useremail			= $_POST['useremail'];
	$userfullname		= $_POST['userfullname'];
	$date				= $_POST['date'];
	$month				= $_POST['month'];
	$year				= $_POST['year'];
	$usergender			= $_POST['usergender'];
	$userphone			= $_POST['userphone'];
	$userphonegsm		= $_POST['userphonegsm'];
	$fbid				= $_POST['fbid'];
	$twitterid			= $_POST['twitterid'];
	$idpekerjaan		= $_POST['pekerjaanid'];
	$idpendidikan 		= $_POST['pendidikanid'];
	$userdob 			= "$year-$month-$date";

	$query	= "update tbl_member set userfullname='$userfullname',usergender='$usergender', userdob='$userdob',userphone='$userphone',userphonegsm='$userphonegsm' where userid='$_SESSION[userid]'";
	//, pekerjaanid='$idpekerjaan', pendidikanid='$idpendidikan', fbid='$fbid',twitterid='$twitterid'
	$hasil 	= sql($query);
			
	if($hasil)
	{
		$error 		= "Welcome your data in $title has been changed successfully, Make changes periodically profile tailored to your current condition.";
		$style		= "alert-success";
		$backlink	= "$fulldomain"."/member/setting";
	}
	else
	{
		$error 		= "Data storage fails to do there are some errors that should be corrected, please check back.";
		$style		= "alert-danger";
		$backlink	= "$fulldomain"."/member/setting";
	}

	$tpl->assign("error",$error);
	$tpl->assign("style",$style);
	$tpl->assign("backlink",$backlink);
}

	$perintah 	= "select * from tbl_member where userid='$_SESSION[userid]'";
	$hasil 		= sql($perintah);
	$data 		= sql_fetch_data($hasil);
		
	$username 			= $data['username'];
	$userfullname		= $data['userfullname'];
	$userphone			= $data['userphone'];
	$userphonegsm		= $data['userphonegsm'];
	$useremail			= $data['useremail'];
	$usergender			= $data['usergender'];
	$idpekerjaan		= $data['pekerjaanid'];
	$idpendidikan		= $data['pendidikanid'];
	$YMId				= $data['YMId'];
	$fbid				= $data['fbid'];
	$twitterid			= $data['twitterid'];
	$DOB 				= explode("-",$data['userdob']);
	
	if(preg_match("/@/i",$username))
	{
		$uname1	= explode("@",$username);
		$uname	= $uname1[0];
	}
	else $uname = $username;
	
	$namalengkap		= explode(" ",$userfullname);
	$cnama				= count($namalengkap);
	$firstname			= $namalengkap[0];
	$lastname			= "";
	for($n=1; $n<=$cnama; $n++)
	{
		$lastname .= $namalengkap[$n]. " ";
	}
	
	$lastname = trim($lastname);
	
	$tpl->assign("username",$uname);
	$tpl->assign("usernameold",$username);
	$tpl->assign("userfullname",$userfullname);
	$tpl->assign("firstname",$firstname);
	$tpl->assign("lastname",$lastname);
	$tpl->assign("cityname",$cityname);
	$tpl->assign("userphone",$userphone);
	$tpl->assign("userpgsm",$userphonegsm);
	$tpl->assign("useremail",$useremail);
	$tpl->assign("usergender",$usergender);
	$tpl->assign("pekerjaanid",$idkerja);
	$tpl->assign("companies",$companies);
	$tpl->assign("fbid",$fbid);//echo $fbid;
	$tpl->assign("twitterid",$twitterid);
	
	sql_free_result($hasil);

	//dapatkan data tanggal
	$dateLoop = array();
	$tempI = 1;
	while ($tempI < 32) {
		 if ($tempI < 10){
			 array_push($dateLoop,"0".$tempI);
			 $temp2 = "0".$tempI;
		 }else{
			 array_push($dateLoop,$tempI);
			 $temp2 = $tempI;
		}
		if($temp2 == $DOB[2]) $dateSelected = $temp2;
		$tempI++;
	}

	$monthLoop = array();
	$tempI = 1;
	while ($tempI < 13) {
		 if ($tempI < 10){
			 array_push($monthLoop,"0".$tempI);
			  $temp2 = "0".$tempI;
		 }else{
			 array_push($monthLoop,$tempI);
			 $temp2 = $tempI;
		}
		if($temp2 == $DOB[1]) $monthSelected = $temp2;
		$tempI++;

	}
	
	$yearLoop = array();
	$tempI = date("Y")-80;

	while ($tempI < date("Y") - 10) {
		 array_push($yearLoop,$tempI);
		if($tempI == $DOB[0]) $yearSelected = $tempI;
		$tempI++;

	}	
	$tpl -> assign( 'yearLoop', $yearLoop );
	$tpl -> assign( 'yearSelected' , $yearSelected);
	$tpl -> assign( 'monthLoop', $monthLoop );
	$tpl -> assign( 'monthSelected' , $monthSelected);
	$tpl -> assign( 'dateLoop', $dateLoop );
	$tpl -> assign( 'dateSelected' , $dateSelected);

	//$tpl->assign("namarubrik","Account Setting");
	$tpl->assign("namarubrik","Pengaturan Akun");

	//Pekerjaan
	$datakerja = array();
	$sql 	= "select pekerjaanid,nama from tbl_pekerjaan order by nama asc";
	$hasil 	= sql($sql);
	while($data = sql_fetch_data($hasil))
	{
		$pekerjaanid	= $data['pekerjaanid'];
		
		
			if($idpekerjaan==$pekerjaanid) $select = "selected='selected'";
			else  $select = "";
		
		
		$datapekerjaan[$pekerjaanid] = array("pekerjaanid"=>$data['pekerjaanid'],"nama"=>$data['nama'],"select"=>$select);
	}
	sql_free_result($hasil);
	$tpl->assign("datapekerjaan",$datapekerjaan);

	//Pendidikan
	/*$datakerja = array();
	$sql 	= "select pendidikanid,nama from tbl_pendidikan order by pendidikanid asc";
	$hasil 	= sql($sql);
	while($data = sql_fetch_data($hasil))
	{
		$pendidikanid	= $data['pendidikanid'];
		
		
			if($idpendidikan==$pendidikanid) $select = "selected='selected'";
			else  $select = "";
		
		
		$datapendidikan[$pendidikanid] = array("pendidikanid"=>$data['pendidikanid'],"nama"=>$data['nama'],"select"=>$select);
	}
	sql_free_result($hasil);
	$tpl->assign("datapendidikan",$datapendidikan);*/
?>