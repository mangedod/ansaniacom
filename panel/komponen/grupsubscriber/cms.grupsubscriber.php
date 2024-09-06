<?php
//Variable halaman ini
$nama_tabel    = "tbl_subscriber";
$nama_tabel1   = "tbl_subscriber_group";
$judul_per_hlm = 25;
$otoritas      = kodeoto($kanal);
$oto           = $otoritas[0];
$gambars_maxw  = 394;
$gambars_maxh  = 250;
$gambarl_maxw  = 555;
$gambarl_maxh  = 312;
$gambarf_maxw  = 945;
$gambarf_maxh  = 532;

//Variable Umum
if(isset($_POST['userid'])) $userid = $_POST['userid'];
 else $userid = $_GET['userid'];

if(isset($_POST['groupid'])) $groupid = $_POST['groupid'];
 else $groupid = $_GET['groupid'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			// $mainmenu[] = array("Kategori","category","$alamat&aksi=viewsec");
			$mainmenu[] = array("Lihat Group","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Group","tambah","$alamat&aksi=tambahgroup");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Grup","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];

			//Orderring
			$order = getorder("groupid","asc",$pageparam,$param);
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

			$sql = "SELECT `groupid`,`nama` from $nama_tabel1 where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=60%><a href=\"$urlorder&order=groupid\" title=\"Urutkan\">Grup</a></th>\n");
			print("<th width=5% align=center><b>Subcriber</b></th><th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$groupid       = $row['groupid'];
				$judul           = $row['nama'];
				$jum1 = sql_get_var("select count(*) as jml from $nama_tabel where groupid='$groupid'");

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm\">$judul</a></b><br clear=\"all\" /> $keterangan</td>\n
					");
				print("<td align=center>$jum1</td>");
				print("<td>");

				$acc[] = array("Detail","detail","$alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapusgroup&groupid=$groupid&hlm=$hlm");

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
	
	//Vie Content
	if($aksi=="viewcontent")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Subcriber Group","category","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Subcriber","lihat","$alamat&aksi=viewcontent&groupid=$groupid");
			$mainmenu[] = array("Tambah Subcriber","tambah","$alamat&aksi=tambah&groupid=$groupid");
			$mainmenu[] = array("Import Subcriber","tambah","$alamat&aksi=import&groupid=$groupid");
			$mainmenu[] = array("Export Subcriber","export","$alamat&aksi=export&groupid=$groupid&notemplate=1");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("userfullname","Nama Lengkap","str","text","$data");
			$cari[] = array("useremail","Email","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];

			//Orderring
			$order = getorder("userfullname","asc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];


			$sql = "select count(*) as jml from $nama_tabel where groupid='$groupid' $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "SELECT `userid`,`groupid`,`userfullname`,`useremail`,`status`,`create_date` from $nama_tabel where groupid='$groupid' $where $parorder 
					limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			// print("<th width=5%><a href=\"$urlorder&order=id\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=40%><a href=\"$urlorder&groupid=$groupid&order=userfullname\" title=\"Urutkan\">Nama Lengkap</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&groupid=$groupid&order=useremail\" title=\"Urutkan\">Email</a></th>\n");
			print("<th width=10% align=center><b>Status</b></th><th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$userid 		= $row['userid'];
				$groupid       	= $row['groupid'];
				$userfullname   = $row['userfullname'];
				$useremail      = $row['useremail'];
				$useraddress    = $row['useraddress'];
				$status         = $row['status'];
				$create_date    = $row['create_date'];
				
				if($status==1)
					$stat="<font style=\"color:#dc190a\">Bounce</font>";
				else
					$stat="Aktif";
					
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<!-- <td width=5% height=20 valign=top>&nbsp;<b>$groupid</b></td> -->
					<td  valign=top class=judul><b>$userfullname</b></td>\n
					<td  valign=top >$useremail</td>
					<td  valign=top >$stat</td>
					");

				print("<td>");

				$acc[] = array("Edit","edit","$alamat&aksi=edit&groupid=$groupid&userid=$userid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&groupid=$groupid&userid=$userid&hlm=$hlm");

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

			$perintah = "delete from $nama_tabel where userid='$userid'";
			$hasil = sql($perintah);
			if($hasil)
			{
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $userid");
				header("location: $alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Hapus
	if($aksi=="hapusgroup")
	{

		if(!$oto['delete']) { echo $error['delete']; }
		else
        {

			$perintah = "delete from $nama_tabel where groupid='$groupid'";
			$hasil = sql($perintah);
			if($hasil)
			{
				$query =sql("delete from $nama_tabel1 where groupid='$groupid'");
				
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $groupid");
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
        	$userfullname      	= cleaninsert($_POST['userfullname']);
        	$useremail      	= cleaninsert($_POST['useremail']);
        	$useraddress      	= cleaninsert($_POST['useraddress']);
			
			if(filter_var($useremail, FILTER_VALIDATE_EMAIL)){}else
			{
				$error = base64_encode("Invalid Email Address, Unsuccessfull add new subscribers, please try again");
				header("location: $alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm&error=$error");
				exit();
			}

			$new 				= newid("userid",$nama_tabel);

			$perintah = "insert into $nama_tabel(`userid`,`groupid`,`userfullname`,`useremail`,create_date,create_userid)
						values ('$new','$groupid','$userfullname','$useremail','$date','$cuserid')";
			$hasil = sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm&error=$error");
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
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewcontent&groupid=$groupid");
			mainaction($mainmenu,$param);
			
			$namagrup 	= sql_get_var("SELECT nama from $nama_tabel1 where groupid='$groupid'");

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
					<th colspan="2">Tambah Data</th>
				</tr>
                <tr>
					<td width="176">Grup</td>
					<td width="471">
                    <input name="groupid" type="hidden" size="20" value="<?php echo $groupid?>" id="groupid" />
                    <input name="groupid_text" type="text" size="20" value="<?php echo $namagrup?>" id="groupid_text" class="validate[required]" readonly="readonly" />
				</tr>
				<tr>
					<td width="15%">Nama Lengkap</td>
					<td ><input name="userfullname" type="text" size="70" value="" id="userfullname" class="validate[required]" /></td>
				</tr>
                <tr>
					<td width="15%">Email</td>
					<td ><input name="useremail" type="text" size="70" value="" id="useremail" class="validate[required]" /></td>
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
        	$userfullname      	= cleaninsert($_POST['userfullname']);
        	$useremail      	= cleaninsert($_POST['useremail']);
        	$useraddress      	= cleaninsert($_POST['useraddress']);
			
			if(filter_var($useremail, FILTER_VALIDATE_EMAIL)){}else
			{
				$error = base64_encode("Invalid Email Address, Unsuccessfull add new subscribers, please try again");
				header("location: $alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm&error=$error");
				exit();
			}
			
			$perintah 	= "update $nama_tabel set `groupid`='$groupid',`userfullname`='$userfullname',`useremail`='$useremail',
						update_date='$date',update_userid='$cuserid' $vgambar $vval where userid='$userid'";
			//die($perintah);
			$hasil 		= sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil mengubah data dengan ID $userid");
				header("location: $alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$userid = $_GET['userid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewcontent&groupid=$groupid");
			mainaction($mainmenu,$param);

			$sql = "select `userid`,`groupid`,`userfullname`,`useremail` from $nama_tabel where userid='$userid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$userid = $row['userid'];
			$groupid       = $row['groupid'];
			$userfullname  = $row['userfullname'];
			$useremail     = $row['useremail'];
			$useraddress   = $row['useraddress'];

			$namagrup 	= sql_get_var("SELECT nama from $nama_tabel1 where groupid='$groupid'");
			?>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="userid" value="<?php echo $userid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr>
					<td width="15%">Nama Lengkap</td>
					<td ><input name="userfullname" type="text" size="70" value="<?php echo $userfullname?>" id="userfullname" class="validate[required]" /></td>
				</tr>
                <tr>
					<td width="15%">Email</td>
					<td ><input name="useremail" type="text" size="70" value="<?php echo $useremail?>" id="useremail" class="validate[required]" /></td>
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
					$error = base64_encode("Unsuccessfull add new subscribers, file import must CSV Format, please try again");
					header("location: $alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm&error=$error");
					exit();
				}
				
				if(!is_dir("$lokasimedia/subscriber")) mkdir("$lokasimedia/subscriber");
				$lokasifile = "$lokasimedia/subscriber";
				
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
					$lines=explode(";",$text);
					$fullname = $lines[0];
					$email = $lines[1];
					$useraddress = $lines[2];
					
					if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$valid++;
						
						if(empty($allowdupicate))
						{
							$jum = sql_get_var("select count(*) as jml from tbl_subscriber where useremail='$email' and groupid='$groupid'");
						
							if($jum<1)
							{
								$perintah = "insert into tbl_subscriber(groupid,userfullname,useremail,useraddress,create_date,create_userid) 
								values ('$groupid','$fullname','$email','$useraddress','$date','$cuserid')";
								$hasil = sql($perintah);
							}
						}
						else
						{
							$perintah = "insert into tbl_subscriber(groupid,userfullname,useremail,useraddress,create_date,create_userid) 
							values ('$groupid','$fullname','$email','$useraddress','$date','$cuserid')";
							$hasil = sql($perintah);
						}
						
					}
					else
					{
						$invalid++;
					}
				
				}
			
				fclose($file_handle);
				
				//Delete Temp File
				unlink("$lokasifile/$namafile");
				
				$msg = base64_encode("Add new subscribers successfull via CSV Import. $valid Subcribers with valid email and $invalid subscribers not import cause invalid email.");
				header("location: $alamat&aksi=viewcontent&groupid=$groupid&hlm=$hlm&msg=$msg");
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
			
			$namagrup 	= sql_get_var("SELECT nama from $nama_tabel1 where groupid='$groupid'");

			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
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
                    <input name="groupid" type="hidden" size="20" value="<?php echo $groupid?>" id="groupid" />
                    <input name="groupid_text" type="text" size="20" value="<?php echo $namagrup?>" id="groupid_text" class="validate[required]" readonly="readonly" />
                    <!--<a href="#" class="apop" onclick="popgroupid()">..</a>--></td>
				</tr>
				<tr>
					<td width="15%">Option </td>
					<td ><input type="checkbox" name="allowdupicate" checked="checked"> Allow duplicate email in groups</td>
				</tr>
                <tr>
					<td width="15%">File Upload</td>
					<td ><input type="file" name="userfile" class="validate[required]" size="70" id="exampleInputName1"></td>
				</tr>
                <tr>
					<td width="15%">&nbsp;</td>
					<td >Sebelum impor database data pelangggan, Anda harus membaca beberapa catatan tentang fitur ini. <br />
                    	File impor harus format CSV dengan ukuran tidak lebih dari <strong> 
						<?php 
							$size=ini_get("upload_max_filesize");
							$size2=formatSizeUnits($size);
							echo $size2;
						?></strong>.<br />
						CSV berisi 3 coloum: Subcriber Nama, Alamat Email dan Alamat</td>
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
	
	//Edit Data
	if($aksi=="export")
	{
		
		include_once("librari/excelwriter/xlsxwriter.class.php");
		$filename = "subscriber-group-$groupid.xlsx";
		
		header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		
		$header = array(
			'No'=>'integer',
			'Grup'=>'string',
			'Nama Lengkap'=>'string',
			'Email'=>'string',
			'Alamat'=>'string',
		);
		
		$writer = new XLSXWriter();
		$writer->writeSheetHeader('Sheet1', $header );//optional
		$sql = "select userid,groupid,userfullname,useremail,useraddress from tbl_subscriber where groupid='$groupid' order by userid asc";
		$hsl = sql($sql);
		$no = 1;
		while($row = sql_fetch_data($hsl))
		{
			$userid= $row['userid'];
			$userfullname    = $row['userfullname'];
			$useremail       = $row['useremail'];
			$useraddress	= $row['useraddress'];
			
			$namagroup       = sql_get_var("select nama from tbl_subscriber_group where groupid = '$groupid'");
			
			$writer->writeSheetRow('Sheet1',array("$no","$namagroup","$userfullname","$useremail","$useraddress"));
			$no++;
		}
		
		$writer->writeToStdOut();
		exit(0);
	}
	
	//Tambah
	if($aksi=="tambahgroup")
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
			<input type="hidden" name="aksi" value="savetambahgroup">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>

				<tr>
					<td width="15%">Nama Group</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
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
	
	//SaveTambah
	if($aksi=="savetambahgroup")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
        	$nama = cleaninsert($_POST['nama']);

			$new = newid("groupid",$nama_tabel1);

			$perintah = "insert into $nama_tabel1(groupid,nama,create_date,create_userid)
						values ('$new','$nama','$date','$cuserid')";
			//die($perintah);
			$hasil = sql($perintah);

			if($hasil)
			{
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
}

?>