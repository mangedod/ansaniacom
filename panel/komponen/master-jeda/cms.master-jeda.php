<?php 
//Variable halaman ini
$nama_tabel		= "tbl_jeda_pembayaran";
$nama_tabel1	= "tbl_product_tipe";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['tipeid'])) $tipeid = $_POST['tipeid'];
 else $tipeid = $_GET['tipeid'];

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
			$mainmenu[] = array("Lihat Tipe Belanja","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
	
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Tipe Belanja","int","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("id","asc",$pageparam,$param);
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
			
			$sql = "select id,nama from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=65%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Tipe Belanja</a></th>\n");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$tipeid          = $row['id'];
				$nama            = $row['nama'];
				
				if($status==0)
				{
					$status = "Tidak Aktif";
					$label 	= "";
				}
				else
				{
					$status = "Aktif";
					$label 	= "label-success";
				}
				
				print("<tr class = \"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=viewjeda&tipeid=$tipeid&hlm=$hlm\" title=\"Urutkan\">$nama</a></td>
					\n");
				print("<td>");
				
				$acc[] = array("Lihat Jeda Pembayaran","detail","$alamat&aksi=viewjeda&tipeid=$tipeid&hlm=$hlm");
								
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
	
	//Vie Menu
	if($aksi=="viewjeda")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Tipe Belanja","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Maksimun Jeda Pembayaran","lihat","$alamat&aksi=viewjeda&tipeid=$tipeid");
			$mainmenu[] = array("Tambah Maksimun Jeda Pembayaran","tambah","$alamat&aksi=tambah&tipeid=$tipeid");
			mainaction($mainmenu,$pageparam);
			
	
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Maksimun Jeda Pembayaran","int","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where']." and tipeid='$tipeid'";
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
			
			$sql = "select id,nama from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=65%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Maksimun Jeda Pembayaran</a></th>\n");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id              = $row['id'];
				$nama            = $row['nama'];
				
				if($status==0)
				{
					$status = "Tidak Aktif";
					$label 	= "";
				}
				else
				{
					$status = "Aktif";
					$label 	= "label-success";
				}
				
				print("<tr class = \"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama Jam</td>
					\n");
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&tipeid=$tipeid&id=$id&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&tipeid=$tipeid&id=$id&hlm=$hlm");
								
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

			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penghapusan data Jeda Pembayaran dengan ID $id",$uri,$ip);
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $id");
				header("location: $alamat&aksi=viewjeda&tipeid=$tipeid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewjeda&tipeid=$tipeid&hlm=$hlm&error=$error");
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
			
			$perintah 	= "select status from $nama_tabel where id='$id' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['status']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set status='$status' where id='$id' ";
			$hasil		= sql($perintah);
		
			if($hasil)
			{  
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Perubahan data status Jeda Pembayaran dengan ID $id",$uri,$ip); 
				$msg = base64_encode("Berhasil merubah status data dengan ID $id");
				header("location: $alamat&aksi=viewjeda&tipeid=$tipeid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=viewjeda&tipeid=$tipeid&hlm=$hlm&error=$error");
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
			$nama = $_POST['nama'];
			$new = newid("id",$nama_tabel);
			
			$perintah = "INSERT INTO $nama_tabel (id,tipeid,nama,create_date,create_userid) VALUES ('$newmenuid','$tipeid','$nama','$date','$cuserid')";
			$hasil = sql($perintah);
			if($hasil)
			{  
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penambahan data jeda pembayaran dengan ID $new",$uri,$ip); 
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=viewjeda&tipeid=$tipeid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewjeda&tipeid=$tipeid&hlm=$hlm&error=$error");
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
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Tipe Belanja","int","text","$data");
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="savetambah">
            <input type="hidden" name="tipeid" value="<?php echo $tipeid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Maksimun Jeda Pembayaran</th>
				</tr>
				<tr> 
					<td width="176">Maksimun Jeda Pembayaran</td>
					<td width="471"><input name="nama" type="text" size="20" value="" id="nama" class="validate[required]" /> Jam</td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Tipe Belanja" />
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
			$nama = $_POST['nama'];
			$id = $_POST['id'];
			$nama = htmlspecialchars($nama);

			$perintah = "update $nama_tabel set nama='$nama',tipeid='$tipeid',update_date='$date',update_userid='$cuserid' where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Perubahan data jeda pembayaran dengan ID $id",$uri,$ip);  
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=viewjeda&tipeid=$tipeid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewjeda&tipeid=$tipeid&hlm=$hlm&error=$error");
				exit();
			}
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
			
			$sql = "select id,nama,tipeid from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$nama = $row['nama'];
			$id = $row['id'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
            <input type="hidden" name="tipeid" value="<?php echo $tipeid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td valign="top">Maksimun Jeda Pembayaran</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" value="" id="nama" class="validate[required]"  /> Jam</td>
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