<?php
	ini_set("display_errors","off");
	include("../../setingan/web.config.inc.php");
	
	$ongkir  = $_GET['ongkir'];
	$orderid = $_GET['orderid'];
	$ongkir  = base64_decode($ongkir);
	
	$data         = explode("***",$ongkir);
	$ongkosawal   = $data[1];
	$nilaisubsidi = $data[2];
	$ongkosakhir  = $data[3];
	
	$sql                     = sql("select transaksiid,totaltagihanafterdiskon from tbl_transaksi where orderid='$orderid'");
	$dt                      = sql_fetch_data($sql);
	$transaksiid             = $dt['transaksiid'];
	$totaltagihanafterdiskon = $dt['totaltagihanafterdiskon'];
	// $confee               = substr($orderid,-3,3);
	$warehouseid             = sql_get_var("select warehouseid from tbl_transaksi_detail where transaksiid='$transaksiid'");

		$total    = $totaltagihanafterdiskon+$ongkosakhir;
		// $total = $total-$confee;
		
		$ongkosawrp  = "IDR ".number_format($ongkosawal,0,",",".");
		$ongkosakrp  = "IDR ".number_format($ongkosakhir,0,",",".");
		$nilaisubsrp = "IDR ".number_format($nilaisubsidi,0,",",".");
		$totalrp     = "IDR ".number_format($total,0,",",".");
	
	echo "$ongkosawrp~~$ongkosakhir~~$ongkosakrp~~$nilaisubsrp~~$total~~$totalrp";
	
?>