<?php 
//Variable halaman ini
$nama_tabel		= "tbl_cms_user";
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
	//Update Password
	if($aksi=="savepassword")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$old_paswd = md5($_POST['old_paswd']);
			$new_paswd = md5($_POST['new_paswd']);
			$new_paswd2 = md5($_POST['new_paswd2']);
			
			$username = $_SESSION['cms_username'];
			$perintah = "SELECT userpassword from $nama_tabel where username='$username'";
			$hasil = sql($perintah);
			if($hasil)	{ $userpassword = sql_result($hasil,0,userpassword); }
			if($userpassword != $old_paswd)
			{
				$error = base64_encode("Password lama tidak sesuai silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
			
			if($new_paswd != $new_paswd2)
			{
				$error = base64_encode("Konfirmasi password baru tidak sesuai silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
			
			$perintah = "update $nama_tabel set userpassword='$new_paswd' where username='$username'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengganti password baru");
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
?>
<script>	
$(document).ready(function() {
	$("#menufrm").validationEngine()
});
</script>
<form method="post" name="menufrm" id="menufrm">
<input type="hidden" name="aksi" value="savepassword">
<table border="0" class="tabel-cms" width="100%">
	<tr>
		<th colspan="2">Ganti Password</th>
	</tr>
	<tr> 
		<td width="176">Password Lama</td>
		<td width="471"><input name="old_paswd" type="password" size="40" value="" id="old_paswd" class="validate[required]" /></td>
	</tr>
	<tr> 
		<td valign="top">Password Baru</td>
		<td align="left"><input name="new_paswd" type="password" size="40" value="" id="new_paswd" class="validate[required]" /></td>
	</tr>
	<tr> 
		<td valign="top">Konfirmasi Password Baru</td>
		<td align="left"><input name="new_paswd2" type="password"  size="40"  value=""  id="new_paswd2" class="validate[required]"/></td>
	</tr>
	<tr> 
		<td valign="top">&nbsp;</td>
		<td align="left">
			<input type="submit" name="Submit" value="Simpan Password" />
			<input type="button" onclick="history.back()" value="Batal">
		</td>
	</tr>
</table>
</form>