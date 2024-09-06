<?php 
$sectionblog 	= array();
$h 				= 1;
$perintah 	= "select secid,nama,keterangan,alias from tbl_blog"."_sec order by secid asc";
$hasil 		= sql($perintah);
while ($data =  sql_fetch_data($hasil))
{
	$secid 		= $data['secid'];
	$namamenu 	= $data['nama'];
	$aliasmenu 	= $data['alias'];
	$ketmenu 	= $data['keterangan'];
	
	$urlmenu 	= "$fulldomain/blog/list/$aliasmenu";

	$sectionblog[$secid] = array("id"=>$secid,"h"=>$h,"nama"=>$namamenu,"aliassec"=>$aliasmenu,"urlmenu"=>$urlmenu);
	$h %= 2;
	$h++;
}
sql_free_result($hasil);

$seciduri = sql_get_var("select secid from tbl_blog_sec where alias='$subaksi'");
$tpl->assign("section",$sectionblog);
$tpl->assign("seciduri",$seciduri);
?>