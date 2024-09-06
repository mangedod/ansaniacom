<?php 
$id = $var[4];

$perintah = "select id,nama,ringkas,lengkap,organizer,lokasievent,tanggalevent,waktuevent,gambar1,gambar,create_date,alias,views from tbl_event where id='$id'";
$hasil = sql($perintah);
$data =  sql_fetch_data($hasil);

$idcontent    = $data['id'];
$nama         = $data['nama'];
$lengkap      = $data['lengkap'];
$tanggal      = tanggaltok_english($data['create_date']);
$gambar       = $data['gambar1'];
$gambarshare  = $data['gambar'];
$ringkas      = $data['ringkas'];
$alias        = $data['alias'];
$organizer    = $data['organizer'];
$lokasievent  = $data['lokasievent'];
$tanggalevent = tanggaltok_english($data['tanggalevent']);
$waktuevent   = $data['waktuevent'];

$file1 = $data['file1'];
$file2 = $data['file2'];

$extfile1 = str_replace(".","",substr($file1,-4,4));
$extfile2 = str_replace(".","",substr($file2,-4,4));
$namafile1 = str_replace("$kanal-$id-1-","",$file1);
$namafile2 = str_replace("$kanal-$id-2-","",$file2);

if(!empty($file1)){ $tpl->assign("extfile1",$extfile1); $tpl->assign("namafile1",$namafile1); $tpl->assign("file1","$fulldomain/gambar/event/upload/$file1"); } 
if(!empty($file2)){ $tpl->assign("extfile2",$extfile2); $tpl->assign("namafile2",$namafile2); $tpl->assign("file2","$fulldomain/gambar/event/upload/$file2"); } 


if(empty($katid)) $katid="0";

//Sesuaikan dengan path
$lengkap = str_replace("jscripts/tiny_mce/plugins/emotions","$domain/plugin/emotion",$lengkap);
$lengkap = str_replace("../../","/",$lengkap);


$tpl->assign("detailid",$idcontent);
$tpl->assign("detailnama",$nama);
$tpl->assign("detaillengkap",$lengkap);
$tpl->assign("detailringkas",$ringkas);
$tpl->assign("detailorganizer",$organizer);
$tpl->assign("detaillokasievent",$lokasievent);
$tpl->assign("detailtanggalevent",$tanggalevent);
$tpl->assign("detailwaktuevent",$waktuevent);

if(!empty($gambar)) $tpl->assign("detailgambar","$fulldomain/gambar/event/$gambar");
if(!empty($gambarshare)) $tpl->assign("detailgambarshare","$fulldomain/gambar/event/$gambarshare");


//assign fasilitas penunjang
if($fasilitasprint) $tpl->assign("urlprint","$fulldomain/$kanal/print/$katid/$idcontent");
if($fasilitaspdf) $tpl->assign("urlpdf","$fulldomain/$kanal/pdf/$katid/$idcontent");
if($fasilitasemail) $tpl->assign("urlemail","$fulldomain/$kanal/kirim/$katid/$idcontent");
if($fasilitasarsip) $tpl->assign("urlarsip","$fulldomain/$kanal/arsip/$secalias");
if($fasilitasrss) $tpl->assign("urlrss","$fulldomain/$kanal/rss");

sql_free_result($hasil);


?>
