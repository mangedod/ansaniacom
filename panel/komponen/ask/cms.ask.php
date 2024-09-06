<?php 
//Variable halaman ini
$nama_tabel		= "tbl_ask";
$nama_tabel1 = "tbl_ask_log";
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
			$mainData[] = array("Lihat Link","lihat","$alamat&aksi=view");
			$mainData[] = array("Tambah Link","tambah","$alamat&aksi=tambah");
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
			
			$sql = "select id,nama,url,alias from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr>");
			print("<th width=5%><a href=\"$urlorder&order=id\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=45% ><a href=\"$urlorder&order=url\" title=\"Urutkan\">URL</a></th>");
			print("<th width=10%>Click</th>\n");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$id = $row['id'];
				$Link = $row['Link'];
				$url = $row['url'];
				$height = $row['height'];
				$alias = $row['alias'];

				$url = substr($url,0,50)."...";

				$views = sql_get_var("select count(*) as jml from tbl_ask_log where id='$id'");
				
				print("<tr class=\"row$i\">
					<td width=5% height=20 valign=top>&nbsp;<b>$id</b></td>\n");
				print("<td valign=top class=hitam><strong>$nama</strong><br />$alias</td>\n");
				print("<td valign=top class=hitam>$url</td>\n");
				print("<td valign=top class=hitam><a href=\"$alamat&aksi=viewlog&id=$id&hlm=$hlm\" class=\"btn btn-default\">$views</a></td>\n");
				print("<td>");
				
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
	
	//HapusData
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$id = $_GET['id'];

			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);

			die($perintah);
			
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
					<td valign="top">Nama Link</td>
					<td align="left"><input name="nama" type="text"  size="60"  value=""  id="nama" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">Alias</td>
					<td align="left"><input name="alias" type="text"  size="60"  value=""  id="alias" class="validate[required]"/></td>
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
			$nama = cleaninsert($nama);
			$alias = cleaninsert($alias);
			
			$perintah = "update $nama_tabel set nama='$nama',url='$url',alias='$alias' where id='$id'";
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
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td valign="top">Nama Link</td>
					<td align="left"><input name="nama" type="text"  size="60"  value="<?php echo $nama?>"  id="nama" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">Alias</td>
					<td align="left"><input name="alias" type="text"  size="60"  value="<?php echo $alias?>"  id="alias" class="validate[required]"/> </td>
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

	//Vie Content
	if($aksi=="viewlog")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
        	$pageparam[] = array("id",$id);
			
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Log","lihat","$alamat&aksi=viewlog&id=$id");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("ipaddress","IP Address","str","text","$data");
			$cari[] = array("browser","Browser","str","text","$data");
			$cari[] = array("tanggal","Tanggal","date","date","$data");
			$cari[] = array("ref","Referer","str","str","$data");
			
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("logid","asc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
			$sql = "select count(*) as jml from $nama_tabel1 where id='$id' $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select logid,tanggal,ipaddress,browser,ref from $nama_tabel1 where id='$id' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=tanggal\" title=\"Urutkan\">Waktu</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=ipaddress\" title=\"Urutkan\">IP Address</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=ref\" title=\"Urutkan\">Refer</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=browser\" title=\"Urutkan\">Browser</a></th>\n");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$tanggal 	 	= $row['tanggal'];
				$secid 	 	= $row['secid'];
				$ipaddress 	= $row['ipaddress'];
				$refer 	= $row['ref'];
				$browser 	= $row['browser'];

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top>$tanggal</td>
					<td  valign=top>$ipaddress</td>
					<td  valign=top>$refer</td>
					<td  valign=top>$browser</td>
				");
					
				print("<td>");
				
				$acc[] = array("Hapus","delete","$alamat&aksi=hapussub&secid=$secid&subid=$subid&hlm=$hlm");
								
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
}

?>