<?php 

if($kanal == "profile")
{
	$katid = $var[5];
	$id = $var[6];
	$katid = $var[5];
	$katid = str_replace(".html","",$katid);
}
else
{
	$katid = $var[4];
	$id = $var[5];
	$katid = $var[4];
	$katid = str_replace(".html","",$katid);
}

if(!empty($katid))
{
	$perintah1 = "select * from tbl_blog_sec where alias='$katid'";
	$hasil1 = sql($perintah1);
	$row1 = sql_fetch_data($hasil1);
	$namasec = $row1['nama'];
	$secid = $row1['secid'];
	$secalias = $row1['alias'];
	$where = "and secid='$secid'";
	$rubrik = "$namasec";
	$tpl->assign("rubrik","$rubrik");
	$tpl->assign("arsip","$fulldomain/$kanal/arsip/$secalias/");
}
else
{
	$secalias = "global";
	$rubrik = "Blog";
	$tpl->assign("rubrik","$rubrik");
	$tpl->assign("arsip","$fulldomain/$kanal/arsip/$secalias/");
}


$perintah = "select id,nama,oleh,ringkas,lengkap,gambar1,gambar,create_date,alias,views,userid from tbl_blog where id='$id' and userid='$_SESSION[useridresel]'";
$hasil = sql($perintah);
$data =  sql_fetch_data($hasil);

$idcontent = $data['id'];
$nama=$data['nama'];
$oleh = $data['oleh'];
$lengkap= $data['lengkap'];
$tanggal = tanggal($data['create_date']);
$gambar = $data['gambar1'];
$gambarshare = $data['gambar'];
$ringkas = $data['ringkas'];
$alias = $data['alias'];
$uidd = $data['userid'];

$views = number_format($data['views'],0,",",".");

if(empty($katid)) $katid="0";


$tpl->assign("detailid",$idcontent);
$tpl->assign("detailnama",$nama);
$tpl->assign("detaillengkap",$lengkap);
$tpl->assign("detailringkas",$ringkas);
$tpl->assign("detailcreator",$oleh);
$tpl->assign("detailtanggal",$tanggal);
$tpl->assign("detailstats",$views);

$ex = explode("-",$gambar);
$yearm = $ex[1];

if(!empty($gambar)) $tpl->assign("detailgambar","$fulldomain/gambar/blog/$gambar");
if(!empty($gambarshare)) $tpl->assign("detailgambarshare","$fulldomain/gambar/blog/$gambarshare");

sql_free_result($hasil);

?>
