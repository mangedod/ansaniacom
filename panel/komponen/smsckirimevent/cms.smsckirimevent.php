<?php
//Variable halaman ini
$rubrik 		= "Kirim SMS Group";
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
			$mainmenu[] = array("Kirim SMS Group","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			$sms	= $_GET['sms'];
			$id		= $_GET['id'];
			
			if(!empty($sms) and !empty($id))
			{
				$sql	= "select pesan from tbl_smsc_sms$sms where id='$id'";
				$query	= sql($sql);
				$isipesan	= sql_result($query,0,pesan);
			}

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
                <input type="hidden" name="id" value="<?php echo $id;?>" />
                <input type="hidden" name="sms" value="<?php echo $sms;?>" />
				<table border="0" class="tabel-cms" width="100%">
					<tr>
						<th colspan="2">Kirim SMS Group</th>
					</tr>
					<tr> 
						<td width="176">Ke Peserta Event</td>
	                    <td align="left">
		                    <select id="eventid" name="eventid" class="validate">
                                <option value="">Pilih Event</option>
                                <?php
                                    $sql = "select eventid,nama from tbl_event where published='1' order by eventid desc";
                                    $hsl = sql($sql);
                                    
                                    while($data=sql_fetch_data($hsl))
                                    {
                                        $eventid = $data['eventid'];
                                        $nama = $data['nama'];
                                        $nama = substr($nama,0,100);
                                        
                                        echo "<option value='$eventid'>$nama</option>";
                                    }
                                    
                                ?>
                            </select>
	                    </td>
					</tr>
                    <tr>
					<tr>
						<td>Isi SMS</td>
						<td><textarea style="width:600px;height:120px" rows="5" name="pesan" class="validate[required]" onKeyDown="textCounter(document.menufrm.pesan,document.menufrm.inputcount,500);" onKeyUp="textCounter(document.menufrm.pesan,document.menufrm.inputcount,500);"><?php echo $isipesan?></textarea>
                        <br clear="all" />Jika anda ingin menyisipkan nama penerima didalam pesan secara otomatis,<br /> tuliskan dengan variable <strong>[nama]</strong> dimana tanda <strong>[nama]</strong> akan diganti
                        dengan nama penerima</td>
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
			
			$eventid = $_POST['eventid'];
			$pesan = $_POST['pesan'];
	
			$sql	= "SELECT tlp,handphone,nama from  `tbl_peserta` where (tlp!='' or handphone!='') and eventid='$eventid'";
			$query	= sql($sql);
			$a = 0;
			while($row = sql_fetch_data($query))
			{
				$nama			= $row['nama'];
				$tlp	= $row['tlp'];
				$handphone = $handphone;
				$pesertaid = $row['pesertaid'];
				
				$handphone = str_replace("-","",$handphone);
				$tlp = str_replace("-","",$tlp);
				
				if(empty($handphone)) $msisdn = $tlp;
				else $msisdn = $tlp;
				
				$pesan2 = str_replace("[nama]",$nama,$pesan);
			
				$new = newid("id","$nama_tabel");
			
				$perintah 	= "insert into $nama_tabel (`id`,`msisdn`,`pesan`,`create_date`,`create_userid`) values ('$idbaru','$msisdn','$pesan2','$date','$cuserid')";
				$hasil 		= sql($perintah);
				
				kirimSMS($msisdn,$pesan2,$new);
				
				unset($nama,$pesan2);
					
				$a++;
			}
			
			if($hsl)
			{

				$msg = base64_encode("Success menambahkan sms dan sedang diantrikan, silahkan lihat menu SMS Keluar");
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