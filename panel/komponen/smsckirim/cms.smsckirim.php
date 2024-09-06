<?php
//Variable halaman ini
$rubrik 		= "SMS Kirim";
$nama_tabel		= "tbl_smsc_smskeluar";
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//View Data
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; } else 
		{
			$mainmenu[] = array("Kirim SMS","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			?>
			<script type="text/javascript" src="template/js/jquery.tokeninput.js"></script>
			<link rel="stylesheet" href="template/styles/token-input-facebook.css" type="text/css" />
            <script>
				$(function(){
					$("#menufrm").validationEngine()
				});
				function textCounter(field, countfield, maxlimit) 
				{
					  if (field.value.length > maxlimit) 
					  {
						field.value = field.value.substring(0, maxlimit);
					  } 
					  else 
					  {
						countfield.value = maxlimit - field.value.length;
					  }
				}
			</script>
			<form method="post" name="menufrm" id="menufrm">
				<input type="hidden" name="aksi" value="savekirimsms"/>
				<table border="0" class="tabel-cms" width="100%">
					<tr>
						<th colspan="2">Kirim SMS</th>
					</tr>
					<tr> 
						<td width="176">To</td>
	                    <td align="left">
		                    <input type="text" name="to" id="to" class="validate[required]" value="" /> <em>Contoh: 6285624253500</em>
	                    </td>
					</tr>
                    <tr>
					<tr>
						<td>Isi SMS</td>
						<td><textarea style="width:400px;height:70px" rows="3" name="pesan" class="validate[required]" onKeyDown="textCounter(document.menufrm.pesan,document.menufrm.inputcount,500);" onKeyUp="textCounter(document.menufrm.pesan,document.menufrm.inputcount,500);"><?php echo $isipesan?></textarea></td>
					</tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td> 
                            Karakter yang tersisa 
                            <input readonly type="text" name="inputcount" size="5" maxlength="4" value="" class="textfield1" />
                            <script language="JavaScript">
                                document.menufrm.inputcount.value = (500 - document.menufrm.pesan.value.length);
                            </script>
                        </td>
                    </tr>
					<tr>
						<td></td>
						<td align="left">
							<input type="submit" name="Submit" value="Kirim" />
							<input type="button" onclick="javascript:history.back();" value="Batal">
						</td>
					</tr>
				</table>
			</form>
            <?php
		}
	}

	//Save Kirim SMS
	if($aksi=="savekirimsms")
	{
		if(!$oto['add']) { echo $error['add']; } else 
		{
				$id	    	= $_POST['id'];
				$pesan	    = desc($_POST['pesan']);
				$msisdn 	= desc($_POST['to']);
				$tanggal	= $_POST['tanggal'];

				$sql	= "select max(id) as idbaru from $nama_tabel";
				$query	= sql($sql);
				$idbaru	= sql_result($query,0,idbaru) + 1;
			
				$perintah 	= "insert into $nama_tabel (`id`,`msisdn`,`pesan`,`create_date`,`create_userid`) values ('$idbaru','$msisdn','$pesan','$date','$cuserid')";
				$hasil 		= sql($perintah);
					
				if($hasil)
				{

					kirimSMS($msisdn,$pesan,$idbaru);
										
					$msg = base64_encode("Success mengirim sms");
					header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
					exit();
				}
				else
				{
					$error = base64_encode("Gagal mengirim sms silahkan coba kembali");
					header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
					exit();
				}
				
			
		}
	}
}
?>