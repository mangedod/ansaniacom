<?php
//Variable halaman ini
$nama_tabel		= "tbl_training";
$nama_tabel1	= "tbl_training_materi";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;


//Variable Umum
if(isset($_POST['secid'])) $secid = $_POST['secid'];
 else $secid = $_GET['secid'];

if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Training
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Training","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Training","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);



			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Training","str","text","$data");
			$cari[] = array("ringkas","Keterangan","str","text","$data");

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

			$sql = "select secid,nama,ringkas from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=1%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Training</a></th>\n");
			print("<th width=10%>Materi</th>");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$secid = $row['secid'];
				$url = $row['url'];
				$ringkas = $row['ringkas'];

				$jmlphoto = sql_get_var("SELECT COUNT(*) from $nama_tabel1 where secid='$secid'");

				print("<tr class=\"row$i\"><td height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=detail&secid=$secid\"><b>$nama</b></a><br />$ringkas</td>\n");
				print("<td valign=top class=hitam><a href=\"$alamat&aksi=viewmateri&secid=$secid\"><b>$jmlphoto Materi</b></a></td>\n");
				print("<td>");
				$acc[] = array("Lihat Materi","view","$alamat&aksi=viewmateri&secid=$secid");

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
	
		//Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$secid = $_GET['secid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select secid,nama,ringkas,lengkap,alias,gambar,gambar1,create_date,create_userid,update_date,update_userid from $nama_tabel  where secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$secid           = $row['secid'];
			$nama          = $row['nama'];
			$ringkas       = $row['ringkas'];
			$lengkap       = $row['lengkap'];
			$alias         = $row['alias'];
			$gambar        = $row['gambar'];
			$gambar1       = $row['gambar1'];
			$create_date   = tanggal($row['create_date']);
			$update_date   = tanggal($row['update_date']);
			$create_userid = $row['create_userid'];
			$update_userid = $row['update_userid'];
			$create_userid = sql_get_var("select userfullname from tbl_cms_user where userid='$create_userid'");
			$update_userid = sql_get_var("select userfullname from tbl_cms_user where userid='$update_userid'");
			
			if(!empty($gambar)) $gambar = "<img src=\"../gambar/$kanal/$gambar\" alt=\"\" />"; else $gambar = "Masih kosong";
			if(!empty($gambar1)) $gambar1 = "<img src=\"../gambar/$kanal/$gambar1\" alt=\"\" />"; else $gambar1 = "Masih kosong";
			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Judul</td> 
					<td align="left"><?php echo $nama?></td>
				</tr>
                <tr> 
					<td valign="top" width="20%" class="tdinfo">Alias</td> 
					<td align="left"><?php echo $alias?></td>
				</tr>
                <tr> 
					<td  class="tdinfo">Ringkas</td>
					<td ><?php echo $ringkas?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Lengkap</td>
					<td ><?php echo $lengkap?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Tanggal Buat</td>
					<td><?php echo $create_date?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Pembuat</td>
					<td><?php echo $create_userid?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Tanggal Update</td>
					<td><?php echo $update_date?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Pengedit</td>
					<td><?php echo $update_userid?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Kecil</td>
					<td><?php echo $gambar?><br />
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Besar</td>
					<td><?php echo $gambar1?><br />
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=edit&secid=$secid"?>'" value="Ubah Data">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}


	//HapusTraining
	if($aksi=="hapus")
	{

		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$secid = $_GET['secid'];
			
			$perintah = "select gambar,gambar1,file1,file2 from $nama_tabel where secid='$secid'";
			$hasil    = sql($perintah);
			$row      = sql_fetch_data($hasil);
			
			$gambar  = $row['gambar'];
			$gambar1 = $row['gambar1'];
			
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
			if(!empty($gambar1)) unlink("$pathfile$kanal/$gambar1");

			$perintah = "delete from $nama_tabel where secid='$secid'";
			$hasil = sql($perintah);

			$perintah 	= "select gambar,gambar1,id from $nama_tabel1 where secid='$secid'";
			$hasil 		= sql($perintah);
			while($row	= sql_fetch_data($hasil))
			{

				$gambar 	= $row['gambar'];
				$gambar1 	= $row['gambar1'];
				$id 	= $row['id'];

				if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
				if(!empty($gambar1)) unlink("$pathfile$kanal/$gambar1");


				$perintahs = "delete from $nama_tabel1 where id='$id' and secid='$secid'";
				$hasils = sql($perintahs);

			}

			if($hasil)
			{
				$msg = base64_encode("Success mengapus menu dengan Training ID $secid");
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
	//SaveTambahTraining
	if($aksi=="savetambah")
	{

		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama = $_POST['nama'];
			$ringkas = $_POST['ringkas'];
			$nama = cleaninsert($nama);
			$ringkas = cleaninsert($ringkas);
			$alias = getalias($nama);
			$lengkap = desc($_POST['lengkap']);

			$newsecid = newid("secid",$nama_tabel);
			
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-section-$alias-$newsecid.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				$namagambarl = "$kanal-section-$alias-$newsecid-l.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
				
				if($gambarl){ 
					$fgambar = ",gambar,gambar1";
					$vgambar = ",'$namagambars','$namagambarl'";
				}
			}

			$perintah = "INSERT INTO $nama_tabel (`secid`,alias, `ringkas`,`nama`,lengkap,create_date,create_userid  $fgambar ) VALUES ('$newsecid', '$alias', '$ringkas','$nama','$lengkap','$date','$cuserid'  $vgambar )";
			$hasil = sql($perintah);
			
			if($hasil)
			{
				$msg = base64_encode("Berhasil ditambahkan Training barudengan id = $newsecid");
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

	//TambahTraining
	if($aksi=="tambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			?>
              <script src="librari/ckeditor/ckeditor.js"></script>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Training</th>
				</tr>
                <tr>
					<td valign="top">Nama Training</td>
					<td align="left"><input name="nama" type="text" size="80" value="" id="nama" class="validate[required]" /></td>
				</tr>
				<tr>
					<td valign="top">Deskripsi Singkat</td>
					<td align="left"><textarea name="ringkas" cols="80" rows="5" id="ringkas" class="validate[required]"></textarea></td>
				</tr>
                 <tr> 
					<td >Deskripsi Lengkap</td>
					<td ><textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" ></textarea></td>
				</tr>
                 <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /> <em>Ukuran gambar minimal <?php echo "$gambarl_maxw x $gambarl_maxh pixel"; ?></em></td>
			  </tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Training" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	//SaveEditTraining
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
			$lengkap = desc($_POST['lengkap']);
			
				//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-section-$alias-$secid.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				$namagambarl = "$kanal-section-$alias-$secid-l.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
				
				if($gambarl){ 
					$vgambar = ",gambar='$namagambars',gambar1='$namagambarl'";
				}
			}


			$perintah = "update $nama_tabel set nama='$nama',alias='$alias',ringkas='$ringkas',lengkap='$lengkap' $vgambar where secid='$secid'";
			$hasil = sql($perintah);
			if($hasil)
			{
				$msg = base64_encode("Berhasil mengubah Training $nama dengan ID $secid");
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
	//EditTraining
	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			$sql = "select nama,secid,ringkas,alias,lengkap from $nama_tabel  where secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$nama = $row['nama'];
			$secid = $row['secid'];
			$url = $row['url'];
			$ringkas = $row['ringkas'];
			$kode = $row['kode'];
			$lengkap = $row['lengkap'];

			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Training</th>
				</tr>
				<tr>
					<td valign="top">Nama Training</td>
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]" /></td>
				</tr>
				<tr>
					<td valign="top">Deskrispi Singkat</td>
					<td align="left"><textarea cols="70" rows="5" name="ringkas" id="ringkas" class="validate[required]"><?php echo $ringkas?></textarea></td>
				</tr>
                <tr> 
					<td >Deskrispi Lengkap</td>
					<td ><textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" ><?php echo $lengkap?></textarea></td>
				</tr>
                <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" />
				    <em>Ukuran gambar minimal <?php echo "$gambarl_maxw x $gambarl_maxh pixel"; ?></em></td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Training" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	//Vie Content
	if($aksi=="viewmateri")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$pageparam[] = array("secid",$secid);

			$mainmenu[] = array("Lihat Training","category","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Materi","lihat","$alamat&aksi=viewmateri");
			$mainmenu[] = array("Tambah Materi","tambah","$alamat&aksi=tambahmateri");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");
			$cari[] = array("ringkas","Ringkas","str","text","$data");
			$cari[] = array("oleh","Fotografer","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");

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

			$sql = "select id,nama,ringkas,published,secid,gambar from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=15%><a href=\"$urlorder&order=id\" title=\"Urutkan\">Preview</a></th>\n");
			print("<th width=60%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">Kategori</a></th>\n");
			print("<th width=5%>Diskusi</th>\n");
			print("<th width=5%>Views</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id = $row['id'];
				$nama = $row['nama'];
				$ringkas = $row['ringkas'];
				$published = $row['published'];
				$secid = $row['secid'];
				$gambar = $row['gambar'];

				if(empty($gambar)) $gambar = "Masih kosong";
				else $gambar = "<img src=\"../gambar/$kanal/$gambar\" style=\"width:200px\" alt=\"\" />";

				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				 
				$kategori = sql_get_var("select nama from $nama_tabel where secid='$secid'");

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td valign=top>$gambar</td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=detailmateri&id=$id&secid=$secid&hlm=$hlm\">$nama</a></b><br clear=\"all\" /> $ringkas</td>\n
					<td  valign=top >$kategori</td>
					<td  valign=top >$komentar</td>
					<td  valign=top >$view</td>
					<td  valign=top >$publish</td>");

				print("<td>");

				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publishmateri&secid=$secid&id=$id&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publishmateri&secid=$secid&id=$id&hlm=$hlm");

				$acc[] = array("Detail","detail","$alamat&aksi=detailmateri&id=$id&secid=$secid&hlm=$hlm");
				$acc[] = array("Edit","edit","$alamat&aksi=editmateri&id=$id&secid=$secid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapusmateri&id=$id&secid=$secid&hlm=$hlm");

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
	if($aksi=="detailmateri")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewmateri&secid=$secid");
			mainaction($mainmenu,$param);

			$sql = "select id,nama,ringkas,oleh,alias,lengkap,gambar,gambar1,video,create_date,create_userid,update_date,update_userid from $nama_tabel1  where id='$id' and secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$id = $row['id'];
			$nama = $row['nama'];
			$ringkas = $row['ringkas'];
			$oleh = $row['oleh'];
			$alias = $row['alias'];
			$lengkap = $row['lengkap'];
			$gambar = $row['gambar'];
			$gambar1 = $row['gambar1'];
			$video = $row['video'];
			$create_date = tanggal($row['create_date']);

			if(!empty($gambar)) $gambar = "<img src=\"../gambar/$kanal/$gambar\" alt=\"\" />"; else $gambar = "Masih kosong";
			if(!empty($gambar1)) $gambar1 = "<img src=\"../gambar/$kanal/$gambar1\" alt=\"\" />"; else $gambar1 = "Masih kosong";

			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
				<tr>
					<td valign="top" width="20%" class="tdinfo">Judul</td>
					<td align="left"><?php echo $nama?></td>
				</tr>
                <tr>
					<td valign="top" width="20%" class="tdinfo">Alias</td>
					<td align="left"><?php echo $alias?></td>
				</tr>
                <tr>
					<td  class="tdinfo">Ringkas</td>
					<td ><?php echo $ringkas?></td>
				</tr>
                 <tr>
					<td  class="tdinfo">Lengkap</td>
					<td ><?php echo $lengkap?></td>
				</tr>
                <tr>
					<td class="tdinfo">Tanggal Buat</td>
					<td><?php echo $create_date?></td>
				</tr>
                <tr>
					<td class="tdinfo" >Gambar Kecil</td>
					<td><?php echo $gambar?></td>
				</tr>
                <tr>
					<td class="tdinfo" >Gambar Besar</td>
					<td><?php echo $gambar1?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Video</td>
					<td>
					<?php 
					if(empty($video))
					{
						echo "Video masih kosong";
					}
					else
					{
					 $video = "../gambar/$kanal/$video";
					
					?>
					<script src="librari/videoplayer/jwplayer.js"></script>
                    <div id='my-video'></div>
					<script type='text/javascript'>
                        jwplayer('my-video').setup({
                            file: '<?php echo $video?>',
                            image: '<?php echo $gambar1?>',
                            width: '640',
                            height: '360'
                        });
                    </script>
					<?php
					}
					?>
				</td>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=editmateri&secid=$secid&id=$id"?>'" value="Ubah Data">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	//Hapus
	if($aksi=="hapusmateri")
	{

		if(!$oto['delete']) { echo $error['delete']; }
		else
        {

			$id = $_GET['id'];
			$perintah 	= "select gambar,gambar1,video from $nama_tabel1 where id='$id' and secid='$secid'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);

			$gambar 	= $row['gambar'];
			$gambar1 	= $row['gambar1'];
			$video 	= $row['video'];

			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
			if(!empty($gambar1)) unlink("$pathfile$kanal/$gambar1");
			if(!empty($video)) unlink("$pathfile$kanal/$video");


			$perintah = "delete from $nama_tabel1 where id='$id' and secid='$secid'";
			$hasil = sql($perintah);
			if($hasil)
			{
				$msg = base64_encode("Success mengapus materi dengan ID $id");
				header("location: $alamat&aksi=viewmateri&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewmateri&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Publish
	if($aksi=="publishmateri")
	{

		if(!$oto['edit']) { echo $error['edit']; }
		else
        {

			$id = $_GET['id'];

			$perintah 	= "select published from $nama_tabel1 where id='$id' and secid='$secid'";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['published']=="0") $status = 1;
				else $status=0;

			$perintah 	= "update $nama_tabel1 set published='$status' where id='$id' and secid='$secid'";
			$hasil		= sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Success merubah status data dengan ID $id");
				header("location: $alamat&aksi=viewmateri&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=viewmateri&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}



	//SaveTambah
	if($aksi=="savetambahmateri")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama = cleaninsert($_POST['nama']);
			$ringkas = cleaninsert($_POST['ringkas']);
			$oleh = cleaninsert($_POST['oleh']);
			$alias = getAlias($nama);
			$lengkap = desc($_POST['lengkap']);

				//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$new.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				$namagambarl = "$kanal-$alias-$new-l.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
				
				if($gambarl){ 
					$fgambar = ",gambar,gambar1";
					$vgambar = ",'$namagambars','$namagambarl'";
				}
			}
			
			if($_FILES['video']['size']>0)
			{
				$namavideo = "$kanal-video-$alias-$id.mp4";
				copy($_FILES['video']['tmp_name'],"$pathfile/$kanal/$namavideo");
				
				if(file_exists("$pathfile/$kanal/$namavideo")){ 
					$fvideo = ",video";
					$vvideo = ",'$namavideo'";
				}
			}

			$perintah = "insert into $nama_tabel1(id,secid,nama,alias,ringkas,lengkap,oleh,create_date,create_userid,published $fgambar $fvideo)
						values ('$new','$secid','$nama','$alias','$ringkas','$lengkap','$oleh','$date','$cuserid','1' $vgambar $vvideo)";
			$hasil = sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=viewmateri&hlm=$hlm&msg=$msg&secid=$secid");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewmateri&hlm=$hlm&msg=$msg&secid=$secid");
				exit();
			}
		}
	}

	//Tambah
	if($aksi=="tambahmateri")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
             <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});

			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
			<input type="hidden" name="aksi" value="savetambahmateri">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Materi</th>
				</tr>
				<tr>
					<td width="15%">Judul</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr>
					<td >Ringkas</td>
					<td ><textarea name="ringkas" cols="76" rows="5" id="ringkas" class="validate[required]"></textarea></td>
				</tr>
                  <tr> 
					<td >Lengkap</td>
					<td ><textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" ></textarea></td>
				</tr>
                 <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /> <em>Ukuran gambar minimal <?php echo "$gambarl_maxw x $gambarl_maxh pixel"; ?></em></td>
			  </tr>
              
               <tr> 
					<td >Video</td>
					<td><input name="video" type="file" size="20" value="" id="video" title="Pilih Video Dari Drive" class="file" /> <em>Video harus berformat MP4 dengan maksimum upload <strong><?php echo ini_get("upload_max_filesize"); ?></strong></em></td>
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

	if($aksi=="saveeditmateri")
	{

		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_POST['id'];
			$nama = cleaninsert($_POST['nama']);
			$ringkas = cleaninsert($_POST['ringkas']);
			$oleh = cleaninsert($_POST['oleh']);
			$alias = getAlias($nama);
			$lengkap = desc($_POST['lengkap']);

			die("here");
			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");

			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$id.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);

				$namagambarl = "$kanal-$alias-$id-l.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);

				if($gambarl){
					$vgambar = ",gambar='$namagambars',gambar1='$namagambarl'";
				}
			}
			
			if($_FILES['videos']['size']>0)
			{
				die("here");
				$namavideo = "$kanal-video-$alias-$id.mp4";
				copy($_FILES['videos']['tmp_name'],"$pathfile/$kanal/$namavideo");
				
				if(file_exists("$pathfile/$kanal/$namavideo")){ 
					$vvideo = ",video='$namavideo'";
				}
			}

			$perintah = "update $nama_tabel1 set nama='$nama',secid='$secid',alias='$alias',ringkas='$ringkas',lengkap='$lengkap',oleh='$oleh',
						update_date='$date',update_userid='$cuserid' $vgambar $vvideo where id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=viewmateri&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewmateri&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editmateri")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewmateri&secid=$secid");
			mainaction($mainmenu,$param);

			$sql = "select id,nama,ringkas,oleh,secid,lengkap from $nama_tabel1  where id='$id' and secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$id = $row['id'];
			$nama = $row['nama'];
			$ringkas = $row['ringkas'];
			$lengkap = $row['lengkap'];
			$oleh = $row['oleh'];
			$secid = $row['secid'];


			?>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditmateri">
            <input type="hidden" name="id" value="<?php echo $id?>">
             <input type="hidden" name="secid" value="<?php echo $secid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr>
					<td valign="top">Judul</td>
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="70" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr>
					<td >Ringkas</td>
					<td ><textarea name="ringkas" cols="76" rows="5" id="ringkas" class="validate[required]"><?php echo $ringkas?></textarea></td>
				</tr>
               <tr> 
					<td >Lengkap</td>
					<td ><textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" ><?php echo $lengkap?></textarea></td>
				</tr>
                <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" />
				    <em>Ukuran gambar minimal <?php echo "$gambarl_maxw x $gambarl_maxh pixel"; ?></em></td>
				</tr>
                <tr> 
					<td >Video</td>
					<td><input name="videos" type="file" size="20" value="" id="videos" title="Pilih Video Dari Drive" class="file" /> <em>Video harus berformat MP4 dengan maksimum upload <strong><?php echo ini_get("upload_max_filesize"); ?></strong></em></td>
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