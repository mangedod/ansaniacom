<?php 
//Variable halaman ini
$nama_tabel		= "tbl_banner_space";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['spaceid'])) $spaceid = $_POST['spaceid'];
 else $spaceid = $_GET['spaceid'];
 
if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Data
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainData[] = array("Lihat Space","lihat","$alamat&aksi=view");
			$mainData[] = array("Tambah Space","tambah","$alamat&aksi=tambah");
			mainaction($mainData,$pageparam);
			
	
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("space","Space","str","text","$data");
			$cari[] = array("nama","Nama Space","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("spaceid","asc",$pageparam,$param);
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
			
			$sql = "select nama,spaceid,space,width,height,keterangan from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr>");
			print("<th width=5%><a href=\"$urlorder&order=spaceid\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Space</a></th>\n");
			print("<th width=45% ><a href=\"$urlorder&order=space\" title=\"Urutkan\">Nama Space</a></th>");
			print("<th width=10%><a href=\"$urlorder&order=width\" title=\"Urutkan\">Width</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=height\" title=\"Urutkan\">Height</a></th>\n");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$spaceid = $row['spaceid'];
				$space = $row['space'];
				$width = $row['width'];
				$height = $row['height'];
				$keterangan = $row['keterangan'];
				
				print("<tr class=\"row$i\">
					<td width=5% height=20 valign=top>&nbsp;<b>$spaceid</b></td>
					<td  valign=top class=judul>$space</a></td>\n");
				print("<td valign=top class=hitam><strong>$nama</strong><br />$keterangan</td>\n");
				print("<td valign=top class=hitam>$width</td>\n");
				print("<td valign=top class=hitam>$height</td>\n");
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&spaceid=$spaceid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&spaceid=$spaceid&hlm=$hlm");

								
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
	
	//HapusData
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$spaceid = $_GET['spaceid'];

			$perintah = "delete from $nama_tabel where spaceid='$spaceid'";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus Data dengan Data ID $spaceid");
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

	//SaveTambahData
	if($aksi=="savetambahData")
	{
		
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama = $_POST['nama'];
			$space = $_POST['space'];
			$width = $_POST['width'];
			$height = $_POST['height'];
			$keterangan = $_POST['keterangan'];
			$nama = cleaninsert($nama);
			$keterangan = cleaninsert($keterangan);
			
			$newid = newid("spaceid",$nama_tabel);
			
			$perintah = "INSERT INTO $nama_tabel (`spaceid`, `space`,`nama`,width,height,keterangan) VALUES ('$newid', '$space','$nama','$width','$height','$keterangan')";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan Data baru dengan id = $newid");
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
	
	//TambahData
	if($aksi=="tambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainData[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainData,$param);
			
			?>
            <script>	
				$(document).ready(function() {
					$("#Datafrm").validationEngine()
				});
			</script>
			<form method="post" name="Datafrm" id="Datafrm">
			<input type="hidden" name="aksi" value="savetambahData">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
				<tr> 
					<td valign="top">Space</td>
					<td align="left"><input name="space" type="text" size="40" value="" id="space" class="validate[required,custom[onlyLetterNumber]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Nama Space</td>
					<td align="left"><input name="nama" type="text"  size="60"  value=""  id="nama" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><textarea name="keterangan" id="keterangan" cols="60" rows="6" class="validate[required]"></textarea></td>
				</tr>
				<tr> 
					<td valign="top">Width</td>
					<td align="left"><input name="width" type="text"  size="10"  value=""  id="width" class="validate[required,custom[onlyNumberSp]]"/> pixel</td>
				</tr>
				<tr> 
					<td valign="top">Height</td>
					<td align="left"><input name="height" type="text"  size="10"  value=""  id="height" class="validate[required,custom[onlyNumberSp]]"/> pixel</td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Data" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveEditData
	if($aksi=="saveeditData")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$nama = $_POST['nama'];
			$space = $_POST['space'];
			$width = $_POST['width'];
			$height = $_POST['height'];
			$keterangan = $_POST['keterangan'];
			$nama = cleaninsert($nama);
			$keterangan = cleaninsert($keterangan);
			
			$perintah = "update $nama_tabel set nama='$nama',space='$space',keterangan='$keterangan',width='$width',height='$height' where spaceid='$spaceid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah Data $nama dengan ID $id");
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
	//EditData
	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainData[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainData,$param);
			
			$sql = "select nama,spaceid,space,width,keterangan,height from $nama_tabel  where spaceid='$spaceid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$nama = $row['nama'];
			$id = $row['id'];
			$url = $row['url'];
			$space = $row['space'];
			$keterangan = $row['keterangan'];
			$width = $row['width'];
			$height = $row['height'];
			
			
			?>
            <script>	
				$(document).ready(function() {
					$("#Datafrm").validationEngine()
				});
			</script>
			<form method="post" name="Datafrm" id="Datafrm">
			<input type="hidden" name="aksi" value="saveeditData">
            <input type="hidden" name="spaceid" value="<?php echo $spaceid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td valign="top">Space</td>
					<td align="left"><input name="space" type="text" size="40" value="<?php echo $space?>" id="space" class="validate[required,custom[onlyLetterNumber]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Nama Space</td>
					<td align="left"><input name="nama" type="text"  size="60"  value="<?php echo $nama?>"  id="nama" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><textarea name="keterangan" id="keterangan" cols="60" rows="6" class="validate[required]"><?php echo $keterangan?></textarea></td>
				</tr>
				<tr> 
					<td valign="top">Width</td>
					<td align="left"><input name="width" type="text"  size="10"  value="<?php echo $width?>"  id="width" class="validate[required,custom[onlyNumberSp]]"/> pixel</td>
				</tr>
				<tr> 
					<td valign="top">Height</td>
					<td align="left"><input name="height" type="text"  size="10"  value="<?php echo $height?>"  id="height" class="validate[required,custom[onlyNumberSp]]"/> pixel</td>
				</tr>
				<tr> 
					<td valign="top">Rubrik</td>
					<td align="left"><input name="space" value="<?php echo $space?>" type="text"  size="60"  id="space" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Data" />
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