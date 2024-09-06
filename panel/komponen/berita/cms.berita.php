<?php 
//Variable halaman ini
$nama_tabel		= "tbl_berita";
$nama_tabel1	= "tbl_berita_sec";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 500;
$gambars_maxh = 450;
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
			$mainmenu[] = array("Kategori","category","$alamat&aksi=viewsec");
			$mainmenu[] = array("Lihat Content","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Content","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");
			$cari[] = array("ringkas","Ringkas","str","text","$data");
			$cari[] = array("secid","Kategori","find","find","index.php?pop=1&kanal=berita&aksi=popsecid");
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
			
			$sql = "select id,nama,ringkas,published,secid,views,headline from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=id\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=70%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">Kategori</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=views\" title=\"Urutkan\">Views</a</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=headline\" title=\"Urutkan\">Headline</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id        = $row['id'];
				$nama      = $row['nama'];
				$ringkas   = $row['ringkas'];
				$published = $row['published'];
				$secid     = $row['secid'];
				$views     = $row['views'];
				$headline = $row['headline'];
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				 
				if($headline=="1") $head ="headline";
				 else $head ="no";
				 
				$kategori = sql_get_var("select nama from $nama_tabel1 where secid='$secid'");
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top>&nbsp;<b>$id</b></td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=detail&id=$id&hlm=$hlm\">$nama</a></b><br clear=\"all\" /> $ringkas</td>\n
					<td  valign=top >$kategori</td>
					<td  valign=top >$views</td>
					<td  valign=top >$head</td>
					<td  valign=top >$publish</td>");
					
				print("<td>");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				
				if($headline==0) $acc[] = array("Jadikan Headline","push","$alamat&aksi=headline&id=$id&hlm=$hlm");
				else $acc[] = array("Hapus Headline","push","$alamat&aksi=headline&id=$id&hlm=$hlm");
				
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
			
			$sql = "select id,nama,ringkas,lengkap,oleh,alias,gambar,gambar1,infogambar,tags,views,create_date,create_userid,update_date,update_userid from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id            = $row['id'];
			$nama          = $row['nama'];
			$ringkas       = $row['ringkas'];
			$lengkap       = $row['lengkap'];
			$oleh          = $row['oleh'];
			$alias         = $row['alias'];
			$gambar        = $row['gambar'];
			$gambar1       = $row['gambar1'];
			$tags         = $row['tags'];
			$views         = $row['views'];
			$infogambar         = $row['infogambar'];
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
					<td class="tdinfo">Penulis</td>
					<td><?php echo $oleh?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Tags</td>
					<td><?php echo $tags?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Views</td>
					<td><?php echo $views?></td>
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
                    <input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=editgambar&id=$id"?>'" value="Edit Gambar">
                   <?php if($gambar!="Masih kosong") { ?><input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=hapusgambar&id=$id"?>'" value="Hapus Gambar"><?php } ?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Besar</td>
					<td><?php echo $gambar1?><br />
					<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=editgambarlarge&id=$id"?>'" value="Edit Gambar">
                   <?php if($gambar1!="Masih kosong") { ?><input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=hapusgambarlarge&id=$id"?>'" value="Hapus Gambar"><?php } ?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Info Gambar</td>
					<td><?php echo $infogambar?></td>
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
			
			$id       = $_GET['id'];
			$perintah = "select gambar,gambar1 from $nama_tabel where id='$id'";
			$hasil    = sql($perintah);
			$row      = sql_fetch_data($hasil);
			
			$gambar  = $row['gambar'];
			$gambar1 = $row['gambar1'];
			
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
			if(!empty($gambar1)) unlink("$pathfile$kanal/$gambar1");
				

			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus Data dengan ID $id");
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

		//Publish
	if($aksi=="headline")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$id = $_GET['id'];
			
			$perintah 	= "select headline,nama,alias,id,gambar,ringkas,create_date,secid from $nama_tabel where id='$id' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);
			
			$alias = $data['alias'];
			$gambar = $data['gambar'];
			$ringkas = $data['ringkas'];
			$create_date = $data['create_date'];
			$headline = $data['headline'];
			$nama = $data['nama'];
			$secid = $data['secid'];
			
			$secalias = sql_get_var("select alias from $nama_tabel1 where secid='$secid'");			

			if($data['headline']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set headline='$status' where id='$id' ";
			$hasil		= sql($perintah);
			
			
			//Takedown dari Headline
			if($status==0)
			{
				$sql = "delete from tbl_headline where itemid='$id' and kanal='$kanal'";
				$hsl = sql($sql);
			}
			if($status==1)
			{
				$url = "/$kanal/read/$secalias/$id/$alias.html";
				if(!empty($gambar)) $gambar = "/gambar/$kanal/$gambar"; else $gambar = "";
				
				$sql = "insert into tbl_headline(create_date,itemid,nama,alias,ringkas,gambar,url,kanal) value('$create_date','$id','$nama','$alias','$ringkas','$gambar','$url','$kanal')";
				$hsl = sql($sql);
			}
		
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
			$nama    = cleaninsert($_POST['nama']);
			$ringkas = cleaninsert($_POST['ringkas']);
			$lengkap = desc($_POST['lengkap']);
			$oleh    = cleaninsert($_POST['oleh']);
			$alias   = getAlias($nama);
			$tags   = cleaninsert($_POST['tags']);
			$infogambar   = cleaninsert($_POST['infogambar']);
			
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
			
			$perintah = "insert into $nama_tabel(id,secid,nama,alias,ringkas,lengkap,oleh,tags,create_date,create_userid,infogambar $fgambar) 
						values ('$new','$secid','$nama','$alias','$ringkas','$lengkap','$oleh','$tags','$date','$cuserid',infogambar $vgambar)";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$update = sql("update tbl_last set tanggal=now() where kanal='$kanal'");
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
			
			$create_date = date("Y-m-d H:i:s");
			
			?>
             <script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popsecid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=berita&aksi=popsecid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("secid").value = res.secid;
							document.getElementById("secid_text").value = res.secid_text;
						}
						return false;
				}
					$(function() {
						$( "#create_date" ).datetimepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
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
					<td width="176">Kategori</td>
					<td width="471">
                   <select name="secid" id="secid"  class="validate[required]">
                    <option value="">--Pilih Kategori--</option>
                    	<?php
						$sql = "select nama,secid from $nama_tabel1  order by nama";
						$hsl = sql($sql);
						while($data=sql_fetch_data($hsl))
						{
							$secid1 = $data['secid'];
							$namasec = $data['nama'];
							echo "<option value=\"$secid1\">$namasec</option>";
							
						}
						sql_free_result($hsl);
						?>
                     </select></td>
				</tr>
				<tr> 
					<td width="15%">Judul</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Tags</td>
					<td><input name="tags" type="text" size="90" value="" id="tags" class="validate[required]" /></td>
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
					<td>Penulis</td>
					<td><input name="oleh" type="text" size="20" value="" id="oleh" class="validate[required]" /></td>
				</tr>
               	 <tr> 
					<td>Tanggal</td>
					<td><input name="create_date" type="text" size="20" value="<?php echo $create_date?>" id="create_date" class="validate[required]" /></td>
				</tr>
                 <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /></td>
				</tr>
                 <tr> 
					<td >Info Gambar</td>
					<td ><textarea name="infogambar" cols="76" rows="5" id="ringkas" ><?php echo $infogambar?></textarea></td>
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
			$oleh = cleaninsert($_POST['oleh']);
			$alias = getAlias($nama);
			$tags =  cleaninsert($_POST['tags']);
			$infogambar = cleaninsert($_POST['infogambar']);

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
			
			$perintah = "update $nama_tabel set nama='$nama',secid='$secid',alias='$alias',ringkas='$ringkas',lengkap='$lengkap',oleh='$oleh',tags='$tags',
						update_date='$date',update_userid='$cuserid',infogambar='$infogambar' $vgambar where id='$id'";
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
			
			$sql = "select id,nama,ringkas,lengkap,oleh,secid,tags,create_date,infogambar from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id      = $row['id'];
			$nama    = $row['nama'];
			$ringkas = $row['ringkas'];
			$lengkap = $row['lengkap'];
			$oleh    = $row['oleh'];
			$secid   = $row['secid'];
			$tags   	= $row['tags'];
			$create_date = $row['create_date'];
			$infogambar = $row['infogambar'];
			
			$kategori = sql_get_var("select nama from $nama_tabel1 where secid='$secid'");
			
			?>
            <script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>
			<script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popsecid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=berita&aksi=popsecid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("secid").value = res.secid;
							document.getElementById("secid_text").value = res.secid_text;
						}
						return false;
				}
					$(function() {
						$( "#create_date" ).datetimepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
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
					<td width="176">Kategori</td>
					<td width="471">
                    	<select name="secid" id="secid"  class="validate[required]">
                    <option value="">--Pilih Group--</option>
                    <?php
						$sql = "select secid,nama from $nama_tabel1  order by nama asc";
						$hsl = sql($sql);
						while($data=sql_fetch_data($hsl))
						{
							$secid1 = $data['secid'];
							$namasec = $data['nama'];
							echo "<option value=\"$secid1\""; if($secid==$secid1){ echo "selected=\"selected\" "; } echo ">$namasec</option>";
							
						}
						sql_free_result($hsl);
						?>
                        </select>
                     </select></td>
				</tr>
				<tr> 
					<td valign="top">Judul</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                  <tr> 
					<td>Tag</td>
					<td><input name="tags" type="text" size="70" value="<?php echo $tags?>" id="tags" class="validate[required]" /></td>
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
					<td>Penulis</td>
					<td><input name="oleh" type="text" size="20" value="<?php echo $oleh?>" id="oleh" class="validate[required]" /></td>
				</tr>
                 <tr> 
					<td>Tanggal</td>
					<td><input name="create_date" type="text" size="20" value="<?php echo $create_date?>" id="create_date" class="validate[required]" /></td>
				</tr>
              
                <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /></td>
				</tr>
                 <tr> 
					<td >Info Gambar</td>
					<td ><textarea name="infogambar" cols="76" rows="5" id="ringkas" ><?php echo $infogambar?></textarea></td>
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
	if($aksi=="hapusgambar")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id = $_GET['id'];
			$perintah 	= "select gambar from $nama_tabel where id='$id'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar 	= $row['gambar'];
			
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar1");
				

			$perintah = "update $nama_tabel set gambar='' where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus gambar dengan Data dengan ID $id");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gambar tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
		
	if($aksi=="saveeditgambar")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_POST['id'];
			$alias = getAlias($_POST['nama']);

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$id.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);

				$perintah = "update $nama_tabel set gambar='$namagambars' where id='$id'";
				$hasil = sql($perintah);

			}
			

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editgambar")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditgambar">
            <input type="hidden" name="id" value="<?php echo $id?>">
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
			
			$id = $_GET['id'];
			$perintah 	= "select gambar1 from $nama_tabel where id='$id'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar1 	= $row['gambar1'];
			
			if(!empty($gambar1)) unlink("$pathfile$kanal/$gambar1");
				

			$perintah = "update $nama_tabel set gambar1='' where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus gambar dengan Data dengan ID $id");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gambar tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
			
	if($aksi=="saveeditgambarlarge")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_POST['id'];
			$alias = getAlias($_POST['nama']);
			$infogambar = $_POST['infogambar'];

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambarl = "$kanal-$alias-$new-l.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);

				$perintah = "update $nama_tabel set gambar1='$namagambarl' where id='$id'";
				$hasil = sql($perintah);

			}
			
			$perintah = "update $nama_tabel set infogambar='$infogambar' where id='$id'";
			$hasil = sql($perintah);
			

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editgambarlarge")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,infogambar from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$infogambar = $row['infogambar'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditgambarlarge">
            <input type="hidden" name="id" value="<?php echo $id?>">
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
					<td >Info Gambar</td>
					<td ><textarea name="infogambar" cols="76" rows="5" id="ringkas" ><?php echo $infogambar?></textarea></td>
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
			print("<th width=40%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Kategori</a></th>\n");
			print("<th width=50%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">Keterangan</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$secid = $row['secid'];
				$nama = $row['nama'];
				$keterangan = $row['keterangan'];

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama<br clear=\"all\" /></td>\n
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
			$order = getorder("secid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select nama,secid,keterangan from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">SecID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Kategori</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$secid = $row['secid'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$secid</b></td>
					<td  valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$secid','$nama');\">Select</button>");
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
			
			$new = newid("secid",$nama_tabel1);
			
			$perintah = "insert into $nama_tabel1(secid,nama,alias,keterangan,create_date,create_userid $fgambar) 
						values ('$new','$nama','$alias','$keterangan','$date','$cuserid' $vgambar)";
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
			$nama = cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$alias = getAlias($nama);
			
			
			$perintah = "update $nama_tabel1 set nama='$nama',alias='$alias',keterangan='$keterangan',
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