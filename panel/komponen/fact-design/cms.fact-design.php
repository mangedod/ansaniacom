<?php
//Variable halaman ini
$nama_tabel    = "tbl_customdesign_fact";
$judul_per_hlm = 25;
$otoritas      = kodeoto($kanal);
$oto           = $otoritas[0];
$gambars_maxw  = 128;
$gambars_maxh  = 128;
$gambarl_maxw  = 800;
$gambarl_maxh  = 600;

//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//View Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
		{
			$mainmenu[] = array("Lihat Data","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Data","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");

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
			
			$sql = "select id,nama,alias,published,lengkap,flag,icon from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th><th width=5%>Icon</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul</a></th>\n");
			//print("<th width=20%>Kategori</th>\n");
			print("<th width=45%>Ringkas</th>\n");
			//print("<th width=5%>Flag</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id 		= $row['id'];
				$nama 		= $row['nama'];
				$lengkap 	= cleaninsert($row['lengkap']);
				$ringkas 	= substr($lengkap,0,200);
				$published 	= $row['published'];
				$secId		= $row['secId'];
				$subId		= $row['subId'];
				$flag		= $row['flag'];
				$icon		= $row['icon'];
				if($icon)
					$icons="<img src=$fulldomain"."gambar/fact-design/$icon>";
				else
					$icons="";
				
				if($flag=="1") $flags="./template/images/approve.png";
				else $flags="./template/images/delete.png";
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				//<!--<td valign=top>$icons</td>--><!--<td  valign=top >$kateg</td>-->
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td valign=top>$icons</td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=detail&id=$id&hlm=$hlm\">$nama</a></b></td>\n
					<td  valign=top >$ringkas</td>");
					//<td  valign=top align=center ><a href=$alamat&aksi=pilihan&id=$id&hlm=$hlm><img src=$flags></a></td>
				print("<td>");
				
				if($published==0) $acc[] = array("Published","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				else $acc[] = array("Draft","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				
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
	
	//Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql 	= "select * from $nama_tabel where id = '$id'";
			$hsl 	= sql($sql);
			$row 	= sql_fetch_data($hsl);
			$id 		= $row[id];
			//$secId 		= $row[secId];
			$nama 		= $row[nama];
			$lengkap 	= $row[lengkap];
			$tanggal 	= tanggal($row[tanggal]);

			sql_free_result($hsl);
			
			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
                <tr> 
					<td  class="tdinfo">Judul</td>
					<td ><?php echo $nama?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Keterangan</td>
					<td><?php echo $lengkap?></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=edit&id=$id"?>'" value="Ubah Data">
					</td>
				</tr>
			</table>
			</form>
            
            <?php
		}
	}

	//Hapus
	if($aksi=="hapus")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		else
		{
			$id 		= $_GET['id'];

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
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
		{
			$nama 		= $_POST['nama'];
			$alias 		= getAlias($nama);
			$ringkas 	= str_replace("'","&rsquo;",($_POST[ringkas]));
			$lengkap 	= str_replace("'","&rsquo;",($_POST[content]));
			$lengkap 	= str_replace("\\","",$lengkap);
			$nama 		= htmlspecialchars ($nama);
			$tanggal = date("Y-m-d H:i:s");
			
			$new = newid("id",$nama_tabel);
			
			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$new.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$fgambar = ",icon";
					$vgambar = ",'$namagambars'";
				}
			}
			
			$perintah = "INSERT INTO $nama_tabel (`id`,`nama`,`alias`,`ringkas`,`lengkap`,tanggalpost $fgambar) 
								VALUES ('$idbaru','$nama','$alias','$ringkas','$lengkap','$tanggal' $vgambar)";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
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
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script type="text/javascript" src="template/js/ui.datepicker-id.js"></script>
			<script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>
            <script type="text/javascript" src="komponen/faq/ajax_subkateg.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
				
                <tr> 
					<td >Nama</td>
					<td ><input name="nama" type="text"  size="60"  class="validate[required]"/></td>
				</tr>
                <tr>
                	<td>Keterangan</td>
                    <td ><textarea name="content" cols="70" rows="10" id="content" class="ckeditor validate[required]" ></textarea></td>
                </tr>
                <tr> 
					<td >Icon</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /> <?php echo $gambars_maxw." x ". $gambars_maxh?></td>
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
	
	//SaveTambahMenu
	if($aksi=="saveedit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
		{
			$id 		= $_POST['id'];
			$nama 		= $_POST[nama];
			$alias 		= getAlias($nama);
			$lengkap 	= str_replace("'","&rsquo;",($_POST[content]));
			$lengkap 	= str_replace("\\","",$lengkap);
			$nama 		= htmlspecialchars ($nama);

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$id.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$vgambar = ",icon='$namagambars'";
				}
			}
			
			$perintah 	= "update $nama_tabel SET nama='$nama',alias='$alias',lengkap='$lengkap' $vgambar WHERE id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}

	//EditMenu
	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
		{
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$perintah 	= "SELECT * from $nama_tabel WHERE id='$id' ";
			
			$hasil 		= sql($perintah);
			$nama 		= sql_result ($hasil, 0, nama);
			$alias 		= sql_result ($hasil, 0, alias);
			$isi 		= sql_result ($hasil, 0, lengkap);
			
			?>
            <script type="text/javascript" src="template/js/ui.datepicker-id.js"></script>
			<script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script type="text/javascript" src="komponen/faq/ajax_subkateg.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				
                <tr> 
					<td >Nama</td>
					<td ><input name="nama" type="text"  size="60"  class="validate[required]" value="<?php echo $nama;?>"/></td>
				</tr>
                <tr>
                	<td>Keterangan</td>
                    <td ><textarea name="content" cols="70" rows="10" id="content" class="ckeditor validate[required]" ><?php echo $isi;?></textarea></td>
                </tr>
               	<tr> 
					<td>Icon</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /> <?php echo $gambars_maxw." x ". $gambars_maxh?></td>
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