<?php
include("../setingan/web.config.inc.php");

$sql = "select produkid,produkpostid,title from tbl_product_post order by produkid asc";
$hsl = sql($sql);

echo $sql;

while($dt = sql_fetch_data($hsl))
{
	$produkid = $dt['produkid'];
	$produkpostid = $dt['produkpostid'];

	$p = sql_get_var_row("select tipeid,title,secid,subid,brandid,alias,tag,ringkas,content,pilihan from tbl_product where produkid='$produkid'");
	$tipeid = $p['tipeid'];
	$secid = $p['secid'];
	$subid = $p['subid'];
	$brandid = $p['brandid'];
	$alias = $p['alias'];
	$tag = $p['tag'];
	$ringkas = $p['ringkas'];
	$content = $p['content'];
	$pilihan = $p['pilihan'];
	$nama = $p['title'];

	$title = "$nama $produkpostid";
	
	$s = "update tbl_product_post set title='$title',tipeid='$tipeid',secid='$secid',subid='$subid',brandid='$brandid',alias='$alias',tag='$tag',ringkas='$ringkas',content='$content',pilihan='$pilihan' where produkpostid='$produkpostid'";
	$h = sql($s);

	echo "$produkid - $produkpostid - $title - $tipeid<br>";

}


?>