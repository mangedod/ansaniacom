<?php
ini_set("display_errors","On");
require_once($lokasiweb."librari/veritrans/Veritrans.php");
Veritrans_Config::$isProduction = $isProduction;
Veritrans_Config::$serverKey = "$serverkey";
	
$notif = new Veritrans_Notification();

$transaction       = $notif->transaction_status;
$type              = $notif->payment_type;
$order_id          = $notif->order_id;
$fraud             = $notif->fraud_status;
$masked_card       = $notif->masked_card;
$bank              = $notif->bank;
$permata_va_number = $notif->permata_va_number;


$ip = $_SERVER['REMOTE_ADDR'];

$input = $HTTP_RAW_POST_DATA;
$data = date('Y-m-d H:i:s')." | $ip | $transaction | $type | $order_id | $fraud $input\r\n";
$file = "logs/backlog.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);


if ($transaction == 'capture') {
  // For credit card transaction, we need to check whether transaction is challenge by FDS or not
  if ($type == 'credit_card'){
    if($fraud == 'challenge'){
	
		  // TODO set payment status in merchant's database to 'Challenge by FDS'
		  // TODO merchant should decide whether this transaction is authorized or not in MAP
		  $message = "Transaction order_id: " . $order_id ." is challenged by FDS";
      } 
      else
	  {
	  
		$orderid = $order_id;
			
		$sql = "update tbl_transaksi set status='3',paymentinfo='$input' where orderid='$orderid'";
		$hasil	= sql($sql);
		
		$data = date('Y-m-d H:i:s')." | $ip | $sql\r\n";
		$file = "logs/backlog.txt";
		$open = fopen($file, "a+"); 
		fwrite($open, "$data"); 
		fclose($open);
	
		if($hasil)
		{
			$sql = sql("select transaksiid,totaltagihanafterdiskon,ongkoskirim,totalinvoice,userid from tbl_transaksi where orderid='$orderid'");
			$dt = sql_fetch_data($sql);
			$transaksiid = $dt['transaksiid'];
			$totaltagihanafterdiskon = $dt['totaltagihanafterdiskon'];
			$ongkoskirim = $dt['ongkoskirim'];
			$totalinvoice = $dt['totalinvoice'];
			$userid = $dt['userid'];
			
			$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
			$hsl = sql($sql);
			
			$data = date('Y-m-d H:i:s')." | $ip | $sql\r\n";
			$file = "logs/backlog.txt";
			$open = fopen($file, "a+"); 
			fwrite($open, "$data"); 
			fclose($open);
			
			$i = 1;
			$a = 1;
			while ($row = sql_fetch_data($hsl))
			{
				$transaksidetailid = $row['transaksidetailid'];
				$produkpostid      = $row['produkpostid'];
				$qty               = $row['jumlah'];
				$berat             = $row['berat'];
				$matauang          = $row['matauang'];
				$harga             = "$matauang. ". number_format($row['harga'],"0",".",".");
				$total             = "$matauang. ". number_format($row['totalharga'],"0",".",".");

				$dtprodukpos = sql_get_var_row("select title, kodeproduk, misc_harga, misc_diskon, warnaid, sizeid from tbl_product_post where produkpostid='$produkpostid'");
				$namaprod    = $dtprodukpos['title'];
				$kodeproduk  = $dtprodukpos['kodeproduk'];
				$produkid    = sql_get_var("select produkid from tbl_product where kodeproduk='$kodeproduk'");
				$warnaid     = $dtprodukpos['warnaid'];
				$warnas      = sql_get_var_row("select kode,nama from tbl_warna where id='$warnaid'");
				$kodewarna   = $warnas['kode'];
				$warna       = $warnas['nama'];
				$sizeid      = $dtprodukpos['sizeid'];
				$size        = sql_get_var("select nama from tbl_size where sizeid='$sizeid'");
				$diskon      = $dtprodukpos['misc_diskon'];
				$misc_harga  = $dtprodukpos['misc_harga'];
				$harga_asli  = "$matauang.".number_format($misc_harga,0,".",".");
				$hargadiskon = "$matauang.".number_format($diskon,0,".",".");


				if($misc_diskon!=0){
					$harga_asli = "$matauang. $hargadiskon";
				}else{
					$harga_asli  = "$matauang. $misc_harga1";
				}
				
				// album
				$gambar_s	= sql_get_var("select gambar_s from tbl_product_image where produkpostid='$produkpostid' and produkid='$produkid' order by albumid asc limit 1");
				
				if(!empty($gambar_s))
					$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
				else
					$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
				$berattotal	.= $berattotal+$row['berat'];
				
						$dt_keranjang[$transaksidetailid] = array("transaksidetailid"=>$transaksidetailid,"nama"=>$namaprod,"kodeproduk"=>$kodeproduk,"image_s"=>$image_s,"berat"=>$berat,"totalharga"=>$total,"qty"=>$qty,"harga"=>$harga,"xx"=>$a,"harga_asli"=>$harga_asli,"hargadiskon"=>$hargadiskon,"kodewarna"=>$kodewarna,"namawarna"=>$warna,"size"=>$size);

				$i %= 2;
				$i++;
				$a++;
			}
			

			$ongkoskirim2	= "$matauang. ". number_format($ongkoskirim,0,".",".");
				
			//tampilkan diskon voucher
			$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, vouchercodeid, invoiceid, kodevoucher, pembayaran,totaltagihan from tbl_transaksi where transaksiid='$transaksiid'");
			$rowv                    = sql_fetch_data($qryv);
			$invoiceid				 = $rowv['invoiceid'];
			$voucherid               = $rowv['voucherid'];
			$vouchercodeid           = $rowv['vouchercodeid'];
			$kodevoucher             = $rowv['kodevoucher'];
			$totaldiskon             = $rowv['totaldiskon'];
			$totaltagihanafterdiskon = $rowv['totaltagihanafterdiskon'];
			$totaltagihan            = $rowv['totaltagihan'];
			
			$pembayaran            = $rowv['pembayaran'];
			
			$pembayaran = "$pembayaran - Bank $bank - $masked_card";
			$tanggal = tanggal(date("Y-m-d H:i:s"));
			
			
			$namavoucher = sql_get_var("select nama from tbl_voucher where id = '$voucherid'");
			
			if($totaltagihanafterdiskon==0)
				$totaltagihanakhir = $totaltagihan+$ongkoskirim;
			else
				$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
			
			$totaltagihan1 = number_format($totaltagihan,0,",",".");
			$totaltagihan2 = "$matauang. $totaltagihan1";
			
			$totaltagihanakhir1 = number_format($totaltagihanakhir,0,",",".");
			$totaltagihanakhir2 = "$matauang. $totaltagihanakhir1";
			
			$totaldiskon1 = number_format($totaldiskon,0,",",".");
			$totaldiskon2 = "$matauang. $totaldiskon1";
			
			
			$kodeinvoice = base64_encode($invoiceid);
		
			$urlconfirm = "$fulldomain"."/cart/confirm/$kodeinvoice";
			$urldownload = "$fulldomain"."/cart/print/$kodeinvoice";
			
			$statusorder = "PAID";
			
			$warnafont = "#477603";
			
			// ambil data kontak admin
			$tk       = sql_get_var_row("select nama,alamat,telp,gsm from tbl_static where alias='kontak' limit 1");
			$namatk   = $tk['nama'];
			$alamattk = $tk['alamat'];
			$telptk   = $tk['telp'];
			$gsmtk    = $tk['gsm'];
		
			//Kirim Email ke Pembeli
			$sqlm = "select username,userfullname,useremail,userphonegsm from tbl_member where userid='$userid'";
			$hslm = sql($sqlm);
			$datam = sql_fetch_data($hslm);
			
			$userfullname = $datam['userfullname'];
			$useremail = $datam['useremail'];
			$userhandphone = $datam['userphonegsm'];
			
			sql_free_result($hslm);
			
			include("invoice.pdf.php");			
			
			
			$pengirim 			= "$owner <$support_email>";
			$webmaster_email 	= "Support <$support_email>"; 
			$userEmail			= "$email"; 
			$userFullName		= "$userfullname"; 
			$headers 			= "From : $owner";
			$subject			= "$title, Proof Shopping #$invoiceid";
			
			$sendmail			= sendmail($userfullname,$useremail,$subject,$html,$html,1);
			
			//kirim email ke admin
			$to 		= "$support_email";
			$from 		= "$support_email";
			$headers 	= "From : $owner";
			$subject2 	= "Transaction Information Paid Off $invoiceid - $title";
			
			$sendmail	= sendmail($title,$to,$subject2,$html,$html,1);
				
		
			
		}
     
	 
	 
      }
    }
  }
else if ($transaction == 'settlement')
{
   // For credit card transaction, we need to check whether transaction is challenge by FDS or not
  if($type!='')
  {
		if($type=="bank_transfer")
		{
			$orderid = $order_id;
			
			$sql = "update tbl_transaksi set status='3',settlementinfo='$input' where orderid='$orderid'";
			$hasil	= sql($sql);
			
			$data = date('Y-m-d H:i:s')." | $ip | $sql\r\n";
			$file = "logs/backlog.txt";
			$open = fopen($file, "a+"); 
			fwrite($open, "$data"); 
			fclose($open);
		
			if($hasil)
			{
				$sql = sql("select transaksiid,totaltagihanafterdiskon,ongkoskirim,totalinvoice,userid from tbl_transaksi where orderid='$orderid'");
				$dt = sql_fetch_data($sql);
				$transaksiid = $dt['transaksiid'];
				$totaltagihanafterdiskon = $dt['totaltagihanafterdiskon'];
				$ongkoskirim = $dt['ongkoskirim'];
				$totalinvoice = $dt['totalinvoice'];
				$userid = $dt['userid'];
				
				$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
				$hsl = sql($sql);
				
				$data = date('Y-m-d H:i:s')." | $ip | $sql\r\n";
				$file = "logs/backlog.txt";
				$open = fopen($file, "a+"); 
				fwrite($open, "$data"); 
				fclose($open);
				
				$i = 1;
				$a = 1;
				while ($row = sql_fetch_data($hsl))
				{
					$transaksidetailid = $row['transaksidetailid'];
					$produkpostid      = $row['produkpostid'];
					$qty               = $row['jumlah'];
					$berat             = $row['berat'];
					$matauang          = $row['matauang'];
					$harga             = "$matauang. ". number_format($row['harga'],"0",".",".");
					$total             = "$matauang. ". number_format($row['totalharga'],"0",".",".");
	
					$dtprodukpos = sql_get_var_row("select title, kodeproduk, misc_harga, misc_diskon, warnaid, sizeid from tbl_product_post where produkpostid='$produkpostid'");
					$namaprod    = $dtprodukpos['title'];
					$kodeproduk  = $dtprodukpos['kodeproduk'];
					$produkid    = sql_get_var("select produkid from tbl_product where kodeproduk='$kodeproduk'");
					$warnaid     = $dtprodukpos['warnaid'];
					$warnas      = sql_get_var_row("select kode,nama from tbl_warna where id='$warnaid'");
					$kodewarna   = $warnas['kode'];
					$warna       = $warnas['nama'];
					$sizeid      = $dtprodukpos['sizeid'];
					$size        = sql_get_var("select nama from tbl_size where sizeid='$sizeid'");
					$diskon      = $dtprodukpos['misc_diskon'];
					$misc_harga  = $dtprodukpos['misc_harga'];
					$harga_asli  = "$matauang.".number_format($misc_harga,0,".",".");
					$hargadiskon = "$matauang.".number_format($diskon,0,".",".");
	
	
					if($misc_diskon!=0){
						$harga_asli = "$matauang. $hargadiskon";
					}else{
						$harga_asli  = "$matauang. $misc_harga1";
					}
					
					// album
					$gambar_s	= sql_get_var("select gambar_s from tbl_product_image where produkpostid='$produkpostid' and produkid='$produkid' order by albumid asc limit 1");
					
					if(!empty($gambar_s))
						$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
					else
						$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
					
					$berattotal	.= $berattotal+$row['berat'];
					
							$dt_keranjang[$transaksidetailid] = array("transaksidetailid"=>$transaksidetailid,"nama"=>$namaprod,"kodeproduk"=>$kodeproduk,"image_s"=>$image_s,"berat"=>$berat,"totalharga"=>$total,"qty"=>$qty,"harga"=>$harga,"xx"=>$a,"harga_asli"=>$harga_asli,"hargadiskon"=>$hargadiskon,"kodewarna"=>$kodewarna,"namawarna"=>$warna,"size"=>$size);
	
					$i %= 2;
					$i++;
					$a++;
				}
				
	
				$ongkoskirim2	= "$matauang. ". number_format($ongkoskirim,0,".",".");
					
				//tampilkan diskon voucher
				$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, vouchercodeid, invoiceid, kodevoucher, pembayaran,totaltagihan from tbl_transaksi where transaksiid='$transaksiid'");
				$rowv                    = sql_fetch_data($qryv);
				$invoiceid				 = $rowv['invoiceid'];
				$voucherid               = $rowv['voucherid'];
				$vouchercodeid           = $rowv['vouchercodeid'];
				$kodevoucher             = $rowv['kodevoucher'];
				$totaldiskon             = $rowv['totaldiskon'];
				$totaltagihanafterdiskon = $rowv['totaltagihanafterdiskon'];
				$totaltagihan            = $rowv['totaltagihan'];
				
				$pembayaran            = $rowv['pembayaran'];
				
				$pembayaran = "$pembayaran - Virtual Account($permata_va_number)";
				$tanggal = tanggal(date("Y-m-d H:i:s"));
				
				
				$namavoucher = sql_get_var("select nama from tbl_voucher where id = '$voucherid'");
				
				if($totaltagihanafterdiskon==0)
					$totaltagihanakhir = $totaltagihan+$ongkoskirim;
				else
					$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
				
				$totaltagihan1 = number_format($totaltagihan,0,",",".");
				$totaltagihan2 = "$matauang. $totaltagihan1";
				
				$totaltagihanakhir1 = number_format($totaltagihanakhir,0,",",".");
				$totaltagihanakhir2 = "$matauang. $totaltagihanakhir1";
				
				$totaldiskon1 = number_format($totaldiskon,0,",",".");
				$totaldiskon2 = "$matauang. $totaldiskon1";
				
				
				$kodeinvoice = base64_encode($invoiceid);
			
				$urlconfirm = "$fulldomain"."/cart/confirm/$kodeinvoice";
				$urldownload = "$fulldomain"."/cart/print/$kodeinvoice";
				
				$statusorder = "PAID";
				
				$warnafont = "#477603";
				
				// ambil data kontak admin
				$tk       = sql_get_var_row("select nama,alamat,telp,gsm from tbl_static where alias='kontak' limit 1");
				$namatk   = $tk['nama'];
				$alamattk = $tk['alamat'];
				$telptk   = $tk['telp'];
				$gsmtk    = $tk['gsm'];
			
				//Kirim Email ke Pembeli
				$sqlm = "select username,userfullname,useremail,userphonegsm from tbl_member where userid='$userid'";
				$hslm = sql($sqlm);
				$datam = sql_fetch_data($hslm);
				
				$userfullname = $datam['userfullname'];
				$useremail = $datam['useremail'];
				$userhandphone = $datam['userphonegsm'];
				
				sql_free_result($hslm);
				
				include("invoice.pdf.php");			
				
				
				$pengirim 			= "$owner <$support_email>";
				$webmaster_email 	= "Support <$support_email>"; 
				$userEmail			= "$email"; 
				$userFullName		= "$userfullname"; 
				$headers 			= "From : $owner";
				$subject			= "$title, Proof Shopping #$invoiceid";
				
				$sendmail			= sendmail($userfullname,$useremail,$subject,$html,$html,1);
				
				//kirim email ke admin
				$to 		= "$support_email";
				$from 		= "$support_email";
				$headers 	= "From : $owner";
				$subject2 	= "Transaction Information Paid Off $invoiceid - $title";
				
				$sendmail	= sendmail($title,$to,$subject2,$html,$html,1);
					
			
				
			}
		}
		
		$sql = "update tbl_transaksi set status='3',settlementinfo='$input' where orderid='$orderid'";
		$hasil	= sql($sql);
		
  }
	
} 
else if($transaction == 'pending')
{
  
		$orderid = $order_id;
			
		$sql = "update tbl_transaksi set status='1',paymentinfo='$input' where orderid='$orderid'";
		$hasil	= sql($sql);
		
		$data = date('Y-m-d H:i:s')." | $ip | $sql\r\n";
		$file = "logs/backlog.txt";
		$open = fopen($file, "a+"); 
		fwrite($open, "$data"); 
		fclose($open);
	
		if($hasil)
		{
			$sql = sql("select transaksiid,totaltagihanafterdiskon,ongkoskirim,totalinvoice,userid from tbl_transaksi where orderid='$orderid'");
			$dt = sql_fetch_data($sql);
			$transaksiid = $dt['transaksiid'];
			$totaltagihanafterdiskon = $dt['totaltagihanafterdiskon'];
			$ongkoskirim = $dt['ongkoskirim'];
			$totalinvoice = $dt['totalinvoice'];
			$userid = $dt['userid'];
			
			$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
			$hsl = sql($sql);
			
			$data = date('Y-m-d H:i:s')." | $ip | $sql\r\n";
			$file = "logs/backlog.txt";
			$open = fopen($file, "a+"); 
			fwrite($open, "$data"); 
			fclose($open);
			
			$i = 1;
			$a = 1;
			while ($row = sql_fetch_data($hsl))
			{
				$transaksidetailid = $row['transaksidetailid'];
				$produkpostid      = $row['produkpostid'];
				$qty               = $row['jumlah'];
				$berat             = $row['berat'];
				$matauang          = $row['matauang'];
				$harga             = "$matauang. ". number_format($row['harga'],"0",".",".");
				$total             = "$matauang. ". number_format($row['totalharga'],"0",".",".");

				$dtprodukpos = sql_get_var_row("select title, kodeproduk, misc_harga, misc_diskon, warnaid, sizeid from tbl_product_post where produkpostid='$produkpostid'");
				$namaprod    = $dtprodukpos['title'];
				$kodeproduk  = $dtprodukpos['kodeproduk'];
				$produkid    = sql_get_var("select produkid from tbl_product where kodeproduk='$kodeproduk'");
				$warnaid     = $dtprodukpos['warnaid'];
				$warnas      = sql_get_var_row("select kode,nama from tbl_warna where id='$warnaid'");
				$kodewarna   = $warnas['kode'];
				$warna       = $warnas['nama'];
				$sizeid      = $dtprodukpos['sizeid'];
				$size        = sql_get_var("select nama from tbl_size where sizeid='$sizeid'");
				$diskon      = $dtprodukpos['misc_diskon'];
				$misc_harga  = $dtprodukpos['misc_harga'];
				$harga_asli  = "$matauang.".number_format($misc_harga,0,".",".");
				$hargadiskon = "$matauang.".number_format($diskon,0,".",".");


				if($misc_diskon!=0){
					$harga_asli = "$matauang. $hargadiskon";
				}else{
					$harga_asli  = "$matauang. $misc_harga1";
				}
				
				// album
				$gambar_s	= sql_get_var("select gambar_s from tbl_product_image where produkpostid='$produkpostid' and produkid='$produkid' order by albumid asc limit 1");
				
				if(!empty($gambar_s))
					$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
				else
					$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
				$berattotal	.= $berattotal+$row['berat'];
				
						$dt_keranjang[$transaksidetailid] = array("transaksidetailid"=>$transaksidetailid,"nama"=>$namaprod,"kodeproduk"=>$kodeproduk,"image_s"=>$image_s,"berat"=>$berat,"totalharga"=>$total,"qty"=>$qty,"harga"=>$harga,"xx"=>$a,"harga_asli"=>$harga_asli,"hargadiskon"=>$hargadiskon,"kodewarna"=>$kodewarna,"namawarna"=>$warna,"size"=>$size);

				$i %= 2;
				$i++;
				$a++;
			}
			

			$ongkoskirim2	= "$matauang. ". number_format($ongkoskirim,0,".",".");
				
			//tampilkan diskon voucher
			$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, vouchercodeid, invoiceid, kodevoucher, pembayaran,totaltagihan from tbl_transaksi where transaksiid='$transaksiid'");
			$rowv                    = sql_fetch_data($qryv);
			$invoiceid				 = $rowv['invoiceid'];
			$voucherid               = $rowv['voucherid'];
			$vouchercodeid           = $rowv['vouchercodeid'];
			$kodevoucher             = $rowv['kodevoucher'];
			$totaldiskon             = $rowv['totaldiskon'];
			$totaltagihanafterdiskon = $rowv['totaltagihanafterdiskon'];
			$totaltagihan            = $rowv['totaltagihan'];
			
			$pembayaran            = $rowv['pembayaran'];
			
			$pembayaran = "$pembayaran - Bank Transfer (Virtual Account)";
			$tanggal = tanggal(date("Y-m-d H:i:s"));
			
			
			$namavoucher = sql_get_var("select nama from tbl_voucher where id = '$voucherid'");
			
			if($totaltagihanafterdiskon==0)
				$totaltagihanakhir = $totaltagihan+$ongkoskirim;
			else
				$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
			
			$totaltagihan1 = number_format($totaltagihan,0,",",".");
			$totaltagihan2 = "$matauang. $totaltagihan1";
			
			$totaltagihanakhir1 = number_format($totaltagihanakhir,0,",",".");
			$totaltagihanakhir2 = "$matauang. $totaltagihanakhir1";
			
			$totaldiskon1 = number_format($totaldiskon,0,",",".");
			$totaldiskon2 = "$matauang. $totaldiskon1";
			
			
			$kodeinvoice = base64_encode($invoiceid);
		
			$urlconfirm = "$fulldomain"."/cart/confirm/$kodeinvoice";
			$urldownload = "$fulldomain"."/cart/print/$kodeinvoice";
			
			$statusorder = "BILLED";
			
			$warnafont = "#cf1b08";
			
			// ambil data kontak admin
			$tk       = sql_get_var_row("select nama,alamat,telp,gsm from tbl_static where alias='kontak' limit 1");
			$namatk   = $tk['nama'];
			$alamattk = $tk['alamat'];
			$telptk   = $tk['telp'];
			$gsmtk    = $tk['gsm'];
		
			//Kirim Email ke Pembeli
			$sqlm = "select username,userfullname,useremail,userphonegsm from tbl_member where userid='$userid'";
			$hslm = sql($sqlm);
			$datam = sql_fetch_data($hslm);
			
			$userfullname = $datam['userfullname'];
			$useremail = $datam['useremail'];
			$userhandphone = $datam['userphonegsm'];
			
			sql_free_result($hslm);
			
			include("invoice.pdf.php");			
			
			
			$pengirim 			= "$owner <$support_email>";
			$webmaster_email 	= "Support <$support_email>"; 
			$userEmail			= "$email"; 
			$userFullName		= "$userfullname"; 
			$headers 			= "From : $owner";
			$subject			= "$title, Pending Transaction #$invoiceid";
			
			$sendmail			= sendmail($userfullname,$useremail,$subject,$html,$html,1);
			
			//kirim email ke admin
			$to 		= "$support_email";
			$from 		= "$support_email";
			$headers 	= "From : $owner";
			$subject2 	= "Pending Transaction $invoiceid - $title";
			
			$sendmail	= sendmail($title,$to,$subject2,$html,$html,1);
				
		
			
		}
     
	$message = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
} 
else if ($transaction == 'deny') 
{
  $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
}
else if ($transaction == 'cancel') 
{
    
  $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
}

$input = $HTTP_RAW_POST_DATA;
$data = date('Y-m-d H:i:s')." | $message\r\n";
$file = "logs/backlog.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);

?>