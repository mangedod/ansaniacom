<?php 
//Variable halaman ini
$nama_tabel		= "tbl_agen";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 73;
$gambars_maxh = 73;


//Variable Umum
if(isset($_POST['agenid'])) $agenid = $_POST['agenid'];
 else $agenid = $_GET['agenid'];
 
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
			$mainmenu[] = array("Lihat Agen","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Agen","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
	
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Agen","str","text","$data");
			$cari[] = array("kode","Kode Agen","str","text","$data");
			// $cari[] = array("keterangan","Keterangan","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("agenid","desc",$pageparam,$param);
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
			
			$sql = "select agenid,nama,keterangan,logo,status,kode from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=40%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Agen</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&order=kode\" title=\"Urutkan\">Kode</a></th>\n");
			print("<th width=10%>Logo</th>");
			print("<th width=10%>Status</th>");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama    = $row['nama'];
				$logo    = $row['logo'];
				$ringkas = $row['keterangan'];
				$agenid  = $row['agenid'];
				$kode    = $row['kode'];
				$status1  = $row['status'];
				
				if($status1==0)
				{
					$status = "Tidak Aktif";
					$label 	= "";
				}
				else
				{
					$status = "Aktif";
					$label 	= "label-success";
				}
				
				if(empty($logo)) $logo = "Masih kosong";
				else $logo = "<img src=\"../gambar/$kanal/$logo\" style=\"width:50px\" alt=\"\" />";
				
				print("<tr class=\"row$i\"><td height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b>$nama</b></td>\n");
				print("<td  valign=top class=judul>$kode</td>\n");
				print("<td valign=top class=hitam>$logo</td>\n");
				print("<td  valign=top class=judul><b><a href=\"$alamat&aksi=publish&agenid=$agenid&hlm=$hlm\"><span class=\"label $label\">$status</span></a></b></td>");
				print("<td>");
				$acc[] = array("Lihat Tarif","view","$alamat&aksi=viewkota&agenid=$agenid");
				
				if($status1==0) $acc[] = array("Aktif","push","$alamat&aksi=publish&agenid=$agenid&hlm=$hlm");
				else $acc[] = array("Tidak Aktif","push","$alamat&aksi=publish&agenid=$agenid&hlm=$hlm");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&agenid=$agenid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&agenid=$agenid&hlm=$hlm");
								
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
			$agenid = $_GET['agenid'];

			$perintah = "delete from $nama_tabel where agenid='$agenid'";
			$hasil = sql($perintah);
			
			$perintah 	= "select logo from $nama_tabel where agenid='$agenid'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$logo 	= $row['logo'];
				
			if(!empty($logo)) unlink("$pathfile$kanal/$logo");
					
			
			if($hasil)
			{  
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penghapusan data Agen dengan ID $agenid",$uri,$ip); 
				$msg = base64_encode("Success mengapus menu dengan Agen ID $agenid");
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
			
			$perintah 	= "select status from $nama_tabel where agenid='$agenid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['status']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set status='$status' where agenid='$agenid' ";
			// die($perintah);
			$hasil		= sql($perintah);
		
			if($hasil)
			{
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Status Agen dengan ID $agenid",$uri,$ip);   
				$msg = base64_encode("Berhasil merubah status data dengan ID $agenid");
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
	//SaveTambahAlbum
	if($aksi=="savetambah")
	{
		
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama = $_POST['nama'];
			$ringkas = $_POST['ringkas'];
			$kode = $_POST['kode'];
			$nama = cleaninsert($nama);
			$ringkas = cleaninsert($ringkas);
			$kode = cleaninsert($kode);
			$alias = getalias($nama);
			
			$newagenid = newid("agenid",$nama_tabel);
			
			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$newagenid.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$fgambar = ",logo";
					$vgambar = ",'$namagambars'";
				}
			}
			
			$perintah = "INSERT INTO $nama_tabel (`agenid`, `keterangan`,`nama`,`kode`,create_date,create_userid $fgambar) 
						VALUES ('$newagenid', '$ringkas','$nama','$kode','$date','$cuserid' $vgambar)";
			$hasil = sql($perintah);
			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penambahan data Agen dengan ID $newagenid",$uri,$ip);  
				$msg = base64_encode("Berhasil ditambahkan Agen barudengan id = $newagenid");
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
				function popbagid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=bagian&aksi=popbagid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("bagid").value 		= res.bagid;
							document.getElementById("bagid_text").value 	= res.bagid_text;
						}
						return false;
				}
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Agen</th>
				</tr>
				<tr> 
					<td valign="top">Nama Agen</td>
					<td align="left"><input name="nama" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td valign="top">Kode Agen</td>
					<td align="left"><input name="kode" type="text" size="40" value="" id="kode" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><textarea name="ringkas" cols="70" rows="5" id="ringkas" class="validate[required]"></textarea></td>
				</tr>
                <tr> 
					<td >Logo</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /></td>
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
			
			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$agenid.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$vgambar = ",logo='$namagambars'";
				}
			}
			
			$perintah = "update $nama_tabel set nama='$nama',kode='$kode',keterangan='$ringkas' $vgambar where agenid='$agenid'";
			$hasil = sql($perintah);
			if($hasil)
			{  
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Agen dengan ID $agenid",$uri,$ip);
				$msg = base64_encode("Berhasil mengubah menu $nama dengan ID $agenid");
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
			
			$sql = "select nama,agenid,keterangan,kode from $nama_tabel  where agenid='$agenid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$nama 		= $row['nama'];
			$agenid 	= $row['agenid'];
			$kode 		= $row['kode'];
			$ringkas 	= $row['keterangan'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popbagid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=bagian&aksi=popbagid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("bagid").value 		= res.bagid;
							document.getElementById("bagid_text").value 	= res.bagid_text;
						}
						return false;
				}
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="agenid" value="<?php echo $agenid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Agen</th>
				</tr>
				<tr> 
					<td valign="top">Nama Agen</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td valign="top">Kode Agen</td> 
					<td align="left"><input name="kode" value="<?php echo $kode?>" type="text" size="40" id="kode" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><textarea cols="70" rows="5" name="ringkas" id="ringkas" class="validate[required]"><?php echo $ringkas?></textarea></td>
				</tr>
                <tr> 
					<td >Logo</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Agen" />
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