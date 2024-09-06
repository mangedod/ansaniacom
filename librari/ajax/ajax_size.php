<?php
	include("../../setingan/web.config.inc.php");
	
	$warnaid    = $_GET['warnaid'];
	$kodeproduk = $_GET['kodeproduk'];
	$perintah   = "select produkpostid,sizeid from tbl_product_post where warnaid='$warnaid' and kodeproduk='$kodeproduk' order by kodeproduk asc";
	$hasil      = sql($perintah);
			
	$dataiwarna     = "";
	$jmltotalstok = 0;
	$jmlstokonh   = 0;
	
	while ($data = sql_fetch_data($hasil)){	
			$produkpostid = $data['produkpostid'];
			$sizeid       = $data['sizeid'];

			$size            = sql_get_var("select nama from tbl_size where sizeid='$sizeid'");
			$totalstok       = sql_get_var("select totalstok from tbl_product_total where produkpostid='$produkpostid'");
			$totalstokonhold = sql_get_var("select jumlah from tbl_product_stokonhold where produkpostid='$produkpostid'");
			$jmltotalstok    = $jmltotalstok+$totalstok;
			$jmlstokonh      = $jmlstokonh+$jmlstokonh;

			$dtsize[$produkpostid] = array("size"=> $size, "sizeid"=>$sizeid);
	}
	sql_free_result($hasil);
	$totalstok           = $jmltotalstok-$jmlstokonh;
	$dtitem['oSize']      = $dtsize;
	$dtitem['totalstok'] = $totalstok;
	// echo json_encode($dtsize);
	echo json_encode($dtitem);
?>