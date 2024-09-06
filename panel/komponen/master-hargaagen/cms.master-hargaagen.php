<?php 
//Variable halaman ini
$nama_tabel		= "tbl_agen";
$nama_tabel1	= "tbl_ongkos";
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
			$mainmenu[] = array("Import Excel ","tambah","$alamat&aksi=import");
			mainaction($mainmenu,$pageparam);
			
	
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Agen","str","text","$data");
			$cari[] = array("keterangan","Keterangan","str","text","$data");

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
			
			$sql = "select agenid,nama,keterangan,logo from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=5%>AgenID</th>\n");
			print("<th width=55%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Agen</a></th>\n");
			print("<th width=10%>Logo</th>");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama 	= $row['nama'];
				$logo 	= $row['logo'];
				$ringkas= $row['keterangan'];
				$agenid= $row['agenid'];
				
				if(empty($logo)) $logo = "Masih kosong";
				else $logo = "<img src=\"../gambar/master-agen/$logo\" style=\"width:50px\" alt=\"\" />";
				
				print("<tr class=\"row$i\"><td height=20 valign=top>&nbsp;$a</td><td height=20 valign=top>&nbsp;$agenid</td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=viewkota&agenid=$agenid\"><b>$nama</b></a><br />$ringkas</td>\n");
				print("<td valign=top class=hitam>$logo</td>\n");
				print("<td>");
				$acc[] = array("Lihat Tarif","view","$alamat&aksi=viewkota&agenid=$agenid");
								
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
	if($aksi=="viewkota")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$pageparam[] = array("agenid",$agenid);
			
			$mainmenu[] = array("Lihat Agen","category","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Data","lihat","$alamat&aksi=viewkota");
			$mainmenu[] = array("Tambah Data","tambah","$alamat&aksi=tambahkota");
			$mainmenu[] = array("Export Excel","excel","$alamat&aksi=exportxls");
			$mainmenu[] = array("Import Excel ","tambah","$alamat&aksi=import");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("kota","Nama Kota","str","text","$data");
			$cari[] = array("service","Service","str","text","$data");
			
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("kota","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];                                                                            
			
			if ((!empty($where)))
			{
				$_SESSION['whereprint']="$where";
			}
			
			if(empty($_SESSION['showfilter']))
			{
				unset($_SESSION['whereprint']);
			}
			
						
			$sql = "select count(*) as jml from $nama_tabel1 where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select id,kota,lama,harga,service from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=35%><a href=\"$urlorder&order=kota\" title=\"Urutkan\">Destinasi Tujuan</a></th>\n");
			print("<th width=35%><a href=\"$urlorder&order=service\" title=\"Urutkan\">Service</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=harga\" title=\"Urutkan\">Harga</a></th>\n");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id 		= $row['id'];
				$kota 		= $row['kota'];
				$lama 	= $row['lama'];
				$harga 	= $row['harga'];
				$service 	= $row['service'];
				
				$kategori   = sql_get_var("select nama from $nama_tabel where agenid='$agenid'");
				 
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td valign=top>$kota</td>
					<td  valign=top class=judul>$service</td>\n
					<td  valign=top >$harga</td>");
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=editkota&id=$id&agenid=$agenid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapuskota&id=$id&agenid=$agenid&hlm=$hlm");
								
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
	if($aksi=="hapuskota")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id = $_GET['id'];

			$perintah = "delete from $nama_tabel1 where id='$id' and agenid='$agenid'";
			$hasil = sql($perintah);
			if($hasil)
			{
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penghapusan data ongkos kirim dengan ID $id",$uri,$ip);   
				$msg = base64_encode("Success mengapus galeri dengan ID $id");
				header("location: $alamat&aksi=viewkota&agenid=$agenid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewkota&agenid=$agenid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//SaveTambah
	if($aksi=="savetambahkota")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$kota = cleaninsert($_POST['kota']);
			$service_code = cleaninsert($_POST['service_code']);
			$service = cleaninsert($_POST['service']);
			$harga = cleaninsert($_POST['harga']);
			
					
			$perintah = "insert into $nama_tabel1(id,agenid,kota,service_code,service,harga,create_date,create_userid) 
						values ('$new','$agenid','$kota','$service_code','$service','$harga','$date','$cuserid')";
			$hasil = sql($perintah);
			
			
			if($hasil)
			{  
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penambahan data Ongkos Kirim dengan ID $new",$uri,$ip); 
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=viewkota&hlm=$hlm&msg=$msg&agenid=$agenid");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewkota&hlm=$hlm&msg=$msg&agenid=$agenid");
				exit();
			}
		}
	}
	
	//Tambah
	if($aksi=="tambahkota")
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
				function popagenid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=berita&aksi=popagenid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("agenid").value = res.agenid;
							document.getElementById("agenid_text").value = res.agenid_text;
						}
						return false;
				}
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
            <input type="hidden" name="agenid" value="<?php echo $agenid?>">
			<input type="hidden" name="aksi" value="savetambahkota">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
				<tr> 
					<td width="15%">Destinasi Tujuan</td>
					<td ><input name="kota" type="text" size="70" value="" id="kota" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Service Kode</td>
					<td ><input name="service_code" type="text" size="70" value="" id="service_code" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Service</td>
					<td><input name="service" type="text" size="70" value="" id="service" class="validate[required]" /></td>
				</tr>
                 <tr> 
					<td >Harga</td>
					<td><input name="harga" type="text" size="20" value="" id="harga" class="validate[required]" /></td>
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
	
	if($aksi=="saveeditkota")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id 	= $_POST['id'];
			$kota = cleaninsert($_POST['kota']);
			$service_code = cleaninsert($_POST['service_code']);
			$service = cleaninsert($_POST['service']);
			$harga = cleaninsert($_POST['harga']);
			
			
			$perintah = "update $nama_tabel1 set kota='$kota',agenid='$agenid',service_code='$service_code',service='$service',harga='$harga',
						update_date='$date',update_userid='$cuserid' where id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Perubahan data ongkos kirim dengan ID $id",$uri,$ip);  
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=viewkota&agenid=$agenid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewkota&agenid=$agenid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editkota")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewkota&agenid=$agenid");
			mainaction($mainmenu,$param);
			
			$sql = "select id,kota,service_code,harga,service,agenid from $nama_tabel1  where id='$id' and agenid='$agenid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$kota = $row['kota'];
			$service_code = $row['service_code'];
			$harga = $row['harga'];
			$service = $row['service'];
			$agenid = $row['agenid'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popagenid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=berita&aksi=popagenid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("agenid").value = res.agenid;
							document.getElementById("agenid_text").value = res.agenid_text;
						}
						return false;
				}
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
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditkota">
            <input type="hidden" name="id" value="<?php echo $id?>">
             <input type="hidden" name="agenid" value="<?php echo $agenid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td width="15%">Destinasi Tujuan</td>
					<td ><input name="kota" type="text" size="70" value="<?php echo $kota?>" id="kota" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Service Kode</td>
					<td ><input name="service_code" type="text" size="70" value="<?php echo $service_code?>" id="service_code" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Service</td>
					<td><input name="service" type="text" size="70" value="<?php echo $service?>" id="service" class="validate[required]" /></td>
				</tr>
                 <tr> 
					<td >Harga</td>
					<td><input name="harga" type="text" size="20" value="<?php echo $harga?>" id="harga" class="validate[required]" /></td>
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
	
	elseif(($aksi=="exportxls"))
	{
		if(!$oto['view']) { echo $error['view']; } else
		{

			/** Error reporting */


			/** PHPExcel */
			require_once "$lokasiweb/librari/Classes/PHPExcel.php";

			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();

			// Set properties
			$objPHPExcel->getProperties()->setCreator("Klik4It")
										 ->setLastModifiedBy("Klik4It")
										 ->setTitle("Office 2007 XLSX Ongkos Kirim")
										 ->setSubject("Office 2007 XLSX Ongkos Kirim")
										 ->setDescription("Transaksi for Office 2007 XLSX, generated using PHP classes.")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Test result file");

			// Create a sheet
			$objPHPExcel->setActiveSheetIndex(0);


			//border
			$styleThinBlackBorderOutline = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),),),);

			$isijudul	= array("A1"=>"Agen ID","B1"=>"Nama Agen","C1"=>"Kota Destinasi","D1"=>"Service Code","E1"=>"Service","F1"=>"Lama","G1"=>"Harga");
			foreach($isijudul as $col=>$isi)
			{
				$objPHPExcel->getActiveSheet()->getCell("$col")->setValue("$isi");
			}

			

			$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray(array('borders' => array('allborders'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
			$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray(array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,)));
			// Set thin black border outline around column
			$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleThinBlackBorderOutline);

			//width column
			$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth("5");
			$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth("15");
			$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth("30");
			$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth("20");
			$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth("30");
			$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth("10");
			$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth("15");
			
			if (!empty($_SESSION['whereprint']))
			{
				$where=$_SESSION['whereprint'];	
			}
			$where .= "and agenid='$agenid'";

			$sql1 = "select * from $nama_tabel1 where 1 $where order by id desc limit 5000";

			$kartustok = array();
			$sumall        = 0;
			$hsl1           = sql($sql1);

			$i = 2;
			$a = 1;

			while ($row1 = sql_fetch_data($hsl1))
			{
				$id				= $row1['id'];
				$agenid			= $row1['agenid'];
				$kota			= $row1['kota'];
				$service_code	= $row1['service_code'];
				$service		= $row1['service'];
				$lama			= $row1['lama'];
				$harga			= $row1['harga'];

					$namaagen	= sql_get_var("select nama from tbl_agen where agenid='$agenid'");
					
				$ongkoskirim2		= number_format($harga,0,".",".");	

				$isidata	= array("A$i"=>$agenid,"B$i"=>$namaagen,"C$i"=>$kota,"D$i"=>$service_code,"E$i"=>$service,"F$i"=>$lama." hari","G$i"=>$harga);

				foreach($isidata as $col=>$isi)
				{
					$objPHPExcel->getActiveSheet()->getCell("$col")->setValue("$isi");
				}

				$objPHPExcel->getActiveSheet()->getStyle("A$i:G$i")->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle("A$i:G$i")->applyFromArray($styleThinBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle("A$i:G$i")->applyFromArray(array('borders' => array('allborders'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
				$objPHPExcel->getActiveSheet()->getStyle("A$i:G$i")->applyFromArray(array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,)));

				$a++;
				$i++;
			}


			sql_free_result($hsl1);
			//die();

			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle("Harga Tarif Ongkir");

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			/** PHPExcel_IOFactory */
			require_once "$lokasiweb/librari/Classes/PHPExcel/IOFactory.php";

			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header("Content-Disposition: attachment;filename=\"TarifOngkir-$tglname.xlsx\"");
			header('Cache-Control: max-age=0');

			$tglname = date("U");

			// Save Excel 2007 file
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("$lokasiweb/lapexcel/TarifOngkir-$tglname.xlsx");

			$link1	= "$fulldomain/lapexcel/TarifOngkir-$tglname.xlsx";
			header("location: ".$link1);

			exit;
		}
	}
	
	if($aksi=="bulksave")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
		{
			$daten	= date("U");
		
			$ext = $_FILES['bulk']['type'];
			$ext = explode("/",$ext);
			$ext = $ext[1];
			if($ext=="vnd.openxmlformats-officedocument.spreadsheetml.sheet")
			{
				$ext = substr($_FILES['bulk']['name'], -4);
			}
			$namaexcel 	= "stok-excel-$daten.$ext";
			$excel 		= copy($_FILES['bulk']['tmp_name'],"$pathfile/excel/$namaexcel");
			
			if($excel)
			{ 
				$xlname = "$pathfile/excel/$namaexcel";
				include($lokasiweb."librari/phpexcel/PHPExcel/IOFactory.php");
				
				try {
					$inputFileType = PHPExcel_IOFactory::identify($xlname);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($xlname);
				} catch (Exception $e) {
					die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
					. '": ' . $e->getMessage());
				}
				
				$sheet = $objPHPExcel->getSheet(0);
				$highestRow = $sheet->getHighestRow();
				$highestColumn = $sheet->getHighestColumn();
				
				$rowdatagudang = $sheet->rangeToArray('A1:' . $highestColumn . '1', NULL, TRUE, FALSE);
				$rowGudang = $rowdatagudang[0];
				//$highestRowGudang = count($rowGudang);
				
				$highestRowGudang	= sql_get_var("select count(*) as jml from tbl_warehouse");
				
				for($i=2;$i<=$highestRow;$i++)
				{
					$rowdata = $sheet->rangeToArray('A' . $i . ':' . $highestColumn . $i, NULL, TRUE, FALSE);

					$row = $rowdata[0];
					
					$agenid			= $row[0];
					$namaagen		= $row[1];
					$destinasi		= $row[2];
					$service_code	= $row[3];
					$service		= $row[4];
					$lama			= $row[5];
					$harga			= $row[6];
					
					$id = sql_get_var("select id from tbl_ongkos where agenid='$agenid' and kota='$destinasi' and service_code='$service_code'");

						
					if(empty($id))
					{
						$perintah 	= "insert into tbl_ongkos (`agenid`,`kota`,`service_code`,`service`,`lama`,`harga`, create_userid, create_date) values ('$agenid`', '$destinasi', 
									'$service_code', '$service`', '$lama', '$harga', '$cuserid', '$date')";
						$hasil 		= sql($perintah);
					}
					else
					{
						$perintah 	= "update tbl_ongkos set harga='$harga', lama='$lama', service='$service', update_userid='$cuserid' 
									where agenid='$agenid' and kota='$destinasi' and service_code='$service_code' and id='$id'";
						$hasil 		= sql($perintah);
					}
										
				}

				if($hasil)
				{
					$msg = base64_encode("Berhasil ditambahkan Data baru");
					header("location: $alamat&msg=$msg");
					exit();
				}
				else
				{
					$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
					header("location: $alamat&error=$error");
					exit();
				}
	
	
			}		
		}
	}
	
	//Tambah
	if($aksi=="import")
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
			<input type="hidden" name="aksi" value="bulksave">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Upload Bulk</th>
				</tr>
                <tr>
					<td >Pilih Bundle Tarif Ongkir</td>
					<td><input name="bulk" type="file" size="20" value="" id="bulk" title="Pilih Bundle Tarif Ongkir Dari Drive" class="file"  multiple/><br />
                    <em>File harus berupa .xlsx (lihat standard) dan maksimum upload <?php echo ini_get("upload_max_filesize"); ?></em></td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Stok" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
                <tr>
				  <td valign="top">&nbsp;</td>
				  <td align="left">&nbsp;</td>
			    </tr>
				<tr>
				  <td valign="top">&nbsp;</td>
				  <td align="left">
			      <p>Untuk melihat contoh file excel silahkan download <a href="/gambar/sampletarif.xlsx" target="_blank">disini</a></strong></p>
			      </td>
			  </tr>
			</table>
			</form>

            <?php
		}
	}

}

?>