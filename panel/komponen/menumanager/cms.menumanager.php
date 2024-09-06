<?php 
//Variable halaman ini
$nama_tabel		= "tbl_cms_menu";
$nama_tabel1	= "tbl_cms_menusub";
$nama_tabel2	= "tbl_cms_menuchild";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['menuid'])) $menuid = $_POST['menuid'];
 else $menuid = $_GET['menuid'];
 
if(isset($_POST['menusubid'])) $menusubid = $_POST['menusubid'];
 else $menusubid = $_GET['menusubid'];

if(isset($_POST['menuchildid'])) $menuchildid = $_POST['menuchildid'];
 else $menuchildid = $_GET['menuchildid'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Kategori","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Kategori","tambah","$alamat&aksi=tambahmenu");
			mainaction($mainmenu,$pageparam);
			
	
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("menuid","Menu ID","int","text","$data");
			$cari[] = array("kode","Kode Menu","str","text","$data");
			$cari[] = array("nama","Nama Menu","str","text","$data");
			$cari[] = array("keterangan","Keterangan","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("menuid","asc",$pageparam,$param);
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
			
			$sql = "select nama,menuid,keterangan,kode,alias from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=menuid\" title=\"Urutkan\">MenuID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Kategori</a></th>\n");
			print("<th width=45% ><a href=\"$urlorder&order=keterangan\" title=\"Urutkan\">Keterangan</a></th>");
			print("<th width=20%><a href=\"$urlorder&order=kode\" title=\"Urutkan\">Kode</a></th>");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$menuid = $row['menuid'];
				$url = $row['url'];
				$keterangan = $row['keterangan'];
				$kode = $row['kode'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$menuid</b></td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=viewsubmenu&menuid=$menuid\"><b>$nama</b></a></td>\n");
				print("<td valign=top class=hitam>$keterangan</td>\n");
				print("<td valign=top class=hitam>$kode</td>\n");
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&menuid=$menuid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&menuid=$menuid&hlm=$hlm");
				$acc[] = array("Lihat Submenu","view","$alamat&aksi=viewsubmenu&menuid=$menuid");
								
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
	
	//ViewSubMenu
	if($aksi=="viewsubmenu")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$pageparam[] = array("menuid",$menuid);
			
			$mainmenu[] = array("Lihat Kategori","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Submenu","tambah","$alamat&aksi=tambahsubmenu&menuid=$menuid");
			$mainmenu[] = array("Lihat Submenu","lihat","$alamat&aksi=viewsubmenu&menuid=$menuid");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("menusubid","Submenu ID","int","text","$data");
			$cari[] = array("kode","Kode Submenu","str","text","$data");
			$cari[] = array("nama","Nama Submenu","str","text","$data");
			$cari[] = array("keterangan","Keterangan","str","text","$data");
			
			
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("menusubid","asc",$pageparam);
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
			
			$sql = "select nama,menuid,keterangan,kode,url,menusubid from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=menusubid\" title=\"Urutkan\">Submenu ID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Submenu</a></th>\n");
			print("<th width=25% ><a href=\"$urlorder&order=keterangan\" title=\"Urutkan\">Keterangan</a></th>");
			print("<th width=15% ><a href=\"$urlorder&order=url\" title=\"Urutkan\">URL</a></th>");
			print("<th width=20%><a href=\"$urlorder&order=kode\" title=\"Urutkan\">Kode</a></th>");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$menuid = $row['menuid'];
				$url = $row['url'];
				$keterangan = $row['keterangan'];
				$kode = $row['kode'];
				$menusubid = $row['menusubid'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$menusubid</b></td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=viewchildmenu&menuid=$menuid&menusubid=$menusubid\"><b>$nama</b></a></td>\n");
				print("<td valign=top class=hitam>$keterangan</td>\n");
				print("<td valign=top class=hitam>$url</td>\n");
				print("<td valign=top class=hitam>$kode</td>\n");
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=editsubmenu&menuid=$menuid&menusubid=$menusubid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapussubmenu&menuid=$menuid&menusubid=$menusubid&hlm=$hlm");
				$acc[] = array("Lihat Child Menu","view","$alamat&aksi=viewsubmenu&menuid=$menuid&menusubid=$menusubid");
								
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
	
	
	//ViewChildMenu
	if($aksi=="viewchildmenu")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$pageparam[] = array("menuid",$menuid);
			$pageparam[] = array("menusubid",$menusubid);
			
			$mainmenu[] = array("Lihat Submenu","lihat","$alamat&aksi=viewsubmenu&menuid=$menuid");
			$mainmenu[] = array("Tambah Child","tambah","$alamat&aksi=tambahchildmenu&menu&menuid=$menuid&submenuid=$submenuid");
			$mainmenu[] = array("Lihat Child Menu","lihat","$alamat&aksi=viewchildmenu&menu&menuid=$menuid&submenuid=$submenuid");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("menuchildid","Childmenu ID","int","text","$data");
			$cari[] = array("kode","Kode Child Menu","str","text","$data");
			$cari[] = array("nama","Nama Child Menu","str","text","$data");
			$cari[] = array("keterangan","Keterangan","str","text","$data");
			$cari[] = array("url","URL","str","text","$data");
			
			
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			//Orderring
			$order = getorder("menuchildid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select count(*) as jml from $nama_tabel2 where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			
			$sql = "select nama,menuid,keterangan,kode,url,menusubid,menuchildid from $nama_tabel2  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=menusubid\" title=\"Urutkan\">Child ID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Child Menu</a></th>\n");
			print("<th width=25% ><a href=\"$urlorder&order=keterangan\" title=\"Urutkan\">Keterangan</a></th>");
			print("<th width=15% ><a href=\"$urlorder&order=url\" title=\"Urutkan\">URL</a></th>");
			print("<th width=20%><a href=\"$urlorder&order=kode\" title=\"Urutkan\">Kode</a></th>");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$menuid = $row['menuid'];
				$url = $row['url'];
				$keterangan = $row['keterangan'];
				$kode = $row['kode'];
				$menuchildid = $row['menuchildid'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$menuchildid</b></td>
					<td  valign=top class=judul><b>$nama</b></td>\n");
				print("<td valign=top class=hitam>$keterangan</td>\n");
				print("<td valign=top class=hitam>$url</td>\n");
				print("<td valign=top class=hitam>$kode</td>\n");
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=editchildmenu&menuid=$menuid&menusubid=$menusubid&menuchildid=$menuchildid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapuschildmenu&menuid=$menuid&menusubid=$menusubid&menuchildid=$menuchildid&hlm=$hlm");

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
	
	//HapusMenu
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$menuid = $_GET['menuid'];

			$perintah = "delete from $nama_tabel where menuid='$menuid'";
			$hasil = sql($perintah);
			
			$perintah = "delete from $nama_tabel1 where menuid='$menuid'";
			$hasil = sql($perintah);
			
			$perintah = "delete from $nama_tabel2 where menuid='$menuid'";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus menu dengan Menu ID $menuid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
	//HapusSubMenu
	if($aksi=="hapussubmenu")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$menuid = $_GET['menuid'];
			$menusubid = $_GET['menusubid'];

			$perintah = "delete from $nama_tabel1 where menuid='$menuid' and menusubid='$menusubid'";
			$hasil = sql($perintah);
			
			$perintah = "delete from $nama_tabel2 where menuid='$menuid' and menusubid='$menusubid'";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus menu dengan Menu ID $menusubid");
				header("location: $alamat&aksi=viewsubmenu&menuid=$menuid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat dihapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsubmenu&menuid=$menuid&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//HapusChildMenu
	if($aksi=="hapuschildmenu")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$menuid = $_GET['menuid'];
			$menusubid = $_GET['menusubid'];
			$menuchildid = $_GET['menuchildid'];

			$perintah = "delete from $nama_tabel2 where menuid='$menuid' and menusubid='$menusubid' and menuchildid='$menuchildid'";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus menu dengan Menu ID $menuchildid");
				header("location: $alamat&aksi=viewchildmenu&menuid=$menuid&menusubid=$menusubid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat dihapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewchildmenu&menuid=$menuid&menusubid=$menusubid&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//SaveTambahMenu
	if($aksi=="savetambahmenu")
	{
		
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama = $_POST['nama'];
			$keterangan = $_POST['keterangan'];
			$kode = $_POST['kode'];
			$nama = cleaninsert($nama);
			$keterangan = cleaninsert($keterangan);
			$kode = cleaninsert($kode);
			
			$newmenuid = newid("menuid",$nama_tabel);
			
			$perintah = "INSERT INTO $nama_tabel (`menuid`, `keterangan`,`nama`,`kode`) VALUES ('$newmenuid', '$keterangan','$nama','$kode')";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan menu baru dengan id = $newmenuid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//TambahMenu
	if($aksi=="tambahmenu")
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
			<input type="hidden" name="aksi" value="savetambahmenu">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Menu</th>
				</tr>
				<tr> 
					<td width="176">Kode</td>
					<td width="471"><input name="kode" type="text" size="20" value="" id="kode" class="validate[required,custom[onlyLetter],minSize[4],maxSize[4]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Nama Menu</td>
					<td align="left"><input name="nama" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><input name="keterangan" type="text"  size="60"  value=""  id="keterangan" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Menu" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveEditMenu
	if($aksi=="saveeditmenu")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$nama = $_POST['nama'];
			$keterangan = $_POST['keterangan'];
			$kode = $_POST['kode'];
			$nama = cleaninsert($nama);
			$keterangan = cleaninsert($keterangan);
			$kode = cleaninsert($kode);
			
			
			$perintah = "update $nama_tabel set nama='$nama',kode='$kode',keterangan='$keterangan' where menuid='$menuid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah menu $nama dengan ID $menuid");
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
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select nama,menuid,keterangan,kode,alias from $nama_tabel  where menuid='$menuid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$nama = $row['nama'];
			$menuid = $row['menuid'];
			$url = $row['url'];
			$keterangan = $row['keterangan'];
			$kode = $row['kode'];
			
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveeditmenu">
            <input type="hidden" name="menuid" value="<?php echo $menuid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Menu</th>
				</tr>
				<tr> 
					<td width="176">Kode</td>
					<td width="471"><input name="kode" value="<?php echo $kode?>" type="text" size="20" id="kode" class="validate[required,custom[onlyLetter],minSize[4],maxSize[4]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Nama Menu</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><input name="keterangan" value="<?php echo $keterangan?>" type="text"  size="60"  id="keterangan" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Menu" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveTambahSubMenu
	if($aksi=="savetambahsubmenu")
	{
		
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama = $_POST['nama'];
			$keterangan = $_POST['keterangan'];
			$kode = $_POST['kode'];
			$url = $_POST['url'];
			$nama = cleaninsert($nama);
			$keterangan = cleaninsert($keterangan);
			$kode = cleaninsert($kode);
			
			$newmenuid = newid("menusubid",$nama_tabel1);
			
			$perintah = "INSERT INTO $nama_tabel1 (`menusubid`,menuid, `keterangan`,`nama`,`kode`,url) VALUES ('$newmenuid','$menuid','$keterangan','$nama','$kode','$url')";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan menu baru dengan id = $newmenuid");
				header("location: $alamat&aksi=viewsubmenu&menuid=$menuid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsubmenu&menuid=$menuid&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//TambahSubMenu
	if($aksi=="tambahsubmenu")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewsubmenu&menuid=$menuid");
			mainaction($mainmenu,$param);
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="savetambahsubmenu">
            <input type="hidden" name="menuid" value="<?php echo $menuid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Submenu</th>
				</tr>
				<tr> 
					<td width="176">Kode</td>
					<td width="471"><input name="kode" type="text" size="20" value="" id="kode" class="validate[required,custom[onlyLetter],minSize[4],maxSize[4]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Nama Menu</td>
					<td align="left"><input name="nama" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><input name="keterangan" type="text"  size="60"  value=""  id="keterangan" class="validate[required]"/></td>
				</tr>
                <tr> 
					<td valign="top">URL Target</td>
					<td align="left"><input name="url" type="text"  size="60"  value=""  id="url" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Submenu" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveEditSubMenu
	if($aksi=="saveeditsubmenu")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$nama = $_POST['nama'];
			$keterangan = $_POST['keterangan'];
			$kode = $_POST['kode'];
			$url = $_POST['url'];
			$nama = cleaninsert($nama);
			$keterangan = cleaninsert($keterangan);
			$kode = cleaninsert($kode);
			
			
			$perintah = "update $nama_tabel1 set nama='$nama',kode='$kode',keterangan='$keterangan',url='$url' where menuid='$menuid' and menusubid='$menusubid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah submenu $nama dengan ID $menuid");
				header("location: $alamat&aksi=viewsubmenu&menuid=$menuid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsubmenu&menuid=$menuid&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//EditSubMenu
	if($aksi=="editsubmenu")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewsubmenu&menuid=$menuid");
			mainaction($mainmenu,$param);
			
			$sql = "select nama,menuid,keterangan,kode,url,menusubid from $nama_tabel1  where menuid='$menuid' and menusubid='$menusubid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$nama = $row['nama'];
			$menuid = $row['menuid'];
			$menusubid = $row['menusubid'];
			$url = $row['url'];
			$keterangan = $row['keterangan'];
			$kode = $row['kode'];
			
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveeditsubmenu">
            <input type="hidden" name="menuid" value="<?php echo $menuid?>">
            <input type="hidden" name="submenuid" value="<?php echo $submenuid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Submenu</th>
				</tr>
				<tr> 
					<td width="176">Kode</td>
					<td width="471"><input name="kode" value="<?php echo $kode?>" type="text" size="20" id="kode" class="validate[required,custom[onlyLetter],minSize[4],maxSize[4]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Nama Submenu</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td valign="top">URL</td> 
					<td align="left"><input name="url" value="<?php echo $url?>" type="text" size="40" value="" id="url" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><input name="keterangan" value="<?php echo $keterangan?>" type="text"  size="60"  id="keterangan" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Ubah Submenu" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveTambahChildMenu
	if($aksi=="savetambahchildmenu")
	{
		
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama = $_POST['nama'];
			$keterangan = $_POST['keterangan'];
			$kode = $_POST['kode'];
			$url = $_POST['url'];
			$nama = cleaninsert($nama);
			$keterangan = cleaninsert($keterangan);
			$kode = cleaninsert($kode);
			
			$newmenuid = newid("menuchildid",$nama_tabel2);
			
			$perintah = "INSERT INTO $nama_tabel2 (menuchildid,`menusubid`,menuid, `keterangan`,`nama`,`kode`,url) VALUES ('$newmenuid','$menusubid','$menuid','$keterangan','$nama','$kode','$url')";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan menu baru dengan id = $newmenuid");
				header("location: $alamat&aksi=viewchildmenu&menuid=$menuid&menusubid=$menusubid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewchildmenu&menuid=$menuid&menusubid=$menusubid&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//TambahMenu
	if($aksi=="tambahchildmenu")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewchildmenu&menuid=$menuid&menusubid=$menusubid");
			mainaction($mainmenu,$param);
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="savetambahchildmenu">
            <input type="hidden" name="menuid" value="<?php echo $menuid?>">
            <input type="hidden" name="submenuid" value="<?php echo $submenuid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Child</th>
				</tr>
				<tr> 
					<td width="176">Kode</td>
					<td width="471"><input name="kode" type="text" size="20" value="" id="kode" class="validate[required,custom[onlyLetter],minSize[4],maxSize[4]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Nama Menu</td>
					<td align="left"><input name="nama" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><input name="keterangan" type="text"  size="60"  value=""  id="keterangan" class="validate[required]"/></td>
				</tr>
                <tr> 
					<td valign="top">URL Target</td>
					<td align="left"><input name="url" type="text"  size="60"  value=""  id="url" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Child" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveTambahMenu
	if($aksi=="saveeditchildmenu")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$nama = $_POST['nama'];
			$keterangan = $_POST['keterangan'];
			$kode = $_POST['kode'];
			$url = $_POST['url'];
			$nama = cleaninsert($nama);
			$keterangan = cleaninsert($keterangan);
			$kode = cleaninsert($kode);
			
			
			$perintah = "update $nama_tabel2 set nama='$nama',kode='$kode',keterangan='$keterangan',url='$url' where menuid='$menuid' and menusubid='$menusubid'  and menuchildid='$menuchildid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah childmenu $nama dengan ID $menuid");
				header("location: $alamat&aksi=viewchildmenu&menuid=$menuid&menusubid=$menusubid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewchildmenu&menuid=$menuid&menusubid=$menusubid&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//EditMenu
	if($aksi=="editchildmenu")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewchildmenu&menuid=$menuid&menusubid=$menusubid");
			mainaction($mainmenu,$param);
			
			$sql = "select nama,menuid,keterangan,kode,url,menusubid,menuchildid from $nama_tabel2  where menuid='$menuid' and menusubid='$menusubid' and menuchildid='$menuchildid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$nama = $row['nama'];
			$menuid = $row['menuid'];
			$menusubid = $row['menusubid'];
			$url = $row['url'];
			$keterangan = $row['keterangan'];
			$kode = $row['kode'];
			$menuchildid = $row['menuchildid'];
			
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveeditchildmenu">
            <input type="hidden" name="menuid" value="<?php echo $menuid?>">
            <input type="hidden" name="submenuid" value="<?php echo $submenuid?>">
            <input type="hidden" name="menuchildid" value="<?php echo $menuchildid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Child</th>
				</tr>
				<tr> 
					<td width="176">Kode</td>
					<td width="471"><input name="kode" value="<?php echo $kode?>" type="text" size="20" id="kode" class="validate[required,custom[onlyLetter],minSize[4],maxSize[4]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Nama Child</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td valign="top">URL</td> 
					<td align="left"><input name="url" value="<?php echo $url?>" type="text" size="40" value="" id="url" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><input name="keterangan" value="<?php echo $keterangan?>" type="text"  size="60"  id="keterangan" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Ubah Child Menu" />
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