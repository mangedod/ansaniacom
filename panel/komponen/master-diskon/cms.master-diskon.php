<?php 
//Variable halaman ini
$nama_tabel		= "tbl_product_mdiskon";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['diskonid'])) $diskonid = $_POST['diskonid'];
 else $diskonid = $_GET['diskonid']; 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Viwe Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Data","lihat","$alamat&aksi=view");
			// $mainmenu[] = array("Tambah Data","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("diskonid","desc",$pageparam,$param);
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
			
			$sql = "select diskonid,nama,diskon_persen from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=40%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=10%>Diskon(%)</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$diskonid      = $row['diskonid'];
				$nama          = $row['nama'];
				$diskon_persen = $row['diskon_persen'];

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama</td>
					<td align=center valign=top class=judul>$diskon_persen%</td>
					");
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&diskonid=$diskonid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&diskonid=$diskonid&hlm=$hlm");
								
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
			$diskonid 	  	= $_GET['diskonid'];

			$perintah 	= "delete from $nama_tabel where diskonid='$diskonid'";
			$hasil 		= sql($perintah);

			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penghapusan data Kategori Produk dengan ID $diskonid",$uri,$ip);  
				$msg = base64_encode("Berhasil menghapus Data dengan ID $diskonid");
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
			$nama          = cleaninsert($_POST['nama']);
			$alias         = getAlias($nama);	
			$diskon_persen = $_POST['diskon_persen'];

			$new 		= newid("diskonid",$nama_tabel);
			
			$perintah 	= "insert into $nama_tabel(diskonid,nama,alias,diskon_persen) 
						values ('$new','$nama','$alias','$diskon_persen')";
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
					<th colspan="2">Tambah Data</th>
				</tr>
                <tr> 
					<td>Nama</td>
					<td>
                    	<input name="nama" type="text" size="40" value="" id="nama" class="validate[required]" /><br />
                        <em>Masukan nama diskon produk dengan jelas</em>
                    </td>
				</tr>
                <tr> 
					<td>Diskon</td>
					<td>
                    	<input name="diskon_persen" type="text" size="1" value="" id="diskon_persen" class="validate[required]" />
                        <em>%</em>
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
			$nama          = cleaninsert($_POST['nama']);
			$alias         = getAlias($nama);
			$diskon_persen = $_POST['diskon_persen'];

			$perintah 	= "update $nama_tabel set nama='$nama',alias='$alias',diskon_persen='$diskon_persen' where diskonid='$diskonid'";
			$hasil 		= sql($perintah);

			if($hasil)
			{  
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Kategori Produk dengan ID $diskonid",$uri,$ip); 
				$msg = base64_encode("Berhasil mengubah data dengan ID $diskonid");
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
			
			$sql = "select diskonid,nama,diskon_persen from $nama_tabel where diskonid='$diskonid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$diskonid      = $row['diskonid'];
			$nama          = $row['nama'];
			$diskon_persen = $row['diskon_persen'];
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>

			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="diskonid" value="<?php echo $diskonid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
                <tr> 
					<td width="50%">Nama</td>
					<td>
                    	<input name="nama" type="text" size="40" value="<?php echo $nama?>" id="nama" class="validate[required]" /><br />
                        <em>Masukan nama diskon produk dengan jelas</em>
                    </td>
				</tr>
                <tr> 
					<td>Diskon</td>
					<td>
                    	<input name="diskon_persen" type="text" size="1" value="<?php echo $diskon_persen?>" id="diskon_persen" class="validate[required]" />
                        <em>%</em>
                    </td>
				</tr>
				<tr> 
					<td colspan="2" align="left">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//Popup Diskon
	if($aksi=="popdiskonid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$var1    = $_GET['var1'];
			$var2    = $_GET['var2'];
			$eventid = $_GET['eventid'];
			
			if(empty($var1) && empty($var2))
			{
				$var1 = "hotelid";
				$var2 = "hotelid_text";
			}
			?>
            	<script type="text/javascript">
				function pushdata(diskonid,nama)
				{
					 if (window.opener && !window.opener.closed)
					 {
					 	window.opener.$("#<?php echo $var1; ?>").val(diskonid);
						window.opener.$("#<?php echo $var2; ?>").val(nama);
					 } 
					  window.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama","str","text","$data");

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
			
			$sql = "select nama,diskonid from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama 	= $row['nama'];
				$nama_en = $row['nama_english'];
				$diskonid 	 	= $row['diskonid'];

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$diskonid','$nama');\">Select</button>");
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