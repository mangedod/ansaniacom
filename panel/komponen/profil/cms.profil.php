<?php 
//Variable halaman ini
$nama_tabel		= "tbl_cms_user";
$judul_per_hlm 	= 10;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//View
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$sql = "select username,userfullname,useraddress,useremail,userphone,userhandphone from $nama_tabel  where userid=$cuserid";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			$username = $row['username'];
			$userfullname = $row['userfullname'];
			$useraddress = $row['useraddress'];
			$useremail = $row['useremail'];
			$userphone = $row['userphone'];
			$userhandphone = $row['userhandphone'];
			
			?>
			<script>	
			$(document).ready(function() {
				$("#menufrm").validationEngine()
			});
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveeditprofil">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Ubah Profile</th>
				</tr>
				<tr> 
					<td valign="top">Nama</td>
					<td align="left"><input name="userfullname" type="text" size="40" value="<?php echo $userfullname?>" id="userfullname" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Username</td>
					<td align="left"><input name="username" type="text" size="40" value="<?php echo $username?>" id="username" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Alamat</td>
					<td align="left"><textarea cols="70" rows="5" name="useraddress" class="validate[required]"><?php echo $useraddress?></textarea></td>
				</tr>
				<tr> 
					<td valign="top">Email</td>
					<td align="left"><input name="useremail" type="text" size="40" value="<?php echo $useremail?>" id="useremail" class="validate[required,custom[email]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Telp</td>
					<td align="left"><input name="userphone" type="text" size="40" value="<?php echo $userphone?>" id="userphone" class="validate[custom[phone]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Handphone</td>
					<td align="left"><input name="userhandphone" type="text" size="40" value="<?php echo $userhandphone?>" id="userhandphone" class="validate[custom[phone]]" /></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Menu" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
			<?php 
		}
	} //EndView 
	
	//SaveEditProfil
	if($aksi=="saveeditprofil")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$userfullname = cleaninsert($_POST['userfullname']);
			$username = $_POST['username'];
			$useraddress = cleaninsert($_POST['useraddress']);
			$useremail = $_POST['useremail'];
			$userphone = $_POST['userphone'];
			$userhandphone = $_POST['userhandphone'];
			
			$perintah = "update $nama_tabel set userfullname='$userfullname',username='$username',useraddress='$useraddress',useremail='$useremail',userphone='$userphone',userhandphone='$userhandphone' where userid='$cuserid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah Profil $username dengan User ID $cuserid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
}
?>