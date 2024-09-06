<?php
include("../../setingan/web.config.inc.php");

	$kotatujuan		= $_GET[ongkosid];
	$subtotal		= $_GET[subtotal];
	$invoice		= $_GET[invoice];
	$kotatujuan1	= explode("|",$kotatujuan);
	$kota			= $kotatujuan1[0];
	$service		= $kotatujuan1[1];
	
	$data			= " SELECT SUM(berat) as total_berat from tbl_transaksi_belanja where invoice='$invoice'";
	$hasil			= sql($data);
	$total_berat 	= sql_result($hasil, "0", "total_berat");
	
	//$beratkirim 	= $total_berat/1000;
	$beratkirim 	= $total_berat;
	$beratkirim 	= explode(".",$beratkirim);
	$beratkirim1 	= "0.".$beratkirim[1];
	
	if(($beratkirim1 < 1 ) && ($beratkirim1 > 0)) 
		{ $beratkirim1 = 1; }
	else if(($beratkirim1 < 1 ) && ($beratkirim[0] < 1)) 
		{ $beratkirim1 = 1; }
	else 
		{ $beratkirim1 = 0; }
	
	$jumlahberatkirim = $beratkirim[0] + $beratkirim1;
	
	//$perintah	= "select id,harga,service,kota from tbl_ongkos WHERE `id` = '$kotatujuan'";
	$perintah	= "select id,harga,service,kota from tbl_ongkos WHERE `kota` like '$kota%' and service='$service'";
	// echo $perintah;
	$hasil		= sql($perintah);
	$data		= sql_fetch_data($hasil);
		$id			= $data['id'];
		$harga		= $data['harga'];
		$service	= $data['service'];
		$kota		= $data['kota'];
		
		$ongkoskirim 	= $harga * $jumlahberatkirim;

		$harga2			= "Rp. ". number_format($harga,0,".",".");
		$ongkoskirim2	= "Rp. ". number_format($ongkoskirim,0,".",".");
		$subtotalnya	= $subtotal + $harga;
		$subtotalnya2	= "Rp. ". number_format($subtotalnya,0,".",".");
		
		echo "<div class='alert alert-success'>
				<strong>$kota</strong> - $service : $harga2/KG x $jumlahberatkirim KG = $ongkoskirim2</div>
			||$ongkoskirim||$harga||$id||$jumlahberatkirim
		";
	sql_free_result($hasil);
?>