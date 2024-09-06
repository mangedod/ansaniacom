<?php 
	include($lokasiweb."/librari/captcha/securimage.php");
	$kodegen = md5(time());

	$tpl->assign('kodegen', $kodegen);
	if($_POST['action'] == "savepesan")
	{
		$invoiceid2		= $_POST['invoiceid'];
		
		$perintah 	= "select transaksiid, invoiceid, orderid, pembayaran, pengiriman, tanggaltransaksi, batastransfer, totaltagihan, totaltagihanafterdiskon, ongkoskirim, status from tbl_transaksi where invoiceid='$invoiceid2'";
		$hasil 		= sql($perintah);
		$data 		=  sql_fetch_data($hasil);
		
			$transaksiid             = $data['transaksiid'];
			$invoiceid               = $data['invoiceid'];
			$orderid                 = $data['orderid'];
			$pembayaran              = $data['pembayaran'];
			$pengiriman              = $data['pengiriman'];
			$tanggaltransaksi        = tanggal($data['tanggaltransaksi']);
			$batastransfer           = tanggal($data['batastransfer']);
			$totaltagihan            = $data['totaltagihan'];
			$totaltagihanafterdiskon = $data['totaltagihanafterdiskon'];
			$ongkoskirim             = $data['ongkoskirim'];
			$status                  = $data['status'];
			
			if($totaltagihanafterdiskon==0)
				$totaltagihanakhir = $totaltagihan;
			else
				$totaltagihanakhir = $totaltagihanafterdiskon;
				
			$total_bayar 		= "IDR. ".number_format($totaltagihanakhir,0,".",".");

			if($pembayaran == "COD")
				$pembayaran = "Cash On Delivery";
			elseif($pembayaran == "Transfer")
				$pembayaran = "Transfer Bank";
			elseif($pembayaran=="klikbca")
			{
				if(!empty($code))
				{
				
					$pembayaran = "BCA KlikPay (CreditCard)<br>Appcode: $code";
				}
				else
				{
				
					$pembayaran = "BCA KlikPay (Debit)";
				}
			}
			else
				$pembayaran = sql_get_var("select nama from tbl_payment_method where paymentid='$pembayaran'");
			
			$kodeinvoice = base64_encode($invoiceid);
			
			if($status=="0"){ $stat = "Keranjang"; $alert = "warning"; }
			elseif($status=="1"){ $stat = "Invoice"; $alert = "warning"; }
			elseif($status=="2"){ $stat = "Konfirmasi"; $alert = "warning"; }
			elseif($status=="3"){ $stat = "Bayar"; $alert = "warning"; }
			elseif($status=="4"){ $stat = "Terkirim"; $alert = "success"; }
			elseif($status=="5"){ $stat = "Batal"; $alert = "danger"; }

		$tpl->assign("invoiceidst",$invoiceid);
		$tpl->assign("pembayaranst",$pembayaran);
		$tpl->assign("total_bayarst",$total_bayar);
		$tpl->assign("tanggaltransaksist",$tanggaltransaksi);
		$tpl->assign("statusst",$stat);
		$tpl->assign("alert",$alert);
		
		sql_free_result($hasil);

	}
?>