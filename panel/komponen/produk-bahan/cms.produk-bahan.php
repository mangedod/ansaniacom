<?php 
//Variable halaman ini
$nama_tabel		= "tbl_bahan";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['bahanid'])) $bahanid = $_POST['bahanid'];
 else $bahanid = $_GET['bahanid']; 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Bahan","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Bahan","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Bahan","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("bahanid","desc",$pageparam,$param);
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
			
			$sql = "select bahanid,nama,keterangan from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=30%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Bahan</a></th>\n");
			print("<th width=60%>Keterangan Bahan</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$bahanid    = $row['bahanid'];
				$nama       = $row['nama'];
				$keterangan = $row['keterangan'];

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b>$nama</b></td>
					<td valign=top >$keterangan</td>");
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&bahanid=$bahanid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&bahanid=$bahanid&hlm=$hlm");
								
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
			$bahanid 	  	= $_GET['bahanid'];

			$perintah 	= "delete from $nama_tabel where bahanid='$bahanid'";
			$hasil 		= sql($perintah);

			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penghapusan data Kategori Produk dengan ID $id",$uri,$ip);  
				$msg = base64_encode("Success menghapus menu dengan Data dengan ID $bahanid");
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
			$nama  = cleaninsert($_POST['nama']);
			$keterangan  = cleaninsert($_POST['keterangan']);

			$new 		= newid("bahanid",$nama_tabel);
			
			$perintah 	= "insert into $nama_tabel(bahanid,nama,keterangan) 
						values ('$new','$nama','$keterangan')";
			$hasil 		= sql($perintah);
			
			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penambahan data Kategori Produk dengan ID $new",$uri,$ip);  
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

			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Bahan</th>
				</tr>
                <tr> 
					<td>Nama Bahan</td>
					<td>
                    	<input name="nama" type="text" size="50" value="" id="nama" class="validate[required]" /><br />
                        <em>Masukan nama bahan dengan jelas</em>
                    </td>
				</tr>
                <tr> 
					<td>Keterangan Bahan</td>
					<td>
						<textarea name="keterangan" id="keterangan" cols="70" rows="10" class="validate[required]" ></textarea>
                    </td>
				</tr>
				<tr>
					<td colspan="2" align="left">
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
			$keterangan = cleaninsert($_POST['keterangan']);
			$nama       = cleaninsert($_POST['nama']);

			$perintah 	= "update $nama_tabel set nama='$nama',keterangan='$keterangan' where bahanid='$bahanid'";
			$hasil 		= sql($perintah);

			if($hasil)
			{  
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Kategori Produk dengan ID $id",$uri,$ip); 
				$msg = base64_encode("Berhasil mengubah data dengan ID $bahanid");
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
			
			$sql = "select bahanid,nama,keterangan from $nama_tabel where bahanid='$bahanid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$bahanid    = $row['bahanid'];
			$nama       = $row['nama'];
			$keterangan = $row['keterangan'];
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>

			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="bahanid" value="<?php echo $bahanid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Bahan</th>
				</tr>
                <tr> 
					<td width="50%">Nama Bahan</td>
					<td>
                    	<input name="nama" type="text" size="50" value="<?php echo $nama?>" id="nama" class="validate[required]" /><br />
                        <em>Masukan nama bahan dengan jelas</em>
                    </td>
				</tr>
                <tr> 
					<td>Keterangan Bahan</td>
					<td>
						<textarea name="keterangan" id="keterangan" cols="70" rows="10" class="validate[required]" ><?php echo $keterangan;?></textarea>
                    </td>
				</tr>
				<tr> 
					<td colspan="2" align="left">
						<input type="submit" name="Submit" value="Simpan Kategori" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//Popup bahan
	if($aksi=="popidbahan")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$var1    = $_GET['var1'];
			$var2    = $_GET['var2'];
			// $eventid = $_GET['eventid'];
			
			if(empty($var1) && empty($var2))
			{
				$var1 = "hotelid";
				$var2 = "hotelid_text";
			}
			?>
            	<script type="text/javascript">
				function pushdata(bahanid,nama)
				{
					 if (window.opener && !window.opener.closed)
					 {
					 	window.opener.$("#<?php echo $var1; ?>").val(bahanid);
						window.opener.$("#<?php echo $var2; ?>").val(nama);
					 } 
					  window.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Bahan","str","text","$data");

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
			$order = getorder("nama","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select nama,bahanid,kode from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Bahan</a></th>\n");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama    = $row['nama'];
				$bahanid = $row['bahanid'];

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$bahanid','$nama');\">Select</button>");
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