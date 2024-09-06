<?php
	
	$perintah 	= "select userid,userpob,userdob,usergender,username,userfullname,useraddress,cityname,userphone,userphonegsm,
					userhomepage,useremail,aboutme,userreligion,userpostcode,negaraid,propinsiid,affiliations,companies,schools,
						wiseword,marriagestatusid,ymid,fbid,twitterid,userhobi,pvbirth,pvemail,pvaddress,pvphonegsm,pvprofile,
						pvmessage,posting,follower,following,tema,header,tipe,statsupdate,avatar from tbl_member where username='$username'";

	$hasil		= sql($perintah);
	$data 		= sql_fetch_data($hasil);
	$uid	 			= $data['userid'];
	$userpob 			= $data['userpob'];
	$userdob 			= tanggalonly($data['userdob']);
	$usergender 		= $data['usergender'];
	$name	 			= $data['username'];
	$userfullname		= $data['userfullname'];
	$useraddress		= $data['useraddress'];
	$cityname			= $data['cityname'];
	$userphone			= $data['userphone'];
	$userphonegsm		= $data['userphonegsm'];
	$userhomepage		= $data['userhomepage'];
	$useremail			= $data['useremail'];
	$aboutme			= nl2br($data['aboutme']);
	$userreligion  	 	= $data['userreligion'];
	$userpostcode		= $data['userpostcode'];
	$negaraid			= $data['negaraid'];
	$propinsiid			= $data['propinsiid'];
	$affiliations		= $data['affiliations'];
	$companies			= $data['companies'];
	$schools 			= $data['schools'];
	$wiseword 			= $data['wiseword'];
	$marriagestatusid	= $data['marriagestatusid'];
	$ymid				= $data['ymid'];
	$fbid				= $data['fbid'];
	$twitterid			= $data['twitterid'];
	$userhobi			= $data['userhobi'];
	$pvbirth			= $data['pvbirth'];
	$pvemail			= $data['pvemail'];
	$pvaddress			= $data['pvaddress'];
	$pvphonegsm			= $data['pvphonegsm'];
	$pvprofile			= $data['pvprofile'];
	$pvmessage			= $data['pvmessage'];
	$gpcid				= $data['gpcid'];
	$fbcid				= $data['fbcid'];
	$twid				= $data['twid'];
	//$posting 			= $data['posting'];
	$follower 			= $data['follower'];
	$following 			= $data['following'];
	$tema	 			= $data['tema'];
	$header	 			= $data['header'];
	$tipe	 			= $data['tipe'];
	$statsupdate		= $data['statsupdate'];
	$avatar				= $data['avatar'];
	
	$posting	= sql_get_var("select count(*) as jml from tbl_post where userid='$uid'");
	
	if(empty($avatar)){ $avatar = "$domain/images/no_pic.jpg"; 
	//$avatar = "$domain/uploads/avatar/$uid.jpg";
	}
	else
	{
		$avatar = str_replace("-m","-f",$avatar);				
		$avatar = "$lokasiwebmember/avatars/$avatar";
		//$avatar = "$domain/uploads/avatar/$uid.jpg";
	}
	
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
	
	if(empty($header))
		$header = "$fulldomain/images/no-cover.jpg";
	
	//Negara belum ada tabel nya
	/*$namanegara = sql_get_var("select namanegara from tbl_negara where id='$negaraid'");
	$tpl->assign("namanegara",$namanegara);*/
	
	$skr = date("Y-m-d");
	$umur = $skr - $data['userDOB'];
	
	if($tipe != 0)
	{
		if($tipe == '2' or tipe=='4')
			$wherepages = "and masjidid='$uid'";
		else
			$wherepages = "and ulamaid='$uid'";
			
		$video = sql_get_var("select count(*) as jml from tbl_konten where published='1' and tipe = 'video' $wherepages");
			
		$audio = sql_get_var("select count(*) as jml from tbl_konten where published='1' and tipe = 'audio' $wherepages");
		
		$agenda = sql_get_var("select count(*) as jml from tbl_agenda where published='1' $wherepages");
		
		$artikel = sql_get_var("select count(*) as jml from tbl_konten where published='1' and tipe='text' $wherepages");
		
		$photo = sql_get_var("select count(*) as jml from tbl_post_media where userid='$uid'");
		
		$tpl->assign("video",$video);
		$tpl->assign("audio",$audio);
		$tpl->assign("agenda",$agenda);
		$tpl->assign("artikel",$artikel);
		$tpl->assign("photo",$photo);
		
		$sqlr = "select id,alias from tbl_radio where 1 $wherepages";
		$qryr = sql($sqlr);
		$rowr = sql_fetch_data($qryr);
		$idradio = $rowr['id'];
		$aliasradio = $rowr['alias'];
		if(!empty($idradio))
			$urlradio = "$fulldomain/radio/read/$idradio/$aliasradio.html";
		else
			$urlradio = "$fulldomain/radio";
		
		$sqlc = "select id,alias from tbl_channel where 1 $wherepages";
		$qryc = sql($sqlc);
		$rowc = sql_fetch_data($qryc);
		$idc = $rowc['id'];
		$aliasc = $rowc['alias'];
		if(!empty($idc))
			$urllive = "$fulldomain/tv/live/watch/$aliasc";
		else
			$urllive = "$fulldomain/tv";
		
		$tpl->assign("urlradio",$urlradio);
		$tpl->assign("urllive",$urllive);
		
		if($aksi=="")
		{
			//konten audio
			$sql = "select id, nama, alias, create_date, secid, gambar1 from tbl_konten where published='1' and gambar!='' and tipe='video' $wherepages";
			$query = sql($sql);
			$row = sql_fetch_data($query);
			$idvideo = $row['id'];
			$namavideo = $row['nama'];
			$aliasvideo = $row['alias'];
			$tanggalvideo = tanggal($row['create_date']);
			$secidvideo = $row['secid'];
			$gambarvideo = $row['gambar1'];
			$secaliasvideo = sql_get_var("select alias from tbl_video_sec where secid='$secidvideo'");
			
			$urlvideo = "$fulldomain/video/read/$secaliasvideo/$idvideo/$aliasvideo.html";
			
			$ex = explode(".",$data['gambar1']);
			$temp1 = $ex[0];
			$ex2 = explode("-",$temp1);
			$countt = count($ex2);
			$idds = $ex2[$countt-1];
			
			if(!empty($gambarvideo)) $gambarvideo = "$fulldomain/media/video/$gambarvideo";
				else $gambarvideo = "$fulldomain/images/no-images.jpg";
			
			$tpl->assign("idvideo",$idvideo);
			$tpl->assign("namavideo",$namavideo);
			$tpl->assign("tanggalvideo",$tanggalvideo);
			$tpl->assign("gambarvideo",$gambarvideo);
			$tpl->assign("urlvideo",$urlvideo);
			
			//photo
			$sql = "select mediaid, nama, gambar, create_date from tbl_post_media where jenis='photo' and userid='$uid'";
			$query = sql($sql);
			$row = sql_fetch_data($query);
			$idphoto = $row['mediaid'];
			$namaphoto = $row['nama'];
			$tanggalphoto = tanggal($row['create_date']);
			$gambarphoto = $row['gambar'];
			
			$urlphoto = "$fulldomain/$name/readmedia/$idphoto";
			
			$ex = explode("-",$gambarphoto);
			$yearm = $ex[1];
			
			if(preg_match("/uploads/i",$gambarphoto))
				$gambarphoto = $gambarphoto;
			else
				$gambarphoto = "uploads/userfiles/$yearm/$gambarphoto";
			
			if(!empty($gambarphoto))
				$gambarphoto = "$fulldomain/$gambarphoto";
			
			$tpl->assign("idphoto",$idphoto);
			$tpl->assign("namaphoto",$namaphoto);
			$tpl->assign("tanggalphoto",$tanggalphoto);
			$tpl->assign("gambarphoto",$gambarphoto);
			$tpl->assign("urlphoto",$urlphoto);			
			
		}
	}
	
	$tpl->assign("userdob",$userdob);
	$tpl->assign("userpob",$userpob);
	$tpl->assign("usergender",$usergender);
	$tpl->assign("nama",$name);
	$tpl->assign("namefull",$userfullname);
	$tpl->assign("useraddress",$useraddress);
	$tpl->assign("cityname",$cityname);
	$tpl->assign("userphone",$userphone);
	$tpl->assign("userphonegsm",$userphonegsm);
	$tpl->assign("userFlexiPhone",$userFlexiPhone);
	$tpl->assign("userhomepage",$userhomepage);
	$tpl->assign("useremail",$useremail);
	$tpl->assign("aboutme",$aboutme);
	$tpl->assign("userreligion",$userreligion);
	$tpl->assign("userpostcode",$userpostcode);
	$tpl->assign("negaraid",$negaraid);
	$tpl->assign("propinsiid",$propinsiid);
	$tpl->assign("marriagestatusid",$marriagestatusid);
	$tpl->assign("companies",$companies);
	$tpl->assign("schools",$schools);
	$tpl->assign("wiseword",$wiseword);
	$tpl->assign("affiliations",$affiliations);
	$tpl->assign("ymid",$ymid);
	$tpl->assign("userhobi",$userhobi);
	$tpl->assign("fbcid",$fbcid);
	$tpl->assign("twid",$twid);
	$tpl->assign("gpcid",$gpcid);
	$tpl->assign("twitterid",$twitterid);
	$tpl->assign("fbid",$fbid);
	$tpl->assign("umur",$umur);
	$tpl->assign("pvbirth",$pvbirth);
	$tpl->assign("pvemail",$pvemail);
	$tpl->assign("pvaddress",$pvaddress);
	$tpl->assign("pvphonegsm",$pvphonegsm);
	$tpl->assign("pvprofile",$pvprofile);
	$tpl->assign("pvmessage",$pvmessage);
	$tpl->assign("posting",$posting);
	$tpl->assign("follower",$follower);
	$tpl->assign("following",$following);
	$tpl->assign("tema",$tema);
	$tpl->assign("header",$header);
	$tpl->assign("tipe",$tipe);
	
	if($uid==$_SESSION[userId]) $showmenu=1;
	else $showmenu=0;
	$tpl->assign("showmenu",$showmenu);
	
	//cek teman
	/*if($userId==$_SESSION[userId]) $stat=1;
	else $stat=0;
	
	if ($stat==0)
	{
		$jumlah	= sql_get_var("select count(*) as jumlah from tbl_teman where request='$_SESSION[userName]' and approve='$name' and status='0'");
			
		if ($jumlah>0)
		{ $addfriends = 1; }
		else
		{
			$addfriends	= 2;
			$jumlah2	= sql_get_var("select count(*) as jumlah2 from tbl_teman where request='$name' and approve='$_SESSION[userName]' and status='0'");
			if ($jumlah2>0)	$app=1;
			else
			{
				$app		= 2;
				$jumlahx	= sql_get_var("select count(*) as jumlahx from tbl_teman where request='$name' and approve='$_SESSION[userName]' and status='1'");
				
				if($jumlahx >0)	$ada=1;	else $ada="";
			}
			$respon = base64_encode($name);
			$linkapp = "$fulldomain/member/respons/$respon";
		}
		$linkadd = "$fulldomain/member/addfriend/$name";
	}*/

	if($name==$_SESSION['username'])
		$tampilPost = "1";
	else
	{
		if($tipe != 0)
			$tampilPost = "0";
		else
			$tampilPost = "1";
	}
	$tpl->assign("tampilPost",$tampilPost);
		
		
	$tpl->assign("stat",$stat);
	$tpl->assign("linkadd",$linkadd);
	$tpl->assign("linkapp",$linkapp);
	$tpl->assign("linkdel",$linkdel);
	$tpl->assign("app",$app);
	$tpl->assign("ada",$ada);
	$tpl->assign("addfriends",$addfriends);
	
	$music = 0;
	$video = 0;
?>