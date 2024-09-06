<?php
//Variable halaman ini
$nama_tabel    = "tbl_smsc_smskeluar";
$nama_tabel1   = "tbl_smsc_contact";
$judul_per_hlm = 25;
$otoritas      = kodeoto($kanal);
$oto           = $otoritas[0];
$gambars_maxw  = 350;
$gambars_maxh  = 300;
$gambarl_maxw  = 800;
$gambarl_maxh  = 600;


//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];
if(isset($_POST['secid'])) $secid = $_POST['secid'];
 else $secid = $_GET['secid'];


if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			 $mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			 mainaction($mainmenu,$param);

			?>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popsecid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=mitra&aksi=popsecid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("secid").value = res.secid;
							document.getElementById("secid_text").value = res.secid_text;
						}
						return false;
				}
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savebalas">
            <input type="hidden" name="id" value="<?php echo $id?>">
            <input type="hidden" name="msisdn" value="<?php echo $msisdn?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Kirim Blas SMS</th>
				</tr>
             <tr> 
					<td width="176">Group</td>
					<td width="471">
                   <select name="secid" id="secid"  class="validate[required]">
                    <option value="">--Pilih Group--</option>
                    	<option value="0">Seluruh Member</option>
                       	<option value="1">Seluruh Reseller</option> 
                    </select></td>
				</tr>
				<tr>
					<td valign="top">Pesan</td>
					<td align="left"><textarea name="jawaban" id="jawaban" cols="70" rows="5" class="validate[required]"></textarea><br />
                    Anda bisa mengirimkan SMS dengan otomatis diganti kata [nama] dengan nama penerima</td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Kirim SMS Ke Group" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat;?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>

            <?php  
		}
	}

	if($aksi=="savebalas") 
	{

		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$secid = $_POST['secid'];
			$jawaban    = cleaninsert($_POST['jawaban']);
			
			$sql = "SELECT userphonegsm,userfullname from tbl_member where tipe='$secid' and userphonegsm!='' and (userid='7' or userid='1141')";
			$hsl = sql($sql);
			while($row = sql_fetch_data($hsl))
			{
				$msisdn = $row['userphonegsm'];
				$userfullname = $row['userfullname'];
				$jawaban2 = str_replace("[nama]",$userfullname,$jawaban);
				
				$newid = newid("id","$nama_tabel");
				
				$perintah 	= "insert into $nama_tabel (`id`,`msisdn`,`pesan`,`create_date`,`create_userid`) values ('$newid','$msisdn','$jawaban2','$date','$cuserid')";
				$hasil 		= sql($perintah);
				
				kirimSMS($msisdn,$jawaban2,$newid);
				
				unset($jawaban2,$userfullname);
				
			}
			
			if($hsl)
			{
				$msg = base64_encode("Berhasil mengirim sms ke $secid_text");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak mengirim sms, silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
}