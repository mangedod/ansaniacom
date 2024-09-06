<?php
	include("../../setingan/web.config.inc.php");
	
	$kecid        = $_GET['kecid'];
	$orderid      = $_GET['orderid'];

	$kotaid      = sql_get_var("select kotaid from tbl_kecamatan where kecid='$kecid'");
	$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where orderid='$orderid'");
	$warehouseid = sql_get_var("select warehouseid from tbl_transaksi_detail where transaksiid='$transaksiid'");
	$kotaid22    = sql_get_var("select kotaid from tbl_warehouse where warehouseid='$warehouseid'");

	$perintah1 	= "select namakota,status from tbl_kota where kotaid='$kotaid'";
	$hasil1 	= sql($perintah1);
	$data1 		= sql_fetch_data($hasil1);
			
	$namakota   = $data1['namakota']; 
	$statusfree = $data1['status'];

	$perintah1 	= "select agenid,nama from tbl_agen where status='1' order by nama asc";
	$hasil1 	= sql($perintah1);
	while ($data1 		= sql_fetch_data($hasil1)){
			
			$agenid 	= $data1['agenid'];
			$nama 		= $data1['nama'];
			
			$datakota 	.= "$agenid~~$nama|";
	}
	sql_free_result($hasil1);
	echo"$datakota";
	
	
	
	echo "^^^";
	
	$sql1 = "select paymentid,nama from tbl_payment_method order by nama asc";
	$hsl1 = sql($sql1);
	
	while ($row1 = sql_fetch_data($hsl1))
	{
		
		$levelid 	= $row1['paymentid'];
		$level 		= $row1['nama'];
		if(!empty($level))
			$datajur1 	.= "$levelid~~$level|";
	}
	
	echo"$datajur1";
?>