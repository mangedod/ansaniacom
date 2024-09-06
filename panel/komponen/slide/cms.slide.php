<?php  
//Variable halaman ini
$nama_tabel		= "tbl_slide";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambarl_maxw = 1920;
$gambarl_maxh = 1052; 


//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];
 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Slide","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Slide","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");
			$cari[] = array("url","URL Target","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("id","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel where 1 and tipe='0' $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select id,nama,url,gambar,ringkas,published from $nama_tabel  where 1 and tipe='0' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<th width=5%><a href=\"$urlorder&order=id\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=30%><a href=\"$urlorder&order=gambar\" title=\"Urutkan\">Preview</a></th>\n");
				print("<th width=40%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama dan URL</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id = $row['id'];
				$nama = $row['nama'];
				$ringkas = $row['ringkas'];
				$url = $row['url'];
				$published = $row['published'];
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				
				$gambar = $row['gambar'];
				
				if(empty($gambar)) $gambar = "Masih kosong";
				else $gambar = "<img src=\"../gambar/$kanal/$gambar\" style=\"height:140px\" alt=\"\" />";
				
				
				print("<tr class=\"row$i\">
					<td width=5% height=20 valign=top>&nbsp;<b>$a</b></td>
					<td  valign=top >$gambar</td>\n
						<td  valign=top><b>$nama</b><br clear=\"all\" />$ringkas<br clear=\"all\" /> $url</td>\n
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
			
			$id = $_GET['id'];
			$perintah 	= "select gambar from $nama_tabel where id='$id'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar 	= $row['gambar'];
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
				

			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus  Data dengan ID $id");
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
			$url = cleaninsert($_POST['url']);
			$userid   = $_POST['userid'];
			
			$new = newid("id",$nama_tabel);
			
			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);

				$namagambarl = "$kanal-$new.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
				
				if($gambarl){ 
					$fgambar = ",gambar";
					$vgambar = ",'$namagambarl'";
				}
			}
			
			$perintah = "insert into $nama_tabel(id,nama,ringkas,url,tipe,create_date,create_userid,userid $fgambar) 
						values ('$new','$nama','$ringkas','$url','0','$date','$cuserid','$userid' $vgambar)";
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
	
	//Vie Menu
	if($aksi=="popuserid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(userid,nama)
				{
					var res = new Object();
					res.userid = userid;
					res.userid_text = nama;
					window.returnValue = res;
					window.close();
					return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("userfullname","Nama Member","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from tbl_member where 1 $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("userid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select userfullname,userid from tbl_member  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=userid\" title=\"Urutkan\">UserID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=userfullname\" title=\"Urutkan\">Nama Member</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['userfullname'];
				$userid = $row['userid'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$userid</b></td>
					<td  valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$userid','$nama');\">Select</button>");
				print("</td></tr>");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		}
	} //EndView /**/
	
	//Tambah
	if($aksi=="tambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			?><script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popuserid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=slide&aksi=popuserid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("userid").value = res.userid;
							document.getElementById("userid_text").value = res.userid_text;
						}
						return false;
				}
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Slide</th>
				</tr>
				<tr> 
					<td width="15%">Nama Slide</td>
					<td ><input name="nama" type="text" size="50" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td width="15%">Keterangan</td>
					<td ><input name="ringkas" type="text" size="50" value="" id="ringkas" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>URL Target</td>
					<td><input name="url" type="text" size="90" value="" id="url" class="validate[required]" /></td>
				</tr>
                 <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /> 
					<em>Ukuran Gambar <?php  echo "$gambarl_maxw x $gambarl_maxh";?> pixel</em></td>
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
			$url = cleaninsert($_POST['url']);
			$userid   = $_POST['userid'];

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambarl = "$kanal-$id.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
				
				if($gambarl){ 
					$vgambar = ",gambar='$namagambarl'";
				}
			}
			
			$perintah = "update $nama_tabel set nama='$nama',url='$url',ringkas='$ringkas',userid='$userid',
						update_date='$date',update_userid='$cuserid' $vgambar where id='$id'";
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
			
			$sql = "select id,nama,url,ringkas,userid from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$url = $row['url'];
			$ringkas = $row['ringkas'];
			
			$userfullname = sql_get_var("select userfullname from tbl_member where userid='$userid'");
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popuserid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=blog&aksi=popuserid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("userid").value = res.userid;
							document.getElementById("userid_text").value = res.userid_text;
						}
						return false;
				}
			</script>
            <form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php  echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Slide</th>
				</tr>
				<tr> 
					<td valign="top">Judul</td> 
					<td align="left"><input name="nama" value="<?php  echo $nama?>" type="text" size="50" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td ><textarea name="ringkas" cols="76" rows="5" id="ringkas" class="validate[required]"><?php  echo $ringkas?></textarea></td>
				</tr>
                <tr> 
					<td>URL Target</td>
					<td><input name="url" type="text" size="90" value="<?php  echo $url?>" id="url" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" />
				    <em>Ukuran Gambar <?php  echo "$gambarl_maxw x $gambarl_maxh";?> pixel</em></td>
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
	
}

?>