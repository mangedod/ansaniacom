<?php 
//Variable halaman ini
$nama_tabel1	= "tbl_reseller_jenis";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];


//Variable Umum
if(isset($_POST['resellerjenisid'])) $resellerjenisid = $_POST['resellerjenisid'];
 else $resellerjenisid = $_GET['resellerjenisid']; 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{

		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Jenis","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Jenis","tambah","$alamat&aksi=tambahsec");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Jenis","str","text","$data");
			
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
			
			$sql = "select resellerjenisid,nama,diskon,keterangan from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=40%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Jenis</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=diskon\" title=\"Urutkan\">Diskon</a></th>\n");
			print("<th width=50%><a href=\"$urlorder&order=resellerjenisid\" title=\"Urutkan\">Keterangan</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$resellerjenisid = $row['resellerjenisid'];
				$nama = $row['nama'];
				$keterangan = $row['keterangan'];
				$diskon = $row['diskon'];

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama<br clear=\"all\" /></td>\n
					<td  valign=top >$diskon %</td>
					<td  valign=top >$keterangan</td>
				");
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=editsec&resellerjenisid=$resellerjenisid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapussec&resellerjenisid=$resellerjenisid&hlm=$hlm");
								
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
	if($aksi=="hapussec")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$perintah = "delete from $nama_tabel1 where resellerjenisid='$resellerjenisid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus Data dengan ID $resellerjenisid");
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
	
	//SaveTambahSec
	if($aksi=="savetambahsec")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama = cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$diskon = $_POST['diskon'];
			
			$new = newid("resellerjenisid",$nama_tabel1);
			
			$perintah = "insert into $nama_tabel1(resellerjenisid,nama,diskon,keterangan,create_date,create_userid $fgambar) 
						values ('$new','$nama','$diskon','$keterangan','$date','$cuserid' $vgambar)";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan Sec baru");
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
	if($aksi=="tambahsec")
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
			<input type="hidden" name="aksi" value="savetambahsec">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Jenis</th>
				</tr>
				<tr> 
					<td width="15%">Nama Jenis</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td width="15%">Diskon Belanja</td>
					<td ><input name="diskon" type="text" size="20" value="" id="diskon" class="validate[required]" /> %</td>
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
			$diskon = $_POST['diskon'];
			
			
			$perintah = "update $nama_tabel1 set nama='$nama',diskon='$diskon',keterangan='$keterangan',
						update_date='$date',update_userid='$cuserid' where resellerjenisid='$resellerjenisid'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $resellerjenisid");
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

	if($aksi=="editsec")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select resellerjenisid,nama,keterangan,diskon from $nama_tabel1  where resellerjenisid='$resellerjenisid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$resellerjenisid = $row['resellerjenisid'];
			$nama = $row['nama'];
			$keterangan = $row['keterangan'];
			$diskon = $row['diskon'];
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditsec">
            <input type="hidden" name="resellerjenisid" value="<?php echo $resellerjenisid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Jenis</th>
				</tr>
				<tr> 
					<td valign="top">Nama Jenis</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td width="15%">Diskon Belanja</td>
					<td ><input name="diskon" type="text" size="20" value="<?php echo $diskon?>" id="diskon" class="validate[required]" /> %</td>
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