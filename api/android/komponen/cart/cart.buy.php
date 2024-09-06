<?php
// Detail Produk
$produkpostid	= $_POST['id'];
$qty			= $_POST['jml'];
$id_qty 		= $_POST['id_qty'];
$userid = $_POST['userid'];
$orderid = $_POST['orderid'];

$date = date("Y-m-d H:i:s");

if(empty($orderid) || $orderid=="undefined")
{
	$orderid = "FS".date("U");
}

if(isset($produkpostid))
{	
	
	$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where orderid='$orderid'");
	$iscart = sql_get_var("select produkpostid from tbl_transaksi_detail where transaksiid='$transaksiid' and transaksiid!='' and produkpostid='$produkpostid'");
	
	if(!empty($iscart))
	{
				
		$stokawal	= sql_get_var("select stock from tbl_product_post where produkpostid='$produkpostid'");
		$namaprod	= sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");
		
		$stokakhir	= $stokawal;
		
		if($qty > $stokakhir)
		{
			$benar = false;
		}
		else
			$benar = true;
			
	
		if($benar)
		{			
			$lastqty = sql_get_var("select jumlah from tbl_transaksi_detail where transaksiid='$transaksiid' and transaksiid!='' and produkpostid='$produkpostid'");
			$qty = $lastqty+1;
			
			$sql = "select title,harga,body_weight,harga from tbl_product_post where produkpostid = '$produkpostid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			$title 		= $row["title"];
			$berat 		= $row['body_weight'];
			$harga 		= $row['harga'];
					
			$berat 	= $berat * $qty;
			$total 	= $harga * $qty;
			
			sql_free_result($hsl);
			
			$qty = intval($qty);			

			$query1	= "update tbl_transaksi_detail set  berat='$berat',jumlah='$qty',harga='$harga',totalharga='$total' where  transaksiid='$transaksiid' and transaksiid!='' and produkpostid='$produkpostid'";
			$hasil1 = sql($query1);
			
			$result['status'] = "OK"; 
			$result['message'] = "Sukses menambahkan produk kedalam keranjang";
			$result['transid'] = $orderid;
		
			echo json_encode($result);
			exit();
			
			
		}
		else
		{
			$salah = "Jumlah kuantitas produk $namaprod yang dibeli tidak mencukupi. Silahkan kurangi jumlah kuantitas produk anda untuk melanjutkan belanja.<br><br>\n";
			$result['status'] = "ERROR"; 
			$result['message'] = $salah;
		
			echo json_encode($result);
			exit();
		}

	}
	else
	{
		
		$stokawal	= sql_get_var("select stock from tbl_product_post where produkpostid='$produkpostid'");
		$namaprod	= sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");
		
		$stokakhir	= $stokawal;
		
		if($qty > $stokakhir)
		{
			$benar = false;
			//break;
		}
		else
			$benar = true;
			
		if($benar)
		{			
			$sql = "select title,harga,body_weight,harga from tbl_product_post where produkpostid = '$produkpostid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			$title 		= $row["title"];
			$berat 		= $row['body_weight'];
			$harga 		= $row['harga'];
					
			$berat 	= $berat * $qty;
			$total 	= $harga * $qty;
			
			sql_free_result($hsl);
			
			$qty = intval($qty);
			
			$cv = $qty*$cv;
			
			
			// Input kedalam database
			$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where orderid='$orderid'");
			
			if (empty($transaksiid))
			{
				$new = newid("transaksiid","tbl_transaksi");				
			
				$query	= ("insert into tbl_transaksi (`transaksiid`,`orderid`,`status`,userid,create_date) 
							values ('$new','$orderid','0','$userid','$date')");
				$hasil = sql($query);
				
				
				$newdetail = newid("transaksidetailid","tbl_transaksi_detail");
				$query1	= ("insert into tbl_transaksi_detail (`transaksidetailid`,`transaksiid`,`produkpostid`,`harga`,`matauang`,`totalharga`,`jumlah`,`berat`,cv) 
							values ('$newdetail','$new','$produkpostid','$harga','$matauang','$total','$qty','$berat','$cv')");
				$hasil1 = sql($query1);
			}
			else
			{
				
				
				if (empty($transaksidetailid))
				{
					$newdetail = newid("transaksidetailid","tbl_transaksi_detail");
					$query1	= ("insert into tbl_transaksi_detail (`transaksidetailid`,`transaksiid`,`produkpostid`,`harga`,`matauang`,`totalharga`,`jumlah`,`berat`) 
								values ('$newdetail','$transaksiid','$produkpostid','$harga','$matauang','$total','$qty','$berat')");
					$hasil1 = sql($query1);
				}
			}
			
			$result['status'] = "OK"; 
			$result['message'] = "Sukses menambahkan produk kedalam keranjang";
			$result['transid'] = $orderid;
		
			echo json_encode($result);
			exit();
			
			
		}
		else
		{
			$salah = "Jumlah kuantitas produk $namaprod yang dibeli tidak mencukupi. Silahkan kurangi jumlah kuantitas produk anda untuk melanjutkan belanja.<br><br>\n";
			$result['status'] = "ERROR"; 
			$result['message'] = $salah;
		
			echo json_encode($result);
			exit();
		}
	}
	

}



?>