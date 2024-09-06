<?php
ini_set("display_errors","On");
//Variable halaman ini
$nama_tabel		= "tbl_newsletter";
$nama_tabel1		= "tbl_newsletter_subcriber";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;


//Variable Umum
if(isset($_POST['newsletterid'])) $newsletterid = $_POST['newsletterid'];
 else $newsletterid = $_GET['newsletterid'];


if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; } else
		{
			$mainmenu[] = array("Lihat Newsletter","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Newsletter","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Newsletter Name","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];

			//Orderring
			$order = getorder("newsletterid","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];

			$sql = "select count(*) as jml from $nama_tabel where 1 and jenis!='1' $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select newsletterid,newslettername,create_date,senddate from $nama_tabel where 1 and jenis!='1' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=newsletterid\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=50%><a href=\"$urlorder&order=newslettername\" title=\"Urutkan\">Newsletter Name</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=senddate\" title=\"Urutkan\">Send Date</a></th>\n");
			print("<th width=15%>Subcriber</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$newsletterid = $row['newsletterid'];
				$newslettername = $row['newslettername'];
				$senddate = $row['senddate'];

				//Count Subcriber
				$subcount = sql_get_var("select count(*) as jml from tbl_newsletter_subcriber where newsletterid='$newsletterid'");

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top>&nbsp;<b>$newsletterid</b></td>
					<td  valign=top class=judul><b><a href=\"$alamat&aksi=detail&newsletterid=$newsletterid&hlm=$hlm\">$newslettername</a></b></td>\n
					<td  valign=top >$senddate</td>
					<td  valign=top align=center><a href=\"$alamat&aksi=subcriber&newsletterid=$newsletterid&hlm=$hlm\">$subcount</a></td>");

				print("<td>");

				$acc[] = array("Subcriber","detail","$alamat&aksi=subcriber&newsletterid=$newsletterid&hlm=$hlm");
				$acc[] = array("Send Testing","email","$alamat&aksi=testing&newsletterid=$newsletterid&hlm=$hlm");
				$acc[] = array("Edit","edit","$alamat&aksi=edit&newsletterid=$newsletterid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&newsletterid=$newsletterid&hlm=$hlm");

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

	if($aksi=="pilihtemplate")
	{
		if(!$oto['view']) { echo $error['view']; } else
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari1[] = array("templatename","Template Name","str","text","$data");

			$formcari = cmsformcari($cari1,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];

			//Orderring
			$order = getorder("templateid","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];


			$sql = "select count(*) as jml from tbl_newsletter_template where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select templateid,templatename,create_date,image from tbl_newsletter_template  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");

			while ($row = sql_fetch_data($hsl))
			{
				$templateid	= $row['templateid'];
				$templatename		= $row['templatename'];
				$tanggal= tanggal($row['create_date']);
				$image= $row['image'];

				if(empty($image)) $image = "../gambar/nopict1.gif";
				else $image = "../gambar/ntemplate/$image";

				echo "
				<div class=\"col-md-4\">
					<div class=\"imgprev\">
						<a href=\"$alamat&aksi=preview&templateid=$templateid&hlm=$hlm\">";
							echo "<img src=\"$image\" alt=\"\" border=\"0\" />";
				echo "</a></div>";
				echo"<br />
					<span>$templatename</span><br />";
				echo "<a class=\"btn\" href=\"$alamat&aksi=preview&templateid=$templateid&hlm=$hlm\"> Preview</a>";
				echo "<a class=\"btn\" href=\"$alamat&aksi=tambah&pilihtemplateid=$templateid\"> Select</a>";

				echo"</div>";



				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);


		}
	} //EndView


	if($aksi=="subcriber")
	{
		if(!$oto['view']) { echo $error['view']; } else
		{
			$mainmenu[] = array("Lihat Newsletter","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Pilih Subcriber","tambah","$alamat&aksi=tambahsubcriber&newsletterid=$newsletterid");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("useremail","Email","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param']."&newsletterid=$newsletterid";

			//Orderring
			$order = getorder("status","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];


			$sql = "select count(*) as jml from tbl_newsletter_subcriber where newsletterid='$newsletterid' $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select userid,userfullname,useremail,status,create_date,update_date,senddate,bounce,state,open,click from tbl_newsletter_subcriber where newsletterid='$newsletterid' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&newsletterid=$newsletterid&order=userid\" title=\"Urutkan\">Subcribers ID</a></th>\n");
			print("<th width=25%><a href=\"$urlorder&newsletterid=$newsletterid&order=userfullname\" title=\"Urutkan\">Subcribers Name</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&newsletterid=$newsletterid&order=useremail\" title=\"Urutkan\">Email</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&newsletterid=$newsletterid&order=senddate\" title=\"Urutkan\">Tanggal Kirim</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&newsletterid=$newsletterid&order=state\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&newsletterid=$newsletterid&order=open\" title=\"Urutkan\">Open</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&newsletterid=$newsletterid&order=click\" title=\"Urutkan\">Click</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$userid = $row['userid'];
				$userfullname = $row['userfullname'];
				$useremail = $row['useremail'];
				$status = $row['status'];
				$update_date = $row['update_date'];
				$sendate = $row['senddate'];
				$bounce = $row['bounce'];
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
					<td width=5% height=20 valign=top>&nbsp;<b>$userid</b></td>
					<td  valign=top class=judul><b>$userfullname</b></td>\n
					<td  valign=top >$useremail</td>
					<td  valign=top >$sendate</td>
					<td  valign=top >$ket</td>
					<td  valign=top align=center>$open</td>
					<td  valign=top align=center>$click</td>");

				print("<td>");

				$acc[] = array("Hapus","delete","$alamat&aksi=hapussubcriber&newsletterid=$newsletterid&userid=$userid&hlm=$hlm");

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

	if($aksi=="preview")
	{
		if(!$oto['view']) { echo $error['view']; } else
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");

			$templateid = $_GET['templateid'];

			$sql = "select templateid,subject,plainmail,htmlmail,templatename from tbl_newsletter_template  where templateid='$templateid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$templatename		= $row['templatename'];
			$subject		= $row['subject'];
			$plainmail		= stripslashes($row['plainmail']);
			$htmlmail		= stripslashes($row['htmlmail']);

			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="templateid" value="<?php echo $templateid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
				<tr>
					<td valign="top" width="20%" class="tdinfo">Template Name</td>
					<td align="left"><?php echo $templatename?></td>
				</tr>
                <tr>
					<td class="tdinfo">Subject</td>
					<td><?php echo $subject?></td>
				</tr>
                <tr>
					<td class="tdinfo">Plain Newsletter</td>
					<td><?php echo $plainmail?></td>
				</tr>
                <tr>
					<td class="tdinfo">HTMl Newsletter</td>
					<td><iframe width="100%" height="700" style="border:1px solid #CCCCCC" src="<?php echo "komponen/newsletter/preview.ntemplate.php";?>"></iframe></td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=tambah&pilihtemplateid=$templateid"?>'" value="Select">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}

	}

	//Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; } else
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			$sql = "select newsletterid,subject,plainmail,htmlmail,newslettername,tags, subaccount, sender, sendername from $nama_tabel  where newsletterid='$newsletterid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$newslettername		= $row['newslettername'];
			$subject		= $row['subject'];
			$plainmail		= stripslashes($row['plainmail']);
			$htmlmail		= stripslashes($row['htmlmail']);
			$tags			= $row['tags'];
			$subaccount		= $row['subaccount'];
			$sender			= $row['sender'];
			$sendername		= $row['sendername'];

			if(!empty($gambar)) $gambar = "<img src=\"../gambar/$kanal/$gambar\" alt=\"\" />"; else $gambar = "Masih kosong";
			if(!empty($gambar1)) $gambar1 = "<img src=\"../gambar/$kanal/$gambar1\" alt=\"\" />"; else $gambar1 = "Masih kosong";

			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="newsletterid" value="<?php echo $newsletterid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
				<tr>
					<td valign="top" width="20%" class="tdinfo">Newsletter Name</td>
					<td align="left"><?php echo $newslettername?></td>
				</tr>
                <tr>
					<td class="tdinfo" >Newsletter Sender Name</td>
					<td ><?php echo $sendername?></td>
				</tr>
                <tr>
					<td class="tdinfo">Subject</td>
					<td><?php echo $subject?></td>
				</tr>
                <tr>
					<td class="tdinfo">Plain Newsletter</td>
					<td><?php echo $plainmail?></td>
				</tr>
                <tr>
					<td class="tdinfo">HTMl Newsletter</td>
					<td><iframe width="100%" height="700" style="border:1px solid #CCCCCC" src="<?php echo "komponen/newsletter/previewhtml.php?newsletterid=$newsletterid";?>"></iframe></td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=edit&newsletterid=$newsletterid"?>'" value="Ubah Data">
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
			$perintah1= sql("delete from $nama_tabel1 where newsletterid='$newsletterid'");
			if($perintah1)
			{
				$perintah = "delete from $nama_tabel where newsletterid='$newsletterid'";
				$hasil = sql($perintah);
				if($hasil)
				{
					$msg = base64_encode("Success mengapus menu dengan Data dengan ID $newsletterid");
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

			$userid = $_GET['userid'];
			$perintah = "delete from tbl_newsletter_subcriber where newsletterid='$newsletterid' and userid='$userid'";
			$hasil = sql($perintah);
			if($hasil)
			{
				$msg = base64_encode("Success mengapus Data dengan ID $userid");
				header("location: $alamat&aksi=subcriber&newsletterid=$newsletterid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=subcriber&newsletterid=$newsletterid&hlm=$hlm&error=$error");
				exit();
			}
	}


	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; } else
		{
			$newslettername = cleaninsert($_POST['newslettername']);
			$subject = cleaninsert($_POST['subject']);
			$plainmail = addslashes($_POST['plainmail']);
			$htmlmail = addslashes($_POST['htmlmail']);
			$tags = cleaninsert($_POST['tags']);
			$subaccount = $_POST['subaccount'];
			$sender = $_POST['sender'];
			$sendername = cleaninsert($_POST['sendername']);
			$senddate = $_POST['senddate'];
			$pilihan = $_POST['pilihan'];
			$groupid = $_POST['groupid'];

			$new = newid("newsletterid",$nama_tabel);

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");

			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$new.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);

				$namagambarl = "$kanal-$alias-$new-l.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);

				if($gambarl){
					$fgambar = ",gambar,gambar1";
					$vgambar = ",'$namagambars','$namagambarl'";
				}
			}

			$perintah = "insert into $nama_tabel(newsletterid,newslettername,subject,plainmail,htmlmail,senddate,sendername,create_date,create_userid)
						values ('$new','$newslettername','$subject','$plainmail','$htmlmail','$senddate','$sendername','$date','$cuserid')";
			$hasil = sql($perintah);

			if($hasil)
			{
				if(!empty($pilihan))
				{
					$namagroup = sql_get_var("select nama from tbl_subcriber_group where groupid='$groupid'");
					if($pilihan=="group")
					{
						if($groupid!=0)
						{
							$sql	= "SELECT userid, userfullname, useremail FROM  `tbl_subcriber` where groupid = '$groupid' and status='0'";
							$query	= sql($sql);
							while($row = sql_fetch_data($query))
							{
								$userid			= $row['userid'];
								$userfullname	= $row['userfullname'];
								$useremail		= $row['useremail'];
		
								$new1 = newid("id","tbl_newsletter_subcriber");
		
								$perintah = "insert into tbl_newsletter_subcriber (id,userid,userfullname,useremail,newsletterid,create_date,senddate,create_userid $fgambar)
											values ('$new1','$userid','$userfullname','$useremail','$new','$date','$senddate','$cuserid' $vgambar)";
								$hasil = sql($perintah);
							}
							$msg = base64_encode("Group $namagroup berhasil ditambahkan sebagai subscriber newsletter.");
							header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
							exit();
						}
						else
						{
							$error = base64_encode("Data tidak dapat dimasukkan. Tidak ada data group yang dipilih. Silahkan periksa kembali.");
							header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
							exit();
						}
					}
					else
					{
						$where="where 1";
						$member_kategori = $_POST['member_kategori'];
						$tanggal= $_POST['tanggal'];
						$tanggal1= $_POST['tanggal1'];
						$propinsiid = $_POST['propinsiid'];
		
						if($member_kategori)
						{
							$jumkategori=count($member_kategori);
							
							for($i=0;$i<$jumkategori;$i++)
							{
								if($member_kategori[$i]=="aktif")
								{
									$where.=" and userActiveStatus='1' and bounce='0'";
								}
								else if($member_kategori[$i]=="tidak aktif")
								{
									$where.=" and userActiveStatus='0' and bounce='0'";
								}
							}
						}
		
						if((!empty($tanggal)) and (!empty($tanggal1)))
						{
							$where.=" and userDOB between '$tanggal' and '$tanggal1'";
						}
						if($propinsiid)
						{
							$where.=" and propinsiid='$propinsiid'";
						}
		
						$sql	= "SELECT memberid, userFullName, userEmail FROM  `tbl_member` $where";
						$query	= sql($sql);
						while($row = sql_fetch_data($query))
						{
							$userid			= $row['memberid'];
							$userfullname	= $row['userFullName'];
							$useremail		= $row['userEmail'];
		
							$new1 = newid("id","tbl_newsletter_subcriber");
		
							$perintah = "insert into tbl_newsletter_subcriber (id,userid,userfullname,useremail,newsletterid,create_date,senddate,create_userid $fgambar)
										values ('$new1','$userid','$userfullname','$useremail','$new','$date','$senddate','$cuserid' $vgambar)";
							$hasil = sql($perintah);
						}
					}
				}
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

			$templateid = $_GET['pilihtemplateid'];

			$sql   = "select templateid,plainmail,htmlmail,templatename from tbl_newsletter_template limit 1";
			$query = sql($sql);
			$row   = sql_fetch_data($query);

			$htmlmail		= stripslashes($row['htmlmail']);

			if($_POST['pilihan'])
				$pilihan = $_POST['pilihan'];
			else
				$pilihan = $_GET['pilihan'];

			if($_POST['newsletterid'])
				$newsletterid = $_POST['newsletterid'];
			else
				$newsletterid = $_GET['newsletterid'];

			if($_POST['newslettertemplateid'])
				$newslettertemplateid = $_POST['newslettertemplateid'];
			else
				$newslettertemplateid = $_GET['newslettertemplateid'];

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
             <form method="post">
            	<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Newsletter</th>
				</tr>
                <tr>
                	<td width="150">Tambah data berdasarkan</td>
                	<td>
                    <select name="pilihan" id="pilihan" onChange="return cek(this.value)">
                    	<option value="">Pilih</option>
                    	<option value="1" <?php if($pilihan==1) echo"selected";?>>New Data</option>
                        <option value="2" <?php if($pilihan==2) echo"selected";?>>Duplicate Newsletter</option>
                        <option value="3" <?php if($pilihan==3) echo"selected";?>>Template Newsletter</option>
                    </select>
                    </td>
                </tr>
                <tr class="newsletter" <?php if($newsletterid){?>style="display:table-row"<?php }else{?>style="display:none"<?php }?>>
                	<td>Duplicate Newsletter From</td>
                	<td>
                    <select name="newsletterid" id="newsletterid">
                    	<option value="">Pilih Newsletter</option>
                    <?php
						$perintah=sql("select newsletterid,newslettername from tbl_newsletter where jenis='0'");
						while($data=sql_fetch_data($perintah))
						{
							if($newsletterid==$data['newsletterid'])
								echo"<option value=$data[newsletterid] selected=\"selected\">$data[newslettername]</option>";
							else
								echo"<option value=$data[newsletterid]>$data[newslettername]</option>";
						}
                    ?>
                    </select>
                    </td>
                </tr>
                <tr class="newslettertemplate" <?php if($newslettertemplateid){?>style="display:table-row"<?php }else{?>style="display:none"<?php }?>>
                	<td>Template Newsletter</td>
                	<td>
                    <select name="newslettertemplateid" id="newslettertemplateid">
                    	<option value="">Pilih Template</option>
                    <?php
						$perintah=sql("select templateid,templatename from tbl_newsletter_template");
						while($data=sql_fetch_data($perintah))
						{
							if($newslettertemplateid==$data['templateid'])
								echo"<option value=$data[templateid] selected=\"selected\">$data[templatename]</option>";
							else
								echo"<option value=$data[templateid]>$data[templatename]</option>";
						}
                    ?>
                    </select>
                    </td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td><input type="submit" value="Tambah Data" /></td>
                </tr>
                </table>
            </form>
            <br clear="all" /><br />
            <?php
				if($pilihan==2)
				{
					$perintah="select newsletterid,newslettername,subject,plainmail,htmlmail,sendername,status,groupid,senddate,sender from tbl_newsletter where newsletterid='$newsletterid'";
					$hasil=sql($perintah);
					$row=sql_fetch_data($hasil);
						$newsletterid = $row['newsletterid'];
						$newslettername = $row['newslettername'];
						$subject = $row['subject'];
						$plainmail = $row['plainmail'];
						$htmlmail = $row['htmlmail'];
						$sendername = $row['sendername'];
						$status = $row['status'];
						$groupid = $row['groupid'];
						$senddate = $row['senddate'];
				}
				else if($pilihan==3)
				{
					$perintah="select templateid,templatename,plainmail,htmlmail from tbl_newsletter_template where templateid='$newslettertemplateid'";
					$hasil=sql($perintah);
					$row=sql_fetch_data($hasil);
						$newsletterid = $row['templateid'];
						$newslettername = $row['templatename'];
						$plainmail = $row['plainmail'];
						$htmlmail = $row['htmlmail'];
				}
            ?>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data Newsletter</th>
				</tr>
				<tr>
					<td width="15%">Newsletter Name</td>
					<td ><input name="newslettername" type="text" size="70" value="<?php echo $newslettername;?>" id="newslettername" class="validate[required]" /></td>
				</tr>
                <tr>
					<td width="15%">Newsletter Sender Name</td>
					<td ><input name="sendername" type="text" size="70" value="<?php echo $sendername;?>" id="sendername" class="validate[required]" /></td>
				</tr>
                <tr>
					<td width="15%">Send Date</td>
					<td ><input name="senddate" type="text" size="70" value="<?php echo $senddate;?>" id="tanggal" class="validate[required]" /></td>
				</tr>
                <tr>
					<td width="15%">Newsletter Subject</td>
					<td ><input name="subject" type="text" size="70" value="<?php echo $subject;?>" id="subject" class="validate[required]" /></td>
				</tr>
                <tr>
					<td >Plain Newsletter</td>
					<td ><textarea name="plainmail" style="width:98%" rows="10" id="plainmail" class="validate[required]"><?php echo $plainmail;?></textarea></td>
				</tr>
                <tr>
					<td >HTML Newsletter</td>
					<td ><textarea name="htmlmail" cols="70" rows="10" id="htmlmail" class="ckeditor validate[required]" ><?php echo $htmlmail;?></textarea></td>
				</tr>
                <tr>
					<th colspan="2">Pilih Subscriber</th>
				</tr>
                 <tr>
                	<td>Tampilkan Data Berdasarkan</td>
                    <td><input type="radio" name="pilihan" value="group" onclick="return ceksub(this.value)" /> Group &nbsp;&nbsp;
                    	<input type="radio" name="pilihan" value="member" onclick="return ceksub(this.value)" /> Member
                    </td>
                </tr>
				<tr class="bygroup" style="display:none">
					<td width="15%">Group</td>
					<td ><select name="groupid">
                    	<option value="">Pilih Group</option>
                        <?php
							$sql = "select groupid, nama from tbl_subcriber_group";
							$qry = sql($sql);
							while($row = sql_fetch_data($qry))
							{
								$groupid = $row['groupid'];
								$nama	 = $row['nama'];

								echo "<option value='$groupid'>$nama</option>";
							}
						?>
                    </select></td>
				</tr>
                <tr class="bymember" style="display:none">
					<td width="15%">Kategori Member</td>
					<td>
                    	<input type="checkbox" name="member_kategori[]" value="aktif" />  Member Aktif&nbsp;&nbsp;
                        <input type="checkbox" name="member_kategori[]" value="tidak aktif" />  Member Tidak Aktif&nbsp;&nbsp;
                    </td>
				</tr>
                <tr class="bymember" style="display:none">
					<td width="15%">Tanggal Lahir</td>
					<td>
                    	<input type="text" name="tanggal1" id="tanggal1" /> sampai <input type="text" name="tanggal2" id="tanggal2" />
                    </td>
				</tr>

                <tr class="bymember" style="display:none">
					<td width="15%">Propinsi</td>
					<td>
                    	<select name="propinsiid" id="propinsiid">
                        	<option value="">Pilih Propinsi</option>
                    	<?php
                        	$perintah="select propinsiid,nama from tbl_propinsi where 1";
							$hasil=sql($perintah);
							while($data=sql_fetch_data($hasil))
							{
								echo"<option value=$data[propinsiid]>$data[nama]</option>";
							}
						?>
                        </select>
                    </td>
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
			$newsletterid = $_POST['newsletterid'];
			$newslettername = cleaninsert($_POST['newslettername']);
			$subject = cleaninsert($_POST['subject']);
			$plainmail = addslashes($_POST['plainmail']);
			$htmlmail = addslashes($_POST['htmlmail']);
			$tags = cleaninsert($_POST['tags']);
			$subaccount = $_POST['subaccount'];
			$sender = $_POST['sender'];
			$sendername = cleaninsert($_POST['sendername']);
			$senddate = $_POST['senddate'];

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");

			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$kanal-$alias-$id.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);

				$namagambarl = "$kanal-$alias-$id-l.$ext";
				$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);

				if($gambarl){
					$vgambar = ",gambar='$namagambars',gambar1='$namagambarl'";
				}
			}

			$perintah = "update $nama_tabel set newslettername='$newslettername', subject='$subject', plainmail='$plainmail', htmlmail='$htmlmail', tags='$tags', subaccount='$subaccount', sender='$sender', sendername='$sendername', senddate='$senddate',update_date='$date',update_userid='$cuserid' $vgambar where newsletterid='$newsletterid'";
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

			$sql = "select newsletterid,subject,plainmail,htmlmail,newslettername,senddate,tags,subaccount,sender,sendername from $nama_tabel  where newsletterid='$newsletterid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$newslettername		= $row['newslettername'];
			$subject		= $row['subject'];
			$plainmail		= stripslashes($row['plainmail']);
			$htmlmail		= stripslashes($row['htmlmail']);
			$senddate		= $row['senddate'];
			$tags			= $row['tags'];
			$subaccount		= $row['subaccount'];
			$sender			= $row['sender'];
			$sendername		= $row['sendername'];

			$sql	= "select id, smtphost, smtpport, smtpuser, apikey from tbl_konfigurasi_newsletter";
			$query	= sql($sql);
			$row = sql_fetch_data($query);

			$smtphost = $row['smtphost'];
			$smtpport = $row['smtpport'];
			$smtpuser = $row['smtpuser'];
			$apikey = $row['apikey'];
			$id = $row['id'];

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
            <script src="librari/ckeditor-market/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="newsletterid" value="<?php echo $newsletterid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr>
					<td width="15%">Newsletter Name</td>
					<td ><input name="newslettername" type="text" size="70" value="<?php echo $newslettername?>" id="newslettername" class="validate[required]" /></td>
				</tr>
                <tr>
					<td width="15%">Newsletter Sender Name</td>
					<td ><input name="sendername" type="text" size="70" value="<?php echo $sendername?>" id="sendername" class="validate[required]" /></td>
				</tr>
                <tr>
					<td width="15%">Send Date</td>
					<td ><input name="senddate" type="text" size="70" value="<?php echo $senddate?>" id="tanggal" class="validate[required]" /></td>
				</tr>
                <tr>
					<td width="15%">Newsletter Subject</td>
					<td ><input name="subject" type="text" size="70" value="<?php echo $subject?>" id="subject" class="validate[required]" /></td>
				</tr>
                <tr>
					<td >Plain Newsletter</td>
					<td ><textarea name="plainmail" style="width:98%" rows="10" id="plainmail" class="validate[required]"><?php echo $plainmail?></textarea></td>
				</tr>
                <tr>
					<td >HTML Newsletter</td>
					<td ><textarea name="htmlmail" cols="70" rows="10" id="htmlmail" class="ckeditor validate[required]" ><?php echo $htmlmail?></textarea></td>
				</tr>
                <tr>
					<td width="15%">Reply To</td>
					<td ><input name="replyto" type="text" size="70" value="<?php echo $replyto?>" id="replyto" class="validate[required]" /></td>
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
			$groupid = $_POST['groupid'];

			$namagroup = sql_get_var("select nama from tbl_subcriber_group where groupid='$groupid'");
			$senddate = sql_get_var("select senddate from tbl_newsletter where newsletterid='$newsletterid'");
			if($pilihan=="group")
			{
				if($groupid!=0)
				{
					$sql	= "SELECT userid, userfullname, useremail FROM  `tbl_subcriber` where groupid = '$groupid' and status='0'";
					$query	= sql($sql);
					while($row = sql_fetch_data($query))
					{
						$userid			= $row['userid'];
						$userfullname	= $row['userfullname'];
						$useremail		= $row['useremail'];

						$new = newid("id","tbl_newsletter_subcriber");

						$perintah = "insert into tbl_newsletter_subcriber (id,userid,userfullname,useremail,newsletterid,create_date,senddate,create_userid $fgambar)
									values ('$new','$userid','$userfullname','$useremail','$newsletterid','$date','$senddate','$cuserid' $vgambar)";
						$hasil = sql($perintah);
					}
					$msg = base64_encode("Group $namagroup berhasil ditambahkan sebagai subscriber newsletter.");
					header("location: $alamat&aksi=subcriber&newsletterid=$newsletterid&hlm=$hlm&msg=$msg");
					exit();
				}
				else
				{
					$error = base64_encode("Data tidak dapat dimasukkan. Tidak ada data group yang dipilih. Silahkan periksa kembali.");
					header("location: $alamat&aksi=subcriber&newsletterid=$newsletterid&hlm=$hlm&error=$error");
					exit();
				}
			}
			else
			{
				$where="where 1";
				$member_kategori = $_POST['member_kategori'];
				$produkid = $_POST['produkid'];
				$tanggal= $_POST['tanggal'];
				$tanggal1= $_POST['tanggal1'];
				$propinsiid = $_POST['propinsiid'];

				if($member_kategori)
				{
					$jumkategori=count($member_kategori);
					
					for($i=0;$i<$jumkategori;$i++)
					{
						if($member_kategori[$i]=="aktif")
						{
							$where.=" and userActiveStatus='1' and bounce='0'";
						}
						else if($member_kategori[$i]=="tidak aktif")
						{
							$where.=" and userActiveStatus='0' and bounce='0'";
						}
						else if($member_kategori[$i]=="premium")
						{
							$where.=" and memberkategoriid='2' and userActiveStatus='1' and bounce='0'";
						}
						else if($member_kategori[$i]=="free")
						{
							$where.=" and memberkategoriid='1' and userActiveStatus='1' and bounce='0'";
						}
						else if($member_kategori[$i]=="spesial")
						{
							$query=sql("select a.memberid from tbl_member_spesial a, tbl_member b where a.memberid=b.memberid and b.bounce='0'");
							while($row = sql_fetch_data($query))
							{
								$membersp[] = $row['memberid'];
							}
							if(!empty($membersp))
							{
								$membersp1 = implode(",",$membersp);
								$where.= " and memberid IN ( $membersp1 )";
							}
							else
								$where .= " and memberid IN ( 0 )";
						}
					}
				}

				if($produkid)
				{
					$produk=implode(",",$produkid);
					$perintah="SELECT a.memberid FROM tbl_transaksi a LEFT JOIN tbl_transaksi_detail b ON a.transaksiid = b.transaksiid
WHERE b.produkid IN (1,2,3,4,5) and b.produkid != 0 GROUP BY a.memberid";
					$hasil=sql($perintah);
					while($row = sql_fetch_data($query))
					{
						$membersp1[] = $row['memberid'];
					}
					if(!empty($membersp1))
					{
						$where.= " and memberid IN ( $membersp2 )";
					}
					else
						$where .= " and memberid IN ( 0 )";
				}

				if((!empty($tanggal)) and (!empty($tanggal1)))
				{
					$where.=" and userDOB between '$tanggal' and '$tanggal1'";
				}
				if($propinsiid)
				{
					$where.=" and propinsiid='$propinsiid'";
				}

				$sql	= "SELECT memberid, userFullName, userEmail FROM  `tbl_member` $where";
				$query	= sql($sql);
				while($row = sql_fetch_data($query))
				{
					$userid			= $row['memberid'];
					$userfullname	= $row['userFullName'];
					$useremail		= $row['userEmail'];

					$new = newid("id","tbl_newsletter_subcriber");

					$perintah = "insert into tbl_newsletter_subcriber (id,userid,userfullname,useremail,newsletterid,create_date,senddate,create_userid $fgambar)
								values ('$new','$userid','$userfullname','$useremail','$newsletterid','$date','$senddate','$cuserid' $vgambar)";
					$hasil = sql($perintah);
				}

			if($hasil)
			{
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=subcriber&newsletterid=$newsletterid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=subcriber&newsletterid=$newsletterid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Tambah
	if($aksi=="tambahsubcriber")
	{
		if(!$oto['add']) { echo $error['add']; } else
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=subcriber&newsletterid=$newsletterid");
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
            <input type="hidden" name="newsletterid" value="<?php echo $newsletterid;?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
                <tr>
                	<td>Tampilkan Data Berdasarkan</td>
                    <td><input type="radio" name="pilihan" value="group" onclick="return cek(this.value)" /> Group &nbsp;&nbsp;
                    	<input type="radio" name="pilihan" value="member" onclick="return cek(this.value)" /> Member
                    </td>
                </tr>
				<tr class="bygroup" style="display:none">
					<td width="15%">Group</td>
					<td ><select name="groupid">
                    	<option value="">Pilih Group</option>
                        <?php
							$sql = "select groupid, nama from tbl_subcriber_group";
							$qry = sql($sql);
							while($row = sql_fetch_data($qry))
							{
								$groupid = $row['groupid'];
								$nama	 = $row['nama'];

								echo "<option value='$groupid'>$nama</option>";
							}
							//echo "<option value='0'>Member Aktif</option>";
						?>
                    </select></td>
				</tr>
                <tr class="bymember" style="display:none">
                	<th colspan="2">Berdasarkan</th>
                </tr>
                <tr class="bymember" style="display:none">
					<td width="15%">Kategori Member</td>
					<td>
                    	<input type="checkbox" name="member_kategori[]" value="aktif" />  Member Aktif&nbsp;&nbsp;
                        <input type="checkbox" name="member_kategori[]" value="tidak aktif" />  Member Tidak Aktif&nbsp;&nbsp;
                    </td>
				</tr>
                <tr class="bymember" style="display:none">
					<td width="15%">Tanggal Lahir</td>
					<td>
                    	<input type="text" name="tanggal" id="tanggal" /> sampai <input type="text" name="tanggal1" id="tanggal1" />
                    </td>
				</tr>
                <tr class="bymember" style="display:none">
					<td width="15%">Propinsi</td>
					<td>
                    	<select name="propinsiid" id="propinsiid">
                        	<option value="">Pilih Propinsi</option>
                    	<?php
                        	$perintah="select propinsiid,nama from tbl_propinsi where 1";
							$hasil=sql($perintah);
							while($data=sql_fetch_data($hasil))
							{
								echo"<option value=$data[propinsiid]>$data[nama]</option>";
							}
						?>
                        </select>
                    </td>
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
            <input type="hidden" name="newsletterid" value="<?php echo $newsletterid;?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Testing Newsletter</th>
				</tr>
                <tr>
                	<td>Nama Penerima</td>
                    <td><input type="text" name="nama" id="nama" class="validate[required]" /></td>
                </tr>
                <tr>
                	<td>Masukan Alamat Email</td>
                    <td><input type="text" name="email" id="email" class="validate[required]" /></td>
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
	if($aksi=="savetesting")
	{
		if(!$oto['add']) { echo $error['add']; } else
		{

			$email = $_POST['email'];
			$newsletterid = $_POST['newsletterid'];
			$penerima= $_POST['nama'];

			//GET Configuration
			$sql	= "select id, smtphost,smtpname, smtpport, smtpuser, apikey,smtpsender from tbl_konfigurasi_newsletter";
			$query	= sql($sql);
			$row = sql_fetch_data($query);

			$smtphost = $row['smtphost'];
			$smtpport = $row['smtpport'];
			$smtpuser = $row['smtpuser'];
			$smtpname = $row['smtpname'];
			$apikey = $row['apikey'];
			$smtpsender = $row['smtpsender'];

			$id = $row['id'];

			$sql2 = "select subject,plainmail,htmlmail,tags,subaccount,sender,sendername from tbl_newsletter where newsletterid='$newsletterid'";
			$hsl2 = sql($sql2);
			$dt = sql_fetch_data($hsl2);

			$subject = $dt['subject'];
			$plainmail = $dt['plainmail'];
			$htmlmail = $dt['htmlmail'];
			$tags = $dt['tags'];
			$subaccount = $dt['subaccount'];

			$tags = explode(",",$tags);

			$subject = str_replace("--userfullname--",$penerima,$subject);
			$subject = str_replace("--useremail--",$useremail,$subject);

			$plainmail = str_replace("--userfullname--",$penerima,$plainmail);
			$plainmail = str_replace("--useremail--",$useremail,$plainmail);
			$plainmail = str_replace("--useraddress--",$useraddress,$plainmail);
			$plainmail = str_replace("[voucher]",$voucher,$plainmail);

			$htmlmail = str_replace("--userfullname--",$penerima,$htmlmail);
			$htmlmail = str_replace("--useremail--",$useremail,$htmlmail);
			$htmlmail = str_replace("--useraddress--",$useraddress,$htmlmail);
			$htmlmail = str_replace("[voucher]",$voucher,$htmlmail);

			$htmlmail = stripslashes($htmlmail);
			$plainmail = stripslashes($plainmail);

			$track = strtolower(md5("$id$useremail$newsletterid"));

			require_once './librari/mandrill/src/Mandrill.php';

			if(!empty($subject))
			{

				$message = array(
				'html' => $htmlmail,
				'text' => $plainmail,
				'subject' => $subject,
				'from_email' => $smtpsender,
				'from_name' => $smtpname,
				'to' => array(
					array(
						'email' => $email,
						'name' => $penerima,
						'type' => 'to'
					)
				),
				'headers' => array('Reply-To' => $smtpsender),
				'important' => false,
				'track_opens' => null,
				'track_clicks' => null,
				'auto_text' => null,
				'auto_html' => null,
				'inline_css' => null,
				'url_strip_qs' => null,
				'preserve_recipients' => null,
				'view_content_link' => null,
				'bcc_address' => null,
				'tracking_domain' => null,
				'signing_domain' => null,
				'return_path_domain' => null,
				'merge' => true,
				'merge_language' => 'mailchimp',
				'tags' => $tags
				);

				$async = false;
				$ip_pool = 'Main Pool';

				//print_r($message);

				try
				{

					$mandrill = new Mandrill($apikey);
					//print_r($mandrill);
					$result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);

					print_r($result);
					$mandrillid = $result[0]['_id'];
					$status = $result[0]['status'];

					if($status=="sent") $status1=1;
					elseif($status=="queue") $status1=2;
					else $status1 = 0;


					/*$sql3 = "update tbl_newsletter_subcriber set status='$status1',mandrillid='$mandrillid' where id='$id'";
					$hsl3 = sql($sql3);*/

					$siiii 	= "insert into tbl_log_mail (`logdate`,`logfrom`,`logto`,`logsubject`,`logmail`,`logcateg`,logstatus)
							values ('$date','$smtpuser','$email','$subject','$htmlmail','$logcateg','$status1')";
					$qi		= sql($siiii);
					if($hasil)
					{
						$msg = base64_encode("Berhasil mengirim email newsletter ke $email");
						header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
						exit();
					}
					else
					{
						$error = base64_encode("Gagal mengirim email newsletter ke $email");
						header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
						exit();
					}
				}
				catch(Mandrill_Error $e)
				{
					$result = 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();

					print_r($result);
				}
			}
		}
	}
}

?>