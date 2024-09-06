<?php 
//Variable halaman ini
$nama_tabel		= "tbl_transaksi_channel";
$nama_tabel1	= "tbl_transaksi_channel_detail";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['gid'])) $gid = $_POST['gid'];
 else $gid = $_GET['gid'];
 if(isset($_POST['transaksiid'])) $transaksiid= $_POST['transaksiid'];
 else $transaksiid= $_GET['transaksiid'];


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
			$mainmenu[] = array("Tambah Transaksi","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("invoiceid","Invoice","int","text","$data");
			
			$cari[] = array("alamatpengiriman","Alamat","str","text","$data");
			$cari[] = array("email","Email","str","text","$data");
			
			$dataselect1[] = array("Pickup Point","Pickup Point(Diambil Sendiri)");
			

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
			
			$sql = "select transaksiid, invoiceid, totaltagihan, namalengkap, alamatpengiriman, email, ongkoskirim,status,tanggaltransaksi,channelid from $nama_tabel  where 1  $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th>No</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=invoiceid\" title=\"Urutkan\">Invoice</a></th>\n");
			print("<th width=30%>Informasi Pemesan</th>");
			print("<th width=10%><a href=\"$urlorder&order=totaltagihan\" title=\"Urutkan\">Subtotal</a></th>");
			print("<th width=10%>Ongkos Kirim</th>");
			print("<th width=10%><a href=\"$urlorder&order=totaltagihan\" title=\"Urutkan\">Total</a></th>");
			print("<th width=20%><a href=\"$urlorder&order=tanggaltransaksi\" title=\"Urutkan\">Tanggal Pesan</a></th>");
			print("<th width=4%>Channel</th>");
			print("<th width=4% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$transaksiid             = $row['transaksiid'];
				$invoiceid               = $row['invoiceid'];
				$totaltagihan            = $row['totaltagihan'];
				$namalengkap             = $row['namalengkap'];
				$alamatpengiriman        = $row['alamatpengiriman'];
				$email                   = $row['email'];
				$ongkoskirim             = $row['ongkoskirim'];
				$channelid             = $row['channelid'];
				$tanggaltransaksi        = tanggal($row['tanggaltransaksi']);
				
				$totaltagihanakhir = $totaltagihan+$ongkoskirim;
				$ongkos_kirim		= "Rp. ". number_format($ongkoskirim,0,".",".");	
				$total_bayar 		= "Rp. ".number_format($totaltagihanakhir,0,".",".");
				$totaltagihan 		= "Rp. ".number_format($totaltagihan,0,".",".");
				
				//kota
				$kota 		= sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
				$channel	= sql_get_var("select nama from tbl_channel where channelid='$channelid'");
				$kodeinvoice= base64_encode($invoiceid);
				
				print("<tr class=\"row$i\"><td height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top><a href=\"$alamat&aksi=detail&transaksiid=$transaksiid&hlm=$hlm\">&nbsp;<b>$invoiceid</b></a></td>
					<td  valign=top class=judul>$namalengkap<br>$alamatpengiriman<br>$telp</td>\n");
				print("<td valign=top class=hitam>$totaltagihan</td>\n");
				print("<td valign=top class=hitam>$ongkos_kirim</td>\n");
				print("<td valign=top class=hitam>$total_bayar</td>\n");
				print("<td valign=top class=hitam>$tanggaltransaksi</td>\n");
				print("<td valign=top class=hitam>$channel</td>\n");
				print("<td>");
				
				$acc[] = array("Detail","detail","$alamat&aksi=detail&transaksiid=$transaksiid&hlm=$hlm");
				$acc[] = array("Cetak Invoice","detail","/panel/komponen/cetakinvoice/cetak-manual.php?kodeinvoice=$kodeinvoice");
				
								
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
			$transaksiid	= $_GET['transaksiid'];
			?>
			<script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function hitungtotal1(){

					var a = $("#ongkoskirim").val();
					var z = eval(a.replace(/\./g,""));
					var b = $("#subtotal").val();
					var x = eval(b.replace(/\./g,""));
					var c = eval(z+x);
					$("#total_bayar").val(c);
				   }
			</script>
			<?php
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Item","tambah","$alamat&aksi=additem&transaksiid=$transaksiid");
			mainaction($mainmenu,$param);
			
			$sql1	= "select transaksiid, invoiceid, totaltagihan, namalengkap, alamatpengiriman,ongkoskirim, status,email, tanggaltransaksi from $nama_tabel 
				where transaksiid='$transaksiid'";
			$hsl1 = sql($sql1);
			$row1 = sql_fetch_data($hsl1);
			
			$transaksiid             = $row1['transaksiid'];
			$invoiceid               = $row1['invoiceid'];
			$totaltagihan            = $row1['totaltagihan'];
			$namalengkap             = $row1['namalengkap'];
			$alamatpengiriman        = $row1['alamatpengiriman'];
			$ongkoskirim             = $row1['ongkoskirim'];
			$status                  = $row1['status'];
			$email                   = $row1['email'];
			$tanggaltransaksi        = tanggal($row1['tanggaltransaksi']);
			
			$totaltagihanakhir = $totaltagihan+$ongkoskirim;
				
				
			$ongkoskirim2		= "IDR. ". number_format($ongkoskirim,0,".",".");	
			$total_bayar 		= "IDR. ".number_format($totaltagihanakhir,0,".",".");
			$totaltagihan 		= "IDR. ".number_format($totaltagihan,0,".",".");
			$total_diskon 		= "IDR. ".number_format($totaldiskon,0,".",".");
			
			$kodeinvoice = base64_encode($invoiceid);
			

			$sql	= "select transaksidetailid,produkpostid,jumlah,matauang,harga,totalharga,berat from $nama_tabel1 where transaksiid='$transaksiid'";
			$hsl = sql($sql);
			$jumlah = sql_num_rows($hsl);
			$i = 1;
			$subtotal=0;
			$a = 1;
			if($jumlah >0)
			{
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
					print("<td valign=top class=hitam>$total</td></tr>\n");
					
					$subtotal=$subtotal+$totalharga;
	
					$i %= 2;
					$i++;
					$a++;
					$ord++;
				}
				print("</table>");
				$all=$subtotal+$ongkoskirim;
			?>
            <form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="update">
            <input type="hidden" name="transaksiid" value="<?php echo $transaksiid;?>" />
            <table border="0" class="tabel-cms" width="100%">

                <tr>
					<th colspan="2">Total Pembelian</th>
				</tr>
                <tr>
					<td valign="top">Subtotal</td>
					<td align="left"><input type="text" name="subtotal" value="<?php echo number_format($subtotal,0,".",".");?>" id="subtotal" /></td>
				</tr>
				<tr> 
					<td valign="top">Ongkos Kirim</td>
					<td align="left"><input type="text" name="ongkoskirim" value="<?php echo number_format($ongkoskirim,0,".",".")?>" id="ongkoskirim" onKeyUp="return hitungtotal1(this.value,subtotal);"/></td>
				</tr>
                <tr> 
					<td valign="top">Total</td>
					<td align="left"><input type="text" name="total_bayar" value="<?php echo number_format($all,0,".",".")?>" id="total_bayar" /></td>
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
			else
			{
			?>
            
            <?php
			}
		}
	}
	
	//SaveTambah
	if($aksi=="update")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$transaksiid	= $_POST['transaksiid'];
			$subtotal	= str_replace(".","",$_POST['subtotal']);
			$ongkoskirim	= str_replace(".","",$_POST['ongkoskirim']);
			$total_bayar	= $_POST['total_bayar'];
			

			$perintah = "update  $nama_tabel set ongkoskirim='$ongkoskirim',totaltagihan='$subtotal',totalinvoice='$total_bayar' where transaksiid='$transaksiid'";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$update = sql("update tbl_last set tanggal=now() where kanal='$kanal'");
				$msg = base64_encode("Berhasil merubah data transaksi.");
				header("location: $alamat&aksi=detail&transaksiid=$transaksiid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&transaksiid=$transaksiid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//Tambah
	if($aksi == "tambah")
	{
		if(!$oto['add']) { echo $error['add']; } else 
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$count = sql_get_var("select count(*) as jml from $nama_tabel where 1");
			
			if($count>0)
				$id=$count+1;
			else
				$id=1;
			
			if($id < 10  )
			   $invoiceid	= "ANZCH"."00000". $id;
			elseif($id < 100 )
				$invoiceid	= "ANZCH"."0000". $directory;
			elseif($id < 1000 )
				$invoiceid	= "ANZCH"."000" . $id;
			elseif($id < 10000 )
				$invoiceid	= "ANZCH"."00" . $id;
			elseif($id < 100000 )
				$invoiceid	= "ANZCH"."0" . $id;
					
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
					$('#tgl').datepicker({
						  showOn: "button",
						  buttonImage: "./template/images/calendar.gif",
						  buttonImageOnly: true,
						  dateFormat  : 'yy-mm-dd',
						  changeMonth : true,
						  changeYear  : true
						});
				 });
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data Transaksi</th>
				</tr>
				<tr> 
					<td>No. Invoice</td>
					<td><input name="invoiceid" type="text" size="40" value="<?php echo $invoiceid;?>" id="invoice" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Tanggal Transaksi</td>
					<td><input name="tanggal" type="text" size="40" value="<?php echo $now;?>" id="tgl" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Channel</td>
					<td>
						<select name="channelid" id="channelid">
                        	<option value="">Pilih Channel</option>
                        	<?php
								$perintah="select channelid,nama from tbl_channel where 1";
								$hasil=sql($perintah);
								while($data=sql_fetch_data($hasil))
								{
									$channelid	= $data['channelid'];
									$nama		= $data['nama'];
									
									echo"<option value=$channelid>$nama</option>";
								}
                            ?>
                        </select>
                    </td>
				</tr>
                <tr>
                	<th colspan="2">Data Pembeli</h>
                </tr>
				<tr> 
					<td>Nama</td>
					<td><input name="nama" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td>Alamat</td>
					<td><textarea name="alamats" id="alamats" cols="40" rows="2" class="validate[required]"></textarea></td>
				</tr>
				<tr> 
					<td>Telepon</td>
					<td><input name="tlp" type="text" size="40" value="" id="tlp" class="validate[required]" /></td>
				</tr>
                <!--<tr>
                	<th colspan="2">Rincian Biaya</h>
                </tr>
                <tr> 
					<td>Ongkos Kirim</td>
					<td><input name="ongkir" type="text" size="40" value="" id="ongkir" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Asuransi</td>
					<td><input name="asuransi" type="text" size="40" value="" id="asuransi" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Subtotal</td>
					<td><input name="subtotal" type="text" size="40" value="" id="subtotal" class="validate[required]" /></td>
				</tr>-->
                
                
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
	
	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$invoiceid	= $_POST['invoiceid'];
			$channelid	= $_POST['channelid'];
			$tanggal	= $_POST['tanggal'];
			
			$nama    = cleaninsert($_POST['nama']);
			$alamats	= cleaninsert($_POST['alamats']);
			$telp	= cleaninsert($_POST['telp']);
			
			$new = newid("transaksiid",$nama_tabel);

			$perintah = "insert into $nama_tabel(transaksiid,tanggaltransaksi,namalengkap,alamatpengiriman,invoiceid,channelid,create_date,create_userid) 
						values ('$new','$tanggal','$nama','$alamats','$invoiceid','$channelid','$date','$cuserid')";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$update = sql("update tbl_last set tanggal=now() where kanal='$kanal'");
				$msg = base64_encode("Berhasil ditambahkan invoice baru. Klik Lihat Produk untuk melihat dan menambahkan data produk yang dibeli.");
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
	
	//Tambah
	if($aksi == "additem")
	{
		if(!$oto['add']) { echo $error['add']; } else 
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$invoiceid	= sql_get_var("select invoiceid from tbl_transaksi_channel where transaksiid='$transaksiid'");
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popprodukpostid() {
sList = window.open("index.php?pop=1&kanal=produk&aksi=popupprodukpostid", "list", "width=600,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=1");
}
				function hitungtotal(){

					var a = $("#qty").val();
					var z = a.replace(/\./g,"");
					var b = $("#produkpostid_harga").val();
					var x = b.replace(/\./g,"");
					var c = z*x;
					$("#subtotal").val(c);
				   }
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahitem">
			<input type="hidden" name="invoiceid" value="<?php echo $invoiceid;?>">
			<input type="hidden" name="transaksiid" value="<?php echo $transaksiid;?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Item</th>
				</tr>
				<tr> 
					<td>Nama Item</td>
					<td>
                    	<input name="produkpostid" id="produkpostid" type="hidden" value="" />
                        <input name="produkpostid_text" id="produkpostid_text" type="text" size="40" value="" class="validate[required]" /> 
                        <a href="#" class="apop" onclick="popprodukpostid()">..</a>
                    </td>
				</tr>
                <tr> 
					<td>Jumlah</td>
					<td><input name="qty" type="text" size="40" value="" id="qty" class="validate[required]" onKeyUp="return hitungtotal(this.value,qty);" /></td>
				</tr>
                <tr> 
					<td>Harga</td>
					<td>
						<input name="harga" type="text" size="40" value="" id="produkpostid_harga" class="validate[required]" onKeyUp="return hitungtotal(this.value,qty);" />
                    </td>
				</tr>
				<tr> 
					<td>Subtotal</td>
					<td><input name="subtotal" type="text" size="40" value="" id="subtotal" class="validate[required]" /></td>
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
	
	//SaveTambah
	if($aksi=="savetambahitem")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$invoiceid		= $_POST['invoiceid'];
			$transaksiid	= $_POST['transaksiid'];
			$produkpostid	= $_POST['produkpostid'];
			$qty			= $_POST['qty'];
			$harga			= $_POST['harga'];
			$subtotal		= $_POST['subtotal'];
			
			$nama    = cleaninsert($_POST['nama']);
			$alamats	= cleaninsert($_POST['alamats']);
			$telp	= cleaninsert($_POST['telp']);
			
			$new = newid("transksidetailid",$nama_tabel1);

			$perintah = "insert into $nama_tabel1(transaksiid,produkpostid,jumlah,matauang,harga,totalharga,create_date,create_userid) 
						values ('$transaksiid','$produkpostid','$qty','IDR','$harga','$subtotal','$date','$cuserid')";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$update = sql("update tbl_last set tanggal=now() where kanal='$kanal'");
				$msg = base64_encode("Berhasil manambahkan item baru.");
				header("location: $alamat&aksi=detail&transaksiid=$transaksiid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&transaksiid=$transaksiid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
}

?>