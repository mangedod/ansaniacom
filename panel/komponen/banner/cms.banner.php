<?php 
//Variable halaman ini
$nama_tabel		= "tbl_banner_space";
$nama_tabel1	= "tbl_banner";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;

//Variable Umum
if(isset($_POST['spaceid'])) $spaceid = $_POST['spaceid'];
 else $spaceid = $_GET['spaceid'];

if(isset($_POST['space'])) $space = $_POST['space'];
 else $space = $_GET['space'];

 
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Space
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Space","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
	
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("space","Space","str","text","$data");
			$cari[] = array("nama","Nama Space","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("spaceid","desc",$pageparam,$param);
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
			
			$sql = "select spaceid,nama,space,width,height from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=1%>Nomor</th>\n");
			print("<th width=30%><a href=\"$urlorder&order=space\" title=\"Urutkan\">Space</a></th>\n");
			print("<th width=40%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=width\" title=\"Urutkan\">Width</a></th>");
			print("<th width=5%><a href=\"$urlorder&order=height\" title=\"Urutkan\">Height</a></th>");
			print("<th width=10%><a href=\"$urlorder&order=height\" title=\"Urutkan\">Jumlah</a></th>");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$spaceid = $row['spaceid'];
				$width = $row['width'];
				$height = $row['height'];
				$space = $row['space'];
				
				$jumlah = sql_get_var("select count(*) as jml from $nama_tabel1 where space='$space'");
				
				print("<tr class=\"row$i\"><td height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=viewbanner&spaceid=$spaceid\">$space</a></td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=viewbanner&spaceid=$spaceid\">$nama</a></td>\n");
				print("<td valign=top align=center>$width</td>\n");
				print("<td valign=top align=center>$height</td>\n");
				print("<td valign=top align=center><a href=\"$alamat&aksi=viewbanner&spaceid=$spaceid\">$jumlah Banner</a></td>\n");
				print("<td>");
				$acc[] = array("Lihat Banner","view","$alamat&aksi=viewbanner&spaceid=$spaceid");
				
							
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
	if($aksi=="viewbanner")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$pageparam[] = array("spaceid",$spaceid);
			
			$mainmenu[] = array("Lihat Space","category","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Banner","lihat","$alamat&aksi=viewbanner");
			$mainmenu[] = array("Tambah Banner","tambah","$alamat&aksi=tambahbanner");
			mainaction($mainmenu,$pageparam);
			
			$cari[] = array("nama","Nama Banner","str","text","$data");
			$cari[] = array("link","URL Target","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("id","desc",$pageparam,$param);
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
			
			$sql = "select id,nama,space,spaceid,published,jenis,gambar,ukuran from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=15%><a href=\"$urlorder&order=id\" title=\"Urutkan\">Preview</a></th>\n");
			print("<th width=60%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=height\" title=\"Urutkan\">Statistik</a></th>");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id = $row['id'];
				$nama = $row['nama'];
				$ringkas = $row['ringkas'];
				$published = $row['published'];
				$spaceid = $row['spaceid'];
				$gambar = $row['gambar'];
				$jenis = $row['jenis'];
				$ukuran = $row['ukuran'];
				$ukuran = explode("x",$ukuran);
				$width = $ukuran[0];
				$height = $ukuran[1];

				if($jenis=="swf")
				{
					if(empty($gambar)) $gambar = "Masih kosong";
					else $gambar = "<object type=\"application/x-shockwave-flash\"  data=\"../gambar/$kanal/$gambar\" width=\"$width\" height=\"$height\">
									<param name=\"movie\" value=\"../gambar/$kanal/$gambar\" />
									<param name=\"quality\" value=\"high\" />
									<param name=\"wmode\" value=\"transparent\" />
									<param name=\"menu\" value=\"false\" />
									<param name=\"AllowScriptAccess\" value=\"always\" />
									</object>";
				}
				else
				{
					if(empty($gambar)) $gambar = "Masih kosong";
					else $gambar = "<img src=\"../gambar/$kanal/$gambar\" style=\"width:$width; height:$height\" alt=\"\" />";
				}
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				 
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td valign=top>$gambar</td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=detailbanner&id=$id&spaceid=$spaceid&hlm=$hlm\">$nama</a></b><br clear=\"all\" /> $ringkas</td>\n
					<td  valign=top ><a href=\"$alamat&aksi=detailbanner&id=$id&spaceid=$spaceid&hlm=$hlm\">Statistik</a></td>
					<td  valign=top >$publish</td>");
					
				print("<td>");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publishbanner&spaceid=$spaceid&id=$id&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publishbanner&spaceid=$spaceid&id=$id&hlm=$hlm");
				
				$acc[] = array("Detail","detail","$alamat&aksi=detailbanner&id=$id&spaceid=$spaceid&hlm=$hlm");
				$acc[] = array("Edit","edit","$alamat&aksi=editbanner&id=$id&spaceid=$spaceid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapusbanner&id=$id&spaceid=$spaceid&hlm=$hlm");
								
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
	if($aksi=="detailbanner")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewbanner&spaceid=$spaceid");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,ringkas,oleh,alias,gambar,gambar1,create_date,create_userid,update_date,update_userid from $nama_tabel1  where id='$id' and spaceid='$spaceid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$ringkas = $row['ringkas'];
			$oleh = $row['oleh'];
			$alias = $row['alias'];
			$gambar = $row['gambar'];
			$gambar1 = $row['gambar1'];
			$create_date = tanggal($row['create_date']);
			
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
					<td class="tdinfo">Fotografer</td>
					<td><?php echo $oleh?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Tanggal Buat</td>
					<td><?php echo $create_date?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Kecil</td>
					<td><?php echo $gambar?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Besar</td>
					<td><?php echo $gambar1?></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=editbanner&spaceid=$spaceid&id=$id"?>'" value="Ubah Data">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//Hapus
	if($aksi=="hapusbanner")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id = $_GET['id'];
			$perintah 	= "select gambar from $nama_tabel1 where id='$id' and spaceid='$spaceid'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar 	= $row['gambar'];
			
			if(!empty($gambar)) unlink("$pathfile$kanal/$gambar");
				

			$perintah = "delete from $nama_tabel1 where id='$id' and spaceid='$spaceid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus banner dengan ID $id");
				header("location: $alamat&aksi=viewbanner&spaceid=$spaceid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewbanner&spaceid=$spaceid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//Publish
	if($aksi=="publishbanner")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$id = $_GET['id'];
			
			$perintah 	= "select published from $nama_tabel1 where id='$id' and spaceid='$spaceid'";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['published']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel1 set published='$status' where id='$id' and spaceid='$spaceid'";
			$hasil		= sql($perintah);
		
			if($hasil)
			{   
				$msg = base64_encode("Success merubah status data dengan ID $id");
				header("location: $alamat&aksi=viewbanner&spaceid=$spaceid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=viewbanner&spaceid=$spaceid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}


	
	//SaveTambah
	if($aksi=="savetambahbanner")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$sql = "select spaceid,nama,space,width,height from $nama_tabel  where spaceid='$spaceid'";
			$hsl = sql($sql);

			$row = sql_fetch_data($hsl);
			$nama = $row['nama'];
			$spaceid = $row['spaceid'];
			$width = $row['width'];
			$height = $row['height'];
			$space = $row['space'];
			$ukuran = $width."x".$height;
			
			$nama = cleaninsert($_POST['nama']);
			$code = ($_POST['code']);
			$harga = cleaninsert($_POST['harga']);
			$budget = cleaninsert($_POST['budget']);
			$ppn = cleaninsert($_POST['ppn']);
			$tipe = cleaninsert($_POST['tipe']);
			$ppn = cleaninsert($_POST['ppn']);
			$jenis = cleaninsert($_POST['jenis']);
			$diskon = cleaninsert($_POST['diskon']);
			$link = cleaninsert($_POST['link']);
			$tglakhir = cleaninsert($_POST['tglakhir']);
			$alias = getAlias($nama);
			
			$files = $_FILES['gambar']['tmp_name'];
			$type = $_FILES['gambar']['type'];
			$size = $_FILES['gambar']['size'];
			$namafile = $_FILES['gambar']['name'];
			
			$new = newid("id",$nama_tabel1);
			
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
		
			if($size> 0)
			{
				$ext = substr($namafile,-3,3);

				$namagambar = "$kanal-$alias-$new.$ext";
				$gambars = copy($files,"$pathfile/$kanal/$namagambar");
				
				if($gambars)
				{ 
					$fgambar = ",gambar";
					$vgambar = ",'$namagambar'";
					
				}
			}
				
			$perintah = "insert into $nama_tabel1(id,spaceid,nama,space,link,jenis,ukuran,harga,diskon,ppn,tglpasang,tglakhir,tipe,code,budget,create_date,create_userid $fgambar) 
						values ('$new','$spaceid','$nama','$space','$link','$jenis','$ukuran','$harga','$diskon','$ppn','$date','$tglakhir',
						'$tipe','$code','$budget','$date','$cuserid' $vgambar)";
			
			$hasil = sql($perintah);
			
			
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=viewbanner&hlm=$hlm&msg=$msg&spaceid=$spaceid");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewbanner&hlm=$hlm&msg=$msg&spaceid=$spaceid");
				exit();
			}
		}
	}
	
	//Tambah
	if($aksi=="tambahbanner")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewbanner&spaceid=$spaceid");
			mainaction($mainmenu,$param);
			
			$sql = "select spaceid,nama,space,width,height from $nama_tabel  where spaceid='$spaceid'";
			$hsl = sql($sql);

			$row = sql_fetch_data($hsl);
			$nama = $row['nama'];
			$spaceid = $row['spaceid'];
			$width = $row['width'];
			$height = $row['height'];
			$space = $row['space'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function changejenis(jenis)
				{
					$(".jenisitem").hide();
					if(jenis!=="code") $("#upload").show("fast");
					else  $("#code").show("fast");
				}
				$(function() {
						$( "#tglakhir" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true
						});

				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
            <input type="hidden" name="spaceid" value="<?php echo $spaceid?>">
			<input type="hidden" name="aksi" value="savetambahbanner">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Banner</th>
				</tr>
                    <tr>
                      <td>Space </td>
                      <td><input type="text" name="space"  value="<?php echo"$space"; ?>" disabled></td>
                    </tr>
                    <tr>
                      <td>Nama Banner </td>
                      <td><input type="text" name="nama"  class="validate[required]" value=""></td>
                    </tr>
                    <tr>
                      <td>Lebar (pixel)</td>
                      <td><input type="text" name="width"  value="<?php echo"$width"; ?>" disabled></td>
                    </tr>
                    <tr>
                      <td>Tinggi (pixel)</td>
                      <td><input type="text" name="height" class=textfield2 value="<?php echo"$height"; ?>" disabled></td>
                    </tr>
                    <tr>
                      <td>Tipe Banner </td>
                      <td><select name="tipe"  class="validate[required]">
                          <option value="" >-- Pilih Tipe Banner ---</option>
                      	  <option value="bybudget" >End by Budget</option>
                          <option value="bydate">End by date</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td>Budget </td>
                      <td><input type="text" name="budget" class=textfield2 value="0"> 
                        (apabila tipe banner by budged example : 50000) </td>
                    </tr>
                
                    <tr> 
                      <td>Harga Pokok</td>
                      <td><input type="text" name="harga" value="0">
                        Rupiah / 1000 impresi </td>
                    </tr>
                    <tr> 
                      <td>Diskon</td>
                      <td><input type="text" name="diskon" value="0">
                        %</td>
                    </tr>
                    <tr> 
                      <td>PPN</td>
                      <td><input type="text" name="ppn" value="0">
                        %</td>
                    </tr>
                    <tr>
                      <td>Letak</td>
                      <td><input type="text" name="space" value="<?php echo"$space"; ?>" disabled></td>
                    </tr>
                    <tr> 
                      <td>Tanggal Akhir</td>
                      <td> <input name="tglakhir" type="text"  id="tglakhir">
                     </td>
                    </tr>
                    <tr> 
                      <td>Link Target</td>
                      <td><input type="text" name="link" size="70" class="validate[required]" value="http://"></td>
                    </tr>
                    <tr> 
                      <td width="206" >Jenis Banner</td>
                      <td width="886"><select name="jenis"  onchange="changejenis(this.value);"  class="validate[required]">
                           <option value="">--Pilih Jenis--</option>
                           <option value="jpg">Gambar JPEG</option>
                          <option value="gif">Gambar GIF</option>
                          <option value="swf">Animasi Flash</option>
                          <option value="png">PNG Images</option>
                          <option value="code">Advertising Code</option>
                        </select></td>
                    </tr>
                    <tr id="upload" style="display:none" class="jenisitem" valign="top"> 
                      <td>Gambar</td>
                      <td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file"/></td>
                    </tr>
                      <tr id="code" style="display:none" class="jenisitem" valign="top"> 
					<td>Ads Code</td>
					<td ><textarea name="code" cols="76" rows="5" id="code"></textarea></td>
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
	
	if($aksi=="saveeditbanner")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$sql = "select spaceid,nama,space,width,height from $nama_tabel  where spaceid='$spaceid'";
			$hsl = sql($sql);

			$row = sql_fetch_data($hsl);
			$nama = $row['nama'];
			$spaceid = $row['spaceid'];
			$width = $row['width'];
			$height = $row['height'];
			$space = $row['space'];
			$ukuran = $width."x".$height;
			
			$nama = cleaninsert($_POST['nama']);
			$code = ($_POST['code']);
			$harga = cleaninsert($_POST['harga']);
			$budget = cleaninsert($_POST['budget']);
			$ppn = cleaninsert($_POST['ppn']);
			$tipe = cleaninsert($_POST['tipe']);
			$ppn = cleaninsert($_POST['ppn']);
			$jenis = cleaninsert($_POST['jenis']);
			$diskon = cleaninsert($_POST['diskon']);
			$link = cleaninsert($_POST['link']);
			$tglakhir = cleaninsert($_POST['tglakhir']);
			$alias = getAlias($nama);
			
			$files = $_FILES['gambar']['tmp_name'];
			$type = $_FILES['gambar']['type'];
			$size = $_FILES['gambar']['size'];
			$namafile = $_FILES['gambar']['name'];
			
		
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
		
			if($size> 0)
			{
				$ext = substr($namafile,-3,3);

				$namagambar = "$kanal-$alias-$new.$ext";
				$gambars = copy($files,"$pathfile/$kanal/$namagambar");
				
				if($gambars)
				{ 
					$vgambar = ",gambar='$namagambar'";
					
				}
			}
				
			$perintah = "update $nama_tabel1 set spaceid='$spaceid',nama='$nama',space='$space',link='$link',jenis='$jenis',ukuran='$ukuran',
						harga='$harga',diskon='$diskon',ppn='$ppn',tglpasang='$date',tglakhir='$tglakhir',tipe='$tipe',
						code='$code',budget='$budget',update_date='$date',update_userid='$cuserid' $vgambar where id='$id' and spaceid='$spaceid'";
			
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=viewbanner&spaceid=$spaceid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewbanner&spaceid=$spaceid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editbanner")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewbanner&spaceid=$spaceid");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,code,harga,budget,tglakhir,ppn,tipe,jenis,diskon,link,spaceid from $nama_tabel1 where id='$id' and spaceid='$spaceid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$spaceid = $row['spaceid'];
			$nama = $row['nama'];
			$code = $row['code'];
			$harga = $row['harga'];
			$budget = $row['budget'];
			$ppn = $row['ppn'];
			$tipe = $row['tipe'];
			$ppn =$row['ppn'];
			$jenis = $row['jenis'];
			$diskon =$row['diskon'];
			$link = $row['link'];
			$tglakhir = $row['tglakhir'];
			
			$sql = "select spaceid,nama,space,width,height from $nama_tabel  where spaceid='$spaceid'";
			$hsl = sql($sql);

			$row = sql_fetch_data($hsl);
			$nama = $row['nama'];
			$spaceid = $row['spaceid'];
			$width = $row['width'];
			$height = $row['height'];
			$space = $row['space'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function changejenis(jenis)
				{
					$(".jenisitem").hide();
					if(jenis!=="code") $("#upload").show("fast");
					else  $("#code").show("fast");
				}
				$(function() {
						$( "#tglakhir" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true
						});

				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
            <input type="hidden" name="spaceid" value="<?php echo $spaceid?>">
			<input type="hidden" name="aksi" value="saveeditbanner">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Banner</th>
				</tr>
                    <tr>
                      <td>Space </td>
                      <td><input type="text" name="space"  value="<?php echo"$space"; ?>" disabled></td>
                    </tr>
                    <tr>
                      <td>Nama Banner </td>
                      <td><input type="text" name="nama"  class="validate[required]" value="<?php echo"$nama"; ?>"></td>
                    </tr>
                    <tr>
                      <td>Lebar (pixel)</td>
                      <td><input type="text" name="width"  value="<?php echo"$width"; ?>" disabled></td>
                    </tr>
                    <tr>
                      <td>Tinggi (pixel)</td>
                      <td><input type="text" name="height" class=textfield2 value="<?php echo"$height"; ?>" disabled></td>
                    </tr>
                    <tr>
                      <td>Tipe Banner </td>
                      <td><select name="tipe"  class="validate[required]">
                          <option value="" >-- Pilih Tipe Banner ---</option>
                      	  <option value="bybudget" <?php if($tipe=="bybudget"){ echo "selected=\"selected\""; }?> >End by Budget</option>
                          <option value="bydate"  <?php if($tipe=="bydate"){ echo "selected=\"selected\""; }?>>End by date</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td>Budget </td>
                      <td><input type="text" name="budget" class=textfield2 value="<?php echo"$budget"; ?>"> 
                        (apabila tipe banner by budged example : 50000) </td>
                    </tr>
                
                    <tr> 
                      <td>Harga Pokok</td>
                      <td><input type="text" name="harga" value="<?php echo"$harga"; ?>">
                        Rupiah / 1000 impresi </td>
                    </tr>
                    <tr> 
                      <td>Diskon</td>
                      <td><input type="text" name="diskon" value="<?php echo"$diskon"; ?>">
                        %</td>
                    </tr>
                    <tr> 
                      <td>PPN</td>
                      <td><input type="text" name="ppn" value="<?php echo"$ppn"; ?>">
                        %</td>
                    </tr>
                    <tr>
                      <td>Letak</td>
                      <td><input type="text" name="space" value="<?php echo"$space"; ?>" disabled></td>
                    </tr>
                    <tr> 
                      <td>Tanggal Akhir</td>
                      <td> <input name="tglakhir" type="text"  id="tglakhir" value="<?php echo"$tglakhir"; ?>" >
                     </td>
                    </tr>
                    <tr> 
                      <td>Link Target</td>
                      <td><input type="text" name="link" size="70" class="validate[required]" value="<?php echo"$link"; ?>"></td>
                    </tr>
                    <tr> 
                      <td width="206" >Jenis Banner</td>
                      <td width="886"><select name="jenis"  onchange="changejenis(this.value);"  class="validate[required]">
                           <option value="">--Pilih Jenis--</option>
                           <option value="jpg" <?php if($jenis=="jpg"){ echo "selected=\"selected\""; }?>>Gambar JPEG</option>
                          <option value="gif" <?php if($jenis=="gif"){ echo "selected=\"selected\""; }?>>Gambar GIF</option>
                          <option value="swf" <?php if($jenis=="swf"){ echo "selected=\"selected\""; }?>>Animasi Flash</option>
                          <option value="png" <?php if($jenis=="png"){ echo "selected=\"selected\""; }?>>PNG Images</option>
                          <option value="code" <?php if($jenis=="code"){ echo "selected=\"selected\""; }?>>Advertising Code</option>
                        </select></td>
                    </tr>
                    <tr id="upload" <?php if($jenis=="code"){ ?> style="display:none" <?php }?> class="jenisitem" valign="top"> 
                      <td>Gambar</td>
                      <td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file"/></td>
                    </tr>
                      <tr id="code" <?php if($jenis!="code"){ ?> style="display:none" <?php }?> class="jenisitem" valign="top"> 
					<td>Ads Code</td>
					<td ><textarea name="code" cols="76" rows="5" id="code"></textarea></td>
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