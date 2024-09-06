<?php 
//Variable halaman ini
$nama_tabel		= "tbl_bank";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 73;
$gambars_maxh = 73;


//Variable Umum
if(isset($_POST['bankid'])) $bankid = $_POST['bankid'];
 else $bankid = $_GET['bankid'];
 
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Album
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Bank","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Bank","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
	
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("namabank","Nama Bank","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("bankid","desc",$pageparam,$param);
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
			
			$sql = "select bankid,namabank,logobank from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=55%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Bank</a></th>\n");
			print("<th width=10%>Logo</th>");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama 	= $row['namabank'];
				$logo 	= $row['logobank'];
				$bankid= $row['bankid'];
				
				if(empty($logo)) $logo = "Masih kosong";
				else $logo = "<img src=\"../gambar/$kanal/$logo\" style=\"width:50px\" alt=\"\" />";
				
				print("<tr class=\"row$i\"><td height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b>$nama</b><br />$ringkas</td>\n");
				print("<td valign=top class=hitam>$logo</td>\n");
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&bankid=$bankid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&bankid=$bankid&hlm=$hlm");
								
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
	
	//HapusAlbum
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$bankid = $_GET['bankid'];

			$perintah = "delete from $nama_tabel where bankid='$bankid'";
			$hasil = sql($perintah);
			
			$perintah 	= "select logobank from $nama_tabel where bankid='$bankid'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$logo 	= $row['logobank'];
				
			if(!empty($logo)) unlink("$pathfile$kanal/$logo");
					
			
			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penghapusan data Bank dengan ID $bankid",$uri,$ip); 
				  
				$msg = base64_encode("Success mengapus menu dengan Bank ID $bankid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	//SaveTambahAlbum
	if($aksi=="savetambah")
	{
		
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama = $_POST['nama'];
			$nama = cleaninsert($nama);
			$alias = getalias($nama);
			
			$newbankid = newid("bankid",$nama_tabel);
			
			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$newbankid.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$fgambar = ",logobank";
					$vgambar = ",'$namagambars'";
				}
			}
			
			$perintah = "INSERT INTO $nama_tabel (`bankid`,`namabank`,create_date,create_userid $fgambar) 
						VALUES ('$newbankid','$nama','$date','$cuserid' $vgambar)";
			$hasil = sql($perintah);
			if($hasil)
			{
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penambahan data Bank dengan ID $newbankid",$uri,$ip);    
				$msg = base64_encode("Berhasil ditambahkan Bank barudengan id = $newbankid");
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
	
	//TambahAlbum
	if($aksi=="tambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popbagid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=bagian&aksi=popbagid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("bagid").value 		= res.bagid;
							document.getElementById("bagid_text").value 	= res.bagid_text;
						}
						return false;
				}
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Bank</th>
				</tr>
				<tr> 
					<td valign="top">Nama Bank</td>
					<td align="left"><input name="nama" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Logo</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Album" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveEditAlbum
	if($aksi=="saveedit")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$nama = $_POST['nama'];
			$nama = cleaninsert($nama);
			$alias = getalias($nama);
			
			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$bankid.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$vgambar = ",logobank='$namagambars'";
				}
			}
			
			$perintah = "update $nama_tabel set namabank='$nama' $vgambar where bankid='$bankid'";
			$hasil = sql($perintah);
			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Bank dengan ID $bankid",$uri,$ip);  
				$msg = base64_encode("Berhasil mengubah menu $nama dengan ID $bankid");
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
	//EditAlbum
	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select namabank,bankid from $nama_tabel  where bankid='$bankid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$nama 		= $row['namabank'];
			$bankid 	= $row['bankid'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popbagid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=bagian&aksi=popbagid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("bagid").value 		= res.bagid;
							document.getElementById("bagid_text").value 	= res.bagid_text;
						}
						return false;
				}
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="bankid" value="<?php echo $bankid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Bank</th>
				</tr>
				<tr> 
					<td valign="top">Nama Bank</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Logo</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Bank" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}	
	
}

?>