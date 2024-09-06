<?php
	include("../../../setingan/web.config.inc.php");
	
	$kodeinvoice = $_GET['kodeinvoiceid'];
		
	$invoiceid = base64_decode($kodeinvoice);
	
	/*if(!file_exists("$pathfile/pdf/$invoiceid.pdf"))
	{*/
		// ambil data toko
		$tk	= sql_get_var_row("select nama,alamat,telp,gsm from tbl_static where alias='kontak'");
		$namatk		= $tk['nama'];
		$alamattk	= $tk['alamat'];
		$telptk		= $tk['telp'];
		$gsmtk		= $tk['gsm'];
						
		// kueri tabel konfirmasi
		$sql1	= "select transaksiid, invoiceid, orderid, totaltagihan, agen, pembayaran, userid, namalengkap, alamatpengiriman, warehouseid, voucherid, totaldiskon, 
				totaltagihanafterdiskon, ongkosinfo, ongkoskirim,confee, status, tipe,email, tanggaltransaksi, batastransfer, bank_tujuan, pesan, dropship, namapengirim, telppengirim, paymentinfo
				from tbl_transaksi where invoiceid='$invoiceid'";
		$hsl1 = sql($sql1);
		$row1 = sql_fetch_data($hsl1);
		
		$transaksiid             = $row1['transaksiid'];
		$invoiceid               = $row1['invoiceid'];
		$orderid                 = $row1['orderid'];
		$totaltagihan            = $row1['totaltagihan'];
		$pengiriman              = $row1['agen'];
		$pembayaran              = $row1['pembayaran'];
		$userid                  = $row1['userid'];
		$namalengkap             = $row1['namalengkap'];
		$alamatpengiriman        = $row1['alamatpengiriman'];
		$warehouseid             = $row1['warehouseid'];
		$voucherid               = $row1['voucherid'];
		$totaldiskon             = $row1['totaldiskon'];
		$totaltagihanafterdiskon = $row1['totaltagihanafterdiskon'];
		$ongkosinfo              = $row1['ongkosinfo'];
		$ongkoskirim             = $row1['ongkoskirim'];
		$confee                  = $row1['confee'];
		$status                  = $row1['status'];
		$tipe                    = $row1['tipe'];
		$email                   = $row1['email'];
		$tanggaltransaksi        = tanggal($row1['tanggaltransaksi']);
		$datetransfer            = tanggal($row1['batastransfer']);
		$bank_tujuan             = $row1['bank_tujuan'];
		$pesan                   = $row1['pesan'];
		$dropship                = $row1['dropship'];
		$namapengirim            = $row1['namapengirim'];
		$telppengirim            = $row1['telppengirim'];
		$paymentinfo             = $row1['paymentinfo'];

		$dtpayinfo    = json_decode($paymentinfo);
		$kodepaynya   = $dtpayinfo->masked_card;
		$bankpaynya   = $dtpayinfo->bank;
		$virtualacnya = $dtpayinfo->permata_va_number;

		if($pengiriman != "Pickup Point")
		{
			$namaagen	= sql_get_var("select nama from tbl_agen where agenid='$pengiriman'");
			$services	= $ongkosinfo;
			// $services	= sql_get_var("select service from tbl_ongkos where agenid='$pengiriman' and id = '$ongkosid'");
		}
		else
			$warehouse	= sql_get_var("select nama from tbl_warehouse where warehouseid='$warehouseid'");
		
		if($totaltagihanafterdiskon==0)
			$totaltagihanakhir = $totaltagihan+$ongkoskirim;
		else
			$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
			
		if($pembayaran == "COD"){
			$pembayarannya = "Cash On Delivery";
		}
		elseif($pembayaran == "Transfer"){
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
			
		$ongkoskirim2       = "IDR. ". number_format($ongkoskirim,0,".",".");	
		$totaltagihanakhir2 = "IDR. ".number_format($totaltagihanakhir,0,".",".");
		$totaltagihan2      = "IDR. ".number_format($totaltagihan,0,".",".");
		$totaldiskon2       = "IDR. ".number_format($totaldiskon,0,".",".");
		
		if($status=="0") {$statusorder = "ORDER";$warnafont = "#e41b1a";}
		elseif($status=="1") {$statusorder = "BILLED";$warnafont = "#e41b1a";}
		elseif($status=="2") {$statusorder = "CONFIRMED";$warnafont = "#59B210";}
		elseif($status=="3") {$statusorder = "PAID";$warnafont = "#59B210";}
		elseif($status=="4") {$statusorder = "SHIPPING";$warnafont = "#59B210";}
		elseif($status=="5") {$statusorder = "VOID";$warnafont = "#e41b1a";}
		
		// $services 		= sql_get_var("select service from tbl_ongkos where id='$ongkosid'");
			
		sql_free_result($hsl1);
		
		$sql	= "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat from tbl_transaksi_detail 
				where transaksiid='$transaksiid'";
		$hsl 	= sql($sql);
		$xx		= 1;
		$dt_keranjang = array();
		while ($row = sql_fetch_data($hsl))
		{
			$transaksidetailid	= $row['transaksidetailid'];
			$produkpostid 	= $row['produkpostid'];
			$jumlah 		= $row['jumlah'];
			$matauang		= $row['matauang'];
			$harga 			= $row['harga'];
			$totalharga 	= $row['totalharga'];
			$berat	 		= $row['berat'];
			$harga			= "$matauang ". number_format($row['harga'],0,".",".");
			$total			= "$matauang ". number_format($totalharga,0,".",".");

			$dtprodukpos = sql_get_var_row("select title, kodeproduk, misc_harga, misc_diskon, warnaid, sizeid from tbl_product_post where produkpostid='$produkpostid'");
			$namaprod    = $dtprodukpos['title'];
			$kodeproduk  = $dtprodukpos['kodeproduk'];
			$produkid    = sql_get_var("select produkid from tbl_product where kodeproduk='$kodeproduk'");
			$warnaid     = $dtprodukpos['warnaid'];
			$namawarna   = sql_get_var("select nama from tbl_warna where id='$warnaid'");
			$sizeid      = $dtprodukpos['sizeid'];
			$size        = sql_get_var("select nama from tbl_size where sizeid='$sizeid'");
			$diskon      = $dtprodukpos['misc_diskon'];
			$misc_harga  = $dtprodukpos['misc_harga'];
			$harga_asli  = "$matauang.".number_format($misc_harga,0,".",".");
			$hargadiskon = "$matauang.".number_format($diskon,0,".",".");
			
			$dt_keranjang[$transaksidetailid] = array("id"=>$id,"xx"=>$xx,"nama"=>$namaprod,"harga"=>$harga,"totalharga"=>$total,"qty"=>$jumlah,"kodeproduk"=>$kodeproduk,"harga_asli"=>$harga_asli,"ketdiskon"=>$ketdiskon,"hargadiskon"=>$hargadiskon,"namawarna"=>$namawarna,"size"=>$size);
			$xx++;
			
			
		}
		sql_free_result($hsl);
		
		$totberat = sql_get_var(" SELECT SUM(berat) as total_berat from tbl_transaksi_detail where transaksiid='$transaksiid'");
		// kueri kode voucher
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
		$kodevoucher = sql_get_var("select kodevoucher from tbl_voucher_kode where voucherid='$voucherid'");
			
		
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
		}
		
		if(empty($userid) or ($userid=='0'))
			{
				$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userfullname	= $data['nama'];
				$idtamu			= $data['id'];
				$useraddress 	= $data['alamat'];
				$propinsiid		= $data['propid'];
				$kotaid 		= $data['kotaid'];
				$userpostcode 	= $data['kodepos'];
				$email 			= $data['email'];
				$telephone 		= $data['nophone'];
				$userphonegsm 	= $data['nophone'];
			}
			else
			{
				$perintah 	= "SELECT * FROM tbl_member WHERE userid='$userid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userfullname	= $data['userfullname'];
				$userid			= $data['userid'];
				$propinsiid		= $data['propinsiid'];
				$useraddress 	= $data['useraddress'];
				$kotaid 		= $data['kotaid'];
				$userpostcode	= $data['userpostcode'];
				$email 			= $data['useremail'];
				$telephone 		= $data['userphone'];
				$userphonegsm	= $data['userphonegsm'];
			}
			
			//kota
			$kota 		= sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
			
			$billingalamat = "$useraddress<br>$kota<br>$userpostcode<br>Telp. $userphonegsm";
		
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
		
		$urlconfirm = "$fulldomain"."cart/confirm/$kodeinvoice";
		
		include("cetak.invoice.php");
		
		/*header("location: $fulldomain/gambar/pdf/$invoiceid.pdf");
	}
	else
	{
		header("location: $fulldomain/gambar/pdf/$invoiceid.pdf");
	}*/
		
?>