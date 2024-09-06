<?php
	include("../../setingan/web.config.inc.php");
	
	$sizeid     = $_GET['sizeid'];
	$warnaid    = $_GET['warnaid'];
	$kodeproduk = $_GET['kodeproduk'];
	$perintah   = "select produkpostid,sizeid from tbl_product_post where sizeid='$sizeid' and kodeproduk='$kodeproduk' and warnaid='$warnaid' order by kodeproduk asc";
	$hasil      = sql($perintah);
	
	$data = sql_fetch_data($hasil);	
			$produkpostid = $data['produkpostid'];
			$sizeid       = $data['sizeid'];

			$totalstok       = sql_get_var("select totalstok from tbl_product_total where produkpostid='$produkpostid'");
			$totalstokonhold = sql_get_var("select jumlah from tbl_product_stokonhold where produkpostid='$produkpostid'");

	sql_free_result($hasil);
	$totalstok       = $totalstok-$totalstokonhold;

	echo json_encode($totalstok);
?>