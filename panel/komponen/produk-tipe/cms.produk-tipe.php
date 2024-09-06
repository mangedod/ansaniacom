<?php 
//Variable halaman ini
$nama_tabel		= "tbl_product_tipe";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;

//Variable Umum
if(isset($_POST['tipeid'])) $tipeid = $_POST['tipeid'];
 else $tipeid = $_GET['tipeid']; 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Tipe","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Tipe","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Tipe","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("tipeid","desc",$pageparam,$param);
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
			
			$sql = "select tipeid,nama,keterangan,gambar from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=20%>Gambar</th>\n");
			print("<th width=30%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Tipe</a></th>\n");
			print("<th width=40%>Keterangan Tipe</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$tipeid     = $row['tipeid'];
				$nama       = $row['nama'];
				$keterangan = $row['keterangan'];
				$gambar     = $row['gambar'];

				if(!empty($gambar)) $gambar = "<img src=\"../gambar/$kanal/$gambar\" alt=\"\" />"; else $gambar = "Masih kosong";

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td align=center valign=top class=judul>$gambar</td>
					<td  valign=top class=judul><b>$nama</b></td>
					<td valign=top >$keterangan</td>");
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&tipeid=$tipeid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&tipeid=$tipeid&hlm=$hlm");
								
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
			$tipeid   = $_GET['tipeid'];
			$perintah = "select gambar from $nama_tabel where tipeid='$tipeid'";
			$hasil    = sql($perintah);
			$row      = sql_fetch_data($hasil);
			
			$gambar  = $row['gambar'];
			
			//Upload Gambar
			$simpangambar = "$pathfile/$kanal";
			
			if(!empty($gambar)) unlink("$simpangambar/$gambar");

			$perintah 	= "delete from $nama_tabel where tipeid='$tipeid'";
			$hasil 		= sql($perintah);

			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penghapusan data Kategori Produk dengan ID $id",$uri,$ip);  
				$msg = base64_encode("Success menghapus menu dengan Data dengan ID $tipeid");
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

	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama       = cleaninsert($_POST['nama']);
			$alias      = getAlias($nama);
			$keterangan = cleaninsert($_POST['keterangan']);

			$new 		= newid("tipeid",$nama_tabel);
			
			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			$simpangambar = "$pathfile/$kanal";
			
			if($_FILES['gambar']['size']>0)
			{
				$ext         = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$new.$ext";
				$gambars     = resizeimg($_FILES['gambar']['tmp_name'],"$simpangambar/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$fgambar = ",gambar";
					$vgambar = ",'$namagambars'";
				}
			}

			$perintah 	= "insert into $nama_tabel(tipeid,nama,alias,keterangan $fgambar) 
						values ('$new','$nama','$alias','$keterangan' $vgambar)";
			$hasil 		= sql($perintah);
			
			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penambahan data Kategori Produk dengan ID $new",$uri,$ip);  
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
					<th colspan="2">Tambah Tipe</th>
				</tr>
                <tr> 
					<td>Nama Tipe</td>
					<td>
                    	<input name="nama" type="text" size="50" value="" id="nama" class="validate[required]" /><br />
                        <em>Masukan nama Tipe dengan jelas</em>
                    </td>
				</tr>
                <tr> 
					<td>Keterangan Tipe</td>
					<td>
						<textarea name="keterangan" id="keterangan" cols="70" rows="10" class="validate[required]" ></textarea>
                    </td>
				</tr>
                 <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /></td>
				</tr>
				<tr>
					<td colspan="2" align="left">
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
			$keterangan = cleaninsert($_POST['keterangan']);
			$nama       = cleaninsert($_POST['nama']);
			$alias      = getAlias($nama);

			//Upload Gambar
			if(!file_exists("$pathfile"."$kanal")) mkdir("$pathfile"."$kanal");
			$simpangambar = "$pathfile"."$kanal";
			
			if($_FILES['gambar']['size']>0)
			{
				$ext         = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$tipeid.$ext";
				$gambars     = resizeimg($_FILES['gambar']['tmp_name'],"$simpangambar/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$vgambar = ",gambar='$namagambars'";
				}
			}

			$perintah 	= "update $nama_tabel set nama='$nama',alias='$alias',keterangan='$keterangan' $vgambar where tipeid='$tipeid'";
			$hasil 		= sql($perintah);

			if($hasil)
			{  
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Kategori Produk dengan ID $id",$uri,$ip); 
				$msg = base64_encode("Berhasil mengubah data dengan ID $tipeid");
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
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select tipeid,nama,keterangan from $nama_tabel where tipeid='$tipeid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$tipeid    = $row['tipeid'];
			$nama       = $row['nama'];
			$keterangan = $row['keterangan'];
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>

			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="tipeid" value="<?php echo $tipeid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Tipe</th>
				</tr>
                <tr> 
					<td width="50%">Nama Tipe</td>
					<td>
                    	<input name="nama" type="text" size="50" value="<?php echo $nama?>" id="nama" class="validate[required]" /><br />
                        <em>Masukan nama Tipe dengan jelas</em>
                    </td>
				</tr>
                <tr> 
					<td>Keterangan Tipe</td>
					<td>
						<textarea name="keterangan" id="keterangan" cols="70" rows="10" class="validate[required]" ><?php echo $keterangan;?></textarea>
                    </td>
				</tr>
                 <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /></td>
				</tr>
				<tr> 
					<td colspan="2" align="left">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//Popup Tipe
	if($aksi=="popidtipe")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$var1    = $_GET['var1'];
			$var2    = $_GET['var2'];
			// $eventid = $_GET['eventid'];
			
			if(empty($var1) && empty($var2))
			{
				$var1 = "tipeid";
				$var2 = "tipeid_text";
			}
			?>
            	<script type="text/javascript">
				function pushdata(tipeid,nama)
				{
					 if (window.opener && !window.opener.closed)
					 {
					 	window.opener.$("#<?php echo $var1; ?>").val(tipeid);
						window.opener.$("#<?php echo $var2; ?>").val(nama);
					 } 
					  window.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Tipe","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from $nama_tabel where 1 $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("nama","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select nama,tipeid from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Tipe</a></th>\n");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama    = $row['nama'];
				$tipeid = $row['tipeid'];

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$tipeid','$nama');\">Select</button>");
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
	
}

?>