<?php
//Variable halaman ini
$nama_tabel    = "tbl_customer";
$nama_tabel1   = "tbl_customer_sec";
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
if(isset($_POST['customerid'])) $customerid = $_POST['customerid'];
 else $customerid = $_GET['customerid'];

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
			$order = getorder("secid","asc",$pageparam,$param);
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

			$sql = "SELECT `secid`,`nama` from $nama_tabel1 where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=60%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">Grup</a></th>\n");
			print("<th width=5% align=center><b>Contact</b></th><th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$secid       = $row['secid'];
				$judul           = $row['nama'];
				$jum1 = sql_get_var("select count(*) as jml from $nama_tabel where secid='$secid'");

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=viewcontent&secid=$secid&hlm=$hlm\">$judul</a></b><br clear=\"all\" /> $keterangan</td>\n
					");
				print("<td align=center><a href=\"$alamat&aksi=viewcontent&secid=$secid&hlm=$hlm\" class=\"btn\">$jum1</a></td>");
				print("<td>");

				$acc[] = array("Detail","detail","$alamat&aksi=viewcontent&secid=$secid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapusgroup&secid=$secid&hlm=$hlm");

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
			$pageparam[] = array("secid",$secid);
			$mainmenu[] = array("View Group","category","$alamat&aksi=view");
			$mainmenu[] = array("View Subcriber","lihat","$alamat&aksi=viewcontent&secid=$secid");
			$mainmenu[] = array("Add Subcriber","tambah","$alamat&aksi=tambah&secid=$secid");
			$mainmenu[] = array("Import","tambah","$alamat&aksi=import&secid=$secid");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("userfullname","Nama Lengkap","str","text","$data");
			$cari[] = array("userphonegsm","Handphone","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];

			//Orderring
			$order = getorder("userfullname","asc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];


			$sql = "select count(*) as jml from $nama_tabel where secid='$secid' $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "SELECT `customerid`,`secid`,`userfullname`,`userphonegsm`,`status`,`create_date` from $nama_tabel where secid='$secid' $where $parorder	limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = ($judul_per_hlm * ($hlm-1)) + 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=40%><a href=\"$urlorder&secid=$secid&order=userfullname\" title=\"Urutkan\">Nama Lengkap</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&secid=$secid&order=userphonegsm\" title=\"Urutkan\">Handphone</a></th>\n");
			print("<th width=10% align=center><b>Status</b></th><th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$customerid 		= $row['customerid'];
				$secid       	= $row['secid'];
				$userfullname   = $row['userfullname'];
				$userphonegsm      = $row['userphonegsm'];
				$useraddress    = $row['useraddress'];
				$status         = $row['status'];
				$create_date    = $row['create_date'];
				
				if($status==1)
					$stat="<font style=\"color:#dc190a\">Bounce</font>";
				else
					$stat="Aktif";
					
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<!-- <td width=5% height=20 valign=top>&nbsp;<b>$secid</b></td> -->
					<td  valign=top class=judul><b>$userfullname</b></td>\n
					<td  valign=top >$userphonegsm</td>
					<td  valign=top >$stat</td>
					");

				print("<td>");

				$acc[] = array("Edit","edit","$alamat&aksi=edit&secid=$secid&customerid=$customerid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&secid=$secid&customerid=$customerid&hlm=$hlm");

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

			$perintah = "delete from $nama_tabel where customerid='$customerid'";
			$hasil = sql($perintah);
			if($hasil)
			{
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $customerid");
				header("location: $alamat&aksi=viewcontent&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewcontent&secid=$secid&hlm=$hlm&error=$error");
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

			$perintah = "delete from $nama_tabel where secid='$secid'";
			$hasil = sql($perintah);
			if($hasil)
			{
				$query =sql("delete from $nama_tabel1 where secid='$secid'");
				
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $secid");
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
        	$userphonegsm      	= cleaninsert($_POST['userphonegsm']);
        	$useraddress      	= cleaninsert($_POST['useraddress']);
			
			

			$new 				= newid("customerid",$nama_tabel);

			$perintah = "insert into $nama_tabel(`customerid`,`secid`,`userfullname`,`userphonegsm`,create_date,create_userid)
						values ('$new','$secid','$userfullname','$userphonegsm','$date','$cuserid')";
			$hasil = sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=viewcontent&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewcontent&secid=$secid&hlm=$hlm&error=$error");
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
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewcontent&secid=$secid");
			mainaction($mainmenu,$param);
			
			$namagrup 	= sql_get_var("SELECT nama from $nama_tabel1 where secid='$secid'");

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
                    <input name="secid" type="hidden" size="20" value="<?php  echo $secid?>" id="secid" />
                    <input name="secid_text" type="text" size="20" value="<?php  echo $namagrup?>" id="secid_text" class="validate[required]" readonly="readonly" />
				</tr>
				<tr>
					<td width="15%">Nama Lengkap</td>
					<td ><input name="userfullname" type="text" size="70" value="" id="userfullname" class="validate[required]" /></td>
				</tr>
                <tr>
					<td width="15%">Handphone</td>
					<td ><input name="userphonegsm" type="text" size="70" value="" id="userphonegsm" class="validate[required]" /></td>
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
        	$userphonegsm      	= cleaninsert($_POST['userphonegsm']);
        	$useraddress      	= cleaninsert($_POST['useraddress']);
			
		
			
			$perintah 	= "update $nama_tabel set `secid`='$secid',`userfullname`='$userfullname',`userphonegsm`='$userphonegsm',
						update_date='$date',update_userid='$cuserid' $vgambar $vval where customerid='$customerid'";
			//die($perintah);
			$hasil 		= sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil mengubah data dengan ID $customerid");
				header("location: $alamat&aksi=viewcontent&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewcontent&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$customerid = $_GET['customerid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewcontent&secid=$secid");
			mainaction($mainmenu,$param);

			$sql = "select `customerid`,`secid`,`userfullname`,`userphonegsm` from $nama_tabel where customerid='$customerid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$customerid = $row['customerid'];
			$secid       = $row['secid'];
			$userfullname  = $row['userfullname'];
			$userphonegsm     = $row['userphonegsm'];
			$useraddress   = $row['useraddress'];

			$namagrup 	= sql_get_var("SELECT nama from $nama_tabel1 where secid='$secid'");
			?>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="customerid" value="<?php  echo $customerid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr>
					<td width="15%">Nama Lengkap</td>
					<td ><input name="userfullname" type="text" size="70" value="<?php  echo $userfullname?>" id="userfullname" class="validate[required]" /></td>
				</tr>
                <tr>
					<td width="15%">Handphone</td>
					<td ><input name="userphonegsm" type="text" size="70" value="<?php  echo $userphonegsm?>" id="userphonegsm" class="validate[required]" /></td>
				</tr>

				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:window.location=('<?php  echo $alamat?>')" value="Batal">
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
					$error = base64_encode("Unsuccessfull add new customer, file import must CSV Format, please try again");
					header("location: $alamat&aksi=viewcontent&secid=$secid&hlm=$hlm&error=$error");
					exit();
				}
				
				if(!is_dir("$pathfile/subscriber")) mkdir("$pathfile/subscriber");
				$lokasifile = "$pathfile/subscriber";
				
				$namafile = date("Ymdhis").".csv";
				copy($_FILES['userfile']['tmp_name'],"$lokasifile/$namafile");
				
				//Process Import
				$valid = 0;
				$invalid = 0;
				
				$file_handle = fopen("$lokasifile/$namafile", "r");
				while (!feof($file_handle) )
				{
					$dts= fgetcsv($file_handle, 1024);
					$dt = explode(";",$dts[0]);
					$fullname = trim($dt[0]);
					$userphonegsm = trim($dt[1]);
					
					if(empty($fullname)) 
					{
						$f = explode("@",$email);
						$fullname = $f[0];
						$fullname = str_replace("."," ",$fullname);
						$fullname = str_replace("_"," ",$fullname);
						
					}
					
					$fullname = ucwords($fullname);
					$fullname = str_replace("'","",$fullname);
					
					
					if(strlen($userphonegsm) > 3) 
					{
						$valid++;
						
						if(empty($allowdupicate))
						{
							$jum = sql_get_var("select count(*) as jml from tbl_customer where userphonegsm='$userphonegsm' and secid='$secid'");
						
							if($jum<1)
							{
								$perintah = "insert into tbl_customer(secid,userfullname,userphonegsm,create_date,create_userid) 
								values ('$secid','$fullname','$userphonegsm','$date','$cuserid')";
								$hasil = sql($perintah);
							}
						}
						else
						{
							$perintah = "insert into tbl_customer(secid,userfullname,userphonegsm,create_date,create_userid) 
							values ('$secid','$fullname','$userphonegsm','$date','$cuserid')";
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
				
				$msg = base64_encode("Add new customer successfull via CSV Import. $valid Subcribers with valid email and $invalid customer not import cause invalid phonenumber.");
				header("location: $alamat&aksi=viewcontent&secid=$secid&hlm=$hlm&msg=$msg");
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
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewcontent&secid=$secid");
			mainaction($mainmenu,$param);
			
			$namagrup 	= sql_get_var("SELECT nama from $nama_tabel1 where secid='$secid'");

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
                    <input name="secid" type="hidden" size="20" value="<?php  echo $secid?>" id="secid" />
                    <input name="secid_text" type="text" size="20" value="<?php  echo $namagrup?>" id="secid_text" class="validate[required]" readonly="readonly" />
                    <!--<a href="#" class="apop" onclick="popsecid()">..</a>--></td>
				</tr>
				<tr>
					<td width="15%">Option </td>
					<td ><input type="checkbox" name="allowdupicate" checked="checked"> Allow duplicate phone number in groups</td>
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
						CSV berisi 2 coloum: Subcriber Nama, Alamat Handphone </td>
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
		$filename = "subscriber-group-$secid.xlsx";
		
		header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		
		$header = array(
			'No'=>'integer',
			'Grup'=>'string',
			'Nama Lengkap'=>'string',
			'Handphone'=>'string',
			'Alamat'=>'string',
		);
		
		$writer = new XLSXWriter();
		$writer->writeSheetHeader('Sheet1', $header );//optional
		$sql = "select customerid,secid,userfullname,userphonegsm,useraddress from tbl_subscriber where secid='$secid' order by customerid asc";
		$hsl = sql($sql);
		$no = 1;
		while($row = sql_fetch_data($hsl))
		{
			$customerid= $row['customerid'];
			$userfullname    = $row['userfullname'];
			$userphonegsm       = $row['userphonegsm'];
			$useraddress	= $row['useraddress'];
			
			$namagroup       = sql_get_var("select nama from tbl_subscriber_group where secid = '$secid'");
			
			$writer->writeSheetRow('Sheet1',array("$no","$namagroup","$userfullname","$userphonegsm","$useraddress"));
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

			$new = newid("secid",$nama_tabel1);

			$perintah = "insert into $nama_tabel1(secid,nama,create_date,create_userid)
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