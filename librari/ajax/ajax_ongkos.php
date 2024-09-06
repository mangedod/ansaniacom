<?php
	ini_set("display_errors","off");
	include("../../setingan/web.config.inc.php");
	
	$kecid   = $_GET['kecid'];
	$orderid = $_GET['orderid'];
	$kurir   = $_GET['kurir'];

	$kurir2      = sql_get_var("select kode from tbl_agen where agenid='$kurir'");
	$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where orderid='$orderid'");
	
	$berat        = sql_get_var("select sum(berat) as berat from tbl_transaksi_detail where transaksiid='$transaksiid'");
	$warehouseid  = sql_get_var("select warehouseid from tbl_transaksi_detail where transaksiid='$transaksiid'");
	$origin       = sql_get_var("select kotaid from tbl_warehouse where warehouseid='$warehouseid'");

	
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://pro.rajaongkir.com/api/cost",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "origin=$origin&originType=city&destination=$kecid&destinationType=subdistrict&weight=$berat&courier=$kurir2",
	  CURLOPT_HTTPHEADER => array(
		"content-type: application/x-www-form-urlencoded",
		"key: 1ad79460512178b0ae94d08ed5ab1150"
	  ),
	));
	
	$data = date('Y-m-d H:i:s')." | origin=$origin&originType=city&destination=$kecid&destinationType=subdistrict&weight=$berat&courier=$kurir2\r\n";
	$file = "backlog.txt";
	$open = fopen($file, "a+"); 
	fwrite($open, "$data"); 
	fclose($open);

	
	$response = curl_exec($curl);
	
	$err = curl_error($curl);
	
	curl_close($curl);
	
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
		
		$datakota 	= "";
		$data = json_decode($response, TRUE);
	    $data = $data['rajaongkir'];
	    $data = $data['results'][0];
		$data = $data['costs'];
		
		 for($i=0;$i<count($data);$i++)
		 {
			$row              = $data[$i];
			$service          = $row['service'];
			$description      = $row['description'];
			$cost             = $row['cost'][0];
			$cost             = $cost['value'];
			
			if($nilaisubsidi != '0')
			{
				if($cost > $nilaisubsidi)
				{
					$hslakhir = $cost - $nilaisubsidi;
					$costr    = number_format($hslakhir,0,",",".");
				}
				else
				{
					$hslakhir = "0";
					$costr    = number_format($hslakhir,0,",",".");
				}
			}
			else
			{
				$hslakhir = $cost;
				$costr    = number_format($hslakhir,0,",",".");
			}
				
				$subdistrict_name = str_replace("'","",$subdistrict_name);
				$nama             = base64_encode("$service - $description IDR. $costr***$cost***$nilaisubsidi***$hslakhir");

			if(!preg_match("/JTR/i", $service))
			{
				$datakota 	.= "$nama~~$description $service (IDR. $costr)|";
			}
			
		 }
		 
		 echo $datakota;
		
	}
?>