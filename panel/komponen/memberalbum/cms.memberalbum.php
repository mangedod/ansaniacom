<?php 
//Variable halaman ini
$nama_tabel		= "tbl_memberalbum_sec";
$nama_tabel1	= "tbl_memberalbum";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;


//Variable Umum
if(isset($_POST['secid'])) $secid = $_POST['secid'];
 else $secid = $_GET['secid'];
 
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
			$mainmenu[] = array("Lihat Album","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Album","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
	
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Album","str","text","$data");
			$cari[] = array("ringkas","Keterangan","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("secid","desc",$pageparam,$param);
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
			
			$sql = "select secid,nama,ringkas from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=1%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Album</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=kode\" title=\"Urutkan\">Photo</a></th>");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama    = $row['nama'];
				$secid   = $row['secid'];
				$url     = $row['url'];
				$ringkas = $row['ringkas'];

				$jml_photo = sql_get_var("SELECT count(*) FROM $nama_tabel1 WHERE secid='$secid'");
				
				print("<tr class=\"row$i\"><td height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=viewgaleri&secid=$secid\"><b>$nama</b></a><br />$ringkas</td>\n");
				print("<td valign=top class=hitam><a href=$alamat&aksi=viewgaleri&secid=$secid>$jml_photo Photo</a></td>\n");
				print("<td>");
				$acc[] = array("Lihat Galeri","view","$alamat&aksi=viewgaleri&secid=$secid");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&secid=$secid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&secid=$secid&hlm=$hlm");
								
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
			$secid = $_GET['secid'];

			$perintah = "delete from $nama_tabel where secid='$secid'";
			$hasil = sql($perintah);
			
			$perintah 	= "select gambar,gambar1,id from $nama_tabel1 where secid='$secid'";
			$hasil 		= sql($perintah);
			while($row	= sql_fetch_data($hasil))
			{
			
				$gambar 	= $row['gambar'];
				$gambar1 	= $row['gambar1'];
				$id 	= $row['id'];
				
				if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
				if(!empty($gambar1)) unlink("$pathfile$kanal/$gambar1");
					
	
				$perintahs = "delete from $nama_tabel1 where id='$id' and secid='$secid'";
				$hasils = sql($perintahs);
			
			}
			
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus menu dengan Album ID $secid");
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
			$ringkas = $_POST['ringkas'];
			$nama = cleaninsert($nama);
			$ringkas = cleaninsert($ringkas);
			$alias = getalias($nama);
			
			$newsecid = newid("secid",$nama_tabel);
			
			$perintah = "INSERT INTO $nama_tabel (`secid`,alias, `ringkas`,`nama`,create_date,create_userid) VALUES ('$newsecid', '$alias', '$ringkas','$nama','$date','$cuserid')";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan Album barudengan id = $newsecid");
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
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Album</th>
				</tr>
                <tr> 
					<td valign="top">Nama Album</td>
					<td align="left"><input name="nama" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><textarea name="ringkas" cols="70" rows="5" id="ringkas" class="validate[required]"></textarea></td>
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
			$ringkas = $_POST['ringkas'];
			$kode = $_POST['kode'];
			$nama = cleaninsert($nama);
			$ringkas = cleaninsert($ringkas);
			$alias = getalias($nama);
			
			
			$perintah = "update $nama_tabel set nama='$nama',alias='$alias',ringkas='$ringkas' where secid='$secid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah menu $nama dengan ID $secid");
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
			
			$sql = "select nama,secid,ringkas,alias from $nama_tabel  where secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$nama = $row['nama'];
			$secid = $row['secid'];
			$url = $row['url'];
			$ringkas = $row['ringkas'];
			$kode = $row['kode'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Album</th>
				</tr>
				<tr> 
					<td valign="top">Nama Album</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><textarea cols="70" rows="5" name="ringkas" id="ringkas" class="validate[required]"><?php echo $ringkas?></textarea></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Album" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//Vie Content
	if($aksi=="viewgaleri")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$pageparam[] = array("secid",$secid);
			
			$mainmenu[] = array("Lihat Album","category","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Galeri","lihat","$alamat&aksi=viewgaleri");
			$mainmenu[] = array("Tambah Galeri","tambah","$alamat&aksi=tambahgaleri");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");
			$cari[] = array("ringkas","Ringkas","str","text","$data");
			$cari[] = array("oleh","Fotografer","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");
			
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("id","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel1 where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select id,nama,ringkas,published,secid,gambar from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=15%><a href=\"$urlorder&order=id\" title=\"Urutkan\">Preview</a></th>\n");
			print("<th width=60%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul</a></th>\n");
			print("<th width=5%>Views</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id = $row['id'];
				$nama = $row['nama'];
				$ringkas = $row['ringkas'];
				$published = $row['published'];
				$secid = $row['secid'];
				$gambar = $row['gambar'];
				
				if(empty($gambar)) $gambar = "Masih kosong";
				else $gambar = "<img src=\"../gambar/$kanal/$gambar\" style=\"width:200px\" alt=\"\" />";
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				 
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td valign=top>$gambar</td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=detailgaleri&id=$id&secid=$secid&hlm=$hlm\">$nama</a></b><br clear=\"all\" /> $ringkas</td>\n
					<td  valign=top >$view</td>
					<td  valign=top >$publish</td>");
					
				print("<td>");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publishgaleri&secid=$secid&id=$id&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publishgaleri&secid=$secid&id=$id&hlm=$hlm");
				
				$acc[] = array("Detail","detail","$alamat&aksi=detailgaleri&id=$id&secid=$secid&hlm=$hlm");
				$acc[] = array("Edit","edit","$alamat&aksi=editgaleri&id=$id&secid=$secid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapusgaleri&id=$id&secid=$secid&hlm=$hlm");
								
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
	if($aksi=="detailgaleri")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewgaleri&secid=$secid");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,ringkas,oleh,alias,gambar,gambar1,create_date,create_userid,update_date,update_userid from $nama_tabel1  where id='$id' and secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$ringkas = $row['ringkas'];
			$oleh = $row['oleh'];
			$alias = $row['alias'];
			$gambar = $row['gambar'];
			$gambar1 = $row['gambar1'];
			$create_date = tanggal($row['create_date']);
			
			if(!empty($gambar)) $gambar = "<img src=\"../gambar/$kanal/$gambar\" alt=\"\" />"; else $gambar = "Masih kosong";
			if(!empty($gambar1)) $gambar1 = "<img src=\"../gambar/$kanal/$gambar1\" alt=\"\" />"; else $gambar1 = "Masih kosong";
			
			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Judul</td> 
					<td align="left"><?php echo $nama?></td>
				</tr>
                <tr> 
					<td valign="top" width="20%" class="tdinfo">Alias</td> 
					<td align="left"><?php echo $alias?></td>
				</tr>
                <tr> 
					<td  class="tdinfo">Ringkas</td>
					<td ><?php echo $ringkas?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Fotografer</td>
					<td><?php echo $oleh?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Tanggal Buat</td>
					<td><?php echo $create_date?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Kecil</td>
					<td><?php echo $gambar?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Besar</td>
					<td><?php echo $gambar1?></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=editgaleri&secid=$secid&id=$id"?>'" value="Ubah Data">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//Hapus
	if($aksi=="hapusgaleri")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id = $_GET['id'];
			$perintah 	= "select gambar,gambar1 from $nama_tabel1 where id='$id' and secid='$secid'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar 	= $row['gambar'];
			$gambar1 	= $row['gambar1'];
			
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
			if(!empty($gambar1)) unlink("$pathfile$kanal/$gambar1");
				

			$perintah = "delete from $nama_tabel1 where id='$id' and secid='$secid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus galeri dengan ID $id");
				header("location: $alamat&aksi=viewgaleri&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewgaleri&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//Publish
	if($aksi=="publishgaleri")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$id = $_GET['id'];
			
			$perintah 	= "select published from $nama_tabel1 where id='$id' and secid='$secid'";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['published']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel1 set published='$status' where id='$id' and secid='$secid'";
			$hasil		= sql($perintah);
		
			if($hasil)
			{   
				$msg = base64_encode("Success merubah status data dengan ID $id");
				header("location: $alamat&aksi=viewgaleri&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=viewgaleri&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}


	
	//SaveTambah
	if($aksi=="savetambahgaleri")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama = cleaninsert($_POST['nama']);
			$ringkas = cleaninsert($_POST['ringkas']);
			$oleh = cleaninsert($_POST['oleh']);
			$alias = getAlias($nama);
			
			$xx = count($_FILES['gambar']['tmp_name']);
			$files = $_FILES['gambar']['tmp_name'];
			$type = $_FILES['gambar']['type'];
			$size = $_FILES['gambar']['size'];
			
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
		
			for($x=0;$x<$xx;$x++)
			{
	
				$new = newid("id",$nama_tabel1);
				$xname = "$files[$x]";
			
				if($size[$x]> 0)
				{
				
					$jenis = $type[$x];
					if(preg_match("/jp/i",$jenis)) $ext = "jpg";
					if(preg_match("/gif/i",$jenis)) $ext = "gif";
					if(preg_match("/png/i",$jenis)) $ext = "png";
			
					$namagambars = "$kanal-$alias-$new.$ext";
					$gambars = resizeimg($xname,"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
					
					$namagambarl = "$kanal-$alias-$new-l.$ext";
					$gambarl = resizeimg($xname,"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
					
					if($gambarl)
					{ 
						$fgambar = ",gambar,gambar1";
						$vgambar = ",'$namagambars','$namagambarl'";
						
					}
				}
					
				$perintah = "insert into $nama_tabel1(id,secid,nama,alias,ringkas,oleh,create_date,create_userid,published $fgambar) 
							values ('$new','$secid','$nama','$alias','$ringkas','$oleh','$date','$cuserid','1' $vgambar)";
				$hasil = sql($perintah);
			
			}
			
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=viewgaleri&hlm=$hlm&msg=$msg&secid=$secid");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewgaleri&hlm=$hlm&msg=$msg&secid=$secid");
				exit();
			}
		}
	}
	
	//Tambah
	if($aksi=="tambahgaleri")
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
            <input type="hidden" name="secid" value="<?php echo $secid?>">
			<input type="hidden" name="aksi" value="savetambahgaleri">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Galeri</th>
				</tr>
				<tr> 
					<td width="15%">Judul</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Ringkas</td>
					<td ><textarea name="ringkas" cols="76" rows="5" id="ringkas" class="validate[required]"></textarea></td>
				</tr>
                <tr> 
					<td>Fotografer</td>
					<td><input name="oleh" type="text" size="20" value="" id="oleh" class="validate[required]" /></td>
				</tr>
                 <tr> 
					<td >Gambar</td>
					<td><input name="gambar[]" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file"  multiple/></td>
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
	
	if($aksi=="saveeditgaleri")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_POST['id'];
			$nama = cleaninsert($_POST['nama']);
			$ringkas = cleaninsert($_POST['ringkas']);
			$oleh = cleaninsert($_POST['oleh']);
			$alias = getAlias($nama);
			

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$id.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				$namagambarl = "$kanal-$alias-$id-l.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
				
				if($gambarl){ 
					$vgambar = ",gambar='$namagambars',gambar1='$namagambarl'";
				}
			}
			
			$perintah = "update $nama_tabel1 set nama='$nama',secid='$secid',alias='$alias',ringkas='$ringkas',oleh='$oleh',
						update_date='$date',update_userid='$cuserid' $vgambar where id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=viewgaleri&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewgaleri&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editgaleri")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewgaleri&secid=$secid");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,ringkas,oleh,secid from $nama_tabel1  where id='$id' and secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$ringkas = $row['ringkas'];
			$lengkap = $row['lengkap'];
			$oleh = $row['oleh'];
			$secid = $row['secid'];
			
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditgaleri">
            <input type="hidden" name="id" value="<?php echo $id?>">
             <input type="hidden" name="secid" value="<?php echo $secid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td valign="top">Judul</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="70" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td >Ringkas</td>
					<td ><textarea name="ringkas" cols="76" rows="5" id="ringkas" class="validate[required]"><?php echo $ringkas?></textarea></td>
				</tr>
                <tr> 
					<td>Fotografer</td>
					<td><input name="oleh" type="text" size="20" value="<?php echo $oleh?>" id="oleh" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /></td>
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