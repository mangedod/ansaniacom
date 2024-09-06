<?php 
//Variable halaman ini
$nama_tabel		= "tbl_bukutamu";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];


//Variable Umum
if(isset($_POST['komid'])) $komid = $_POST['komid'];
 else $komid = $_GET['komid'];
 
if(isset($_POST['id'])) $id = $_POST['id'];
 else $komid = $_GET['komid'];
 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Buku Tamu","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama","str","text","$data");
			$cari[] = array("email","Alamat Email","str","text","$data");
			$cari[] = array("komentar","Isi Komentar","str","text","$data");
			$cari[] = array("create_date","Tanggal","date","date","$data");
			
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("komid","desc",$pageparam,$param);
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
			
			$sql = "select komid,nama,email,ip,komentar,published,balasan from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=60%>Komentar</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id        = $row['id'];
				$nama      = $row['nama'];
				$email     = $row['email'];
				$komid     = $row['komid'];
				$ip        = $row['ip'];
				$komentar  = nl2br($row['komentar']);
				$published = $row['published'];
				$balasan    = $row['balasan'];
				
				if(!empty($balasan)) $balasan = "<br /><br /><strong>Balasan:</strong><br />$balasan";
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				 
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top><strong>$nama</strong><br />$email<br />$ip</td>
					<td  valign=top>$komentar $balasan</td>\n
					<!-- <td  valign=top><a href=\"$urls\" target=\"_blank\">$judul</a></td>\n -->
					<td  valign=top >$publish</td>");
					
				print("<td>");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publish&komid=$komid&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publish&komid=$komid&hlm=$hlm");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&komid=$komid&hlm=$hlm");
				$acc[] = array("Balas","mail","$alamat&aksi=reply&komid=$komid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&komid=$komid&hlm=$hlm");
								
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
			$komid = $_GET['komid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,ringkas,lengkap,oleh,alias,gambar,gambar1,create_date,create_userid,update_date,update_userid from $nama_tabel  where komid='$komid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$ringkas = $row['ringkas'];
			$lengkap = $row['lengkap'];
			$oleh = $row['oleh'];
			$alias = $row['alias'];
			$gambar = $row['gambar'];
			$gambar1 = $row['gambar1'];
			$create_date = tanggal($row['create_date']);
			$update_date = tanggal($row['update_date']);
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
                    <input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=editgambar&komid=$komid"?>'" value="Edit Gambar">
                   <?php if($gambar!="Masih kosong") { ?><input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=hapusgambar&komid=$komid"?>'" value="Hapus Gambar"><?php } ?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Besar</td>
					<td><?php echo $gambar1?><br />
					<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=editgambarlarge&komid=$komid"?>'" value="Edit Gambar">
                   <?php if($gambar1!="Masih kosong") { ?><input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=hapusgambarlarge&komid=$komid"?>'" value="Hapus Gambar"><?php } ?></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=edit&komid=$komid"?>'" value="Ubah Data">
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
			
			$komid = $_GET['komid'];

			$perintah = "delete from $nama_tabel where komid='$komid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//Publish
	if($aksi=="publish")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$komid = $_GET['komid'];
			
			$perintah 	= "select published from $nama_tabel where komid='$komid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['published']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set published='$status' where komid='$komid' ";
			$hasil		= sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Success merubah status data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}

	if($aksi=="saveedit")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$komid = $_POST['komid'];
			$nama = cleaninsert($_POST['nama']);
			$email = cleaninsert($_POST['email']);
			$komentar = desc($_POST['komentar']);
			$homepage = cleaninsert($_POST['homepage']);
			$ip = $_POST['ip'];
			$alias = getAlias($nama);
			
			$perintah = "update $nama_tabel set nama='$nama',email='$email',komentar='$komentar',homepage='$homepage',ip='$ip',
						update_date='$date',update_userid='$cuserid' where komid='$komid'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}

	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$komid = $_GET['komid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select * from $nama_tabel where komid='$komid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$komid = $row['komid'];
			$nama = $row['nama'];
			$komentar = $row['komentar'];
			$ip = $row['ip'];
			$email = $row['email'];
			$homepage = $row['homepage'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="komid" value="<?php echo $komid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td valign="top">Nama</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="50" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td valign="top">Alamat Email</td> 
					<td align="left"><input name="email" value="<?php echo $email?>" type="text" size="50" id="email" class="validate[required]"  /></td>
				</tr>
                 <tr> 
					<td valign="top">Homepage</td> 
					<td align="left"><input name="homepage" value="<?php echo $homepage?>" type="text" size="50" id="homepage" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td >Komentar</td>
					<td ><textarea name="komentar" cols="90" rows="20" id="komentar" class="ckeditor validate[required]" ><?php echo $komentar?></textarea></td>
				</tr>
                <tr> 
					<td>IP Address</td>
					<td><input name="ip" type="text" size="20" value="<?php echo $ip?>" id="ip" class="validate[required]" /></td>
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
	
	if($aksi=="savereply")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$komid = $_POST['komid'];
			$balasan = desc($_POST['balasan']);
			$perintah = "update $nama_tabel set balasan='$balasan',update_date='$date',update_userid='$cuserid' where komid='$komid'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil membalas bukutamu");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Gagal membalas bukutamu");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}

	if($aksi=="reply")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$komid = $_GET['komid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select * from $nama_tabel where komid='$komid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$komid = $row['komid'];
			$nama = $row['nama'];
			$komentar = nl2br($row['komentar']);
			$ip = $row['ip'];
			$email = $row['email'];
			$homepage = $row['homepage'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savereply">
            <input type="hidden" name="komid" value="<?php echo $komid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Balas Bukutamu</th>
				</tr>
				<tr> 
					<td valign="top">Nama</td> 
					<td align="left"><?php echo $nama?></td>
				</tr>
                <tr> 
					<td >Komentar</td>
					<td ><div style="width:700px;"><?php echo $komentar?></div></td>
				</tr>
                  <tr> 
					<td >Balasan</td>
					<td ><textarea name="balasan" cols="90" rows="20" id="balasan" class="validate[required]" ><?php echo $balasan?></textarea></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Balasan" />
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