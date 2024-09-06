<?php 
//Variable halaman ini
$nama_tabel		= "tbl_product_sec";
$nama_tabel1	= "tbl_product_sub";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['secid'])) $secid = $_POST['secid'];
 else $secid = $_GET['secid']; 

if(isset($_POST['subid'])) $subid = $_POST['subid'];
 else $subid = $_GET['subid'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Kategori","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("namasec","Nama Kategori","str","text","$data");

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
			
			$sql = "select secid,namasec,num from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=70%><a href=\"$urlorder&order=namasec\" title=\"Urutkan\">Nama Kategori</a></th>\n");
			print("<th width=10%>Sub Kategori</th>\n");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$secid 	 	= $row['secid'];
				$namasec 	= $row['namasec'];
				$num 	 	= $row['num'];

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=viewsub&secid=$secid\">$namasec</a></b></td>
					<td align=center valign=top ><a href=\"$alamat&aksi=viewsub&secid=$secid\">$num</a></td>");
					
				print("<td>");
				
				$acc[] = array("Lihat Sub","view","$alamat&aksi=viewsub&secid=$secid");
								
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

	//Popup Sub Kategori
	if($aksi=="popsecsubid")
	{
		if(!$oto['view']) { echo $error['view']; }
		{
			$var1 = $_GET['var1'];
			$var2 = $_GET['var2'];
			
			if(empty($var1) && empty($var2))
			{
				$var1 = "subid";
				$var2 = "subid_text";
			}
			
			?>
            	<script type="text/javascript">
				function pushdata(subid,namasub)
				{
					 if (window.opener && !window.opener.closed)
					 {
					 	window.opener.$("#<?php echo $var1; ?>").val(subid);
						window.opener.$("#<?php echo $var2; ?>").val(namasub);
					 } 
					  window.close();
                    return false;
				} 
				</script>
            <?php 

            $secid = $_GET['secid'];
			$pageparam[] = array('secid',$secid);

            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("namasub","Nama Sub Kategori","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from $nama_tabel1 where 1 $where";// and secid='$_GET[secid]'
			$hsl = sql($sql);
			
			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("subid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select namasub,subid from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";// and secid='$_GET[secid]'
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=namasub\" title=\"Urutkan\">Nama Sub Kategori</a></th>\n");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$namasub	= $row['namasub'];
				$subid 		= $row['subid'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top align=center>&nbsp;$a</td>
					<td  valign=top class=judul>$namasub</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$subid','$namasub');\">Select</button>");
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

	//Vie Content
	if($aksi=="viewsub")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
        	$pageparam[] = array("secid",$secid);
			
			$mainmenu[] = array("Kategori","category","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Sub Kategori","lihat","$alamat&aksi=viewsub&secid=$secid");
			$mainmenu[] = array("Tambah Sub Kategori","tambah","$alamat&aksi=tambahsub&secid=$secid");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("namasub","Nama Sub Kategori","str","text","$data");
			
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("subid","asc",$pageparam,$param);
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
			
			$sql = "select subid,secid,namasub from $nama_tabel1 where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=namasub\" title=\"Urutkan\">Nama Sub Kategori (ID)</a></th>\n");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$subid 	 	= $row['subid'];
				$secid 	 	= $row['secid'];
				$namasub 	= $row['namasub'];

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$namasub</td>
				");
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=editsub&secid=$secid&subid=$subid&hlm=$hlm");
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

	//Hapus
	if($aksi=="hapussub")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
        	$secid = $_GET['secid'];
			$subid = $_GET['subid'];

			$perintah = "delete from $nama_tabel1 where secid=$secid and subid='$subid'";
			$hasil = sql($perintah);

			if($hasil)
			{  
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penghapusan data Sub Produk dengan ID $subid",$uri,$ip); 
				$perintahs = "update $nama_tabel set num=num-1 where secid='$secid'";
				$hasils = sql($perintahs);

				$msg = base64_encode("Success mengapus Data dengan ID $subid");
				header("location: $alamat&aksi=viewsub&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsub&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//SaveTambahSub
	if($aksi=="savetambahsub")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$namasub 	= cleaninsert($_POST['namasub']);
			$alias 		= getAlias($namasub);

			$new 		= newid("subid",$nama_tabel1);
			
			$perintah 	= "insert into $nama_tabel1(subid,secid,namasub,alias) 
						values ('$new','$secid','$namasub','$alias')";
			$hasil 		= sql($perintah);
			
			if($hasil)
			{  
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penambahan data Sub Produk dengan ID $new",$uri,$ip); 
				$perintahs 	= "update $nama_tabel set num=num+1 where secid='$secid'";
				$hasils 	= sql($perintahs);

				$msg = base64_encode("Berhasil ditambahkan Sub baru");
				header("location: $alamat&aksi=viewsub&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsub&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//Tambah
	if($aksi=="tambahsub")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewsub&secid=$secid");
			mainaction($mainmenu,$param);
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script>

			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="savetambahsub">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Sub Kategori</th>
				</tr>
                <tr> 
					<td>Nama Kategori</td>
					<td>
                    	<input name="namasub" type="text" size="70" value="" id="namasub" class="validate[required]" /><br />
                        <em>Masukan nama sub kategori produk dengan jelas</em>
                    </td>
				</tr>
				<tr> 
					<td colspan="2" align="left">
						<input type="submit" name="Submit" value="Simpan Subkategori" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	if($aksi=="saveeditsub")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$namasub 	= cleaninsert($_POST['namasub']);
			$alias 		= getAlias($namasub);

			$perintah 	= "update $nama_tabel1 set namasub='$namasub',alias='$alias' where secid='$secid' and subid='$subid'";
			$hasil 		= sql($perintah);

			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Sub Produk dengan ID $subid",$uri,$ip);  
				$msg = base64_encode("Berhasil mengubah data dengan ID $subid");
				header("location: $alamat&aksi=viewsub&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsub&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editsub")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewsec");
			mainaction($mainmenu,$param);
			
			$sql = "select subid,secid,namasub from $nama_tabel1 where secid='$secid' and subid='$subid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$secid 		= $row['secid'];
			$subid 		= $row['subid'];
			$namasub 	= $row['namasub'];
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>

			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveeditsub">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
            <input type="hidden" name="subid" value="<?php echo $subid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Sub Kategori</th>
				</tr>
                <tr> 
					<td>Nama Kategori (ID)</td>
					<td>
                    	<input name="namasub" type="text" size="70" value="<?php echo $namasub?>" id="namasub" class="validate[required]" /><br />
                        <em>Masukan nama sub kategori produk dengan jelas</em>
                    </td>
				</tr>
				<tr> 
					<td align="left" colspan="2">
						<input type="submit" name="Submit" value="Simpan Subkategori" />
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