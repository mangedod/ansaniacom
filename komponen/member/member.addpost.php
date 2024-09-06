<?php
if(empty($_SESSION['usernameresel'])) exit();
if($_POST['tousername']!="")
{
	$tousername 	= $_POST['tousername'];
	$ex 			= getProfileName($tousername);
	$touserfullname = $ex['userfullname'];
	$touserid 		= $ex['userid'];
}
else
{
	$tousername 	= $_SESSION['usernameresel'];
	$touserid 		= $_SESSION['useridresel'];
	$touserfullname = $_SESSION['userfullnameresel'];
}

$sharefb	= $_POST['sharefb'];
$sharetw	= $_POST['sharetw'];
$jenis	= $_POST['jenis'];
$isi		= bersih($_POST['isi']);

//die($_SESSION['twcid']);
//Post Media
$gambars_maxw = 250;
$gambars_maxh = 330;
$gambarm_maxw = 350;
$gambarm_maxh = 470;
$gambarl_maxw = 600;
$gambarl_maxh = 800;
$gambarf_maxw = 800;
$gambarf_maxh = 1050;

if(!empty($isi))
{
	if($isi == "Apa yang Anda pikirkan?") $isi = "";
	
	$tanggal	= date("Y-m-d H:i:s");
	$idbaru 	= newid("postid","tbl_post");

	$perintah2	= "insert into tbl_post (postid,userid,username,tousername,touserid,userfullname,touserfullname,isi,tanggal,home,jenis) 
				values ('$idbaru','$_SESSION[useridresel]','$_SESSION[usernameresel]','$tousername','$touserid','$_SESSION[userfullnameresel]','$touserfullname','$isi','$tanggal','$_SESSION[verified]','$jenis')";
	$hasil2		=  sql($perintah2);
	
	if($hasil2)
	{
		$mention = "";
		$isii = explode(" ",$isi);
		for($u=0;$u<count($isii);$u++)
		{
			$kata = $isii[$u];
			if($kata[0]=="@")
			{
				$katax = str_replace("@","",$kata);
				
				$mnt = sql_get_var("select username from tbl_member where username='$katax' limit 1");
				
				if(!empty($mnt))
				{
					$mention .="$katax,";
					setlog($_SESSION['usernameresel'],$katax,"menyebut sahabat dalam statusnya","$fulldomain/member/post/$idbaru","comment");
					$isi = str_replace("$kata","<a href=\"$fulldomain/$mnt\">$kata</a>",$isi);
				}
				
			}
			/*if($kata[0]=="#")
			{
				$katax = str_replace("#","",$kata);
				$isi = str_replace("$kata","<a href=\"$fulldomain/member/cari/$katax\">$kata</a>",$isi);
			}
			if(preg_match("/http:\/\//i",$kata))
			{
				$isi = str_replace("$kata","<a href=\"$kata\" target=\"_blank\"  title=\"$kata\">Tautan</a>",$isi);
			}*/
		}
		
		$sqlp	= "update tbl_member set posting=posting+1 where username='$_SESSION[usernameresel]'";
		$qry 	= sql($sqlp);
	}
	
	//Cek Youtube
	if(preg_match("/youtube.com\/watch\?v=/i",$isi))
	{
		$conten = explode(" ",$isi);
		for($i=0;$i<count($conten);$i++)
		{
			if(preg_match("/youtube.com\/watch\?v=/i",$conten[$i]))
			{ 
				$youtube = $conten[$i];
				$isibaru = str_replace($youtube,"",$isi);
			}
		}
		
		$video	= explode("watch?v=",$youtube);
		$video	= explode("&",$video[1]);
		
		$youtubeid = $video[0];
		
		$newid 	= newid("mediaid","tbl_post_media");
		$fbulan = date("Ym");
		if(!file_exists("$lokasimember/userfiles/$fbulan")) mkdir("$lokasimember/userfiles/$fbulan");
		
		//Get data from Youtube
		$url 	= "http://gdata.youtube.com/feeds/api/videos/$youtubeid";
		$curl 	= curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 20);
		$result = curl_exec($curl); 
		
		$youtubetitle 	= ucwords(getTitle($result));
		$youtubedesc 	= getDesc($result);
		$youtubethumb 	= getThumbnailUrl($result,true);
		$youtubetitle   = str_replace("'","`",$youtubetitle);
		$youtubedesc    = str_replace("'","`",$youtubedesc);
		$youtubethumb   = $youtubethumb[0];
		
		
		$ext 			= "jpg";
		$namagambarm 	= "youtube-$fbulan-$_SESSION[useridresel]-$newid-m.$ext";
		
		save_image($youtubethumb,"$lokasimember/userfiles/$fbulan/$namagambarm");
		
		$namagambars 	= "youtube-$fbulan-$_SESSION[useridresel]-$newid-s.$ext";
		$gambars 		= resizeimg("$lokasimember/userfiles/$fbulan/$namagambarm","$lokasimember/userfiles/$fbulan/$namagambars",$gambars_maxw,$gambars_maxh);
		
		$namagambarl 	= "youtube-$fbulan-$_SESSION[useridresel]-$newid-l.$ext";
		$gambarl 		= resizeimg("$lokasimember/userfiles/$fbulan/$namagambarm","$lokasimember/userfiles/$fbulan/$namagambarl",$gambarl_maxw,$gambarl_maxh);
		
		$namagambarf 	= "youtube-$fbulan-$_SESSION[useridresel]-$newid-f.$ext";
		$gambarf 		= resizeimg("$lokasimember/userfiles/$fbulan/$namagambarm","$lokasimember/userfiles/$fbulan/$namagambarf",$gambarf_maxw,$gambarf_maxh);
		
		$perintah	= "insert into tbl_post_media(create_date,jenis,userid,nama,ringkas,gambar,gambar_s,gambar_m,gambar_l,gambar_f,url,youtubeid,published) 
					values ('$tanggal','youtube','$_SESSION[useridresel]','$youtubetitle','$youtubedesc','$namagambarm','$namagambars','$namagambarm','$namagambarl',
					'$namagambarf','$youtube','$youtubeid','1')";
		$hasil		=  sql($perintah);
		
		$media = array("mediaid"=>$newid,"jenis"=>"youtube","lokasi"=>"$fbulan","nama"=>$youtubetitle,"media"=>"uploads/userfiles/$fbulan/$namagambarl","url"=>$youtube,
						"youtubeid"=>$youtubeid);
		$media = serialize($media);
 		$newisi = trim($isibaru);

		if(empty($newisi)) $isibaru = $youtubetitle;
		
		$sql = "update tbl_post set media='$media',isi='$isibaru' where postid='$idbaru'";
		$res = sql($sql);
		//die("here".$youtube);
	}
	
	//Upload Gambar
	$fbulan = date("Ym");
	if(!file_exists("$lokasimember/userfiles/$fbulan")) mkdir("$lokasimember/userfiles/$fbulan");
	
	if($_FILES['filePhoto']['size']>0)
	{
		$newid = newid("mediaid","tbl_post_media");
		
		$ext 			= getimgext($_FILES['filePhoto']);
		$namagambars 	= "media-$fbulan-$_SESSION[useridresel]-$newid-s.$ext";
		$gambars 		= resizeimg($_FILES['filePhoto']['tmp_name'],"$lokasimember/userfiles/$fbulan/$namagambars",$gambars_maxw,$gambars_maxh);
		
		$namagambarm 	= "media-$fbulan-$_SESSION[useridresel]-$newid-m.$ext";
		$gambarm 		= resizeimg($_FILES['filePhoto']['tmp_name'],"$lokasimember/userfiles/$fbulan/$namagambarm",$gambarm_maxw,$gambarm_maxh);
		
		$namagambarl 	= "media-$fbulan-$_SESSION[useridresel]-$newid-l.$ext";
		$gambarl 		= resizeimg($_FILES['filePhoto']['tmp_name'],"$lokasimember/userfiles/$fbulan/$namagambarl",$gambarl_maxw,$gambarl_maxh);
		
		$namagambarf 	= "media-$fbulan-$_SESSION[useridresel]-$newid-f.$ext";
		$gambarf 		= resizeimg($_FILES['filePhoto']['tmp_name'],"$lokasimember/userfiles/$fbulan/$namagambarf",$gambarf_maxw,$gambarf_maxh);
		
		if(file_exists("$lokasimember/userfiles/$fbulan/$namagambarl"))
		{ 
			$perintah	= "insert into tbl_post_media(create_date,jenis,userid,nama,ringkas,gambar,gambar_s,gambar_m,gambar_l,gambar_f,url,published) 
						values ('$tanggal','photo','$_SESSION[useridresel]','$isi','$isi','$namagambarm','$namagambars','$namagambarm','$namagambarl','$namagambarf','','1')";
			$hasil		=  sql($perintah);
			
			$media = array("mediaid"=>$newid,"jenis"=>"photo","lokasi"=>"$fbulan","media"=>"uploads/userfiles/$fbulan/$namagambarl");
			$media = serialize($media);
			
			$sql = "update tbl_post set media='$media' where postid='$idbaru'";
			$res = sql($sql);
			
			$photo = true;
		}
	}

	

	if($sharefb)
	{
		
		if(!empty($_SESSION['fbcid']))
		{
			include($lokasiweb."librari/fbconnect/share.php");
			
				$isi = preg_replace('#<br\s*/?>#i', "\r\n\r\n", $isi);
				$isi = str_replace("\\'", "'", $isi);
				$isi = str_replace('\"', '"', $isi);
				$isi = str_replace('\`', '`', $isi);
				$isi = strip_tags($isi);
				
				/*if($photo==true)
				{
					try {
						$publishStream = $facebook->api("/$user/photos", 'post', array(
							'message' => "$isi \r\n\r\n Update from SalingSapa.com",
							'url' => "$lokasiwebmember/userfiles/$fbulan/$namagambarl",
							'source' => $_FILES['filePhoto']['tmp_name'],
							)
						);
						
					}catch (FacebookApiException $e) {  }
				}
				else
				{
					try {
					$publishStream = $facebook->api("/$user/feed", 'post', array(
						'message' => "$isi \r\n\r\n Update from pagosun.com",
						'link' => "http://www.pagosun.com/$_SESSION[usernameresel]/readpost/$idbaru",
						)
					);
					
					}catch (FacebookApiException $e) { }
				}*/
				
				
				if($photo==true)
				{
					$data = array("message" => "$isi \r\n\r\n Update from SalingSapa.com",
								  "url"=> "$lokasiwebmember/userfiles/$fbulan/$namagambarl",
								  "name"=> "Upload Picture",
								  "description"=> "Upload Picture - $isi \r\n\r\n Update from SalingSapa.com",
								  "picture"=> $_FILES['filePhoto']['tmp_name'] );
				}
				else
				{
					$data = array("message" => "$isi  \r\n\r\n Update from SalingSapa.com");
				}
				try {
					$publishStream = $facebook->api("/$_SESSION[fbcid]/feed", 'post',$data);
					/*print_r($publishStream);
					die();*/
				}catch (FacebookApiException $e) { /*print_r($e); die();*/ }
				
		}
		
		header("location: $fulldomain");
	}

	if($sharetw)
	{
		//Update Status ke Twitter
		if(!empty($_SESSION['twcid']))
		{
			$perintah 	= "SELECT tw_token,tw_secret from tbl_member where userId='$_SESSION[useridresel]'";
			$hasil 		= sql($perintah);
			$row      	= sql_fetch_data($hasil);
			
			$tw_token  		= $row['tw_token'];
			$tw_secret 		= $row['tw_secret'];
			
			if(!empty($tw_secret))
			{
				include($lokasiweb."librari/twitteroauth/config.php");
				include($lokasiweb."librari/twitteroauth/twitteroauth/twitteroauth.php");
				
				$tweet = new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET,$tw_token, $tw_secret);
				$tweet->post('statuses/update', array('status' => $isi));
			}
		}
	}
	
	if($tousername!=$_SESSION['usernameresel']) setlog($_SESSION['usernameresel'],"$tousername","menulis status didinding Anda","$fulldomain/member/post/$idbaru");
	
	if($jenis=="1")
	{
		header("location:$fulldomain/member/syukur");
	}
	else if($jenis=="2")
	{
		header("location:$fulldomain/member/janji");
	}
	else
	{
		header("location:$fulldomain/member");
	}
}
else
{
	header("location:$fulldomain/member");
}
?>