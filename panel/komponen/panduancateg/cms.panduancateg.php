<?php
//Variable halaman ini
$nama_tabel		= "tbl_panduan_sec";
//$nama_tabel1	= "tbl_faq_sub";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;

//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];
 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//View Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
		{
			$mainmenu[] = array("Lihat Data","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Data","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");

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
			
			$sql = "select secid,nama,keterangan,icon from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			//print("<th width=5%>Icon</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=65%>Katerangan</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$secid 		= $row['secid'];
				$nama 		= $row['nama'];
				$keterangan	= $row['keterangan'];
				$icon		= $row['icon'];
				
				if(!empty($icon))
					$icons = "<i class='fa $icon'></i>";
				else
					$icons = "";
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b>$nama</b></td>\n
					<td  valign=top >$keterangan</td>");
				print("<td>");
				
				/*if($published==0) $acc[] = array("Published","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				else $acc[] = array("Draft","push","$alamat&aksi=publish&id=$id&hlm=$hlm");<td valign=top>$icons</td>
*/
				
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
			$id 		= $_GET['secid'];

			$perintah = "delete from $nama_tabel where secid='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penghapusan data Kategori FAQ dengan ID $id",$uri,$ip);
				  
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
		}
	}
	
	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
		{
			$nama 		= $_POST[nama];
			$icon 		= $_POST[icon];
			$alias 		= getAlias($nama);
			$keterangan	= str_replace("'","&rsquo;",($_POST[keterangan]));
			$nama 		= htmlspecialchars ($nama);
 
 			$new = newid("secid",$nama_tabel);
			
			$perintah = "INSERT INTO $nama_tabel (`secid`,`nama`,`alias`,`keterangan`,`icon`,create_date,create_userid) 
								VALUES ('$new','$nama','$alias','$keterangan','$icon','$date','$cuserid')";
			$hasil = sql($perintah);
			
			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penambahan data Kategori FAQ dengan ID $new",$uri,$ip);
				  
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
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
            <script type="text/javascript" src="template/js/ui.datepicker-id.js"></script>
			<script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
                <tr> 
					<td >Nama Kategori</td>
					<td ><input name="nama" type="text"  size="60"  class="validate[required]"/></td>
				</tr>
                <tr> 
					<td>Keterangan</td>
					<td><textarea name="keterangan" style="width:300px" rows="8" class="text"></textarea></td>
				</tr>
                <!--<tr> 
					<td >Icon</td>
					<td><button class="btn btn-default" data-iconset="fontawesome" name="icon" id="icon" role="iconpicker" class="validate[required]"></button></td>
				</tr>-->
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
	
	//SaveTambahMenu
	if($aksi=="saveedit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
		{
			$secid 		= $_POST[secid];
			$nama 		= $_POST[nama];
			$icon 		= $_POST[icon];
			$alias 		= getAlias($nama);
			$keterangan	= str_replace("'","&rsquo;",($_POST[keterangan]));
			$nama 		= htmlspecialchars ($nama);

			$perintah 	= "update $nama_tabel SET nama='$nama',alias='$alias',keterangan='$keterangan',icon='$icon',update_date='$date',update_userid='$cuserid' WHERE secid='$secid'";
			$hasil = sql($perintah);

			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Kategori FAQ dengan ID $secid",$uri,$ip);
				  
				$msg = base64_encode("Berhasil mengubah data dengan ID $secid");
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
			$secid = $_GET['secid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$perintah 	= "SELECT * from $nama_tabel WHERE secid='$secid' ";
			
			$hasil 		= sql($perintah);
			$nama 		= sql_result ($hasil, 0, nama);
			$alias 		= sql_result ($hasil, 0, alias);
			$keterangan	= sql_result ($hasil, 0, keterangan);
			
			?>
            <script type="text/javascript" src="template/js/ui.datepicker-id.js"></script>
			<script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				 <tr> 
					<td >Nama Kategori</td>
					<td ><input name="nama" type="text"  size="60"  class="validate[required]" value="<?php echo $nama;?>"/></td>
				</tr>
                <tr> 
					<td>Keterangan</td>
					<td><textarea name="keterangan" cols="60" rows="8" class="text"><?php echo $keterangan?></textarea></td>
				</tr>
                <!--<tr> 
					<td >Icon</td>
					<td><button class="btn btn-default" data-iconset="fontawesome" name="icon" id="icon" role="iconpicker" class="validate[required]"></button></td>
				</tr>-->
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