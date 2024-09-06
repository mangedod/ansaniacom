<?php
//Variable halaman ini
$nama_tabel    = "tbl_smsc_contact";
$nama_tabel1   = "tbl_smsc_contact_group";
$judul_per_hlm = 25;
$otoritas      = kodeoto($kanal);
$oto           = $otoritas[0];
$gambars_maxw  = 350;
$gambars_maxh  = 300;
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
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Group","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Group","tambah","$alamat&aksi=tambahsec");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Group","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];

			//Orderring
			$order = getorder("nama","asc",$pageparam,$param);
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

			$sql = "select secid,nama,keterangan from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=30%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Group</a></th>\n");
			print("<th width=40%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">Keterangan</a></th>\n");
			print("<th width=10%>Contact</th>\n");
			print("<th width=10%>Manage</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$secid = $row['secid'];
				$nama = $row['nama'];
				$keterangan = $row['keterangan'];
				
				$jml = sql_get_var("select count(*) as jml from $nama_tabel where secid='$secid'");

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama<br clear=\"all\" /></td>\n
					<td  valign=top >$keterangan</td>
					<td  valign=top >$jml contact</td>
					<td  valign=top ><a href=\"$alamat&aksi=viewcontact&secid=$secid\" class=\"btn btn-default\">manage</a></td>
				");

				print("<td>");

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

	//Vie Menu
	if($aksi=="viewcontact")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$pageparam[] = array('secid',$secid);
			
			
			
			$mainmenu[] = array("Group","category","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Contact","lihat","$alamat&aksi=viewcontact&secid=$secid");
			$mainmenu[] = array("Tambah Contact","tambah","$alamat&aksi=tambah&secid=$secid");
			$mainmenu[] = array("Import Contact","excel","$alamat&aksi=import&secid=$secid");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama","str","text",$data);
			$cari[] = array("company","Perusahaan","str","text",$data);
			$cari[] = array("email","Email","str","text",$data);
			$cari[] = array("hp","Mobile Phone","str","text",$data);
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];

			//Orderring
			$order = getorder("id","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			
			$namagrup = sql_get_var("select nama from $nama_tabel1 where secid='$secid'");

			$sql = "select count(*) as jml from $nama_tabel where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select id,nama,company,address,email,tlp,hp,secid from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><td colspan=8><strong>Group:</strong> $namagrup</td>\n");
			print("<tr><th width=1%>No</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=company\" title=\"Urutkan\">Perusahaan</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=email\" title=\"Urutkan\">Email</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=hp\" title=\"Urutkan\">Handphone</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id      = $row['id'];
				$nama    = $row['nama'];
				$company = $row['company'];
				$address = $row['address'];
				$email   = $row['email'];
				$tlp     = $row['tlp'];
				$hp      = $row['hp'];
				$secid   = $row['secid'];

				$group = sql_get_var("SELECT nama from $nama_tabel1 where secid='$secid'");

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama</td>\n
					<td  valign=top class=judul>$company</td>\n
					<td  valign=top class=judul>$hp</td>\n
					<td  valign=top class=judul>$email</td>\n");

				print("<td>");

				$acc[] = array("Edit","edit","$alamat&aksi=edit&id=$id&hlm=$hlm&secid=$secid");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&id=$id&hlm=$hlm&secid=$secid");

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
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $id");
				header("location: $alamat&aksi=viewcontact&hlm=$hlm&msg=$msg&secid=$secid");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewcontact&hlm=$hlm&error=$error&secid=$secid");
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
			$nama    = $_POST['nama'];
			$company = $_POST['company'];
			$address = $_POST['address'];
			$email   = $_POST['email'];
			$tlp     = $_POST['tlp'];
			$hp      = $_POST['hp'];
			$kota    = $_POST['kota'];
			$fax 	= $_POST['fax'];
			$pinbb 	= $_POST['pinbb'];
			$wa		= $_POST['wa'];
			$bagian     = $_POST['bagian'];
			$jabatan      = $_POST['jabatan'];
			$keterangan      = $_POST['keterangan'];

			$new = newid("id",$nama_tabel);

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

			$perintah = "insert into $nama_tabel(id,nama,company,address,email,tlp,hp,secid,kota,fax,pinbb,wa,bagian,jabatan,keterangan,create_userid,create_date)
						values ('$new','$nama','$company','$address','$email','$tlp','$hp','$secid','$kota','$fax','$pinbb','$wa','$bagian','$jabatan','$keterangan','$cuserid','$date')";
			$hasil = sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=viewcontact&hlm=$hlm&msg=$msg&secid=$secid");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewcontact&hlm=$hlm&error=$error&secid=$secid");
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
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewcontact&secid=$secid");
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
            <input type="hidden" name="secid" value="<?php echo $secid; ?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
                <tr> 
					<td width="176">Group</td>
					<td width="471">

                    	<?php 
						$grup = sql_get_var("select nama from $nama_tabel1 where secid='$secid'");
						echo $grup;
						?>
                     </select></td>
				</tr>
				<tr>
					<td width="15%">Nama</td>
					<td><input type="text" name="nama" size="40" value="" id="nama" class="validate[required]"></td>
				</tr>
				<tr>
					<td width="15%">Perusahaan</td>
					<td><input type="text" name="company" size="40" value="" id="company" ></td>
				</tr>
				
				<tr>
					<td width="15%">Email</td>
					<td><input type="text" name="email" size="40" value="" id="email" ></td>
				</tr>
				<tr>
					<td width="15%">Handphone</td>
					<td><input type="text" name="hp" size="40" value="" id="hp"  class="validate[required]"></td>
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

	if($aksi=="saveedit")
	{

		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id      = $_POST['id'];
			$nama    = $_POST['nama'];
			$company = $_POST['company'];
			$email   = $_POST['email'];
			$tlp     = $_POST['tlp'];
			$hp      = $_POST['hp'];
			$kota    = $_POST['kota'];
			$fax 	= $_POST['fax'];
			$pinbb 	= $_POST['pinbb'];
			$wa		= $_POST['wa'];
			$bagian     = $_POST['bagian'];
			$jabatan      = $_POST['jabatan'];
			$keterangan      = $_POST['keterangan'];

			$perintah = "update $nama_tabel set nama='$nama',company='$company',email='$email',tlp='$tlp',hp='$hp',secid='$secid',
						kota='$kota',fax='$fax',pinbb='$pinbb',wa='$wa',bagian='$bagian',jabatan='$jabatan',keterangan='$keterangan',
						update_date='$date',update_userid='$cuserid' where id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=viewcontact&hlm=$hlm&msg=$msg&secid=$secid");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewcontact&hlm=$hlm&error=$error&secid=$secid");
				exit();
			}
		}
	}

	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			$sql = "select id,nama,company,address,email,tlp,hp,secid,kota,fax,pinbb,wa,bagian,jabatan,keterangan from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$id      = $row['id'];
			$nama    = $row['nama'];
			$company = $row['company'];
			$address = $row['address'];
			$email   = $row['email'];
			$tlp     = $row['tlp'];
			$hp      = $row['hp'];
			$secid   = $row['secid'];
			$kota    = $row['kota'];
			$fax 	= $row['fax'];
			$pinbb 	= $row['pinbb'];
			$wa		= $row['wa'];
			$bagian     = $row['bagian'];
			$jabatan      = $row['jabatan'];
			$keterangan      = $row['keterangan'];

			$group = sql_get_var("SELECT nama from $nama_tabel1 where secid='$secid'");

			?>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
               <tr> 
					<td width="176">Kategori</td>
					<td width="471">
                    <?php 
						$grup = sql_get_var("select nama from $nama_tabel1 where secid='$secid'");
						echo $grup;
					?>
                        </td>
				</tr>
				<tr>
					<td width="15%">Nama</td>
					<td><input type="text" name="nama" size="40" value="<?php  echo $nama; ?>" id="nama" class="validate[required]"></td>
				</tr>
				<tr>
					<td width="15%">Perusahaan</td>
					<td><input type="text" name="company" size="40" value="<?php  echo $company; ?>" id="company" ></td>
				</tr>
			
				<tr>
					<td width="15%">Email</td>
					<td><input type="text" name="email" size="40" value="<?php  echo $email; ?>" id="email" ></td>
				</tr>
				<tr>
					<td width="15%">Handphone</td>
					<td><input type="text" name="hp" size="40" value="<?php  echo $hp; ?>" id="hp"  class="validate[required]"></td>
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

	

	//Hapus
	if($aksi=="hapussec")
	{

		if(!$oto['delete']) { echo $error['delete']; }
		else
        {

			$perintah = "delete from $nama_tabel1 where secid='$secid'";
			$hasil = sql($perintah);
			
			$perintah = "delete from $nama_tabel where secid='$secid'";
			$hasil = sql($perintah);
			
			if($hasil)
			{
				$msg = base64_encode("Success mengapus Data dengan ID $secid");
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

	//SaveTambahSec
	if($aksi=="savetambahsec")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama = cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$alias = getAlias($nama);

			$new = newid("secid",$nama_tabel1);

			$perintah = "insert into $nama_tabel1(secid,nama,alias,keterangan,create_date,create_userid $fgambar)
						values ('$new','$nama','$alias','$keterangan','$date','$cuserid' $vgambar)";
			$hasil = sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil ditambahkan Sec baru");
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
	if($aksi=="tambahsec")
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
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahsec">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Group</th>
				</tr>
				<tr>
					<td width="15%">Nama Group</td>
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
			$nama = cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$alias = getAlias($nama);


			$perintah = "update $nama_tabel1 set nama='$nama',alias='$alias',keterangan='$keterangan',
						update_date='$date',update_userid='$cuserid' where secid='$secid'";
			$hasil = sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil mengubah data dengan ID $secid");
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

	if($aksi=="editsec")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			$sql = "select secid,nama,keterangan from $nama_tabel1  where secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$secid = $row['secid'];
			$nama = $row['nama'];
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
					<th colspan="2">Edit Group</th>
				</tr>
				<tr>
					<td valign="top">Nama Group</td>
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
	
	
	if($aksi=="importsave")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
		
			$file = $_FILES['userfile'];
			$allowdupicate = $_POST['allowdupicate'];
		
			if($_FILES['userfile']['size'] > 0)
			{
				$filename = $_FILES['userfile']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
				if($ext!=="csv")
				{
					$error = base64_encode("Unsuccessfull add new subcribers, file import must CSV Format, please try again");
					header("location: $alamat&aksi=import&secid=$secid&hlm=$hlm&error=$error");
					exit();
				}
				
				if(!is_dir("$pathfile/contact")) mkdir("$pathfile/contact");
				$lokasifile = "$pathfile/contact";
				
				$namafile = date("Ymdhis").".csv";
				copy($_FILES['userfile']['tmp_name'],"$lokasifile/$namafile");
				
				//Process Import
				$valid = 0;
				$invalid = 0;
				
				$file_handle = fopen("$lokasifile/$namafile", "r");
				while (!feof($file_handle) )
				{
					$line_of_text = fgetcsv($file_handle, 1024);
					$text = $line_of_text[0];
					$lines = explode(";",$text);
					$fullname = $lines[0];
					$hp = trim($lines[1]);
					$email = $lines[2];
					$company = $lines[3];
					
					if(empty($allowdupicate))
					{
						$jum = sql_get_var("select count(*) as jml from $nama_tabel where hp='$hp' and groupid='$groupid'");
					
						if($jum<1 && !empty($hp))
						{
							$perintah = "insert into $nama_tabel(secid,nama,company,email,hp,create_date,create_userid) 
							values ('$secid','$fullname','$company','$email','$hp','$date','$cuserid')";
							$hasil = sql($perintah);
						}
					}
					else
					{
						if(!empty($hp))
						{
							$perintah = "insert into $nama_tabel(secid,nama,company,email,hp,create_date,create_userid) 
							values ('$secid','$fullname','$company','$email','$hp','$date','$cuserid')";
							$hasil = sql($perintah);
						}
					}
						
				
				
				}
			
				fclose($file_handle);
				
				//Delete Temp File
				unlink("$lokasifile/$namafile");
				
				$msg = base64_encode("Add new contact successfull via CSV Import");
				header("location: $alamat&aksi=viewcontact&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
				
			}
		}
	
	}
	//Tambah
	if($aksi=="import")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewcontent&groupid=$groupid");
			mainaction($mainmenu,$param);
			
			$namagrup 	= sql_get_var("SELECT nama from $nama_tabel1 where secid='$secid'");

			?>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="importsave">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
                <tr>
					<td width="176">Grup</td>
					<td width="471">
                    <input name="groupid" type="hidden" size="20" value="<?php echo $secid?>" id="groupid" />
                    <input name="groupid_text" type="text" size="20" value="<?php echo $namagrup?>" id="groupid_text" class="validate[required]" readonly="readonly" />
                    <!--<a href="#" class="apop" onclick="popgroupid()">..</a>--></td>
				</tr>
				<tr>
					<td width="15%">Option </td>
					<td ><input type="checkbox" name="allowdupicate" checked="checked"> Allow duplicate handphone in groups</td>
				</tr>
                <tr>
					<td width="15%">File Upload</td>
					<td ><input type="file" name="userfile" class="validate[required]" size="70" id="exampleInputName1"></td>
				</tr>
                <tr>
					<td width="15%">&nbsp;</td>
					<td >Sebelum impor database data contact, Anda harus membaca beberapa catatan tentang fitur ini. <br />
                    	File impor harus format CSV dengan ukuran tidak lebih dari <strong> 
						<?php 
							$size = ini_get("upload_max_filesize");
							echo $size;
						?></strong>.<br />
						CSV berisi 4 coloum: Nama,Nomor Handphone, Email, Perusahaan</td>
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
}

?>