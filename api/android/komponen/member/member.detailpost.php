<?php
$userid = $var[4];
$postid = $var[5];

$perintah	= "select postid,isi,username,userid,userfullname,touserid,tousername,touserfullname,tanggal,jmlLike,groupnya,type,media,via,jmlkomen from tbl_post where isi!='' and postid='$postid'";
$hasil = sql( $perintah);

$username = sql_get_var("select username from tbl_member where userid='$userid'");

$datadetail = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil))
 {	
		$postid		= $data['postid'];
		$isi		= $data['isi'];
		$isi		= geturl(trim($isi));
		$jmlisi 	= strlen($isi);
		$usernames	= $data['username'];
				
		
		$isii = explode(" ",$isi);
		for($uu=0;$uu<count($isii);$uu++)
		{
			$kata = $isii[$uu];
			if($kata[0]=="@")
			{
				$katax = str_replace("@","",$kata);
				
				$mnt = sql_get_var("select username from tbl_member where username='$katax' limit 1");
				
				if(!empty($mnt))
				{
					$isi = str_replace("$kata","<a href=\"$fulldomain/profile/$mnt\">$kata</a>",$isi);
				}
				
			}
		}
		$isi 		= getemoticon($isi);
		$isi		= preg_replace('/(\#)([^\s]+)/', "<a href=\"$fulldomain/user/cari/$2\">#$2</a>", $isi);
		$tousername	= $data['tousername'];
		$via		= $data['via'];
		$userid		= $data['userid'];
		$jmlkomen	= $data['jmlkomen'];
		$namalengkap= $data['userfullname'];
		$avatar		= "$fulldomain/uploads/avatar/$userid.jpg";		
		$profileurl		= "$fulldomain/$usernames";
		
		if($tousername!=$usernames)
		{
			$tonamalengkap = $data['touserfullname'];
			$toprofileurl		= "$fulldomain/profile/$tousername";
		}
		else
		{
			$tonamalengkap  = "";
			$toprofileurl	= "";
		}
		
		if($userid=='0')
		{
			$namalengkap= "SalingSapa";
			$profileurl		= "$fulldomain/about";
		}
		
		
		$tanggal	= $data['tanggal'];
		$type		= $data['type'];
		$skr		= date("Y-m-d");
		$media	= $data['media'];

		
		if (($usernames == $username) or ($tousername == $username)) $hapusposting = 1;
		else $hapusposting = 0;
		
		
		//explode tanggal
		$tgl		= explode(" ",$tanggal);
		$tegeel		= $tgl[0];
		$tegeel1	= tanggalsingkat($tegeel);
		$jam		= $tgl[1];
		$jam1		= $jam;
		//explode waktu
		$time		= explode(":",$jam1);
		$tm1		= $time[0];
		$tm2		= $time[1];
		$tm3		= $time[2];
	
		if($tm1>12)
			$ket	= "pm";
		else
			$ket	= "am";
	
		if($tegeel==$skr)
			$tgltampil	= $tm1.":".$tm2." ".$ket;
		else
			$tgltampil	= $tegeel1." at ".$tm1.":".$tm2." ".$ket;
	
		//check like stats name
		$query3	= "select username from tbl_post_like where postid='$postid' order by id desc";
		$hsl3	= sql($query3);
		$jum	= sql_num_rows($hsl3);
		$x		= 0;
		$likearray 	= array();
		$likearray1 = array();
		while ($dta3= sql_fetch_data($hsl3))
		{
			if($username==$dta3['username'])
			{
				$userlikename	= "Anda";
				$userlikename1	= $userlikename;
			}
			else
			{
				$userxx			= getProfileName($dta3['username']);
				
				$userlikename1	= "<span class='none_icon'><a href='$fulldomain/profile/".$userxx['username']."'>".$userxx['username']."</a></span>";
			}
		
			if ($jum == 2)	
			{
				$likearray[$x] 	= $userlikename;
				$likearray1[$x] = $userlikename1;
				if (($likearray[0] == "Anda") or ($likearray[0] == $userName))
					$userlikename2 = $likearray1[0] . " dan ".$likearray1[1];			
				else
					$userlikename2 = $likearray1[1] . " dan ".$likearray1[0];
				
			}
			else if ($jum > 2)
			{
				if ($userlikename == "Anda")
				{
					$userlikename2 = "Anda";
					break;
				}
				else 
				{
					if ($userlikename == $userName)
						$userlikename2 = $userName;
				}	
			}
			else
			{
					$userlikename2 = $userlikename1;
			}
			$x++;
		}
		
		//cek like atau tidak
		$query2		= "select count(*) as jmllikenya from tbl_post_like where postid='$postid' and username='$username'";
		$hhsl		= sql($query2);
		$ddata1		= sql_fetch_data($hhsl);
		$jmllikenya	= $ddata1['jmllikenya'];
		
		if ($jmllikenya > 0)
			$unlike	= "1";
		else
			$unlike	= "0";
		sql_free_result($hhsl);	

		//buat ambil limit komennya
		$limit = 2;
		if ($jmlkomen > $limit)
			$mulai 	= $jmlkomen - $limit;
		else
			$mulai 	= 0; 
		
		if($jmlkomen>0)
		{
		
		if($s=="m" && $aksi!="post")
		{
		}
		else
		{
		
			$sql	= "select id,username,userid,userfullname,isi,tanggal,via from tbl_post_komen where postid='$postid' order by tanggal asc";
			$hsl	= sql($sql);
			while($row = sql_fetch_data($hsl))
			{
				$id			= $row['id'];
				$oleh		= $row['username'];
				$olehuserid		= $row['userid'];
				$gambar		= "$fulldomain/uploads/avatar/$olehuserid.jpg";
				$nama		= $row['userfullname'];
				$urlprofilecomment = "$fulldomain/profile/$oleh";
				$cvia		= $row['via'];
				
				$komentar	= geturl(trim($row['isi']));
				$jmlkom = strlen($komentar);
				
				if($jmlkom > 300 && $aksi!="post")
				{
					$komentar = substr($komentar,0,300)." <a href=\"/user/post/$postid\">more</a>";
				}
				
				$linkgambar	= "$fulldomain/pic/$oleh";
				$ttggll		= $row['tanggal'];
				
				
				$skr		= date("Y-m-d");
				
				//explode tanggal
				$tgl1		= explode(" ",$ttggll);
				$tegeel1	= $tgl1[0];
				$tegeel2	= tanggalLahir($tegeel1);
				$jam1		= $tgl1[1];
				$jam2		= $jam1;
				//explode waktu
				$time1		= explode(":",$jam2);
				$tm11		= $time1[0];
				$tm22		= $time1[1];
				$tm32		= $time1[2];

				if($tm11>12)
					$ket1	= "pm";
				else
					$ket1	= "am";
				
				if($tegeel1==$skr)
					$tgltampil1	= $tm11.":".$tm22." ".$ket1;
				else
					$tgltampil1	= $tegeel2." at ".$tm11.":".$tm22." ".$ket1;
				
				//hapus komentar nya
				if( ($oleh==$username) or ($hapusposting =="1") )
					$hapus	= 1;
				else
					$hapus	= 0;
				
				$datakomen[] = array("id"=>$id,"nama"=>$nama,"urlprofile"=>$urlprofilecomment,"komentar"=>$komentar,"gambar"=>$gambar,"oleh"=>$oleh,"hapus"=>$hapus,"tgltampil1"=>$tgltampil1,
											"linkgambar"=>$linkgambar,"username"=>$username);
			}
			sql_free_result($hsl);
			
			}
			
		
		}
		
			//Media
			if(!empty($media))
			{
				$media = unserialize($media);
				$mjenis = $media['jenis'];
				$mcontent = $media['gambar'];
				$mlokasi = $media['lokasi'];
				$mcontent = $media['media'];
				$myoutubeid = $media['youtubeid'];
				$mnama = $media['nama'];
				$mcontent = "$fulldomain/$mcontent";
				$murl = $media['url'];		
				
				
			}
		

		
			$datapost[] = array(
									"postid"=>$postid,
									"isi"=>$isi,
									"userid"=>$userid,
									"avatar"=>$avatar,
									"hapus"=>$hapusposting,
									"jmlkomen"=>$jmlkomen,
									"jmlkomenBaru"=>$jmlkomenBaru,
									"namalengkap"=>$namalengkap,
									"mjenis"=>$mjenis,
									"mnama"=>$mnama,
									"murl"=>$murl,
									"mcontent"=>$mcontent,
									"myoutubeid"=>$myoutubeid,
									"userDirName"=>$userDirName,
									"username"=>$usernames,
									"profileurl"=>$profileurl,
									"unlike"=>$unlike,
									"jmlLike"=>$jum,
									"jmlLike2"=>($jum-1),
									"userlikename"=>$userlikename,
									"userlikename2"=>$userlikename2,
									"tgltampil"=>$tgltampil,
									"hapusposting"=>$hapusposting,
									"datakomen"=>$datakomen,
									"tonamalengkap"=>$tonamalengkap,
									"toprofileurl"=>$toprofileurl);
			$u++;
			unset($mjenis,$murl,$mcontent);
	
		
}
sql_free_result($hasil);


$result['status']="OK";
$result['message']="Data berhasil di load";
$result['halaman']= $hlm;
$result['totalhalaman'] = $hlm_tot;
$result['datapost'] = $datapost;
$result['stringpage'] = $stringpage;
	
echo json_encode($result);
?>