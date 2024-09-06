<?php 
$mysql = "select url,id,nama,alias from tbl_ask order by id asc";
$hasil = sql($mysql);

$menu = array();
$a =1;
while ($row = sql_fetch_data($hasil)) 
{	
	$id     = $row['id'];
	$nama       = $row['nama'];
	$alias      = $row['alias'];
	$keterangan = $row['keterangan'];
	$gambar     = $row['gambar'];

	$url = "$fulldomain/ask/redirect/$alias/";		
		
	$menu[]= array("id"=>$id,"no"=>$a,"nama"=>$nama,"alias"=>$alias,"url"=>$url,"gambar"=>$gambar);
	$a++;	
}
$tpl->assign("menu",$menu);
?>