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
			$mainmenu[] = array("Lihat Laporan","lihat","$alamat&aksi=view");
			// $mainmenu[] = array("Export Excel","lihat","$alamat&aksi=exportxls");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("tanggaltransaksi","Tanggal","date","date","$data");
			// $cari[] = array("tanggaltransaksi","Tanggal","daterange","daterange","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where']." and  (status='3' or status='4')";
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("tanggaltransaksi","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			if(!empty($param))
			{
				$pr		= explode("&tanggaltransaksi=",$param);
				$pr1	= $pr[1];	
				
				$_SESSION['tanggaltransaksi'] = $pr1;
			}
			else
				unset($_SESSION['tanggaltransaksi']);			
						
			$tot = sql_get_var("select count(*) as jml from $nama_tabel where 1 $where $parorder");
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select invoiceid, transaksiid, totaltagihan, 
					totaldiskon, totaltagihanafterdiskon, ongkoskirim, status, statuskirim, flag, tanggaltransaksi from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";//ongkosid, 
			// echo $sql;
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=20%>Invoice</th>\n");
			print("<th width=35%>Item Barang</th>\n");
			print("<th width=20%>Tanggal Transaksi</th>");
			print("<th width=20%>Total</th>");
			print("</tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$transaksiid 		= $row['transaksiid'];
				$invoiceid 			= $row['invoiceid'];
				$totaltagihan 		= $row['totaltagihan'];
				$totaldiskon 		= $row['totaldiskon'];
				$totaltagihanafterdiskon = $row['totaltagihanafterdiskon'];
				$ongkosid 			= $row['ongkosid'];
				$ongkoskirim 		= $row['ongkoskirim'];
				$status 			= $row['status'];
				$statuskirim 		= $row['statuskirim'];
				$no_resi 			= $row['no_resi'];
				$flag 				= $row['flag'];
				$tanggaltansaksi	= tanggal($row['tanggaltransaksi']);
				
				if($totaltagihanafterdiskon==0)
					$totaltagihanakhir = $totaltagihan+$ongkoskirim;
				else
					$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
					
				$ongkos_kirim		= "Rp. ". number_format($ongkoskirim,0,".",".");	
				$total_bayar 		= "Rp. ".number_format($totaltagihanakhir,0,".",".");
				$totaltagihan 		= "Rp. ".number_format($totaltagihan,0,".",".");
				$total_diskon 		= "Rp. ".number_format($totaldiskon,0,".",".");
				
				$namabarang = "";
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
						$namabarang[]	.= $row3['title'];
					sql_free_result($res3);
					
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
					$itemproduk = "Upgrade Member";
				else
					$itemproduk = implode("<br>",$namabarang);
				
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top><a href=\"$alamat&aksi=detail&transaksiid=$transaksiid&hlm=$hlm\">&nbsp;<b>$invoiceid</b></a></td>
					<td width=10% height=20 valign=top>$itemproduk</td>\n");
				print("<td valign=top class=hitam>$tanggaltansaksi</td>\n");
				print("<td align=right class=hitam>$total_bayar</td>\n");

				
				print("</tr>");
				
				$i %= 2;
				$i++;
				$a++;
				$ord++;
				
			}
			print("</table><br clear='all'>");
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		}  
	} //EndView 
	
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$transaksiid	= $_GET['transaksiid'];
			
			$sql1	= "select transaksiid, invoiceid, orderid, totaltagihan, pengiriman, pembayaran, userid, namalengkap, alamatpengiriman, warehouseid, voucherid, kodevoucher, totaldiskon,  confee, 
				totaltagihanafterdiskon, ongkoskirim, ongkosinfo, status, tipe,email, tanggaltransaksi, batastransfer, noresi, flag from $nama_tabel 
				where transaksiid='$transaksiid'";
			$hsl1 = sql($sql1);
			$row1 = sql_fetch_data($hsl1);
			
			$transaksiid             = $row1['transaksiid'];
			$invoiceid               = $row1['invoiceid'];
			$orderid                 = $row1['orderid'];
			$confee                  = $row1['confee'];
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
			$ongkoskirim             = $row1['ongkoskirim'];
			$status                  = $row1['status'];
			$tipe                    = $row1['tipe'];
			$email                   = $row1['email'];
			$tanggaltransaksi        = tanggal($row1['tanggaltransaksi']);
			$batastransfer           = tanggal($row1['batastransfer']);
			$flag                    = $row1['flag'];
			$noresi                  = $row1['noresi'];
			
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
			
			// $services 		= sql_get_var("select service from tbl_ongkos where id='$ongkosid'");
			$namatoko 		= sql_get_var("select nama from tbl_warehouse where warehouseid='$warehouseid'");
			if($pengiriman != "Pickup Point")
				$pengiriman = sql_get_var("select nama from tbl_agen where agenid='$pengiriman'");
			
			if($flag == 0)
			{
			$sql	= "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat from $nama_tabel1 where transaksiid='$transaksiid'";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=2%>Nomor</th>\n");
			print("<th width=33%>Nama Produk</th>\n");
			print("<th width=25%>Deskripsi</th>");
			print("<th width=8%>Qty</th>");
			print("<th width=13%>Harga</th>");
			print("<th width=23%>SubTotal</th></tr></thead>");

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
			print("</table><br clear='all'><br clear='all'>");
			
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
				<tr> 
					<td valign="top">Jenis Pengiriman</td>
					<td align="left"><?php echo $pengiriman?></td>
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
                <tr>
					<th colspan="2">Total Pembelian</th>
				</tr>
                <tr> 
					<td valign="top">Subtotal</td>
					<td align="left"><?php echo $totaltagihan?></td>
				</tr>
                <?php if($confee!='0')
					{
				?>
				<tr> 
					<td valign="top">Convenience Fee</td>
					<td align="left"><?php echo $confee?></td>
				</tr>
                <?php 
					}
				?>
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
	
	elseif(($aksi=="exportxls"))
	{
		if(!$oto['view']) { echo $error['view']; } else
		{

			if($_POST['tanggaltransaksi'])
			{
				$tanggaltransaksi	= $_POST['tanggaltransaksi'];
				if(!$_SESSION['tanggaltransaksi']) 
					$_SESSION['tanggaltransaksi'] = $tanggaltransaksi;
				else
					$_SESSION['tanggaltransaksi'] = $tanggaltransaksi;
			}
			
			if($_GET['tanggaltransaksi'])
			{
				$tanggaltransaksi	= $_GET['tanggaltransaksi'];
				if(!$_SESSION['tanggaltransaksi']) 
					$_SESSION['tanggaltransaksi'] = $tanggaltransaksi;
				else
					$_SESSION['tanggaltransaksi'] = $tanggaltransaksi;
			}


			if(!empty($_SESSION['tanggaltransaksi']))
				$tanggaltransaksi = $_SESSION['tanggaltransaksi'];
			
			if(!empty($tanggaltransaksi))
			{
				$temp = explode("|",$tanggaltransaksi);
				$tgl1 = $temp[0];
				$tgl2 = $temp[1];
				
				$where .= " and (date(tanggaltransaksi) >= '$tgl1' and date(tanggaltransaksi) <= '$tgl2')";
				
				if($tgl1 == $tgl2)
					$periode = tanggalvalid($tgl1);
				else
					$periode = tanggalvalid($tgl1)." sampai ".tanggalvalid($tgl2);
			}
			else
			{
				unset($_SESSION['tanggaltransaksi']);
				$periode = "Semua Transaksi";
			}
				
			$tot = sql_get_var("select count(*) as jml from tbl_transaksi where (status='3' or status='4') $where");
			//echo "select count(*) as jml from tbl_transaksi where 1 $where  and (status='3' or status='4')"; die();
			
			/** Error reporting */
			
			
			/** PHPExcel */
			require_once "$lokasiweb/librari/Classes/PHPExcel.php";
			
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			
			// Set properties
			$objPHPExcel->getProperties()->setCreator("Klik4It")
										 ->setLastModifiedBy("Klik4It")
										 ->setTitle("Office 2007 XLSX Report Transaksi")
										 ->setSubject("Office 2007 XLSX Report Transaksi")
										 ->setDescription("Report Transaksi for Office 2007 XLSX, generated using PHP classes.")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Test result file");
					
			// Create a sheet
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objPHPExcel->getActiveSheet()->setCellValue("A1", "Transaksi Periode $periode");
			$objPHPExcel->getActiveSheet()->mergeCells("A1:F1");
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize("14");
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			
			// sheet 2
			$objPHPExcel->getActiveSheet()->setCellValue("A2", "$tanggalnya");
			$objPHPExcel->getActiveSheet()->mergeCells("A2:F2");
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize("12");
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle("A2:F2")->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			
			//border
			$styleThinBlackBorderOutline = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),),),);
			
			$isijudul	= array("A4"=>"Total Transaksi : $tot","A6"=>"No","B6"=>"Tanggal","C6"=>"Invoice","D6"=>"Billing Information","E6"=>"Item Barang","F6"=>"Shipping Information",
							"G6"=>"Metode Pengiriman","H6"=>"Metode Pembayaran","I6"=>"Sub Total");
			foreach($isijudul as $col=>$isi)
			{
				$objPHPExcel->getActiveSheet()->getCell("$col")->setValue("$isi");
				$objPHPExcel->getActiveSheet()->getStyle("$col")->applyFromArray(array('borders' => array('left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
			}
			$objPHPExcel->getActiveSheet()->mergeCells("A4:C4");
			$objPHPExcel->getActiveSheet()->getStyle("A4:I6")->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle("A6:I6")->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$objPHPExcel->getActiveSheet()->getStyle("A6:I6")->applyFromArray(array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,)));
			// Set thin black border outline around column
			$objPHPExcel->getActiveSheet()->getStyle("A6:I6")->applyFromArray($styleThinBlackBorderOutline);
			
			//width column
			$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth("5");
			$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth("25");
			$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth("25");
			$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth("30");
			$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth("30");
			$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth("30");
			$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth("30");
			$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth("30");
			$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth("20");
			
			$sql 	= "select transaksiid, invoiceid, orderid, totaltagihan, pengiriman, pembayaran, userid, namalengkap, alamatpengiriman, warehouseid, voucherid, totaldiskon, 
				totaltagihanafterdiskon, ongkosid, ongkoskirim, status, tipe,email, tanggaltransaksi, batastransfer,flag from tbl_transaksi where 1 $where and (status='3' or status='4') 
				order by tanggaltransaksi asc";
			$query 	= sql($sql);
			$i 	= 7;
			$no = 1;
			while ($row = sql_fetch_data($query))
			{
				$transaksiid		= $row['transaksiid'];
				$invoiceid			= $row['invoiceid'];
				$orderid			= $row['orderid'];
				$totaltagihan		= $row['totaltagihan'];
				$pengiriman			= $row['pengiriman'];
				$pembayaran			= $row['pembayaran'];
				$userid				= $row['userid'];
				$namalengkap		= $row['namalengkap'];
				$alamatpengiriman	= $row['alamatpengiriman'];
				$warehouseid		= $row['warehouseid'];
				$voucherid			= $row['voucherid'];
				$totaldiskon		= $row['totaldiskon'];
				$totaltagihanafterdiskon	= $row['totaltagihanafterdiskon'];
				$ongkosid			= $row['ongkosid'];
				$ongkoskirim		= $row['ongkoskirim'];
				$status				= $row['status'];
				$tipe				= $row['tipe'];
				$email				= $row['email'];
				$flag				= $row['flag'];
				$tanggaltransaksi	= tanggalsimple($row['tanggaltransaksi']);
				$batastransfer		= tanggalsimple($row['batastransfer']);
				
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
					
				if($pembayaran != "COD" and $pembayaran != "Transfer" and $pembayaran != "klikbca")
					$pembayaran = sql_get_var("select nama from tbl_payment_method where paymentid='$pembayaran'");			
					
				$ongkoskirim2		= "IDR. ". number_format($ongkoskirim,0,".",".");	
				$total_bayar 		= "IDR. ".number_format($totaltagihanakhir,0,".",".");
				$totaltagihan 		= "IDR. ".number_format($totaltagihan,0,".",".");
				$total_diskon 		= "IDR. ".number_format($totaldiskon,0,".",".");
				
				if($status=="3") $stat = "Pembayaran sudah diterima. Pesanan akan segera diproses";
				elseif($status=="4") $stat = "Pesanan sudah dikirim.";
				
				$kodeinvoice = base64_encode($invoiceid);
				
				$urlconfirm = "$fulldomain/cart/confirm/$kodeinvoice";
				$urldownload = "$fulldomain/cart/download/$kodeinvoice";
				
				$services 		= sql_get_var("select service from tbl_ongkos where id='$ongkosid'");
					
				sql_free_result($hsl1);
				
				$sql	= "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat from tbl_transaksi_detail 
						where transaksiid='$transaksiid'";
				$hsl 	= sql($sql);
				$xx		= 1;
				$namaprod = "";
				$detailproduk = array();
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
						
					$namaprod[] 		.= sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");
					$kodeproduk 		= sql_get_var("select kodeproduk from tbl_product_post where produkpostid='$produkpostid'");
					
					
					
					//$detailproduk[$transaksidetailid] = array("id"=>$id,"xx"=>$xx,"namaprod"=>$namaprod,"harga"=>$harga,"total"=>$total,"qty"=>$jumlah,"kodeproduk"=>$kodeproduk);
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
					
				
				// kueri bank
				if($pembayaran == 'Transfer')
				{
					$perintah = "select * from tbl_norek where status='1'";
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
					$kotaid 		= $data['cityname'];
					$userpostcode	= $data['userpostcode'];
					$email 			= $data['useremail'];
					$telephone 		= $data['userphone'];
					$userphonegsm	= $data['userphonegsm'];
				}
				
				//kota
				$kota 		= sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
				
				$billingalamat = "$useraddress, $kota, $userpostcode, Telp. $userphonegsm";
				
				if($flag == 1)
					$itemproduk = "Upgrade Member";
				else
					$itemproduk = implode(", ",$namaprod);
				
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
				
				$isidata	= array("A$i"=>$no,
									"B$i"=>$tanggaltransaksi,
									"C$i"=>"$invoiceid",
									"D$i"=>"$userFullName\r\n$billingalamat",
									"E$i"=>"$itemproduk",
									"F$i"=>"$namalengkap\r\n$alamatpengiriman",
									"G$i"=>"$pengiriman",
									"H$i"=>"$pembayaran",
									"I$i"=>"$total_bayar");
				
				foreach($isidata as $col=>$isi)
				{
					$objPHPExcel->getActiveSheet()->getCell("$col")->setValue("$isi");
					$objPHPExcel->getActiveSheet()->getStyle("$col")->getAlignment()->setWrapText(true);
				}
				$objPHPExcel->getActiveSheet()->getStyle("A$i:I$i")->applyFromArray($styleThinBlackBorderOutline);

				
				$isiborder	= array("A","B","C","D","E","F","G","H","I");
				foreach($isiborder as $kolom)
				{
					if($kolom == "A" or $kolom == "F")
						$objPHPExcel->getActiveSheet()->getStyle("$kolom$i")->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),'borders' => array('left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
					else
						$objPHPExcel->getActiveSheet()->getStyle("$kolom$i")->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),'borders' => array('left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
				}
				
				$i++;
				$no++;
			}
			sql_free_result($query);
			
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle("Transaksi $bul $tahun");
			
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
				
			/** PHPExcel_IOFactory */
			require_once "$lokasiweb/librari/Classes/PHPExcel/IOFactory.php";
			$tgln	= date("U");
			
			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header("Content-Disposition: attachment;filename=\"trans-$tgln.xlsx\"");
			header('Cache-Control: max-age=0');
			
			// Save Excel 2007 file
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("$lokasiweb/lapexcel/trans-$tgln.xlsx");
			
			$link1	= "$fulldomain/lapexcel/trans-$tgln.xlsx";
			header("location: ".$link1);	
			
			exit;
		}
	}
}

?>