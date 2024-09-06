<?php
//Variable halaman ini
$nama_tabel    = "tbl_panduanbelanja";
$nama_tabel1   = "tbl_panduan_sec";
$judul_per_hlm = 25;
$otoritas      = kodeoto($kanal);
$oto           = $otoritas[0];
$gambars_maxw  = 140;
$gambars_maxh  = 140;
$gambarl_maxw  = 800;
$gambarl_maxh  = 600;

//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];
if(isset($_POST['secid'])) $secid = $_POST['secid'];
 else $secid = $_GET['secid']; 
 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//View Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
		{
			$mainmenu[] = array("Kategori","category","$alamat&aksi=viewsec");
			$mainmenu[] = array("Lihat Data","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Data","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");

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
			
			$sql = "select id,nama,secId,subId,alias,published,lengkap,flag,icon from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<th width=2%>No</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul</a></th>\n");
			print("<th width=20%>Kategori</th>\n");
			print("<th width=5%>Utama</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id 		= $row['id'];
				$nama 		= $row['nama'];
				$lengkap 	= cleaninsert($row['lengkap']);
				$ringkas 	= substr($lengkap,0,200);
				$published 	= $row['published'];
				$secId		= $row['secId'];
				$subId		= $row['subId'];
				$flag		= $row['flag'];
				$icon		= $row['icon'];
				if($icon)
					$icons="<img src=$fulldomain/gambar/panduanbelanja/$icon>";
				else
					$icons="";
				
				if($flag=="1") $flags="./template/images/approve.png";
				else $flags="./template/images/delete.png";
				
				$kateg = sql_get_var("select nama from $nama_tabel1 where secid='$secId'");
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=detail&id=$id&hlm=$hlm\">$nama</a></b></td>\n
					<td  valign=top >$kateg</td>
					<td  valign=top align=center ><a href=$alamat&aksi=pilihan&id=$id&hlm=$hlm><img src=$flags></a></td>");
				print("<td>");
				
				if($published==0) $acc[] = array("Published","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				else $acc[] = array("Draft","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				
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
	
	//Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql 	= "select * from $nama_tabel where id = '$id'";
			$hsl 	= sql($sql);
			$row 	= sql_fetch_data($hsl);
			$id 		= $row[id];
			$secId 		= $row[secId];
			$nama 		= $row[nama];
			$lengkap 	= $row[lengkap];
			$tanggal 	= tanggal($row[tanggal]);

			sql_free_result($hsl);
			
			$namasec 	= sql_get_var("select nama from tbl_panduan_sec where secId='$secId'");
			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Kategori</td> 
					<td align="left"><?php echo $namasec?></td>
				</tr>
                <tr> 
					<td  class="tdinfo">Pertanyaan</td>
					<td ><?php echo $nama?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Jawaban</td>
					<td><?php echo $lengkap?></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=edit&id=$id"?>'" value="Ubah Data">
					</td>
				</tr>
			</table>
			</form>
            
            <?php
		}
	}

	//Hapus
	if($aksi=="hapus")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		else
		{
			$id 		= $_GET['id'];

			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
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
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
	//Publish
	if($aksi=="pilihan")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
		{
			
			$id = $_GET['id'];
			
			$perintah 	= "select flag from $nama_tabel where id='$id' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['flag']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set flag='$status' where id='$id' ";
			$hasil		= sql($perintah);
		
			if($hasil)
			{   
				$msg = base64_encode("Success merubah status data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
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
			$nama 		= $_POST['nama'];
			$alias 		= getAlias($nama);
			$secId 		= $_POST['secId'];
			$subId 		= $_POST['subId'];
			$ringkas 	= str_replace("'","&rsquo;",($_POST[ringkas]));
			$lengkap 	= str_replace("'","&rsquo;",($_POST[content]));
			$lengkap 	= str_replace("\\","",$lengkap);
			$nama 		= htmlspecialchars ($nama);
			$tanggal = date("Y-m-d H:i:s");
			
			$new = newid("id",$nama_tabel);
			
			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$new.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$fgambar = ",icon";
					$vgambar = ",'$namagambars'";
				}
			}
			
			$perintah = "INSERT INTO $nama_tabel (`id`, secId,subId,`nama`,`alias`,`ringkas`,`lengkap`,tanggalpost $fgambar) 
								VALUES ('$idbaru','$secId','$subId','$nama','$alias','$ringkas','$lengkap','$tanggal' $vgambar)";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
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
            <script type="text/javascript" src="komponen/faq/ajax_subkateg.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
				<tr> 
					<td width="15%">Kategori</td>
					<td>
                    	<select name="secId">
                        	<option value="">Pilih Kategori</option>
                            <?php
								$perintah 	= "SELECT * FROM tbl_panduan_sec order by secId desc";
								$hasil 		= sql($perintah);
								while($row 	= sql_fetch_data($hasil))
								{
									$secId 		= $row['secid'];
									$namasec 	= $row['nama'];
										
									echo"<option value=$secId>$namasec</option>";
								}
								sql_free_result($hasil);
                            ?>
                        </select>
                    </td>
				</tr>
                <!--<tr>
                    <td valign="top">Sub Kategori</td>
                    <td>
                        <select name="subId" id="subid">
                            <option value="">Pilih</option>
                        </select>
                    </td>
                </tr>-->
                <tr> 
					<td >Pertanyaan</td>
					<td ><input name="nama" type="text"  size="60"  class="validate[required]"/></td>
				</tr>
                <tr>
                	<td>Jawaban</td>
                    <td ><textarea name="content" cols="70" rows="10" id="content" class="ckeditor validate[required]" ></textarea></td>
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
	
	//SaveTambahMenu
	if($aksi=="saveedit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
		{
			$id 		= $_POST['id'];
			$secId 		= $_POST['secId'];
			$subId 		= $_POST['subId'];
			$nama 		= $_POST[nama];
			$alias 		= getAlias($nama);
			$lengkap 	= str_replace("'","&rsquo;",($_POST[content]));
			$lengkap 	= str_replace("\\","",$lengkap);
			$nama 		= htmlspecialchars ($nama);

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$id.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				if($gambars){ 
					$vgambar = ",icon='$namagambars'";
				}
			}
			
			$perintah 	= "update $nama_tabel SET secId='$secId',subId='$subId',nama='$nama',alias='$alias',lengkap='$lengkap' $vgambar WHERE id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
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
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$perintah 	= "SELECT * from $nama_tabel WHERE id='$id' ";
			
			$hasil 		= sql($perintah);
			$secId1 	= sql_result ($hasil, 0, secId);
			$nama 		= sql_result ($hasil, 0, nama);
			$alias 		= sql_result ($hasil, 0, alias);
			$isi 		= sql_result ($hasil, 0, lengkap);
			
			?>
            <script type="text/javascript" src="template/js/ui.datepicker-id.js"></script>
			<script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script type="text/javascript" src="komponen/faq/ajax_subkateg.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td width="15%">Kategori</td>
					<td>
                    	<select name="secId">
                        	<option value="">Pilih Kategori</option>
                            <?php
								$perintah 	= "SELECT * FROM tbl_panduan_sec order by secId desc";
								$hasil 		= sql($perintah);
								while($row 	= sql_fetch_data($hasil))
								{
									$secId 		= $row['secid'];
									$namasec 	= $row['nama'];
									
									if($secId1==$secId)
										echo"<option value=$secId selected>$namasec</option>";
									else
										echo"<option value=$secId>$namasec</option>";
								}
								sql_free_result($hasil);
                            ?>
                        </select>
                    </td>
				</tr>
                <!--<tr>
                    <td valign="top">Sub Kategori</td>
                    <td>
                        <select name="subId" id="subid">
                        	<option value="">Pilih</option>
                        	<?php
								$perintah 	= "SELECT * FROM tbl_faq_sub where secId='$secId' order by secId desc";
								$hasil 		= sql($perintah);
								while($row 	= sql_fetch_data($hasil))
								{
									$sub 		= $row[subId];
									$namasub 	= $row[nama];
									
									if($subId==$sub)
										echo"<option value=$sub selected>$namasub</option>";
									else
										echo"<option value=$sub>$namasub</option>";
								}
								sql_free_result($hasil);
                            ?>
                            
                        </select>
                    </td>
                </tr>-->
                <tr> 
					<td >Pertanyaan</td>
					<td ><input name="nama" type="text"  size="60"  class="validate[required]" value="<?php echo $nama;?>"/></td>
				</tr>
                <tr>
                	<td>Lengkap</td>
                    <td ><textarea name="content" cols="70" rows="10" id="content" class="ckeditor validate[required]" ><?php echo $isi;?></textarea></td>
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
	
	//Vie Content
	if($aksi=="viewsec")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Kategori","lihat","$alamat&aksi=viewsec");
			$mainmenu[] = array("Tambah Kategori","tambah","$alamat&aksi=tambahsec");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Kategori","str","text","$data");

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
			
			$sql = "select secid,nama,keterangan,icon from $nama_tabel1 where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			//print("<th width=5%>Icon</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Kategori</a></th>\n");
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
				
				$acc[] = array("Edit","edit","$alamat&aksi=editsec&secid=$secid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapussec&secid=$secid&hlm=$hlm");
								
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
	if($aksi=="hapussec")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$secid 	= $_GET['secid'];
			
			$perintah = "delete from $nama_tabel1 where secid='$secid'";
			$hasil    = sql($perintah);
			if($hasil)
			{   
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penghapusan data Kategori FAQ dengan ID $secid",$uri,$ip);

				$msg = base64_encode("Success menghapus Data dengan ID $secid");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//SaveTambahSec
	if($aksi=="savetambahsec")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama 		= $_POST[nama];
			$icon 		= $_POST[icon];
			$alias 		= getAlias($nama);
			$keterangan	= str_replace("'","&rsquo;",($_POST[keterangan]));
			$nama 		= htmlspecialchars ($nama);
			
			$new = newid("secid",$nama_tabel1);
			
			$perintah = "insert into $nama_tabel1(secid,nama,alias,keterangan,icon,create_date,create_userid $fgambar) 
						values ('$new','$nama','$alias','$keterangan','$icon','$date','$cuserid' $vgambar)";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penambahan data Kategori FAQ dengan ID $new",$uri,$ip);
				$msg = base64_encode("Berhasil ditambahkan Sec baru");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//Tambah
	if($aksi=="tambahsec")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewsec");
			mainaction($mainmenu,$param);
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahsec">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Kategori</th>
				</tr>
				<tr> 
					<td width="15%">Nama Kategori</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td ><textarea name="keterangan" cols="76" rows="5" id="keterangan" class="validate[required]"></textarea></td>
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
	
	if($aksi=="saveeditsec")
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
			
			$perintah = "update $nama_tabel1 set nama='$nama',alias='$alias',keterangan='$keterangan',icon='$icon',
						update_date='$date',update_userid='$cuserid' where secid='$secid'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Kategori FAQ dengan ID $secid",$uri,$ip);
				$msg = base64_encode("Berhasil mengubah data dengan ID $secid");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editsec")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewsec");
			mainaction($mainmenu,$param);
			
			$sql = "select secid,nama,keterangan from $nama_tabel1  where secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$secid      = $row['secid'];
			$nama       = $row['nama'];
			$keterangan = $row['keterangan'];
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditsec">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Kategori</th>
				</tr>
				<tr> 
					<td valign="top">Nama Kategori</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td ><textarea name="keterangan" cols="76" rows="5" id="keterangan" class="validate[required]"><?php echo $keterangan?></textarea></td>
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