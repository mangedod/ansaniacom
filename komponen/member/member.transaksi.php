<?php
		$judul_per_hlm = 8;
		$batas_paging  = 5;

		$hlm     = $var[4];
		// $subaksi = $var[4];
		$whereb  = "and resellerid='$_SESSION[useridresel]'";

		$sql = "select count(*) as jml from tbl_transaksi where 1 $whereb";
		$hsl = sql($sql);
		$tot = sql_result($hsl, 0,'jml');

		$tpl->assign("jml_post",$tot);
		
		$hlm_tot = ceil($tot / $judul_per_hlm);		
		if (empty($hlm)){
			$hlm = 1;
		}
		if ($hlm > $hlm_tot){
		$hlm = $hlm_tot;
		}
		$ord = ($hlm - 1) * $judul_per_hlm;
		if ($ord < 0 ) $ord=0;
		
		$perintah     = "select transaksiid, invoiceid, orderid, pembayaran, pengiriman, tanggaltransaksi, batastransfer, totaltagihan, totaltagihanafterdiskon, totalinvoice, ongkoskirim, status from tbl_transaksi where 1 $whereb order by tanggaltransaksi desc limit $ord, $judul_per_hlm";// and status > 0
		$hasil        = sql($perintah);
		$datalistrans = array();
		$no           = 0;
		while($data   = sql_fetch_data($hasil))
		{
			$transaksiid             = $data['transaksiid'];
			$invoiceid               = $data['invoiceid'];
			$orderid                 = $data['orderid'];
			$namaalias               = getalias($orderid);
			$pembayaran              = $data['pembayaran'];
			$pengiriman              = $data['pengiriman'];
			$tanggaltransaksi        = tanggal($data['tanggaltransaksi']);
			$batastransfer           = tanggal($data['batastransfer']);
			$totaltagihan            = $data['totaltagihan'];
			$totaltagihanafterdiskon = $data['totaltagihanafterdiskon'];
			$totalinvoice            = $data['totalinvoice'];
			$ongkoskirim             = $data['ongkoskirim'];
			$status                  = $data['status'];
			
			if($totalinvoice==0)
				$totaltagihanakhir = $totaltagihanafterdiskon;
			else
				$totaltagihanakhir = $totalinvoice;
				/*
			if($totaltagihanafterdiskon==0)
				$totaltagihanakhir = $totaltagihan;
			else
				$totaltagihanakhir = $totaltagihanafterdiskon;*/
				
			$total_bayar 		= "IDR. ".number_format($totaltagihanakhir,0,".",".");

			/*if($pembayaran == "COD")
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
				$pembayaran = sql_get_var("select nama from tbl_payment_method where paymentid='$pembayaran'");*/
			
			$kodeinvoice = base64_encode($invoiceid);
			
			if($status=="0"){ $stat = "Keranjang"; $alert = "warning"; }
			elseif($status=="1"){ $stat = "Invoice"; $alert = "warning"; }
			elseif($status=="2"){ $stat = "Konfirmasi"; $alert = "warning"; }
			elseif($status=="3"){ $stat = "Bayar"; $alert = "warning"; }
			elseif($status=="4"){ $stat = "Terkirim"; $alert = "success"; }
			elseif($status=="5"){ $stat = "Batal"; $alert = "danger"; }
			
			/*if(!empty($gambar)) $gambar = "$fulldomain/gambar/blog/$gambar";
			 else $gambar = "$fulldomain/images/noimages.jpg";*/
			 
			$link = "$fulldomain/$kanal/readtransaksi/$transaksiid/$namaalias.html";
			// $link = "$fulldomain/$kanal/transaksi/readtransaksi/$transaksiid/$namaalias.html";
			 
			$no++;
			$datalistrans[$transaksiid] = array("transaksiid"=>$transaksiid,"no"=>$no,"invoiceid"=>$invoiceid,"status"=>$stat,"alert"=>$alert,"stat"=>$stat,"pembayaran"=>$pembayaran,"link"=>$link,
					"tanggaltransaksi"=>$tanggaltransaksi,"total_bayar"=>$total_bayar,"urldetail"=>$link);
		}
		sql_free_result($hasil);
		$tpl->assign("datalistrans",$datalistrans);
		
		//Paging 
		$batas_page =5;
		
		$stringpage = array();
		$pageid =0;
		
		$Selanjutnya 	= "&rsaquo;";
		$Sebelumnya 	= "&lsaquo;";
		$Akhir			= "&raquo;";
		$Awal 			= "&laquo;";
		
		if ($hlm > 1){
			$prev = $hlm - 1;
			$stringpage[$pageid] = array("nama"=>"$Awal","link"=>"$fulldomain/$kanal/$aksi/1");
			$pageid++;
			$stringpage[$pageid] = array("nama"=>"$Sebelumnya","link"=>"$fulldomain/$kanal/$aksi/$prev");

		}
		else {
			$stringpage[$pageid] = array("nama"=>"$Awal","link"=>"");
			$pageid++;
			$stringpage[$pageid] = array("nama"=>"$Sebelumnya","link"=>"");
		}
		
		$hlm2 = $hlm - (ceil($batas_page/2));
		$hlm4= $hlm+(ceil($batas_page/2));
		
		if($hlm2 <= 0 ) $hlm3=1;
		   else $hlm3 = $hlm2;
		$pageid++;
		for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
			if ($ii==$hlm){
				$stringpage[$pageid] = array("nama"=>"$ii","link"=>"","class"=>"active");
			}else{
				$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/$aksi/$ii");
			}
			$pageid++;
		}
		if ($hlm < $hlm_tot){
			$next = $hlm + 1;
			$stringpage[$pageid] = array("nama"=>"$Selanjutnya","link"=>"$fulldomain/$kanal/$aksi/$next");
			$pageid++;
			$stringpage[$pageid] = array("nama"=>"$Akhir","link"=>"$fulldomain/$kanal/$aksi/$hlm_tot");
		}
		else
		{
			$stringpage[$pageid] = array("nama"=>"$Selanjutnya","link"=>"");
			$pageid++;
			$stringpage[$pageid] = array("nama"=>"$Akhir","link"=>"");
		}
		$tpl->assign("stringpage",$stringpage);
		//Selesai Paging

?>