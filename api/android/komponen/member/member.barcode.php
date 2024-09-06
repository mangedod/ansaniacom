<?php
$code 		= $_POST['code'];
$userid 		= $_POST['userid'];

if($code!='' || $userid!='' )
{
	
	$perintah	= "select code from tbl_barcode where code='$code' and published='1'";
	$hasil 		= sql($perintah);
	
	if(sql_num_rows($hasil)<1)
	{
		$result['status'] = "ERROR"; 
		$result['message'] = "Barcode tidak terdaftar didalam sistem, kemungkinan barcode telah kadaluarsa. Silahkan coba kembali untuk melakukan pemindaian ulang";
		echo json_encode($result);
		exit();
	}
	else
	{
		$row 			= sql_fetch_data($hasil);
		$code  		= $row['code'];
		
		$lastscan = sql_get_var("select create_date from tbl_barcode_scan where userid='$userid' and code='$code' order by create_date desc limit 1");
		
		
		$date = date("Y-m-d H:i:s"); 
		
		$date1 = new DateTime($lastscan);
		$date2 = new DateTime($date);
		
		$diff = $date2->diff($date1);
		
		$hours = $diff->h;
		$hours = $hours + ($diff->days*24);
		
		if($hours>24 || empty($lastscan))
		{
			earnpoin("barcode",$userid);
		
			$result['status'] = "OK"; 
			$result['message'] = "Terima kasih sudah melakukan scan barcode di lokasi yang telah kami tentukan. Sekarang poin anda bertambah dari hasil aktifitas scan barcode";
			
			
			$views = "insert into tbl_barcode_scan(create_date,userid,code) values ('$date','$userid','$code')";
			$hsl = sql($views);
		}
		else
		{
			$result['status']="ERROR";
			$result['message']="Mohon Maaf Anda scan barcode gagal dilakukan, kemungkinan anda melakukan scan barcode berulang dihari yang sama";
		}

				
		echo json_encode($result);
		exit();


	}
}
else
{
	$result['status'] = "ERROR"; 
	$result['message'] = "Barcode masih kosong, silahkan coba kembali";	

	echo json_encode($result);
	exit();
}


?>	
