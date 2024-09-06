<?php
$subaksi = $var[4];
$batas_paging = 5;
$start = $var[6];
$limit = $var[7];
$userid = $var[5];


$datamember = sql_get_var_row("select userfullname,userid,username from tbl_member where userid='$userid'");
$username = $datamember['username'];

if($username)
{
	//notifikasi baru
	if($subaksi=="read")
	{
		$perintah = "select id,fromusername,pesan,status,icon,tanggal,url from tbl_notifikasi where tousername='$username' and id='$start'";
		$hasil =sql($perintah);
		$data = sql_fetch_data($hasil);
		
		$id = $data['id'];
		$id2 			= base64_encode($id);
		$base 			= md5($id2);
		$fromusername 	= $data['fromusername'];
		$pesan 			= $data['pesan'];
		$pesan = str_replace("<strong>","",$pesan);
		$pesan = str_replace("</strong>","",$pesan);
		$icon 			= $data['icon'];
		$status 		= $data['status'];
		$url = $data['url'];
		
		$urls = explode("/",$url);
		$kanal = $urls[3];
		$aksi = $urls[4];
		$postid = $urls[5];
		
		$datas = array("title"=>$title,"aksi"=>$aksi,"kanal"=>$kanal,"kanal"=>$kanal,"postid"=>$postid);
		
		//Update Read
		$perintahc = "update tbl_notifikasi set status='1' where tousername='$username' and url='$url'";
		$hasilc = sql($perintahc);
		
		$result['status']="OK";
		$result['message']="Notifikasi terbaru berhasil di load";
		$result['notif']= $datas;
		echo json_encode($result);
		exit;
	}
	else if($subaksi=="notifbaru")
	{
		$hlm 			= $hlm;
		$judul_per_hlm 	= 10;
		$batas_paging 	= 5;
		
		$sql = "select count(*) as jml from tbl_notifikasi where tousername='$username' and status='0'";
		$hsl = sql($sql);
		$tot = sql_result($hsl, 0, jml);
		$hlm_tot = ceil($tot / $judul_per_hlm);		
		if (empty($hlm)){
			$hlm = 1;
			}
		if ($hlm > $hlm_tot){
			$hlm = $hlm_tot;
			}
		
		$ord = ($hlm - 1) * $judul_per_hlm;
		if ($ord < 0 ) $ord=0;
	
		//Notifikasi
		$perintah = "select id,fromusername,pesan,status,icon,tanggal,url from tbl_notifikasi where tousername='$username' and status='0' order by tanggal desc limit $start, $limit";
		$hasil =sql($perintah);
		$jml = sql_num_rows($hasil);
		if($jml>0)
		{
			$notifikasi = array();
			while($data = sql_fetch_data($hasil))
			{
				$id 			= $data['id'];
				$id2 			= base64_encode($id);
				$base 			= md5($id2);
				$fromusername 	= $data['fromusername'];
				$pesan 			= $data['pesan'];
				$pesan = str_replace("<strong>","",$pesan);
				$pesan = str_replace("</strong>","",$pesan);
				$icon 			= $data['icon'];
				$status 		= $data['status'];
				$url = $data['url'];
				
				if($status==0) $pesan = "<strong>$pesan</strong>";
				else
					$pesan = "$pesan";
				
			
				$urls = explode("/",$url);
				$kanal = $urls[3];
				$aksi = $urls[4];
				$audioid = $urls[5];

						
				if($kanal=="member" && $aksi=="post")
				{
					$tipe = "laporan";
					$page = "laporandetail";
					$title = "Interaksi Audio";
					$message = "$fromuserfullname $pesan";
				}
				else
				{
					$tipe = "audio";
					$page = "audiodetail";
					$title = "Interaksi Audio";
					$message = "$fromuserfullname $pesan";
				}
			
		
				$datas = array("title"=>$title,"message"=>$message,"tipe"=>$tipe,"page"=>$page,"audioid"=>$audioid);
		

			
			
				
				if(($fromusername=="system") or ($fromusername=="")) { $pesan1 = "$pesan"; }
				else { $pesan1 = "$fromusername $pesan"; }
				
				if($fromusername!="system")
				{
					$dtuser	= getProfileName($fromusername);
					$fname	= $dtuser['userfullname'];
					$avatar	= $dtuser['avatar'];
					if($avatar)
						$avatar="$avatar";
					else
						$avatar="$domainmedia/gambar/avatar-default.png";
						
					$urluser	= "$fulldomain/index.php/$fromusername";
					$urlnotif	= "$fulldomain/index.php/member/notifdetail/?id=$id";
				}
				else
				{
					$fname	="Administrator";
					$avatar	= "$domainmedia/gambar/avatar-default.png";
					$urluser	= "";
					$urlnotif	= "$fulldomain/index.php/member/notifdetail/?id=$id";
				}
				$tanggal = tanggal($data->tanggal);
				
				$tanggal = $data['tanggal'];
				//explode tanggal
				$tgl		= explode(" ",$tanggal);
				$tegeel		= $tgl[0];
				$tegeel1	= tanggalLahir($tegeel);
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
		
				$notifikasi[] = array("id"=>$id,"pesan"=>$pesan1,"fname"=>$fname,"username"=>$fromusername,"avatar"=>$avatar,"pesannotif"=>$pesan,"urluser"=>$urluser,"urlnotif"=>$urlnotif,"tgltampil"=>$tgltampil,"status"=>$status,
								"icon"=>$icon,"data"=>$datas);
			}
			sql_free_result($hasil);
			$result['status']="OK";
			$result['message']="Notifikasi terbaru berhasil di load";
			$result['notifikasibaru']=$notifikasi;
			$result['jumlahnotifikasibaru']=$jml;
			
					
			
			
			//Paging 
			$batas_page =5;
			
			$stringpage = array();
			$pageid =0;
			
			if ($hlm > 1){
				$prev = $hlm - 1;
				$stringpage[$pageid] = array("nama"=>"Awal","link"=>"$domainfull/$kanal/$aksi/1");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"$domainfull/$kanal/$aksi/$prev");
		
			}
			else {
				$stringpage[$pageid] = array("nama"=>"Awal","link"=>"");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"");
			}
			
			$hlm2 = $hlm - (ceil($batas_page/2));
			$hlm4= $hlm+(ceil($batas_page/2));
			
			if($hlm2 <= 0 ) $hlm3=1;
			   else $hlm3 = $hlm2;
			$pageid++;
			for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
				if ($ii==$hlm){
					$stringpage[$pageid] = array("nama"=>"$ii","link"=>"","class"=>"active");
				}else{
					$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$domainfull/$kanal/$aksi/$ii");
				}
				$pageid++;
			}
			if ($hlm < $hlm_tot){
				$next = $hlm + 1;
				$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"$domainfull/$kanal/$aksi/$next");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$domainfull/$kanal/$aksi/$hlm_tot");
			}
			else
			{
				$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"");
			}
			$result['stringpagebaru']=$stringpage;
		}
		else
		{
			$result['status']="ERROR";
			$result['message']="Tidak ada notifikasi baru untuk Anda.";
		}
	}
	else
	{
			
		//notifikasi sudah dibaca
		$hlm 			= $hlm;
		$judul_per_hlm 	= 10;
		$batas_paging 	= 5;
		
		$sql = "select count(*) as jml from tbl_notifikasi where tousername='$username' and status='1'";
		$hsl =sql($sql);
		$tot = sql_result($hsl, 0, jml);
		$hlm_tot = ceil($tot / $judul_per_hlm);		
		if (empty($hlm)){
			$hlm = 1;
			}
		if ($hlm > $hlm_tot){
			$hlm = $hlm_tot;
			}
		
		$ord = ($hlm - 1) * $judul_per_hlm;
		if ($ord < 0 ) $ord=0;
	
		//Notifikasi
		$perintah = "select id,fromusername,pesan,status,icon,tanggal,url from tbl_notifikasi where tousername='$username' order by id desc limit $start, $limit";
		$hasil =sql($perintah);
		$jml = sql_num_rows($hasil);
		if($jml>0)
		{
			$notifikasi = array();
			while($data = sql_fetch_data($hasil))
			{
				$id 			= $data['id'];
				$id2 			= base64_encode($id);
				$base 			= md5($id2);
				$fromusername 	= $data['fromusername'];
				$pesan 			= $data['pesan'];
				$icon 			= $data['icon'];
				$status 		= $data['status'];
				$url			= $data['url'];
				$pesan = str_replace("<strong>","",$pesan);
				$pesan = str_replace("</strong>","",$pesan);
				if($status==0) $pesan = "$pesan";
				else
					$pesan = "$pesan";
				
				$urls = explode("/",$url);
				$kanal = $urls[3];
				$aksi = $urls[4];
				$audioid = $urls[5];

				if($kanal=="member" && $aksi=="post")
				{
					$tipe = "audio";
					$page = "audiodetail";
					$title = "Interaksi Audio";
					$message = "$fromuserfullname $pesan";
				}
				else
				{
					$tipe = "audio";
					$page = "audiodetail";
					$title = "Interaksi Audio";
					$message = "$fromuserfullname $pesan";
		
					
				}
		
		
				$datas = array("title"=>$title,"message"=>$message,"tipe"=>$tipe,"page"=>$page,"audioid"=>$audioid);
				
				if($fromusername!="system")
				{
					$dtuser	= getProfileName($fromusername);
					$fname	= $dtuser['userfullname'];
					$avatar	= $dtuser['avatar'];
					if($avatar)
						$avatar="$avatar";
					else
						$avatar="$domainmedia/gambar/avatar-default.png";
						
					$urluser	= "$fulldomain/index.php/$fromusername";
					$urlnotif	= "$fulldomain/index.php/member/notifdetail/?id=$id";
				}
				else
				{
					$fname	="Administrator";
					$avatar	= "$domainmedia/gambar/avatar-default.png";
					$urluser	= "";
					$urlnotif	= "$fulldomain/index.php/member/notifdetail/?id=$id";
				}
				if($avatar)
					$avatar="$avatar";
				else
					$avatar="$domainmedia/gambar/avatar-default.png";
					
				$tanggal = tanggal($data->tanggal);
				
				$tanggal = $data['tanggal'];
				//explode tanggal
				$tgl		= explode(" ",$tanggal);
				$tegeel		= $tgl[0];
				$tegeel1	= tanggalLahir($tegeel);
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
		
				$notifikasi[] = array("id"=>$id,"pesan"=>$pesan1,"fname"=>$fname,"username"=>$fromusername,"avatar"=>$avatar,"pesannotif"=>$pesan,"urluser"=>$urluser,"urlnotif"=>$urlnotif,"tgltampil"=>$tgltampil,"status"=>$status,
								"icon"=>$icon,"data"=>$datas);
			}
			sql_free_result($hasil);
			$result['status']="OK";
			$result['message']="Notifikasi terbaru berhasil di load";
			$result['notifikasi']=$notifikasi;
			$result['jumlahnotifikasi']=$jml;
			
			//Paging 
			$batas_page =5;
			
			$stringpage = array();
			$pageid =0;
			
			if ($hlm > 1){
				$prev = $hlm - 1;
				$stringpage[$pageid] = array("nama"=>"Awal","link"=>"$domainfull/$kanal/$aksi/1");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"$domainfull/$kanal/$aksi/$prev");
		
			}
			else {
				$stringpage[$pageid] = array("nama"=>"Awal","link"=>"");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"");
			}
			
			$hlm2 = $hlm - (ceil($batas_page/2));
			$hlm4= $hlm+(ceil($batas_page/2));
			
			if($hlm2 <= 0 ) $hlm3=1;
			   else $hlm3 = $hlm2;
			$pageid++;
			for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
				if ($ii==$hlm){
					$stringpage[$pageid] = array("nama"=>"$ii","link"=>"","class"=>"active"	);
				}else{
					$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$domainfull/$kanal/$aksi/$ii");
				}
				$pageid++;
			}
			if ($hlm < $hlm_tot){
				$next = $hlm + 1;
				$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"$domainfull/$kanal/$aksi/$next");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$domainfull/$kanal/$aksi/$hlm_tot");
			}
			else
			{
				$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"");
			}
			$result['stringpage']=$stringpage;
		}
		else
		{
			$result['status']="ERROR";
			$result['message']="Tidak ada Notifikasi untuk Anda.";
		}
	}
	echo json_encode($result);
	exit;
}
else
{
	$result['status'] = "Error"; 
	$result['message']="Tidak ada data dikirim";
	echo json_encode($result);
	exit;
}


?>