<?php 
//Variable halaman ini
$nama_tabel		= "tbl_static";
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
 

if(!$oto['oto']) { echo $error['oto']; }
else
{

	
	//Detail
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,ringkas,lengkap,alamat,oleh,alias,telp,gsm,bbm,instagram,youtube,email,email_support,gambar,gambar1,create_date,create_userid,update_date,update_userid from $nama_tabel  where alias='$kanal'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id                  = $row['id'];
			$nama                = $row['nama'];
			$ringkas             = $row['ringkas'];
			$alamat11             = $row['alamat'];
			$telp                = $row['telp'];
			$gsm                 = $row['gsm'];
			$bbm                 = $row['bbm'];
			$kontakinstagram     = $row['instagram'];
			$konakyoutube        = $row['youtube'];
			$kontakemail         = $row['email'];
			$kontakemail_support = $row['email_support'];
			$lengkap             = $row['lengkap'];
			$oleh                = $row['oleh'];
			$alias               = $row['alias'];
			$gambar              = $row['gambar'];
			$gambar1             = $row['gambar1'];
			$create_date         = tanggal($row['create_date']);
			$update_date         = tanggal($row['update_date']);
			$create_userid       = $row['create_userid'];
			$update_userid       = $row['update_userid'];
			$dtgenset            = sql_get_var_row("select webfacebook,webtwitter from tbl_konfigurasi where webid='1'");
			$webfacebook         = $dtgenset['webfacebook'];
			$webtwitter          = $dtgenset['webtwitter'];
			
			if(!empty($gambar)) $gambar = "<img src=\"../gambar/$kanal/$gambar\" alt=\"\" />"; else $gambar = "Masih kosong";
			if(!empty($gambar1)) $gambar1 = "<img src=\"../gambar/$kanal/$gambar1\" alt=\"\" />"; else $gambar1 = "Masih kosong";
			
			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail Informasi</th>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Judul</td> 
					<td align="left"><?php echo $nama?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Lengkap</td>
					<td ><?php echo $lengkap?></td>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Alamat</td> 
					<td align="left"><?php echo $alamat11?></td>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Telp</td> 
					<td align="left"><?php echo $telp?></td>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">No Hp</td> 
					<td align="left"><?php echo $gsm?></td>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">BBM</td> 
					<td align="left"><?php echo $bbm?></td>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Instagram</td> 
					<td align="left"><a target=_blank href="https://www.instagram.com/<?php echo $kontakinstagram?>">Lihat Instagram</a></td>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Email</td> 
					<td align="left"><?php echo $kontakemail?></td>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Email Support</td> 
					<td align="left"><?php echo $kontakemail_support?></td>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Facebook Page</td> 
					<td align="left"><a target=_blank href="http://www.facebook.com/<?php echo $webfacebook?>">Lihat Facebook</a></td>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Twitter Account</td> 
					<td align="left"><a target=_blank href="https://twitter.com/<?php echo $webtwitter?>">Lihat Twitter</a></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Pendukung</td>
					<td><?php echo $gambar?></td>
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
	
	//SaveTambahMenu
	if($aksi=="saveedit")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id       = $_POST['id'];
			$nama     = cleaninsert($_POST['nama']);
			$ringkas  = desc($_POST['ringkas']);
			$alamattk = desc($_POST['alamattk']);

			$telp          = cleaninsert($_POST['telp']);
			$gsm           = cleaninsert($_POST['gsm']);
			$bbm           = cleaninsert($_POST['bbm']);
			$instagram     = cleaninsert($_POST['instagram']);
			// $youtube    = cleaninsert($_POST['youtube']);
			$email         = cleaninsert($_POST['email']);
			$email_support = cleaninsert($_POST['email_support']);
			$lengkap       = desc($_POST['lengkap']);
			$oleh          = cleaninsert($_POST['oleh']);
			$alias         = getAlias($nama);

			$webfacebook    = cleaninsert($_POST['webfacebook']);
			$webtwitter     = cleaninsert($_POST['webtwitter']);
			
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

			$perintah1 = "update tbl_konfigurasi set webfacebook='$webfacebook',webtwitter='$webtwitter' where webid='1'";//deskripsi='$deskripsi',
			$hasil1 = sql($perintah1);
			
			$perintah = "update $nama_tabel set nama='$nama',ringkas='$ringkas',lengkap='$lengkap',oleh='$oleh',telp='$telp',gsm='$gsm',bbm='$bbm',alamat='$alamattk',
						instagram='$instagram',email='$email',email_support='$email_support',update_date='$date',update_userid='$cuserid' $vgambar where alias='$kanal'";
			//die($perintah);
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
	//EditMenu
	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,ringkas,lengkap,alamat,oleh,telp,gsm,bbm,instagram,youtube,email,email_support from $nama_tabel  where alias='$kanal'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id      = $row['id'];
			$nama    = $row['nama'];
			$ringkas = $row['ringkas'];
			$alamattk = $row['alamat'];

			$telp                = $row['telp'];
			$gsm                 = $row['gsm'];
			$bbm                 = $row['bbm'];
			$kontakinstagram     = $row['instagram'];
			$konakyoutube        = $row['youtube'];
			$kontakemail         = $row['email'];
			$kontakemail_support = $row['email_support'];
			$lengkap             = $row['lengkap'];
			$oleh                = $row['oleh'];

			$dtgenset      = sql_get_var_row("select webfacebook,webtwitter from tbl_konfigurasi where webid='1'");
			$webfacebook   = $dtgenset['webfacebook'];
			$webtwitter    = $dtgenset['webtwitter'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
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
					<td valign="top">Judul</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td >Informasi Lengkap</td>
					<td ><textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" ><?php echo $lengkap?></textarea></td>
				</tr>
                <tr> 
					<td>Ringkas</td>
					<td><textarea name="ringkas" cols="70" rows="10" id="ringkas" class="ckeditor validate[required]" ><?php echo $ringkas?></textarea></td>
				</tr>
<tr> 
					<td>Alamat</td>
					<td><textarea name="alamattk" cols="70" rows="10" id="alamattk" class="ckeditor validate[required]" ><?php echo $alamattk?></textarea></td>
				</tr>

                <tr> 
					<td>Telp</td>
					<td><input name="telp" type="text" size="20" value="<?php echo $telp?>" id="telp" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>No Hp</td>
					<td><input name="gsm" type="text" size="20" value="<?php echo $gsm?>" id="gsm" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>BBM</td>
					<td><input name="bbm" type="text" size="20" value="<?php echo $bbm?>" id="bbm" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Email</td>
					<td><input name="email" type="text" size="20" value="<?php echo $kontakemail?>" id="email" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Email Support</td>
					<td><input name="email_support" type="text" size="20" value="<?php echo $kontakemail_support?>" id="email_support" class="validate[required]" /></td>
				</tr>
                  <tr>
                    <td valign="top">Instagram</td>
                    <td align="left">https://www.instagram.com/
                      <input name="instagram" type="text" size="40" value="<?php echo $kontakinstagram?>" id="instagram" class="validate[required]" /></td>
                  </tr>
                  <tr>
                    <td valign="top">Facebook Page</td>
                    <td align="left">http://www.facebook.com/
                      <input name="webfacebook" type="text" size="40" value="<?php echo $webfacebook?>" id="webfacebook" class="validate[required]" /></td>
                  </tr>
                  <tr>
                    <td valign="top">Twitter Account</td>
                    <td align="left">http://www.twitter.com/
                      <input name="webtwitter" type="text" size="40" value="<?php echo $webtwitter?>" id="webtwitter" class="validate[required]" /></td>
                  </tr>
                <tr> 
					<td>Penulis</td>
					<td><input name="oleh" type="text" size="20" value="<?php echo $oleh?>" id="oleh" class="validate[required]" /></td>
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