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
			$mainmenu[] = array("Lihat Transaksi Paid","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("invoiceid","Invoice","int","text","$data");
			
			$cari[] = array("alamatpengiriman","Alamat","str","text","$data");
			$cari[] = array("email","Email","str","text","$data");
			
			$dataselect[] = array("COD","COD");
			$dataselect[] = array("Transfer","Transfer Manual");
			
			$ppayment = "select paymentid,nama from tbl_payment_method where status='1' order by nama asc";
			$hpayment = sql($ppayment);
			while($dpayment=sql_fetch_data($hpayment))
			{
				$dataselect[] = array($dpayment['paymentid'],$dpayment['nama']);						
			}
			
			$cari[] = array("pembayaran","Method Pembayaran","select","select",$dataselect);
			
			$dataselect1[] = array("Pickup Point","Pickup Point(Diambil Sendiri)");
			
			$sql	= "select agenid, nama from tbl_agen";
			$qry	= sql($sql);
			while($rowq = sql_fetch_data($qry))
			{
				$dataselect1[] = array($rowq['agenid'],$rowq['nama']);
			}
			
			$cari[] = array("pengiriman","Method Pengambilan Barang","select","select",$dataselect1);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where']." and status='3'";
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
			print("<th width=20%><a href=\"$urlorder&order=invoiceid\" title=\"Urutkan\">Invoice</a></th>\n");
			print("<th width=30%>Informasi Pemesan</th>");
			print("<th width=10%>Total</th>");
			print("<th width=10%>Tanggal Pesan</th>");
			print("<th width=10%>Janis Transaksi</th>");
			print("<th width=4% align=center><b>Action</b></th></tr></thead>");

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
				elseif($status=="3") $stat = "Lunas";
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
					
				$kodeinvoice = base64_encode($invoiceid);
				
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top><a href=\"/panel/komponen/cetakinvoice/cetak.php?kodeinvoiceid=$kodeinvoice\" target=\"_blank\" >&nbsp;<b>#$invoiceid</b></a></td>
					<td  valign=top class=judul>$billingnama<br>$billingalamat<br>$billingemail</td>\n");
				print("<td valign=top class=hitam>$total_bayar</td>\n");
				print("<td valign=top class=hitam>$tanggaltansaksi</td>\n");
				print("<td valign=top class=hitam>$jenistransaksi</td>\n");

				print("<td>");
				
				$acc[] = array("Detail","detail","$alamat&aksi=detail&transaksiid=$transaksiid&hlm=$hlm");
				if($flag=="0")
					if($pengiriman != "Pickup Point")
						$acc[] = array("Pengiriman Barang","edit","$alamat&aksi=shipping&transaksiid=$transaksiid");
				$acc[] = array("Cetak Invoice","detail","/panel/komponen/cetakinvoice/cetak.php?kodeinvoiceid=$kodeinvoice");
				// $acc[] = array("Cetak DO","detail","/panel/komponen/cetakdo/cetak.php?kodeinvoiceid=$kodeinvoice");
				
								
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
			
			$sql1	= "select transaksiid, invoiceid, orderid, totaltagihan, pengiriman, pembayaran, userid, namalengkap, alamatpengiriman, warehouseid, voucherid, totaldiskon, 
				totaltagihanafterdiskon, ongkosid, ongkoskirim, status, tipe,email, tanggaltransaksi, batastransfer, flag, bank_tujuan from $nama_tabel 
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
			$totaldiskon             = $row1['totaldiskon'];
			$totaltagihanafterdiskon = $row1['totaltagihanafterdiskon'];
			$ongkosid                = $row1['ongkosid'];
			$ongkoskirim             = $row1['ongkoskirim'];
			$status                  = $row1['status'];
			$tipe                    = $row1['tipe'];
			$email                   = $row1['email'];
			$tanggaltransaksi        = tanggal($row1['tanggaltransaksi']);
			$batastransfer           = tanggal($row1['batastransfer']);
			$flag                    = $row1['flag'];
			$bank_tujuan             = $row1['bank_tujuan'];
			
			if($pembayaran != "COD" and $pembayaran != "Transfer" and $pembayaran != "klikbca")
			$pembayaran = sql_get_var("select nama from tbl_payment_method where paymentid='$pembayaran'");	

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
                <?php if($totaldiskon!='0')
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
            	<tbody align="top">
                    <tr>
                        <th colspan="2">Informasi Pembayaran</th>
                    </tr>
                </tbody>

                <tbody align="top">
                    <tr>
                        <td colspan="2" scope="row" class="sub_spec">
                          Pembayaran dilakukan secara <strong><?php echo $pembayaran?></strong><br />
                            <?php if($pembayaran=='Transfer')
								{
							?>
                                Untuk menyelesaikan pembayaran transaksi ini, silahkan transfer ke : <br />
                                <ol>
                                <?php foreach($rekening as $a)
								{
								?>
                                <li><?php echo $a['bank']." (".$a['akun']. "a.n ".$a['namaak'].")" ?></li>
                                <?php
								}
								?>
                                </ol>
                            <?php
							}
							?>
                        </td>
                    </tr>
                </tbody>
			</table>
            
            <?php 
		}
	}
	if($aksi=="simpanshipping")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$transaksiid		= $_POST['transaksiid'];
			$invoiceid 		= $_POST['invoiceid'];
			$kirim 			= $_POST['kirim'];
			$no_resi 		= $_POST['no_resi'];
			$nama			= $_POST['nama'];
			$email			= $_POST['email'];
			$userphonegsm 	= $_POST['nohp'];
			$lengkap	 	= $_POST['lengkap'];
			$tanggalkirim 	= $_POST['tanggalkirim'];
			if(empty($tanggalkirim))
				$tanggalkirim = $date;


			$sql	= "select status,namalengkap,alamatpengiriman,email,orderid,pengiriman, userid from $nama_tabel where invoiceid='$invoiceid'";
			$query	= sql($sql);
			while($row = sql_fetch_data($query))
			{
				$statusnya		 = $row['status'];
				$namapengiriman	 = $row['namalengkap'];
				$alamatpengiriman= $row['alamatpengiriman'];
				$email			 = $row['email'];
				$orderid		 = $row['orderid'];
				$pengiriman		 = $row['pengiriman'];
				$userid		 = $row['userid'];
				
				if($pengiriman != "Pickup Point")
					$pengiriman = sql_get_var("select nama from tbl_agen where agenid='$pengiriman'");
					
				if($userid == 0)
				{
					$perintah 	= "SELECT userfullname,useremail,userphonegsm FROM tbl_tamu WHERE orderid='$orderid'";
					$hasil 		= sql($perintah);
					$data 		= sql_fetch_data($hasil);
		
					$nama	= $data['userfullname'];
					$email 			= $data['useremail'];
					$userphonegsm 	= $data['userphonegsm'];
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
					
						$linkregister 			= "$fulldomain"."login/register";
						
						/*$contentemail	= sql_get_var("select keterangan from tbl_wording where alias='shipping' and jenis = 'email' limit 1");
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
							
					$contentsms	= sql_get_var("select keterangan from tbl_wording where alias='shipping' and jenis = 'sms' limit 1");

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
			else
			{
				$perintah = "update $nama_tabel set status='6' where transaksiid='$transaksiid'";
				$hasil = sql($perintah);
			
				/*$subject			= "$title, Pembatalan Transaksi";
				$userEmail			= "$email"; 
				$userFullName		= "$nama"; 
				$headers 			= "From : $owner";
				
				$isi				= nl2br($lengkap);
				$sendmail			= sendmail($userFullName,$userEmail,$subject,$isi,$isi);
				
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Pembatalan metode pembayaran COD dengan Invoice $invoiceid",$uri,$ip);*/
				
				$msg = base64_encode("Transaksi dengan no invoice $invoice berhasil dibatalkan.");
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
			$transaksiid 	= $_GET['transaksiid'];
			$sql1	= "select invoiceid,userid,orderid,alamatpengiriman, ongkoskirim from $nama_tabel where transaksiid='$transaksiid'";
			$query1	= sql($sql1);
			$row1	= sql_fetch_data($query1);
			$invoiceid	= $row1['invoiceid'];
			$userid		= $row1['userid'];
			$orderid	= $row1['orderid'];
			$alamatpengiriman	= $row1['alamatpengiriman'];
			$ongkoskirim	= $row1['ongkoskirim'];
			$ex	= explode("<br>",$alamatpengiriman);
			$kota = $ex[1];
			
			$kodeinvoice = base64_encode($invoiceid);
			
			if(empty($userid) or ($userid=='0'))
			{
				$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userFullName	= $data['userfullname'];
				$email 			= $data['useremail'];
				$userphonegsm 	= $data['userphonegsm'];
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
            <input type="hidden" name="aksi" value="simpanshipping">
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
                        	<option value="">Pilih Status Pengiriman</option>
                        	<option value="kirim">Dikirim</option>
                            <option value="batal">Dibatalkan</option>
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
						// print("<th width=13%>Gudang/Toko</th></tr></thead>");
			
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
							print("<td valign=top class=hitam>$jumlah</td>
									<input type=\"hidden\" name=\"transaksidetailid[]\" value=\"$transaksidetailid\" />
									<input type=\"hidden\" name=\"qty[]\" value=\"$jumlah\" />
									<input type=\"hidden\" name=\"produkpostid[]\" value=\"$produkpostid\" />
								\n");
							/*print("<td valign=top class=hitam>
                					<select name=\"warehouseid[]\" id=\"status\">");
									$ptoko 		= "select warehouseid,nama from tbl_warehouse order by nama asc";
									$htoko 		= sql($ptoko);
									while($dtoko	= sql_fetch_data($htoko))
									{
										$warehouseid = $dtoko['warehouseid'];
										$nama 		 = $dtoko['nama'];
												
										echo "<option value='$warehouseid'>$nama</option>";
									}
									sql_free_result($htoko);*/
									
							// print("</select></td>");
							print("</tr>\n");
			
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

                            Terima kasih untuk kunjungan Anda pada website <?php echo $title?>.<br /><br />
                            
                            Mohon maaf, kami memberitahukan bahwa transaksi yang telah Anda lakukan
                            dengan nomor invoice <strong><?php echo $invoiceid ?></strong> akan dilakukan pembatalan transaksi
                            yang disebabkan karena :<br /><br />
                            
                            **type your message here**<br /><br />
                            
                            Terimakasih atas kepercayaan Anda berbelanja di <?php echo $title?>. Kami senang dapat melayani Anda.
                            Semoga dilain waktu kami bisa kembali mendapatkan kepercayaan sebagai tempat belanja Anda.
                            Dapatkan kesempatan untuk memperoleh berbagai diskon menarik dengan menjadi member di <?php echo $title?>. 
                            Jika Anda belum menjadi member kami bisa melakukan pendaftaran di :<br /><br />
                            
                            <?php echo $fulldomain?>/login/register<br /><br />
                            
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
	
	/*if($aksi=="ambil")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {

			$transaksiid 	= $_GET['transaksiid'];
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
	}*/
}

?>