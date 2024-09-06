<?php 
//Variable halaman ini
$nama_tabel		= "tbl_video";
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
			$mainmenu[] = array("Lihat Video","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Video","tambah","$alamat&aksi=tambah");
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
			
			$sql = "select id,nama,ringkas,published from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=60%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id 		= $row['id'];
				$bagId 		= $row['bagId'];
				$nama 		= $row['nama'];
				$ringkas 	= $row['ringkas'];
				$published 	= $row['published'];
				$secid 		= $row['secid'];
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				 				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=detail&id=$id&hlm=$hlm\">$nama</a></b><br clear=\"all\" /> $ringkas</td>\n
					<td  valign=top >$publish</td>");
					
				print("<td>");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				
				$acc[] = array("Detail","detail","$alamat&aksi=detail&id=$id&hlm=$hlm");
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
			
			$sql = "select id,nama,ringkas,alias,video,youtubeid,gambar1,create_date,jenis,create_userid,update_date,update_userid from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id 		= $row['id'];
			$bagId 		= $row['bagId'];
			$nama 		= $row['nama'];
			$ringkas 	= $row['ringkas'];
			$video 		= $row['video'];
			$jenis 		= $row['jenis'];
			$gambar1 	= $row['gambar1'];
			$youtubeid 	= $row['youtubeid'];
			$create_date = tanggal($row['create_date']);
			$update_date = tanggal($row['update_date']);
			$create_userid = $row['create_userid'];
			$update_userid = $row['update_userid'];
			$create_userid = sql_get_var("select userfullname from tbl_cms_user where userid='$create_userid'");
			$update_userid = sql_get_var("select userfullname from tbl_cms_user where userid='$update_userid'");
			
			if(!empty($gambar1)) $gambar1 = "../gambar/$kanal/$gambar1"; else $gambar1 = "";
			
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
					<td  class="tdinfo">Ringkas</td>
					<td ><?php echo $ringkas?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Create</td>
					<td><?php echo $create_date?> by <?php echo $create_userid?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Update</td>
					<td><?php echo $update_date?> by <?php echo $update_userid?></td>
				</tr>
                 <tr> 
					<td class="tdinfo">Jenis Video</td>
					<td><?php echo $jenis?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Video</td>
					<td>
					<?php 
						if($jenis=="upload") $video = "../gambar/$kanal/$video";
						else if($jenis=="youtube") $video = "http://www.youtube.com/watch?v=$youtubeid";
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
				</td>
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
			
			$id = $_GET['id'];
			$perintah 	= "select gambar,gambar1,video from $nama_tabel where id='$id'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar 	= $row['gambar'];
			$gambar1 	= $row['gambar1'];
			$video 	= $row['video'];
			
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
			if(!empty($gambar1)) unlink("$pathfile$kanal/$gambar1");
			if(!empty($video)) unlink("$pathfile$kanal/$video");
				

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
			$nama = cleaninsert($_POST['nama']);
			$ringkas = cleaninsert($_POST['ringkas']);
			$jenis = desc($_POST['jenis']);
			$oleh = cleaninsert($_POST['oleh']);
			$alias = getAlias($nama);
			$bagid1	= explode("-",$_POST['bagid']);
			$bagid	= $bagid1[0];
			$catId 	= $bagid1[1];
			
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
				
			
			if($jenis=="upload")
			{
				
				if($_FILES['video']['size']>0)
				{
					$ext = getvideoext($_FILES['video']);
					if($ext=="mp4" || $ext=="flv")
					{
						$namavideo = "$kanal-video-$alias-$new.$ext";
						$video = copy($_FILES['video']['tmp_name'],"$pathfile/$kanal/$namavideo");
						
						if($video){ 
							$vfield = ",video";
							$vval = ",'$namavideo'";
						}
					}
				}
				
			}
			else if($jenis=="youtube")
			{
				$youtubeid = cleaninsert($_POST['youtubeid']);
				$yfield = ",youtubeid";
				$yval  = ",'$youtubeid'";
			}
			
			$perintah = "insert into $nama_tabel(id,nama,alias,ringkas,jenis,create_date,create_userid $fgambar $vfield $yfield) 
						values ('$new','$nama','$alias','$ringkas','$jenis','$date','$cuserid' $vgambar $vval $yval)";
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
				function popsecid(bagid)
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=video&aksi=popsecid&bagid="+bagid+"","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("secid").value = res.secid;
							document.getElementById("secid_text").value = res.secid_text;
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
				function changejenis(jenis)
				{
					$(".jenisitem").hide();
					if(jenis!=="") $("#"+jenis).show("fast");
				}
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
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
                          <td >Capture Video</td>
                          <td ><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Capture" class="" /> <em>Ukuran Gambar 1280 x 720 pixel</em></td>
                        </tr>
                <tr> 
					<td >Jenis Video</td>
					<td ><select name="jenis" id="jenis" onchange="changejenis(this.value);" class="validate[required]">
                    		<option value=""> - Pilih Jenis Video - </option>
                            <option value="upload"> Upload </option>
                            <option value="youtube"> Youtube </option>
                          </select></td>
				</tr>
                <tr id="upload" style="display:none" class="jenisitem" valign="top"> 
					<td >Upload </td>
				  <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
                       
                        <tr>
                          <td>File Video</td>
                          <td><input name="video" type="file" size="20" value="" id="video" title="Pilih Video" class="" />
                          Maksimum file yang bisa dikirim<strong> <?php echo ini_get("upload_max_filesize");?></strong> format <strong>FLV</strong> dan <strong>MP4</strong></td>
                        </tr>
                      </table></td>
				</tr>

                <tr id="youtube" class="jenisitem" style="display:none"> 
					<td width="15%">YouTube ID</td>
					<td ><input name="youtubeid" type="text" size="70" value="" id="youtubeid" class="" /><br />
						Masukan Youtube ID saja, seperti yang tercetak tebal:<br />
						http://www.youtube.com/watch?v=<strong>uiPKTFLKx6o</strong></td>
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
			$id = $_POST['id'];
			$nama = cleaninsert($_POST['nama']);
			$ringkas = cleaninsert($_POST['ringkas']);
			$lengkap = desc($_POST['lengkap']);
			$jenis = cleaninsert($_POST['jenis']);
			$alias = getAlias($nama);
			$bagid1	= explode("-",$_POST['bagid']);
			$bagid	= $bagid1[0];
			$catId 	= $bagid1[1];
			
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
				
			
			if($jenis=="upload")
			{
				
				if($_FILES['video']['size']>0)
				{
					$ext = getvideoext($_FILES['video']);
					if($ext=="mp4" || $ext=="flv")
					{
						$namavideo = "$kanal-video-$alias-$new.$ext";
						$video = copy($_FILES['video']['tmp_name'],"$pathfile/$kanal/$namavideo");
						
						if($video){ 
							$vval = ",video='$namavideo'";
						}
					}
				}
				
			}
			else if($jenis=="youtube")
			{
				$youtubeid = cleaninsert($_POST['youtubeid']);
				$yval  = ",youtubeid='$youtubeid'";
			}
			
			$perintah = "update $nama_tabel set nama='$nama',alias='$alias',ringkas='$ringkas',jenis='$jenis',
						update_date='$date',update_userid='$cuserid' $vgambar $vval $yval where id='$id'";
			$hasil = sql($perintah);

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
			
			$sql = "select id,nama,ringkas,youtubeid from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$ringkas = $row['ringkas'];
			$lengkap = $row['lengkap'];
			$oleh = $row['oleh'];
			$youtubeid = $row['youtubeid'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
				function changejenis(jenis)
				{
					$(".jenisitem").hide();
					if(jenis!=="") $("#"+jenis).show("fast");
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
					<td valign="top">Judul</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td ><textarea name="ringkas" cols="76" rows="5" id="ringkas" class="validate[required]"><?php echo $ringkas?></textarea></td>
				</tr>
                <tr>
                     <td >Capture Video</td>
                    <td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Capture" class="" /> <em>Ukuran Gambar 1280 x 720 pixel</em></td>
                </tr>
                <tr> 
					<td >Jenis Video</td>
					<td ><select name="jenis" id="jenis" onchange="changejenis(this.value);" class="validate[required]">
                    		<option value=""> - Pilih Jenis Video - </option>
                            <option value="upload" <?php if($jenis=="upload"){ ?> selected="selected" <?php } ?>> Upload </option>
                            <option value="youtube" <?php if($jenis=="youtube"){ ?> selected="selected" <?php } ?>> Youtube </option>
                          </select></td>
				</tr>
                <tr id="upload" <?php if($jenis!="upload"){ ?> style="display:none"<?php } ?>  class="jenisitem" valign="top"> 
					<td >Upload </td>
				  <td><table width="100%" border="0" cellspacing="2" cellpadding="2">

                        <tr>
                          <td>File Video</td>
                          <td><input name="video" type="file" size="20" value="" id="video" title="Pilih Video" class="" /><br />
							Maksimum file yang bisa dikirim<strong> <?php echo ini_get("upload_max_filesize");?></strong> format <strong>FLV</strong> dan <strong>MP4</strong> </td>
                        </tr>
                      </table></td>
				</tr>

                <tr id="youtube" class="jenisitem"  <?php if($jenis!="youtube") {?> style="display:none"<?php } ?> > 
					<td width="15%">YouTube ID</td>
					<td ><input name="youtubeid" type="text" size="70" value="<?php echo $youtubeid?>" id="youtubeid" class="" /><br />
						Masukan Youtube ID saja, seperti yang tercetak tebal:<br />
						http://www.youtube.com/watch?v=<strong>uiPKTFLKx6o</strong></td>
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
			$mainmenu[] = array("Lihat Video","back","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Kategori","lihat","$alamat&aksi=viewsec");
			$mainmenu[] = array("Tambah Kategori","tambah","$alamat&aksi=tambahsec");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Kategori","str","text","$data");
			
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
			
			$sql = "select secid,nama,keterangan,bagId from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Kategori</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=bagId\" title=\"Urutkan\">Bagian</a></th>\n");
			print("<th width=50%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">Keterangan</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$secid = $row['secid'];
				$bagId = $row['bagId'];
				$nama = $row['nama'];
				$keterangan = $row['keterangan'];
				$bagian = sql_get_var("select nama from tbl_bagian where id='$bagId'");

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama<br clear=\"all\" /></td>\n
					<td  valign=top >$bagian</td>
					<td  valign=top >$keterangan</td>
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
	if($aksi=="popsecid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(secid,nama)
				{
					var res = new Object();
					res.secid = secid;
					res.secid_text = nama;
					window.returnValue = res;
					window.close();
					return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("namagroup","Nama Kategori","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from $nama_tabel1 where bagId='$_GET[bagid]' $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("secid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select nama,secid,bagId,catId,keterangan from $nama_tabel1  where bagId='$_GET[bagid]' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">SecID</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=bagId\" title=\"Urutkan\">Bagian</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Kategori</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$secid = $row['secid'];
				$bagId = $row['bagId'];
				$catId = $row['catId'];
				$idnye = $secid."-".$bagId."-".$catId;

				$bagian   	= sql_get_var("select nama from tbl_bagian where id='$bagId'");
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$secid</b></td>
					<td  valign=top class=judul>$bagian</td>\n
					<td  valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$idnye','$nama');\">Select</button>");
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
			
			$perintah = "delete from $nama_tabel1 where secid='$secid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus Data dengan ID $secid");
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
			$nama = cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$alias = getAlias($nama);
			$bagid1	= explode("-",$_POST['bagid']);
			$bagid	= $bagid1[0];
			$catId 	= $bagid1[1];
			
			$new = newid("secid",$nama_tabel1);
			
			$perintah = "insert into $nama_tabel1(secid,catId,bagId,nama,alias,keterangan,create_date,create_userid $fgambar) 
						values ('$new','$catId','$bagid','$nama','$alias','$keterangan','$date','$cuserid' $vgambar)";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
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
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahsec">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Kategori</th>
				</tr>
				<tr> 
					<td width="176">Bagian</td>
					<td width="471">
                    <input name="bagid" type="hidden" size="20" value="" id="bagid" />
                    <input name="bagid_text" type="text" size="20" value="" id="bagid_text"> 
                    <a href="#" class="apop" onclick="popbagid()">..</a></td>
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
			$nama = cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$alias = getAlias($nama);
			$bagid1	= explode("-",$_POST['bagid']);
			$bagid	= $bagid1[0];
			$catId 	= $bagid1[1];
			
			
			$perintah = "update $nama_tabel1 set nama='$nama',alias='$alias',keterangan='$keterangan',catId='$catId',bagId='$bagid',
						update_date='$date',update_userid='$cuserid' where secid='$secid'";
			$hasil = sql($perintah);

			if($hasil)
			{   
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
			
			$sql = "select secid,nama,keterangan,bagId from $nama_tabel1  where secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$secid = $row['secid'];
			$nama = $row['nama'];
			$keterangan = $row['keterangan'];
			$bagid 		= $row['bagId'];
			$bagian   	= sql_get_var("select nama from tbl_bagian where id='$bagid'");
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
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
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditsec">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Kategori</th>
				</tr>
				<tr> 
					<td width="176">Bagian</td>
					<td width="471">
                    <input name="bagid" type="hidden" size="20" value="<?php echo $bagid?>" id="bagid" />
                    <input name="bagid_text" type="text" size="20" value="<?php echo $bagian?>" id="bagid_text"> 
                    <a href="#" class="apop" onclick="popbagid()">..</a></td>
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