<?php 
if(file_exists($lokasiweb."/komponen/$kanal/$kanal.$aksi.php")) include("$kanal.$aksi.php");
else{ $aksi = "list";  include("$kanal.list.php"); }

include($lokasiweb."/komponen/controller/controller.controller.php");

$aboutmenu = array();
$h = 1;
$perintah = "select id,nama,lengkap,ringkas,alias,gambar1 from tbl_about order by id asc";
$hasil = sql($perintah);
while ($data =  sql_fetch_data($hasil))
{
	$id        = $data['id'];
	$namamenu  = $data['nama'];
	$lengkap   = $data['lengkap'];
	$ringkas   = $data['ringkas'];
	$aliasmenu = $data['alias'];
	$gambar1   = $data['gambar1'];

	if(!empty($gambar1))
		$gambar1	= "$fulldomain/gambar/aboutus/$gambar1";
	
	$urlmenu = "$fulldomain/about/read/$id/$aliasmenu";

	$aboutmenu[$id] = array("id"=>$id,"h"=>$h,"nama"=>$namamenu,"lengkapabout"=>$lengkap,"ringkasabout"=>$ringkas,"gambarabout"=>$gambar1,"urlmenu"=>$urlmenu);
	$h %= 2;
	$h++;

}
sql_free_result($hasil);
$tpl->assign("aboutmenu",$aboutmenu);

/*$faqmenu = array();
$h1 = 1;
$perintah1 = "select secid,nama,alias from tbl_faq_sec order by secid asc";
$hasil1 = sql($perintah1);
while ($data1 =  sql_fetch_data($hasil1))
{
	$id1 = $data1['secid'];
	$namamenu1 = $data1['nama'];
	$aliasmenu1 = $data1['alias'];
	
	$urlmenu1 = "$fulldomain/about/faq/$id1/$aliasmenu1.html";

	$faqmenu[$secid] = array("secid"=>$id1,"h1"=>$h1,"nama"=>$namamenu1,"urlmenu"=>$urlmenu1);
	$h1 %= 2;
	$h1++;

}
sql_free_result($hasil1);
$tpl->assign("faqmenu",$faqmenu);*/

$tpl->display("$kanal.html");
?>