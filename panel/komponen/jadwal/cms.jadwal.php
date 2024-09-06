<?php 
//Variable halaman ini
$nama_tabel		= "tbl_jadwal_sholat";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];


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
			$mainmenu[] = array("Lihat Jadwal","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Jadwal","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");
			$cari[] = array("ringkas","Ringkas","str","text","$data");
			$cari[] = array("oleh","Penulis","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");
			
			$dataselect[] = array("0","Draft");
			$dataselect[] = array("1","Published");
			
			$cari[] = array("published","Status","select","select",$dataselect);

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
			
			$sql = "select id,kota,tanggal,imsyak,shubuh,dzuhur,ashar,maghrib,isya,published from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=id\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=kota\" title=\"Urutkan\">Kota</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=tanggal\" title=\"Urutkan\">Tanggal</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=imsyak\" title=\"Urutkan\">Imsyak</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=shubuh\" title=\"Urutkan\">Shubuh</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=dzuhur\" title=\"Urutkan\">Dzuhur</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=ashar\" title=\"Urutkan\">Ashar</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=maghrib\" title=\"Urutkan\">Maghrib</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=isya\" title=\"Urutkan\">Isya</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id       	= $row['id'];
				$kota      	= $row['kota'];
				$tanggal   	= tanggal($row['tanggal']);
				$imsyak 	= substr($row['imsyak'],0,5);
				$shubuh 	= substr($row['shubuh'],0,5);
				$dzuhur 	= substr($row['dzuhur'],0,5);
				$ashar 		= substr($row['ashar'],0,5);
				$maghrib 	= substr($row['maghrib'],0,5);
				$isya 		= substr($row['isya'],0,5);
				$published 	= $row['published'];
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top>&nbsp;<b>$id</b></td>
					<td  valign=top class=judul><b>$kota</b></td>\n
					<td  valign=top >$tanggal</td>
					<td  valign=top align=center>$imsyak</td>
					<td  valign=top align=center>$shubuh</td>
					<td  valign=top align=center>$dzuhur</td>
					<td  valign=top align=center>$ashar</td>
					<td  valign=top align=center>$maghrib</td>
					<td  valign=top align=center>$isya</td>
					<td  valign=top >$publish</td>");
					
				print("<td>");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				
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
	
	//Hapus
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id       = $_GET['id'];
			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $id");
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
			{
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
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
			$kota    	= cleaninsert($_POST['kota']);
			$tanggal 	= cleaninsert($_POST['tanggal']);
			$imsyak 	= cleaninsert($_POST['imsyak']);
			$shubuh 	= cleaninsert($_POST['shubuh']);
			$dzuhur 	= cleaninsert($_POST['dzuhur']);
			$ashar 		= cleaninsert($_POST['ashar']);
			$maghrib 	= cleaninsert($_POST['maghrib']);
			$isya 		= cleaninsert($_POST['isya']);
			
			$new 		= newid("id",$nama_tabel);

			$perintah 	= "insert into $nama_tabel(id,kota,tanggal,create_date,create_userid,imsyak,shubuh,dzuhur,ashar,maghrib,isya) 
						values ('$new','$kota','$tanggal','$date','$cuserid','$imsyak','$shubuh','$dzuhur','$ashar','$maghrib','$isya')";
			$hasil 		= sql($perintah);
			
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
            <script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
					$( "#tanggal" ).datepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					});
					$( "#imsyak" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#shubuh" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#dzuhur" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#ashar" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#maghrib" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#isya" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
				<tr> 
					<td width="15%">Kota</td>
					<td >
                    	<select name="kota" id="kota" class="validate[required]">
                        	<option value="Jakarta dan sekitarnya">Jakarta dan sekitarnya</option>
                            <option value="Bandung dan sekitarnya">Bandung dan sekitarnya</option>
                            <option value="Surabaya dan sekitarnya">Surabaya dan sekitarnya</option>
                        </select>
                    </td>
				</tr>
                <tr> 
					<td >Tanggal</td>
					<td ><input name="tanggal" type="text" size="20" value="" id="tanggal" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Imsyak</td>
					<td ><input name="imsyak" type="text" size="10" value="" id="imsyak" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Shubuh</td>
					<td ><input name="shubuh" type="text" size="10" value="" id="shubuh" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Dzuhur</td>
					<td ><input name="dzuhur" type="text" size="10" value="" id="dzuhur" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Ashar</td>
					<td ><input name="ashar" type="text" size="10" value="" id="ashar" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Maghrib</td>
					<td ><input name="maghrib" type="text" size="10" value="" id="maghrib" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Isya</td>
					<td ><input name="isya" type="text" size="10" value="" id="isya" class="validate[required]" /></td>
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
			$id 		= $_POST['id'];
			$kota    	= cleaninsert($_POST['kota']);
			$tanggal 	= cleaninsert($_POST['tanggal']);
			$imsyak 	= cleaninsert($_POST['imsyak']);
			$shubuh 	= cleaninsert($_POST['shubuh']);
			$dzuhur 	= cleaninsert($_POST['dzuhur']);
			$ashar 		= cleaninsert($_POST['ashar']);
			$maghrib 	= cleaninsert($_POST['maghrib']);
			$isya 		= cleaninsert($_POST['isya']);
	
			$perintah 	= "update $nama_tabel set kota='$kota',tanggal='$tanggal',imsyak='$imsyak',shubuh='$shubuh',dzuhur='$dzuhur',ashar='$ashar',maghrib='$maghrib',isya='$isya',
						update_date='$date',update_userid='$cuserid' where id='$id'";
			$hasil 		= sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
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
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select id,kota,tanggal,imsyak,shubuh,dzuhur,ashar,maghrib,isya from $nama_tabel where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id      	= $row['id'];
			$kota    	= $row['kota'];
			$tanggal 	= $row['tanggal'];
			$shubuh 	= $row['shubuh'];
			$dzuhur 	= $row['dzuhur'];
			$ashar 		= $row['ashar'];
			$maghrib 	= $row['maghrib'];
			$isya 		= $row['isya'];
			$imsyak 	= $row['imsyak'];
			
			?>
            <script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
					$( "#tanggal" ).datepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					});
					$( "#imsyak" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#shubuh" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#dzuhur" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#ashar" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#maghrib" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#isya" ).timepicker({
					  showOn: "button",
					  buttonImage: "template/images/clock.png",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
				});
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td width="15%">Kota</td>
					<td >
                    	<select name="kota" id="kota" class="validate[required]">
                        	<option value="Jakarta dan sekitarnya" <?php if($kota=="Jakarta dan sekitarnya") echo "selected='selected'"; ?>>Jakarta dan sekitarnya</option>
                            <option value="Bandung dan sekitarnya" <?php if($kota=="Bandung dan sekitarnya") echo "selected='selected'"; ?>>Bandung dan sekitarnya</option>
                            <option value="Surabaya dan sekitarnya" <?php if($kota=="Surabaya dan sekitarnya") echo "selected='selected'"; ?>>Surabaya dan sekitarnya</option>
                        </select>
                    </td>
				</tr>
                <tr> 
					<td >Tanggal</td>
					<td ><input name="tanggal" type="text" size="20" value="<?php echo $tanggal?>" id="tanggal" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Imsyak</td>
					<td ><input name="imsyak" type="text" size="10" value="<?php echo $imsyak?>" id="imsyak" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Shubuh</td>
					<td ><input name="shubuh" type="text" size="10" value="<?php echo $shubuh?>" id="shubuh" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Dzuhur</td>
					<td ><input name="dzuhur" type="text" size="10" value="<?php echo $dzuhur?>" id="dzuhur" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Ashar</td>
					<td ><input name="ashar" type="text" size="10" value="<?php echo $ashar?>" id="ashar" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Maghrib</td>
					<td ><input name="maghrib" type="text" size="10" value="<?php echo $maghrib?>" id="maghrib" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Isya</td>
					<td ><input name="isya" type="text" size="10" value="<?php echo $isya?>" id="isya" class="validate[required]" /></td>
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