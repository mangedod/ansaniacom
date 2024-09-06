<?php
include("../setingan/web.config.inc.php");

sql("truncate tbl_product_brand");

$perintah 	= "select brandid,nama,alias from q8001_ansania.tbl_product_brand";
$hasil 		= sql($perintah);
		
while($data = sql_fetch_data($hasil))
{	
	$brandid		= $data['brandid'];
	$nama 		= $data['nama'];
	$alias 		= $data['alias'];
	
	sql("insert into tbl_product_brand(brandid,nama,alias,published) values('$brandid','$nama','$alias','1')");


}
sql_free_result($hasil);

?>