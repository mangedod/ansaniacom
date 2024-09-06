<?php
session_start();
if($_SESSION['orderid'])
{
	$tpl->assign("tipe",$_SESSION['tipeid']);
	
	if($_POST['jenis']) $jenis = $_POST['jenis'];
	else $jenis = $_SESSION['jenis']; 
	
	if($_SESSION['username'] or ($jenis==1))
	{
		$userid			= $_POST['userid'];
		$userfullname	= $_POST['userfullname'];
		$useraddress	= $_POST['useraddress'];
		$userpostcode	= $_POST['userpostcode'];
		$userphonegsm 	= $_POST['userphonegsm'];
		$propinsiid 	= $_POST['propinsiid'];
		$negaraid		= $_POST['negaraid'];
		$kotaid		 	= $_POST['kotaid'];
		$kotaid		 	= $_POST['cityname'];
		$kecid			= $_POST['kecid'];
		$pengiriman		= $_POST['pengiriman'];
		$email 			= $_POST['email'];
		$pesan	 		= $_POST['pesan'];
		$pembayaran		= $_POST['pembayaran'];
		$ongkirid		= $_POST['ongkiridnya'];
		$warehouseid	= $_POST['warehouseid'];
		$bank			= $_POST['bank'];
		$orderid		= $_SESSION[orderid];
		$tipeid			= $_SESSION[tipeid];
		$pesan			= $_POST['pesan'];
		$dropship		= $_POST['dropship'];
		$namapengirim	= $_POST['namapengirim'];
		$telppengirim	= $_POST['telppengirim'];
		$ongkoskirim	= $_POST['ongkoskirim'];
		
		$ongkir = base64_decode($ongkirid);
	
		$data        = explode("***",$ongkir);
		$ongkosinfo  = $data[0];
		$ongkoskirim = $data[3];
		if($pengiriman != "Pickup Point")
		{
			$namaagen	= sql_get_var("select nama from tbl_agen where agenid='$pengiriman'");
		}
		else
			$warehouse	= sql_get_var("select nama from tbl_warehouse where warehouseid='$warehouseid'");
		
		$transaksiid 	= sql_get_var("SELECT transaksiid FROM tbl_transaksi WHERE orderid='$_SESSION[orderid]'");
		$jumlah 	= sql_get_var("SELECT count(*) as jumlah FROM tbl_transaksi WHERE invoiceid!=''");
		
		$jedatransfer 	= sql_get_var("SELECT jedapembayaran FROM tbl_konfigurasi WHERE webid='$webid'");
		// $jedatransfer 	= sql_get_var("SELECT nama FROM tbl_jeda_pembayaran WHERE tipeid='$tipeid'");
		
		$kota       = sql_get_var("SELECT namakota FROM tbl_kota WHERE kotaid='$kotaid'");
		$kecamatan  = sql_get_var("SELECT namakecamatan FROM tbl_kecamatan WHERE kecid='$kecid'");
		$propinsi   = sql_get_var("SELECT namapropinsi FROM tbl_propinsi WHERE propid='$propinsiid'");
		$kodenegara = sql_get_var("SELECT kode FROM tbl_negara WHERE id='$negaraid'");
		
		$jumlah++;
		$i 		= 10000000 + $jumlah;
		$kode 	= substr($i,1,7);
		
		$invoiceid = $_SESSION['orderid'];
				
		$isi			= "";
		$tanggal		= date("Y-m-d H:i:s");
		 
		$date = new datetime($tanggal);
		$date->add(new DateInterval('PT'.$jedatransfer.'H'));
		$datetransfer = $date->format('Y-m-d H:i:s');
		
		if($_SESSION['userid'])
		{
			$email 	= sql_get_var("SELECT useremail FROM tbl_member WHERE userid='$_SESSION[userid]'");
		}

		if(empty($_SESSION['userid']) && empty($useraddress))
		{
			$useraddress = sql_get_var("select alamat from tbl_tamu where orderid='$_SESSION[orderid]'");
			$alamat_kirim = "$useraddress".","." $kota".","." $kecamatan".","." $propinsi".","." $kodenegara".","." $userpostcode<br>Telp. $userphonegsm";
		}
		else
		{
			$alamat_kirim = "$useraddress".","." $kota".","." $kecamatan".","." $propinsi".","." $kodenegara".","." $userpostcode<br>Telp. $userphonegsm";
		}
		
		$totalberat = sql_get_var(" SELECT SUM(berat) as total_berat from tbl_transaksi_detail where transaksiid='$transaksiid'");
		
		$jumlahberatkirim = $totalberat;
		
		$sql                     = sql("select transaksiid,totaltagihanafterdiskon from tbl_transaksi where transaksiid='$transaksiid'");
		$dt                      = sql_fetch_data($sql);
		$transaksiid             = $dt['transaksiid'];
		$totaltagihanafterdiskon = $dt['totaltagihanafterdiskon'];
		
		
		if($pembayaran == "Transfer")
		{
			
			$total        = $totaltagihanafterdiskon;
			$totalinvoice = $total+$ongkoskirim;
		}
		else
		{
			$total        = $totaltagihanafterdiskon;
			$totalinvoice = $total+$ongkoskirim;

		}
		
		// Input Transaksi
		$perintah 	= "SELECT invoiceid FROM tbl_transaksi WHERE orderid='$_SESSION[orderid]' and invoiceid='$invoiceid'";
		$hasil 		= sql($perintah);
		if(sql_num_rows($hasil)>0)
		{
			$salah = "Transactions by Invoice No. : $invoiceid have been done.<br><br>\n";
			$tpl->assign("style","alert-danger");
			unset($_SESSION['orderid'], $_SESSION['last'],$_SESSION['jenis']);
			$benar = 2;
		}
		else
		{		
			$perintah 	= "update tbl_transaksi set invoiceid='$invoiceid', namalengkap='$userfullname', email='$email', alamatpengiriman='$alamat_kirim', ongkosinfo='$ongkosinfo',propid='$propinsiid',kotaid='$kotaid',kecid='$kecid',
						 ongkoskirim='$ongkoskirim', totalinvoice='$totalinvoice',pengiriman='$pengiriman',agen='$pengiriman',pembayaran='$pembayaran', bank_tujuan='$bank', tanggaltransaksi='$tanggal', batastransfer='$datetransfer', 
						 warehouseid='2', pesan='$pesan', dropship='$dropship', totaltagihanafterdiskon='$total', namapengirim='$namapengirim', telppengirim='$telppengirim', status='1', userid='$_SESSION[userid]'  
						 where transaksiid='$transaksiid' and orderid='$_SESSION[orderid]'";
			$hasil 		= sql($perintah);
			if (!$hasil)
			{
				$salah = "The message store failed. Please repeat.<br>\n";
				$tpl->assign("style","alert-danger");
				unset($_SESSION['orderid'], $_SESSION['last'],$_SESSION['jenis']);
				$benar = 2;
			}
			else
			{ 
				// Cek Alamat member Ada atau Tidak
					if($_SESSION['userid'])
					{
						$ck          = sql_get_var_row("select useraddress,cityname,propinsiid,userpostcode,kotaid from tbl_member where userid='$_SESSION[userid]'");
						$cekalamat   = $ck['useraddress'];
						$cekkota     = $ck['cityname'];
						$cekkotaid   = $ck['kotaid'];
						$cekpropinsi = $ck['propinsiid'];
						$cekkodepos  = $ck['userpostcode'];
						
						if(empty($cekalamat))
							sql("update tbl_member set useraddress='$useraddress' where userid='$_SESSION[userid]'");
							
						if(empty($cekkota))
							sql("update tbl_member set cityname='$kota' where userid='$_SESSION[userid]'");

						if(empty($cekkotaid))
							sql("update tbl_member set kotaid='$kotaid' where userid='$_SESSION[userid]'");
						
						if(empty($cekpropinsi))
							sql("update tbl_member set propinsiid='$propinsiid' where userid='$_SESSION[userid]'");
						
						if(empty($cekkodepos))
							sql("update tbl_member set userpostcode='$userpostcode' where userid='$_SESSION[userid]'");

						if($_POST['tambahalamat']=='1')
						{
							$new = newid("useralamatid","tbl_member_alamat");
		
							$query	= "insert into tbl_member_alamat (useralamatid,nama,userid,userfullname,useraddress,kotaid,propinsiid,userpostcode,userphonegsm,create_date) values
										('$new','$namaalamat','$_SESSION[userid]','$userfullname','$useraddress','$kotaid','$propinsiid','$userpostcode','$userphonegsm','$tanggal')";//die($query);
							$hasil 	= sql($query);
						}
					}
					
				//tampilkan diskon voucher
				$qryv          = sql(" SELECT voucherid, vouchercodeid, kodevoucher from tbl_transaksi where transaksiid='$transaksiid'");
				$rowv          = sql_fetch_data($qryv);
				$voucherid     = $rowv['voucherid'];
				$vouchercodeid = $rowv['vouchercodeid'];
				$kodevoucher   = $rowv['kodevoucher'];
				
				sql("update tbl_voucher_kode set status='1' where kodevoucher='$kodevoucher' and vouchercodeid='$vouchercodeid'");
					
				sql("update tbl_voucher set used=used+'1' where id='$voucherid'");

				
				if($pembayaran == "Transfer")
				{
					$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
					$hsl = sql($sql);
					$i = 1;
					$a = 1;
					while ($row = sql_fetch_data($hsl))
					{
						$transaksidetailid = $row['transaksidetailid'];
						$produkpostid      = $row['produkpostid'];
						$qty               = $row['jumlah'];
						$berat             = $row['berat'];
						$cabangid          = $row['warehouseid'];
						$matauang          = $row['matauang'];
						$harga             = "$matauang. ". number_format($row['harga'],"0",".",".");
						$total             = "$matauang. ". number_format($row['totalharga'],"0",".",".");

						$dtprodukpos = sql_get_var_row("select title, kodeproduk, misc_harga, misc_diskon, warnaid, sizeid from tbl_product_post where produkpostid='$produkpostid'");
						$namaprod    = $dtprodukpos['title'];
						$kodeproduk  = $dtprodukpos['kodeproduk'];
						$produkid    = sql_get_var("select produkid from tbl_product where kodeproduk='$kodeproduk'");
						$warnaid     = $dtprodukpos['warnaid'];
						$warnas      = sql_get_var_row("select kode,nama from tbl_warna where id='$warnaid'");
						$kodewarna   = $warnas['kode'];
						$warna       = $warnas['nama'];
						$sizeid      = $dtprodukpos['sizeid'];
						$size        = sql_get_var("select nama from tbl_size where sizeid='$sizeid'");
						$diskon      = $dtprodukpos['misc_diskon'];
						$misc_harga  = $dtprodukpos['misc_harga'];
						$harga_asli  = "$matauang.".number_format($misc_harga,0,".",".");
						$hargadiskon = "$matauang.".number_format($diskon,0,".",".");

						/*if($diskon!=0){
							$harga_asli = $harga_asli;
						}else{
							$harga_asli  = $hargadiskon;
						}*/
						// $nogsmcabang	= sql_get_var("select nogsm from tbl_warehouse where warehouseid='$cabangid'");
						
						$perintahst 	= "insert into tbl_product_stokonhold (`invoiceid`, `produkpostid`, `jumlah`, `tipe`) values ('$invoiceid', '$produkpostid', '$qty', '$tipeid')";
						$hasilst 		= sql($perintahst);
						
						// album
						$gambar_s	= sql_get_var("select gambar_s from tbl_product_image where produkpostid='$produkpostid' and produkid='$produkid' order by albumid asc limit 1");
						
						if(!empty($gambar_s))
							$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
						else
							$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
						
						$berattotal	.= $berattotal+$row['berat'];
						
						$dt_keranjang[$transaksidetailid] = array("transaksidetailid"=>$transaksidetailid,"nama"=>$namaprod,"kodeproduk"=>$kodeproduk,"image_s"=>$image_s,"berat"=>$berat,"totalharga"=>$total,"qty"=>$qty,"harga"=>$harga,"xx"=>$a,"harga_asli"=>$harga_asli,"hargadiskon"=>$hargadiskon,"kodewarna"=>$kodewarna,"namawarna"=>$warna,"size"=>$size);
	
						$i %= 2;
						$i++;
						$a++;
					}
					
					$tpl->assign("detailproduk",$dt_keranjang);
					
	
					$ongkoskirim2	= "$matauang. ". number_format($ongkoskirim,0,".",".");
						
					//tampilkan diskon voucher
					$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, vouchercodeid, kodevoucher, totaltagihan from tbl_transaksi where transaksiid='$transaksiid'");
					$rowv                    = sql_fetch_data($qryv);
					$voucherid               = $rowv['voucherid'];
					$vouchercodeid           = $rowv['vouchercodeid'];
					$kodevoucher             = $rowv['kodevoucher'];
					$totaldiskon             = $rowv['totaldiskon'];
					$totaltagihanafterdiskon = $rowv['totaltagihanafterdiskon'];
					$totaltagihan            = $rowv['totaltagihan'];
					
					$namavoucher = sql_get_var("select nama from tbl_voucher where id = '$voucherid'");
					
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
						
					$tujuan = "";
					if($pembayaran == 'Transfer')
					{
						$perintah = "select * from tbl_norek where status='1' and id = '$bank'";
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
							$tujuan .=" $bank No $norek a.n $atasnama ";
						}
					}
					
					$kodeinvoice = base64_encode($invoiceid);
		
					$urlconfirm = "$fulldomain"."/cart/confirm/$kodeinvoice";
					$urldownload = "$fulldomain"."/cart/print/$kodeinvoice";
					
					$statusorder = "BILLED";
					
					$warnafont = "#e41b1a";
					
				
					$tpl->assign("totaltagihan",$totaltagihan2);
					$tpl->assign("total_diskon",$totaldiskon);
					$tpl->assign("total_diskon2",$totaldiskon2);
					$tpl->assign("ongkos_kirim",$ongkoskirim);
					$tpl->assign("ongkos_kirim2",$ongkoskirim2);
					$tpl->assign("totaltagihanakhird",$totaltagihanakhir2);
					$tpl->assign("totberat",$jumlahberatkirim);
					$tpl->assign("namadiskon",$namavoucher);
					$tpl->assign("diskonnya",$totaldiskon2);
					$tpl->assign("kode_voucher",$kodevoucher);
					
					// ambil data kontak admin
					$tk       = sql_get_var_row("select nama,alamat,telp,gsm from tbl_static where alias='kontak' limit 1");
					$namatk   = $tk['nama'];
					$alamattk = $tk['alamat'];
					$telptk   = $tk['telp'];
					$gsmtk    = $tk['gsm'];
				
					//include("invoice.pdf.php");
					
					$pengirim 			= "$owner <$support_email>";
					$webmaster_email 	= "Support <$support_email>"; 
					$userEmail			= "$email"; 
					$userFullName		= "$userfullname"; 
					$headers 			= "From : $owner";
					$subject			= "$title, Invoice #$invoiceid";
					
					$sendmail			= sendmail($userFullName,$userEmail,$subject,$html,$html,1);
								
					$salah = "<center>Thank you, your transaction has been successful, we have sent an email to you. <br>Please check your email to see the details of the transaction.
							<br>Your invoice number is <strong><a href='$urldownload' target='_blank'>$invoiceid</a></strong> / the invoice number will be used when the transfer / payment confirmation.
								<br><br><a href='$urldownload' class='btn btn-xs btn-primary' target='_blank'>Print Invoice</a>&nbsp;&nbsp;<a href='$urlconfirm' class='btn btn-xs btn-primary'>Make a Payment Confirmation</a></center>";
					$tpl->assign("style","alert-success");
						
					//kirim email ke admin
					$to 		= "$support_email";
					$from 		= "$support_email";
					$headers 	= "From : $owner";
					$subject2 	= "Invoice No. Ordering Information $invoiceid - $title";
					
					$sendmail	= sendmail($title,$to,$subject2,$html,$html,1);
					kirimSMS($userphonegsm,"Terima kasih sudah belanja di Ansania dgn Nomor Transaksi $invoiceid, lanjutkan Pembayaran Rp. $totaltagihanakhir2 ke $tujuan.");
			
					setlog($userfullname,"system","Doing Purchase.","$fulldomain"."panel/index.php?tab=5&tabsub=9&kanal=transaksi&aksi=detail&invoiceid=$invoiceid","buy");
					unset($_SESSION['orderid'], $_SESSION['last'],$_SESSION['jenis']);
				}
				else if($pembayaran=="CreditCard")
				{
					$item_details = array();
						
					$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
					$hsl = sql($sql);
					$i = 1;
					$a = 1;
					while ($row = sql_fetch_data($hsl))
					{
						$transaksidetailid = $row['transaksidetailid'];
						$produkpostid      = $row['produkpostid'];
						$qty               = $row['jumlah'];
						$berat             = $row['berat'];
						$matauang          = $row['matauang'];
						$harga 				= $row['harga'];
						
						$sql2	= "select title,kodeproduk from tbl_product_post where produkpostid='$produkpostid'";
						$query2	= sql($sql2);
						$row2	= sql_fetch_data($query2);
						$nama			= $row2["title"];
						$kodeproduk		= $row2['kodeproduk'];

						
						$perintahst 	= "insert into tbl_product_stokonhold (`invoiceid`, `produkpostid`, `jumlah`, `tipe`) values ('$invoiceid', '$produkpostid', '$qty', '$tipeid')";
						$hasilst 		= sql($perintahst);
						
						$berattotal	.= $berattotal+$row['berat'];
						
						$nama = substr("$kodeproduk - $nama",0,49);
						
						$item_details[] = array('id' => "$a",'price' => $harga,'quantity' => $qty,'name' => "$nama");
						
	
						$i %= 2;
						$i++;
						$a++;
						}
						if(!empty($ongkoskirim))
						{
							$item_details[] = array('id' => $a,'price' => $ongkoskirim,'quantity' => "1",'name' => "Ongkos Kirim");
						}
						
						if(!empty($kodevoucher))
						{
							unset($item_details);
							$nama = substr("$kodeproduk - $nama",0,25);
							$item_details[] = array('id' => 1,'price' => $totalinvoice,'quantity' => "1",'name' => "$nama + Ongkir");
						}

					
					require_once($lokasiweb."librari/veritrans/Veritrans.php");
				
					Veritrans_Config::$serverKey = "$serverkey";
					Veritrans_Config::$isProduction = $isProduction;
					Veritrans_Config::$is3ds = true;
					
					//Update Metode Pembayaran
					$update = sql("update tbl_transaksi set pembayaran='CreditCard',totalinvoice='$totalinvoice' where orderid='$_SESSION[orderid]'");
					
					// Required
					$transaction_details = array(
					  'order_id' => $_SESSION['orderid'],
					  'gross_amount' => $totalinvoice, // no decimal allowed for creditcard
					  );
					
					//Query ke Tabel Member
					$sql = "select userfullname,useraddress,cityname,userphonegsm,userpostcode,useremail from tbl_member where userid='$_SESSION[userid]'";
					$hsl = sql($sql);
					
					$data = sql_fetch_data($hsl);
					
					$userfullname 	= $data['userfullname'];
					$useraddress	= $data['useraddress'];
					$cityname	= $data['cityname'];
					$userphonegsm	= $data['userphonegsm'];
					$userpostcode	= $data['userpostcode'];
					$useremail	= $data['useremail'];
					
					sql_free_result($hsl);
					
					// Optional
					$customer_details = array(
						'first_name'    => "$userfullname",
						'last_name'     => "$userfullname",
						'email'         => "$useremail",
						'phone'         => "$userphonegsm"
						);
						
					// Fill transaction details
					$transaction = array(
						"vtweb" => array (
						  "enabled_payments" => array("credit_card"),
						  "finish_redirect_url" => "$fulldomain"."/cart/finish/sukses/",
						  "unfinish_redirect_url" => "$fulldomain"."/cart/finish/gagal/",
						  "error_redirect_url" => "$fulldomain"."/cart/finish/error/"
						),
						'transaction_details' => $transaction_details,
						'customer_details' => $customer_details,
						'item_details' => $item_details,
						);
					
					try {
					  // Redirect to Veritrans VTWeb page
					  header('Location: ' . Veritrans_VtWeb::getRedirectionUrl($transaction));
					  exit();
					}
					catch (Exception $e) {
					  echo $e->getMessage();
					  if(strpos ($e->getMessage(), "Access denied due to unauthorized")){
						  echo "<code>";
						  echo "<h4>Please set real server key from sandbox</h4>";
						  echo "In file: " . __FILE__;
						  echo "<br>";
						  echo "<br>";
						  echo htmlspecialchars('Veritrans_Config::$serverKey = \'<your server key>\';');
						  die();
					}
					
					}
									
				}
				
				else if($pembayaran=="BankTransfer")
				{
					
					$item_details = array();
					
					$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
					$hsl = sql($sql);
					$i = 1;
					$a = 1;
					while ($row = sql_fetch_data($hsl))
					{
						$transaksidetailid 	= $row['transaksidetailid'];
						$produkpostid	= $row['produkpostid'];
						$qty 			= $row['jumlah'];
						$berat			= $row['berat'];
						$matauang		= $row['matauang'];
						$misc_harga		= $row['harga'];
							
						$sql2	= "select title,kodeproduk from tbl_product_post where produkpostid='$produkpostid'";
						$query2	= sql($sql2);
						$row2	= sql_fetch_data($query2);
						$nama			= $row2["title"];
						$kodeproduk		= $row2['kodeproduk'];
					
						
						$perintahst 	= "insert into tbl_product_stokonhold (`invoiceid`, `produkpostid`, `jumlah`, `tipe`) values ('$invoiceid', '$produkpostid', '$qty', '$tipeid')";
						$hasilst 		= sql($perintahst);
						
						$berattotal	.= $berattotal+$row['berat'];
						
						$nama = substr("$kodeproduk - $nama",0,49);
						
						$item_details[] = array('id' => "$a",'price' => $misc_harga,'quantity' => $qty,'name' => "$nama");
						
	
						$i %= 2;
						$i++;
						$a++;
					}
					
					if(!empty($ongkoskirim))
					{
							$item_details[] = array('id' => $a,'price' => $ongkoskirim,'quantity' => "1",'name' => "Ongkos Kirim");
					}
					
					if(!empty($kodevoucher))
					{
						unset($item_details);
						$nama = substr("$kodeproduk - $nama",0,25);
						$item_details[] = array('id' => 1,'price' => $totalinvoice,'quantity' => "1",'name' => "$nama + Ongkir");
					}
					
					require_once($lokasiweb."librari/veritrans/Veritrans.php");
				
					Veritrans_Config::$serverKey = "$serverkey";
					Veritrans_Config::$isProduction = $isProduction;
					Veritrans_Config::$is3ds = true;
					
					//Update Metode Pembayaran
					$update = sql("update tbl_transaksi set pembayaran='BankTransfer',totalinvoice='$totalinvoice' where orderid='$_SESSION[orderid]'");
					
					// Required
					$transaction_details = array(
					  'order_id' => $_SESSION['orderid'],
					  'gross_amount' => $totalinvoice, // no decimal allowed for creditcard
					  );
					
					//Query ke Tabel Member
					$sql = "select userfullname,useraddress,cityname,userphonegsm,userpostcode,useremail from tbl_member where userid='$_SESSION[userid]'";
					$hsl = sql($sql);
					
					$data = sql_fetch_data($hsl);
					
					$userfullname 	= $data['userfullname'];
					$useraddress	= $data['useraddress'];
					$cityname	= $data['cityname'];
					$userphonegsm	= $data['userphonegsm'];
					$userpostcode	= $data['userpostcode'];
					$useremail	= $data['useremail'];
					
					sql_free_result($hsl);
					
					kirimSMS($userphonegsm,"Terima kasih sudah belanja di Ansania dgn Nomor Transaksi $invoiceid, lanjutkan Pembayaran anda sesuai dengan metode yang anda pilih.");
					
					// Optional
					$customer_details = array(
						'first_name'    => "$userfullname",
						'last_name'     => "$userfullname",
						'email'         => "$useremail",
						'phone'         => "$userphonegsm"
						);
						
					// Fill transaction details
					$transaction = array(
						"vtweb" => array (
						  "enabled_payments" => array("bank_transfer"),
						  "finish_redirect_url" => "$fulldomain"."/cart/finish/sukses/",
						  "unfinish_redirect_url" => "$fulldomain"."/cart/finish/gagal/",
						  "error_redirect_url" => "$fulldomain"."/cart/finish/error/"
						),
						'transaction_details' => $transaction_details,
						'customer_details' => $customer_details,
						'item_details' => $item_details,
						);
					
					try {
					  // Redirect to Veritrans VTWeb page
					  header('Location: ' . Veritrans_VtWeb::getRedirectionUrl($transaction));
					  exit();
					}
					catch (Exception $e) {
					  echo $e->getMessage();
					  if(strpos ($e->getMessage(), "Access denied due to unauthorized")){
						  echo "<code>";
						  echo "<h4>Please set real server key from sandbox</h4>";
						  echo "In file: " . __FILE__;
						  echo "<br>";
						  echo "<br>";
						  echo htmlspecialchars('Veritrans_Config::$serverKey = \'<your server key>\';');
						  die();
					}
					
					}
									
				}
				
			}
		}
		$tpl->assign("benar",$benar);	
		$tpl->assign("salah",$salah);
		$tpl->assign("agen",$agen);
		$tpl->assign("trans_id",$trans_id);
		$tpl->assign("kotatujuan2",$kotatujuan2);
		$tpl->assign("namarubrik","Transaksi Sukses");
	}
	else
	{
		$last = "$fulldomain"."/cart/checkout";
		$_SESSION['last']	= $last;
		header("location: $fulldomain"."/member/login");
	}

}
else
{
	$salah = "<center>Your order does not have the number of transactions. Please repeat the process of shopping <br> You choose
featured product range.<br>
	<br><a href='$fulldomain/product' class='btn btn-warning'>Select Product In First</a></center>";
	$tpl->assign("style","alert-danger");
	$tpl->assign("salah",$salah);
}

?>