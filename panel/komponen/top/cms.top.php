<?php 
//Variable halaman ini
$nama_tabel	= "tbl_top";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];
 
if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Data
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainData[] = array("Lihat Promo","lihat","$alamat&aksi=view");
			$mainData[] = array("Tambah Promo","tambah","$alamat&aksi=tambah");
			mainaction($mainData,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Link","str","text","$data");
			$cari[] = array("url","URL","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("id","asc",$pageparam,$param);
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
			
			$sql = "select id,nama,url,alias,click,published from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr>");
			print("<th width=5%><a href=\"$urlorder&order=id\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=40%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=45% ><a href=\"$urlorder&order=url\" title=\"Urutkan\">URL Target</a></th>");
			print("<th width=10%>Click</th>\n");
			print("<th width=10%>Status</th>\n");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$id = $row['id'];
				$published = $row['published'];
				$url = $row['url'];
				$click = $row['click'];

				if($published=="1") $publish ="publish";
				 else $publish ="draft";
			
				
				print("<tr class=\"row$i\">
					<td width=5% height=20 valign=top>&nbsp;<b>$id</b></td>\n");
				print("<td valign=top class=hitam>$nama<br />$alias</td>\n");
				print("<td valign=top class=hitam>$url</td>\n");
				print("<td valign=top class=hitam>$click</td>\n");
				print("<td  valign=top >$publish</td>\n");
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
	
	//HapusData
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$id = $_GET['id'];

			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);

					
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus Data dengan Data ID $id");
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
			$url = $_POST['url'];
			$width = $_POST['width'];
			$height = $_POST['height'];
			$alias = $_POST['alias'];
			$nama = cleaninsert($nama);
			$alias = cleaninsert($alias);
			
			$newid = newid("id",$nama_tabel);
			
			$perintah = "INSERT INTO $nama_tabel (`id`, `url`,`nama`,alias) VALUES ('$newid', '$url','$nama','$alias')";
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
					<td valign="top">Nama</td>
					<td align="left"><input name="nama" type="text"  size="60"  value=""  id="nama" class="validate[required]"/></td>
				</tr>
				
				<tr> 
					<td valign="top">URL Traget</td>
					<td align="left"><input name="url" type="text" size="40" value="" id="url" class="validate[required]" /></td>
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
            <br clear="all">
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
			$url = $_POST['url'];
			$width = $_POST['width'];
			$height = $_POST['height'];
			$alias = $_POST['alias'];
			$alias = cleaninsert($alias);
			
			$perintah = "update $nama_tabel set nama='$nama',url='$url' where id='$id'";
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
			
			$sql = "select nama,id,url,alias from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$nama = $row['nama'];
			$id = $row['id'];
			$url = $row['url'];
			$alias = $row['alias'];
					
			
			?>
            <script>	
				$(document).ready(function() {
					$("#Datafrm").validationEngine()
				});
			</script>
			<form method="post" name="Datafrm" id="Datafrm">
			<input type="hidden" name="aksi" value="saveeditData">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td valign="top">Nama </td>
					<td align="left"><input name="nama" type="text"  size="60"  value="<?php echo $nama?>"  id="nama" class="validate[required]"/></td>
				</tr>
			
				<tr> 
					<td valign="top">URL Target</td>
					<td align="left"><input name="url" type="text" size="60" value="<?php echo $url?>" id="Link" class="validate[required]" /></td>
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