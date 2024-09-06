<?php
//Variable halaman ini
$nama_tabel		= "tbl_wablast";
$nama_tabel1	= "tbl_wa";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 1080;
$gambarl_maxh = 1080;


//Variable Umum
if(isset($_POST['blastid'])) $blastid = $_POST['blastid'];
 else $blastid = $_GET['blastid'];


if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; } else
		{
			$mainmenu[] = array("Lihat Blast","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Blast","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Blast Name","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];

			//Orderring
			$order = getorder("blastid","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];

			$sql = "select count(*) as jml from $nama_tabel where 1  $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select blastid,judul,pesan,create_date,senddate from $nama_tabel where 1  $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=blastid\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=50%><a href=\"$urlorder&order=judul\" title=\"Urutkan\">Blast Name</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=senddate\" title=\"Urutkan\">Send Date</a></th>\n");
			print("<th width=15%>Subcriber</th>\n");
			print("<th width=5%>Terkirim</th>\n");
			print("<th width=5%>Pending</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$blastid = $row['blastid'];
				$judul = $row['judul'];
				$senddate = $row['senddate'];

				//Count Subcriber
				$subcount = sql_get_var("select count(*) as jml from tbl_wa where blastid='$blastid'");
				$terkirim = sql_get_var("select count(*) as jml from tbl_wa where blastid='$blastid' and status='1'");
				$pending = sql_get_var("select count(*) as jml from tbl_wa where blastid='$blastid' and status='0'");

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top>&nbsp;<b>$blastid</b></td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=detail&blastid=$blastid&hlm=$hlm\">$judul</a></b></td>\n
					<td  valign=top >$senddate</td>
					<td  valign=top align=center><a href=\"$alamat&aksi=subcriber&blastid=$blastid&hlm=$hlm\">$subcount</a></td>
					<td  valign=top >$terkirim</td>
					<td  valign=top >$pending</td>");

				print("<td>");

				$acc[] = array("Subcriber","detail","$alamat&aksi=subcriber&blastid=$blastid&hlm=$hlm");
				$acc[] = array("Send Testing","mail","$alamat&aksi=testing&blastid=$blastid&hlm=$hlm");
				$acc[] = array("Edit","edit","$alamat&aksi=edit&blastid=$blastid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&blastid=$blastid&hlm=$hlm");

				cmsaction($acc);
				unset($acc);

				print("</td></tr>");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);


		}
	} //EndView




	if($aksi=="subcriber")
	{
		if(!$oto['view']) { echo $error['view']; } else
		{
			$mainmenu[] = array("Lihat Blast","back","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Penerima","lihat","$alamat&aksi=subcriber&blastid=$blastid");
			$mainmenu[] = array("Pilih Penerima","tambah","$alamat&aksi=tambahsubcriber&blastid=$blastid");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("userphonegsm","Email","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param']."&blastid=$blastid";

			//Orderring
			$order = getorder("status","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];


			$sql = "select count(*) as jml from tbl_wa where blastid='$blastid' $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select customerid,userfullname,userphonegsm,status,pesan,tanggal,terkirim from tbl_wa where blastid='$blastid' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=25%><a href=\"$urlorder&blastid=$blastid&order=userfullname\" title=\"Urutkan\">Name</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&blastid=$blastid&order=userphonegsm\" title=\"Urutkan\">Handphone</a></th>\n");
			print("<th width=40%><a href=\"$urlorder&blastid=$blastid&order=pesan\" title=\"Urutkan\">Pesan</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&blastid=$blastid&order=senddate\" title=\"Urutkan\">Terkirim</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&blastid=$blastid&order=state\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$customerid = $row['customerid'];
				$userfullname = $row['userfullname'];
				$userphonegsm = $row['userphonegsm'];
				$status = $row['status'];
				$update_date = $row['update_date'];
				$terkirim = $row['terkirim'];
				$pesan = $row['pesan'];
				$state = $row['state'];
				$open = $row['open'];
				$click = $row['click'];

				if(($status == 1) and ($bounce==0))
					$ket	= "<span class=\"label label-success\">Terkirim</span> <br> $update_date";
				else if((($status==1) and ($bounce!=0)) or (($status==2) and ($bounce!=0)))
				{
					if($state!='0')
						$ket	= "<span class=\"label label-danger\">$state</span> <br> $update_date";
					else
						$ket	= "<span class=\"label label-danger\">Bounce</span> <br> $update_date";
				}
				else
					$ket ="<span class=\"label label-warning\">Belum Dikirim</span>";

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><b>$userfullname</b></td>\n
					<td  valign=top >$userphonegsm</td>
					<td  valign=top >$pesan</td>
					<td  valign=top >$terkirim</td>
					<td  valign=top align=center>$ket</td>");

				print("<td>");

				$acc[] = array("Hapus","delete","$alamat&aksi=hapussubcriber&blastid=$blastid&customerid=$customerid&hlm=$hlm");

				cmsaction($acc);
				unset($acc);

				print("</td></tr>");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);


		}
	} //EndView

	
	//Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; } else
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			$sql = "select blastid,judul,pesan,senddate,gambar from $nama_tabel  where blastid='$blastid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$judul		= $row['judul'];
			$pesan		= $row['pesan'];
			$gambar 	= $row['gambar'];
			$senddate 	= ($row['senddate']);
			
			if(!empty($gambar)) $gambar = "<img src=\"../gambar/wablast/$gambar\" alt=\"\" />"; else $gambar = "Masih kosong";

			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="blastid" value="<?php echo $blastid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
				<tr>
					<td valign="top" width="20%" class="tdinfo">Blast Name</td>
					<td align="left"><?php echo $judul?></td>
				</tr>
                <tr>
					<td valign="top" width="20%" class="tdinfo">Tanggal Kirim</td>
					<td align="left"><?php echo $senddate?></td>
				</tr>
              
                <tr>
					<td class="tdinfo">Subject</td>
					<td><?php echo $judul?></td>
				</tr>
                <tr>
					<td class="tdinfo">Plain Blast</td>
					<td><?php echo $pesan?></td>
				</tr>
                 <tr> 
					<td class="tdinfo" >Gambar</td>
					<td><?php echo $gambar?>
					</td>
				</tr>
               
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=edit&blastid=$blastid"?>'" value="Ubah Data">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	//Hapus
	if($aksi=="hapus")
	{

		if(!$oto['delete']) { echo $error['delete']; } else
		{
			$perintah1= sql("delete from $nama_tabel1 where blastid='$blastid'");
			if($perintah1)
			{
				$perintah = "delete from $nama_tabel where blastid='$blastid'";
				$hasil = sql($perintah);
				if($hasil)
				{
					$msg = base64_encode("Success mengapus menu dengan Data dengan ID $blastid");
					header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
					exit();
				}
				else
					$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
					header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
					exit();
				}
			else
			{
				$error = base64_encode("Data subscriber tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="hapussubcriber")
	{

		if(!$oto['delete']) { echo $error['delete']; } else
		{

			$customerid = $_GET['customerid'];
			$perintah = "delete from tbl_wab where blastid='$blastid' and customerid='$customerid'";
			$hasil = sql($perintah);
			if($hasil)
			{
				$msg = base64_encode("Success mengapus Data dengan ID $userid");
				header("location: $alamat&aksi=subcriber&blastid=$blastid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=subcriber&blastid=$blastid&hlm=$hlm&error=$error");
				exit();
			}
	}


	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; } else
		{
			$judul = cleaninsert($_POST['judul']);
			$pesan = $_POST['pesan'];
			$tags = cleaninsert($_POST['tags']);
			$subaccount = $_POST['subaccount'];
			$sender = $_POST['sender'];
			$sendername = cleaninsert($_POST['sendername']);
			$senddate = $_POST['senddate'];
			$pilihan = $_POST['pilihan'];
			$secid = $_POST['secid'];
			$voucherid = $_POST['voucherid'];

			$new = newid("blastid",$nama_tabel);

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");

			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);

				$namagambarl = "$kanal-$alias-$new-l.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);

				if($gambarl){
					$fgambar = ",gambar";
					$vgambar = ",'$namagambarl'";
				}
			}

			$perintah = "insert into $nama_tabel(blastid,judul,voucherid,pesan,senddate,create_date,create_userid $fgambar)
						values ('$new','$judul','$voucherid','$pesan','$senddate','$date','$cuserid' $vgambar)";
			$hasil = sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil ditambahkan Data baru");
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

	//Tambah
	if($aksi=="tambah")
	{
		if(!$oto['add']) { echo $error['add']; } else
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);


			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script type="text/javascript" src="./template/js/jquery-ui-timepicker-addon.js"></script>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
					$( "#tanggal" ).datetimepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});

				});
				$(function() {
					$( "#tanggal2" ).datepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  changeMonth: true,
      				  changeYear: true,
					  yearRange: '1970:2010'
					});

				});
				$(function() {
					$( "#tanggal1" ).datepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  changeMonth: true,
      				  changeYear: true,
					  yearRange: '1970:2010'
					});

				});
				function cek(data)
				{
					if(data==1)
					{
						$(".newsletter").hide();
						$(".newslettertemplate").hide();
					}
					else if (data==2)
					{
						$(".newsletter").show("fast");
						$(".newslettertemplate").hide();
					}
					else if (data==3)
					{
						$(".newslettertemplate").show("fast");
						$(".newsletter").hide();
					}
					else
					{
						$(".newslettertemplate").hide();
						$(".newsletter").hide();
					}
				};
				function ceksub(data)
				{
					if(data == "group")
					{
						$(".bygroup").show("fast");
						$(".bymember").hide();
					}
					else if(data == "member")
					{
						$(".bymember").show("fast");
						$(".bygroup").hide();
					}
					else
					{
						$(".bygroup").hide();
						$(".bymember").hide();
					}
				}
			</script>
            	
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data Blast</th>
				</tr>
				<tr>
					<td width="15%">Blast Name</td>
					<td ><input name="judul" type="text" size="70" value="<?php echo $judul;?>" id="judul" class="validate[required]" /></td>
				</tr>
           
                <tr>
					<td width="15%">Send Date</td>
					<td ><input name="senddate" type="text" size="70" value="<?php echo $senddate;?>" id="tanggal" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td width="15%">Voucher</td>
					<td>
                    	<select name="voucherid" id="voucherid">
                        	<option value="">Pilih Voucher</option>
                        <?php
							$perintah = "select id,nama from tbl_voucher where 1 order by create_date desc";
							$hasil=sql($perintah);
							while($data=sql_fetch_data($hasil))
							{
								echo"<option value=$data[id]>$data[nama]</option>";
							}
                        ?>
                        </select>
                    </td>
				</tr>
               
                 <tr>
					<td width="15%">Catatan</td>
					<td >Untuk mengirimkan newseletter dengan data pelanggan atau voucher silahkan sematkan --userfullname-- di dalam pesan untuk Nama lengkap, --userphonegsm-- untuk
                    email dan --voucher-- untuk kode voucher</td>
				</tr>
              
                <tr>
					<td >HTML Blast</td>
					<td ><textarea name="pesan" cols="70" rows="10" id="pesan" ><?php echo $pesan;?></textarea></td>
				</tr>
                  <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /></td>
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

	//SaveTambahMenu
	if($aksi=="saveedit")
	{

		if(!$oto['edit']) { echo $error['edit']; } else
		{
			$blastid = $_POST['blastid'];
			$judul = cleaninsert($_POST['judul']);
			$judul = cleaninsert($_POST['judul']);
			$plainmail = addslashes($_POST['plainmail']);
			$pesan = addslashes($_POST['pesan']);
			$tags = cleaninsert($_POST['tags']);
			$subaccount = $_POST['subaccount'];
			$sender = $_POST['sender'];
			$sendername = cleaninsert($_POST['sendername']);
			$senddate = $_POST['senddate'];
			$voucherid = $_POST['voucherid'];

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");

			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);

				$namagambarl = "$kanal-$blastid-l.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);

				if($gambarl){
					$vgambar = ",gambar='$namagambarl'";
				}
			}

			$perintah = "update $nama_tabel set judul='$judul', voucherid='$voucherid',pesan='$pesan',senddate='$senddate',update_date='$date',update_userid='$cuserid' $vgambar where blastid='$blastid'";
			$hasil = sql($perintah);
			
			if($hasil)
			{
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
	//EditMenu
	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; } else
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			$sql = "select blastid,judul,pesan,judul,voucherid,senddate from $nama_tabel  where blastid='$blastid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$judul		= $row['judul'];
			$judul		= $row['judul'];
			$pesan		= $row['pesan'];
			$senddate		= $row['senddate'];
			$tags			= $row['tags'];
			$subaccount		= $row['subaccount'];
			$sender			= $row['sender'];
			$sendername		= $row['sendername'];
			$voucherid = $row['voucherid'];


			?>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
					$( "#tanggal" ).datetimepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});

				});
			</script>
            <script type="text/javascript" src="./template/js/jquery-ui-timepicker-addon.js"></script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="blastid" value="<?php echo $blastid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr>
					<td width="15%">Blast Name</td>
					<td ><input name="judul" type="text" size="70" value="<?php echo $judul?>" id="judul" class="validate[required]" /></td>
				</tr>
            
                <tr>
					<td width="15%">Send Date</td>
					<td ><input name="senddate" type="text" size="70" value="<?php echo $senddate?>" id="tanggal" class="validate[required]" /></td>
				</tr>
                  <tr> 
					<td width="15%">Voucher</td>
					<td>
                    	<select name="voucherid" id="voucherid">
                        	<option value="">Pilih Voucher</option>
                        <?php
							$perintah = "select id,nama from tbl_voucher where 1 order by create_date desc";
							$hasil=sql($perintah);
							while($data=sql_fetch_data($hasil))
							{
								echo"<option value='$data[id]'"; if($voucherid==$data['id']){ echo " selected='selected' "; } echo">$data[nama]</option>";
							}
                        ?>
                        </select>
                    </td>
				</tr>
             
                <tr>
					<td width="15%">Catatan</td>
					<td >Untuk mengirimkan newseletter dengan data pelanggan atau voucher silahkan sematkan --userfullname-- di dalam email untuk Nama lengkap, --userphonegsm-- untuk
                    email dan --voucher-- untuk kode voucher</td>
				</tr>

                <tr>
					<td >HTML Blast</td>
					<td ><textarea name="pesan" cols="70" rows="10" id="pesan"><?php echo $pesan?></textarea></td>
				</tr>
                  <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /></td>
				</tr>

				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:history.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	//SaveTambah
	if($aksi=="savetambahsubcriber")
	{
		if(!$oto['add']) { echo $error['add']; } else
		{
			$pilihan = $_POST['pilihan'];
			$secid = $_POST['secid'];

			$namagroup = sql_get_var("select nama from tbl_customer_sec where secid='$secid'");
			$blast = sql_get_var_row("select senddate,pesan,voucherid,gambar from tbl_wablast where blastid='$blastid'");
			$senddate = $blast['senddate'];
			$voucherid = $blast['voucherid'];
			$pesan1 = $blast['pesan'];
			$gambar = $blast['gambar'];
						
			if($secid!=0)
			{
				$sql	= "SELECT customerid,userfullname,userphonegsm FROM  `tbl_customer` where secid = '$secid' and status='0'";
				$query	= sql($sql);
				while($row = sql_fetch_data($query))
				{
					$customerid			= $row['customerid'];
					$userfullname	= ucwords($row['userfullname']);
					$userphonegsm		= $row['userphonegsm'];

					$new = newid("id","tbl_wa");
					
					$voucher = sql_get_var("select kodevoucher from tbl_voucher_kode where voucherid='$voucherid'");
					
				
					$pesan = str_replace("--userfullname--",$userfullname,$pesan1);
					$pesan = str_replace("--userphonegsm--",$userphonegsm,$pesan);
					$pesan = str_replace("--useraddress--",$useraddress,$pesan);
					$pesan = str_replace("--voucher--",$voucher,$pesan);
					
					$userphonegsm = trim($userphonegsm);
					$userphonegsm = str_replace(" ","",$userphonegsm);
					$userphonegsm = str_replace("-","",$userphonegsm);
					$userphonegsm = str_replace("+","",$userphonegsm);
					
					if(substr($userphonegsm,0,1)=="0"){ $userphonegsm = "62".substr($userphonegsm,1,12); }
					
					$html = str_replace("<br>","\r\n",$pesan);
					$html = str_replace("\r\n","\r\n",$html);
					$html = str_replace("</strong>","*",$html);
					$html = str_replace("<strong>","*",$html);
					$html = str_replace("<b>","*",$html);
					$html = str_replace("</b>","*",$html);
					
					$perintah = "insert into tbl_wa (id,customerid,userfullname,userphonegsm,pesan,blastid,create_date,tanggal,create_userid,gambar $fgambar)
								values ('$new','$customerid','$userfullname','$userphonegsm','$pesan','$blastid','$date','$senddate','$cuserid','$gambar' $vgambar)";
					$hasil = sql($perintah);
					
					unset($pesan);
				}
				$msg = base64_encode("Group $namagroup berhasil ditambahkan sebagai subscriber newsletter.");
				header("location: $alamat&aksi=subcriber&blastid=$blastid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan. Tidak ada data group yang dipilih. Silahkan periksa kembali.");
				header("location: $alamat&aksi=subcriber&blastid=$blastid&hlm=$hlm&error=$error");
				exit();
			}
			

			
		}
	}

	//Tambah
	if($aksi=="tambahsubcriber")
	{
		if(!$oto['add']) { echo $error['add']; } else
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=subcriber&blastid=$blastid");
			mainaction($mainmenu,$param);

			$sql	= "select id, smtphost, smtpport, smtpuser, apikey from tbl_konfigurasi_newsletter";
			$query	= sql($sql);
			$row = sql_fetch_data($query);

			$smtphost = $row['smtphost'];
			$smtpport = $row['smtpport'];
			$smtpuser = $row['smtpuser'];
			$apikey = $row['apikey'];
			$id = $row['id'];

			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script type="text/javascript" src="./template/js/jquery-ui-timepicker-addon.js"></script>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
					$( "#tanggal" ).datepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  changeMonth: true,
      				  changeYear: true,
					  yearRange: '1970:2010'
					});

				});
				$(function() {
					$( "#tanggal1" ).datepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  changeMonth: true,
      				  changeYear: true,
					  yearRange: '1970:2010'
					});

				});

				function cek(data)
				{
					if(data == "group")
					{
						$(".bygroup").show("fast");
						$(".bymember").hide();
					}
					else if(data == "member")
					{
						$(".bymember").show("fast");
						$(".bygroup").hide();
					}
					else
					{
						$(".bygroup").hide();
						$(".bymember").hide();
					}
				}

			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahsubcriber">
            <input type="hidden" name="blastid" value="<?php echo $blastid;?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
              
				<tr class="bygroup" >
					<td width="15%">Group</td>
					<td ><select name="secid">
                    	<option value="">Pilih Group</option>
                        <?php
							$sql = "select secid, nama from tbl_customer_sec";
							$qry = sql($sql);
							while($row = sql_fetch_data($qry))
							{
								$secid = $row['secid'];
								$nama	 = $row['nama'];

								echo "<option value='$secid'>$nama</option>";
							}
					
						?>
                    </select></td>
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

	if($aksi=="testing")
	{
		if(!$oto['add']) { echo $error['add']; } else
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			?>
            <form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetesting">
            <input type="hidden" name="blastid" value="<?php echo $blastid;?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Testing Blast</th>
				</tr>
                <tr>
                	<td>Nama Penerima</td>
                    <td><input type="text" name="nama" id="nama" class="validate[required]" /></td>
                </tr>
                <tr>
                	<td>Nomor Handphone</td>
                    <td><input type="text" name="userphonegsm" id="userphonegsm" class="validate[required]" /></td>
                </tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Testing Kirim" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            <?php
		}
	}
	if($aksi=="savetesting")
	{
		if(!$oto['add']) { echo $error['add']; } else
		{

			$userphonegsm = $_POST['userphonegsm'];
			$blastid = $_POST['blastid'];
			$penerima= $_POST['nama'];

	
			$id = $row['id'];

			$sql2 = "select judul,pesan,gambar from tbl_wablast where blastid='$blastid'";
			$hsl2 = sql($sql2);
			$dt = sql_fetch_data($hsl2);

			$judul = $dt['judul'];
			$pesan = $dt['pesan'];
			$gambar = $dt['gambar'];
			
			$voucher = "VOUCHER001SAMPLE";

			$tags = explode(",",$tags);

			$judul = str_replace("--userfullname--",$penerima,$judul);
			$judul = str_replace("--userphonegsm--",$userphonegsm,$judul);

			$plainmail = str_replace("--userfullname--",$penerima,$plainmail);
			$plainmail = str_replace("--userphonegsm--",$userphonegsm,$plainmail);
			$plainmail = str_replace("--useraddress--",$useraddress,$plainmail);
			$plainmail = str_replace("--voucher--",$voucher,$plainmail);

			$pesan = str_replace("--userfullname--",$penerima,$pesan);
			$pesan = str_replace("--userphonegsm--",$userphonegsm,$pesan);
			$pesan = str_replace("--useraddress--",$useraddress,$pesan);
			$pesan = str_replace("--voucher--",$voucher,$pesan);


			
			
			$userphonegsm = trim($userphonegsm);
			$userphonegsm = str_replace(" ","",$userphonegsm);
			$userphonegsm = str_replace("-","",$userphonegsm);
			$userphonegsm = str_replace("+","",$userphonegsm);
			
			if(substr($userphonegsm,0,1)=="0"){ $userphonegsm = "62".substr($userphonegsm,1,12); }
			
			$html = str_replace("<br>","\r\n",$pesan);
			$html = str_replace("\r\n","\r\n",$html);
			$html = str_replace("</strong>","*",$html);
			$html = str_replace("<strong>","*",$html);
			$html = str_replace("<b>","*",$html);
			$html = str_replace("</b>","*",$html);
			
			$token = 'cflmcESp58g8Y4o8AGgpVRdgfpWeE8fDJZwLUrfUqFhezQNG3b';
			$phone = $userphonegsm;
			$message = $html;
			
			
			if(!empty($gambar))
			{
				$url = 'http://wa.adisumaryadi.net:8003/api/sendFile';

				$photo  = "@$lokasiweb/gambar/wablast/$gambar;type=image/jpeg;filename=gambar.jpeg";
				
				
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($curl, CURLOPT_TIMEOUT,30);
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, array(
					'token'    => $token,
					'phone'     => $phone,
					'body'   => $photo,
					'caption'   => $html,
					'filename'   => "gambar.jpg",
				));
				$response = curl_exec($curl);
				
				if(preg_match("/error/i",$response))
				{
					$error = base64_encode("Test Gagal dikirimkan, kemungkinan WA belum terhubung ke WA Gateway");
					header("location: $alamat&aksi=view&blastid=$blastid&hlm=$hlm&error=$error");
					exit();
				}

			
			}
			else
			{
				$url = 'http://wa.adisumaryadi.net:8003/api/sendMessage';
				
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($curl, CURLOPT_TIMEOUT,30);
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, array(
					'token'    => $token,
					'phone'     => $phone,
					'body'   => $message,
				));
				$response = curl_exec($curl);
				curl_close($curl);
				
				if(preg_match("/error/i",$response))
				{
					$error = base64_encode("Test Gagal dikirimkan, kemungkinan WA belum terhubung ke WA Gateway");
					header("location: $alamat&aksi=view&blastid=$blastid&hlm=$hlm&error=$error");
					exit();
				}

			}

			if($response)
			{
				$msg = base64_encode("Test Berhasil dikirimkan");
				header("location: $alamat&aksi=view&blastid=$blastid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Test Gagal dikirimkan");
				header("location: $alamat&aksi=view&blastid=$blastid&hlm=$hlm&error=$error");
				exit();
			
			
			}
		}
	}
}

?>