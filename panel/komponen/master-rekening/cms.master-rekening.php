<?php 
//Variable halaman ini
$nama_tabel		= "tbl_norek";
$nama_tabel1	= "tbl_bank";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];

if(isset($_POST['bank'])) $bank = $_POST['bank'];
 else $bank = $_GET['bank'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//View Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Data","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Data","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("norek","No.Rekening","str","text","$data");
			$cari[] = array("atasnama","Atas Nama","str","text","$data");

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
			
			$sql = "select id,userid,bank,norek,atasnama,status from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=20%>Logo</th>\n");
			print("<th width=15%>Bank</th>\n");
			print("<th width=30%><a href=\"$urlorder&order=norek\" title=\"Urutkan\">No.Rekening</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=atasnama\" title=\"Urutkan\">Atas Nama</a></th>\n");
			print("<th width=10%>Status</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id 		= $row['id'];
				$userid 	= $row['userid'];
				$bank		= $row['bank'];
				$norek		= $row['norek'];
				$atasnama	= $row['atasnama'];
				
				$status          = $row['status'];
				
				if($status==0)
				{
					$status = "Tidak Aktif";
					$label 	= "";
				}
				else
				{
					$status = "Aktif";
					$label 	= "label-success";
				}
				
				$sql1	= "select namabank,logobank from $nama_tabel1 where bankid='$bank'";
				$query	= sql($sql1);
				$row	= sql_fetch_data($query);
				$namabank	= $row['namabank'];
				$logobank	= $row['logobank'];

				if(!empty($logobank)) $image_s = "<img src=\"../gambar/master-bank/$logobank\" alt=\"\" />"; else $image_s = "Masih kosong";
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top align=center>$image_s</td>
					<td  valign=top class=judul>$namabank</td>\n
					<td  valign=top >$norek</td>
					<td  valign=top >$atasnama</td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=publish&id=$id&hlm=$hlm\"><span class=\"label $label\">$status</span></a></b></td>
					");
					
				print("<td>");
				
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
	
	//Publish
	if($aksi=="publish")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			
			$perintah 	= "select status from $nama_tabel where id='$id' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['status']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set status='$status' where id='$id' ";
			$hasil		= sql($perintah);
		
			if($hasil)
			{
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Status Matauang dengan ID $id",$uri,$ip);   
				$msg = base64_encode("Berhasil merubah status data dengan ID $id");
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
	
	//View PopupBank
	if($aksi=="popupbankid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$var1    = $_GET['var1'];
			$var2    = $_GET['var2'];
			
			if(empty($var1) && empty($var2))
			{
				$var1 = "bankid";
				$var2 = "bankid_text";
			}
			?>
            	<script type="text/javascript">
				function pushdata(bankid,namabank)
				{
					 if (window.opener && !window.opener.closed)
					 {
					 	window.opener.$("#<?php echo $var1; ?>").val(bankid);
						window.opener.$("#<?php echo $var2; ?>").val(namabank);
					 } 
					  window.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("namabank","Nama Bank","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from $nama_tabel1 where 1 $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("namabank","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select namabank,bankid from $nama_tabel1 where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=namabank\" title=\"Urutkan\">Nama Bank</a></th>\n");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$namabank    = $row['namabank'];
				$bankid      = $row['bankid'];

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td valign=top class=judul>$namabank</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$bankid','$namabank');\">Select</button>");
				print("</td></tr>");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		}
	}
	//EndView PopupMenu
	
	//Hapus
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id = $_GET['id'];

			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penghapusan data Rekening dengan ID $id",$uri,$ip);   
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

	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
        	$bankid		= $_POST['bankid'];
			$norek 		= cleaninsert($_POST['norek']);
			$atasnama 	= cleaninsert($_POST['atasnama']);
			$privacy 	= cleaninsert($_POST['privacy']);
			
			$new = newid("id",$nama_tabel);
			
			$perintah = "insert into $nama_tabel(id,bank,norek,atasnama,privacy,create_date,create_userid) 
						values ('$new','$bankid','$norek','$atasnama','$privacy','$date','$cuserid')";
			$hasil = sql($perintah);
			
			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penambahan data Rekening dengan ID $new",$uri,$ip);  
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
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
				/*function popbankid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=master-rekening&aksi=popupbankid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("bankid").value = res.bankid;
							document.getElementById("bankid_text").value = res.bankid_text;
						}
						return false;
				}*/
				function popbankid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=master-rekening&aksi=popupbankid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
				<tr> 
					<td width="176">Pilih Bank</td>
					<td width="471">
                    <input name="bankid" type="hidden" size="20" value="" id="bankid" />
                    <input name="bankid_text" type="text" size="50" value="" id="bankid_text" placeholder="Pilih Bank" class="validate[required]"> 
                    <a href="#" class="apop" onclick="popbankid('bankid','bankid_text')">..</a></td>
				</tr>
				<tr> 
					<td width="15%">No.Rekening</td>
					<td ><input name="norek" type="text" size="40" value="" id="norek" class="validate[required]" />&nbsp;<em>Masukan No Rekening Anda.</em></td>
				</tr>
                <tr> 
					<td >Atas nama</td>
					<td ><input name="atasnama" type="text" size="40" value="" id="atasnama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Privacy</td>
					<td >
						<input type="radio" name="privacy" class="inputbiasa" value="1" /> Tampilkan No Rekening &nbsp;
                		<input type="radio" name="privacy" class="inputbiasa" value="0" /> Jangan Tampilkan No Rekening
                		<br /><em>Pilihlah privacy untuk menampilkan atau tidak no rekening Anda.</em>
					</td>
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
        	$id			= $_POST['id'];
			$bankid		= $_POST['bankid'];
			$norek 		= cleaninsert($_POST['norek']);
			$atasnama 	= cleaninsert($_POST['atasnama']);
			$privacy 	= cleaninsert($_POST['privacy']);
			
			$perintah = "update $nama_tabel set bank='$bankid',norek='$norek',atasnama='$atasnama',privacy='$privacy',
						update_date='$date',update_userid='$cuserid' where id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Rekening dengan ID $id",$uri,$ip);   
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
			
			$sql = "select id,bank,norek,atasnama,privacy from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id 			= $row['id'];
			$bankid 		= $row['bank'];
			$norek 			= $row['norek'];
			$atasnama 		= $row['atasnama'];
			$privacy 		= $row['privacy'];

			$namabank 	= sql_get_var("select namabank from $nama_tabel1 where bankid='$bankid'");
			// die($namabank);
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});

				function popbankid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=master-rekening&aksi=popupbankid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("bankid").value = res.bankid;
							document.getElementById("bankid_text").value = res.bankid_text;
						}
						return false;
				}
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
					<td width="176">Pilih Bank</td>
					<td width="471">
                    <input name="bankid" type="hidden" size="20" value="<?php echo $bankid?>" id="bankid" />
                    <input name="bankid_text" type="text" size="20" value="<?php echo $namabank?>" id="bankid_text" /> 
                    <a href="#" class="apop" onclick="popbankid()">..</a></td>
				</tr>
				<tr> 
					<td width="15%">No.Rekening</td>
					<td ><input name="norek" type="text" size="40" value="<?php echo $norek?>" id="norek" class="validate[required]" />&nbsp;<em>Masukan No Rekening Anda.</em></td>
				</tr>
                <tr> 
					<td >Atas nama</td>
					<td ><input name="atasnama" type="text" size="40" value="<?php echo $atasnama?>" id="atasnama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Privacy</td>
					<td >
						<input type="radio" name="privacy" class="inputbiasa" value="1" <?php if($privacy=="1"){ ?>checked="checked" <?php }?> /> Tampilkan No Rekening &nbsp;
                		<input type="radio" name="privacy" class="inputbiasa" value="0" <?php if($privacy=="0"){ ?>checked="checked" <?php }?> /> Jangan Tampilkan No Rekening
                		<br /><em>Pilihlah privacy untuk menampilkan atau tidak no rekening Anda.</em>
					</td>
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