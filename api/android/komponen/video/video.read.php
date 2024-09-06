<?php
$id = $var[4];
$katid = str_replace(".html","",$katid);

$perintah = "select id,nama,ringkas,gambar1,create_date,alias,video,jenis,youtubeid,views from tbl_video where id='$id' and published='1'";
$hasil = sql($perintah); 

$jml = sql_num_rows($hasil);

if($jml<1)
{
	$result['status']="OK";
	$result['message']="Data Tidak Ditemukan";
	echo json_encode($result);
	exit();
}

$data =  sql_fetch_data($hasil);
$idcontent = $data['id'];
$nama=$data['nama'];
$oleh = $data['oleh'];
$lengkap= $data['lengkap'];
$tanggal = tanggal($data['create_date']);
$gambar = $data['gambar'];
$ringkas = $data['ringkas'];
$alias = $data['alias'];
$views = $data['views'];
$video = $data['video'];
$jenis = $data['jenis'];
$youtubeid = $data['youtubeid'];
$views = $data['views'];
$videourl = $data['videourl'];

if(empty($lengkap)) $lengkap = $ringkas;

$url = "$fulldomain/video/read/$idcontent/$alias";

$unameteman = $user['username'];

$rubrik = "$namasec";




if(empty($katid)) $katid="0";

//Sesuaikan dengan path
$lengkap = str_replace("jscripts/tiny_mce/plugins/emotions","$domain/plugin/emotion",$lengkap);
$lengkap = str_replace("../../","/",$lengkap);

$ringkasshare = str_replace('<br>', "\r", $ringkas);
$ringkasshare = str_replace('<br />', "\r", $ringkasshare);
$ringkasshare = str_replace('<br />', "\r", $ringkasshare);
$ringkasshare = str_replace('&nbsp;', " ", $ringkasshare);
$ringkasshare = strip_tags($ringkasshare);


if(!empty($gambar)) $tpl->assign("detailgambar","$domain/gambar/video/$gambar");

if($jenis=="youtube")
{ 
	$jenis = "yt";
	$video = "<iframe width=\"100%\" height=\"315\" src=\"https://www.youtube.com/embed/$youtubeid\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>"; 
}
else if($jenis=="videourl")
{ 
	$video = $videourl; 
}
else 
{
	if(!empty($video)) $video = "$domain/medias/video/$md5/$video";
}

$url = "$fulldomain/video/read/$idcontent/$alias";


sql_free_result($hasil);

// Masukan data kedalam statistik
$stats = number_format($views,0,0,".");

$views = "update tbl_video set views=views+1 where id='$id'";
$hsl = sql($views);


$result['status']="OK";
$result['message']="Data berhasil di load";
$result['kategori'] = $namasec;
$result['detailid'] = $idcontent;
$result['detailnama'] = $nama;
$result['detailgambar'] = $detailgambar;
$result['detaillengkap'] = $lengkap;
$result['detailringkas'] = $ringkas;
$result['detailringkasshare'] = $ringkasshare;
$result['detailcreator'] = $oleh;
$result['detailtanggal'] = $tanggal;
$result['detailjenis'] = $jenis;
$result['detailvideo'] = $video;
$result['detailyoutubeid'] = $youtubeid;
$result['detailurl'] = $url;	
echo json_encode($result);
?>
