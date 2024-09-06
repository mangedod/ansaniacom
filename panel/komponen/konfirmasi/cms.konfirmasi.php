<?php 
//Variable halaman ini
$nama_tabel		= "tbl_konfirmasi";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;


//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];
 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Konfirmasi","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Konfirmasi","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("invoiceid","Invoice","text","text","$data");
			$cari[] = array("nama","Nama","str","text","$data");
			$cari[] = array("create_date","Tanggal Konfirmasi","date","date","$data");
			

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("create_date","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];
						
			$sql = "select count(*) as jml from $nama_tabel where 1 $where  $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select id,invoiceid,metode_pembayaran,bank_tujuan,total_bayar,jumlah_bayar,bank_dari, norek, atas_nama, kartukredit, tanggalbayar, status, flag, create_date from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=invoice\" title=\"Urutkan\">Invoice</a></th>\n");
			print("<th width=15%>Bank Tujuan</th>\n");
			print("<th width=15%>Bank Pengirim</th>\n");
			print("<th width=15%>Akun Pengirim</th>\n");
			print("<th width=10%>Total Pembayaran</th>\n");
			print("<th width=10%>Tanggal</th>\n");
			print("<th width=5%>Status Konfirmasi</th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id					= $row['id'];
				$invoiceid			= $row['invoiceid'];
				$metode_pembayaran	= $row['metode_pembayaran'];
				$bank_tujuan		= $row['bank_tujuan'];
				$total_bayar		= "IDR. ".number_format($row['total_bayar'],0,".",".").",-";
				$jumlah_bayar			= $row['jumlah_bayar'];
				$bank_dari		= $row['bank_dari'];
				$norek	= $row['norek'];
				$atas_nama				= $row['atas_nama'];
				$kartukredit				= $row['kartukredit'];
				$tanggalbayar				= $row['tanggalbayar'];
				$status			= $row['status'];
				$tanggalkonfirmasi	= tanggal($row['create_date']);

				$sqlr	= "select bank, norek from tbl_norek where id='$bank_tujuan'";
				$resr	= sql($sqlr);
				$rowr	= sql_fetch_data($resr);
					$id_bank		= $rowr['bank'];
					$norek_tujuan	= $rowr['norek'];
				sql_free_result($resr);
				
				$nama_bank = sql_get_var("select namabank from tbl_bank where bankid='$id_bank'");
				
				/*if($status_konfirmasi=="1") $stats = "Accepted";
				else if($status_konfirmasi=="2") $stats	= "Canceled";
				else $stats = "Pending";*/

				if($status=="0") 
				{
					$stats1	= "<a href=\"$alamat&aksi=tambah&invoice=$invoice\">Pending</a>";
				}
				elseif($status=="1") $stats1	= "Lunas";
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b>$invoiceid</b></td>\n
					<td  valign=top >$nama_bank - $norek_tujuan</td>
					<td  valign=top >$bank_dari - $norek</td>
					<td  valign=top >$atas_nama</td>
					<td  valign=top >$total_bayar</td>
					<td  valign=top >$tanggalkonfirmasi</td>
					<td  valign=top >$stats1</td>");
					// <td  valign=top ><a href=\"index.php?pop=1&kanal=konfirmasi&aksi=popupconfirm\">$stats</a></td>
					

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		    
			
		}
	} //EndView 
	
	if($aksi=="saveconfirm")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$invoice			= $_POST['invoice'];
			$email				= $_POST['email'];
			$nama				= $_POST['nama'];
			$alamatpengiriman	= $_POST['alamatpengiriman'];
			$note_konfirmasi	= desc($_POST['note_konfirmasi']);
			$status_konfirmasi	= cleaninsert($_POST['status_konfirmasi']);
		
			if($status_konfirmasi=="2") $cancelstats = ",status='2'";
			else if($status_konfirmasi=="1") $cancelstats = ",status='1'";
			else $cancelstats = ",status='0'";
			
			$perintah = "update $nama_tabel set status_konfirmasi='$status_konfirmasi',note_konfirmasi='$note_konfirmasi' $cancelstats where invoice='$invoice'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$message	= "
					Dear $nama,<br><br />
					
					Terimakasih atas pembayaran yang dilakukan untuk nomor invoice <strong>#$invoice</strong><br />
					Kami telah menerima dan melakukan validasi atas pembayaran yang Anda lakukan.<br /><br />

					Kami akan segera melakukan pengiriman untuk pesanan Anda ke alamat :<br />

					$alamatpengiriman<br /><br />
					
					Catatan : $note_konfirmasi<br /><br />

					Terimakasih atas kepercayaan Anda berbelanja di $title. Kami senang dapat melayani Anda.
					Semoga dilain waktu Kami bisa kembali mendapatkan kepercayaan sebagai tempat belanja Anda.<br /><br />
					
					Regards,<br />
					$owner
				";
				
				//kirim email ke admin
				$to 		= "$email";
				$from 		= "$support_email";
				$subject 	= "$title, Konfirmasi Pembayaran Invoice #$invoice";
				$message 	= $message;
				$headers 	= "From : $owner";
				
				$sendmail	= sendmail($judulpesan,$to,$subject,$message2,$message);
				
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan validasi atas Konfirmasi pembayaram untuk Invoice $invoice",$uri,$ip);
				
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="confirm")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			$transaksiid	= $_GET['transaksiid'];

			$sql1 	= "select transaksiid,invoiceid,totaltagihan,totaltagihanafterdiskon,ongkoskirim from tbl_transaksi where transaksiid='$transaksiid'";
			$hsl1 	= sql($sql1);
			$row1 	= sql_fetch_data($hsl1);
			$transaksiid			= $row1['transaksiid'];
			$invoiceid				= $row1['invoiceid'];
			$totaltagihan			= $row1['totaltagihan'];
			$totaltagihanafterdiskon= $row1['totaltagihanafterdiskon'];
			$ongkoskirim			= $row1['ongkoskirim'];
			
			if($totaltagihanafterdiskon==0)
				$totaltagihanakhir = $totaltagihan+$ongkoskirim;
			else
				$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;

			$sql = "select id,invoiceid,metode_pembayaran,bank_tujuan,total_bayar,jumlah_bayar,bank_dari, norek, atasnama, kartukredit, tanggalbayar, status, flag from $nama_tabel  where invoiceid='$invoiceid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
				$id 				= $row['id'];
				$userid 			= $row['userid'];
				$bank_tujuan 		= $row['bank_tujuan'];
				$bank_dari 			= $row['bank_dari'];
				$norek 				= $row['norek'];
				$atas_nama 			= $row['atas_nama'];
				$jumlah_bayar 		= "Rp. ".number_format($row['jumlah_bayar'],0,".",".").",-";
				$status_konfirmasi 	= $row['status_konfirmasi'];
				$note_konfirmasi	= $row['note_konfirmasi'];
				$nama 				= $row['nama'];
				$email 				= $row['email'];
				$invoice 			= $row['invoice'];
				$tipe_pembayaran 	= $row['tipe_pembayaran'];
				$total_bayar 		= "Rp. ".number_format($row['total_bayar'],0,".",".").",-";
				$tgl_bayar 			= $row['tgl_bayar'];
				$tanggal_bayar		= tanggaltok($tgl_bayar);
				$alamat11 			= $row['alamat'];
				$kode_voucher 		= $row['kode_voucher'];
				$ongkos_kirim 		= "Rp. ". number_format($row['ongkos_kirim'],0,".","."). ",-";
				$pesan 				= $row['pesan'];
				$nohp 				= $row['nohp'];
				$metode_pembayaran 	= $row['metode_pembayaran'];
				$kotaid 			= $row['kotaid'];
				// $kota				= getNamaKota($kotaid);
				$ongkos_id			= $row['ongkosid'];
			
				$perintah 	= "select * from tbl_norek where status='1'";
				$hasil 		= sql($perintah);
				while ($data=sql_fetch_data($hasil)) 
				{
					$id			= $data['id'];
					$id_bank	= $data['bank'];
					$norek		= $data['norek'];
					
					$sql8	= "select namabank from tbl_bank where bankid='$id_bank'";
					$res8	= sql($sql8);
					$row8	= sql_fetch_data($res8);
					$namabank	= $row8['namabank'];
					
					sql_free_result($res8);
					
					$nama = "$namabank ($norek)";
					
					$bank[$id] = array("id"=>$id, "nama"=>$nama, "id_bank"=>$id_bank);
				}
				sql_free_result($hasil);
			?>

            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
						$( "#tanggal" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true
						});

				});
			
				function klikid(idnya)
				{
					$("#example-"+idnya).colorbox({width:"500", inline:true, href:"#inline_example"+idnya});
				}
				function klikinv(idnya)
				{
					$("#printinv-"+idnya).colorbox({width:"775", inline:true, href:"#inline_inv"+idnya});
				}
			</script>

			<style>
				.detail { float:left; width:100%; margin-bottom:5px; background-color:#fcdcdc; padding:5px;}
				.details { float:left; width:100%; margin-bottom:5px; background-color:#f7f6f6; padding:5px;}
				.label-detail { float:left; width:139px; font-weight:bold; }
				.buttons { float:left; border:1px #cccccc solid; padding:5px 10px;}
				.header-tabel { float:left; background-color:#f1f1f1; overflow:hidden; padding:5px 0; text-align:center; font-weight:bold; margin-right:1px; margin-bottom:1px; }
				.isi-tabel-0 { float:left; background-color:#f7f6f6; overflow:hidden; padding:5px 0; text-align:center; margin-right:1px; margin-bottom:1px; }
				.isi-tabel-1 { float:left; background-color:#fcdcdc; overflow:hidden; padding:5px 0; text-align:center; margin-right:1px; margin-bottom:1px; }
				.header-tabel-dark { float:left; background-color:#e8e8e8; overflow:hidden; padding:5px 0; text-align:center; font-weight:bold; margin-right:1px; }
				.shipping { display:none; }
				.icon-menu { float:left; width:40px; text-align:center; margin-right:10px; height:auto; }
				.box-invoice {float:left; border:1px #cfcfcf solid; width:710px; overflow:hidden; margin-bottom:10px;}
				.box-logo {float:left; width:400px; overflow:hidden; margin-right:10px;}
				.box-status {float:left; width:300px; overflow:hidden; margin-bottom:10px;}
				.status-invoice {float:left; text-align:center; width:100%; padding:5px 0; margin-bottom:10px;}
				.status-invoice span { font-weight:bold; font-size:20px; line-height:22px;}
				
				.box-list-inv { float:left; margin:3px 10px; width:688px; overflow:hidden; }
				.box-list-inv span { font-weight:bold; font-size:16px;}
				
				.datepay { float:left; min-width:50px; width:auto !important; }
			</style>
			<link media="screen" rel="stylesheet" href="./template/colorbox/colorbox.css" />
			<script src="./template/colorbox/jquery.colorbox.js"></script>

					<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
					<input type="hidden" name="aksi" value="saveconfirm">
		            <input type="hidden" name="invoice" value="<?php echo $invoice?>" />
	                <input type="hidden" name="nama" id="nama" value="<?php echo $nama?>" />
	                <input type="hidden" name="email" id="email" value="<?php echo $email?>" />
					<table border="0" class="tabel-cms" width="100%">
						<tr>
							<th colspan="2">Detail Data Konfirmasi</th>
						</tr>
						<tr> 
							<td valign="top" style="width: 17%;">Id Data</td> 
							<td align="left">#<?php echo $id ?></td>
						</tr>
						<tr> 
							<td valign="top">Invoice Number</td> 
							<td align="left">
								<!--<?php //echo"<a href=\"$alamat&aksi=detail&id=$id\">"; ?> <?php echo $invoice?> <?php //echo "</a>"; ?>-->
								<a onclick="return klikinv(<?php echo $id?>);" id="printinv-<?php echo $id?>"><strong><?php echo $invoice?></strong></a>
							</td>
						</tr>
						<tr> 
							<td valign="top">Tipe Pembayaran</td> 
							<td align="left"><?php echo $tipe_pembayaran?></td>
						</tr>
						<tr> 
							<td valign="top">Metode Pembayaran</td> 
							<td align="left"><?php echo $metode_pembayaran?></td>
						</tr>
						<tr> 
							<td valign="top">Bank Tujuan</td> 
							<td align="left"><?php echo $nama_bank ?></td>
						</tr>
						<tr> 
							<td valign="top">Total Belanja</td> 
							<td align="left"><?php echo $total_bayar?></td>
						</tr>
						<tr> 
							<td valign="top">Jumlah Bayar</td> 
							<td align="left"><?php echo $jumlah_bayar?></td>
						</tr>
		                <tr> 
							<td>Tanggal</td>
							<td><?php echo $tgl_bayar?></td>
						</tr>
						<tr> 
							<td valign="top">Bank Pengirim</td> 
							<td align="left"><?php echo $bank_dari?></td>
						</tr>
						<tr> 
							<td valign="top">Nomor Rekening</td> 
							<td align="left"><?php echo $norek?></td>
						</tr>
						<tr> 
							<td valign="top">Atas Nama</td> 
							<td align="left"><?php echo $atas_nama?></td>
						</tr>
		                <tr> 
							<td >Pesan Tambahan</td>
							<td ><?php echo $pesan?></td>
						</tr>
						<tr> 
							<td valign="top">Status</td> 
							<td align="left">
								<select name="status_konfirmasi">
		                            <option value="0" <?php if ($status_konfirmasi == '0'){?>selected="selected"<?php } ?>>Pending</option>
		                            <option value="1" <?php if ($status_konfirmasi == '1'){?>selected="selected"<?php } ?>>Accepted</option>
		                            <option value="2" <?php if ($status_konfirmasi == '2'){?>selected="selected"<?php } ?>>Canceled</option>
		                        </select>
		                    </td>
						</tr>
	                    <tr> 
	                        <td >Catatan untuk Pembeli</td>
	                        <td ><textarea name="note_konfirmasi" cols="76" rows="5" id="pesan" class="validate[required]"><?php echo $note_konfirmasi?></textarea></td>
	                    </tr>
						<tr> 
							<td valign="top">&nbsp;</td>
							<td align="left">
								<input type="submit" name="Submit" value="Simpan" />
								<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
							</td>
						</tr>
					</table>
					</form>
            <?php 	
		}
	}

	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		{	
			$invoiceid		= $_POST['invoiceid'];
			$bank			= $_POST['bank'];
			$total 			= $_POST['total'];
			$daribank 		= $_POST['daribank'];
			$norek 			= $_POST['norek'];
			$name 			= $_POST['atas_nama'];
			$tgl_konfirmasi	= date("Y-m-d H:i:s");
			$jumlah_bayar	= $_POST['jumlah_bayar'];
			$tgl_bayar		= cleaninsert($_POST['tanggal']);
			
			if(empty($invoiceid))
			{
				$error = base64_encode("Harap memasukan Nomor Invoice terlebih dahulu.");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
			
			$new = newid("id",$nama_tabel);
			
			$statustrans	= sql_get_var("select status from tbl_transaksi where invoiceid='$invoiceid'");
		
			if($statustrans == '5')
			{
				$error = base64_encode("Nomor Invoice $invoiceid yang anda masukan sudah dibatalkan karena melebihi batas waktu transfer yang ditentukan. Silahkan invoice ulang di menu transaksi ke konsumen yang bersangkutan.");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
			else
			{
				$konfirmasiid	= sql_get_var("select id from tbl_konfirmasi where invoiceid='$invoiceid'");
			
				if(empty($konfirmasiid))
				{
					$perintah2 	= "insert into tbl_konfirmasi (`bank_tujuan`, `bank_dari`, `norek`, `jumlah_bayar`, `total_bayar`, `metode_pembayaran`, `atas_nama`, `status`, `create_date`, 
							`tanggalbayar`,`invoiceid`) values ('$bank', '$daribank', '$norek', '$jumlah_bayar', '$total','$pembayaran', '$name', '1', '$tgl_konfirmasi', '$tgl_bayar', 
							'$invoiceid')";
					$hasil 		= sql($perintah2);	
					
					if($hasil)
					{
						$update	= sql("update tbl_transaksi set status='2' where invoiceid='$invoiceid'");
					
						$qrys	= sql("select namalengkap,email,alamatpengiriman,resellerid from tbl_transaksi where invoiceid='$invoiceid'");
						$rows	= sql_fetch_data($qrys);
						
						$fname            = $rows['namalengkap'];
						$email            = $rows['email'];
						$alamatpengiriman = $rows['alamatpengiriman'];
						$resellerid       = $rows['resellerid'];
						if($resellerid == '0')
						{
							$aliasdomain = "$fulldomain/reseller/registrasi";
						}
						else
						{
							$qrysres          = sql("select userfullname,useremail,userid from tbl_member where userid='$resellerid'");
							$rowsres          = sql_fetch_data($qrysres);
							$contactname      = $rowsres['userfullname'];
							$contactuseremail = $rowsres['useremail'];
							$idusernya        = $rowsres['userid'];
							$aliasdomain1     = sql_get_var("select aliasdomain from tbl_domain where userid='$idusernya'");
							$aliasdomain      = "$aliasdomain1/user/daftar";

							//kirim email ke reseller
							$tores      = "$owner <$support_email>";
							$fromres    = "Support <$support_email>";
							$headers    = "From : $owner";
							$subjectres = "Konfirmasi Pembayaran";
							$message    = "Ada Informasi mengenai Konfirmasi online $title dengan no invoice $invoiceid";
							
							$sendmail1	= sendmail($contactname,$contactuseremail,$subjectres,$message,$message,1);
						}
					
						$isi = "
								Dear $fname,<br /><br />
		
								Terimakasih atas pembayaran yang dilakukan untuk <strong>$invoiceid</strong><br />
								Kami telah menerima dan melakukan validasi atas pembayaran yang Anda lakukan.<br /><br />
								 
								Kami akan segera melakukan pengiriman untuk pesanan Anda ke alamat :<br />
								 
								$alamatpengiriman<br /><br />
		
								Terimakasih atas kepercayaan Anda berbelanja di $title. Kami senang dapat melayani Anda.
								Semoga dilain waktu kami bisa kembali mendapatkan kepercayaan sebagai tempat belanja Anda.
								Dapatkan kesempatan untuk memperoleh berbagai diskon menarik dengan menjadi member di $title. 
								Jika Anda belum menjadi member kami bisa melakukan pendaftaran di : <br />
		
								<a href='$aliasdomain'>$aliasdomain</a><br /><br />
		
								Regards,<br />
		
								$title
							";
							
						$pengirim 			= "$owner <$support_email>";
						$webmaster_email 	= "Support <$support_email>"; 
						$userEmail			= "$email"; 
						$userFullName		= "$fname"; 
						$headers 			= "From : $owner";
						$subject			= "$title, Konfirmasi Pembayaran";
						
						$sendmail			= sendmail($userFullName,$userEmail,$subject,$isi,$isi,1);
						
						//kirim email ke admin
						$to 		= "$support_email";
						$from 		= "$support_email";
						$subject1 	= "Konfirmasi Pembayaran";
						$message 	= "Ada Informasi mengenai Konfirmasi online $title dengan no invoice $invoice";
						$headers 	= "From : $from";
						
						$sendmail1	= sendmail("Support",$support_email,$subject1,$message,$message,1);

						setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penambahan data Konfirmasi Pembayaran untuk Invoice $invoiceid",$uri,$ip);  
						$msg = base64_encode("Berhasil menambahkan Konfirmasi");
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
				else
				{
					$error = base64_encode("Nomor Invoice $invoiceid yang anda masukan sudah melakukan konfirmasi sebelumnya.");
					header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
					exit();
				}
			}
		}
	}
	
	//Tambah
	if($aksi=="tambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			
			$transaksiid	= $_GET['transaksiid'];

			$sql1 	= "select transaksiid,invoiceid,totaltagihan,totaltagihanafterdiskon,ongkoskirim,pembayaran from tbl_transaksi where transaksiid='$transaksiid'";
			$hsl1 	= sql($sql1);
			$row1 	= sql_fetch_data($hsl1);
			$transaksiid			= $row1['transaksiid'];
			$invoiceid				= $row1['invoiceid'];
			$totaltagihan			= $row1['totaltagihan'];
			$totaltagihanafterdiskon= $row1['totaltagihanafterdiskon'];
			$ongkoskirim			= $row1['ongkoskirim'];
			$pembayaran				= $row1['pembayaran'];
			
			if($totaltagihanafterdiskon==0)
				$totaltagihanakhir = $totaltagihan+$ongkoskirim;
			else
				$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;

			$sql = "select id,invoiceid,metode_pembayaran,bank_tujuan,total_bayar,jumlah_bayar,bank_dari, norek, atas_nama, kartukredit, tanggalbayar, status, flag from $nama_tabel  where invoiceid='$invoiceid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
				$id 				= $row['id'];
				$bank_tujuan 		= $row['bank_tujuan'];
				$bank_dari 			= $row['bank_dari'];
				$norek 				= $row['norek'];
				$atas_nama 			= $row['atas_nama'];
				$jumlah_bayar 		= "Rp. ".number_format($row['jumlah_bayar'],0,".",".").",-";
				$status			 	= $row['status'];
				$total_bayar 		= "Rp. ".number_format($row['totaltagihanakhir'],0,".",".").",-";
				$tgl_bayar 			= $row['tgl_bayar'];
				$tanggal_bayar		= tanggaltok($tanggalbayar);
				$metode_pembayaran 	= $row['metode_pembayaran'];
			
				$perintah 	= "select * from tbl_norek where status='1'";
				$hasil 		= sql($perintah);
				while ($data=sql_fetch_data($hasil)) 
				{
					$id			= $data['id'];
					$id_bank	= $data['bank'];
					$norek		= $data['norek'];
					
					$sql8	= "select namabank from tbl_bank where bankid='$id_bank'";
					$res8	= sql($sql8);
					$row8	= sql_fetch_data($res8);
					$namabank	= $row8['namabank'];
					
					sql_free_result($res8);
					
					$nama = "$namabank ($norek)";
					
					$bank[$id] = array("id"=>$id, "nama"=>$nama, "id_bank"=>$id_bank);
				}
				sql_free_result($hasil);
			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
						$( "#tanggal" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true
						});

				});
				function popinvoiceid()
				{
					var res = window.showModalDialog("index.php?pop=1&kanal=konfirmasi&aksi=popinvoiceid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
					if (res == undefined){
						res = window.returnValue;
						console.log(res);
					}
					if (res != null && res != undefined)
					{
						console.log(res);
						document.getElementById("invoiceid").value 		= res.invoiceid;
						document.getElementById("invoiceid_text").value 	= res.invoiceid;
						document.getElementById("total").value 			= res.total;
						document.getElementById("total_text").innerHTML	= "<strong> "+ res.total_text +"</strong>";
					}
					return false;
				}
			</script>

			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Konfirmasi</th>
				</tr>
				<tr> 
					<td valign="top">Invoice Number</td> 
					<td align="left">
						<?php if(!empty($invoiceid)) { ?>
                        <input name="invoiceid" value="<?php echo $invoiceid ?>" type="text" size="40" id="invoiceid" class="validate[required]" />
                        <?php } else { ?>
                        <input name="invoiceid" type="hidden" size="20" value="" id="invoiceid" />
                        <input name="invoiceid_text" type="text" size="30" value="" id="invoiceid_text"  onclick="return popinvoice()"> 
                        <a href="#" class="apop" onclick="popinvoiceid()">..</a>
                        <!-- <input name="invoice" value="" type="text" size="20" id="invoice" class="validate[required]"  /> -->
                        <?php } ?>
                    </td>
				</tr>
				<tr> 
					<td valign="top">Bank Tujuan Transfer</td> 
					<td align="left">
	                    <select name="bank" id="bank">
							<?php 
							foreach ($bank as $p) {?>
								<option value="<?php echo $p[id]?>"><?php echo ($p[nama]); ?></option>
							<?php }
							?>
                        </select>
					</td>
				</tr>
				<tr> 
					<td valign="top">Total Belanja</td> 
					<td align="left">
                    	<div id="total_text"><strong><?php echo "Rp. ".number_format($totaltagihanakhir,0,".","."); ?></strong></div>
                    	<input name="total" value="<?php echo $totaltagihanakhir ?>" type="hidden" size="40" id="total" class="validate[required]"  />
						<!-- <input name="total" value="" type="text" size="20" id="total" class="validate[required]"  /> -->
					</td>
				</tr>
				<tr> 
					<td valign="top"> Jumlah Bayar</td> 
					<td align="left"><input name="jumlah_bayar" value="" type="text" size="20" id="jumlah_bayar" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td>Tanggal</td>
					<td><input name="tanggal" type="text" size="20" value="" id="tanggal" class="validate[required]" /><em>Klik icon gambar, format : yyyy-mm-dd</em></td>
				</tr>
				<tr> 
					<td valign="top"> Bank Pengirim</td> 
					<td align="left"><input name="daribank" value="" type="text" size="20" id="daribank" class="validate[required]"  /></td>
				</tr>
				<tr> 
					<td valign="top"> Nomor Rekening</td> 
					<td align="left"><input name="norek" value="" type="text" size="20" id="norek" class="validate[required]"  /></td>
				</tr>
				<tr> 
					<td valign="top"> Atas Nama</td> 
					<td align="left"><input name="atas_nama" value="" type="text" size="20" id="atas_nama" class="validate[required]"  /></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}

	if($aksi=="saveshipping")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$invoiceid			= $_POST['invoice'];
			$ids				= $_POST['ids'];
			$warna				= $_POST['warna'];
			$status				= $_POST['status'];
			$no_resi			= cleaninsert($_POST['no_resi']);
			$note_konfirmasi	= cleaninsert($_POST['note_konfirmasi']);
			$note_admin			= cleaninsert($_POST['note_admin']);
			$nama				= $_POST['nama'];
			$email				= $_POST['email'];
			$alamatpengiriman	= $_POST['alamatpengiriman'];
			$namaagen			= $_POST['namaagen'];
			$produkpostid	= sql_get_var("select produkpostid from tbl_transaksi_belanja where invoice='$invoiceid'");
			$stock	= sql_get_var("select stock from tbl_product_stock where produkpostid='$produkpostid'");
			$qty	= sql_get_var("select qty from tbl_transaksi_belanja where invoice='$invoiceid'");
			$stock_skrg	= $stock-$qty;

			$perintah3	= "update tbl_product_stock set stock='$stock_skrg', update_date='$date', update_userid='$cuserid' where produkpostid='$produkpostid'";
			$hasil3		= sql($perintah3);
			
			$perintah3	= "update tbl_transaksi_konfirmasi set status='$status', note_konfirmasi='$note_konfirmasi', note_admin='$note_admin', no_resi='$no_resi', 
						update_date='$date', update_userid='$cuserid' where invoice='$invoiceid'";
			$hasil3		= sql($perintah3);

			if($hasil3)
			{   
				$message	= "
					Dear $nama,<br><br />
					
					Terimakasih atas transaksi yang telah dilakukan untuk nomor invoice <strong>#$invoiceid</strong><br />
					Kami telah melakukan pengiriman barang atas transaksi yang Anda lakukan.<br /><br />

					Kami akan segera melakukan pengiriman untuk pesanan Anda ke alamat :<br />

					$alamatpengiriman<br /><br />
					
					Nomor Resi Pengiriman : $no_resi<br />
					Agen Pengiriman : $namaagen<br /><br />

					Terimakasih atas kepercayaan Anda berbelanja di $title. Kami senang dapat melayani Anda.
					Semoga dilain waktu Kami bisa kembali mendapatkan kepercayaan sebagai tempat belanja Anda.<br /><br />
					
					Regards,<br />
					$owner
				";

				//kirim email ke admin
				$to 		= "$email";
				$from 		= "$support_email";
				$subject 	= "$title, Informasi Pengiriman Barang Invoice #$invoiceid";
				$message 	= $message;
				$headers 	= "From : $owner";
				
				$sendmail	= sendmail($judulpesan,$to,$subject,$message2,$message);
				
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Perubahan Status Pengiriman data Transaksi dengan Invoice $invoice",$uri,$ip);
				
				$msg = base64_encode("Berhasil mengubah data dengan ID $invoice");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="shipping")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$invoice	= $_GET['invoice'];
			
			$sql = "select id,userid,invoice,metode_pembayaran,bank_tujuan,total_bayar,jumlah_bayar,tgl_bayar,bank_dari,norek,atas_nama,pesan,status_konfirmasi,nohp,
					ongkos_kirim,kotaid,kode_voucher,email,alamat,nama,note_konfirmasi,subtotal,diskon,agen,ongkosinfo,berat from $nama_tabel where invoice='$invoice'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
				$id 				= $row['id'];
				$userid 			= $row['userid'];
				$bank_tujuan 		= $row['bank_tujuan'];
				$bank_dari 			= $row['bank_dari'];
				$norek 				= $row['norek'];
				$atas_nama 			= $row['atas_nama'];
				$jumlah_bayar 		= "IDR ".number_format($row['jumlah_bayar'],0,".",".");
				$status_konfirmasi 	= $row['status_konfirmasi'];
				$nama 				= $row['nama'];
				$email 				= $row['email'];
				$invoice 			= $row['invoice'];
				$tipe_pembayaran 	= $row['tipe_pembayaran'];
				$total_bayar 		= "IDR ".number_format($row['total_bayar'],0,".",".");
				$tgl_bayar 			= $row['tgl_bayar'];
				$tanggal_bayar		= tanggaltok($tgl_bayar);
				$alamat11 			= $row['alamat'];
				$kode_voucher 		= $row['kode_voucher'];
				$ongkos_kirim 		= "IDR ". number_format($row['ongkos_kirim'],0,".",".");
				$pesan 				= $row['pesan'];
				$nohp 				= $row['nohp'];
				$metode_pembayaran 	= $row['metode_pembayaran'];
				$kotaid 			= $row['kotaid'];
				$kota				= getNamaKota($kotaid);
				$note_konfirmasi	= $row['note_konfirmasi'];
				$subtotal			= "IDR ". number_format($row['subtotal'],0,".",".");
				$ongkos_kirim		= $row['ongkos_kirim'];
				$diskon				= $row['diskon'];
				$agen				= $row['agen'];
				$service			= $row['ongkosinfo'];
				$totberat			= ceil($row['berat']/1000);

				$datauser			= getProfile($userid);
				$fname				= $datauser['userfullname'];
			sql_free_result($hsl);
			
			// kueri agen pengiriman
			$namaagen 	= sql_get_var("select nama from tbl_agen where agenid='$agen'");
			// $namaagen 	= sql_get_var("select nama from tbl_agen where agenid='$agen'");
			
			// kueri ongkos service	
			// $service	= sql_get_var("select service from tbl_ongkos where id='$ongkosid'");
			
			if($status_konfirmasi=="1") $stats = "Received";
			else if($status_konfirmasi=="2") $stats	= "Canceled";
			else 
			{
				$stats = "Pending";
			}
			
			$nama_bank 			= sql_get_var("select namabank from tbl_bank where bankid='$bank_tujuan'");
			?>
			<style> .inputbiasa { margin-bottom:5px !important; }</style>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
						$( "#tanggal" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true
						});
				});
				function popdetail(invoice)
				{
					window.showModalDialog("index.php?pop=1&kanal=konfirmasi&aksi=popdetail&invoice="+invoice,"", "dialogWidth:900px;dialogHeight:600px;dialogTop:100px;")
				}
			</script>
            
                <form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
                <input type="hidden" name="aksi" value="saveshipping">
                <input type="hidden" name="invoice" id="invoice" value="<?php echo $invoice?>" />
                <input type="hidden" name="nama" id="nama" value="<?php echo $nama?>" />
                <input type="hidden" name="email" id="email" value="<?php echo $email?>" />
                <input type="hidden" name="namaagen" id="namaagen" value="<?php echo "$namaagen - $service"?>" />
                <input type="hidden" name="alamatpengiriman" id="alamatpengiriman" value="<?php echo $alamat11?>" />
                <table border="0" class="tabel-cms" width="100%">
                    <tr>
                        <th colspan="2">Pengiriman Barang</th>
                    </tr>
                    <tr> 
                        <td valign="top" width="15%">Id Data</td> 
                        <td align="left">#<?php echo $id ?></td>
                    </tr>
                    <tr> 
                        <td valign="top">Invoice Number</td> 
                        <td align="left"><strong><?php echo $invoice?></strong></td>
                        <!-- <a onclick="popdetail(invoice.value)"></a> -->
                    </tr>
                    <tr> 
                        <td valign="top">Metode Pembayaran</td> 
                        <td align="left"><?php echo $metode_pembayaran ?></td>
                    </tr>
                    <tr> 
                        <td valign="top">Bank Tujuan</td> 
                        <td align="left"><?php echo $nama_bank ?></td>
                    </tr>
                    <tr> 
                        <td valign="top">Total Belanja</td> 
                        <td align="left"><?php echo $total_bayar?></td>
                    </tr>
                    <tr> 
                        <td valign="top">Jumlah Bayar</td> 
                        <td align="left"><?php echo $jumlah_bayar?></td>
                    </tr>
                    <tr> 
                        <td>Tanggal</td>
                        <td><?php echo $tanggal_bayar?></td>
                    </tr>
                    <tr> 
                        <td valign="top">Atas Nama</td> 
                        <td align="left"><?php echo $atas_nama?></td>
                    </tr>
                    <tr> 
                        <td >Pesan</td>
                        <td ><?php echo $pesan?></td>
                    </tr>
                    <tr> 
                        <td valign="top">Status Konfirmasi</td> 
                        <td align="left"><?php echo $stats?></td>
                    </tr>
                    <tr> 
                        <td valign="top">Status Pengiriman</td> 
                        <td align="left">
                            <input type="checkbox" name="status" id="status" value="3" /> Terkirim
                        </td>
                    </tr>
                    <tr> 
                        <td >Nomor Resi Pengiriman</td>
                        <td ><textarea name="no_resi" cols="76" rows="5" id="no_resi" class="validate[required]"><?php echo $no_resi?></textarea></td>
                    </tr>
                    <tr> 
                        <td >Catatan untuk Pembeli</td>
                        <td ><textarea name="note_konfirmasi" cols="76" rows="5" id="note_konfirmasi" class=""><?php echo $note_konfirmasi?></textarea></td>
                    </tr>
                    <tr> 
                        <td >Catatan untuk Admin</td>
                        <td ><textarea name="note_admin" cols="76" rows="5" id="note_admin" class=""><?php echo $note_admin?></textarea></td>
                    </tr>
                    <tr> 
                        <td valign="top">&nbsp;</td>
                        <td align="left">
                            <input type="submit" name="Submit" value="Simpan" />
                            <input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
                        </td>
                    </tr>
                </table>
                </form>
            <?php 	
		}
	}

	//Popup Produk
	if($aksi=="popinvoiceid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$produkpostid	= $_GET['produkpostid'];
			$warna			= base64_decode($_GET['warna']);
			?>
            	<script type="text/javascript">
				function pushdata(invoiceid,total,total_text)
				{
					var res = new Object();
					res.invoiceid 	= invoiceid;
					res.total 		= total;
					res.total_text 	= total_text;
					
					window.returnValue = res;
                    if (window.opener) {
						window.opener.returnValue = res;
					}
                    window.returnValue = res;
                    self.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("create_date","Tanggal Transaksi","date","date","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from tbl_transaksi where status='1' $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			
			if($tot>0)
			{
				cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
				
				//Orderring
				$order = getorder("id","asc",$pageparam);
				$parorder = $order[0];
				$urlorder = $order[1];
			
				$sql 	= "select transaksiid,invoiceid,totaltagihan,totaltagihanafterdiskon,ongkoskirim,userid from tbl_transaksi where status='1'";
				$hsl = sql($sql);
				$i = 1;
				$a = 1;
				
				print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
				print("<tr><th width=10%>Nomor</th>\n");
				print("<th width=20%><a href=\"$urlorder&order=invoice\" title=\"Urutkan\">Nomor Invoice</a></th>\n");
				print("<th width=30%><a href=\"$urlorder&order=userid\" title=\"Urutkan\">Nama Pembeli</a></th>\n");
				print("<th width=20%><a href=\"$urlorder&order=total_bayar\" title=\"Urutkan\">Total Belanja</a></th>\n");
				print("<th width=10% align=center><b>Select</b></th></tr></thead>");
	
				while ($row = sql_fetch_data($hsl))
				{
					$transaksiid			= $row['transaksiid'];
					$invoiceid				= $row['invoiceid'];
					$totaltagihan			= $row['totaltagihan'];
					$totaltagihanafterdiskon= $row['totaltagihanafterdiskon'];
					$ongkoskirim			= $row['ongkoskirim'];
					$userid					= $row['userid'];
					
					if($totaltagihanafterdiskon==0)
						$totaltagihanakhir = $totaltagihan+$ongkoskirim;
					else
						$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
						
					$total_bayar1	= "IDR ".number_format($totaltagihanakhir,0,".",".");
					
					$nama_pembeli	= sql_get_var("select userfullname from tbl_member where userid='$userid'");
					
					print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
						<td  valign=top class=judul>$invoiceid</td>
						<td  valign=top class=judul>$nama_pembeli</td>
						<td  valign=top class=judul>$total_bayar1</td>\n");
					print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$invoiceid','$totaltagihanakhir','$total_bayar1');\">Select</button>");
					print("</td></tr>");
	
					$i %= 2;
					$i++;
					$a++;
					$ord++;
				}
				print("</table><br clear='all'>");
				
				cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			}
			else
			{
				echo "<p align=center> Tidak ada transaksi baru. </p>";
			}
		}
	} //EndView 
}

?>