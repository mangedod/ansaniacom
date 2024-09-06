<?php
	include("../../setingan/web.config.inc.php");
	
	$propinsi 	= $_GET['propinsi'];
	$perintah 	= "select kotaid,namakota,tipe from tbl_kota where propid='$propinsi' order by namakota asc";
	$hasil 		= sql($perintah);
			
	$datakota 	= "";
	
	while ($data = sql_fetch_data($hasil)){	
			$isi_id		= $data['kotaid'];
			$kota 		= $data['namakota'];
			$tipe 		= $data['tipe'];
			
			if($tipe=="Kota") $kota = "$kota (Kota)";
			
			$datakota 	.= "$isi_id~~$kota|";
	}
	sql_free_result($hasil);
	echo"$datakota";
?>