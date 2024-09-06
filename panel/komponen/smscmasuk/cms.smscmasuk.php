<?php
//Variable halaman ini
$rubrik 		= "SMS Masuk";
$nama_tabel		= "tbl_smsc_smsmasuk";
$nama_tabel1	= "tbl_smsc_smskeluar";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$alamatsms		= "index.php?kanal=smsckirim&tab=$tab&tabsub=$tabsub";

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
			$mainmenu[] = array("Lihat SMS Masuk","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[]		  = array("msisdn","No Handphone","str","text","$data");
			$cari[]       = array("pesan","Pesan","str","text","$data");
			$cari[]		  = array("terima","Tanggal Terima","date","date","$date");	
			$formcari     = cmsformcari($cari,$pageparam);
			$where        = $formcari[0]['where'];
			$param        = $formcari[0]['param'];

			//Orderring
			$order    = getorder("id","desc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];

			$tot = sql_get_var("select count(*) as jml from $nama_tabel where 1 $where $parorder");
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select id,msisdn,kirim,terima,pesan,status from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i	 = 1;
			$no  = (($hlm - 1) * $judul_per_hlm) + 1;

			echo "<table border=0 class='tabel-cms' width=100% cellpadding='1' cellspacing='1'><thead><tr>";
			echo "<th width=5%>Nomor</th>";
			echo "<th width=15%><a href='$urlorder&order=msisdn' title='Urutkan'>No Handphone</a></th>";
			echo "<th width=15%><a href='$urlorder&order=terima' title='Urutkan'>Tanggal Terima</a></th>";
			echo "<th width=30%>Pesan</th>";
			echo "<th width=10%>Status</th>";
			echo "<th width=10% align='center'><b>Action</b></th>";
			echo "</tr></thead>";

			while($row = sql_fetch_data($hsl))
			{
				$id		= $row['id'];
				$msisdn	= $row['msisdn'];
				$kirim	= $row['kirim'];
				$terima = $row['terima'];
				$status	= $row['status']; 
				$pesan	= $row['pesan'];
				
				if($status == "1") 
					$namastat = "Replayed";
				else 
					$namastat = "<span style='color:red;'>Unreplay</span>";

				echo "<tr class='row$i'>";
				echo "<td valign='top'>$no</td>";
				echo "<td valign='top'><b>$msisdn</b></td>";
				echo "<td valign='top'>$terima</td>";
				echo "<td valign='top'>$pesan</td>";
				echo "<td valign='top'>$namastat</td>";
				echo "<td>";
				
				$acc[] = array("Balas SMS","sms","$alamat&aksi=balassms&id=$id&hlm=$hlm");
				$acc[] = array("Teruskan","edit","$alamatsms&sms=masuk&id=$id");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&id=$id&hlm=$hlm");

				cmsaction($acc);
				unset($acc);

				echo "</td></tr>";

				$i %= 2;
				$i++;
				$no++;
				$ord++;
				unset($housekeepingtask);
				// echo"<br>";
			}
			echo "</table><br clear='all'/>";

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			sql_free_result($hsl);
		}
	}

	//Hapus Data
	if($aksi=="hapus")
	{
		if(!$oto['delete']) { echo $error['delete']; } else 
		{
			$sql1	= "select `id`,`msisdn`,`smsc`,`kirim`,`terima`,`pesan`,`create_date`,`status` from $nama_tabel where id='$id'";
			$query1	= sql($sql1);
			$row1	= sql_fetch_data($query1);
			$id			= $row1['id'];
			$msisdn		= $row1['msisdn'];
			$smsc		= $row1['smsc'];
			$kirim		= $row1['kirim'];
			$terima		= $row1['terima'];
			$pesan		= $row1['pesan'];
			$tanggal	= $row1['create_date'];
			$status		= $row1['status'];
			
			$sql	= "select max(id) as idbaru from tbl_smsc_trash_smsmasuk";
			$query	= sql($sql);
			$idbaru	= sql_result($query,0,idbaru) + 1;
		
			$perintah 	= "insert into tbl_smsc_trash_smsmasuk (`id`,`msisdn`,`smsc`,`kirim`,`terima`,`pesan`,`create_date`,`status`,`create_userid`) 
							values ('$idbaru','$msisdn','$smsc','$kirim','$terima','$pesan','$tanggal','$status','$cuserid')";
			$hasil 		= sql($perintah);
	
			$sql = "delete from $nama_tabel where id='$id'";
			$hsl = sql($sql);
			if($hsl)
			{
				$msg = base64_encode("Success mengapus data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal menghapus data silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Save Kirim SMS
	if($aksi=="savebalassms")
	{
		if(!$oto['add']) { echo $error['add']; } else 
		{
				$id	    	= $_POST['id'];
				$pesan	    = desc($_POST['pesan']);
				$msisdn 	= desc($_POST['to']);
				$tanggal	= $_POST['tanggal'];

				$sql	= "select max(id) as idbaru from $nama_tabel1";
				$query	= sql($sql);
				$idbaru	= sql_result($query,0,idbaru) + 1;
			
				$perintah 	= "insert into $nama_tabel1 (`id`,`msisdn`,`pesan`,`create_date`,`create_userid`) values ('$idbaru','$msisdn','$pesan','$date','$cuserid')";
				$hasil 		= sql($perintah);
					
				if($hsl)
				{
					$perintah1	= "update $nama_tabel set status='1' where id='$id'";
					$hasil1		= sql($perintah1);
					
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

	//Kirim SMS
	if($aksi=="balassms")
	{
		if(!$oto['add']) { echo $error['add']; } else 
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$tanggal	= $_GET['tanggal'];

			$sql 		= "select msisdn,pesan from $nama_tabel where id='$id'";
			$hsl 		= sql($sql);
			$row 		= sql_fetch_data($hsl);
			$msisdn 	= $row['msisdn'];
			$pesan	 	= $row['pesan'];

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
				<input type="hidden" name="aksi" value="savebalassms"/>
                <input type="hidden" name="id" value="<?php echo $id;?>" />
				<table border="0" class="tabel-cms" width="100%">
					<tr>
						<th colspan="2">Kirim SMS Balasan</th>
					</tr>
					<tr> 
						<td width="176">To</td>
	                    <td align="left">
		                    <input type="text" name="to" id="to" class="validate[required]" value="<?php echo $msisdn;?>" readonly="readonly" />
	                    </td>
					</tr>
                    <tr>
                    <td>Pesan</td>
                        <td><textarea name="pesanmasuk" style="width:400px;height:70px" rows="3" class="textarea" disabled="disabled"><?php echo $pesan;?></textarea></td>
                    </tr>
					<tr>
						<td>Isi SMS Balasan</td>
						<td><textarea style="width:400px;height:70px" rows="3" name="pesan" class="validate[required]" onKeyDown="textCounter(document.menufrm.pesan,document.menufrm.inputcount,130);" onKeyUp="textCounter(document.menufrm.pesan,document.menufrm.inputcount,130);"></textarea></td>
					</tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td> 
                            Karakter yang tersisa 
                            <input readonly type="text" name="inputcount" size="5" maxlength="4" value="" class="textfield1" />
                            <script language="JavaScript">
                                document.menufrm.inputcount.value = (130 - document.menufrm.pesan.value.length);
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
}
?>