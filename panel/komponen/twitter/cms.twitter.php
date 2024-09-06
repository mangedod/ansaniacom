<?php 
//Variable halaman ini
$nama_tabel		= "tbl_twitter";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambarl_maxw = 63;
$gambarl_maxh = 63;


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
			$mainmenu[] = array("Lihat Tweet","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Tweet","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama","str","text","$data");
			$cari[] = array("tweet","Tweet","str","text","$data");

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
			
			$sql = "select id,nama,tweet,gambar,tanggal,published from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<th width=5%><a href=\"$urlorder&order=id\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=30%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Tweet</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id = $row['id'];
				$nama = $row['nama'];
				$tweet = $row['tweet'];
				$tanggal = tanggal($row['tanggal']);
				$published = $row['published'];
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				
				$gambar = $row['gambar'];
				
				if(empty($gambar)) $gambar = "Masih kosong";
				else $gambar = "<img src=\"../gambar/$kanal/$gambar\" style=\"height:140px\" alt=\"\" />";
				
				
				print("<tr class=\"row$i\">
					<td width=5% height=20 valign=top>&nbsp;<b>$id</b></td>
					<td  valign=top>$gambar<b>$nama</b><br clear=\"all\" /> $tweet<br clear=\"all\" /> $tanggal</td>\n
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
			
			$id = $_GET['id'];
			$perintah 	= "select gambar from $nama_tabel where id='$id'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar 	= $row['gambar'];
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
				

			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus  Data dengan ID $id");
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
			$nama = cleaninsert($_POST['nama']);
			$tweet = cleaninsert($_POST['tweet']);
			$tanggal = cleaninsert($_POST['tanggal']);
			
			$new = newid("id",$nama_tabel);
			
			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);

				$namagambarl = "$kanal-$new.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
				
				if($gambarl){ 
					$fgambar = ",gambar";
					$vgambar = ",'$namagambarl'";
				}
			}
			
			$perintah = "insert into $nama_tabel(id,nama,tweet,tanggal,create_date,create_userid $fgambar) 
						values ('$new','$nama','$tweet','$tanggal','$date','$cuserid' $vgambar)";
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
			
			?><script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
						$( "#tanggal" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true,
						});

				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Slide</th>
				</tr>
				<tr> 
					<td width="15%">Nama</td>
					<td ><input name="nama" type="text" size="50" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Tweet</td>
					<td><textarea name="tweet" cols="76" rows="5" id="ringkas" class="validate[required]"></textarea></td>
				</tr>
                <tr> 
					<td>Tanggal</td>
					<td><input name="tanggal" type="text" size="20" value="" id="tanggal" class="validate[required]" /></td>
				</tr>
                 <tr> 
					<td >Photo</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /> <em>Ukuran Gambar <?php echo $gambarl_maxw?>  x <?php echo $gambarl_maxh?> pixel</em></td>
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
			$id = $_POST['id'];
			$nama = cleaninsert($_POST['nama']);
			$tweet = cleaninsert($_POST['tweet']);
			$tanggal = cleaninsert($_POST['tanggal']);

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambarl = "$kanal-$id.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
				
				if($gambarl){ 
					$vgambar = ",gambar='$namagambarl'";
				}
			}
			
			$perintah = "update $nama_tabel set nama='$nama',tweet='$tweet',tanggal='$tanggal',
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
			
			$sql = "select id,nama,tweet,tanggal from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$tweet = $row['tweet'];
			$tanggal = $row['tanggal'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
						$( "#tanggal" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true,
						});

				});
			</script>
            <form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Slide</th>
				</tr>
				<tr> 
					<td valign="top">Nama</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="50" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td>Tweet</td>
					<td><textarea name="tweet" cols="76" rows="5" id="ringkas" class="validate[required]"><?php echo $tweet?></textarea></td>
				</tr>
                <tr> 
					<td>Tanggal</td>
					<td><input name="tanggal" value="<?php echo $tanggal?>" type="text" size="20" value="" id="tanggal" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /> <em>Ukuran Gambar <?php echo $gambarl_maxw?>  x <?php echo $gambarl_maxh?> pixel</em></td>
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