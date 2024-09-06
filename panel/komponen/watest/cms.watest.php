<?php 
//Variable halaman ini
$nama_tabel		= "tbl_wa";
$nama_tabel1	= "tbl_artikel_sec";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];


//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Album
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {	$mainmenu[] = array("Kembali","back","$alamat");
			mainaction($mainmenu,$param);
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="kirim">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Test Kirim WA</th>
				</tr>
				<tr> 
					<td width="15%">Nomor Handphone</td>
					<td ><input name="userphonegsm" type="text" size="70" value="" id="userphonegsm"  placeholder="Contoh 6281223800500" class="validate[required]" />
                    </td>
				</tr>
                <tr> 
					<td >Pesan</td>
					<td ><textarea name="pesan" cols="76" rows="5" id="pesan" class="validate[required]"></textarea></td>
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
	
	//SaveTambahSec
	if($aksi=="kirim")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$userphonegsm = cleaninsert($_POST['userphonegsm']);
			$pesan = cleaninsert($_POST['pesan']);
			
			kirimwa($userphonegsm,$pesan);
			
			if($hasil)
			{   
				$msg = base64_encode("WA Test berhasil ditambahkan, dalam antrian pengiriman");
				header("location: index.php?kanal=wablastlog&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal dikirimkan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	

	
}

?>