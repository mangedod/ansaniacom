<?php
	$transaksiidnya = $var[4];
	$perintah = "select transaksiid, invoiceid, orderid, totaltagihan, pengiriman, pembayaran, userid, namalengkap, alamatpengiriman, warehouseid, voucherid, totaldiskon, 
				totaltagihanafterdiskon, ongkosinfo, ongkoskirim, status, tipe,email, tanggaltransaksi, batastransfer, noresi, flag, statuskirim, tanggalkirim, tanggalterima, 
				namapenerimapaket, notelppenerimapaket, kodevoucher from tbl_transaksi 
				where transaksiid='$transaksiidnya'";
	$hasil = sql($perintah);
	$row1 =  sql_fetch_data($hasil);
	
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
	$totaldiskon             = $row1['totaldiskon'];
	$totaltagihanafterdiskon = $row1['totaltagihanafterdiskon'];
	$ongkosinfo              = $row1['ongkosinfo'];
	$services                = $ongkosinfo;
	$ongkoskirim             = $row1['ongkoskirim'];
	$status                  = $row1['status'];
	$statuskirim             = $row1['statuskirim'];
	$tanggalkirim            = $row1['tanggalkirim'];
	$tanggalterima           = tanggal($row1['tanggalterima']);
	$namapenerimapaket       = $row1['namapenerimapaket'];
	$notelppenerimapaket     = $row1['notelppenerimapaket'];
	$tipe                    = $row1['tipe'];
	$email                   = $row1['email'];
	$tanggaltransaksi        = tanggal($row1['tanggaltransaksi']);
	$batastransfer           = tanggal($row1['batastransfer']);
	$flag                    = $row1['flag'];
	$noresi                  = $row1['noresi'];
	$kodevoucher             = $row1['kodevoucher'];
	
	if($totaltagihanafterdiskon==0)
		$totaltagihanakhir = $totaltagihan+$ongkoskirim;
	else
		$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
	
	if($tanggalkirim!="0000-00-00 00:00:00"){
			$tanggalkirim2 = tanggal($tanggalkirim);}
	else{
			$tanggalkirim2 = "";}
		
	$ongkoskirim2		= "IDR. ". number_format($ongkoskirim,0,".",".");	
	$total_bayar 		= "IDR. ".number_format($totaltagihanakhir,0,".",".");
	$totaltagihan 		= "IDR. ".number_format($totaltagihan,0,".",".");
	$total_diskon 		= "IDR. ".number_format($totaldiskon,0,".",".");
	
	if($status=="0") $stat = "Keranjang";
	elseif($status=="1") $stat = "Invoice";
	elseif($status=="2") $stat = "Konfirmasi";
	elseif($status=="3") $stat = "Bayar";
	elseif($status=="4") $stat = "Pengiriman";
	elseif($status=="5") $stat = "Batal";
	
	$kodeinvoice = base64_encode($invoiceid);
	
	$urlconfirm = "$fulldomain/cart/confirm/$kodeinvoice";
	
	// $services 		= sql_get_var("select service from tbl_ongkos where id='$ongkosid'");
	$namatoko 		= sql_get_var("select nama from tbl_warehouse where warehouseid='$warehouseid'");
	if($pengiriman != "Pickup Point")
		$pengiriman = sql_get_var("select nama from tbl_agen where agenid='$pengiriman'");
	
	$sql   = "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat from tbl_transaksi_detail where transaksiid='$transaksiidnya'";
	$hsl   = sql($sql);
	$xx    = 1;
	$nomer = 1;
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
				$tgldiskk2       = tanggaltok($diskkk['tanggaldiskon']);
				$hrgdiskk        = $diskkk['harga_diskonk'];
				$tanggalsekarang = date("Y-m-d");

				if($tgldiskk == $tanggalsekarang)
				{
					$ketdiskon   = "Diskon $namadiskk ($persendiskk) Khusus tanggal $tgldiskk2:<br/>";
					$hargadiskon = "$matauang.".number_format($hrgdiskk,0,".",".");
				}
				elseif($jumlah == 1)
				{
					$ketdiskon   = "Diskon Single Set 20%:<br/>";
					$hargadiskon = "$matauang.".number_format($misc_diskon_single,0,".",".");
				}
				elseif ($jumlah == 2) 
				{
					$ketdiskon   = "Diskon Double dan Multi Set 25%:<br/>";
					$hargadiskon = "$matauang.".number_format($misc_diskon_double,0,".",".");
				}
				elseif ($jumlah == 3) 
				{
					$ketdiskon   = "Diskon Triple dan Optimum 30%:<br/>";
					$hargadiskon = "$matauang.".number_format($misc_diskon_triple,0,".",".");
				}
				else
				{
					$ketdiskon   = "";
					$hargadiskon = "<center>-</center>";
				}
		
		$detailtransaksi[$transaksidetailid] = array("transaksidetailid"=>$transaksidetailid,"kodeproduk"=>$kodeproduk,"produkpostid"=>$produkpostid,"jumlah"=>$jumlah,"harga"=>$harga,"total"=>$total,"xx"=>$xx,"nomer"=>$nomer,"namaprod"=>$namaprod,"ketdiskon"=>$ketdiskon,"hargadiskon"=>$hargadiskon);
		$xx %= 2;
		$xx++;
		$nomer++;
	}
	sql_free_result($hsl);
	
	$tpl->assign("detailid",$transaksiid);
	$tpl->assign("detailflag",$flag);
	$tpl->assign("detailstatuskirim",$statuskirim);
	$tpl->assign("detailtotaldiskon",$totaldiskon);
	$tpl->assign("detailongkoskirim",$ongkoskirim);
	$tpl->assign("detailongkoskirim2",$ongkoskirim2);
	$tpl->assign("detailpengiriman",$pengiriman);
	$tpl->assign("detailtanggalkirim",$tanggalkirim2);
	$tpl->assign("detailnamalengkap",$namalengkap);
	$tpl->assign("detailalamatpengiriman",$alamatpengiriman);
	$tpl->assign("detailservices",$services);
	$tpl->assign("detailnoresi",$noresi);
	$tpl->assign("detailnamatoko",$namatoko);
	$tpl->assign("detailtanggalterima",$tanggalterima);
	$tpl->assign("detailnamapenerimapaket",$namapenerimapaket);
	$tpl->assign("detailnotelppenerimapaket",$notelppenerimapaket);
	$tpl->assign("detailtotaltagihan",$totaltagihan);
	$tpl->assign("detailnamadiskon",$namadiskon);
	$tpl->assign("detailtotal_diskon",$total_diskon);
	$tpl->assign("detailkodevoucher",$kodevoucher);
	$tpl->assign("detailtotal_bayar",$total_bayar);
	$tpl->assign("detailtransaksi",$detailtransaksi);
	
	sql_free_result($hasil);
?>