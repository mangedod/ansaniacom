<?php
require_once($lokasiweb."librari/veritrans/Veritrans.php");
Veritrans_Config::$isProduction = $isProduction;
Veritrans_Config::$serverKey = "$serverkey";
	
$notif = new Veritrans_Notification();

$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$fraud = $notif->fraud_status;

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
	
		if($hasil)
		{
			$sql = sql("select transaksiid,totaltagihanafterdiskon,ongkoskirim,totalinvoice,resellerid,userid,pembayaran,ongkosinfo,agen from tbl_transaksi where orderid='$orderid'");
			$dt = sql_fetch_data($sql);
			$transaksiid = $dt['transaksiid'];
			$totaltagihanafterdiskon = $dt['totaltagihanafterdiskon'];
			$ongkoskirim = $dt['ongkoskirim'];
			$totalinvoice = $dt['totalinvoice'];
			$resellerid = $dt['resellerid'];
			$userid = $dt['userid'];
			$pembayaran = $dt['pembayaran'];
			$ongkosinfo = $dt['ongkosinfo'];
			$agen = $dt['agen'];
			
			$namaagen = sql_get_var("select nama from tbl_agen where agenid='$agen'");
			
			$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
			$hsl = sql($sql);
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

				$dtprodukpos        = sql_get_var_row("select title, kodeproduk, misc_harga,misc_diskon_single,misc_diskon_double,misc_diskon_triple  from tbl_product_post where produkpostid='$produkpostid'");
				$namaprod           = $dtprodukpos['title'];
				$kodeproduk         = $dtprodukpos['kodeproduk'];
				$misc_diskon_single = $dtprodukpos['misc_diskon_single'];
				$misc_diskon_double = $dtprodukpos['misc_diskon_double'];
				$misc_diskon_triple = $dtprodukpos['misc_diskon_triple'];
				$misc_harga         = $dtprodukpos['misc_harga'];
				$harga_asli         = "$matauang.".number_format($misc_harga,0,".",".");

					$diskkk          = sql_get_var_row("select nama, diskon_persen, tanggaldiskon,harga_diskonk from tbl_product_mdiskonk where produkpostid='$produkpostid'");
					$namadiskk       = $diskkk['nama'];
					$persendiskk     = $diskkk['diskon_persen']."%";
					$tgldiskk        = $diskkk['tanggaldiskon'];
					$tgldiskk2       = tanggalonly($diskkk['tanggaldiskon']);
					$hrgdiskk        = $diskkk['harga_diskonk'];
					$tanggalsekarang = date("Y-m-d");

					if($tgldiskk == $tanggalsekarang)
					{
						$ketdiskon   = "Diskon $namadiskk ($persendiskk) Khusus tanggal $tgldiskk2:<br/>";
						$hargadiskon = "$matauang.".number_format($hrgdiskk,0,".",".");
					}
					elseif($qty == 1)
					{
						$ketdiskon   = "Diskon Single Set 20%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_single,0,".",".");
					}
					elseif ($qty == 2) 
					{
						$ketdiskon   = "Diskon Double dan Multi Set 25%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_double,0,".",".");
					}
					elseif ($qty == 3) 
					{
						$ketdiskon   = "Diskon Triple dan Optimum 30%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_triple,0,".",".");
					}
					else
					{
						$ketdiskon   = "";
						$hargadiskon = "<center>-</center>";
					}
				

				// album
				$gambar_s	= sql_get_var("select gambar_s from tbl_product_image where produkpostid='$produkpostid' order by albumid asc limit 1");
				
				if(!empty($gambar_s))
					$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
				else
					$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
				$berattotal	.= $berattotal+$row['berat'];
				
				$dt_keranjang[$transaksidetailid] = array("transaksidetailid"=>$transaksidetailid,"nama"=>$namaprod,"kodeproduk"=>$kodeproduk,"image_s"=>$image_s,"berat"=>$berat,"totalharga"=>$total,"qty"=>$qty,"harga"=>$harga,"xx"=>$a,"harga_asli"=>$harga_asli,"ketdiskon"=>$ketdiskon,"hargadiskon"=>$hargadiskon);

				$i %= 2;
				$i++;
				$a++;
			}
			

			$ongkoskirim2	= "$matauang. ". number_format($ongkoskirim,0,".",".");
				
			//tampilkan diskon voucher
			$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, vouchercodeid, kodevoucher, totaltagihan from tbl_transaksi where transaksiid='$transaksiid'");
			$rowv                    = sql_fetch_data($qryv);
			$voucherid               = $rowv['voucherid'];
			$vouchercodeid           = $rowv['vouchercodeid'];
			$kodevoucher             = $rowv['kodevoucher'];
			$totaldiskon             = $rowv['totaldiskon'];
			$totaltagihanafterdiskon = $rowv['totaltagihanafterdiskon'];
			$totaltagihan            = $rowv['totaltagihan'];
			
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
			
			
			$kodeinvoice = base64_encode($orderid);
		
			$urlconfirm = "$fulldomain/cart/confirm/$kodeinvoice";
			$urldownload = "$fulldomain/cart/print/$kodeinvoice";
			
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
			
			
			include("invoice.pdf.php");
			
			sql_free_result($hslm);
			
			$pengirim 			= "$owner <$support_email>";
			$webmaster_email 	= "Support <$support_email>"; 
			$userEmail			= "$email"; 
			$userFullName		= "$userfullname"; 
			$headers 			= "From : $owner";
			$subject			= "Bukti Belanja #$orderid";
			
			$sendmail			= sendmail($userfullname,$useremail,$subject,$html,$html,1);
			
			$contentsms	= "Terima kasih sukses telah melakukan belanja dengan nomor $orderid, kami segera mengirimkan pesanan Anda";
			$sendsms = kirimSMS($userphonegsm,$contentsms);
						
			
			//kirim email ke admin
			$to 		= "$support_email";
			$from 		= "$support_email";
			$headers 	= "From : $owner";
			$subject2 	= "Informasi Transaksi Lunas $orderid";
			
			$sendmail	= sendmail($title,$to,$subject2,$html,$html,1);
				
			//kirim email ke reseller
			$perintah	="select userid,userfullname,avatar,posting,follower,following,tema,usergender,useraddress,cityname,useremail,userphonegsm from tbl_member where userid='$resellerid' limit 1";
			$hasil= sql($perintah);
			$profil= sql_fetch_data($hasil);
			sql_free_result($hasil);
			
			$iduser = $profil['userid'];
			$contactname = $profil['userfullname'];
			$avatar = $profil['avatar'];
			$contactuseremail = $profil['useremail'];
			$contactuserphone = $profil['userphonegsm'];
			

			$tores    = "$support_email";
			$fromres  = "$support_email";
			$headers  = "From : $owner";
			$subject3 = "Informasi Pemesanan Lunas #$orderid ";
			
			$sendmail	= sendmail($contactname,$contactuseremail,$subject3,$html,$html,1);
			
			$contentsms	= "Ada transaksi lunas dengan nomor invoice $orderid, silahkan dicek ke halaman sahabat sygma Anda";
			$sendsms = kirimSMS($contactuserphone,$contentsms);

			//kirim sms ke admin
			$sqlh     = "select gsm from tbl_static where alias='kontak' limit 1";
			$queryh   = sql($sqlh);
			$rowh     = sql_fetch_data($queryh);
			$gsmadmin = $rowh['gsm'];
		
			$kirimsms	= kirimSMS($gsmadmin,"Informasi Pemesanan Lunas  No Invoice $orderid , silahkan login ke $fulldomain/panel utk melihat detail pemesanan. Terimakasih");
			
		}
     
	 
	 
      }
    }
  }
else if ($transaction == 'settlement')
{
  
   // For credit card transaction, we need to check whether transaction is challenge by FDS or not
  if ($type !='')
  {
	  	$orderid = $order_id;
			
		$sql = "update tbl_transaksi set status='3',paymentinfo='$input' where orderid='$orderid'";
		$hasil	= sql($sql);
	
		if($hasil)
		{
			$sql = sql("select transaksiid,totaltagihanafterdiskon,ongkoskirim,totalinvoice,resellerid,userid,pembayaran,ongkosinfo,agen from tbl_transaksi where orderid='$orderid'");
			$dt = sql_fetch_data($sql);
			$transaksiid = $dt['transaksiid'];
			$totaltagihanafterdiskon = $dt['totaltagihanafterdiskon'];
			$ongkoskirim = $dt['ongkoskirim'];
			$totalinvoice = $dt['totalinvoice'];
			$resellerid = $dt['resellerid'];
			$userid = $dt['userid'];
			$pembayaran = $dt['pembayaran'];
			$ongkosinfo = $dt['ongkosinfo'];
			$agen = $dt['agen'];
			
			$namaagen = sql_get_var("select nama from tbl_agen where agenid='$agen'");
			
			$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
			$hsl = sql($sql);
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

				$dtprodukpos        = sql_get_var_row("select title, kodeproduk, misc_harga,misc_diskon_single,misc_diskon_double,misc_diskon_triple  from tbl_product_post where produkpostid='$produkpostid'");
				$namaprod           = $dtprodukpos['title'];
				$kodeproduk         = $dtprodukpos['kodeproduk'];
				$misc_diskon_single = $dtprodukpos['misc_diskon_single'];
				$misc_diskon_double = $dtprodukpos['misc_diskon_double'];
				$misc_diskon_triple = $dtprodukpos['misc_diskon_triple'];
				$misc_harga         = $dtprodukpos['misc_harga'];
				$harga_asli         = "$matauang.".number_format($misc_harga,0,".",".");

					$diskkk          = sql_get_var_row("select nama, diskon_persen, tanggaldiskon,harga_diskonk from tbl_product_mdiskonk where produkpostid='$produkpostid'");
					$namadiskk       = $diskkk['nama'];
					$persendiskk     = $diskkk['diskon_persen']."%";
					$tgldiskk        = $diskkk['tanggaldiskon'];
					$tgldiskk2       = tanggalonly($diskkk['tanggaldiskon']);
					$hrgdiskk        = $diskkk['harga_diskonk'];
					$tanggalsekarang = date("Y-m-d");

					if($tgldiskk == $tanggalsekarang)
					{
						$ketdiskon   = "Diskon $namadiskk ($persendiskk) Khusus tanggal $tgldiskk2:<br/>";
						$hargadiskon = "$matauang.".number_format($hrgdiskk,0,".",".");
					}
					elseif($qty == 1)
					{
						$ketdiskon   = "Diskon Single Set 20%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_single,0,".",".");
					}
					elseif ($qty == 2) 
					{
						$ketdiskon   = "Diskon Double dan Multi Set 25%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_double,0,".",".");
					}
					elseif ($qty == 3) 
					{
						$ketdiskon   = "Diskon Triple dan Optimum 30%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_triple,0,".",".");
					}
					else
					{
						$ketdiskon   = "";
						$hargadiskon = "<center>-</center>";
					}
				

				// album
				$gambar_s	= sql_get_var("select gambar_s from tbl_product_image where produkpostid='$produkpostid' order by albumid asc limit 1");
				
				if(!empty($gambar_s))
					$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
				else
					$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
				$berattotal	.= $berattotal+$row['berat'];
				
				$dt_keranjang[$transaksidetailid] = array("transaksidetailid"=>$transaksidetailid,"nama"=>$namaprod,"kodeproduk"=>$kodeproduk,"image_s"=>$image_s,"berat"=>$berat,"totalharga"=>$total,"qty"=>$qty,"harga"=>$harga,"xx"=>$a,"harga_asli"=>$harga_asli,"ketdiskon"=>$ketdiskon,"hargadiskon"=>$hargadiskon);


				$i %= 2;
				$i++;
				$a++;
			}
			

			$ongkoskirim2	= "$matauang. ". number_format($ongkoskirim,0,".",".");
				
			//tampilkan diskon voucher
			$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, vouchercodeid, kodevoucher, totaltagihan from tbl_transaksi where transaksiid='$transaksiid'");
			$rowv                    = sql_fetch_data($qryv);
			$voucherid               = $rowv['voucherid'];
			$vouchercodeid           = $rowv['vouchercodeid'];
			$kodevoucher             = $rowv['kodevoucher'];
			$totaldiskon             = $rowv['totaldiskon'];
			$totaltagihanafterdiskon = $rowv['totaltagihanafterdiskon'];
			$totaltagihan            = $rowv['totaltagihan'];
			
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
			
			
			$kodeinvoice = base64_encode($orderid);
		
			$urlconfirm = "$fulldomain/cart/confirm/$kodeinvoice";
			$urldownload = "$fulldomain/cart/print/$kodeinvoice";
			
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
			
			
			include("invoice.pdf.php");
			
			sql_free_result($hslm);
			
			$pengirim 			= "$owner <$support_email>";
			$webmaster_email 	= "Support <$support_email>"; 
			$userEmail			= "$email"; 
			$userFullName		= "$userfullname"; 
			$headers 			= "From : $owner";
			$subject			= "Bukti Belanja #$orderid";
			
			$sendmail			= sendmail($userfullname,$useremail,$subject,$html,$html,1);
			
			$contentsms	= "Terima kasih sukses telah melakukan belanja dengan nomor $orderid, kami segera mengirimkan pesanan Anda";
			$sendsms = kirimSMS($userphonegsm,$contentsms);
						
			
			//kirim email ke admin
			$to 		= "$support_email";
			$from 		= "$support_email";
			$headers 	= "From : $owner";
			$subject2 	= "Informasi Transaksi Lunas $orderid";
			
			$sendmail	= sendmail($title,$to,$subject2,$html,$html,1);
				
			//kirim email ke reseller
			$perintah	="select userid,userfullname,avatar,posting,follower,following,tema,usergender,useraddress,cityname,useremail,userphonegsm from tbl_member where userid='$resellerid' limit 1";
			$hasil= sql($perintah);
			$profil= sql_fetch_data($hasil);
			sql_free_result($hasil);
			
			$iduser = $profil['userid'];
			$contactname = $profil['userfullname'];
			$avatar = $profil['avatar'];
			$contactuseremail = $profil['useremail'];
			$contactuserphone = $profil['userphonegsm'];
			

			$tores    = "$support_email";
			$fromres  = "$support_email";
			$headers  = "From : $owner";
			$subject3 = "Informasi Pemesanan Lunas #$orderid ";
			
			$sendmail	= sendmail($contactname,$contactuseremail,$subject3,$html,$html,1);
			
			$contentsms	= "Ada transaksi lunas dengan nomor invoice $orderid, silahkan dicek ke halaman sahabat sygma Anda";
			//$sendsms = kirimSMS($contactuserphone,$contentsms);

			//kirim sms ke admin
			$sqlh     = "select gsm from tbl_static where alias='kontak' limit 1";
			$queryh   = sql($sqlh);
			$rowh     = sql_fetch_data($queryh);
			$gsmadmin = $rowh['gsm'];
		
			//$kirimsms	= kirimSMS($gsmadmin,"Informasi Pemesanan Lunas  No Invoice $orderid , silahkan login ke $fulldomain/panel utk melihat detail pemesanan. Terimakasih");
			
		}
  }
} 
else if($transaction == 'pending')
{
  
  		$orderid = $order_id;
		$sql = "update tbl_transaksi set status='1',paymentinfo='$input' where orderid='$orderid'";
		$hasil	= sql($sql);
	
		if($hasil)
		{
			$sql = sql("select transaksiid,totaltagihanafterdiskon,ongkoskirim,totalinvoice,resellerid,userid,pembayaran,ongkosinfo,agen from tbl_transaksi where orderid='$orderid'");
			$dt = sql_fetch_data($sql);
			$transaksiid = $dt['transaksiid'];
			$totaltagihanafterdiskon = $dt['totaltagihanafterdiskon'];
			$ongkoskirim = $dt['ongkoskirim'];
			$totalinvoice = $dt['totalinvoice'];
			$resellerid = $dt['resellerid'];
			$userid = $dt['userid'];
			$pembayaran = $dt['pembayaran'];
			$ongkosinfo = $dt['ongkosinfo'];
			$agen = $dt['agen'];
			
			$namaagen = sql_get_var("select nama from tbl_agen where agenid='$agen'");
			
			$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
			$hsl = sql($sql);
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

				$dtprodukpos        = sql_get_var_row("select title, kodeproduk, misc_harga,misc_diskon_single,misc_diskon_double,misc_diskon_triple  from tbl_product_post where produkpostid='$produkpostid'");
				$namaprod           = $dtprodukpos['title'];
				$kodeproduk         = $dtprodukpos['kodeproduk'];
				$misc_diskon_single = $dtprodukpos['misc_diskon_single'];
				$misc_diskon_double = $dtprodukpos['misc_diskon_double'];
				$misc_diskon_triple = $dtprodukpos['misc_diskon_triple'];
				$misc_harga         = $dtprodukpos['misc_harga'];
				$harga_asli         = "$matauang.".number_format($misc_harga,0,".",".");

					$diskkk          = sql_get_var_row("select nama, diskon_persen, tanggaldiskon,harga_diskonk from tbl_product_mdiskonk where produkpostid='$produkpostid'");
					$namadiskk       = $diskkk['nama'];
					$persendiskk     = $diskkk['diskon_persen']."%";
					$tgldiskk        = $diskkk['tanggaldiskon'];
					$tgldiskk2       = tanggalonly($diskkk['tanggaldiskon']);
					$hrgdiskk        = $diskkk['harga_diskonk'];
					$tanggalsekarang = date("Y-m-d");

					if($tgldiskk == $tanggalsekarang)
					{
						$ketdiskon   = "Diskon $namadiskk ($persendiskk) Khusus tanggal $tgldiskk2:<br/>";
						$hargadiskon = "$matauang.".number_format($hrgdiskk,0,".",".");
					}
					elseif($qty == 1)
					{
						$ketdiskon   = "Diskon Single Set 20%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_single,0,".",".");
					}
					elseif ($qty == 2) 
					{
						$ketdiskon   = "Diskon Double dan Multi Set 25%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_double,0,".",".");
					}
					elseif ($qty == 3) 
					{
						$ketdiskon   = "Diskon Triple dan Optimum 30%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_triple,0,".",".");
					}
					else
					{
						$ketdiskon   = "";
						$hargadiskon = "<center>-</center>";
					}
				

				// album
				$gambar_s	= sql_get_var("select gambar_s from tbl_product_image where produkpostid='$produkpostid' order by albumid asc limit 1");
				
				if(!empty($gambar_s))
					$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
				else
					$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
				$berattotal	.= $berattotal+$row['berat'];
				
				$dt_keranjang[$transaksidetailid] = array("transaksidetailid"=>$transaksidetailid,"nama"=>$namaprod,"kodeproduk"=>$kodeproduk,"image_s"=>$image_s,"berat"=>$berat,"totalharga"=>$total,"qty"=>$qty,"harga"=>$harga,"xx"=>$a,"harga_asli"=>$harga_asli,"ketdiskon"=>$ketdiskon,"hargadiskon"=>$hargadiskon);


				$i %= 2;
				$i++;
				$a++;
			}
			

			$ongkoskirim2	= "$matauang. ". number_format($ongkoskirim,0,".",".");
				
			//tampilkan diskon voucher
			$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, vouchercodeid, kodevoucher, totaltagihan from tbl_transaksi where transaksiid='$transaksiid'");
			$rowv                    = sql_fetch_data($qryv);
			$voucherid               = $rowv['voucherid'];
			$vouchercodeid           = $rowv['vouchercodeid'];
			$kodevoucher             = $rowv['kodevoucher'];
			$totaldiskon             = $rowv['totaldiskon'];
			$totaltagihanafterdiskon = $rowv['totaltagihanafterdiskon'];
			$totaltagihan            = $rowv['totaltagihan'];
			
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
			
			
			$kodeinvoice = base64_encode($orderid);
		
			$urlconfirm = "$fulldomain/cart/confirm/$kodeinvoice";
			$urldownload = "$fulldomain/cart/print/$kodeinvoice";
			
			$statusorder = "BILLED";
			
			$warnafont = "#c90916";
			
			//Ambil data kontak admin
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
			
			
			include("invoice.pdf.php");
			
			sql_free_result($hslm);
			
			$pengirim 			= "$owner <$support_email>";
			$webmaster_email 	= "Support <$support_email>"; 
			$userEmail			= "$email"; 
			$userFullName		= "$userfullname"; 
			$headers 			= "From : $owner";
			$subject			= "Tagihan Belanja #$orderid";
			
			$html .= "<br><hr><br>Silahkan lakukan pembayaran dengan menggunakan metode pembayaran yang telah Anda pilih sebelumnya, setelah
			Anda melakukan pembayaran kami akan segera memproses transaksi Anda";
			
			$sendmail			= sendmail($userfullname,$useremail,$subject,$html,$html,1);
			
			$contentsms	= "Transaksi dengan nomor $orderid ditunda, silahkan lakukan pembayaran terlebih dahulu ";
			$sendsms = kirimSMS($userphonegsm,$contentsms);
						
			
			//kirim email ke admin
			$to 		= "$support_email";
			$from 		= "$support_email";
			$headers 	= "From : $owner";
			$subject2 	= "Informasi Transaksi Pending $orderid";
			
			$sendmail	= sendmail($title,$to,$subject2,$html,$html,1);
				
			//kirim email ke reseller
			$perintah	="select userid,userfullname,avatar,posting,follower,following,tema,usergender,useraddress,cityname,useremail,userphonegsm from tbl_member where userid='$resellerid' limit 1";
			$hasil= sql($perintah);
			$profil= sql_fetch_data($hasil);
			sql_free_result($hasil);
			
			$iduser = $profil['userid'];
			$contactname = $profil['userfullname'];
			$avatar = $profil['avatar'];
			$contactuseremail = $profil['useremail'];
			$contactuserphone = $profil['userphonegsm'];
			

			$tores    = "$support_email";
			$fromres  = "$support_email";
			$headers  = "From : $owner";
			$subject3 = "Informasi Pemesanan Lunas #$orderid ";
			
			$sendmail	= sendmail($contactname,$contactuseremail,$subject3,$html,$html,1);
			
			$contentsms	= "Ada transaksi Pending dengan nomor invoice $orderid, silahkan dicek ke halaman sahabat sygma Anda";
			//$sendsms = kirimSMS($contactuserphone,$contentsms);

			//kirim sms ke admin
			$sqlh     = "select gsm from tbl_static where alias='kontak' limit 1";
			$queryh   = sql($sqlh);
			$rowh     = sql_fetch_data($queryh);
			$gsmadmin = $rowh['gsm'];
		
			//$kirimsms	= kirimSMS($gsmadmin,"Informasi Pemesanan Pending  No Invoice $orderid , silahkan login ke $fulldomain/panel utk melihat detail pemesanan. Terimakasih");
			
		}
  
} 
else if ($transaction == 'deny') 
{
		$orderid = $order_id;
		$sql = "update tbl_transaksi set status='6',paymentinfo='$input' where orderid='$orderid'";
		$hasil	= sql($sql);
	
		if($hasil)
		{
			$sql = sql("select transaksiid,totaltagihanafterdiskon,ongkoskirim,totalinvoice,resellerid,userid,pembayaran,ongkosinfo,agen from tbl_transaksi where orderid='$orderid'");
			$dt = sql_fetch_data($sql);
			$transaksiid = $dt['transaksiid'];
			$totaltagihanafterdiskon = $dt['totaltagihanafterdiskon'];
			$ongkoskirim = $dt['ongkoskirim'];
			$totalinvoice = $dt['totalinvoice'];
			$resellerid = $dt['resellerid'];
			$userid = $dt['userid'];
			$pembayaran = $dt['pembayaran'];
			$ongkosinfo = $dt['ongkosinfo'];
			$agen = $dt['agen'];
			
			$namaagen = sql_get_var("select nama from tbl_agen where agenid='$agen'");
			
			$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
			$hsl = sql($sql);
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

				$dtprodukpos        = sql_get_var_row("select title, kodeproduk, misc_harga,misc_diskon_single,misc_diskon_double,misc_diskon_triple  from tbl_product_post where produkpostid='$produkpostid'");
				$namaprod           = $dtprodukpos['title'];
				$kodeproduk         = $dtprodukpos['kodeproduk'];
				$misc_diskon_single = $dtprodukpos['misc_diskon_single'];
				$misc_diskon_double = $dtprodukpos['misc_diskon_double'];
				$misc_diskon_triple = $dtprodukpos['misc_diskon_triple'];
				$misc_harga         = $dtprodukpos['misc_harga'];
				$harga_asli         = "$matauang.".number_format($misc_harga,0,".",".");

					$diskkk          = sql_get_var_row("select nama, diskon_persen, tanggaldiskon,harga_diskonk from tbl_product_mdiskonk where produkpostid='$produkpostid'");
					$namadiskk       = $diskkk['nama'];
					$persendiskk     = $diskkk['diskon_persen']."%";
					$tgldiskk        = $diskkk['tanggaldiskon'];
					$tgldiskk2       = tanggalonly($diskkk['tanggaldiskon']);
					$hrgdiskk        = $diskkk['harga_diskonk'];
					$tanggalsekarang = date("Y-m-d");

					if($tgldiskk == $tanggalsekarang)
					{
						$ketdiskon   = "Diskon $namadiskk ($persendiskk) Khusus tanggal $tgldiskk2:<br/>";
						$hargadiskon = "$matauang.".number_format($hrgdiskk,0,".",".");
					}
					elseif($qty == 1)
					{
						$ketdiskon   = "Diskon Single Set 20%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_single,0,".",".");
					}
					elseif ($qty == 2) 
					{
						$ketdiskon   = "Diskon Double dan Multi Set 25%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_double,0,".",".");
					}
					elseif ($qty == 3) 
					{
						$ketdiskon   = "Diskon Triple dan Optimum 30%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_triple,0,".",".");
					}
					else
					{
						$ketdiskon   = "";
						$hargadiskon = "<center>-</center>";
					}
				

				// album
				$gambar_s	= sql_get_var("select gambar_s from tbl_product_image where produkpostid='$produkpostid' order by albumid asc limit 1");
				
				if(!empty($gambar_s))
					$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
				else
					$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
				$berattotal	.= $berattotal+$row['berat'];
				
				$dt_keranjang[$transaksidetailid] = array("transaksidetailid"=>$transaksidetailid,"nama"=>$namaprod,"kodeproduk"=>$kodeproduk,"image_s"=>$image_s,"berat"=>$berat,"totalharga"=>$total,"qty"=>$qty,"harga"=>$harga,"xx"=>$a,"harga_asli"=>$harga_asli,"ketdiskon"=>$ketdiskon,"hargadiskon"=>$hargadiskon);


				$i %= 2;
				$i++;
				$a++;
			}
			

			$ongkoskirim2	= "$matauang. ". number_format($ongkoskirim,0,".",".");
				
			//tampilkan diskon voucher
			$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, vouchercodeid, kodevoucher, totaltagihan from tbl_transaksi where transaksiid='$transaksiid'");
			$rowv                    = sql_fetch_data($qryv);
			$voucherid               = $rowv['voucherid'];
			$vouchercodeid           = $rowv['vouchercodeid'];
			$kodevoucher             = $rowv['kodevoucher'];
			$totaldiskon             = $rowv['totaldiskon'];
			$totaltagihanafterdiskon = $rowv['totaltagihanafterdiskon'];
			$totaltagihan            = $rowv['totaltagihan'];
			
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
			
			
			$kodeinvoice = base64_encode($orderid);
		
			$urlconfirm = "$fulldomain/cart/confirm/$kodeinvoice";
			$urldownload = "$fulldomain/cart/print/$kodeinvoice";
			
			$statusorder = "BILLED";
			
			$warnafont = "#c90916";
			
			//Ambil data kontak admin
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
			
			
			include("invoice.pdf.php");
			
			sql_free_result($hslm);
			
			$pengirim 			= "$owner <$support_email>";
			$webmaster_email 	= "Support <$support_email>"; 
			$userEmail			= "$email"; 
			$userFullName		= "$userfullname"; 
			$headers 			= "From : $owner";
			$subject			= "Transaksi Ditolak #$orderid";
			
			$html .= "<br><hr><br>Transaksi Anda ditolak karena ada indikasi fraud atau penyebab lainnya, untuk informasi lebih lengkap silahkan
			hubungi nomor yang tertera di email ini";
			
			$sendmail			= sendmail($userfullname,$useremail,$subject,$html,$html,1);
			
			$contentsms	= "Transaksi dengan nomor $orderid ditolak karena terindikasi fraud";
			$sendsms = kirimSMS($userphonegsm,$contentsms);
						
			
			//kirim email ke admin
			$to 		= "$support_email";
			$from 		= "$support_email";
			$headers 	= "From : $owner";
			$subject2 	= "Informasi Transaksi Ditolak $orderid";
			
			$sendmail	= sendmail($title,$to,$subject2,$html,$html,1);
				
			//kirim email ke reseller
			$perintah	="select userid,userfullname,avatar,posting,follower,following,tema,usergender,useraddress,cityname,useremail,userphonegsm from tbl_member where userid='$resellerid' limit 1";
			$hasil= sql($perintah);
			$profil= sql_fetch_data($hasil);
			sql_free_result($hasil);
			
			$iduser = $profil['userid'];
			$contactname = $profil['userfullname'];
			$avatar = $profil['avatar'];
			$contactuseremail = $profil['useremail'];
			$contactuserphone = $profil['userphonegsm'];
			

			$tores    = "$support_email";
			$fromres  = "$support_email";
			$headers  = "From : $owner";
			$subject3 = "Informasi Transaksi Ditolak #$orderid ";
			
			$sendmail	= sendmail($contactname,$contactuseremail,$subject3,$html,$html,1);
			
			$contentsms	= "Ada transaksi Ditolak dengan nomor invoice $orderid, silahkan dicek ke halaman sahabat sygma Anda";
			//$sendsms = kirimSMS($contactuserphone,$contentsms);

			//kirim sms ke admin
			$sqlh     = "select gsm from tbl_static where alias='kontak' limit 1";
			$queryh   = sql($sqlh);
			$rowh     = sql_fetch_data($queryh);
			$gsmadmin = $rowh['gsm'];
		
			//$kirimsms	= kirimSMS($gsmadmin,"Informasi Pemesanan Pending  No Invoice $orderid , silahkan login ke $fulldomain/panel utk melihat detail pemesanan. Terimakasih");
			
		}
}
else if ($transaction == 'cancel') 
{

  $orderid = $order_id;
		$sql = "update tbl_transaksi set status='6',paymentinfo='$input' where orderid='$orderid'";
		$hasil	= sql($sql);
	
		if($hasil)
		{
			$sql = sql("select transaksiid,totaltagihanafterdiskon,ongkoskirim,totalinvoice,resellerid,userid,pembayaran,ongkosinfo,agen from tbl_transaksi where orderid='$orderid'");
			$dt = sql_fetch_data($sql);
			$transaksiid = $dt['transaksiid'];
			$totaltagihanafterdiskon = $dt['totaltagihanafterdiskon'];
			$ongkoskirim = $dt['ongkoskirim'];
			$totalinvoice = $dt['totalinvoice'];
			$resellerid = $dt['resellerid'];
			$userid = $dt['userid'];
			$pembayaran = $dt['pembayaran'];
			$ongkosinfo = $dt['ongkosinfo'];
			$agen = $dt['agen'];
			
			$namaagen = sql_get_var("select nama from tbl_agen where agenid='$agen'");
			
			$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
			$hsl = sql($sql);
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

				$dtprodukpos        = sql_get_var_row("select title, kodeproduk, misc_harga,misc_diskon_single,misc_diskon_double,misc_diskon_triple  from tbl_product_post where produkpostid='$produkpostid'");
				$namaprod           = $dtprodukpos['title'];
				$kodeproduk         = $dtprodukpos['kodeproduk'];
				$misc_diskon_single = $dtprodukpos['misc_diskon_single'];
				$misc_diskon_double = $dtprodukpos['misc_diskon_double'];
				$misc_diskon_triple = $dtprodukpos['misc_diskon_triple'];
				$misc_harga         = $dtprodukpos['misc_harga'];
				$harga_asli         = "$matauang.".number_format($misc_harga,0,".",".");

					$diskkk          = sql_get_var_row("select nama, diskon_persen, tanggaldiskon,harga_diskonk from tbl_product_mdiskonk where produkpostid='$produkpostid'");
					$namadiskk       = $diskkk['nama'];
					$persendiskk     = $diskkk['diskon_persen']."%";
					$tgldiskk        = $diskkk['tanggaldiskon'];
					$tgldiskk2       = tanggalonly($diskkk['tanggaldiskon']);
					$hrgdiskk        = $diskkk['harga_diskonk'];
					$tanggalsekarang = date("Y-m-d");

					if($tgldiskk == $tanggalsekarang)
					{
						$ketdiskon   = "Diskon $namadiskk ($persendiskk) Khusus tanggal $tgldiskk2:<br/>";
						$hargadiskon = "$matauang.".number_format($hrgdiskk,0,".",".");
					}
					elseif($qty == 1)
					{
						$ketdiskon   = "Diskon Single Set 20%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_single,0,".",".");
					}
					elseif ($qty == 2) 
					{
						$ketdiskon   = "Diskon Double dan Multi Set 25%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_double,0,".",".");
					}
					elseif ($qty == 3) 
					{
						$ketdiskon   = "Diskon Triple dan Optimum 30%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_triple,0,".",".");
					}
					else
					{
						$ketdiskon   = "";
						$hargadiskon = "<center>-</center>";
					}
				

				// album
				$gambar_s	= sql_get_var("select gambar_s from tbl_product_image where produkpostid='$produkpostid' order by albumid asc limit 1");
				
				if(!empty($gambar_s))
					$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
				else
					$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
				$berattotal	.= $berattotal+$row['berat'];
				
				$dt_keranjang[$transaksidetailid] = array("transaksidetailid"=>$transaksidetailid,"nama"=>$namaprod,"kodeproduk"=>$kodeproduk,"image_s"=>$image_s,"berat"=>$berat,"totalharga"=>$total,"qty"=>$qty,"harga"=>$harga,"xx"=>$a,"harga_asli"=>$harga_asli,"ketdiskon"=>$ketdiskon,"hargadiskon"=>$hargadiskon);


				$i %= 2;
				$i++;
				$a++;
			}
			

			$ongkoskirim2	= "$matauang. ". number_format($ongkoskirim,0,".",".");
				
			//tampilkan diskon voucher
			$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, vouchercodeid, kodevoucher, totaltagihan from tbl_transaksi where transaksiid='$transaksiid'");
			$rowv                    = sql_fetch_data($qryv);
			$voucherid               = $rowv['voucherid'];
			$vouchercodeid           = $rowv['vouchercodeid'];
			$kodevoucher             = $rowv['kodevoucher'];
			$totaldiskon             = $rowv['totaldiskon'];
			$totaltagihanafterdiskon = $rowv['totaltagihanafterdiskon'];
			$totaltagihan            = $rowv['totaltagihan'];
			
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
			
			
			$kodeinvoice = base64_encode($orderid);
		
			$urlconfirm = "$fulldomain/cart/confirm/$kodeinvoice";
			$urldownload = "$fulldomain/cart/print/$kodeinvoice";
			
			$statusorder = "BILLED";
			
			$warnafont = "#c90916";
			
			//Ambil data kontak admin
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
			
			
			include("invoice.pdf.php");
			
			sql_free_result($hslm);
			
			$pengirim 			= "$owner <$support_email>";
			$webmaster_email 	= "Support <$support_email>"; 
			$userEmail			= "$email"; 
			$userFullName		= "$userfullname"; 
			$headers 			= "From : $owner";
			$subject			= "Transaksi Ditolak #$orderid";
			
			$html .= "<br><hr><br>Transaksi Anda dibatalkan karena telah melebih batas waktu pembayaran atau sebab lainnya, untuk informasi lebih lengkap silahkan
			hubungi nomor yang tertera di email ini";
			
			$sendmail			= sendmail($userfullname,$useremail,$subject,$html,$html,1);
			
			$contentsms	= "Transaksi dengan nomor $orderid dibatalkan karena expire atau sebab lainnya";
			$sendsms = kirimSMS($userphonegsm,$contentsms);
						
			
			//kirim email ke admin
			$to 		= "$support_email";
			$from 		= "$support_email";
			$headers 	= "From : $owner";
			$subject2 	= "Informasi Transaksi Dibatalkan $orderid";
			
			$sendmail	= sendmail($title,$to,$subject2,$html,$html,1);
				
			//kirim email ke reseller
			$perintah	="select userid,userfullname,avatar,posting,follower,following,tema,usergender,useraddress,cityname,useremail,userphonegsm from tbl_member where userid='$resellerid' limit 1";
			$hasil= sql($perintah);
			$profil= sql_fetch_data($hasil);
			sql_free_result($hasil);
			
			$iduser = $profil['userid'];
			$contactname = $profil['userfullname'];
			$avatar = $profil['avatar'];
			$contactuseremail = $profil['useremail'];
			$contactuserphone = $profil['userphonegsm'];
			

			$tores    = "$support_email";
			$fromres  = "$support_email";
			$headers  = "From : $owner";
			$subject3 = "Informasi Transaksi Dibatalkan #$orderid ";
			
			$sendmail	= sendmail($contactname,$contactuseremail,$subject3,$html,$html,1);
			
			$contentsms	= "Ada transaksi Dibatalkan dengan nomor invoice $orderid, silahkan dicek ke halaman sahabat sygma Anda";
			//$sendsms = kirimSMS($contactuserphone,$contentsms);

			//kirim sms ke admin
			$sqlh     = "select gsm from tbl_static where alias='kontak' limit 1";
			$queryh   = sql($sqlh);
			$rowh     = sql_fetch_data($queryh);
			$gsmadmin = $rowh['gsm'];
		
			//$kirimsms	= kirimSMS($gsmadmin,"Informasi Pemesanan Pending  No Invoice $orderid , silahkan login ke $fulldomain/panel utk melihat detail pemesanan. Terimakasih");
			
		}
		
		$message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
}

$input = $HTTP_RAW_POST_DATA;
$data = date('Y-m-d H:i:s')." | $message\r\n";
$file = "logs/backlog.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);


?>