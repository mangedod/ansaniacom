<?php
$laporid = $_GET['laporid'];
$userid = $_GET['userid'];
$usertipe = sql_get_var("select usertipe from tbl_member where userid='$userid'");

if($usertipe == 0)
{
	$result["message"] = "Maaf Anda tidak mempunyai otoritas untuk halaman ini";
	echo json_encode($result);
	exit;
}

$perintah = "select laporid, polsekid, userid, jenis, gambar, video, audio, pesan, jmlcomment, jmllike, latitude, longitude, status, convertstatus, respon, responuserid, tanggalrespon,
				create_date from tbl_lapor where laporid='$laporid' and polsekid='$userid'";
$hasil = sql($perintah);
$data =  sql_fetch_data($hasil);

$laporid	= $data['laporid'];
$polsekid	= $data['polsekid'];
$userids	= $data['userid'];
$jenis		= $data['jenis'];
$isi		= $data['pesan'];
$isi		= geturl(trim($isi));
$jmlisi 	= strlen($isi);
$gambar		= $data['gambar'];
$jmlcomment	= $data['jmlcomment'];
$jum		= $data['jmllike'];
$video		= $data['video'];
$audio		= $data['audio'];
$latitude	= $data['latitude'];
$longitude	= $data['longitude'];	
$tanggal	= $data['create_date']; 
$status	= $data['status']; 
$respon	= $data['respon']; 
$responuserid	= $data['responuserid']; 
$tanggalrespon	= tanggal($data['tanggalrespon']); 
$namaperespon	= sql_get_var("select userfullname from tbl_member where userid='$responuserid'");

$link = "$fulldomain/member/post/$laporid";

$user = sql_get_var_row("select userfullname, avatar, username from tbl_member where userid='$userids'");
	
$namalengkap = $user['userfullname'];
$usernames  = $user['username'];

$ava	= $user['avatar'];
		 
if(!empty($ava)) $avatar = "$domainmedia/avatar/$userids.jpg";
 else $avatar = "$fulldomain/images/avatar-default.png";

$profileurl		= "$fulldomain/$usernames";

	if(!empty($gambar)) $gambar = "$domainmedia/gambar/$gambar";
	
if($jenis=="video")
	if(!empty($video)) $video = "$domainmedia/video/$video";
	
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

$result["userid"] = $userid;
$result["usertipe"] = $usertipe;
$result["laporid"] = $laporid;
$result["nama"] = $nama;
$result["isi"] = $isi;
$result["url"] = $url;
$result["avatar"] = $avatar;
$result["hapus"] = $hapus1;
$result["jmlcomment"] = $jmlcomment;
$result["namalengkap"] = $namalengkap;
$result["alias"] = $alias;
$result["mgambar"] = $gambar;
$result["mnama"] = $mnama;
$result["murl"] = $murl;
$result["mcontent"] = $video;
$result["username"] = $usernames;
$result["profileurl"] = $profileurl;
$result["unlike"] = $unlike;
$result["jmlLike"] = $jum;
$result["tgltampil"] = $tgltampil;
$result["hapusposting"] = $hapusposting;
$result["mjenis"] = $jenis;
$result["status"] = $status;
$result["respon"] = $respon;
$result["responuserid"] = $responuserid;
$result["namaperespon"] = $namaperespon;
$result["tanggalrespon"] = $tanggalrespon;

$jmllapor = sql_get_var("select posting from tbl_member where userid='$userids'");	

echo json_encode($result);		

?>
