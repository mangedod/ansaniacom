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
			$mainmenu[] = array("Lihat Transaksi Belanja","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("orderid","OrderID","int","text","$data");
			
			$cari[] = array("alamatpengiriman","Alamat","str","text","$data");
			$cari[] = array("email","Email","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where']." and status='0'";
			$param = $formcari[0]['param'];
			
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
					totaldiskon, totaltagihanafterdiskon, ongkosid, ongkoskirim, noresi, status, statuskirim, flag, create_date from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=2%>Nomor</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=orderid\" title=\"Urutkan\">OrderID</a></th>\n");
			print("<th width=30%>Informasi Pemesan</th>");
			print("<th width=10%>Total</th>");
			print("<th width=10%>Tanggal Pesan</th>");
			print("<th width=10%>Janis Transaksi</th>");
			print("</tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$transaksiid 		= $row['transaksiid'];
				$userid 			= $row['userid'];
				$orderid 			= $row['orderid'];
				$invoiceid 			= $row['invoiceid'];
				$pembayaran 		= $row['pembayaran'];
				$pengiriman 		= $row['pengiriman'];
				$totaltagihan 		= $row['totaltagihan'];
				$namalengkap 		= $row['namalengkap'];
				$alamatpengiriman 	= $row['alamatpengiriman'];
				$email 				= $row['email'];
				$warehouseid 		= $row['warehouseid'];
				$voucherid 			= $row['voucherid'];
				$kodevoucher 		= $row['kodevoucher'];
				$tgl_trans 			= $row['tgl_trans'];
				$alamat11 			= $row['alamat'];
				$kode_voucher 		= $row['kode_voucher'];
				$totaldiskon 		= $row['totaldiskon'];
				$totaltagihanafterdiskon = $row['totaltagihanafterdiskon'];
				$ongkosid 			= $row['ongkosid'];
				$ongkoskirim 		= $row['ongkoskirim'];
				$noresi 			= $row['noresi'];
				$status 			= $row['status'];
				$statuskirim 		= $row['statuskirim'];
				$no_resi 			= $row['no_resi'];
				$flag 				= $row['flag'];
				$tanggaltansaksi	= tanggal($row['create_date']);
				
				if($totaltagihanafterdiskon==0)
					$totaltagihanakhir = $totaltagihan+$ongkoskirim;
				else
					$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
					
				$ongkos_kirim		= "IDR. ". number_format($ongkoskirim,0,".",".");	
				$total_bayar 		= "IDR. ".number_format($totaltagihanakhir,0,".",".");
				$totaltagihan 		= "IDR. ".number_format($totaltagihan,0,".",".");
				$total_diskon 		= "IDR. ".number_format($totaldiskon,0,".",".");
				
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
							else $diskonnya = "IDR. ". number_format($jumlahdiskon,0,".",".");
						sql_free_result($res4);

					sql_free_result($resvid);
				}
				
				if($userid == 0)
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
					$kotaid 		= $data['kotaid'];
					// $kotaid 		= $data['cityname'];
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
				
				if($status=="0") $stat = "Keranjang";
				elseif($status=="1") $stat = "Invoice";
				elseif($status=="2") $stat = "Konfirmasi";
				elseif($status=="3") $stat = "Bayar";
				elseif($status=="4") $stat = "Pengiriman";
				elseif($status=="5") $stat = "Batal";
			
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

				$sql5	= "select kota, service, harga from tbl_ongkos where id='$ongkosid'";
				$res5	= sql($sql5);
				$row5	= sql_fetch_data($res5);
					$kota_tujuan	= $row5['kota'];
					$service		= $row5['service'];
					$hargaongkir	= $row5['harga'];
				sql_free_result($res5);
				
				$userfullname = sql_get_var("select userfullname from tbl_member where userid='$userid'");
				
				if($flag == 1)
					$jenistransaksi = "Upgrade Member";
				else
					$jenistransaksi = "Pembelian Produk";
				
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top><a href=\"$alamat&aksi=detail&transaksiid=$transaksiid&hlm=$hlm\">&nbsp;<b>#$orderid</b></a></td>
					<td  valign=top class=judul>$billingnama<br>$billingalamat<br>$billingemail</td>\n");
				print("<td valign=top class=hitam>$total_bayar</td>\n");
				print("<td valign=top class=hitam>$tanggaltansaksi</td>\n");
				print("<td valign=top class=hitam>$jenistransaksi</td>\n");

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
	
	//Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$transaksiid	= $_GET['transaksiid'];
			
			$sql1	= "select transaksiid, invoiceid, orderid, totaltagihan, pengiriman, pembayaran, userid, namalengkap, alamatpengiriman, warehouseid, voucherid, totaldiskon, 
				totaltagihanafterdiskon, ongkosid, ongkoskirim, status, tipe,email, tanggaltransaksi, batastransfer, flag from $nama_tabel 
				where transaksiid='$transaksiid'";
			$hsl1 = sql($sql1);
			$row1 = sql_fetch_data($hsl1);
			
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
			$flag				= $row1['flag'];
			
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
			
			$urlconfirm = "$fulldomain/cart/confirm/$kodeinvoice";
			
			$services 		= sql_get_var("select service from tbl_ongkos where id='$ongkosid'");
			
			if($flag == 0)
			{
				$sql	= "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat from $nama_tabel1 where transaksiid='$transaksiid'";
				$hsl = sql($sql);
				$i = 1;
				$a = 1;
	
				print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
				print("<tr><th width=2%>Nomor</th>\n");
				print("<th width=33%>Nama Produk</th>\n");
				print("<th width=33%>Qty</th>");
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
						
					$namaprod 		= sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");
					$kodeproduk 		= sql_get_var("select kodeproduk from tbl_product_post where produkpostid='$produkpostid'");
					
					print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
						<td width=10% height=20 valign=top><b>$namaprod</b></td>\n");
					print("<td valign=top class=hitam>$jumlah</td>\n");
					print("<td valign=top class=hitam>$harga</td>\n");
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
				<tr> 
					<td valign="top">Status</td>
					<td align="left">Keranjang</td>
				</tr>
			</table>
            
            <?php 
		}
	}
}

?>