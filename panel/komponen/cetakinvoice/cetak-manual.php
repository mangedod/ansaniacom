<?php
	include("../../../setingan/web.config.inc.php");
	
	$kodeinvoice = $_GET['kodeinvoice'];
		
	$invoiceid = base64_decode($kodeinvoice);
	
	//$update = sql_get_var("update tbl_transaksi_channel set status='1' where invoiceid='$invoiceid'");
	
	/*if(!file_exists("$pathfile/pdf/$invoiceid.pdf"))
	{*/
		// ambil data toko
		$tk	= sql_get_var_row("select nama,alamat,telp,gsm from tbl_static where alias='kontak'");
		$namatk		= $tk['nama'];
		$alamattk	= $tk['alamat'];
		$telptk		= $tk['telp'];
		$gsmtk		= $tk['gsm'];
						
		// kueri tabel konfirmasi
		$sql1	= "select transaksiid, invoiceid, totaltagihan, totalinvoice,namalengkap, alamatpengiriman,ongkoskirim,status,tanggaltransaksi from tbl_transaksi_channel where invoiceid='$invoiceid'";
		$hsl1 = sql($sql1);
		$row1 = sql_fetch_data($hsl1);
		
		$transaksiid             = $row1['transaksiid'];
		$invoiceid               = $row1['invoiceid'];
		$totaltagihan            = $row1['totaltagihan'];
		$namalengkap             = $row1['namalengkap'];
		$alamatpengiriman        = $row1['alamatpengiriman'];
		$ongkoskirim             = $row1['ongkoskirim'];
		$status                  = $row1['status'];
		$tanggaltransaksi        = tanggal($row1['tanggaltransaksi']);
		$totalinvoice            = $row1['totalinvoice'];

		$ongkoskirim2       = "IDR. ". number_format($ongkoskirim,0,".",".");	
		$totaltagihanakhir2 = "IDR. ".number_format($totalinvoice,0,".",".");
		$totaltagihan2      = "IDR. ".number_format($totaltagihan,0,".",".");
		
		sql_free_result($hsl1);
		
		$sql	= "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat from tbl_transaksi_channel_detail 
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
		
		//$totberat = sql_get_var(" SELECT SUM(berat) as total_berat from tbl_transaksi_channel_detail where transaksiid='$transaksiid'");

		include("cetak.invoicem.php");
		
		/*header("location: $fulldomain/gambar/pdf/$invoiceid.pdf");
	}
	else
	{
		header("location: $fulldomain/gambar/pdf/$invoiceid.pdf");
	}*/
		
?>