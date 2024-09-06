<?php 
//Variable halaman ini
$nama_tabel		= "tbl_transaksi";
$nama_tabel1	= "tbl_transaksi_detail";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['gid'])) $gid = $_POST['gid'];
 else $gid = $_GET['gid'];
 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Transaksi","lihat","$alamat&aksi=view");
			// $mainmenu[] = array("Export Excel","excel","$alamat&aksi=exportxls");
			mainaction($mainmenu,$pageparam);
			

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("invoiceid","Invoice","int","text","$data");
			
			$cari[] = array("alamatpengiriman","Alamat","str","text","$data");
			$cari[] = array("email","Email","str","text","$data");
			
			/*$dataselect[] = array("COD","Cash On Delivery");
			$dataselect[] = array("Transfer","Transfer Bank");
			
			$ppayment = "select paymentid,nama from tbl_payment_method where status='1' order by nama asc";
			$hpayment = sql($ppayment);
			while($dpayment=sql_fetch_data($hpayment))
			{
				$dataselect[] = array($dpayment['paymentid'],$dpayment['nama']);						
			}
			$dataselect[] = array("klikbca","BCA KlikPay");
			
			$cari[] = array("pembayaran","Method Pembayaran","select","select",$dataselect);*/
			
			$dataselect1[] = array("Pickup Point","Pickup Point(Diambil Sendiri)");
			
			$sql	= "select agenid, nama from tbl_agen";
			$qry	= sql($sql);
			while($rowq = sql_fetch_data($qry))
			{
				$dataselect1[] = array($rowq['agenid'],$rowq['nama']);
			}
			
			$cari[] = array("pengiriman","Method Pengambilan Barang","select","select",$dataselect1);
			
			$dataselect2[] = array("0","Keranjang");
			$dataselect2[] = array("1","Menunggu Pembayaran");
			$dataselect2[] = array("2","Sudah Konfirmasi");
			$dataselect2[] = array("3","Sudah Dibayar");
			$dataselect2[] = array("4","Pengiriman");
			$dataselect2[] = array("5","Batal");
			
			$cari[] = array("status","Status","select","select",$dataselect2);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			if ((!empty($where)))
			{
				$_SESSION['whereprint']="$where";
			}
			
			if(empty($_SESSION['showfilter']))
			{
				unset($_SESSION['whereprint']);
			}
			
			//Orderring
			$order = getorder("tanggaltransaksi","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select transaksiid, userid, orderid, invoiceid, pembayaran, pengiriman, totaltagihan, namalengkap, alamatpengiriman, email, warehouseid, voucherid, kodevoucher, 
					totaldiskon, totaltagihanafterdiskon, ongkosinfo, ongkoskirim, noresi, status, statuskirim, flag, tanggaltransaksi, resellerid from $nama_tabel  where 1 and status > 0 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th>No</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=invoiceid\" title=\"Urutkan\">Invoice</a></th>\n");
			print("<th width=30%>Informasi Pemesan</th>");
			print("<th width=10%><a href=\"$urlorder&order=totaltagihan\" title=\"Urutkan\">Subtotal</a></th>");
			// print("<th width=10%>Diskon</th>");
			print("<th width=10%>Ongkos Kirim</th>");
			print("<th width=10%><a href=\"$urlorder&order=totaltagihan\" title=\"Urutkan\">Total</a></th>");
			print("<th width=10%><a href=\"$urlorder&order=pembayaran\" title=\"Urutkan\">Pembayaran</a></th>");
			print("<th width=20%><a href=\"$urlorder&order=tanggaltransaksi\" title=\"Urutkan\">Tanggal Pesan</a></th>");
			print("<th width=4%><a href=\"$urlorder&order=status\" title=\"Urutkan\">Status</a></th>");
			print("<th width=4% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$transaksiid             = $row['transaksiid'];
				$userid                  = $row['userid'];
				$orderid                 = $row['orderid'];
				$invoiceid               = $row['invoiceid'];
				$resellerid              = $row['resellerid'];
				$pembayaran              = $row['pembayaran'];
				$pengiriman              = $row['pengiriman'];
				$totaltagihan            = $row['totaltagihan'];
				$namalengkap             = $row['namalengkap'];
				$alamatpengiriman        = $row['alamatpengiriman'];
				$email                   = $row['email'];
				$warehouseid             = $row['warehouseid'];
				$voucherid               = $row['voucherid'];
				$kodevoucher             = $row['kodevoucher'];
				$tgl_trans               = $row['tgl_trans'];
				$alamat11                = $row['alamat'];
				$kode_voucher            = $row['kode_voucher'];
				$totaldiskon             = $row['totaldiskon'];
				$totaltagihanafterdiskon = $row['totaltagihanafterdiskon'];
				$ongkosinfo                = $row['ongkosinfo'];
				$ongkoskirim             = $row['ongkoskirim'];
				$noresi                  = $row['noresi'];
				$status                  = $row['status'];
				$statuskirim             = $row['statuskirim'];
				$no_resi                 = $row['no_resi'];
				$flag                    = $row['flag'];
				$tanggaltransaksi        = tanggal($row['tanggaltransaksi']);
				
				if($totaltagihanafterdiskon==0)
					$totaltagihanakhir = $totaltagihan+$ongkoskirim;
				else
					$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
					
				$ongkos_kirim		= "Rp. ". number_format($ongkoskirim,0,".",".");	
				$total_bayar 		= "Rp. ".number_format($totaltagihanakhir,0,".",".");
				$totaltagihan 		= "Rp. ".number_format($totaltagihan,0,".",".");
				$total_diskon 		= "Rp. ".number_format($totaldiskon,0,".",".");
				
				if(!empty($kodevoucher))
				{
					$cekdis = 1;
					$sqlvid	= "select voucherid from tbl_voucher_kode where kodevoucher='$kodevoucher'";
					$resvid	= sql($sqlvid);
					$rowvid	= sql_fetch_data($resvid);

						$voucherid		= $rowvid['voucherid'];

						$sql4	= "select nama, jenis, jumlah from tbl_voucher where id='$voucherid'";
						$res4	= sql($sql4);
						$row4	= sql_fetch_data($res4);
							$namadiskon		= $row4['nama'];
							$jenisdiskon	= $row4['jenis'];
							$jumlahdiskon	= $row4['jumlah'];
							
							if($jenisdiskon=="persen") $diskonnya = $jumlahdiskon ." %";
							else $diskonnya = "Rp. ". number_format($jumlahdiskon,0,".",".");
						sql_free_result($res4);

					sql_free_result($resvid);
				}
				
				if($userid == 0)
				{
					$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
					$hasil 		= sql($perintah);
					$data 		= sql_fetch_data($hasil);
		
					$userFullName	= $data['nama'];
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
		
					$userFullName	= $data['userfullname'];
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
				
				$billingnama = $userFullName;
				$billingalamat = $billingalamat;
				$billingemail = $email;
				
				/*if($status=="0") $stat = "Cart";
				elseif($status=="1") $stat = "Invoiced";
				elseif($status=="2") $stat = "Confirmed";
				elseif($status=="3") $stat = "Paid";
				elseif($status=="4") $stat = "Shipped";
				elseif($status=="5") $stat = "Expire";
				elseif($status=="6") $stat = "Void";*/
				if($status=="0") $stat = "<label class=\"label label-info\">Cart</label>";
				elseif($status=="1") $stat = "<label class=\"label label-warning\">Invoiced</label>";
				elseif($status=="2") $stat = "<label class=\"label label-success\">Confirmed</label>";
				elseif($status=="3") $stat = "<label class=\"label label-success\">Paid</label>";
				elseif($status=="4") $stat = "<label class=\"label label-info\">Shipped</label>";
				elseif($status=="5") $stat = "<label class=\"label label-danger\">Expire</label>";
				elseif($status=="6") $stat = "<label class=\"label label-danger\">Void</label>";
			
				$perintah 	= "select id,bank,norek from tbl_norek where status='1'";
				$hasil 		= sql($perintah);
				while ($data=sql_fetch_data($hasil)) 
				{
					$idrek		= $data['id'];
					$id_bank	= $data['bank'];
					$norek2		= $data['norek'];
					
					$nama_bank = sql_get_var("select namabank from tbl_bank where bankid='$id_bank'");
					
					$nama = "$nama_bank ($norek2)";
					
					$bank[$idrek] = array("idrek"=>$idrek, "nama"=>$nama, "id_bank"=>$id_bank);
				}
				sql_free_result($hasil);

				$datatransaksi[$transaksiid] = array();
				$sql1	= "select produkpostid, jumlah, harga, totalharga, transaksidetailid,matauang from $nama_tabel1 where transaksiid='$transaksiid'";
				$res1	= sql($sql1);
				$xx		= 1;
				$nomer	= 1;
				while ($row1 = sql_fetch_data($res1))
				{
					$produkpostid	= $row1['produkpostid'];
					$qty			= $row1['jumlah'];
					$matauang		= $row1['matauang'];
					$harga			= "$matauang. ". number_format($row1['harga'],0,".","."). ",-";
					$total			= "$matauang. ". number_format($row1['totalharga'],0,".","."). ",-";
					$transaksidetailid			= $row1['transaksidetailid'];
					
					$sql3	= "select title,kodeproduk from tbl_product_post where produkpostid='$produkpostid'";
					$res3	= sql($sql3);
					$row3	= sql_fetch_data($res3);
						$namabarang	= $row3['title'];
						$kodeproduk	= $row3['kodeproduk'];
					sql_free_result($res3);
					
					$datatransaksi[$transaksiid][$ids] = array("transaksidetailid"=>$transaksidetailid,"kodeproduk"=>$kodeproduk,"produkpostid"=>$produkpostid,"qty"=>$qty,"harga"=>$harga,"total"=>$total,"xx"=>$xx,"nomer"=>$nomer,
													"namabarang"=>$namabarang);
					$nomer++;
					$xx++;
					$xx = $xx%2;
				}
				sql_free_result($res1);

				// Logo
				$logo = sql_get_var("select logo from tbl_konfigurasi limit 1");

				/*$sql5	= "select kota, service, harga from tbl_ongkos where id='$ongkosid'";
				$res5	= sql($sql5);
				$row5	= sql_fetch_data($res5);
					$kota_tujuan	= $row5['kota'];
					$service		= $row5['service'];
					$hargaongkir	= $row5['harga'];
				sql_free_result($res5);*/
				
				$userfullname = sql_get_var("select userfullname from tbl_member where userid='$userid'");
				
				if($flag == 1)
					$jenistransaksi = "Upgrade Member";
				else
					$jenistransaksi = "Pembelian Produk";
				
				
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
				
				$kodeinvoice = base64_encode($invoiceid);

				$resellername = sql_get_var("select userfullname from tbl_member where userid='$resellerid'");
				
				
				print("<tr class=\"row$i\"><td height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top><a href=\"$alamat&aksi=detail&transaksiid=$transaksiid&hlm=$hlm\">&nbsp;<b>$invoiceid</b></a></td>
					<td  valign=top class=judul>$billingnama<br>$billingalamat<br>$billingemail</td>\n");
				print("<td valign=top class=hitam>$totaltagihan</td>\n");
				// print("<td valign=top class=hitam>$total_diskon</td>\n");
				print("<td valign=top class=hitam>$ongkos_kirim</td>\n");
				print("<td valign=top class=hitam>$total_bayar</td>\n");
				print("<td valign=top class=hitam>$pembayarannya</td>\n");
				print("<td valign=top class=hitam>$tanggaltransaksi</td>\n");

				/*if ($status=="4") {

				print("<td valign=top class=hitam><a onclick='return klikid($transaksiid);' id='example-$transaksiid'>$stat</a></td>\n");

				}else{*/

				print("<td valign=top class=hitam>$stat</td>\n");

				//}

				print("<td>");
				
				$acc[] = array("Detail","detail","$alamat&aksi=detail&transaksiid=$transaksiid&hlm=$hlm");
				if ($status=="1") 
				{
					if($pembayaran == "Cash On Delivery")
						$acc[] = array("Verifikasi Lokasi","edit","$alamat&aksi=verifikasi&transaksiid=$transaksiid&hlm=$hlm");
					else
						// $acc[] = array("Konfirmasi","edit","index.php?tab=5&tabsub=9&kanal=konfirmasi&aksi=tambah&transaksiid=$transaksiid&hlm=$hlm");
					$acc[] = array("Batalkan","edit","$alamat&aksi=batal&transaksiid=$transaksiid&hlm=$hlm");
				}
				elseif($status=="2")
				{
					$acc[] = array("Approve Konfirmasi","edit","$alamat&aksi=approve&transaksiid=$transaksiid");
				}
				elseif($status == '3')
				{
					if($flag=="0")
						if($pengiriman != "Pickup Point")
							$acc[] = array("Pengiriman Barang","edit","$alamat&aksi=shipping&transaksiid=$transaksiid");
						else
							$acc[] = array("Barang Telah Diambil","edit","$alamat&aksi=ambil&transaksiid=$transaksiid");
				}
				elseif($status == '4')
				{
					if($flag=="0")
					$acc[] = array("Edit Status Pengiriman","edit","$alamat&aksi=statusshipping&transaksiid=$transaksiid");	
				}
				elseif($status>="5")
				{
					$acc[] = array("Kirim Invoice Kembali","edit","$alamat&aksi=sendinvoice&transaksiid=$transaksiid");
				}
				$acc[] = array("Cetak Invoice","detail","/panel/komponen/cetakinvoice/cetak.php?kodeinvoiceid=$kodeinvoice");
				// $acc[] = array("Cetak DO","detail","/panel/komponen/cetakdo/cetak.php?kodeinvoiceid=$kodeinvoice");
				//$acc[] = array("Hapus","delete","$alamat&aksi=hapus&transaksiid=$transaksiid&hlm=$hlm");
				
								
				cmsaction($acc);
				unset($acc);
				
				print("</td></tr>");
				
				$i %= 2;
				$i++;
				$a++;
				$ord++;
				
			}
			print("</table><br clear='all'>");
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		}  
	} //EndView 
	
		//Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$transaksiid	= $_GET['transaksiid'];
			
			$sql1	= "select transaksiid, invoiceid, orderid, totaltagihan, pengiriman, pembayaran, userid, namalengkap, alamatpengiriman, warehouseid, voucherid, kodevoucher, totaldiskon, 
				totaltagihanafterdiskon, ongkosinfo, agen, confee, ongkoskirim, status, tipe,email, tanggaltransaksi, batastransfer, noresi, flag, statuskirim, tanggalkirim, tanggalterima, 
				namapenerimapaket, notelppenerimapaket, resellerid from $nama_tabel 
				where transaksiid='$transaksiid'";
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
			$services                = $row1['ongkosinfo'];
			$agen                    = $row1['agen'];
			$confee                  = $row1['confee'];
			$ongkoskirim             = $row1['ongkoskirim'];
			$status                  = $row1['status'];
			$statuskirim             = $row1['statuskirim'];
			$tanggalkirim1            = $row1['tanggalkirim'];
			if($tanggalkirim1 != "0000-00-00 00:00:00"){$tanggalkirim = tanggal($tanggalkirim1);}else{$tanggalkirim = "";}
			$tanggalterima           = tanggal($row1['tanggalterima']);
			$namapenerimapaket       = $row1['namapenerimapaket'];
			$notelppenerimapaket     = $row1['notelppenerimapaket'];
			$tipe                    = $row1['tipe'];
			$email                   = $row1['email'];
			$tanggaltransaksi        = tanggal($row1['tanggaltransaksi']);
			$batastransfer           = tanggal($row1['batastransfer']);
			$flag                    = $row1['flag'];
			$noresi                  = $row1['noresi'];
			$resellerid              = $row1['resellerid'];
			
			if($totaltagihanafterdiskon==0)
				$totaltagihanakhir = $totaltagihan+$ongkoskirim;
			else
				$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
				
				
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
			
			$urlconfirm = "$fulldomain"."cart/confirm/$kodeinvoice";
			
			// $services    = sql_get_var("select service from tbl_ongkos where id='$ongkosid'");
			$namatoko       = sql_get_var("select nama from tbl_warehouse where warehouseid='$warehouseid'");
			$namareseller   = sql_get_var("select userfullname from tbl_member where userid='$resellerid'");
			// $landingpage    = sql_get_var("select namadomain from tbl_domain where userid='$resellerid'");
			if($pengiriman != "Pickup Point")
				$pengiriman = sql_get_var("select nama from tbl_agen where agenid='$pengiriman'");
			
			if($flag == 0)
			{
			$sql	= "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat from $nama_tabel1 where transaksiid='$transaksiid'";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<form method=\"post\" name=\"menufrm\" id=\"menufrm\"><table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=2%>Nomor</th>\n");
			print("<th width=33%>Nama Produk</th>\n");
			print("<th width=25%>Deskripsi</th>");
			print("<th width=8%>Qty</th>");
			print("<th width=13%>Harga</th>");
			print("<th width=23%>SubTotal</th></tr></thead>");

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
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top><b>$namaprod</b></td>\n");
				print("<td valign=top class=hitam>Warna : $namawarna <br/>Ukuran : $size</td>\n");
				print("<td valign=top class=hitam>$jumlah</td>\n");
				print("<td valign=top class=hitam>$harga_asli</td>\n");
				print("<td valign=top class=hitam>$total</td>\n");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table>");
			
			}
			
			?>
            <table border="0" class="tabel-cms" width="100%">
            	<?php
				if($flag == "0")
				{
				?>
				<tr>
					<th colspan="2">Informasi Pengiriman</th>
				</tr>
					<?php
                    if($resellerid != "0")
                    {
                    ?>
                <tr> 
					<td valign="top">Reseller</td>
					<td align="left"><?php echo $namareseller." (<a href=\"http://$landingpage\" target=\"_blank\">".$landingpage."</a>)"?></td>
				</tr>
                	<?php
                    }
					?>
                <tr> 
					<td valign="top">Tanggal Pengiriman</td>
					<td align="left"><?php echo  $tanggalkirim?></td>
				</tr>
					<?php
                    if($pengiriman != "Pickup Point")
                    {
                    ?>
                    <tr> 
                        <td width="176">Nama</td>
                        <td width="471">
                        <?php echo $namalengkap?></td>
                    </tr>
                    <tr> 
                        <td width="176">Alamat</td>
                        <td width="471"><?php echo $alamatpengiriman?></td>
                    </tr>
                    <tr> 
                        <td valign="top">Agen Pengiriman</td>
                        <td align="left"><?php echo $pengiriman?></td>
                    </tr>
                    <tr> 
                        <td valign="top">Service</td>
                        <td align="left"><?php echo $services?></td>
                    </tr>
                    <tr> 
                        <td valign="top">No AWB</td>
                        <td align="left"><?php echo $noresi?></td>
                    </tr>
                    <?php
                    }
					else
					{
					?>
                    <tr> 
                        <td width="176">Nama Depo</td>
                        <td width="471">
                        <?php echo $namatoko?></td>
                    </tr>
                    <?php
					}
				}
				?>
                <?php
				if($statuskirim == "2")
				{
				?>
				<tr>
					<th colspan="2">Informasi Penerima Paket</th>
				</tr>
				<tr> 
					<td valign="top">Tanggal Terima Paket</td>
					<td align="left"><?php echo $tanggalterima?></td>
				</tr>
                <tr> 
					<td valign="top">Nama Penerima</td>
					<td align="left"><?php echo $namapenerimapaket?></td>
				</tr>
                <tr> 
                    <td width="176">Telp Penerima</td>
                    <td width="471">
                    <?php echo $notelppenerimapaket?></td>
                </tr>
                    <?php
				}
				?>
                <tr>
					<th colspan="2">Total Pembelian</th>
				</tr>
                <tr> 
					<td valign="top">Subtotal</td>
					<td align="left"><?php echo $totaltagihan?></td>
				</tr>
                <?php if($totaldiskon>0)
					{
				?>
				<tr> 
					<td valign="top">Diskon Voucher</td>
					<td align="left">Diskon <?php echo $namadiskon?> <?php echo $total_diskon?> (<?php echo $kodevoucher?>)</td>
				</tr>
                <?php 
					}
				?>
                <?php if($ongkoskirim!='0')
					{
				?>
				<tr> 
					<td valign="top">Ongkos Kirim</td>
					<td align="left"><?php echo $ongkoskirim2?></td>
				</tr>
                <?php 
					}
				?>
                <tr> 
					<td valign="top">Total</td>
					<td align="left"><?php echo $total_bayar?></td>
				</tr>
			</table>
            
            <?php 
		}
	}
	
	//SaveTambahMenu
	if($aksi=="savebatal")
	{
		
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$transaksiid = $_POST['transaksiid'];
			$invoiceid   = $_POST['invoiceid'];
			$email       = $_POST['email'];
			$nama        = $_POST['nama'];
			$nohp        = $_POST['nohp'];
			$subject     = $_POST['subject'];
			$pesan       = $_POST['lengkap'];
			
			$perintah = "update $nama_tabel set status='6' where transaksiid='$transaksiid'";
			$hasil = sql($perintah);
			if($hasil)
			{  
				$vou = sql_get_var_row("select vouchercodeid, kodevoucher from $nama_tabel where transaksiid='$transaksiid'");
				$vouchercodeid 	= $vou['vouchercodeid'];
				$kodevoucher	= $vou['kodevoucher'];
				
				$perintah = "update tbl_voucher_kode set status='0' where vouchercodeid='$vouchercodeid'";
				$hasil = sql($perintah);
				 
				$userEmail			= "$email"; 
				$userFullName		= "$userFullName"; 
				$headers 			= "From : $owner";
				$subject			= "$title, $subject";
				
				$isi				= nl2br($pesan);
				$sendmail			= sendmail($userFullName,$userEmail,$subject,$isi,$isi);
				
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Pembatalan data Transaksi dengan Invoice $invoiceid",$uri,$ip);
				
				$msg = base64_encode("Transaksi dengan no invoice $invoice berhasil dibatalkan.");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//TambahMenu
	if($aksi=="batal")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$transaksiid 	= $_GET['transaksiid'];
			
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql1	= "select invoiceid,userid,orderid,resellerid from $nama_tabel where transaksiid='$transaksiid'";
			$query1	= sql($sql1);
			$row1	= sql_fetch_data($query1);
			$invoiceid	= $row1['invoiceid'];
			$userid		= $row1['userid'];
			$orderid	= $row1['orderid'];
			$resellerid	= $row1['resellerid'];
			
			if(empty($userid) or ($userid=='0'))
			{
				$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userFullName	= $data['nama'];
				$email 			= $data['email'];
				$userphonegsm 	= $data['nophone'];
			}
			else
			{
				$perintah 	= "SELECT * FROM tbl_member WHERE userid='$userid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userFullName	= $data['userfullname'];
				$email 			= $data['useremail'];
				$userphonegsm	= $data['userphonegsm'];
			}

			if(!empty($resellerid) or ($resellerid!='0'))
			{
				$namadomainnya = sql_get_var("select aliasdomain from tbl_domain where userid='$resellerid'");
				$fulldomainnya = $namadomainnya."/member/daftar";
				/*$ajakan_bergabung_customer = "Dapatkan kesempatan untuk memperoleh berbagai diskon menarik dengan menjadi member di <?php echo $title?>. 
                            Jika Anda belum menjadi member kami bisa melakukan pendaftaran di :<br /><br />
                            
                            ".$fulldomainnya;*/
			}
			else
			{
				$fulldomainnya = $fulldomain."member/daftar";
				$ajakan_bergabung_customer = "";
			}

			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
				function popgid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=group&aksi=popupgid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("gid").value = res.gid;
							document.getElementById("gid_text").value = res.gid_text;
						}
						return false;
				}
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="savebatal">
            <input type="hidden" name="transaksiid" value="<?php echo $transaksiid?>">
            <input type="hidden" name="invoiceid" value="<?php echo $invoiceid?>">
            <input type="hidden" name="email" value="<?php echo $email?>">
            <input type="hidden" name="nama" value="<?php echo $userFullName?>">
            <input type="hidden" name="nohp" value="<?php echo $userphonegsm?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Admin</th>
				</tr>
				<tr> 
					<td width="176">Subject</td>
					<td width="471"><input name="subject" type="text" size="20" value="Transaction Cancellation" id="subject" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td width="176">Pesan</td>
					<td width="471">
                    	<textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" >
                    		Dear <?php echo $userFullName?>,<br /><br />

                            Thank you for your visit on the website <?php echo $title?>.<br /><br />
                            
                            We're sorry, we inform that the transactions you have made
							with the number of the invoice <strong><?php echo $invoiceid ?></strong> transaction cancellation shall be made
							that is because :<br /><br />
                            
                            **type your message here**<br /><br />
                            
                            Thank you for the confidence you shop at <?php echo $title?>. We are pleased to be able to serve you.
							We wish we could go back in time on the other gain trust as Your shopping.
                            <?php echo $ajakan_bergabung_customer?><br /><br />
                            
                            Regards,<br />
                            <?php echo $title?>
                    	</textarea>
                   	</td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Kirim" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	if($aksi=="saveverifikasi")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {

			$invoiceid 		= $_POST['invoiceid'];
			$verifikasi		= $_POST['verifikasi'];
			$no_resi 		= $_POST['no_resi'];
			$nama			= $_POST['nama'];
			$email			= $_POST['email'];
			$userphonegsm 	= $_POST['nohp'];
			$lengkap	 	= $_POST['lengkap'];
			
			if($verifikasi == "kirim")
			{
			
				$transaksidetailid		= $_POST['transaksidetailid'];
	
				foreach ($transaksidetailid as $key => $id) {
					$transaksidetailid  = $_POST["transaksidetailid"][$key];
					$warehouseid        = $_POST["warehouseid"][$key];
					$produkpostid       = $_POST["produkpostid"][$key];
					$qty		        = $_POST["qty"][$key];
					
					$totalstok	= sql_get_var("select totalstok from tbl_product_wh where warehouseid='$warehouseid' and produkpostid='$produkpostid'");
	
					$perintah 	= "update $nama_tabel1 set warehouseid='$warehouseid' where transaksidetailid='$transaksidetailid'";
					$hasil 		= sql($perintah);
					
					if($hasil)
					{
						$perintah 	= "update tbl_product_wh set totalstok=totalstok-'$qty' where warehouseid='$warehouseid' and produkpostid='$produkpostid'";
						$hasil 		= sql($perintah);
						
						$perintah 	= "update tbl_product_total set totalstok=totalstok-'$qty' where produkpostid='$produkpostid'";
						$hasil 		= sql($perintah);
						
						$perintah 	= "update tbl_product_stokonhold set status='1' where invoiceid='$invoiceid' and produkpostid='$produkpostid'";
						$hasil 		= sql($perintah);
					}
					
	
				}
	
	
				$sql	= "select status,namalengkap,alamatpengiriman,email,orderid,agen, userid from $nama_tabel where invoiceid='$invoiceid'";
				$query	= sql($sql);
				while($row = sql_fetch_data($query))
				{
					$statusnya		 = $row['status'];
					$alamatpengiriman= $row['alamatpengiriman'];
					$orderid		 = $row['orderid'];
					$pengiriman		 = $row['agen'];
					$userid		 = $row['userid'];
					
					if($pengiriman != "Pickup Point")
						$pengiriman = sql_get_var("select nama from tbl_agen where agenid='$pengiriman'");
	
					$sql = "update $nama_tabel set status='4', noresi='$no_resi', statuskirim='1'  where invoiceid='$invoiceid'";
					$hsl = sql($sql);
					if($hsl) 
					{
						$linkregister 			= "$fulldomain"."/login/register";
						
						$contentemail	= sql_get_var("select keterangan from tbl_wording where alias='shipping' and jenis = 'email' limit 1");
						$contentemail	= str_replace("[nama]","$nama",$contentemail);
						$contentemail	= str_replace("[invoiceid]","$invoiceid",$contentemail);
						$contentemail	= str_replace("[pengiriman]","$pengiriman",$contentemail);
						$contentemail	= str_replace("[noresi]","$no_resi",$contentemail);
						$contentemail	= str_replace("[alamatpengiriman]","$alamatpengiriman",$contentemail);
						$contentemail	= str_replace("[linkregister]","$linkregister",$contentemail);
						$contentemail	= str_replace("[owner]","$owner",$contentemail);
						$contentemail	= str_replace("[title]","$title",$contentemail);
							
						$pengirim 			= "$owner <$support_email>";
						$webmaster_email 	= "Support <$support_email>"; 
						$userEmail			= "$email"; 
						$userFullName		= "$nama"; 
						$headers 			= "From : $owner";
						$subject			= "$title, Order Completed";
						
						$sendmail			= sendmail_cart($userFullName,$userEmail,$subject,$contentemail,$contentemail,$support_email,$title);
								
						/*$contentsms	= sql_get_var("select keterangan from tbl_wording where alias='shipping' and jenis = 'sms' limit 1");
	
						$contentsms	= str_replace("[owner]","$owner",$contentsms);
						$contentsms	= str_replace("[title]","$title",$contentsms);
						$contentsms	= str_replace("[invoiceid]","$invoiceid",$contentsms);
						$contentsms	= str_replace("[noresi]","$no_resi",$contentsms);
						$contentsms	= str_replace("[namaagen]","$pengiriman",$contentsms);
		
						$sendsms = kirimSMS($userphonegsm,$contentsms);*/
						
						setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan pengiriman barang untuk transaksi dengan metode pembayaran COD dengan Invoice $invoiceid",$uri,$ip);
						
						$msg = base64_encode("Transaksi dengan no invoice $invoice berhasil dilakukan pengiriman.");
								
						header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
					}
				}
			}
			else
			{
				$sql = "update $nama_tabel set status='6'  where invoiceid='$invoiceid'";
					$hsl = sql($sql);
				
				$vou = sql_get_var_row("select vouchercodeid, kodevoucher from $nama_tabel where invoiceid='$invoiceid'");
				$vouchercodeid 	= $vou['vouchercodeid'];
				$kodevoucher	= $vou['kodevoucher'];
				
				$sql = "update $nama_tabel set status='6'  where invoiceid='$invoiceid'";
					$hsl = sql($sql);
				if($hsl)
				{
					$perintah = "update tbl_voucher_kode set status='0' where vouchercodeid='$vouchercodeid'";
					$hasil = sql($perintah);
				}
					
				$userEmail			= "$email"; 
				$userFullName		= "$nama"; 
				$headers 			= "From : $owner";
				$subject			= "$title, The cancellation of the COD payment method";
				
				$isi				= nl2br($lengkap);
				$sendmail			= sendmail($userFullName,$userEmail,$subject,$isi,$isi);
				
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Pembatalan metode pembayaran COD dengan Invoice $invoiceid",$uri,$ip);
				
				$msg = base64_encode("Transaksi dengan no invoice $invoice berhasil dibatalkan.");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
		}
	}
	
	//TambahMenu
	if($aksi=="verifikasi")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$transaksiid 	= $_GET['transaksiid'];
			
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql1             = "select invoiceid,userid,orderid,alamatpengiriman from $nama_tabel where transaksiid='$transaksiid'";
			$query1           = sql($sql1);
			$row1             = sql_fetch_data($query1);
			$invoiceid        = $row1['invoiceid'];
			$userid           = $row1['userid'];
			$orderid          = $row1['orderid'];
			$alamatpengiriman = $row1['alamatpengiriman'];
			$resellerid       = $row1['resellerid'];
			$ex               = explode("<br>",$alamatpengiriman);
			$kota             = $ex[1];
			
			$kodeinvoice = base64_encode($invoiceid);
			
			if(empty($userid) or ($userid=='0'))
			{
				$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userFullName	= $data['nama'];
				$email 			= $data['email'];
				$userphonegsm 	= $data['nophone'];
			}
			else
			{
				$perintah 	= "SELECT * FROM tbl_member WHERE userid='$userid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userFullName	= $data['userfullname'];
				$email 			= $data['useremail'];
				$userphonegsm	= $data['userphonegsm'];
			}

			if($resellerid == '0')
			{
				$aliasdomain               = "$fulldomain/member/daftar";
				$ajakan_bergabung_customer = "";
				$linkubahbayaran           = "";
				$ubahbayaran               = "";
			}
			else
			{
				$idusernya                 = sql_get_var("select userid from tbl_member where userid='$resellerid'");
				$aliasdomain1              = sql_get_var("select aliasdomain from tbl_domain where userid='$idusernya'");
				$aliasdomain               = "$aliasdomain1/member/daftar";
				$ajakan_bergabung_customer = "Dapatkan kesempatan untuk memperoleh berbagai diskon menarik dengan menjadi member di <?php echo $title?>. 
                            Jika Anda belum menjadi member kami bisa melakukan pendaftaran di :<br /><br />
                            
                            ".$aliasdomain;
				$linkubahbayaran           = "$aliasdomain1/cart/pembayaran/$kodeinvoice";
				$ubahbayaran               = "Anda dapat mengubah metode pembayaran dengan mengklik URL dibawah ini:<br /><br />
                            
                            <a href=\"<?php echo $linkubahbayaran?>\">Ubah Metode Bayar</a><br /><br />";
			}

			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
				function tampil(data) {
					if(data=="kirim")
					{
						$(".kirim").show();
						$(".info").hide();
					}
					else if(data=="info")
					{
						$(".kirim").hide();
						$(".info").show();
					}
					else
					{
						$(".kirim").hide();
						$(".info").hide();
					}
				}
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveverifikasi">
            <input type="hidden" name="transaksiid" value="<?php echo $transaksiid?>">
            <input type="hidden" name="invoiceid" value="<?php echo $invoiceid?>">
            <input type="hidden" name="email" value="<?php echo $email?>">
            <input type="hidden" name="nama" value="<?php echo $userFullName?>">
            <input type="hidden" name="nohp" value="<?php echo $userphonegsm?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Verifikasi Lokasi</th>
				</tr>
				<tr> 
					<td width="176">Kota Tujuan</td>
					<td width="471"><?php echo $kota;?></td>
				</tr>
                <tr> 
					<td width="176">Status Verifikasi</td>
					<td width="471">
                    	<select name="verifikasi" onchange="tampil(this.value)">
                        	<option value="">Pilih Status Verifikasi</option>
                        	<option value="kirim">Kirim Barang</option>
                            <option value="info">Kirim Info (Kota yang dituju tidak dicover COD)</option>
                        </select>
                  	</td>
				</tr>
                <tr class="kirim" style="display:none"> 
					<td colspan='2'>
                    <?php
						$sql	= "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat from $nama_tabel1 where transaksiid='$transaksiid' and warehouseid='0'";
						$hsl = sql($sql);
						$i = 1;
						$a = 1;
					
						print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
						print("<tr><th colspan=\"4\">Pengambilan Stok Barang</th></tr>\n");
						print("<tr><th width=2%>Nomor</th>\n");
						print("<th width=33%>Nama Produk</th>\n");
						print("<th width=15%>Qty</th>");
						print("<th width=13%>Gudang/Toko</th></tr></thead>");
			
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
								
							$namaprod 		= sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");
							$kodeproduk 		= sql_get_var("select kodeproduk from tbl_product_post where produkpostid='$produkpostid'");
							
							print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
								<td width=10% height=20 valign=top><b>$namaprod</b></td>\n");
							print("<td valign=top class=hitam>$jumlah</td>\n");
							print("<td valign=top class=hitam><input type=\"hidden\" name=\"transaksidetailid[]\" value=\"$transaksidetailid\" />
									<input type=\"hidden\" name=\"qty[]\" value=\"$jumlah\" />
									<input type=\"hidden\" name=\"produkpostid[]\" value=\"$produkpostid\" />
                					<select name=\"warehouseid[]\" id=\"status\">");
									$ptoko 		= "select warehouseid,nama from tbl_warehouse order by nama asc";
									$htoko 		= sql($ptoko);
									while($dtoko	= sql_fetch_data($htoko))
									{
										$warehouseid = $dtoko['warehouseid'];
										$nama 		 = $dtoko['nama'];
												
										echo "<option value='$warehouseid'>$nama</option>";
									}
									sql_free_result($htoko);
									
							print("</select>
									</td></tr>\n");
			
							$i %= 2;
							$i++;
							$a++;
							$ord++;
						}
						print("</table><br clear='all'><br clear='all'>");
					
                    ?></td>
				</tr>
                <tr class="kirim" style="display:none"> 
					<td width="176">No. Resi / AWB Kurir</td>
					<td width="471">
                    	<input type="text" name="no_resi" size="30" />
                   	</td>
				</tr>
                <tr class="info" style="display:none"> 
					<td width="176">Pesan</td>
					<td width="471">
                    	<textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" >
                    		Dear <?php echo $userFullName?>,<br /><br />

                            Terima kasih untuk kunjungan Anda pada website <?php echo $title?>.<br /><br />
                            
                            Mohon maaf, kami memberitahukan bahwa transaksi yang telah Anda lakukan
                            dengan nomor invoice <strong><?php echo $invoiceid ?></strong> akan dilakukan pembatalan metode
                            pembayaran dengan opsi COD yang disebabkan karena :<br /><br />
                            
                            Kota Tujuan Anda tidak dicover oleh kami. <?php echo $ubahbayaran?>
                            
                            Terimakasih atas kepercayaan Anda berbelanja di <?php echo $title?>. Kami senang dapat melayani Anda.
                            Semoga dilain waktu kami bisa kembali mendapatkan kepercayaan sebagai tempat belanja Anda.
                            <?php echo $ajakan_bergabung_customer?><br /><br />
                            
                            Regards,<br />
                            <?php echo $title?>
                    	</textarea>
                   	</td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Kirim" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	if($aksi=="saveambil")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {

			$transaksiid 	= $_POST['transaksiid'];
			$invoiceid 		= $_POST['invoiceid'];
			$namapenerima	= $_POST['namapenerima'];
			$notelp			= $_POST['notelp'];
			$statuskirim	= $_POST['kirim'];
			
			if($statuskirim == "kirim")
			{
				$sql = "update $nama_tabel set statuskirim='2', namapenerimapaket='$namapenerima', notelppenerimapaket='$notelp', tanggalterima='$date', tanggalkirim='$date'  where invoiceid='$invoiceid'";
				$hsl = sql($sql);
				
				$warehouseid = sql_get_var("select warehouseid from $nama_tabel where transaksiid='$transaksiid'");
				$invoice = sql_get_var("select invoiceid from $nama_tabel where transaksiid='$transaksiid'");
				
				$sql = "select produkpostid, qty from tbl_transaksi_detail where transaksiid='$transaksiid'";
				$qty = sql($sql);
				while($row = sql_fetch_data($qty))
				{
					$produkpostid = $row['produkpostid'];
					$qty = $row['qty'];
					
					$totalstok	= sql_get_var("select totalstok from tbl_product_wh where warehouseid='$warehouseid' and produkpostid='$produkpostid'");
		
					$perintah 	= "update $nama_tabel1 set warehouseid='$warehouseid' where transaksidetailid='$transaksidetailid'";
					$hasil 		= sql($perintah);
					
					if($hasil)
					{
						$perintah 	= "update tbl_product_wh set totalstok=totalstok-'$qty' where warehouseid='$warehouseid' and produkpostid='$produkpostid'";
						$hasil 		= sql($perintah);
						
						$perintah 	= "update tbl_product_total set totalstok=totalstok-'$qty' where produkpostid='$produkpostid'";
						$hasil 		= sql($perintah);
						
						$perintah 	= "update tbl_product_stokonhold set status='1' where invoiceid='$invoiceid' and produkpostid='$produkpostid'";
						$hasil 		= sql($perintah);
					}
				}
				
				$sql = "update $nama_tabel set status='4'  where transaksiid='$transaksiid'";
				$hsl = sql($sql);
				
				if($hsl)
				{
					$msg = base64_encode("Transaksi dengan no invoice $invoice Sudah Diambil");
					header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				}
				else
				{
					$error = base64_encode("Transaksi dengan no invoice $invoice tidak dapat di ambil dan silahkan coba kembali");
					header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
					exit();
				}
			}
			else
			{
				$perintah = "update $nama_tabel set status='6' where transaksiid='$transaksiid'";
				$hasil = sql($perintah);
			
				$subject			= "$title, Transaction Cancellation";
				$userEmail			= "$email"; 
				$userFullName		= "$nama"; 
				$headers 			= "From : $owner";
				
				$isi				= nl2br($lengkap);
				$sendmail			= sendmail($userFullName,$userEmail,$subject,$isi,$isi);
				
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Pembatalan metode pembayaran COD dengan Invoice $invoiceid",$uri,$ip);
				
				$msg = base64_encode("Transaksi dengan no invoice $invoice berhasil dibatalkan.");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
		}
	}
	
	//TambahMenu
	if($aksi=="ambil")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$transaksiid 	= $_GET['transaksiid'];
			$sql1	= "select invoiceid,userid,orderid,warehouseid from $nama_tabel where transaksiid='$transaksiid'";
			$query1	= sql($sql1);
			$row1	= sql_fetch_data($query1);
			$invoiceid	= $row1['invoiceid'];
			$userid		= $row1['userid'];
			$orderid	= $row1['orderid'];
			$warehouseid	= $row1['warehouseid'];
			
			if(empty($userid) or ($userid=='0'))
			{
				$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userFullName	= $data['nama'];
				$email 			= $data['email'];
				$userphonegsm 	= $data['nophone'];
			}
			else
			{
				$perintah 	= "SELECT * FROM tbl_member WHERE userid='$userid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userFullName	= $data['userfullname'];
				$email 			= $data['useremail'];
				$userphonegsm	= $data['userphonegsm'];
			}
			
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
				function tampil(data) {
					if(data=="kirim")
					{
						$(".kirim").show();
						$(".batal").hide();
					}
					else if(data=="batal")
					{
						$(".kirim").hide();
						$(".batal").show();
					}
					else
					{
						$(".kirim").hide();
						$(".batal").hide();
					}
				}
			</script>
			<form method="post" name="menufrm" id="menufrm">
            <input type="hidden" name="aksi" value="saveambil">
            <input type="hidden" name="transaksiid" value="<?php echo $transaksiid?>">
            <input type="hidden" name="invoiceid" value="<?php echo $invoiceid?>">
            <input type="hidden" name="email" value="<?php echo $email?>">
            <input type="hidden" name="nama" value="<?php echo $userFullName?>">
            <input type="hidden" name="nohp" value="<?php echo $userphonegsm?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Pengiriman</th>
				</tr>
                <tr> 
					<td width="176">Status Pengiriman</td>
					<td width="471">
                    	<select name="kirim" onchange="tampil(this.value)">
                        	<option value="">Pilih Status Pengambilan</option>
                        	<option value="kirim">Diambil</option>
                            <option value="batal">Dibatalkan</option>
                        </select>
                   	</td>
				</tr>
                <tr class="kirim" style="display:none"> 
					<td width="176">Nama Penerima</td>
					<td width="471">
                    	<input type="text" name="namapenerima" size="30" class="validate[required]" />
                   	</td>
				</tr>
                <tr class="kirim" style="display:none"> 
					<td width="176">No Telp</td>
					<td width="471">
                    	<input type="text" name="notelp" size="30" />
                   	</td>
				</tr>
                <tr class="batal" style="display:none"> 
					<td width="176">Pesan</td>
					<td width="471">
                    	<textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" >
                    		Dear <?php echo $userFullName?>,<br /><br />

                            Thank you for your visit on the website <?php echo $title?>.<br /><br />
                            
                            We're sorry, we inform that the transactions you have made
							with the number of the invoice <strong><?php echo $invoiceid ?></strong> transaction cancellation shall be made
								that is because :<br /><br />
                            
                            **type your message here**<br /><br />
                            
                            Thank you for the confidence you shop at <?php echo $title?>. We are pleased to be able to serve you.
							We wish we could go back in time on the other gain trust as Your shopping.
							Get the opportunity to earn various attractive discount by becoming a member at <?php echo $title ?>.
								If you are not already a member we can perform registration on :<br /><br />
                            
                            <?php echo $fulldomain?>member/daftar<br /><br />
                            
                            Regards,<br />
                            <?php echo $title?>
                    	</textarea>
                   	</td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Kirim" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveTambahMenu
	if($aksi=="approve")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$transaksiid = $_GET['transaksiid'];
			
			$sql       = "select invoiceid, flag, userid, orderid from $nama_tabel where transaksiid='$transaksiid'";
			$query     = sql($sql);
			$row       = sql_fetch_data($query);
			$invoiceid = $row['invoiceid'];
			$flag      = $row['flag'];
			$userid    = $row['userid'];
			$orderid   = $row['orderid'];

			$sqla	= "update $nama_tabel set status = '3' where transaksiid='$transaksiid'";
			$querya	= sql($sqla);
			
			if($querya)
			{
				if(empty($userid))
				{
					$perintah 	= "SELECT nama,email,nophone FROM tbl_tamu WHERE orderid='$orderid'";
					$hasil 		= sql($perintah);
					$data 		= sql_fetch_data($hasil);
		
					$nama         = $data['nama'];
					$email        = $data['email'];
					$userphonegsm = $data['nophone'];
				}
				else
				{
					$perintah 	= "SELECT userfullname,useremail,userphonegsm FROM tbl_member WHERE userid='$userid'";
					$hasil 		= sql($perintah);
					$data 		= sql_fetch_data($hasil);
		
					$nama         = $data['userfullname'];
					$email        = $data['useremail'];
					$userphonegsm = $data['userphonegsm'];
				}
				if($flag == '1')
				{
					
					$sqla	= "update tbl_member set secid = '2' where userid='$userid'";
					$querya	= sql($sqla);
					
					if($querya)
					{
						$message	= "
							Dear $nama,<br><br />
							
							Terimakasih atas pembayaran deposit yang dilakukan untuk nomor invoice <strong>#$invoiceid</strong><br />
							Kami telah menerima dan melakukan validasi atas pembayaran yang Anda lakukan.<br /><br />
		
							Anda sudah Terdaftar sebagai reseller kami dan berhak mendapatkan harga khusus selama menjadi reseller kami.<br />
		
							Terimakasih atas kepercayaan Anda berbelanja di $title. Kami senang dapat melayani Anda.
							Semoga dilain waktu Kami bisa kembali mendapatkan kepercayaan sebagai tempat belanja Anda.<br /><br />
							
							Regards,<br />
							$owner
						";
						
						//kirim email ke admin
						$to 		= "$email";
						$from 		= "$support_email";
						$subject 	= "$title, Confirmation Of Payment Of The Invoice #$invoice";
						$message 	= $message;
						$headers 	= "From : $owner";
						
						$sendmail	= sendmail($nama,$email,$subject,$message2,$message);
					}
				}
				else
				{
					$contentemail	= sql_get_var("select keterangan from tbl_wording where alias='paid' and jenis = 'email' limit 1");
					$contentemail	= str_replace("[nama]","$nama",$contentemail);
					$contentemail	= str_replace("[invoiceid]","$invoiceid",$contentemail);
					$contentemail	= str_replace("[linkregister]","$linkregister",$contentemail);
					$contentemail	= str_replace("[owner]","$owner",$contentemail);
					$contentemail	= str_replace("[title]","$title",$contentemail);
					
					$subject	= sql_get_var("select subjek from tbl_wording where alias='paid' and jenis = 'email' limit 1");
					$subject	= str_replace("[title]","$title",$subject);
						
						$pengirim 			= "$owner <$support_email>";
						$webmaster_email 	= "Support <$support_email>"; 
						$userEmail			= "$email"; 
						$userFullName		= "$nama"; 
						$headers 			= "From : $owner";
						if(empty($subject))
							$subject			= "$title, We Have Received Confirmation Of Payment";
						
						$sendmail			= sendmail($nama,$email,$subject,$contentemail,$contentemail);
				}
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] menyetujui data Transaksi dengan Invoice #$invoiceid",$uri,$ip);
				$msg = base64_encode("Transaksi dengan no invoice $invoiceid berhasil di approve");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
			}
			else
			{
				$error = base64_encode("Transaksi dengan no invoice $invoiceid tidak dapat di approve dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	if($aksi=="simpanshipping")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$transaksiid  = $_POST['transaksiid'];
			$resellerid   = $_POST['resellerid'];
			$invoiceid    = $_POST['invoiceid'];
			$kirim        = $_POST['kirim'];
			$no_resi      = $_POST['no_resi'];
			$nama         = $_POST['nama'];
			$email        = $_POST['email'];
			$userphonegsm = $_POST['nohp'];
			$lengkap      = $_POST['lengkap'];
			$tanggalkirim = $_POST['tanggalkirim'];
			if(empty($tanggalkirim))
				$tanggalkirim = $date;

			$sql	= "select status,namalengkap,alamatpengiriman,email,orderid,agen, userid from $nama_tabel where invoiceid='$invoiceid'";
			$query	= sql($sql);
			while($row = sql_fetch_data($query))
			{
				$statusnya		 = $row['status'];
				$namapengiriman	 = $row['namalengkap'];
				$alamatpengiriman= $row['alamatpengiriman'];
				$email			 = $row['email'];
				$orderid		 = $row['orderid'];
				$pengiriman		 = $row['agen'];
				$userid		 = $row['userid'];
				
				if($pengiriman != "Pickup Point")
					$pengiriman = sql_get_var("select nama from tbl_agen where agenid='$pengiriman'");
					
				if($userid == 0)
				{
					$perintah 	= "SELECT nama,email,nophone FROM tbl_tamu WHERE orderid='$orderid'";
					$hasil 		= sql($perintah);
					$data 		= sql_fetch_data($hasil);
		
					$nama	= $data['nama'];
					$email 			= $data['email'];
					$userphonegsm 	= $data['nophone'];
				}
				else
				{
					$perintah 	= "SELECT userfullname,useremail,userphonegsm FROM tbl_member WHERE userid='$userid'";
					$hasil 		= sql($perintah);
					$data 		= sql_fetch_data($hasil);
		
					$nama	= $data['userfullname'];
					$email 			= $data['useremail'];
					$userphonegsm	= $data['userphonegsm'];
				}
			}
			
			if($kirim == "kirim")
			{
				$transaksidetailid		= $_POST['transaksidetailid'];
	
				foreach ($transaksidetailid as $key => $id) {
					$transaksidetailid  = $_POST["transaksidetailid"][$key];
					$warehouseid        = $_POST["warehouseid"][$key];
					$produkpostid       = $_POST["produkpostid"][$key];
					$qty		        = $_POST["qty"][$key];
					
					$totalstok	= sql_get_var("select totalstok from tbl_product_wh where warehouseid='$warehouseid' and produkpostid='$produkpostid'");
	
					$perintah 	= "update $nama_tabel1 set warehouseid='$warehouseid' where transaksidetailid='$transaksidetailid'";
					$hasil 		= sql($perintah);
					
					if($hasil)
					{
						$perintah 	= "update tbl_product_wh set totalstok=totalstok-'$qty' where warehouseid='$warehouseid' and produkpostid='$produkpostid'";
						$hasil 		= sql($perintah);
						
						$perintah 	= "update tbl_product_total set totalstok=totalstok-'$qty' where produkpostid='$produkpostid'";
						$hasil 		= sql($perintah);
						
						$perintah 	= "update tbl_product_stokonhold set status='1' where invoiceid='$invoiceid' and produkpostid='$produkpostid'";
						$hasil 		= sql($perintah);
					}
					
	
				}
	
				$sql = "update $nama_tabel set status='4', noresi='$no_resi', statuskirim='1', tanggalkirim='$date'  where invoiceid='$invoiceid'";
				$hsl = sql($sql);
				if($hsl) 
				{
						if($resellerid == '0')
						{
							$linkregister = "$fulldomain"."member/daftar";
						}
						else
						{
							$idusernya    = sql_get_var("select userid from tbl_member where userid='$resellerid'");
							$aliasdomain1 = sql_get_var("select aliasdomain from tbl_domain where userid='$idusernya'");
							$linkregister  = "$aliasdomain1"."member/daftar";
						}
						
						$contentemail	= sql_get_var("select keterangan from tbl_wording where alias='shipping' and jenis = 'email' limit 1");
						$contentemail	= str_replace("[nama]","$nama",$contentemail);
						$contentemail	= str_replace("[invoiceid]","$invoiceid",$contentemail);
						$contentemail	= str_replace("[pengiriman]","$pengiriman",$contentemail);
						$contentemail	= str_replace("[noresi]","$no_resi",$contentemail);
						$contentemail	= str_replace("[alamatpengiriman]","$alamatpengiriman",$contentemail);
						$contentemail	= str_replace("[linkregister]","$linkregister",$contentemail);
						$contentemail	= str_replace("[owner]","$owner",$contentemail);
						$contentemail	= str_replace("[title]","$title",$contentemail);
			
							
							$pengirim 			= "$owner <$support_email>";
							$webmaster_email 	= "Support <$support_email>"; 
							$userEmail			= "$email"; 
							$userFullName		= "$nama"; 
							$headers 			= "From : $owner";
							$subject			= "$title, Order Completed";
							
							$sendmail			= sendmail($userFullName,$userEmail,$subject,$contentemail,$contentemail);
							
					/*$contentsms	= sql_get_var("select keterangan from tbl_wording where alias='shipping' and jenis = 'sms' limit 1");

					$contentsms	= str_replace("[owner]","$owner",$contentsms);
					$contentsms	= str_replace("[title]","$title",$contentsms);
					$contentsms	= str_replace("[invoiceid]","$invoiceid",$contentsms);
					$contentsms	= str_replace("[noresi]","$no_resi",$contentsms);
					$contentsms	= str_replace("[namaagen]","$pengiriman",$contentsms);
	
					$sendsms = kirimSMS($userphonegsm,$contentsms);*/
					
					$msg = base64_encode("Transaksi dengan no invoice $invoiceid berhasil dikirim.");		
					// header("location: $fulldomain/$cms/$aksi/$subaksi/order/$userid");
						header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				}
			}
			else
			{
				/*$vou = sql_get_var_row("select vouchercodeid, kodevoucher from $nama_tabel where transaksiid='$transaksiid'");
				$vouchercodeid 	= $vou['vouchercodeid'];
				$kodevoucher	= $vou['kodevoucher'];*/
				
				$perintah = "update $nama_tabel set status='6' where transaksiid='$transaksiid'";
				$hasil = sql($perintah);
				/*if($hasil)
				{
					$perintah = "update tbl_voucher_kode set status='0' where vouchercodeid='$vouchercodeid'";
					$hasil = sql($perintah);
				}*/
			
				$subject			= "$title, Transaction Cancellation";
				$userEmail			= "$email"; 
				$userFullName		= "$nama"; 
				$headers 			= "From : $owner";
				
				$isi				= nl2br($lengkap);
				$sendmail			= sendmail($userFullName,$userEmail,$subject,$isi,$isi);
				
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Pembatalan metode pembayaran COD dengan Invoice $invoiceid",$uri,$ip);
				
				$msg = base64_encode("Transaksi dengan no invoice $invoiceid berhasil dibatalkan.");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
		}
	}
	
	//TambahMenu
	if($aksi=="shipping")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$transaksiid      = $_GET['transaksiid'];
			$sql1             = "select invoiceid,userid,orderid,alamatpengiriman, ongkoskirim,resellerid from $nama_tabel where transaksiid='$transaksiid'";
			$query1           = sql($sql1);
			$row1             = sql_fetch_data($query1);
			$invoiceid        = $row1['invoiceid'];
			$userid           = $row1['userid'];
			$orderid          = $row1['orderid'];
			$alamatpengiriman = $row1['alamatpengiriman'];
			$ongkoskirim      = $row1['ongkoskirim'];
			$resellerid       = $row1['resellerid'];
			$ex               = explode("<br>",$alamatpengiriman);
			$kota             = $ex[1];
			
			$kodeinvoice = base64_encode($invoiceid);
			
			if(empty($userid) or ($userid=='0'))
			{
				$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userFullName	= $data['nama'];
				$email 			= $data['email'];
				$userphonegsm 	= $data['nophone'];
			}
			else
			{
				$perintah 	= "SELECT * FROM tbl_member WHERE userid='$userid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userFullName	= $data['userfullname'];
				$email 			= $data['useremail'];
				$userphonegsm	= $data['userphonegsm'];
			}

			if($resellerid == '0')
			{
				$aliasdomain = "$fulldomain"."member/daftar";
				$ajakan_bergabung_customer = "";
			}
			else
			{
				/*$idusernya    = sql_get_var("select userid from tbl_member where userid='$resellerid'");
				$aliasdomain1 = sql_get_var("select aliasdomain from tbl_domain where userid='$idusernya'");
				$aliasdomain  = "$aliasdomain1"."member/daftar";
				$ajakan_bergabung_customer = "Dapatkan kesempatan untuk memperoleh berbagai diskon menarik dengan menjadi member di <?php echo $title?>. 
                            Jika Anda belum menjadi member kami bisa melakukan pendaftaran di :<br /><br />
                            
                            ".$aliasdomain;*/
			}
			
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
				function tampil(data) {
					if(data=="kirim")
					{ 
						$(".kirim").show();
						$(".batal").hide();
					}
					else if(data=="batal")
					{
						$(".kirim").hide();
						$(".batal").show();
					}
					else
					{
						$(".kirim").hide();
						$(".batal").hide();
					}
				}
			</script>
			<form method="post" name="menufrm" id="menufrm">
            <input type="hidden" name="aksi" value="simpanshipping">
            <input type="hidden" name="transaksiid" value="<?php echo $transaksiid?>">
            <input type="hidden" name="invoiceid" value="<?php echo $invoiceid?>">
            <input type="hidden" name="email" value="<?php echo $email?>">
            <input type="hidden" name="nama" value="<?php echo $userFullName?>">
            <input type="hidden" name="nohp" value="<?php echo $userphonegsm?>">
            <input type="hidden" name="resellerid" value="<?php echo $resellerid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Pengiriman</th>
				</tr>
                <tr> 
					<td width="176">Status Pengiriman</td>
					<td width="471">
                    	<select name="kirim" onchange="tampil(this.value)">
                        	<option value="">Pilih Status Pengiriman</option>
                        	<option value="kirim">Dikirim</option>
                            <option value="batal">Dibatalkan</option>
                        </select>
                   	</td>
				</tr>
				<tr class="kirim" style="display:none"> 
					<td colspan='2'>
                    <?php
						$sql	= "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat,warehouseid from $nama_tabel1 where transaksiid='$transaksiid'";// and warehouseid='0'
						$hsl = sql($sql);
						$i = 1;
						$a = 1;
					
						print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
						print("<tr><th colspan=\"4\">Pengambilan Stok Barang</th></tr>\n");
						print("<tr><th width=2%>Nomor</th>\n");
						print("<th width=33%>Nama Produk</th>\n");
						print("<th width=15%>Qty</th>");
						print("<th width=13%>Gudang/Toko</th></tr></thead>");
			
						while ($row = sql_fetch_data($hsl))
						{
							$transaksidetailid = $row['transaksidetailid'];
							$produkpostid      = $row['produkpostid'];
							$jumlah            = $row['jumlah'];
							$matauang          = $row['matauang'];
							$harga             = $row['harga'];
							$totalharga        = $row['totalharga'];
							$berat             = $row['berat'];
							$warehouseid1      = $row['warehouseid'];
							$harga             = "$matauang ". number_format($row['harga'],0,".",".");
							$total             = "$matauang ". number_format($totalharga,0,".",".");
								
							$namaprod 		= sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");
							$kodeproduk 		= sql_get_var("select kodeproduk from tbl_product_post where produkpostid='$produkpostid'");
							
							print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
								<td width=10% height=20 valign=top><b>$namaprod</b></td>\n");
							print("<td valign=top class=hitam>$jumlah</td>\n");
							print("<td valign=top class=hitam><input type=\"hidden\" name=\"transaksidetailid[]\" value=\"$transaksidetailid\" />
									<input type=\"hidden\" name=\"qty[]\" value=\"$jumlah\" />
									<input type=\"hidden\" name=\"produkpostid[]\" value=\"$produkpostid\" />
                					<select name=\"warehouseid[]\" id=\"status\">");
									$ptoko 		= "select warehouseid,nama from tbl_warehouse where warehouseid='$warehouseid1' order by nama asc";
									$htoko 		= sql($ptoko);
									while($dtoko	= sql_fetch_data($htoko))
									{
										$warehouseid = $dtoko['warehouseid'];
										$nama 		 = $dtoko['nama'];
												
										echo "<option value='$warehouseid'>$nama</option>";
									}
									sql_free_result($htoko);
									
							print("</select>
									</td></tr>\n");
			
							$i %= 2;
							$i++;
							$a++;
							$ord++;
						}
						print("</table><br clear='all'><br clear='all'>");
					
                    ?></td>
				</tr>
                <tr class="kirim" style="display:none"> 
					<td width="176">No. Resi / AWB Kurir</td>
					<td width="471">
                    	<input type="text" name="no_resi" size="30" <?php if($ongkoskirim!='0')echo 'class="validate[required]"'?> />
                   	</td>
				</tr>
                <tr class="batal" style="display:none"> 
					<td width="176">Pesan</td>
					<td width="471">
                    	<textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" >
                    		Dear <?php echo $userFullName?>,<br /><br />

                            Thank you for your visit on the website <?php echo $title?>.<br /><br />
                            
                           We're sorry, we inform that the transactions you have made
							with the number of the invoice <strong><?php echo $invoiceid ?></strong> transaction cancellation shall be made
							that is because :<br /><br />
	                            
                            **type your message here**<br /><br />
                            
                            Thank you for the confidence you shop at <?php echo $title?>. We are pleased to be able to serve you.
							We wish we could go back in time on the other gain trust as Your shopping.
                            <?php echo $ajakan_bergabung_customer?><br /><br />
                            
                            Regards,<br />
                            <?php echo $title?>
                    	</textarea>
                   	</td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Kirim" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	if($aksi=="sendinvoice")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$transaksiid			= $_GET['transaksiid'];
			
			$tipe 	= sql_get_var("SELECT tipe FROM tbl_transaksi WHERE transaksiid='$transaksiid'");
			
			if($tipe==0)
				$tipeid = 2;
			else
				$tipeid = 1;
			
			// $jedatransfer 	= sql_get_var("SELECT nama FROM tbl_jeda_pembayaran WHERE tipeid='$tipeid'");
			$jedatransfer 	= sql_get_var("SELECT jedapembayaran FROM tbl_konfigurasi WHERE webid='$webid'");
			
			$tanggal		= date("Y-m-d H:i:s");
			
			$date = new datetime($tanggal);
			$date->add(new DateInterval('PT'.$jedatransfer.'H'));
			$datetransfer = $date->format('Y-m-d H:i:s');
			
			$perintah 	= "update tbl_transaksi set tanggaltransaksi='$tanggal', batastransfer='$datetransfer', status='1'  where transaksiid='$transaksiid'";
			//		 die($perintah);
			$hasil 		= sql($perintah);
			if ($hasil)
			{ 
				// ambil data toko
				$sq	= sql("select nama,alamat,telp,gsm from tbl_static where alias='kontak' limit 1");
				$tk = sql_fetch_data($sq);
				$namatk		= $tk['nama'];
				$alamattk	= $tk['alamat'];
				$telptk		= $tk['telp'];
				$gsmtk		= $tk['gsm'];
				
				// kueri tabel Transaksi
				$sql1	= "select transaksiid, invoiceid, orderid, totaltagihan, agen, pembayaran, userid, namalengkap, alamatpengiriman, warehouseid, voucherid, totaldiskon, 
						totaltagihanafterdiskon, ongkosinfo, ongkoskirim, status, tipe,email, tanggaltransaksi, batastransfer, bank_tujuan, pesan, namapengirim, telppengirim, dropship, paymentinfo
						 from tbl_transaksi where transaksiid='$transaksiid'";
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
				$services                = $row1['ongkosinfo'];
				$ongkoskirim             = $row1['ongkoskirim'];
				$status                  = $row1['status'];
				$tipe                    = $row1['tipe'];
				$email                   = $row1['email'];
				$tanggaltransaksi        = tanggal($row1['tanggaltransaksi']);
				$batastransfer           = tanggal($row1['batastransfer']);
				$bank_tujuan             = $row1['bank_tujuan'];
				$pesan                   = $row1['pesan'];
				$namapengirim            = $row1['namapengirim'];
				$telppengirim            = $row1['telppengirim'];
				$dropship                = $row1['dropship'];
				$paymentinfo             = $row1['paymentinfo'];

				$dtpayinfo    = json_decode($paymentinfo);
				$kodepaynya   = $dtpayinfo->masked_card;
				$bankpaynya   = $dtpayinfo->bank;
				$virtualacnya = $dtpayinfo->permata_va_number;
				
				if($totaltagihanafterdiskon==0)
					$totaltagihanakhir = $totaltagihan+$ongkoskirim;
				else
					$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
					
				$total_bayar 		= $totaltagihanakhir;
						
				// $services 		= sql_get_var("select service from tbl_ongkos where id='$ongkosid'");
				
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
						
				$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
				$hsl = sql($sql);
				$dt_keranjang = array();
				$i = 1;
				$a = 1;
				while ($row = sql_fetch_data($hsl))
				{
					$tarnsaksidetailid = $row['tarnsaksidetailid'];
					$produkpostid      = $row['produkpostid'];
					$qty               = $row['jumlah'];
					$berat             = $row['berat'];
					$harga             = "$matauang. ". number_format($row['harga'],"0",".",".");
					$matauang          = $row['matauang'];
					$total             = "$matauang. ". number_format($row['totalharga'],"0",".",".");

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
					
					$perintahst 	= "insert into tbl_product_stokonhold (`invoiceid`, `produkpostid`, `jumlah`, `tipe`) values ('$invoiceid', '$produkpostid', '$qty', '$tipeid')";
					$hasilst 		= sql($perintahst);

					$i %= 2;
					$i++;
					$a++;
					
					$berattotal	.= $berattotal+$row['berat'];
					
					$dt_keranjang[$tarnsaksidetailid] = array("id"=>$tarnsaksidetailid,"nama"=>$namaprod,"kodeproduk"=>$kodeproduk,"berat"=>$berat,"totalharga"=>$total,"qty"=>$qty,"namawarna"=>$namawarna,"size"=>$size);
				}
				

				$ongkoskirim2	= "$matauang. ". number_format($ongkoskirim,0,".",".");
					
				//tampilkan diskon voucher
				$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, totaltagihan from tbl_transaksi where transaksiid='$transaksiid'");
				$rowv                    = sql_fetch_data($qryv);
				$voucherid               = $rowv['voucherid'];
				$totaldiskon             = $rowv['totaldiskon'];
				$totaltagihanafterdiskon = $rowv['totaltagihanafterdiskon'];
				$totaltagihan            = $rowv['totaltagihan'];
				
				$kodevoucher = sql_get_var("select kodevoucher from tbl_voucher_kode where voucherid='$voucherid'");
				
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
					
				if($pembayaran == 'Transfer')
				{
					$perintah = "select * from tbl_norek where status='1' and id = '$bank_tujuan'";
					$hasil = sql($perintah);
					$rekening = array();
					while ($data=sql_fetch_data($hasil)) 
					{
						$id			= $data['id'];
						$id_bank	= $data['bankid'];
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
						
				$kodeinvoice = base64_encode($invoiceid);

				$statusorder = "BILLED";
				
				$warnafont = "#e41b1a";

				/*if($userid == '0')
				{
					$urlconfirm       = "$fulldomain";
					$contactname      = "Support ".$title;
					$contactuseremail = $support_email;
				}
				else
				{
*/					$qrysres          = sql("select userfullname,useremail,userid from tbl_member where userid='$userid'");
					$rowsres          = sql_fetch_data($qrysres);
					$contactname      = $rowsres['userfullname'];
					$contactuseremail = $rowsres['useremail'];
					$idusernya        = $rowsres['userid'];
					// $aliasdomain1     = sql_get_var("select aliasdomain from tbl_domain where userid='$idusernya'");
					$urlconfirm       = "$fulldomain"."cart/confirm/$kodeinvoice";
				// }
				include("invoice.pdf.php");

				$pengirim 			= "$owner <$support_email>";
				$webmaster_email 	= "Support <$support_email>"; 
				$userEmail			= "$email"; 
				$userFullName		= "$userfullname"; 
				$headers 			= "From : $owner";
				$subject			= "$title, Invoice #invoiceid";
				
				$sendmail			= sendmail($userFullName,$userEmail,$subject,$html,$html,1);
					
				//kirim email ke admin
				$to 		= "$support_email";
				$from 		= "$support_email";
				$subject 	= "Booking Information No Invoice $invoiceid - $title";
				$message 	= $message;
				$headers 	= "From : $owner";
				
				$sendmail	= sendmail($title,$to,$subject,$html,$html,1);
						
					//kirim email ke reseller
					$tores    = "$support_email";
					$fromres  = "$support_email";
					$headers  = "From : $owner";
					$subject3 = "Booking Information No Invoice $invoiceid - $title";
					
					$sendmail	= sendmail($contactname,$contactuseremail,$subject3,$html,$html,1);
				
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Perubahan Status Pengiriman data Transaksi dengan Invoice $invoice",$uri,$ip);
				
				$msg = base64_encode("Berhasil mengirim data dengan ID $invoice");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dikirim dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	if($aksi=="simpanstatusshipping")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {

			$invoiceid 		= $_POST['invoiceid'];
			$namapenerima	= $_POST['namapenerima'];
			$notelp			= $_POST['notelp'];
			$statuskirim	= $_POST['statuskirim'];

			$sql = "update $nama_tabel set statuskirim='$statuskirim', namapenerimapaket='$namapenerima', notelppenerimapaket='$notelp', tanggalterima='$date'  where invoiceid='$invoiceid'";
			$hsl = sql($sql);
			if($hsl) 
			{
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
			}
		}
	}
	
	//TambahMenu
	if($aksi=="statusshipping")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$transaksiid         = $_GET['transaksiid'];
			$sql1                = "select invoiceid,statuskirim,namapenerimapaket,notelppenerimapaket from $nama_tabel where transaksiid='$transaksiid'";
			$query1              = sql($sql1);
			$row1                = sql_fetch_data($query1);
			$invoiceid           = $row1['invoiceid'];
			$statuskirim         = $row1['statuskirim'];
			$namapenerimapaket   = $row1['namapenerimapaket'];
			$notelppenerimapaket = $row1['notelppenerimapaket'];
			
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
				function popgid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=group&aksi=popupgid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("gid").value = res.gid;
							document.getElementById("gid_text").value = res.gid_text;
						}
						return false;
				}
			</script>
			<form method="post" name="menufrm" id="menufrm">
            <input type="hidden" name="aksi" value="simpanstatusshipping">
            <input type="hidden" name="invoiceid" value="<?php echo $invoiceid?>" />
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Pengiriman</th>
				</tr>
                <tr> 
					<td width="176">Status Pengiriman</td>
					<td width="471">
                    	<input type="radio" name="statuskirim" value="2" class="validate[required]" <?php if($statuskirim=='2') echo "checked"?> /> Sudah Diterima
                   	</td>
				</tr>
                <tr> 
					<td width="176">Nama Penerima</td>
					<td width="471">
                    	<input type="text" name="namapenerima" size="30" value="<?php echo $namapenerimapaket?>" class="validate[required]" />
                   	</td>
				</tr>
                <tr> 
					<td width="176">No Telp</td>
					<td width="471">
                    	<input type="text" name="notelp" size="30" value="<?php echo $notelppenerimapaket?>" />
                   	</td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Kirim" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	if($aksi=="simpannoresi")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$transaksiid		= $_POST['transaksiid'];
			$invoiceid 		= $_POST['invoiceid'];
			$no_resi 		= $_POST['noresi'];

			$sql	= "select status,namalengkap,alamatpengiriman,email,orderid,pengiriman, userid from $nama_tabel where invoiceid='$invoiceid'";
			$query	= sql($sql);
			while($row = sql_fetch_data($query))
			{
				$statusnya		 = $row['status'];
				$namapengiriman	 = $row['namalengkap'];
				$alamatpengiriman= $row['alamatpengiriman'];
				$orderid		 = $row['orderid'];
				$pengiriman		 = $row['pengiriman'];
				$userid		 = $row['userid'];
				
				if($pengiriman != "Pickup Point")
					$pengiriman = sql_get_var("select nama from tbl_agen where agenid='$pengiriman'");
					
				if($userid == 0)
				{
					$perintah 	= "SELECT nama,email,nophone FROM tbl_tamu WHERE orderid='$orderid'";
					$hasil 		= sql($perintah);
					$data 		= sql_fetch_data($hasil);
		
					$nama	= $data['nama'];
					$email 			= $data['email'];
					$userphonegsm 	= $data['nophone'];
				}
				else
				{
					$perintah 	= "SELECT userfullname,useremail,userphonegsm FROM tbl_member WHERE userid='$userid'";
					$hasil 		= sql($perintah);
					$data 		= sql_fetch_data($hasil);
		
					$nama	= $data['userfullname'];
					$email 			= $data['useremail'];
					$userphonegsm	= $data['userphonegsm'];
				}
			}
			
	
			$sql = "update $nama_tabel set noresi='$no_resi'  where invoiceid='$invoiceid'";
			$hsl = sql($sql);
			if($hsl) 
			{
				
					$linkregister 			= "$fulldomain"."login/register";
					
					$contentemail	= sql_get_var("select keterangan from tbl_wording where alias='shipping' and jenis = 'email' limit 1");
					$contentemail	= str_replace("[nama]","$nama",$contentemail);
					$contentemail	= str_replace("[invoiceid]","$invoiceid",$contentemail);
					$contentemail	= str_replace("[pengiriman]","$pengiriman",$contentemail);
					$contentemail	= str_replace("[noresi]","$no_resi",$contentemail);
					$contentemail	= str_replace("[alamatpengiriman]","$alamatpengiriman",$contentemail);
					$contentemail	= str_replace("[linkregister]","$linkregister",$contentemail);
					$contentemail	= str_replace("[owner]","$owner",$contentemail);
					$contentemail	= str_replace("[title]","$title",$contentemail);
		
						
						$pengirim 			= "$owner <$support_email>";
						$webmaster_email 	= "Support <$support_email>"; 
						$userEmail			= "$email"; 
						$userFullName		= "$nama"; 
						$headers 			= "From : $owner";
						$subject			= "$title, Update No Resi";
						
						$sendmail			= sendmail($userFullName,$userEmail,$subject,$contentemail,$contentemail);
						
				/*$contentsms	= sql_get_var("select keterangan from tbl_wording where alias='shipping' and jenis = 'sms' limit 1");

				$contentsms	= str_replace("[owner]","$owner",$contentsms);
				$contentsms	= str_replace("[title]","$title",$contentsms);
				$contentsms	= str_replace("[invoiceid]","$invoiceid",$contentsms);
				$contentsms	= str_replace("[noresi]","$no_resi",$contentsms);
				$contentsms	= str_replace("[namaagen]","$pengiriman",$contentsms);

				$sendsms = kirimSMS($userphonegsm,$contentsms);*/
						
				// header("location: $fulldomain/$cms/$aksi/$subaksi/order/$userid");
					header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
			}
		}
	}
	
	//TambahMenu
	if($aksi=="editnoresi")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$transaksiid 	= $_GET['transaksiid'];
			$sql1	= "select invoiceid,noresi from $nama_tabel where transaksiid='$transaksiid'";
			$query1	= sql($sql1);
			$row1	= sql_fetch_data($query1);
			$invoiceid	= $row1['invoiceid'];
			$noresi		= $row1['noresi'];
			
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
				function popgid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=group&aksi=popupgid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("gid").value = res.gid;
							document.getElementById("gid_text").value = res.gid_text;
						}
						return false;
				}
			</script>
			<form method="post" name="menufrm" id="menufrm">
            <input type="hidden" name="aksi" value="simpannoresi">
            <input type="hidden" name="invoiceid" value="<?php echo $invoiceid?>" />
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Pengiriman</th>
				</tr>
                <tr> 
					<td width="176">No Resi</td>
					<td width="471">
                    	<input type="text" name="noresi" size="30" value="<?php echo $noresi?>" class="validate[required]" />
                   	</td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Kirim" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}

	elseif(($aksi=="exportxls"))
	{
		if(!$oto['view']) { echo $error['view']; } else
		{

			/** Error reporting */


			/** PHPExcel */
			require_once "$lokasiweb/librari/Classes/PHPExcel.php";

			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();

			// Set properties
			$objPHPExcel->getProperties()->setCreator("Klik4It")
										 ->setLastModifiedBy("Klik4It")
										 ->setTitle("Office 2007 XLSX Kartu Stok")
										 ->setSubject("Office 2007 XLSX Kartu Stok")
										 ->setDescription("Transaksi for Office 2007 XLSX, generated using PHP classes.")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Test result file");

			// Create a sheet
			$objPHPExcel->setActiveSheetIndex(0);


			//border
			$styleThinBlackBorderOutline = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),),),);

			$isijudul	= array("A1"=>"Invoice","B1"=>"No Order","C1"=>"Subtotal","D1"=>"Diskon","E1"=>"Ongkos Kirim","F1"=>"Total","G1"=>"Informasi Penagihan","H1"=>"Metode Pembayaran",
						"I1"=>"Alamat Pengiriman","J1"=>"Metode Pengiriman","K1"=>"Item","L1"=>"Status","M1"=>"Tanggal Transaksi");
			foreach($isijudul as $col=>$isi)
			{
				$objPHPExcel->getActiveSheet()->getCell("$col")->setValue("$isi");
			}

			

			$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray(array('borders' => array('allborders'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
			$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray(array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,)));
			// Set thin black border outline around column
			$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($styleThinBlackBorderOutline);

			//width column
			$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth("25");
			$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth("25");
			$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth("25");
			$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth("25");
			$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth("25");
			$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth("25");
			$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth("50");
			$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth("40");
			$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth("50");
			$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth("25");
			$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setWidth("70");
			$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setWidth("25");
			$objPHPExcel->getActiveSheet()->getColumnDimension("M")->setWidth("25");
			
			if (!empty($_SESSION['whereprint']))
			{
				$where=$_SESSION['whereprint'];	
			}

			$sql1 = "select * from $nama_tabel where 1 $where order by tanggaltransaksi desc";

			$kartustok = array();
			$sumall        = 0;
			$hsl1           = sql($sql1);

			$i = 2;
			$a = 1;

			while ($row1 = sql_fetch_data($hsl1))
			{
				$transaksiid		= $row1['transaksiid'];
				$invoiceid			= $row1['invoiceid'];
				$orderid			= $row1['orderid'];
				$totaltagihan		= $row1['totaltagihan'];
				$pengiriman			= $row1['pengiriman'];
				$pembayaran			= $row1['pembayaran'];
				$userid				= $row1['userid'];
				$namalengkap		= $row1['namalengkap'];
				$alamatpengiriman	= $row1['alamatpengiriman'];
				$warehouseid		= $row1['warehouseid'];
				$voucherid			= $row1['voucherid'];
				$totaldiskon		= $row1['totaldiskon'];
				$totaltagihanafterdiskon	= $row1['totaltagihanafterdiskon'];
				$ongkosid			= $row1['ongkosid'];
				$ongkoskirim		= $row1['ongkoskirim'];
				$status				= $row1['status'];
				$tipe				= $row1['tipe'];
				$email				= $row1['email'];
				$tanggaltransaksi	= tanggal($row1['tanggaltransaksi']);
				$batastransfer		= tanggal($row1['batastransfer']);
				$bank_tujuan		= $row1['bank_tujuan'];
				$pesan				= $row1['pesan'];
				$namapengirim		= $row1['namapengirim'];
				$telppengirim		= $row1['telppengirim'];
				$dropship			= $row1['dropship'];
				$code				= $row1['code'];
				
				if($pengiriman != "Pickup Point")
				{
					$namaagen	= sql_get_var("select nama from tbl_agen where agenid='$pengiriman'");
					$services	= sql_get_var("select service from tbl_ongkos where agenid='$pengiriman' and id = '$ongkosid'");
					$pengiriman = "$namaagen - $services";
				}
				else
					$warehouse	= sql_get_var("select nama from tbl_warehouse where warehouseid='$warehouseid'");
				
				if($totaltagihanafterdiskon==0)
					$totaltagihanakhir = $totaltagihan+$ongkoskirim;
				else
					$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
					
				if($pembayaran == "COD")
					$pembayaran = "Cash On Delivery";
				elseif($pembayaran == "Transfer")
					$pembayaran = "Transfer Bank";
				elseif($pembayaran == "klikbca")
				{
					if(!empty($code))
					{
					
						$pembayaran = "BCA KlikPay (CreditCard)\r\nAppcode: $code";
					}
					else
					{
					
						$pembayaran = "BCA KlikPay (Debit)";
					}
				}
				else
					$pembayaran = sql_get_var("select nama from tbl_payment_method where paymentid='$pembayaran'");		
					
				$ongkoskirim2		= "Rp. ". number_format($ongkoskirim,0,".",".");	
				$total_bayar 		= "Rp. ".number_format($totaltagihanakhir,0,".",".");
				$totaltagihan 		= "Rp. ".number_format($totaltagihan,0,".",".");
				$total_diskon 		= "Rp. ".number_format($totaldiskon,0,".",".");
				
				if($status=="0") $stat = "Belanja";
				elseif($status=="1") $stat = "Invoice Telah Dikirimkan. Menunggu Konfirmasi Pembayaran.";
				elseif($status=="2") $stat = "Konfirmasi pembayaran telah diterima. Menunggu Approve dari Administrator";
				elseif($status=="3") $stat = "Pembayaran sudah diterima. Pesanan akan segera diproses";
				elseif($status=="4") $stat = "Pesanan sudah dikirim.";
				elseif($status=="5") $stat = "Pesanan telah dibatalkan.";
				$services 		= sql_get_var("select service from tbl_ongkos where id='$ongkosid'");
					
				
				$sql	= "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat from tbl_transaksi_detail 
						where transaksiid='$transaksiid'";
				$hsl 	= sql($sql);
				$xx		= 1;
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
						
					$namaprod 		= sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");
					$kodeproduk 		= sql_get_var("select kodeproduk from tbl_product_post where produkpostid='$produkpostid'");
					
					$ketbarang		.= "$xx. $namaprod($kodeproduk) / jumlah : $jumlah / Harga : $harga / Total : $total\r\n";
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
						else $diskonnya = "Rp ". number_format($jumlahdiskon,0,".",".");
					sql_free_result($res4);
				}
					
				
				// kueri bank
				if($pembayaran == 'Transfer Bank')
				{
					$perintah = "select * from tbl_norek where status='1' and id = '$bank_tujuan'";
					$hasil = sql($perintah);
					$rekening = array();
					while ($data=sql_fetch_data($hasil)) 
					{
						$id			= $data['id'];
						$id_bank	= $data['bankid'];
						$norek		= $data['norek'];
						$atasnama	= $data['atasnama'];
						
						$sql8	= "select namabank from tbl_bank where bankid='$id_bank'";
						$res8	= sql($sql8);
						$row8	= sql_fetch_data($res8);
						$logo	= $row8['logobank'];
						$bank	= $row8['namabank'];
				
						$rekening = "$bank - $norek - $atasnama";
					
					}
				}
				
				if(empty($userid) or ($userid=='0'))
				{
					$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
					$hasil 		= sql($perintah);
					$data 		= sql_fetch_data($hasil);
		
					$userFullName	= $data['nama'];
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
		
					$userFullName	= $data['userfullname'];
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
				
				$billinginformasi = "$userFullName";
				if(!empty($useraddress)) $billinginformasi .= "\r\n$useraddress";
				if(!empty($kota)) $billinginformasi .= "\r\n$kota";
				if(!empty($userpostcode)) $billinginformasi .= "\r\n$userpostcode";
				$billinginformasi .= "\r\nTelp. $userphonegsm\r\n$email";

				$isidata	= array("A$i"=>$invoiceid,"B$i"=>$orderid,"C$i"=>$totaltagihan,"D$i"=>$total_diskon,"E$i"=>$ongkoskirim2,"F$i"=>$total_bayar,"G$i"=>$billinginformasi,
							"H$i"=>$pembayaran."\r\n$rekening","I$i"=>"$namalengkap\r\n$alamatpengiriman","J$i"=>$pengiriman,"K$i"=>$ketbarang,"L$i"=>$stat,"M$i"=>$tanggaltransaksi);

				foreach($isidata as $col=>$isi)
				{
					$objPHPExcel->getActiveSheet()->getCell("$col")->setValue("$isi");
				}

				$objPHPExcel->getActiveSheet()->getStyle("A$i:M$i")->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle("A$i:M$i")->applyFromArray($styleThinBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle("A$i:M$i")->applyFromArray(array('borders' => array('allborders'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
				$objPHPExcel->getActiveSheet()->getStyle("A$i:M$i")->applyFromArray(array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,)));


				/*$isiborder	= array("A","B","C","D","E","F");
				foreach($isiborder as $kolom)
				{
					if($kolom == "A" or $kolom == "F")
						$objPHPExcel->getActiveSheet()->getStyle("$kolom$i")->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),'borders' => array('left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
					else
						$objPHPExcel->getActiveSheet()->getStyle("$kolom$i")->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),'borders' => array('left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
				}*/

				$a++;
				$i++;
			}


			sql_free_result($hsl1);
			//die();

			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle("Transaksi");

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			/** PHPExcel_IOFactory */
			require_once "$lokasiweb/librari/Classes/PHPExcel/IOFactory.php";

			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header("Content-Disposition: attachment;filename=\"Transaksi-$tglname.xlsx\"");
			header('Cache-Control: max-age=0');

			$tglname = date("U");

			// Save Excel 2007 file
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("$lokasiweb/lapexcel/Transaksi-$tglname.xlsx");

			$link1	= "$fulldomain/lapexcel/Transaksi-$tglname.xlsx";
			header("location: ".$link1);

			exit;
		}
	}

}

?>