<?php 
$katid = $var[4];
$id    = $var[5];
$katid = $var[4];
$katid = str_replace(".html","",$katid);

if(!empty($katid) and $katid!="uncategorize")
{
	$perintah1 = "select * from tbl_$kanal"."_sec where alias='$katid'";
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
	$secalias = "uncategorize";
	$tpl->assign("rubrik","$rubrik");
	$tpl->assign("arsip","$fulldomain/$kanal/arsip/$secalias/");
}


$perintah = "select id,nama,ringkas,lengkap,gambar1,gambar,create_date,alias,views,oleh,tags from tbl_$kanal where id='$id'";
$hasil = sql($perintah);
$data =  sql_fetch_data($hasil);

$idcontent   = $data['id'];
$nama        = $data['nama'];
$lengkap     = $data['lengkap'];
$tanggal     = tanggaltok_english($data['create_date']);
$gambar      = $data['gambar1'];
$gambarshare = $data['gambar'];
$ringkas     = $data['ringkas'];
$alias       = $data['alias'];
$views       = $data['views'];
$oleh        = $data['oleh'];
$tag         = $data['tags'];

$t = explode(",",$tag);
$tags = array();
for($c=0;$c<count($t);$c++)
{
	$tags[$c] = array("tagid"=>$c,"tag"=>trim($t[$c]),"url"=>"$fulldomain/$kanal/tag/".urlencode(trim($t[$c])));
}
$tpl->assign("tags",$tags);

$file1 = $data['file1'];
$file2 = $data['file2'];

$from = getProfileId($userid);
$fullname = $from['userfullname'];
$avatar   = $from['avatar'];
$urlprofil= $from['url'];

if(empty($katid)) $katid="0";

//Sesuaikan dengan path
$lengkap = str_replace("jscripts/tiny_mce/plugins/emotions","$domain/plugin/emotion",$lengkap);
$lengkap = str_replace("../../","/",$lengkap);


$tpl->assign("detailid",$idcontent);
$tpl->assign("detailnama",$nama);
$tpl->assign("detaillengkap",$lengkap);
$tpl->assign("detailringkas",$ringkas);
$tpl->assign("detailcreator",$oleh);
$tpl->assign("detailtanggal",$tanggal);
$tpl->assign("detailstats",$views);
$tpl->assign("detailavatar",$avatar);
$tpl->assign("urlprofil",$urlprofil);

$ex = explode("-",$gambar);
$yearm = $ex[1];

if(!empty($gambar)) $tpl->assign("detailgambar","$fulldomain/gambar/$kanal/$gambar");
if(!empty($gambarshare)) $tpl->assign("detailgambarshare","$fulldomain/gambar/$kanal/$gambarshare");

sql_free_result($hasil);


// Masukan data kedalam statistik
	$views = "update tbl_$kanal set views=views+1 where id='$idcontent'";
	$hsl = sql($views);

//Berita Terkait
$mysql 		= "select id,nama,alias,gambar,ringkas from tbl_$kanal where published='1' and id < '$id' $where order by create_date desc limit 4";
$hasil 		= sql($mysql);
$jmlbter 	= sql_num_rows($hasil);
$datapilihan = array();
$a =1;		
while ($data =  sql_fetch_data($hasil)) {	
	$nama    = $data['nama'];
	$id      = $data['id'];
	$alias   = $data['alias'];
	$gambar  = $data['gambar'];
	$ringkas = ringkas($data['ringkas'],30);
	$uid     = $data['userid'];
	
	if(!empty($gambar)) $gambar = "$fulldomain/gambar/$kanal/$gambar";
	else $gambar = "$fulldomain/images/noimages.jpg";
	
	$link = "$fulldomain/$kanal/read/$secalias/$id/$alias";
		
	$datapilihan[$id] = array("id"=>$id,"a"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"link"=>$link,"gambar"=>$gambar);
	$a++;	
}
sql_free_result($hasil);
$tpl->assign("terkait",$datapilihan);
$tpl->assign("jmlbter",$jmlbter);

?>
