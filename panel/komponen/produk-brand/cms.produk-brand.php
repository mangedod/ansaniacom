<?php 
//Variable halaman ini
$nama_tabel		= "tbl_product_brand";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 250;
$gambars_maxh = 188;
$gambarl_maxw = 250;
$gambarl_maxh = 188;


//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];
 
if(isset($_POST['secid'])) $secid = $_POST['secid'];
 else $secid = $_GET['secid']; 

if(isset($_POST['subid'])) $subid = $_POST['subid'];
 else $subid = $_GET['subid'];
 
if(isset($_POST['brandid'])) $brandid = $_POST['brandid'];
 else $brandid = $_GET['brandid'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Brand","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Brand","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");
			$cari[] = array("ringkas","Ringkas","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");
			
			$dataselect[] = array("0","Draft");
			$dataselect[] = array("1","Published");
			
			$cari[] = array("published","Status","select","select",$dataselect);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("urutan","asc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel where 1 $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select brandid,nama,published,secid,subid,lengkap from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=45%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=urutan\" title=\"Urutkan\">Urutan</a></th>");
			/*print("<th width=10%><a href=\"$urlorder&order=subid\" title=\"Urutkan\">Sub Kategori</a></th>");*/
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$brandid 	= $row['brandid'];
				$nama 		= $row['nama'];
				$lengkap 	= $row['lengkap'];
				$ringkas	= substr($lengkap,0,100);
				$published 	= $row['published'];
				$secid 		= $row['secid'];
				$subid 		= $row['subid'];
				
				// kategori produk
				$namasec = sql_get_var("select namasec from tbl_product_sec where secid='$secid'");
				
				// subkategori produk
				$namasub = sql_get_var("select namasub from tbl_product_sub where subid='$subid'");
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				 
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=detail&brandid=$brandid&hlm=$hlm\">$nama</a></b><br clear=\"all\" /> $ringkas</td>\n
					<td  valign=top ><a href=\"$alamat&aksi=downmenu&brandid=$brandid\" class='btn btn-default' style='margin-right:5px;'>&uarr;</a>
						<a href=\"$alamat&aksi=upmenu&brandid=$brandid\" class='btn btn-default'>&darr;</a></td>
					<td  valign=top >$publish</td>");/*<td  valign=top >$namasec</td>
					<td  valign=top >$namasub</td>*/
					
				print("<td>");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publish&brandid=$brandid&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publish&brandid=$brandid&hlm=$hlm");
				
				$acc[] = array("Detail","detail","$alamat&aksi=detail&brandid=$brandid&hlm=$hlm");
				$acc[] = array("Edit","edit","$alamat&aksi=edit&brandid=$brandid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&brandid=$brandid&hlm=$hlm");
								
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
	if($aksi=="upmenu")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$brandid 	= $_GET['brandid'];
			
			$perintah 	= "select urutan from $nama_tabel where brandid='$brandid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			/*if($data['urutan']=="0") $status = 0;
				else $status=1;*/
				
			$urutanlama 	= $data['urutan'];
			$urutanbaru 	= $urutanlama +1;
			
			$menuidtukar 	= sql_get_var("select brandid from $nama_tabel where urutan='$urutanbaru'");
				
			$perintah 	= "update $nama_tabel set urutan='$urutanlama' where brandid='$menuidtukar'";
			$hasil		= sql($perintah);
				
			$perintah 	= "update $nama_tabel set urutan='$urutanbaru' where brandid='$brandid' ";
			$hasil		= sql($perintah);
		
			if($hasil)
			{
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan urutan data Brand Produk dengan ID $brandid",$uri,$ip);   
				//$msg = base64_encode("Success merubah urutan data dengan ID $menuid");&msg=$msg
				header("location: $alamat&aksi=view&hlm=$hlm");
				exit();
			}
			else
			{
				//$error = base64_encode("Gagal merubah urutan data dan silahkan coba kembali");&error=$error
				header("location: $alamat&aksi=view&hlm=$hlm");
				exit();
			}
		}
	}
	//downmenu
	if($aksi=="downmenu")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$brandid 	= $_GET['brandid'];
			
			$perintah 	= "select urutan from $nama_tabel where brandid='$brandid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['urutan']=="0") $status = 0;
				else $status=1;
			
			$urutanlama 	= $data['urutan'];
			$urutanbaru 	= $urutanlama - $status;
			
			$menuidtukar 	= sql_get_var("select brandid from $nama_tabel where urutan='$urutanbaru'");
				
				//echo "$menuidtukar - $urutanlama<br>$menuid - $urutanbaru"; die();
			$perintah 	= "update $nama_tabel set urutan='$urutanlama' where brandid='$menuidtukar'";
			$hasil		= sql($perintah);
			
			$perintah 	= "update $nama_tabel set urutan='$urutanbaru' where brandid='$brandid' ";
			$hasil		= sql($perintah);
		
			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan urutan data Brand Produk dengan ID $brandid",$uri,$ip);  
				$msg = base64_encode("Success merubah urutan data dengan ID $menuid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah urutan data dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//Popup Brand
	if($aksi=="popbrandid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			$var1 = $_GET['var1'];
			$var2 = $_GET['var2'];
			
			if(empty($var1) && empty($var2))
			{
				$var1 = "brandid";
				$var2 = "brandid_text";
			}
			
			?>
            	<script type="text/javascript">
				function pushdata(brandid,nama)
				{
					 if (window.opener && !window.opener.closed)
					 {
					 	window.opener.$("#<?php echo $var1; ?>").val(brandid);
						window.opener.$("#<?php echo $var2; ?>").val(nama);
					 } 
					  window.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Brand","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from $nama_tabel where published='1' $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("nama","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select nama,brandid from $nama_tabel where published='1' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Brand</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama 	 = $row['nama'];
				$brandid = $row['brandid'];

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$brandid','$nama');\">Select</button>");
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
			$brandid = $_GET['brandid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select brandid,nama,lengkap,alias,gambar,gambar1,create_date,create_userid,update_date,update_userid,secid,subid from $nama_tabel 
					where brandid='$brandid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id 			= $row['id'];
			$nama 			= $row['nama'];
			$lengkap 		= $row['lengkap'];
			$alias 			= $row['alias'];
			$gambar 		= $row['gambar'];
			$gambar1 		= $row['gambar1'];
			$create_date 	= tanggal($row['create_date']);
			$update_date 	= tanggal($row['update_date']);
			$secid 			= $row['secid'];
			$subid 			= $row['subid'];
			
			// kategori produk
			$namasec = sql_get_var("select namasec from tbl_product_sec where secid='$secid'");
			
			// subkategori produk
			$namasub = sql_get_var("select namasub from tbl_product_sub where subid='$subid'");
			
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
                <!--<tr> 
					<td width="20%" class="tdinfo">Kategori</td>
					<td ><?php echo $namasec?></td>
				</tr>
				<tr> 
					<td valign="top" class="tdinfo">Sub Kategori</td> 
					<td align="left"><?php echo $namasub?></td>
				</tr>-->
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Judul</td> 
					<td align="left"><?php echo $nama?></td>
				</tr>
                <tr> 
					<td valign="top" width="20%" class="tdinfo">Alias</td> 
					<td align="left"><?php echo $alias?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Lengkap</td>
					<td ><?php echo $lengkap?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Tanggal Update</td>
					<td><?php echo $update_date?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Kecil</td>
					<td><?php echo $gambar?><br />
                    <input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=editgambar&brandid=$brandid"?>'" value="Edit Gambar">
                   <?php if($gambar!="Masih kosong") { ?><input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=hapusgambar&brandid=$brandid"?>'" value="Hapus Gambar"><?php } ?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Besar</td>
					<td><?php echo $gambar1?><br />
					<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=editgambarlarge&brandid=$brandid"?>'" value="Edit Gambar">
                   <?php if($gambar1!="Masih kosong") { ?><input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=hapusgambarlarge&brandid=$brandid"?>'" value="Hapus Gambar"><?php } ?></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=edit&brandid=$brandid"?>'" value="Ubah Data">
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
			
			$brandid = $_GET['brandid'];
			$perintah 	= "select gambar,gambar1 from $nama_tabel where brandid='$brandid'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar 	= $row['gambar'];
			$gambar1 	= $row['gambar1'];
			
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
			if(!empty($gambar1)) unlink("$pathfile$kanal/$gambar1");
				

			$perintah = "delete from $nama_tabel where brandid='$brandid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penghapusan data Brand Produk dengan ID $brandid",$uri,$ip);
				
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $brandid");
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
			
			$brandid = $_GET['brandid'];
			
			$perintah 	= "select published from $nama_tabel where brandid='$brandid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['published']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set published='$status' where brandid='$brandid' ";
			$hasil		= sql($perintah);
		
			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan status Brand produk dengan ID $brandid",$uri,$ip);  
				$msg = base64_encode("Success merubah status data dengan ID $brandid");
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
			$nama 		= cleaninsert($_POST['nama']);
			$lengkap	= desc($_POST['lengkap']);
			$alias 		= getAlias($nama);
			
			$new = newid("brandid",$nama_tabel);
			
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
			
			$perintah 	= "insert into $nama_tabel(brandid,nama,alias,lengkap,create_date,create_userid,secid,subid $fgambar) 
						values ('$new','$nama','$alias','$lengkap','$date','$cuserid','$secid','$subid' $vgambar)";
			$hasil 		= sql($perintah);
			
			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penambahan data Bank dengan ID $new",$uri,$ip);
				  
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
				
				function popsecid()
				{
					var res = window.showModalDialog("index.php?pop=1&kanal=master-kategori&aksi=popsecid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
					if (res == undefined){
						res = window.returnValue;
						console.log(res);
					}
					if (res != null && res != undefined)
					{
						console.log(res);
						document.getElementById("secid").value = res.secid;
						document.getElementById("secid_text").value = res.secid_text;
						
						if(res.secid=="1")
						{
							$(".phonedata").show();
						}
						else
						{
							$(".phonedata").hide();
						}
					}
					return false;
				}
				function popsecsubid(secid)
				{
					var res = window.showModalDialog("index.php?pop=1&kanal=master-subproduk&aksi=popsecsubid&secid="+secid+"","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
					if (res == undefined){
						res = window.returnValue;
						console.log(res);
					}
					if (res != null && res != undefined)
					{
						console.log(res);
						document.getElementById("subid").value = res.subid;
						document.getElementById("subid_text").value = res.subid_text;
					}
					return false;
				}
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="3">Tambah Data</th>
				</tr>
                <!--<tr> 
					<td width="176">Kategori</td>
					<td width="471" colspan="2">
                    <input name="secid" type="hidden" size="20" value="" id="secid" />
                    <input name="secid_text" type="text" size="30" value="" id="secid_text"  onclick="return popsecid()"> 
                    <a href="#" class="apop" onclick="popsecid()">..</a></td>
				</tr>
                <tr> 
					<td width="176">Sub Kategori</td>
					<td width="471" colspan="2">
                    <input name="subid" type="hidden" size="20" value="" id="subid" />
                    <input name="subid_text" type="text" size="30" value="" id="subid_text" class="validate[required]" /> 
                    <a href="#" class="apop" onclick="popsecsubid(secid.value)">..</a></td>
				</tr>-->
				<tr> 
					<td width="16%">Nama</td>
					<td colspan="2"><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Lengkap</td>
					<td >
                    	<textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" ></textarea><br />
                        <em>Masukan keterangan brand dengan jelas</em>
                    </td>
				</tr>
                <tr> 
					<td>Gambar</td>
					<td colspan="2"><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /><em>Ukuran gambar <?php echo $gambarl_maxw?>px x <?php echo $gambarl_maxh?>px</em></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td colspan="2" align="left">
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
			$brandid 	= $_POST['brandid'];
			$nama 		= cleaninsert($_POST['nama']);
			$lengkap 	= desc($_POST['lengkap']);
			$alias 		= getAlias($nama);
			
			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext 			= getimgext($_FILES['gambar']);
				$namagambars 	= "$kanal-$alias-$brandid.$ext";
				$gambars 		= resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
				
				$namagambarl 	= "$kanal-$alias-$brandid-l.$ext";
				$gambarl 		= resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
				
				if($gambarl){ 
					$vgambar = ",gambar='$namagambars',gambar1='$namagambarl'";
				}
			}
			
			$perintah 	= "update $nama_tabel set nama='$nama',alias='$alias',lengkap='$lengkap',secid='$secid',subid='$subid',
						update_date='$date',update_userid='$cuserid' $vgambar where brandid='$brandid'";
			//die($perintah);
			$hasil 		= sql($perintah);

			if($hasil)
			{   
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Brand Produk dengan ID $brandid",$uri,$ip);
				
				$msg = base64_encode("Berhasil mengubah data dengan ID $brandid");
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
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select brandid,nama,lengkap,secid,subid from $nama_tabel where brandid='$brandid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$brandid 	= $row['brandid'];
			$nama 		= $row['nama'];
			$lengkap 	= $row['lengkap'];
			$lengkap_en	= $row['lengkap_english'];
			$secid		= $row['secid'];
			$subid		= $row['subid'];
			
			// kategori produk
			$namasec = sql_get_var("select namasec from tbl_product_sec where secid='$secid'");
			
			// subkategori produk
			$namasub = sql_get_var("select namasub from tbl_product_sub where subid='$subid'");
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popsecid()
				{
					var res = window.showModalDialog("index.php?pop=1&kanal=master-kategori&aksi=popsecid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
					if (res == undefined){
						res = window.returnValue;
						console.log(res);
					}
					if (res != null && res != undefined)
					{
						console.log(res);
						document.getElementById("secid").value = res.secid;
						document.getElementById("secid_text").value = res.secid_text;
						
						if(res.secid=="1")
						{
							$(".phonedata").show();
						}
						else
						{
							$(".phonedata").hide();
						}
					}
					return false;
				}
				function popsecsubid(secid)
				{
					var res = window.showModalDialog("index.php?pop=1&kanal=master-subproduk&aksi=popsecsubid&secid="+secid+"","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
					if (res == undefined){
						res = window.returnValue;
						console.log(res);
					}
					if (res != null && res != undefined)
					{
						console.log(res);
						document.getElementById("subid").value = res.subid;
						document.getElementById("subid_text").value = res.subid_text;
					}
					return false;
				}
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="brandid" value="<?php echo $brandid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="3">Edit Data</th>
				</tr>
                <!--<tr> 
					<td width="176">Kategori</td>
					<td width="471" colspan="2">
                    <input name="secid" type="hidden" size="20" value="<?php echo $secid?>" id="secid" />
                    <input name="secid_text" type="text" size="50" value="<?php echo $namasec?>" id="secid_text"> 
                    <a href="#" class="apop" onclick="popsecid()">..</a></td>
				</tr>
                <tr> 
					<td width="176">Sub Kategori</td>
					<td width="471" colspan="2">
                    <input name="subid" type="hidden" size="20" value="<?php echo $subid?>" id="subid" />
                    <input name="subid_text" type="text" size="50" value="<?php echo $namasub?>" id="subid_text" class="validate[required]" /> 
                    <a href="#" class="apop" onclick="popsecsubid(secid.value)">..</a></td>
				</tr>-->
				<tr> 
					<td valign="top">Nama</td> 
					<td colspan="2" align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td >Lengkap</td>
					<td>
                    	<textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" ><?php echo $lengkap?></textarea><br />
                        <em>Masukan keterangan brand  dengan jelas</em>
                    </td>
				</tr>
                <tr> 
					<td >Gambar</td>
					<td colspan="2"><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /><em>Ukuran gambar <?php echo $gambarl_maxw?>px x <?php echo $gambarl_maxh?>px</em></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td colspan="2" align="left">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//Hapus
	if($aksi=="hapusgambar")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$brandid = $_GET['brandid'];
			$perintah 	= "select gambar from $nama_tabel where brandid='$brandid'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar 	= $row['gambar'];
			
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar1");
				

			$perintah = "update $nama_tabel set gambar='' where brandid='$brandid'";
			$hasil = sql($perintah);
			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penghapusan data gambar Brand Produk dengan ID $brandid",$uri,$ip);
				  
				$msg = base64_encode("Success mengapus gambar dengan Data dengan ID $brandid");
				header("location: $alamat&aksi=detail&brandid=$brandid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gambar tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&brandid=$brandid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
		
	if($aksi=="saveeditgambar")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$brandid = $_POST['brandid'];
			$alias = getAlias($_POST['nama']);

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$brandid.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);

				$perintah = "update $nama_tabel set gambar='$namagambars' where brandid='$brandid'";
				$hasil = sql($perintah);

			}
			

			if($hasil)
			{   
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data gambar Brand Produk dengan ID $brandid",$uri,$ip);
				$msg = base64_encode("Berhasil mengubah data dengan ID $brandid");
				header("location: $alamat&aksi=detail&brandid=$brandid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&brandid=$brandid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editgambar")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$brandid = $_GET['brandid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select brandid,nama from $nama_tabel  where brandid='$brandid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$brandid = $row['brandid'];
			$nama = $row['nama'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditgambar">
            <input type="hidden" name="brandid" value="<?php echo $brandid?>">
             <input type="hidden" name="nama" value="<?php echo $nama?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Gambar Depan</th>
				</tr>
				<tr> 
					<td valign="top">Judul</td> 
					<td align="left"><input name="namas" value="<?php echo $nama?>" type="text" size="40" id="namas" readonly="readonly"  /></td>
				</tr>
                <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /></td>
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
	
	//Hapus
	if($aksi=="hapusgambarlarge")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$brandid = $_GET['brandid'];
			$perintah 	= "select gambar1 from $nama_tabel where brandid='$brandid'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar1 	= $row['gambar1'];
			
			if(!empty($gambar1)) unlink("$pathfile$kanal/$gambar1");
				

			$perintah = "update $nama_tabel set gambar1='' where brandid='$brandid'";
			$hasil = sql($perintah);
			if($hasil)
			{  
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penghapusan data gambar Brand Produk dengan ID $brandid",$uri,$ip); 
				$msg = base64_encode("Success mengapus gambar dengan Data dengan ID $brandid");
				header("location: $alamat&aksi=detail&brandid=$brandid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gambar tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&brandid=$brandid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
			
	if($aksi=="saveeditgambarlarge")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$brandid = $_POST['brandid'];
			$alias = getAlias($_POST['nama']);

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambarl = "$kanal-$alias-$brandid-l.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);

				$perintah = "update $nama_tabel set gambar1='$namagambarl' where brandid='$brandid'";
				$hasil = sql($perintah);

			}
			

			if($hasil)
			{  
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data gambar Brand Produk dengan ID $brandid",$uri,$ip); 
				$msg = base64_encode("Berhasil mengubah data dengan ID $brandid");
				header("location: $alamat&aksi=detail&brandid=$brandid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&brandid=$brandid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editgambarlarge")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$brandid = $_GET['brandid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select brandid,nama from $nama_tabel  where brandid='$brandid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$brandid = $row['brandid'];
			$nama = $row['nama'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditgambarlarge">
            <input type="hidden" name="brandid" value="<?php echo $brandid?>">
             <input type="hidden" name="nama" value="<?php echo $nama?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Gambar Large</th>
				</tr>
				<tr> 
					<td valign="top">Judul</td> 
					<td align="left"><input name="namsa" value="<?php echo $nama?>" type="text" size="40" id="namas" readonly="readonly"  /></td>
				</tr>
                <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /></td>
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