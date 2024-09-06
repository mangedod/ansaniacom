<?php 
//Variable halaman ini
$nama_tabel		= "tbl_blog_sec";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];


//Variable Umum
if(isset($_POST['secid'])) $secid = $_POST['secid'];
 else $secid = $_GET['secid'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Kategori Blog","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Kategori Blog","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Kategori","str","text","$data");
			$cari[] = array("keterangan","Keterangan","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");

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
			
			$sql = "select secid,nama,keterangan from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=id\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=70%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$secid        = $row['secid'];
				$nama      = $row['nama'];
				$keterangan   = $row['keterangan'];
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top>&nbsp;<b>$secid</b></td>
					<td  valign=top class=judul><b>$nama</b><br clear=\"all\" /> $keterangan</td>\n");
					
				print("<td>");

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
		
	//Hapus
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$secid       = $_GET['secid'];				

			$perintah = "delete from $nama_tabel where secid='$secid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $secid");
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
			$nama    	= cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$alias		= getAlias($nama);
			
			$new = newid("secid",$nama_tabel);
			
			$perintah = "insert into $nama_tabel(secid,nama,alias,keterangan,create_date,create_userid) 
						values ('$new','$nama','$alias','$keterangan','$date','$cuserid')";
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
            <script src="librari/ckeditor/ckeditor.js"></script>
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
					<td width="15%">Judul</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td ><textarea name="keterangan" cols="76" rows="5" id="keterangan" class="validate[required]"></textarea></td>
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
			$secid 		= $_POST['secid'];
			$nama 		= cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$alias		= getAlias($nama);
			
			$perintah = "update $nama_tabel set nama='$nama',alias='$alias',keterangan='$keterangan',
						update_date='$date',update_userid='$cuserid' where secid='$secid'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $secid");
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
			$secid = $_GET['secid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select secid,nama,keterangan from $nama_tabel  where secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$secid      = $row['secid'];
			$nama    = $row['nama'];
			$keterangan = $row['keterangan'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td valign="top">Judul</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td ><textarea name="keterangan" cols="76" rows="5" id="keterangan" class="validate[required]"><?php echo $keterangan?></textarea></td>
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