<?php
//Variable halaman ini
$nama_tabel		= "tbl_smsc_smsautorespon";
$judul_per_hlm 	= 10;
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
			$mainmenu[] = array("Lihat SMS Auto Respon","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah SMS Auto Respon","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[]       = array("isipesan","Pesan","str","text","$data");
			$formcari     = cmsformcari($cari,$pageparam);
			$where        = $formcari[0]['where'];
			$param        = $formcari[0]['param'];

			//Orderring
			$order    = getorder("id","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];

			$tot = sql_get_var("select count(*) as jml from $nama_tabel where jenis='respon' $where $parorder");
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select id,isipesan,published from $nama_tabel  where jenis='respon' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i	 = 1;
			$no  = (($hlm - 1) * $judul_per_hlm) + 1;

			echo "<table border=0 class='tabel-cms' width=100% cellpadding='1' cellspacing='1'><thead><tr>";
			echo "<th width=10%>Nomor</th>";
			echo "<th width=50%>Isi Pesan</th>";
			echo "<th width=10%>Status</th>";
			echo "<th width=10% align='center'><b>Action</b></th>";
			echo "</tr></thead>";

			while($row = sql_fetch_data($hsl))
			{
				$id			= $row['id'];
				$isipesan	= $row['isipesan'];
				$published	= $row['published'];
				$jenis	    = $row['jenis'];
				
				if($published=="1") 
					$publish ="Publish";
				else 
					$publish ="Draft";

				echo "<tr class='row$i'>";
				echo "<td valign='top'>$no</td>";
				echo "<td valign='top'>$isipesan</td>";
				echo "<td valign='top'>$publish</td>";
				echo "<td>";
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&id=$id&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&id=$id&hlm=$hlm");

				cmsaction($acc);
				unset($acc);

				echo "</td></tr>";

				$i %= 2;
				$i++;
				$no++;
				$ord++;
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
			$sql = "delete from $nama_tabel where id='$id' and jenis='respon'";
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
	if ($aksi == "publish") 
	{
		//Buat Toolbar atas
		if(!$oto['edit']) { echo $error['edit']; } else 
		{
					
			$perintah 	= "select published from $nama_tabel WHERE id='$id' and jenis='respon'";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);
			
			if($data['published']=="0") 
				$status = 1;
			else 
				$status	= 0;
				
			$perintah 	= "update $nama_tabel SET `published`='$status' WHERE id='$id' and jenis='respon'";
			$hasil 		= sql($perintah);
		
			if($hasil)
			{
				$msg = base64_encode("Success merubah data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah data silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//Save Data
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; } else 
		{
			$waktu	 				= $_POST['waktu'];
			$isipesan	        	= cleaninsert($_POST['pesan']);
			
			$new        			= newid("id",$nama_tabel);

			$sql = "INSERT INTO $nama_tabel (id,create_date,create_userid,isipesan,jenis) 
					VALUES ('$new','$date','$cuserid','$isipesan','respon')";
			$hsl = sql($sql);

			if($hsl)
			{
				$msg = base64_encode("Success menambah data baru dengan id $new");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal menambah data silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Tambah Data
	if($aksi=="tambah")
	{
		if(!$oto['add']) { echo $error['add']; } else 
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			?>
            <script>
				$(function(){
					$("#menufrm").validationEngine()
					$( "#waktu" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true,
						  timeFormat: "HH:mm"
						});
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
				<input type="hidden" name="aksi" value="savetambah"/>
				<table border="0" class="tabel-cms" width="100%">
					<tr>
						<th colspan="2">Tambah SMS Auto Respon</th>
					</tr>
					<tr>
						<td>Isi SMS</td>
						<td><textarea style="width:400px;height:70px" rows="3" name="pesan" class="validate[required]" onKeyDown="textCounter(document.menufrm.pesan,document.menufrm.inputcount,130);" onKeyUp="textCounter(document.menufrm.pesan,document.menufrm.inputcount,130);"><?php echo $isipesan?></textarea></td>
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
							<input type="submit" name="Submit" value="Simpan" />
							<input type="button" onclick="javascript:history.back();" value="Batal">
						</td>
					</tr>
				</table>
			</form>
            <?php
		}
	}


	//Save Data Edit
	if($aksi=="saveedit")
	{
		if(!$oto['edit']) { echo $error['edit']; } else 
		{
			$id			= $_POST['id'];
			$isipesan	= $_POST['pesan'];

			$sql = "update $nama_tabel set update_date='$date',update_userid='$cuserid',
				isipesan='$isipesan' where id='$id' and jenis='respon'";
			$hsl = sql($sql);
			if($hsl)
			{
				$msg = base64_encode("Success merubah data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah data silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Edit Data
	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; } else 
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			$sql = "select isipesan from $nama_tabel  where id='$id' and jenis='respon'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$isipesan	= $row['isipesan'];
			
			?>
            <script>
				$(function(){
					$("#menufrm").validationEngine()
					$("#waktu").datepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true
					});
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
				<input type="hidden" name="aksi" value="saveedit"/>
				<input type="hidden" name="id" value="<?php echo $id?>"/>
				<table border="0" class="tabel-cms" width="100%">
					<tr>
						<th colspan="2">Edit SMS Auto Respon</th>
					</tr>
					<tr>
						<td>Isi SMS</td>
						<td><textarea style="width:400px;height:70px" rows="3" name="pesan" class="validate[required]" onKeyDown="textCounter(document.menufrm.pesan,document.menufrm.inputcount,130);" onKeyUp="textCounter(document.menufrm.pesan,document.menufrm.inputcount,130);"><?php echo $isipesan?></textarea></td>
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
							<input type="submit" name="Submit" value="Simpan" />
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