<?php
	$invoiceid = $var[4];
		
		// kueri tabel konfirmasi
		$sql1	= "select transaksiid, invoiceid, orderid, totaltagihan, pengiriman, pembayaran, userid, namalengkap, alamatpengiriman, warehouseid, voucherid, totaldiskon, 
				totaltagihanafterdiskon, ongkosinfo, ongkoskirim, status, tipe,email, tanggaltransaksi, batastransfer, bank_tujuan, kodevoucher, noresi, paymentinfo from tbl_transaksi where invoiceid='$invoiceid'";
		$hsl1 = sql($sql1);
		$row1 = sql_fetch_data($hsl1);
		
		$transaksiid             = $row1['transaksiid'];
		$invoiceid               = $row1['invoiceid'];
		$orderid                 = $row1['orderid'];
		$totaltagihan            = $row1['totaltagihan'];
		$pengiriman              = $row1['pengiriman'];
		$pembayaran              = $row1['pembayaran'];
		$userid                  = $row1['userid'];
		$namalengkap             = $row1['namalengkap'];
		$alamatpengiriman        = $row1['alamatpengiriman'];
		$warehouseid             = $row1['warehouseid'];
		$voucherid               = $row1['voucherid'];
		$kodevoucher             = $row1['kodevoucher'];
		$totaldiskon             = $row1['totaldiskon'];
		$totaltagihanafterdiskon = $row1['totaltagihanafterdiskon'];
		$ongkosinfo              = $row1['ongkosinfo'];
		$ongkoskirim             = $row1['ongkoskirim'];
		$status                  = $row1['status'];
		$tipe                    = $row1['tipe'];
		$email                   = $row1['email'];
		$tanggaltransaksi        = tanggal_english($row1['tanggaltransaksi']);
		$batastransfer           = tanggal_english($row1['batastransfer']);
		$bank_tujuan             = $row1['bank_tujuan'];
		$noresi                  = $row1['noresi'];
		$paymentinfo             = $row1['paymentinfo'];

		$dtpayinfo    = json_decode($paymentinfo);
		$kodepaynya   = $dtpayinfo->masked_card;
		$bankpaynya   = $dtpayinfo->bank;
		$virtualacnya = $dtpayinfo->permata_va_number;
		
		if($pengiriman != "Pickup Point")
		{
			$namaagen	= sql_get_var("select nama from tbl_agen where agenid='$pengiriman'");
			$pengiriman = "$namaagen - $ongkosinfo";
		}
		else
			$warehouse	= sql_get_var("select nama from tbl_warehouse where warehouseid='$warehouseid'");
		
		if($totaltagihanafterdiskon==0)
			$totaltagihanakhir = $totaltagihan+$ongkoskirim;
		else
			$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;	
			
		$ongkoskirim2		= "IDR. ". number_format($ongkoskirim,0,".",".");	
		$total_bayar 		= "IDR. ".number_format($totaltagihanakhir,0,".",".");
		$totaltagihan 		= "IDR. ".number_format($totaltagihan,0,".",".");
		$total_diskon 		= "IDR. ".number_format($totaldiskon,0,".",".");
		
		if($status=="0") $stat = "<label class=\"label label-info\">Shopping</label>";
		elseif($status=="1") $stat = "<label class=\"label label-warning\">Invoice Has Been Sent. Awaiting Payment Confirmation.</label>";
		elseif($status=="2") $stat = "<label class=\"label label-success\">Confirmation of payment has been received. Wait for Approve from Administrator.</label>";
		elseif($status=="3") $stat = "<label class=\"label label-success\">Payments already received. Orders will be processed immediately.</label>";
		elseif($status=="4") $stat = "<label class=\"label label-info\">The order has been sent.</label>";
		elseif($status=="5") $stat = "<label class=\"label label-danger\">The order has been cancelled.</label>";
		elseif($status=="6") $stat = "<label class=\"label label-danger\">The order has been cancelled.</label>";
		
		$kodeinvoice = base64_encode($invoiceid);
		
		$urlconfirm = "$fulldomain"."/cart/confirm/$kodeinvoice";
		$urldownload = "$fulldomain"."/cart/print/$kodeinvoice";
		
		sql_free_result($hsl1);
		
		$sql	= "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat from tbl_transaksi_detail 
				where transaksiid='$transaksiid'";
		$hsl 	= sql($sql);
		$xx		= 1;
		$detailproduk = array();
		while ($row = sql_fetch_data($hsl))
		{
			$transaksidetailid = $row['transaksidetailid'];
			$produkpostid      = $row['produkpostid'];
			$jumlah            = $row['jumlah'];
			$matauang          = $row['matauang'];
			$harga             = $row['harga'];
			$totalharga        = $row['totalharga'];
			$berat             = $row['berat'];
			$harga             = "$matauang ". number_format($row['harga'],0,".",".");
			$total             = "$matauang ". number_format($totalharga,0,".",".");

			$dtprodukpos = sql_get_var_row("select title, kodeproduk, misc_harga, misc_diskon, warnaid, sizeid from tbl_product_post where produkpostid='$produkpostid'");
			$namaprod    = $dtprodukpos['title'];
			$kodeproduk  = $dtprodukpos['kodeproduk'];
			$warnaid     = $dtprodukpos['warnaid'];
			$namawarna   = sql_get_var("select nama from tbl_warna where id='$warnaid'");
			$sizeid      = $dtprodukpos['sizeid'];
			$size        = sql_get_var("select nama from tbl_size where sizeid='$sizeid'");
			$diskon      = $dtprodukpos['misc_diskon'];
			$misc_harga  = $dtprodukpos['misc_harga'];
			$harga_asli  = "$matauang.".number_format($misc_harga,0,".",".");
			$hargadiskon = "$matauang.".number_format($diskon,0,".",".");
			
			$detailproduk[$transaksidetailid] = array("id"=>$id,"xx"=>$xx,"namaprod"=>$namaprod,"harga"=>$harga,"total"=>$total,"qty"=>$jumlah,"kodeproduk"=>$kodeproduk,"harga_asli"=>$harga_asli,"ketdiskon"=>$ketdiskon,"hargadiskon"=>$hargadiskon,"namawarna"=>$namawarna,"size"=>$size);
			$xx++;
			
			
		}
		sql_free_result($hsl);
		
		$totberat = sql_get_var(" SELECT SUM(berat) as total_berat from tbl_transaksi_detail where transaksiid='$transaksiid'");
		// kueri kode voucher
		$namavoucher = sql_get_var("select nama from tbl_voucher where id = '$voucherid'");

		if(!empty($voucherid))
		{
			$cekdis = 1;
			$sql4	= "select nama, jenis, jumlah from tbl_voucher where id='$voucherid'";
			$res4	= sql($sql4);
			$row4	= sql_fetch_data($res4);
				$namadiskon		= $row4['nama'];
				$jenisdiskon	= $row4['jenis'];
				$jumlahdiskon	= $row4['jumlah'];
				
				if($jenisdiskon=="persen") $diskonnya = $jumlahdiskon ." %";
				else $diskonnya = "IDR ". number_format($jumlahdiskon,0,".",".");
			sql_free_result($res4);
		}
			
		// kueri bank
		if($pembayaran == 'Transfer')
		{
			$perintah = "select * from tbl_norek where status='1' and id = '$bank_tujuan'";
			$hasil = sql($perintah);
			$rekening = array();
			while ($data=sql_fetch_data($hasil)) 
			{
				$id			= $data['id'];
				$id_bank	= $data['bank'];
				$norek		= $data['norek'];
				$atasnama	= $data['atasnama'];
				
				$sql8	= "select namabank from tbl_bank where bankid='$id_bank'";
				$res8	= sql($sql8);
				$row8	= sql_fetch_data($res8);
				$logo	= $row8['logobank'];
				$bank	= $row8['namabank'];
		
				$rekening[$id] = array("idr"=>$id,"akun"=>$norek,"bank"=>$bank,"namaak"=>$atasnama);
			
			}

			$pembayarannya = "Manual Bank Transfer";
		}
		elseif($pembayaran == "BankTransfer"){
			$pembayarannya = "ATM (Virtual Account)";
		}
		elseif($pembayaran == "CreditCard"){
			$pembayarannya = "Credit Card";
		}
		elseif($pembayaran == "CreditCard-Cicilan"){
			$pembayarannya = "Credit Card Cicilan";
		}
		
		if(empty($userid) or ($userid=='0'))
			{
				$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userFullName	= $data['userfullname'];
				$idtamu			= $data['id'];
				$useraddress 	= $data['useraddress'];
				$propinsiid		= $data['propinsiid'];
				$kotaid 		= $data['kotaid'];
				$userpostcode 	= $data['userpostcode'];
				$email 			= $data['useremail'];
				$telephone 		= $data['userphone'];
				$userphonegsm 	= $data['userphonegsm'];
			}
			else
			{
				$perintah 	= "SELECT * FROM tbl_member WHERE userid='$userid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userFullName	= $data['userfullname'];
				$userid			= $data['userid'];
				$propinsiid		= $data['propinsiid'];
				$useraddress 	= $data['useraddress'];
				// $kotaid 		= $data['cityname'];
				$kotaid 		= $data['kotaid'];
				$userpostcode	= $data['userpostcode'];
				$email 			= $data['useremail'];
				$telephone 		= $data['userphone'];
				$userphonegsm	= $data['userphonegsm'];
			}
			
			//kota
			$kota 		= sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
			
			$billingalamat = "$useraddress<br>$kota<br>$userpostcode<br>Telp. $userphonegsm";
			
			$tpl->assign("billingnama",$userFullName);
			$tpl->assign("billingalamat",$billingalamat);
			$tpl->assign("billingemail",$email);
		
		//Tampilkan jumlah berat barang
		$beratkirim 	= $totberat;
		$beratkirim 	= explode(".",$beratkirim);
		$beratkirim1 	= "0.".$beratkirim[1];
		
		if(($beratkirim1 < 1 ) && ($beratkirim1 > 0)) 
			{ $beratkirim1 = 1; }
		else if(($beratkirim1 < 1 ) && ($beratkirim[0] < 1)) 
			{ $beratkirim1 = 1; }
		else 
			{ $beratkirim1 = 0; }
		
		$jumlahberatkirim = $beratkirim[0] + $beratkirim1;
		
		
		$tpl->assign("invoiceid",$invoiceid);
		$tpl->assign("orderid",$orderid);
		$tpl->assign("totaltagihan",$totaltagihan);
		$tpl->assign("pengiriman",$pengiriman);
		$tpl->assign("pembayaran",$pembayaran);
		$tpl->assign("pembayarannya",$pembayarannya);
		$tpl->assign("userid",$userid);
		$tpl->assign("namalengkap",$namalengkap);
		$tpl->assign("alamatpengiriman",$alamatpengiriman);
		$tpl->assign("warehouseid",$warehouseid);
		$tpl->assign("warehouse",$warehouse);
		$tpl->assign("voucherid",$voucherid);
		$tpl->assign("kodevoucher",$kodevoucher);
		$tpl->assign("kode_voucher",$kodevoucher);
		$tpl->assign("namadiskon",$namavoucher);
		$tpl->assign("totaltagihanakhird",$total_bayar);
		$tpl->assign("stats",$stat);
		$tpl->assign("status",$status);
		$tpl->assign("urlconfirm",$urlconfirm);
		$tpl->assign("tanggaltransaksi",$tanggaltransaksi);
		$tpl->assign("detailproduk",$detailproduk);
		$tpl->assign("ongkos_kirim",$ongkoskirim);
		$tpl->assign("ongkos_kirim2",$ongkoskirim2);
		$tpl->assign("total_diskon",$totaldiskon);
		$tpl->assign("total_diskon2",$total_diskon);
		$tpl->assign("diskonnya",$total_diskon);
		$tpl->assign("totberat",$jumlahberatkirim);
		$tpl->assign("services",$ongkosinfo);
		$tpl->assign("rekening",$rekening);
		$tpl->assign("namaagen",$namaagen);
		$tpl->assign("urldownload",$urldownload);
		$tpl->assign("almttk",$alamattk);
		$tpl->assign("telptk",$telptk);
		$tpl->assign("no_resi",$noresi);
		$tpl->assign("kodepaynya",$kodepaynya);
		$tpl->assign("bankpaynya",$bankpaynya);
		$tpl->assign("virtualacnya",$virtualacnya);
		
		
		$tpl->assign("namarubrik","Transaction Detail");
?>