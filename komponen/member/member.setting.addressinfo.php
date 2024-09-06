<?php 
	if($_POST['saveper']=="1")
	{
		
		$useraddress  = $_POST['useraddress'];
		$negaraid     = $_POST['negaraid'];
		$propinsiid   = $_POST['propinsiid'];
		$kotaid       = $_POST['cityname'];
		$cityname     = sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
		$kecid        = $_POST['kecid'];
		$userpostcode = $_POST['userpostcode'];
		
		$query	= "update tbl_member set useraddress='$useraddress',kecid='$kecid',kotaid='$kotaid',cityname='$cityname',negaraid='$negaraid',propinsiid='$propinsiid',userpostcode='$userpostcode' 
				where userid='$_SESSION[userid]'";
		$hasil 	= sql($query);
				
		if($hasil)
		{
			$error 		= "Welcome your data in $title has been changed successfully, Make changes periodically profile tailored to your current condition.";
			$style		= "alert-success";
			$backlink	= "$fulldomain"."/member/setting/addressinfo";
		}
		else
		{
			$error 		= "Data storage fails to do there are some errors that should be corrected, please check back.";
			$style		= "alert-danger";
			$backlink	= "$fulldomain"."/member/setting/addressinfo";
		}
		
		$tpl->assign("error",$error);
		$tpl->assign("style",$style);
		$tpl->assign("backlink",$backlink);
	}
	
	if($_POST['savepership']=="1")
	{
		
		$nama				= $_POST['nama'];
		$namalengkap		= $_POST['namalengkap'];
		$useraddress		= $_POST['useraddress'];
		$userphonegsm		= $_POST['userphonegsm'];
		$propinsiid			= $_POST['propinsiid'];
		$kotaid				= $_POST['cityname'];
		$kecid				= $_POST['kecid'];
		$userpostcode		= $_POST['userpostcode'];
		$date = date("Y-m-d H:i:s");
		
		$new = newid("useralamatid","tbl_member_alamat");
		
		$query	= "insert into tbl_member_alamat (useralamatid,nama,userid,userfullname,useraddress,kecid,kotaid,propinsiid,userpostcode,userphonegsm,create_date) values
					('$new','$nama','$_SESSION[userid]','$namalengkap','$useraddress','$kecid','$kotaid','$propinsiid','$userpostcode','$userphonegsm','$date')";//die($query);
		$hasil 	= sql($query);
				
		if($hasil)
		{
			$error 		= "Welcome your data in $title has been added successfully, Make changes periodically profile tailored to your current condition.";
			$style		= "alert-success";
			$backlink	= "$fulldomain"."/member/setting/addressinfo";
		}
		else
		{
			$error 		= "Data storage fails to do there are some errors that should be corrected, please check back.";
			$style		= "alert-danger";
			$backlink	= "$fulldomain"."/member/setting/addressinfo";
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
	$useraddress		= $data['useraddress'];
	$kotaId				= $data['kotaid'];
	$kecid				= $data['kecid'];
	// $kotaId				= $data['cityname'];
	$cityname			= sql_get_var("select namakota from tbl_kota where kotaid='$kotaId'");
	$userphone			= $data['userphone'];
	$userphonegsm		= $data['userphonegsm'];
	$useremail			= $data['useremail'];
	$aboutme			= $data['aboutme'];
	$usergender			= $data['usergender'];
	$userpostcode		= $data['userpostcode'];
	$negaraid			= $data['negaraid'];
	$propinsiid			= $data['propinsiid'];
	$idpekerjaan		= $data['pekerjaanid'];
	$idpendidikan		= $data['pendidikanid'];
	$affiliations		= $data['affiliations'];
	$schools 			= $data['schools'];
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
	$tpl->assign("useraddress",$useraddress);
	$tpl->assign("cityname",$cityname);
	$tpl->assign("userphone",$userphone);
	$tpl->assign("userpgsm",$userphonegsm);
	$tpl->assign("useremail",$useremail);
	$tpl->assign("aboutme",$aboutme);
	$tpl->assign("usergender",$usergender);
	$tpl->assign("userpostcode",$userpostcode);
	$tpl->assign("negaraid",$negaraid);
	$tpl->assign("propinsiid",$propinsiid);
	$tpl->assign("pekerjaanid",$idkerja);
	$tpl->assign("companies",$companies);
	$tpl->assign("fbid",$fbid);//echo $fbid;
	$tpl->assign("twitterid",$twitterid);
	$tpl->assign("kotaid",$kotaId);
	
	sql_free_result($hasil);
	
	/*TAMPIL ALAMAT LAINNYA*/
		$queryal	= "select  	useralamatid,kecid,kotaid,propinsiid,userid,nama,userfullname,useraddress,userpostcode,userphonegsm,create_date from tbl_member_alamat where userid='$_SESSION[userid]' order by create_date desc limit 3";
		$hslal		= sql($queryal);
		$detailalamat	= array();
		while($dtal = sql_fetch_data($hslal))
		{
			$useralamatid   = $dtal['useralamatid'];
			$nama           = $dtal['nama'];
			$namapenerima   = $dtal['userfullname'];
			$telppenerima   = $dtal['userphonegsm'];
			$alamatpenerima = $dtal['useraddress'];
			$kodepos        = $dtal['userpostcode'];
			$kotaid         = $dtal['kotaid'];
			$kotap          = sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
			$propinsiid     = $dtal['propinsiid'];
			$propinsip      = sql_get_var("select namapropinsi from tbl_propinsi where propid='$propinsiid'");
			$tanggal        = $dtal['create_date'];
			$tanggal        = tanggal($tanggal);
			if($telppenerima == '0' or $telppenerima == '')
			{
				$telppenerima = "-";
			}
			else
			{
				$telppenerima = $telppenerima;
			}

			$detailalamat[$useralamatid] = array("useralamatid"=>$useralamatid,"nama"=>$nama,"namapenerima"=>$namapenerima,"telppenerima"=>$telppenerima,"alamatpenerima"=>$alamatpenerima,"kodepos"=>$kodepos,"kotap"=>$kotap,"propinsip"=>$propinsip,"tanggal"=>$tanggal);
		}
		sql_free_result($hslal);
		$tpl->assign("detailalamat",$detailalamat);

	//Negara
	$datanegara = array();
	$pnegara 	= "select id,namanegara from tbl_negara order by namanegara asc";
	$hnegara 	= sql($pnegara);
	while($dnegara = sql_fetch_data($hnegara))
	{
		$idnegara	= $dnegara['id'];
		
		if($negaraid==0)
		{
			if($idnegara==97) $select = "selected='selected'";
			else  $select = "";
		}
		elseif($negaraid==$idnegara) $select = "selected='selected'";
		else $select = "";
		
		$datanegara[$idnegara] = array("id"=>$dnegara['id'],"namanegara"=>$dnegara['namanegara'],"select"=>$select);
	}
	sql_free_result($hnegara);
	$tpl->assign("datanegara",$datanegara);

	//propinsi
	$datapropinsi 	= array();
	$ppropinsi 		= "select propid,namapropinsi from tbl_propinsi order by namapropinsi asc";
	$hpropinsi 		= sql($ppropinsi);
	while($dpropinsi= sql_fetch_data($hpropinsi))
	{
		$id	= $dpropinsi['propid'];
		
		if($propinsiid==$id) $select = "selected='selected'";
		else $select = "";
		
		$datapropinsi[$id] = array("id"=>$id,"namapropinsi"=>$dpropinsi['namapropinsi'],"select"=>$select);
	}
	sql_free_result($hpropinsi);
	$tpl->assign("datapropinsi",$datapropinsi);
	
	if($propinsiid!=0)
	{
		//kota
		$sqlkota	= "select kotaid,namakota from tbl_kota where propid='$propinsiid' order by namakota asc";
		$reskota	= sql($sqlkota);
		$datakota	= array();
		while ($rowkota	= sql_fetch_data($reskota))
		{
			$idkota	= $rowkota['kotaid'];
			$kota	= $rowkota['namakota'];
			
			if($kotaid==$idkota) $select = "selected='selected'";
			else $select = "";
			
			$datakota[$idkota]	= array("idkota"=>$idkota,"kota"=>$kota,"select"=>$select);
		}
		sql_free_result($reskota);
		$tpl->assign("datakota",$datakota);
	}
		// kecamatan 
		$sqlk	= "select kecid,namakecamatan from tbl_kecamatan where propid='$propinsiid' and kotaid='$kotaid' order by namakecamatan asc";
		$queryk	= sql($sqlk);
		$datakecamatan	= array();
		while($rowk = sql_fetch_data($queryk))
		{
			$kecidd	= $rowk['kecid'];
			$namakecamatan	= $rowk['namakecamatan'];
			
			if ($kecid == $kecidd)
				$select = "selected";
			else
				$select	= "";
			
			$datakecamatan[$kecidd]	= array("kecid"=>$kecidd,"namakecamatan"=>$namakecamatan,"select"=>$select);
		}
		sql_free_result($queryk);
		$tpl->assign("datakecamatan",$datakecamatan);

	//$tpl->assign("namarubrik","Account Setting");
	$tpl->assign("namarubrik","Pengaturan Akun");
?>