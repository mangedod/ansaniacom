<?php
include("../setingan/web.config.inc.php");

$perintah 	= "select * from tbl_product_post where produkid='0'";
$hasil 		= sql($perintah);

while($data = sql_fetch_data($hasil))
{	
	$produkpostid		= $data['produkpostid'];
	$kodeproduk 		= $data['kodeproduk'];

	$produkid = sql_get_var("select produkid from tbl_product where kodeproduk='$kodeproduk'");
	
	echo "$produkpostid - $produkid<br>";
	
	$sqls = sql("update tbl_product_post set produkid='$produkid' where produkpostid='$produkpostid'");
	

}
sql_free_result($hasil);
?>