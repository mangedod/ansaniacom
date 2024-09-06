<?php 
//Variable halaman ini
$nama_tabel		= "tbl_customdesigntesti";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 350;


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
			$mainmenu[] = array("Lihat Testimoni","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Testimoni","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");
			$cari[] = array("testimoni","Testimoni","str","text","$data");
			$cari[] = array("lengkap","Lengkap","str","text","$data");
			$cari[] = array("company","Company","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");
			
			$dataselect[] = array("0","Draft");
			$dataselect[] = array("1","Published");
			
			$cari[] = array("published","Status","select","select",$dataselect);

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
			
			$sql = "select id,nama,testimoni,published,company,gambar from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=15%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Testimoni</a></th>\n");
			print("<th width=65%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Testimoni</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id        = $row['id'];
				$nama      = $row['nama'];
				$testimoni   = $row['testimoni'];
				$published = $row['published'];
				$gambar = $row['gambar'];
				$company = $row['company'];
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				 
				 if(!empty($gambar)) $gambar = "<img src=\"../gambar/$kanal/$gambar\" alt=\"\" style=\"width:150px\" />"; else $gambar = "Masih kosong";
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td >$gambar</td>
					<td  valign=top class=judul><b>$nama</b>, $company<br clear=\"all\" /> $testimoni</td>\n
					<td  valign=top >$publish</td>");
					
				print("<td>");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&id=$id&hlm=$hlm");
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

	//Hapus
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id       = $_GET['id'];
			$perintah = "select gambar,gambar1 from $nama_tabel where id='$id'";
			$hasil    = sql($perintah);
			$row      = sql_fetch_data($hasil);
			
			$gambar  = $row['gambar'];
			
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");

			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus dengan Data dengan ID $id");
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
	
	//Publish
	if($aksi=="publish")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$id = $_GET['id'];
			
			$perintah 	= "select published from $nama_tabel where id='$id' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['published']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set published='$status' where id='$id' ";
			$hasil		= sql($perintah);
		
			if($hasil)
			{   
				$msg = base64_encode("Success merubah status data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}


	
	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama    = cleaninsert($_POST['nama']);
			$testimoni = cleaninsert($_POST['testimoni']);
			$company    = cleaninsert($_POST['company']);
			$alias   = getAlias($nama);
			
			$new = newid("id",$nama_tabel);

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$new.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$fgambar = ",gambar";
					$vgambar = ",'$namagambars'";
				}
			}
			
			$perintah = "insert into $nama_tabel(id,nama,testimoni,company,create_date,create_userid $fgambar ) 
						values ('$new','$nama','$testimoni','$company','$date','$cuserid' $vgambar)";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan Data baru");
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
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
				<tr> 
					<td width="15%">Nama</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Company</td>
					<td><input name="company" type="text" size="60" value="" id="company" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Testimoni</td>
					<td ><textarea name="testimoni" cols="70" rows="10" id="testimoni" class="validate[required]" ></textarea></td>
				</tr>

                 <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /> <em>Ukuran gambar minimal <?php echo "$gambars_maxw x $gambars_maxh pixel"; ?></em></td>
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
	
	if($aksi=="saveedit")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id      = $_POST['id'];
			$nama    = cleaninsert($_POST['nama']);
			$testimoni = cleaninsert($_POST['testimoni']);
			$company    = cleaninsert($_POST['company']);

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$id.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$vgambar = ",gambar='$namagambars'";
				}
			}
			
			$perintah = "update $nama_tabel set nama='$nama',testimoni='$testimoni',company='$company',
						update_date='$date',update_userid='$cuserid' $vgambar where id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{   
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

	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,testimoni,company from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$testimoni = $row['testimoni'];
			$company = $row['company'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td valign="top">Nama</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td>Company</td>
					<td><input name="company" type="text" size="60" value="<?php echo $company?>" id="company" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Testimoni</td>
					<td ><textarea name="testimoni" cols="70" rows="10" id="testimoni" class="validate[required]" ><?php echo $testimoni?></textarea></td>
				</tr>
                <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" />
				    <em>Ukuran gambar minimal <?php echo "$gambars_maxw x $gambars_maxh pixel"; ?></em></td>
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
	

}

?>