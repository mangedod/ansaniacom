<?php 
//Variable halaman ini
$nama_tabel		= "tbl_konfigurasi";
$judul_per_hlm 	= 10;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;

//Variable Umum
$webid	= 1;

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//View
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$sql                    = "select title,domain,deskripsi,owner,support,support_email,metakeyword,smtpuser,smtphost,smtpport,smtppass,issmtp,logo,webfacebook,webtwitter,jedapembayaran,smsAdmin,webinstagram,webyoutube,webtiktok,smsKeuangan from $nama_tabel  where webid=$webid";
			$hsl                    = sql($sql);
			$row                    = sql_fetch_data($hsl);
			$title                  = $row['title'];
			$domain                 = $row['domain'];
			$deskripsi              = $row['deskripsi'];
			$owner                  = $row['owner'];
			$support                = $row['support'];
			$support_email          = $row['support_email'];
			$metakeyword            = $row['metakeyword'];
			$issmtp                 = $row['issmtp'];
			$smtpuser               = $row['smtpuser'];
			$smtphost               = $row['smtphost'];
			$smtpport               = $row['smtpport'];
			$smtppass               = $row['smtppass'];
			$issmtp                 = $row['issmtp'];
			$logo                   = $row['logo'];
			$webtwitter             = $row['webtwitter'];
			$webfacebook            = $row['webfacebook'];
			$webyoutube            = $row['webyoutube'];
			$webinstagram            = $row['webinstagram'];
			$webtiktok            = $row['webtiktok'];
			$jedapembayaran         = $row['jedapembayaran'];
			$smsAdmin               = $row['smsAdmin'];
			$smsKeuangan            = $row['smsKeuangan'];
			if(!empty($logo)) $logo = "<img src=\"../gambar/web/$logo\" alt=\"\" />"; else $logo = "Masih kosong";
			?>
			<script>	
			$(document).ready(function() {
				$("#menufrm").validationEngine()
			});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditgeneral">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">General Setting</th>
				</tr>
				<tr> 
					<td valign="top">Judul Web</td>
					<td align="left"><input name="title" type="text" size="40" value="<?php echo $title?>" id="title" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Domain</td>
					<td align="left"><input name="domain" type="text" size="40" value="<?php echo $domain?>" id="domain" class="validate[required,custom[url]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Deskripsi</td>
					<td align="left"><textarea cols="70" rows="5" name="deskripsi" class="validate[required]"><?php echo $deskripsi?></textarea></td>
				</tr>
                <tr> 
					<td valign="top">Meta Keywords</td>
					<td align="left"><textarea cols="70" rows="5" name="metakeyword" class="validate[required]"><?php echo $metakeyword?></textarea></td>
				</tr>
                <tr> 
					<td valign="top">Jeda Pembayaran</td>
					<td align="left"><input name="jedapembayaran" type="text" size="40" value="<?php echo $jedapembayaran?>" id="jedapembayaran" class="validate[required]" /> Jam</td>
				</tr>
                <tr>
                  <th colspan="2" valign="top">Konfigurasi Email</th>
                </tr>
				<tr> 
					<td valign="top">Owner</td>
					<td align="left"><input name="owner" type="text" size="40" value="<?php echo $owner?>" id="owner" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Support</td>
					<td align="left"><input name="support" type="text" size="40" value="<?php echo $support?>" id="support" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Support Email</td>
					<td align="left"><input name="support_email" type="text" size="40" value="<?php echo $support_email?>" id="support_email" class="validate[required,custom[email]]" /></td>
				</tr>
                <tr> 
					<td valign="top">SMTP Host</td>
					<td align="left">
                    <select name="issmtp" id="issmtp">
                    	<option value="0" <?php if($issmtp=="0"){ ?> selected="selected" <?php }?>>Local Email</option>
                        <option value="1" <?php if($issmtp=="1"){ ?> selected="selected" <?php }?>>Remote SMTP</option>
                    </select>
                    <script>
						$("#issmtp").change(function() {
						  var is = $("#issmtp").val();
						  if(is=="1"){ $(".is").show(); }
						  else { $(".is").hide(); }
						});
					</script>                    </td>
				</tr>
                <tr  <?php if($issmtp=="0"){ ?> style="display:none" <?php }?> class="is" > 
					<td valign="top">SMTP Host</td>
					<td align="left"><input name="smtphost" type="text" size="40" value="<?php echo $smtphost?>" id="smtphost" /></td>
				</tr>
                  <tr <?php if($issmtp=="0"){ ?> style="display:none" <?php }?> class="is" > 
					<td valign="top">SMTP Port</td>
					<td align="left"><input name="smtpport" type="text" size="40" value="<?php echo $smtpport?>" id="smtpport" /></td>
				</tr>
                  <tr <?php if($issmtp=="0"){ ?> style="display:none" <?php }?> class="is" > 
					<td valign="top">SMTP Usename</td>
					<td align="left"><input name="smtpuser" type="text" size="40" value="<?php echo $smtpuser?>" id="smtpuser" /></td>
				</tr>
                  <tr   <?php if($issmtp=="0"){ ?> style="display:none" <?php }?> class="is"> 
					<td valign="top">SMTP Password</td>
					<td align="left"><input name="smtppass" type="text" size="40" value="<?php echo $smtppass?>" id="smtppass" /></td>
				</tr>
                <tr>
                  <th colspan="2" valign="top">Konfigurasi SMS</th>
                </tr>
				<tr> 
					<td valign="top">SMS Admin</td>
					<td align="left"><input name="smsAdmin" type="text" size="40" value="<?php echo $smsAdmin?>" id="smsAdmin" class="validate[required]" /><br><i>Contoh : 08123456789</i></td>
				</tr>
				<tr> 
					<td valign="top">SMS Keuangan</td>
					<td align="left"><input name="smsKeuangan" type="text" size="40" value="<?php echo $smsKeuangan?>" id="smsKeuangan" class="validate[required]" /><br><i>Contoh : 08123456789</i></td>
				</tr>
                  <tr>
                    <th colspan="2" valign="top">Social Media</th>
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
                    <td valign="top">Tiktok Account</td>
                    <td align="left">http://www.tiktok.com/
                      <input name="webtiktok" type="text" size="40" value="<?php echo $webtiktok?>" id="webtiktok" class="validate[required]" /></td>
                  </tr>
                   <tr>
                    <td valign="top">Instagram Account</td>
                    <td align="left">http://www.instagram.com/
                      <input name="webinstagram" type="text" size="40" value="<?php echo $webinstagram?>" id="webinstagram" class="validate[required]" /></td>
                  </tr>
                   <tr>
                    <td valign="top">Youtube Account</td>
                    <td align="left">http://www.youtube.com/
                      <input name="webyoutube" type="text" size="40" value="<?php echo $webyoutube?>" id="webyoutube" class="validate[required]" /></td>
                  </tr>
                  <tr>
                    <th colspan="2" valign="top">Logo Website</th>
                  </tr>
                  <tr>
                    <td valign="top">Logo</td>
                    <td align="left"><?php echo $logo?><br /><input name="logo" type="file" size="20" value="" id="logo" title="Pilih Gambar Dari Drive" /></td>
                  </tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Konfigurasi" />
						<input type="button" onclick="javascript:history.back();" value="Batal">					</td>
				</tr>
			</table>
			</form>
			<?php 
		}
	} //EndView 
	
	//SaveEditGeneral
	if($aksi=="saveeditgeneral")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$title          = cleaninsert($_POST['title']);
			$domain         = cleaninsert($_POST['domain']);
			$deskripsi      = cleaninsert($_POST['deskripsi']);
			$owner          = cleaninsert($_POST['owner']);
			$support        = cleaninsert($_POST['support']);
			$support_email  = cleaninsert($_POST['support_email']);
			$metakeyword    = cleaninsert($_POST['metakeyword']);
			$smtphost       = cleaninsert($_POST['smtphost']);
			$smtpuser       = cleaninsert($_POST['smtpuser']);
			$smtpport       = cleaninsert($_POST['smtpport']);
			$smtppass       = cleaninsert($_POST['smtppass']);
			$issmtp         = cleaninsert($_POST['issmtp']);
			$alias          = getalias($title);
			$webfacebook    = cleaninsert($_POST['webfacebook']);
			$webtwitter     = cleaninsert($_POST['webtwitter']);
			$jedapembayaran = cleaninsert($_POST['jedapembayaran']);
			$smsAdmin       = cleaninsert($_POST['smsAdmin']);
			$smsKeuangan    = cleaninsert($_POST['smsKeuangan']);
			$webyoutube            = $_POST['webyoutube'];
			$webinstagram            = $_POST['webinstagram'];
			$webtiktok            = $_POST['webtiktok'];

			//Upload Gambar
			if(!file_exists("$pathfile/web/")) mkdir("$pathfile/web/");
			
			if($_FILES['logo']['size']>0)
			{
				$ext = getimgext($_FILES['logo']);
				$namagambars = "logo-$alias.$ext";
				$gambars = resizeimg($_FILES['logo']['tmp_name'],"$pathfile/web/$namagambars",$gambars_maxw,$gambars_maxh);
				
				$namagambarl = "logo-$alias-l.$ext";
				$gambarl = resizeimg($_FILES['logo']['tmp_name'],"$pathfile/web/$namagambarl",$gambarl_maxw,$gambarl_maxh);
				
				if($gambarl){ 
					$vgambar = ",logo='$namagambars'";
				}
			}
			
			$perintah = "update $nama_tabel set title='$title',domain='$domain',deskripsi='$deskripsi',owner='$owner', jedapembayaran='$jedapembayaran',
						support='$support',support_email='$support_email',metakeyword='$metakeyword',smtphost='$smtphost',smtpuser='$smtpuser',webtiktok='$webtiktok',webyoutube='$webyoutube',webinstagram='$webinstagram',
						smtppass='$smtppass',smtpport='$smtpport',issmtp='$issmtp',webfacebook='$webfacebook',webtwitter='$webtwitter',smsAdmin='$smsAdmin',
						smsKeuangan='$smsKeuangan' $vgambar where webid='$webid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah General Setting");
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
}
?>