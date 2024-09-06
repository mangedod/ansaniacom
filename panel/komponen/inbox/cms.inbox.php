<?php 
//Variable halaman ini
$nama_tabel		= "tbl_contact";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];


//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];
 
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
			$mainmenu[] = array("Lihat Kontak Masuk","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama","str","text","$data");
			$cari[] = array("email","Alamat Email","str","text","$data");
			$cari[] = array("pesan","Isi Kontak Masuk","str","text","$data");
			$cari[] = array("create_date","Tanggal","date","date","$data");
			
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("id","desc",$pageparam,$param);
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
			
			$sql = "select id,nama,email,ip,pesan,replied from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm"; 
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=60%>Isi</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=replied\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id       = $row['id'];
				$nama     = $row['nama'];
				$email    = $row['email'];
				$ip       = $row['ip'];
				$komentar = nl2br($row['pesan']);
				$replied  = $row['replied'];
				
				if($replied=="1") $reply ="Replied";
				 else $reply ="Unreplied";
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top><strong>$nama</strong><br />$email<br />$ip</td>
					<td  valign=top>$komentar</td>\n
					<td  valign=top >$reply</td>");
					
				print("<td>");
				
				if($replied==0) $acc[] = array("Reply","push","$alamat&aksi=reply&id=$id&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&id=$id&hlm=$hlm");
								
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

	// Balas email 
	if($aksi=="reply")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
		{
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);

			$sql   = "SELECT nama,email from $nama_tabel WHERE id='$id'";
			$hsl   = sql($sql);
			$row   = sql_fetch_data($hsl);
			$email = $row['email'];
			$nama  = $row['nama'];
			?>
			<!-- <div style="background: #f2dede; border: 1px solid #dcaeae; padding: 15px; text-align: center; color: #ec5c5c; font-weight: bold;">
				MAAF, SEMENTARA FITUR REPLY EMAIL BELUM BISA DIGUNAKAN. TERIMAKASIH ATAS KESABARAN ANDA.
			</div> -->
			<script src="librari/ckeditor/ckeditor.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script> 
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="sendemail">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Reply</th>
				</tr>
				<tr> 
					<td width="15%">Nama Tujuan</td>
					<td ><input name="nama" type="text" size="70" value="<?php echo $nama;?>" id="nama" readonly="readonly" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td width="15%">Tujuan</td>
					<td ><input name="email" type="text" size="70" value="<?php echo $email;?>" id="email" readonly="readonly" class="validate[required]" /></td>
				</tr>
					<td width="15%">Judul</td>
					<td ><input name="judul" type="text" size="70" value="" id="judul" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Isi</td>
					<td ><textarea name="isi" cols="70" rows="10" id="isi" class="ckeditor validate[required]" ></textarea></td>
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

	// send email
	if($aksi=="sendemail")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
		{
			$id      = $_POST['id'];
			$tujuan  = $_POST['email'];
			$nama    = $_POST['nama'];
			$judul   = $_POST['judul'];
			$isi     = cleaninsert($_POST['isi']);
			$isihtml = $_POST['isi'];

			$hasil = sendmail($nama,$tujuan,$judul,$isi,$isihtml);
			// die();
			if($hasil)
			{   
				$sql = "UPDATE $nama_tabel SET replied='1' WHERE id='$id'";
				$hsl = sql($sql);

				$msg = base64_encode("Berhasil membalas email");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Email tidak dapat dikirim, silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
	//Hapus
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id = $_GET['id'];
			$perintah 	= "select gambar,gambar1 from $nama_tabel where id='$id'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar 	= $row['gambar'];
			$gambar1 	= $row['gambar1'];
			
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
			if(!empty($gambar1)) unlink("$pathfile$kanal/$gambar1");
				

			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
}

?>