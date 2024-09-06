<?php
	//Variable halaman ini
	$nama_tabel 	= "tbl_ticketing";
	$nama_tabel1 	= "tbl_ticketing_balas";
	$judul_per_hlm 	= 25;
	$otoritas		= kodeoto($kanal);
	$oto			= $otoritas[0];
	$fileallowed	= "jpg, jpeg, png, gif, pdf, doc, docx, txt, xls, xlsx, ppt, pptx, zip, rar";

	//Variable Umum
	if(isset($_POST['gid'])) $gid = $_POST['gid'];
	else $gid = $_GET['gid'];
	
if (!$oto['oto']) { echo $error['oto']; } else
{
	//View Menu
	if($aksi=="view")
	{
		if (!$oto['view']) { echo $error['view']; } else
        {
			$mainmenu[] = array("Lihat Ticketing","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
	
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("kode_support","Kode Support","str","text","$data");
			$cari[] = array("pengirim","Email/UserName","str","text","$data");
	
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
	
			//Orderring
			$order = getorder("create_date","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];

			$getstatus     = $_GET['status'];
			$getreply_user = $_GET['reply_user'];

			if(!empty($getstatus) || $getstatus=='0')
				$where .= "and status='$getstatus' and is_closed='0'";
			if(!empty($getreply_user) || $getreply_user=='0')
				$where .= "and reply_user='$getreply_user' and is_closed='0'";

			// echo $where;
			
			//$outletid = sql_get_var("select outletid from tbl_member where userid='$cuserid'");outletid='$outletid' 
			
			if ($_SESSION['cms_isticketing']==1)
			{
				$smp	= "select matapelajaranid from tbl_mata_pelajaran where pelajaranid='$_SESSION[cms_pelajaranid]'";
				$qmp	= sql($smp);
				$jmp	= sql_num_rows($qmp);
				if($jmp>0)
				{
					$wherepelajaran = "and (matapelajaranid in (";
					$xx				= 1;
					while ($rmp = sql_fetch_data($qmp))
					{
						if($xx==$jmp)
							$wherepelajaran .= $rmp['matapelajaranid'];
						else
							$wherepelajaran .= $rmp['matapelajaranid'] .",";
						$xx++;
					}
					$wherepelajaran .= "))";
				}
				sql_free_result($qmp);
			}
			
			$sql = "select count(*) as jml from $nama_tabel where 1 $wherepelajaran $where $parorder";
			$hsl = sql($sql);
	
			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
	
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select * from $nama_tabel where 1 $wherepelajaran $where order by create_date desc limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=2%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=memberid\" title=\"Urutkan\">Pengirim</a></th>\n");
			print("<th width=35%>Pesan</th>");
			print("<th width=15%>Pelajaran</th>");
			print("<th width=10%>Status</th>");
			if (($_SESSION['cms_gid']==2) or ($_SESSION['cms_isticketing']==1)) print("<th width=10%>Balas</th>");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");
			
			while ($row = sql_fetch_data($hsl))
			{
				$id 				= $row['ticketingid'];
				$pesan 				= $row['isipertanyaan'];
				$close 				= $row['is_closed'];
				$balas 				= $row['status'];
				$userid 			= $row['memberid'];
				$status 			= $row['status'];
				$pengirim 			= sql_get_var("select userFullName from tbl_member where memberid='$userid'");
				$judul 				= $row['judul'];
				$tanggal 			= $row['create_date'];
				$tanggal			= tanggal($tanggal);
				$matapelajaranid	= $row['matapelajaranid'];
				$reply_user			= $row['reply_user'];
				
				$matapelajaran		= sql_get_var("select nama from tbl_mata_pelajaran where matapelajaranid='$matapelajaranid'");
				
				if ($close == 1)
				{
					$keterangan	= "<img src='./template/images/tick.png'> <strong style='color:#3a8000;'>Pertanyaan sudah selesai diproses</strong>";
					$closed		= "<img src='./template/images/lock.png'> <strong style='color:#3a8000;'>Close</strong>";
					$reply		= "";
				}
				else
				{
					if($reply_user == 2 and $balas == 1)
					{
						$keterangan	= "<img src='./template/images/pencil.png'> Sudah dibalas oleh Admin dan sedang diproses";
						$closed		= "<img src='./template/images/unlock.png'> <a href=\"$alamat&aksi=closed&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm\"><strong>Open</strong></a>";
						$reply		= "<img src='./template/images/email_reply.png'> <a href=\"$alamat&aksi=reply&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm\"><strong>Reply</strong></a>";

					}
					else if($reply_user == 1 and $balas == 1)
					{
						$keterangan	= "<img src='./template/images/exclamation.png'> <span style='background:#1f1f9e; color:#fff'>Dibalas oleh siswa dan sedang diproses</span>";
						$closed		= "<img src='./template/images/unlock.png'> <a href=\"$alamat&aksi=closed&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm\"><strong>Open</strong></a>";
						$reply		= "<img src='./template/images/email_reply.png'> <a href=\"$alamat&aksi=reply&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm\"><strong>Reply</strong></a>";

					}
					else if($reply_user == 0 and $balas == 0)
					{
						$keterangan	= "<img src='./template/images/exclamation.png'> <span style='background:#bc2525; color:#fff'>Pertanyaan mohon dijawab</span>";
						$closed		= "<img src='./template/images/unlock.png'> <a href=\"$alamat&aksi=closed&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm\"><strong>Open</strong></a>";
						$reply		= "<img src='./template/images/email_reply.png'> <a href=\"$alamat&aksi=reply&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm\"><strong>Reply</strong></a>";

					}
					else
					{
						$keterangan	= "<img src='./template/images/exclamation.png'> Pertanyaan mohon dijawab dan sedang diproses";
						$closed		= "<img src='./template/images/unlock.png'> <a href=\"$alamat&aksi=closed&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm\"><strong>Open</strong></a>";
						$reply		= "<img src='./template/images/email_reply.png'> <a href=\"$alamat&aksi=reply&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm\"><strong>Reply</strong></a>";
					}
				}	
				
				if($balas == 0)
				{
					$replied	= "<img src='./template/images/email.png'> Received";
				}
				else
				{
					$replied	= "<img src='./template/images/email_open.png'> Replied";
				}
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$pengirim</td>\n");
				print("<td valign=top><a href=\"$alamat&aksi=detail&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm\"><strong>$judul</strong></a>
					<br /><strong>Tanggal Update :</strong> $tanggal 
					<br /><br />$keterangan</td>\n
					<td  valign=top>$matapelajaran</td>\n");
				print("<td valign=top>$replied <br /><br />$closed</td>\n");
				if (($_SESSION['cms_gid']==2) or ($_SESSION['cms_isticketing']==1)) print("<td valign=top>$reply</td>\n");
	
				print("<td>");
	
				$acc[] = array("Detail","detail","$alamat&aksi=detail&id=$id&hlm=$hlm");
				if($close==0)
				{
					if (($_SESSION['cms_gid']==2) or ($_SESSION['cms_isticketing']==1)) $acc[] = array("Reply","edit","$alamat&aksi=reply&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm");
					if (($_SESSION['cms_gid']==2) or ($_SESSION['cms_isticketing']==1)) $acc[] = array("Edit","edit","$alamat&aksi=edit&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm");
				}
				if (($_SESSION['cms_gid']==2) or ($_SESSION['cms_isticketing']==1)) $acc[] = array("Hapus","delete","$alamat&aksi=hapus&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm");
	
	
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
		if (!$oto['view']) { echo $error['view']; } else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
	
			$id				= $_GET['id'];
			$matapelajaranid= $_GET['matapelajaranid'];
			
			$sql1	= "select * from $nama_tabel where ticketingid='$id'";
			$hsl1 	= sql($sql1);
			$row1 	= sql_fetch_data($hsl1);
	
			$id 			= $row1['ticketingid'];
			$userId 		= $row1['memberid'];
			$pesan 			= $row1['isipertanyaan'];
			$pengirim 		= sql_get_var("select userFullName from tbl_member where memberid='$userId'");
			$judul 			= $row1['judul'];
			$pesan 			= nl2br($pesan);
			$pesan 			= str_replace("#","<hr>",$pesan);
			$balas 			= $row1['status'];
			$close 			= $row1['is_closed'];
			$tanggal 		= tanggal($row1['create_date']);
			$filetanya		= $row1['filetanya'];
			$reply_user		= $row1['reply_user'];
			
			if ($close == 1)
			{
				$keterangan	= "<img src='./template/images/tick.png'> <strong style='color:#3a8000;'>Pertanyaan sudah selesai diproses</strong>";
				$closed		= "<img src='./template/images/lock.png'> <strong style='color:#3a8000;'>Close</strong>";
			}
			else
			{
				if($reply_user == 2 and $balas == 1)
				{
					$keterangan	= "<img src='./template/images/pencil.png'> Sudah dibalas oleh Admin dan sedang diproses";
					$closed		= "<img src='./template/images/unlock.png'> <strong>Open</strong>";

				}
				else if($reply_user == 1 and $balas == 1)
				{
					$keterangan	= "<img src='./template/images/exclamation.png'> <span style='background:#1f1f9e; color:#fff'>Dibalas oleh siswa dan sedang diproses</span>";
					$closed		= "<img src='./template/images/unlock.png'> <strong>Open</strong>";

				}
				else if($reply_user == 0 and $balas == 0)
				{
					$keterangan	= "<img src='./template/images/exclamation.png'> <span style='background:#bc2525; color:#fff'>Pertanyaan mohon dijawab</span>";
					$closed		= "<img src='./template/images/unlock.png'> <strong>Open</strong>";

				}
				else
				{
					$keterangan	= "<img src='./template/images/exclamation.png'> Pertanyaan mohon dijawab dan sedang diproses";
					$closed		= "<img src='./template/images/unlock.png'> <strong>Open</strong>";
				}
			}	
			
			if($balas == 0)
			{
				$replied	= "<img src='./template/images/email.png'> Received";
			}
			else
			{
				$replied	= "<img src='./template/images/email_open.png'> Replied";
			}
			
			if(!empty($filetanya)) $filetanya = "<a href='$fulldomain/gambar/ticketing/$filetanya' target='_blank'> Download File </a>";
				else $filetanya = "Tidak ada file";
	
			?>
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail Pertanyaan</th>
				</tr>
				<tr>
					<td width="10%">Judul</td>
					<td width="90%"><?php echo $judul?></td>
				</tr>
 				<tr>
					<td>Tanggal Kirim</td>
					<td><?php echo $tanggal?></td>
				</tr>
				<tr>
					<td>Pengirim</td>
					<td><?php echo $pengirim?></td>
				</tr>
				<tr>
					<td>Status</td>
					<td><?php echo $replied?>   <?php echo $closed?></td>
				</tr>
				
				<tr>
					<th colspan="2">Isi Pertanyaan</th>
				</tr>
				<tr>
					<td colspan="2" align="left"><?php echo $pesan?><br />File Upload: <?php echo $filetanya?><br /><br /><?php echo $keterangan?></td>
				</tr>
				
				<tr>
					<td colspan="2" align="right">
					<?php if (($_SESSION['cms_gid']==2) or ($_SESSION['cms_isticketing']==1)) {
						if ($close == 0) { ?>
                        <button class="btn dropdown-toggle" onclick="window.location=('<?php echo"$alamat&aksi=reply&id=$id&hlm=$hlm"?>');">Reply</button>
						<button class="btn dropdown-toggle" onclick="window.location=('<?php echo"$alamat&aksi=edit&id=$id&hlm=$hlm"?>');">Edit</button>
						<button class="btn dropdown-toggle" onclick="window.location=('<?php echo"$alamat&aksi=closed&id=$id&hlm=$hlm"?>');">Close</button>
					<?php } ?>
						<button class="btn dropdown-toggle" onclick="window.location=('<?php echo"$alamat&aksi=hapus&id=$id&hlm=$hlm"?>');">Delete</button>
					<?php } ?>
					</td>
				</tr>
			</table><br clear="all" /><br />
			
			<?php
			$sql	= "select tutorid,isijawaban,create_date,ticketingbalasid,filejawab from $nama_tabel1 where ticketingid='$id'";
			$hsl 	= sql($sql);
			$i 		= 1;
			$a 		= 1;	
	
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=100% colspan=5>Jawaban</th></tr></thead>");
			
			print("<tr>");
			print("<td width=10%><strong>Nomor</strong></td>\n");
			print("<td width=15%><a href=\"$urlorder&order=create_date\" title=\"Urutkan\"><strong>Tanggal</strong></a></td>\n");
			print("<td width=10%><a href=\"$urlorder&order=tutorid\" title=\"Urutkan\"><strong>Tutor</strong></a></td>\n");
			print("<td width=60% ><strong>Jawaban</strong></td>");
			print("<td width=5% align=center><b>Action</b></td></tr>");
			while ($row = sql_fetch_data($hsl))
			{
				$balasan	= $row['isijawaban'];
				$tgl_balas	= tanggalsimple($row['create_date']);
				$tutorid	= $row['tutorid'];
				$filejawab	= $row['filejawab'];
				$balasid	= $row['ticketingbalasid'];
				$oleh		= sql_get_var("select userfullname from tbl_cms_user where userid='$tutorid'");
				
				if(!empty($filejawab)) $filejawab = "<a href='$fulldomain/gambar/ticketing/$filejawab' target='_blank'> Download File </a>";
				else $filejawab = "Tidak ada file";
	
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>");
				print("<td valign=top class=hitam>$tgl_balas</td>\n");
				print("<td valign=top class=hitam>$oleh</td>\n");
				print("<td valign=top class=hitam>$balasan<br ><strong>File Upload:</strong> $filejawab</td>\n");
				
				print("<td>");
	
				if($close==0)
				{
					if (($_SESSION['cms_gid']==2) or ($_SESSION['cms_isticketing']==1)) $acc[] = array("Edit","edit","$alamat&aksi=editreply&id=$id&matapelajaranid=$matapelajaranid&balasid=$balasid&hlm=$hlm");
				}
				if (($_SESSION['cms_gid']==2) or ($_SESSION['cms_isticketing']==1)) $acc[] = array("Hapus","delete","$alamat&aksi=hapusreply&id=$id&matapelajaranid=$matapelajaranid&balasid=$balasid&hlm=$hlm");
	
	
				cmsaction($acc);
				unset($acc);
	
				print("</td></tr>");
	
				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'><br clear='all'>");
		}
	}

	//HapusMenu
	if($aksi=="hapus")
	{
		if (!$oto['delete']) { echo $error['view']; } 
		else
        {
			$id = $_GET['id'];
	
			$perintah 	= "delete from $nama_tabel1 where ticketingid='$id'";
			$hasil 		= sql($perintah);
			
			$perintah 	= "delete from $nama_tabel where ticketingid='$id'";
			$hasil 		= sql($perintah);
	
			if($hasil)
			{
				$msg = base64_encode("Success mengapus data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//HapusMenu
	if($aksi=="hapusreply")
	{
		if (!$oto['delete']) { echo $error['view']; } 
		else
        {
			$id 				= $_GET['id'];
			$balasid 			= $_GET['balasid'];
			$matapelajaranid 	= $_GET['matapelajaranid'];
	
			$perintah 	= "delete from $nama_tabel1 where ticketingid='$id' and ticketingbalasid='$balasid'";
			$hasil 		= sql($perintah);
			
			if($hasil)
			{
				$msg = base64_encode("Success mengapus data dengan ID $balasid");
				header("location: $alamat&aksi=detail&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&id=$id&matapelajaranid=$matapelajaranid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Simpan-Status
	if($aksi=="savereply")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$ticketingbalasid	= newid("ticketingbalasid",$nama_tabel1);
			$ticketingid		= cleaninsert($_POST['id']);
			$isijawaban			= desc($_POST['isijawaban']);
			$memberid			= cleaninsert($_POST['memberid']);
			$hlm				= $_POST['hlm'];
			$judultanya			= cleaninsert($_POST['judultanya']);
			$judul				= cleaninsert($_POST['judul']);
			$alias				= getAlias($judultanya);
			$pesan				= desc($_POST['pesan']);
			$tanggal2			= tanggalbulantahunjam($date);
			$is_answer			= 1;
			
			$folderalbum	= "$pathfile"."ticketing/";
				
			if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }
				
			if($_FILES['files']['size']>0)
			{
				$ext = getfileext($_FILES['files']);
				//if($ext=="pdf" || $ext=="doc" || $ext=="docx")
				if(preg_match("/$ext/i",$fileallowed))
				{
					$namafile 	= "jawaban-$ticketingid-$ticketingbalasid"."."."$ext";
					copy($_FILES['files']['tmp_name'],"$folderalbum/"."$namafile");
					if(file_exists("$folderalbum/"."$namafile"))
					{
						$vfield = ",filejawab";
						$vval 	= ",'$namafile'";
					}
					$cekfile = 1;
				}
				else
				{
					$cekfile = 0;
				}
			}
			
			
			$pesan_email 	= "
					<strong>Pertanyaan:</strong> <br />
					$pesan <br /><br />
					
					<strong>Jawab:</strong> <br />
					$isijawaban<br />
					--<br /><br />
					
					Dibalas tanggal: $tanggal2 <br /> 
					Oleh: $_SESSION[cms_userfullname]<br /><br />
					
					Jika Anda akan bertanya kembali, silahkan klik link di bawah ini :
					<a href='$fulldomain/member/ticketing/detail/$ticketingid/$alias.html'> <strong>$judul</strong> </a>
					Dengan melakukan login terlebih dahulu. Terima kasih.";
	
			$perintah2	= "insert into $nama_tabel1 (`ticketingbalasid`,`ticketingid`,`isijawaban`,`tutorid`,`judul`,`create_date`,`create_userid`,`is_answer` $vfield) 
						values ('$ticketingbalasid','$ticketingid','$isijawaban','$_SESSION[cms_userid]','$judul','$date','$_SESSION[cms_userid]','$is_answer' $vval)";
			
			//echo $perintah2; die();
			$hasil2		= sql($perintah2);
			
			$perintah2	= "update $nama_tabel set status='1',reply_user='2' where ticketingid='$ticketingid'";
			$hasil2		= sql($perintah2);
	
			$hasil2 = 1;
			if($hasil2)
			{
				$qm	= sql("select userFullName, userEmail from tbl_member where memberid='$memberid'");
				$rm	= sql_fetch_data($qm);
					$userEmail			= $rm['userEmail'];
					$userFullName		= $rm['userFullName'];
				sql_free_result($qm);
				
				$headers 			= "From : $owner";
				$subject			= "$title - $judul";
				$sendmail			= sendmail($userFullName,$userEmail,$subject,$pesan_email,$pesan_email);
				//echo "$userFullName,$userEmail,$subject,$pesan_email,$pesan_email"; die();
				
				if(!$cekfile)
					$msg = base64_encode("File tidak diizinkan untuk diupload, silahkan file yang berekstensi $fileallowed. Berhasil mengirim balasan untuk ID $ticketingid.");
				else
					$msg = base64_encode("Berhasil mengirim balasan untuk ID $ticketingid.");
					
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				if(!$cekfile)
					$error = base64_encode("File tidak diizinkan untuk diupload, silahkan file yang berekstensi $fileallowed. Data tidak dapat dimasukkan dan silahkan coba kembali.");
				else
					$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
			
		}
	}

	//TambahMenu
	if($aksi=="reply")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id 				= $_GET['id'];
			$matapelajaranid	= $_GET['matapelajaranid'];
			
			if($_SESSION['cms_gid']!=2)
			{
				$pelajaranid	= sql_get_var("select pelajaranid from tbl_mata_pelajaran where matapelajaranid='$matapelajaranid'");
				$namapelajaran 	= sql_get_var("select nama from tbl_pelajaran where pelajaranid='$pelajaranid'");
				
				if($pelajaranid!=$_SESSION['cms_pelajaranid']) $bukantutor = 1;
				else $bukantutor = 0;
			}
			elseif($_SESSION['cms_gid']==2)
			{
				$bukantutor = 0;
			}
			
			if($bukantutor==1)
			{
				if($pelajaranid!=$_SESSION['cms_pelajaranid']) 
					echo "<center><div class=\"box-error\">Anda tidak dapat membalas pertanyaan untuk pelajaran <strong>$namapelajaran</strong></div></center>";
			}
			else
			{
	
				$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
				mainaction($mainmenu,$param);
		
				$sql1	= "select * from $nama_tabel where ticketingid='$id'";
				$query1	= sql($sql1);
				$row1	= sql_fetch_data($query1);
				$pesan			= $row1['isipertanyaan'];
				$pesan 			= str_replace("#","<br><hr><br>",$pesan);
				$memberid		= $row1['memberid'];
				$pengirim		= sql_get_var("select userFullName from tbl_member where memberid='$memberid'");
				$judul			= $row1['judul'];
				$filetanya		= $row1['filetanya'];
				
				if(!empty($filetanya)) $filetanya = "<a href='$fulldomain/gambar/ticketing/$filetanya' target='_blank'> Download File </a>";
				else $filetanya = "Tidak ada file";
			
				?>
				<script src="librari/ckeditor/ckeditor.js"></script>
				<script>
					$(document).ready(function() {
						$("#menufrm").validationEngine()
					});
				</script>
				<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
				<input type="hidden" name="aksi" value="savereply">
				<input type="hidden" name="id" value="<?php echo $id?>">
				<input type="hidden" name="pesan" value="<?php echo $pesan?>">
                <input type="hidden" name="memberid" value="<?php echo $memberid?>">
                <input type="hidden" name="judultanya" value="<?php echo $judul?>">
				<table border="0" class="tabel-cms" width="100%">
					<tr>
						<th colspan="2">Reply Ticketing</th>
					</tr>
					<tr>
						<td width="20%">Pengirim</td>
						<td width="80%"><input name="pengirim" type="text" readonly="readonly" size="20" value="<?php echo $pengirim?>" id="pengirim" class="validate[required]" /></td>
					</tr>
					<tr>
						<td>Pertanyaan</td>
						<td><?php echo $pesan?></td>
					</tr>
                    <tr>
						<td>File Upload</td>
						<td><?php echo $filetanya?></td>
					</tr>
					<tr>
						<td width="20%">Judul</td>
						<td width="80%"><input name="judul" type="text" size="50" value="Re: <?php echo $judul?>" id="judul" class="validate[required]" /></td>
					</tr>
					<tr>
						<td>Jawaban</td>
						<td><textarea name="isijawaban" cols="70" rows="10" id="isijawaban" class="ckeditor validate[required]" ></textarea></td>
					</tr>
                    <tr>
						<td width="20%">File Upload</td>
						<td width="80%">
                        	<input name="files" type="file" size="50" id="files" class="" />
                            <em>Maksimum file yang bisa dikirim<strong> <?php echo ini_get("upload_max_filesize");?></strong> 
                            format <strong><?php echo $fileallowed?></strong></em>
                        </td>
					</tr>
					<tr>
						<td valign="top">&nbsp;</td>
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
	
	//Simpan-Status
	if($aksi=="saveedit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$pengirim		= cleaninsert($_POST['pengirim']);
			$memberid		= cleaninsert($_POST['memberid']);
			$pesan			= desc($_POST['pesan']);
			$judul			= cleaninsert($_POST['judul']);
			$hlm			= $_POST['hlm'];
			$ticketingid	= cleaninsert($_POST['id']);
			
			$alias			= getAlias($judul);
			
			$fileallow		= "pdf, doc, docx";
			$folderalbum	= "$pathfile"."ticketing/";
				
			if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }
				
			if($_FILES['files']['size']>0)
			{
				$ext = getfileext($_FILES['files']);
				//if($ext=="pdf" || $ext=="doc" || $ext=="docx")
				if(preg_match("/$ext/i",$fileallowed))
				{
					$namafile 	= "ticketing-$alias-$ticketingid"."."."$ext";

					copy($_FILES['files']['tmp_name'],"$folderalbum/"."$namafile");
					if(file_exists("$folderalbum/"."$namafile"))
					{
						$vfield = ",filetanya='$namafile'";
					}
					$cekfile = 1;
				}
				else
				{
					$cekfile = 0;
				}
			}
	
			$perintah 	= "update $nama_tabel SET isipertanyaan='$pesan',judul='$judul' $vfield WHERE ticketingid='$ticketingid'";
			$hasil 		= sql($perintah);
	
			if($hasil)
			{
				if(!$cekfile)
					$msg = base64_encode("File tidak diizinkan untuk diupload, silahkan file yang berekstensi $fileallowed. Berhasil mengubah data.");
				else
					$msg = base64_encode("Berhasil mengubah data.");
					
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				if(!$cekfile)
					$error = base64_encode("File tidak diizinkan untuk diupload, silahkan file yang berekstensi $fileallowed. Data tidak dapat diubah dan silahkan coba kembali");
				else
					$error = base64_encode("Data tidak dapat diubah dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//TambahMenu
	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
	
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
	
			$sql1	= "select * from $nama_tabel where ticketingid='$id'";
			$query1	= sql($sql1);
			$row1	= sql_fetch_data($query1);
			$pesan			= $row1['isipertanyaan'];
			$pesan 			= str_replace("#","<br><hr><br>",$pesan);
			$memberid		= $row1['memberid'];
			$pengirim		= sql_get_var("select userFullName from tbl_member where memberid='$memberid'");
			$judul			= $row1['judul'];
			
			?>
			<script src="librari/ckeditor/ckeditor.js"></script>
			<script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
			<input type="hidden" name="id" value="<?php echo $id?>">
            <input type="hidden" name="memberid" value="<?php echo $memberid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Ticketing</th>
				</tr>
				<tr>
					<td width="20%">Pengirim</td>
					<td width="80%"><input name="pengirim" type="text" readonly="readonly" size="20" value="<?php echo $pengirim?>" id="pengirim" class="validate[required]" /></td>
				</tr>
				<tr>
					<td width="20%">Judul</td>
					<td width="80%"><input name="judul" type="text" size="50" value="<?php echo $judul?>" id="judul" class="validate[required]" /></td>
				</tr>
				<tr>
					<td>Pertanyaan</td>
					<td><textarea name="pesan" cols="70" rows="10" id="pesan" class="ckeditor validate[required]" ><?php echo $pesan?></textarea></td>
				</tr>
                <tr>
                    <td width="20%">File Upload</td>
                    <td width="80%">
                        <input name="files" type="file" size="50" id="files" class="" />
                        <em>Maksimum file yang bisa dikirim<strong> <?php echo ini_get("upload_max_filesize");?></strong> 
                        format <strong><?php echo $fileallowed?></strong></em>
                    </td>
                </tr>
				<tr>
					<td valign="top">&nbsp;</td>
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
	
	//Simpan-Status
	if($aksi=="closed")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
	
			$perintah 	= "update $nama_tabel SET is_closed='1' WHERE ticketingid='$id'";
			$hasil 		= sql($perintah);
	
			if($hasil)
			{
				$msg = base64_encode("Berhasil mengubah data.");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat diubah dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//Simpan-Status
	if($aksi=="saveeditreply")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$ticketingbalasid	= cleaninsert($_POST['balasid']);
			$pesan				= desc($_POST['pesan']);
			$judul				= cleaninsert($_POST['judul']);
			$hlm				= $_POST['hlm'];
			$ticketingid		= cleaninsert($_POST['id']);
			$matapelajaranid	= cleaninsert($_POST['matapelajaranid']);
			$is_answer			= 1;
			
			$fileallow		= "pdf, doc, docx";
			$folderalbum	= "$pathfile"."ticketing/";
				
			if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }
				
			if($_FILES['files']['size']>0)
			{
				$ext = getfileext($_FILES['files']);
				if(preg_match("/$ext/i",$fileallowed))
				{
					$namafile 	= "jawaban-$ticketingid-$ticketingbalasid"."."."$ext";
					//if(!preg_match("/$extf/i",$fileallowvideo))
					
					copy($_FILES['files']['tmp_name'],"$folderalbum/"."$namafile");
					if(file_exists("$folderalbum/"."$namafile"))
					{
						$vfield = ",filejawab='$namafile'";
					}
					$cekfile = 1;
				}
				else
				{
					$cekfile = 0;
				}
			}
	
			$perintah 	= "update $nama_tabel1 SET isijawaban='$pesan',judul='$judul',is_answer='$is_answer' $vfield 
						WHERE ticketingid='$ticketingid' and ticketingbalasid='$ticketingbalasid'";
			$hasil 		= sql($perintah);
	
			if($hasil)
			{
				if(!$cekfile)
					$msg = base64_encode("File tidak diizinkan untuk diupload, silahkan file yang berekstensi $fileallowed. Berhasil mengubah data.");
				else
					$msg = base64_encode("Berhasil mengubah data.");
				header("location: $alamat&aksi=detail&id=$ticketingid&matapelajaranid=$matapelajaranid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				if(!$cekfile)
					$error = base64_encode("File tidak diizinkan untuk diupload, silahkan file yang berekstensi $fileallowed. Data tidak dapat diubah dan silahkan coba kembali.");
				else
					$error = base64_encode("Data tidak dapat diubah dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&id=$ticketingid&matapelajaranid=$matapelajaranid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//TambahMenu
	if($aksi=="editreply")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id 				= $_GET['id'];
			$balasid 			= $_GET['balasid'];
			$matapelajaranid 	= $_GET['matapelajaranid'];
	
			$mainmenu[] = array("Kembali","back","$alamat&aksi=detail&id=$id&matapelajaranid=$matapelajaranid");
			mainaction($mainmenu,$param);
	
			$sql1	= "select * from $nama_tabel1 where ticketingid='$id' and ticketingbalasid='$balasid'";
			$query1	= sql($sql1);
			$row1	= sql_fetch_data($query1);
			$pesan			= $row1['isijawaban'];
			$pesan 			= str_replace("#","<br><hr><br>",$pesan);
			$judul			= $row1['judul'];
			
			?>
			<script src="librari/ckeditor/ckeditor.js"></script>
			<script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditreply">
			<input type="hidden" name="id" value="<?php echo $id?>">
            <input type="hidden" name="balasid" value="<?php echo $balasid?>">
            <input type="hidden" name="matapelajaranid" value="<?php echo $matapelajaranid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Jawaban</th>
				</tr>
				<tr>
					<td width="20%">Judul</td>
					<td width="80%"><input name="judul" type="text" size="50" value="<?php echo $judul?>" id="judul" class="validate[required]" /></td>
				</tr>
				<tr>
					<td>Jawaban</td>
					<td><textarea name="pesan" cols="70" rows="10" id="pesan" class="ckeditor validate[required]" ><?php echo $pesan?></textarea></td>
				</tr>
                <tr>
                    <td width="20%">File Upload</td>
                    <td width="80%">
                        <input name="files" type="file" size="50" id="files" class="" />
                        <em>Maksimum file yang bisa dikirim<strong> <?php echo ini_get("upload_max_filesize");?></strong> 
                        format <strong><?php echo $fileallowed?></strong></em>
                    </td>
                </tr>
				<tr>
					<td valign="top">&nbsp;</td>
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