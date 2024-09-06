<?php 
//Variable halaman ini
$nama_tabel    = "tbl_template";
$judul_per_hlm = 25;
$otoritas      = kodeoto($kanal);
$oto           = $otoritas[0];
$gambars_maxw  = 350;
$gambars_maxh  = 300;
$gambarl_maxw  = 800;
$gambarl_maxh  = 600; 

//Variable Umum
if(isset($_POST['templateId'])) $templateId = $_POST['templateId'];
 else $templateId = $_GET['templateId']; 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Template","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Template","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("namatemplate","Nama Template","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("templateId","desc",$pageparam,$param);
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
			
			$sql = "select templateId,namatemplate,lokasitemplate,templatealias,gambar from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=40%>Thumbnail</th>\n");
			print("<th width=40%><a href=\"$urlorder&order=namatemplate\" title=\"Urutkan\">Nama Template</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$templateId     = $row['templateId'];
				$namatemplate   = $row['namatemplate'];
				$lokasitemplate = $row['lokasitemplate'];
				$templatealias  = $row['templatealias'];
				$gambar         = $row['gambar'];
				
				if($gambar)
				{
					// $img       = $lokasitemplate."/".$templatealias."/".$gambar;
					$thumbnail 	= "<img src=\"../gambar/template/$templatealias/$gambar\">";
				}
				else
					$thumbnail="Masih kosong";

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td align=center valign=top>$thumbnail</td>
					<td  valign=top>$namatemplate</td>");
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&templateId=$templateId&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&templateId=$templateId&hlm=$hlm");
								
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
			$templateId = $_GET['templateId'];
			$perintah   = "select gambar,lokasitemplate,templatealias from $nama_tabel where templateId='$templateId'";
			$hasil      = sql($perintah);
			$row        = sql_fetch_data($hasil);
			
			$gambar         = $row['gambar'];
			$lokasitemplate = $row['lokasitemplate'];
			$templatealias  = $row['templatealias'];
			
			if(!empty($gambar)) unlink("$lokasitemplate/$templatealias/$gambar");

			$perintah = "delete from $nama_tabel where templateId='$templateId'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Sukses menghapus Data dengan ID $templateId");
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
			$namatemplate      = cleaninsert($_POST['namatemplate']);
			$templatealias     = cleaninsert($_POST['templatealias']);
			$lokasiwebtemplate = cleaninsert($_POST['lokasiwebtemplate']);
			$lokasitemplate    = cleaninsert($_POST['lokasitemplate']);
			$mobiletemplate    = cleaninsert($_POST['mobiletemplate']);
			$slidewidth        = cleaninsert($_POST['slidewidth']);
			$slideheight       = cleaninsert($_POST['slideheight']);
			$bannerwidth       = cleaninsert($_POST['bannerwidth']);
			$bannerheight      = cleaninsert($_POST['bannerheight']);
			
			$new 		= newid("templateId",$nama_tabel);
			
			//Upload Gambar
			if(!file_exists("$lokasitemplate/$templatealias")) mkdir("$lokasitemplate/$templatealias");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext         = getimgext($_FILES['gambar']);
				$namagambars = "thumbnail-$templatealias-$new.$ext";
				$gambars     = resizeimg($_FILES['gambar']['tmp_name'],"$lokasitemplate/$templatealias/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$fgambar = ",gambar";
					$vgambar = ",'$namagambars'";
				}
			}

			$perintah 	= "insert into $nama_tabel(templateId,namatemplate,templatealias,lokasiwebtemplate,lokasitemplate,mobiletemplate,slidewidth,
							slideheight,bannerwidth,bannerheight,create_date,create_userid $fgambar) 
						values ('$new','$namatemplate','$templatealias','$lokasiwebtemplate','$lokasitemplate','$mobiletemplate','$slidewidth',
							'$slideheight','$bannerwidth','$bannerheight','$date','$cuserid' $vgambar)";
			$hasil 		= sql($perintah);
			
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
					<th colspan="2">Tambah Template</th>
				</tr>
				<tr> 
					<td width="15%">Nama Template</td>
					<td >
                        <input name="namatemplate" type="text" size="25" value="" id="namatemplate" class="validate[required]" />
                    </td>
				</tr>
				<tr> 
					<td width="15%">Alias Template</td>
					<td >
                        <input name="templatealias" type="text" size="25" value="" id="templatealias" class="validate[required]" />
                    </td>
				</tr>
				<tr> 
					<td width="15%">Lokasi Web Template</td>
					<td >
                        <input name="lokasiwebtemplate" type="text" size="55" value="" id="lokasiwebtemplate" class="validate[required]" />
                    </td>
				</tr>
				<tr> 
					<td width="15%">Lokasi Template</td>
					<td >
                        <input name="lokasitemplate" type="text" size="55" value="" id="lokasitemplate" class="validate[required]" />
                    </td>
				</tr>
				<tr> 
					<td width="15%">Mobile Template</td>
					<td >
                        <input name="mobiletemplate" type="text" size="55" value="" id="mobiletemplate" class="validate[required]" />
                    </td>
				</tr>
                <tr> 
					<td>Slide Width</td>
					<td><input name="slidewidth" type="text" size="5" value="" id="slidewidth" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Slide Height</td>
					<td><input name="slideheight" type="text" size="5" value="" id="slideheight" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Banner Width</td>
					<td><input name="bannerwidth" type="text" size="5" value="" id="bannerwidth" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Banner Height</td>
					<td><input name="bannerheight" type="text" size="5" value="" id="bannerheight" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Gambar Thumbnail</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Thumbnail Dari Drive" class="file" /></td>
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
			$templateId        = $_POST['templateId'];
			$namatemplate      = cleaninsert($_POST['namatemplate']);
			$templatealias     = cleaninsert($_POST['templatealias']);
			$lokasiwebtemplate = cleaninsert($_POST['lokasiwebtemplate']);
			$lokasitemplate    = cleaninsert($_POST['lokasitemplate']);
			$mobiletemplate    = cleaninsert($_POST['mobiletemplate']);
			$slidewidth        = cleaninsert($_POST['slidewidth']);
			$slideheight       = cleaninsert($_POST['slideheight']);
			$bannerwidth       = cleaninsert($_POST['bannerwidth']);
			$bannerheight      = cleaninsert($_POST['bannerheight']);

			//Upload Gambar
			if(!file_exists("$lokasitemplate/$templatealias")) mkdir("$lokasitemplate/$templatealias");
			
			if($_FILES['gambar']['size']>0)
			{
				// echo "masuk kondisi gambar ".$lokasitemplate."/".$templatealias;
				$ext         = getimgext($_FILES['gambar']);
				$namagambars = "thumbnail-$templatealias-$new.$ext";
				$gambars     = resizeimg($_FILES['gambar']['tmp_name'],"$lokasitemplate/$templatealias/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$vgambar = ",gambar='$namagambars'";
				}
			}
			// die();
			$perintah 	= "update $nama_tabel set namatemplate='$namatemplate',templatealias='$templatealias',lokasiwebtemplate='$lokasiwebtemplate',
							lokasitemplate='$lokasitemplate',mobiletemplate='$mobiletemplate',slidewidth='$slidewidth',slideheight='$slideheight',
							bannerwidth='$bannerwidth',bannerheight='$bannerheight',update_date='$date',update_userid='$cuserid' $vgambar where templateId='$templateId'";
			$hasil 		= sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $templateId");
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
			
			$sql = "select templateId,namatemplate,templatealias,lokasiwebtemplate,lokasitemplate,mobiletemplate,gambar,slidewidth,slideheight,bannerwidth,bannerheight from $nama_tabel where templateId='$templateId'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$templateId        = $row['templateId'];
			$namatemplate      = $row['namatemplate'];
			$templatealias     = $row['templatealias'];
			$lokasiwebtemplate = $row['lokasiwebtemplate'];
			$lokasitemplate    = $row['lokasitemplate'];
			$mobiletemplate    = $row['mobiletemplate'];
			$gambar            = $row['gambar'];
			$slidewidth        = $row['slidewidth'];
			$slideheight       = $row['slideheight'];
			$bannerwidth       = $row['bannerwidth'];
			$bannerheight      = $row['bannerheight'];
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>

			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="templateId" value="<?php echo $templateId?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Template</th>
				</tr>
				<tr> 
					<td width="15%">Nama Template</td>
					<td >
                        <input name="namatemplate" type="text" size="25" value="<?php echo $namatemplate?>" id="namatemplate" class="validate[required]" />
                    </td>
				</tr>
				<tr> 
					<td width="15%">Alias Template</td>
					<td >
                        <input name="templatealias" type="text" size="25" value="<?php echo $templatealias?>" id="templatealias" class="validate[required]" />
                    </td>
				</tr>
				<tr> 
					<td width="15%">Lokasi Web Template</td>
					<td >
                        <input name="lokasiwebtemplate" type="text" size="55" value="<?php echo $lokasiwebtemplate?>" id="lokasiwebtemplate" class="validate[required]" />
                    </td>
				</tr>
				<tr> 
					<td width="15%">Lokasi Template</td>
					<td >
                        <input name="lokasitemplate" type="text" size="55" value="<?php echo $lokasitemplate?>" id="lokasitemplate" class="validate[required]" />
                    </td>
				</tr>
				<tr> 
					<td width="15%">Mobile Template</td>
					<td >
                        <input name="mobiletemplate" type="text" size="55" value="<?php echo $mobiletemplate?>" id="mobiletemplate" class="validate[required]" />
                    </td>
				</tr>
                <tr> 
					<td>Slide Width</td>
					<td><input name="slidewidth" type="text" size="5" value="<?php echo $slidewidth?>" id="slidewidth" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Slide Height</td>
					<td><input name="slideheight" type="text" size="5" value="<?php echo $slideheight?>" id="slideheight" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Banner Width</td>
					<td><input name="bannerwidth" type="text" size="5" value="<?php echo $bannerwidth?>" id="bannerwidth" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Banner Height</td>
					<td><input name="bannerheight" type="text" size="5" value="<?php echo $bannerheight?>" id="bannerheight" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Gambar Thumbnail</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Thumbnail Dari Drive" class="file" /></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Kategori" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//Popup Kategori
	if($aksi=="poptemplateId")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(templateId,namatemplate)
				{
					var res = new Object();
					res.templateId = templateId;
					res.templateId_text = namatemplate;
					
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
			$cari[] = array("namatemplate","Nama Template","str","text","$data");

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
			$order = getorder("namatemplate","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select namatemplate,templateId from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=namatemplate\" title=\"Urutkan\">Nama Template</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$namatemplate = $row['namatemplate'];
				$templateId 	 = $row['templateId'];

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$namatemplate</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$templateId','$namatemplate');\">Select</button>");
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