<?php 
//Variable halaman ini
$nama_tabel		= "tbl_member";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 250;
$gambars_maxh = 250;
$gambarl_maxw = 800;
$gambarl_maxh = 600;

//Variable Umum
if(isset($_POST['userid'])) $userid = $_POST['userid'];
 else $userid = $_GET['userid'];
 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }  
		else {
			$mainmenu[] = array("Lihat Member","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Member","tambah","$alamat&aksi=tambahadmin");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("username","Username","int","text","$data");
			$cari[] = array("userfullname","Nama Lengkap","str","text","$data");
			// $cari[] = array("useraddress","Alamat","str","text","$data");
			$cari[] = array("useremail","Email","str","text","$data");
			
			$dataselect[] = array("0","Pending");
			$dataselect[] = array("1","Billed");
			$dataselect[] = array("2","Verified");
			$dataselect[] = array("3","Expired");
			$dataselect[] = array("4","Decline");
			
			$cari[] = array("verified","Status","select","select",$dataselect);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("userid","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel where tipe='3' $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select userid,username,tipe,userfullname,useremail,verified,pilihan,avatar,cid from $nama_tabel  where tipe='3' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=1%>Nomor</th>\n");
			print("<th width=20%>Avatar</th>\n");
			print("<th width=25%><a href=\"$urlorder&order=userfullname\" title=\"Urutkan\">Nama Lengkap</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=username\" title=\"Urutkan\">Username</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=useremail\" title=\"Urutkan\">Email</a></th>");
			// print("<th width=10%><a href=\"$urlorder&order=tipe\" title=\"Urutkan\">Tipe</a></th>");
			print("<th width=10%><a href=\"$urlorder&order=cid\" title=\"Urutkan\">CID</a></th>");
			print("<th width=10%><a href=\"$urlorder&order=verified\" title=\"Urutkan\">Status</a></th>");
			print("<th width=10%><a href=\"$urlorder&order=pilihan\" title=\"Urutkan\">Pilihan</a></th>");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$userfullname = $row['userfullname'];
				$userid       = $row['userid'];
				$username     = $row['username'];
				$usernickname = $row['usernickname'];
				$useremail    = $row['useremail'];
				$userid       = $row['userid'];
				$tipe         = $row['tipe'];
				$cid          = $row['cid'];
				$pilihan      = $row['pilihan'];
				$avatar       = $row['avatar'];
				$verified     = $row['verified'];
				
				if($tipe=="0") $tipe = "Member";
				elseif($tipe=="1") $tipe = "Reseller";
				elseif($tipe=="2") $tipe = "Supervisior";
				elseif($tipe=="3") $tipe = "Manager";
				
					
				if($pilihan == 0)
					$status = "<img src='./template/images/publish_r.png'>";
				elseif($pilihan == 1)
					$status = "<img src='./template/images/publish_g.png'>";
				
				if($verified == 0)
				{
					$verified = "Pending";
					// $verified = "<div class=\"alert alert-success alert-dismissible\" role=\"alert\"></div>";
				}
				elseif($verified == 1)
				{
					$verified = "Billed";
					// $verified = "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">Belum Terpakai</div>";
				}
				elseif($verified == 2)
				{
					$verified = "Verified";
				}
				elseif($verified == 3)
				{
					$verified = "Expired";
				}
				elseif($verified == 4)
				{
					$verified = "Decline";
				}
					
				if(!empty($avatar)) $avatar = "<img src='$lokasiwebmember/avatars/$avatar' style='width:80px'>";
				
			
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>$avatar</td>
					<td width=10% height=20 valign=top><b>$userfullname</b></td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=detail&userid=$userid\"><b>$username</b></a></td>\n");
				print("<td valign=top class=hitam>$useremail</td>\n");
				// print("<td valign=top class=hitam>$tipe</td>\n");
				print("<td valign=top class=hitam>$cid</td>\n");
				print("<td align=center>$verified</td>");
				print("<td align=center><a href=\"$alamat&aksi=pilihan&userid=$userid\">$status</a></td>");
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&userid=$userid&hlm=$hlm");
				$acc[] = array("Edit CID","edit","$alamat&aksi=editcid&userid=$userid&hlm=$hlm");
				$acc[] = array("Ganti Password","ganti-password","$alamat&aksi=ubahpassword&userid=$userid&hlm=$hlm");
				$acc[] = array("Edit Status","edit","$alamat&aksi=editstatus&userid=$userid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&userid=$userid&hlm=$hlm");
				
								
				cmsaction($acc);
				unset($acc);
				
				print("</td></tr>");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");
			sql_free_result($hsl);
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		    
			
		}
	} //EndView 
	
	//Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }else {
			$userid     = $_GET['userid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select * from $nama_tabel where userid='$userid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$userid       = $row['userid'];
			$avatar       = $row['avatar'];
			$username     = $row['username'];
			$useremail    = $row['useremail'];
			$userfullname = $row['userfullname'];
			$usergender   = $row['usergender'];
			$userpob      = $row['userpob'];
			$userdob      = tanggaltok($row['userdob']);
			$nomor_ktp    = $row['nomor_ktp'];
			$useraddress  = $row['useraddress'];
			$cityname     = $row['cityname'];
			$userphone    = $row['userphone'];
			$userphonegsm = $row['userphonegsm'];
			$pinbb        = $row['pinbb'];
			$norek        = $row['norek'];
			$status_rumah = $row['status_rumah'];
			$lama_tinggal = $row['lama_tinggal'];
			$pekerjaan    = $row['pekerjaan'];
			$kantor       = $row['kantor'];
			$jabatan      = $row['jabatan'];
			$status_kerja = $row['status_kerja'];
			$masa_kerja   = $row['masa_kerja'];
			$pengeluaran  = $row['pengeluaran'];
			$telp_kantor  = $row['telp_kantor'];
			$status_nikah = $row['marriagestatusid'];

			$nama_sutri        = $row['nama_sutri'];
			$pekerjaan_sutri   = $row['pekerjaan_sutri'];
			$kantor_sutri      = $row['kantor_sutri'];
			$jabatan_sutri     = $row['jabatan_sutri'];
			$telp_kantor_sutri = $row['telp_kantor_sutri'];

			$userdirname      = $row['userdirname'];
			$userpostcode     = $row['userpostcode'];
			$negaraid         = $row['negaraid'];
			$propinsiid       = $row['propinsiid'];
			
			$propinsiid = sql_get_var("select namapropinsi from tbl_propinsi where propid='$propinsiid'");
			$negaraid   = sql_get_var("select namanegara from tbl_negara where id='$negaraid'");
			$alamat11   = "$useraddress $cityname $propinsiid $userpostcode $negaraid";

			if($status_rumah == 1){ $statrmh = "Rumah Pribadi"; }
			elseif($status_rumah == 2){ $statrmh = "Rumah Keluarga"; }
			elseif($status_rumah == 3){ $statrmh = "Rumah Dinas"; }
			elseif($status_rumah == 4){ $statrmh = "Sewa/Kontrak"; }
			elseif($status_rumah == 5){ $statrmh = "Lain-lain"; }

			if($status_nikah == 1){ $statnik = "Belum Menikah"; }
			elseif($status_nikah == 2){ $statnik = "Sudah Menikah"; }
			elseif($status_nikah == 3){ $statnik = "Pernah Menikah (Duda/Janda)"; }
			
			if(!empty($avatar)) $avatar = "$lokasiwebmember/avatars/$avatar";
			?>
            <table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Data Detail</th>
				</tr>
				<tr> 
					<td width="260" valign="top"><table border="0" class="tabel-cms" width="100%">
                    	<tr>
                        	<td >Photo</td>
                      	</tr>
                      	<tr>
                        	<td ><?php 
			                    if(!empty($avatar)) echo "<img src=\"$avatar\" alt=\"\" border=\"0\" />"; 
								else echo "Kosong";
							?></td>
                      	</tr>
                      	<tr>
                        	<td >&nbsp;</td>
                      	</tr>
                    </table></td>
					<td width="auto" valign="top">
                    <table border="0" class="tabel-cms" width="100%">
                      	<tr>
                        	<th colspan="2" align="left">A. Data Pribadi</th>
                      	</tr>
                      	<tr>
                        	<td width="176">Username</td>
                        	<td width="471"><?php echo $username?></td>
                      	</tr>
                      	<tr>
                        	<td width="176">Email</td>
                        	<td width="471"><?php echo $useremail?></td>
                      	</tr>
                      	<tr>
                        <td valign="top">Nama Lengkap</td>
                        	<td align="left"><?php echo $userfullname?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Jenis Kelamin</td>
                        	<td align="left"><?php echo $usergender?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Tempat, Tanggal Lahir</td>
                        	<td align="left"><?php echo $userpob?>, <?php echo $userdob?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Nomor KTP</td>
                        	<td align="left"><?php echo $nomor_ktp?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Alamat Lengkap</td>
                        	<td align="left"><?php echo $alamat11?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Nomor Telepon</td>
                        	<td align="left"><?php echo $userphone?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Nomor Whatsapp</td>
                        	<td align="left"><?php echo $userphonegsm?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Pin BBM</td>
                        	<td align="left"><?php echo $pinbb?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Nomor Rekening Bank</td>
                        	<td align="left"><?php echo $norek?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Status Rumah</td>
                        	<td align="left"><?php echo $statrmh?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Lama Tinggal</td>
                        	<td align="left"><?php echo $lama_tinggal?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Pekerjaan</td>
                        	<td align="left"><?php echo $pekerjaan?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Kantor & Jabatan</td>
                        	<td align="left"><?php echo $kantor?> - <?php echo $jabatan?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Status Pekerja</td>
                        	<td align="left"><?php echo $status_kerja?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Masa Kerja</td>
                        	<td align="left"><?php echo $masa_kerja?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Pengeluaran per bulan</td>
                        	<td align="left"><?php echo $pengeluaran?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Telepon Kantor</td>
                        	<td align="left"><?php echo $telp_kantor?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Status Pernikahan</td>
                        	<td align="left"><?php echo $statnik?></td>
                      	</tr>
                      	<tr>
                        	<th colspan="2" align="left">B. Data Pasangan</th>
                      	</tr>
                      	<tr>
                        	<td width="176">Nama Suami/Istri</td>
                        	<td width="471"><?php echo $nama_sutri?></td>
                      	</tr>
                      	<tr>
                        <td valign="top">Pekerjaan</td>
                        	<td align="left"><?php echo $pekerjaan_sutri?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Kantor & Jabatan</td>
                        	<td align="left"><?php echo $kantor_sutri?> - <?php echo $jabatan_sutri?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Telepon Kantor</td>
                        	<td align="left"><?php echo $telp_kantor_sutri?></td>
                      	</tr>
                    </table>
                    </td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo"$alamat&aksi=edit&userid=$userid";?>'" value="Ubah Data"></td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}

	if($aksi=="popupmngrid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$var1    = $_GET['var1'];
			$var2    = $_GET['var2'];
			
			if(empty($var1) && empty($var2))
			{
				$var1 = "mngrid";
				$var2 = "mngrid_text";
			}
			?>
            	<script type="text/javascript">
				function pushdata(mngrid,namamng)
				{
					 if (window.opener && !window.opener.closed)
					 {
					 	window.opener.$("#<?php echo $var1; ?>").val(mngrid);
						window.opener.$("#<?php echo $var2; ?>").val(namamng);
					 } 
					  window.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("userfullname","Nama Lengkap","str","text","$data");
			$cari[] = array("username","Username","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where']."and tipe='3'";
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from $nama_tabel where 1 $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("userfullname","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select username,userfullname,userid from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=username\" title=\"Urutkan\">Username</a></th>\n");
			print("<th width=60%><a href=\"$urlorder&order=userfullname\" title=\"Urutkan\">Nama Lengkap</a></th>\n");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$username = $row['username'];
				$namamng  = $row['userfullname'];
				$mngrid   = $row['userid'];

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td valign=top class=judul>$username</td>\n
					<td valign=top class=judul>$namamng</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$mngrid','$namamng');\">Select</button>");
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

	//HapusMenu
	if($aksi=="hapus")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		{
			$perintahu 	= "select avatar from $nama_tabel where userid='$userid'";
			$hasilu 	= sql($perintahu);
			$row 		= sql_fetch_data($hasilu);

				$avatar	= $row['avatar'];

				$yearm	= date("Ym");
				if(!empty($avatar))
					unlink("$lokasimember/avatars/$yearm/$avatar");
					unlink("$lokasimember/avatars/$avatar");

			$perintah = "delete from $nama_tabel where userid='$userid'";
			$hasil = sql($perintah);
			
			$perintah = "delete from tbl_domain where userid='$userid'";
			$hasil = sql($perintah);
			
			$perintah = "delete from tbl_transaksi where resellerid='$userid'";
			$hasil = sql($perintah);
			
			$perintah = "delete from tbl_transaksi_detail where resellerid='$userid'";
			$hasil = sql($perintah);
			
			$perintah = "update tbl_blog set userid='0' where userid='$userid'";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus admin dengan ID $menuid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//Publish
	if($aksi=="pilihan")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$userid = $_GET['userid'];
			
			$perintah 	= "select pilihan from $nama_tabel where userid='$userid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['pilihan']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set pilihan='$status' where userid='$userid' ";
			$hasil		= sql($perintah);
		
			if($hasil)
			{   
				$msg = base64_encode("Success merubah status data dengan UserID $userid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//SaveTambahMenu
	if($aksi=="savetambahadmin")
	{
		
		if(!$oto['add']) { echo $error['add']; }
		{
			// $tipe         = $_POST['tipe'];
			$refuserid       = $_POST['refuserid'];
			$username        = $_POST['username'];
			$useremail       = $_POST['useremail'];
			$userpassword    = $_POST['userpassword'];
			// $userpassword = $_POST['userpassword']."jcow";
			$userfullname    = $_POST['userfullname'];
			$usergender      = $_POST['usergender'];
			$userpob         = $_POST['userpob'];
			$userdob         = $_POST['userdob'];
			$nomor_ktp       = $_POST['nomor_ktp'];
			$useraddress     = $_POST['useraddress'];
			$kotaid          = $_POST['kotaid'];
			$cityname        = sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
			$propinsiid      = $_POST['propinsiid'];
			$negaraid        = $_POST['negaraid'];
			$userpostcode    = $_POST['userpostcode'];
			$userphone       = $_POST['userphone'];
			$userphonegsm    = $_POST['userphonegsm'];
			$pinbb           = $_POST['pinbb'];
			$norek           = $_POST['norek'];
			$status_rumah    = $_POST['status_rumah'];
			$lama_tinggal    = $_POST['lama_tinggal'];
			$profesiid       = cleaninsert($_POST['profesiid']);
			$pekerjaan       = sql_get_var("select profesi from tbl_work where id='$profesiid'");
			$kantor          = $_POST['kantor'];
			$jabatan         = $_POST['jabatan'];
			$status_kerja    = $_POST['status_kerja'];
			$masa_kerja      = $_POST['masa_kerja'];
			$pengeluaran     = $_POST['pengeluaran'];
			$telp_kantor     = $_POST['telp_kantor'];
			$status_nikah    = $_POST['status_nikah'];

			$nama_sutri        = $_POST['nama_sutri'];
			$profesiid_sutri    = cleaninsert($_POST['profesiid_sutri']);
			$pekerjaan_sutri    = sql_get_var("select profesi from tbl_work where id='$profesiid_sutri'");
			$kantor_sutri      = $_POST['kantor_sutri'];
			$jabatan_sutri     = $_POST['jabatan_sutri'];
			$telp_kantor_sutri = $_POST['telp_kantor_sutri'];

			$useractivestatus = $_POST['useractivestatus'];
			$userlastloggedin = $_POST['userlastloggedin'];
			$userlastactive   = $_POST['userlastactive'];
			$userstatus       = $_POST['userstatus'];
			$usercreateddate  = $_POST['usercreateddate'];
			
			$cek = sql_get_var("select count(*) as sama from tbl_member where username='$username'");
			if($cek)
			{
				$error = base64_encode("Data tidak dapat dimasukkan, username $username sudah tersedia");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
			else
			{
			
				$baru = newid("userid",$nama_tabel);
				$userpassword = md5($userpassword);
				
				$yearm	= date("Ym");
				$folderalbum = "$lokasimember/avatars/$yearm";
				if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }
				
				$folderalbum2 = "$lokasimember/avatar";
				if(!file_exists($folderalbum2)){	mkdir($folderalbum2,0777); }
				
			
				if($_FILES['gambar']['size']>0)
				{
					$filename	= $_FILES['gambar']['name'];
					$filesize	= $_FILES['gambar']['size'];
					$filetmpname	= $_FILES['gambar']['tmp_name'];
		
					$imageinfo = getimagesize($filetmpname);
					$imagewidth = $imageinfo[0];
					$imageheight = $imageinfo[1];
					$imagetype = $imageinfo[2];
					
					switch($imagetype)
					{
						case 1: $imagetype="gif"; break;
						case 2: $imagetype="jpg"; break;
						case 3: $imagetype="png"; break;
					}
					
					$photofull = "avatar-".$baru."-f.".$imagetype;
					$gambarl = resizeimg($filetmpname,"$folderalbum/$photofull",250,250);
					
					$photolarge = "avatar-".$baru."-l.".$imagetype;
					resizeimg($filetmpname,"$folderalbum/$photolarge",200,200);
					
					$photomedium = "avatar-".$baru."-m.".$imagetype;
					resizeimg($filetmpname,"$folderalbum/$photomedium",150,150);
					
					$photomedium2 = $baru.'.jpg';
					resizeimg($filetmpname,"$folderalbum2/$photomedium2",250,250);
					
					$photosmall = "avatar-".$baru."-s.".$imagetype;
					resizeimg($filetmpname,"$folderalbum/$photosmall",80,80);
					
					if($gambarl){ 
						$avatar1 = ",avatar";
						$avatar = ",'$yearm/$photofull'";
					}
				}
				
				$perintah = "INSERT INTO $nama_tabel (userid,tipe,username,useremail,userpassword,userfullname,usergender,userpob,userdob,nomor_ktp,useraddress,kotaid,cityname,
							propinsiid,negaraid,userpostcode,userphone,userphonegsm,pinbb,norek,status_rumah,lama_tinggal,workid,pekerjaan,kantor,
							jabatan,status_kerja,masa_kerja,pengeluaran,telp_kantor,marriagestatusid,nama_sutri,pekerjaan_sutri,kantor_sutri,jabatan_sutri,telp_kantor_sutri,
							useractivestatus,userlastloggedin,userlastactive,userstatus,usercreateddate $avatar1)
							 
							 VALUES ('$baru','3','$username','$useremail','$userpassword','$userfullname','$usergender','$userpob','$userdob','$nomor_ktp','$useraddress','$kotaid','$cityname',
							 '$propinsiid','$negaraid','$userpostcode','$userphone','$userphonegsm','$pinbb','$norek','$status_rumah','$lama_tinggal','$profesiid','$pekerjaan','$kantor',
							 '$jabatan','$status_kerja','$masa_kerja','$pengeluaran','$telp_kantor','$status_nikah','$nama_sutri','$pekerjaan_sutri','$kantor_sutri','$jabatan_sutri','$telp_kantor_sutri',
							 '1','$userlastloggedin','$userlastactive','$userstatus','$date' $avatar)";//refuserid,,'$refuserid'
				$hasil = sql($perintah);
				
		
				if($hasil)
				{   
					$query=("insert into tbl_member_stats (userid,login) values ('$baru','0')");
					$hasil = sql($query);

					$newdomainid    = newid("domainid","tbl_domain");
					$namadomain     = $username.".sygmadayainsani.co.id";
					// $aliasdomain    = getalias($namadomain);
					$tanggalbuatnya = date("Y-m-d H:i:s");
					$perintah6      = "insert into tbl_domain(domainid,jenisdomain,namadomain,userid,aliasdomain,title,webtitle,webdesc,tagline,webmeta,templateId,cleanurl,tanggalbuat) 
									values ('$newdomainid','subdomain','$namadomain','$baru','$namadomain','Sygma Online Reseller','SDI Landing Page','SDI Landing Page','SDI Landing Page','SDI Landing Page','1','index.php/','$tanggalbuatnya')";
					$hasil6      = sql($perintah6);
					
					$msg = base64_encode("Berhasil ditambahkan Member baru dengan username = $username");
					header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
					exit();
				}
				else
					$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
					header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
					exit();
				}
			}
	}
	
	//TambahMenu
	if($aksi=="tambahadmin")
	{
		if(!$oto['add']) { echo $error['add']; }
		{
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			?>
            <script src="librari/ajax/ajax_kota.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
				$( "#userdob" ).datepicker({
				  // showOn: "button",
				  frontendOn: "button",
				  buttonImage: "template/images/calendar.gif",
				  buttonImageOnly: true
				});
			  });
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahadmin">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Member</th>
				</tr>
				<tr>
					<th colspan="2">A. Data Pribadi</th>
				</tr>
                <tr> 
					<td width="176">Username</td>
					<td width="471"><input name="username" type="text" size="20" value="" id="username" class="validate[required,custom[onlyLetter],minSize[3]]" /></td>
				</tr>
                <tr> 
					<td width="176">UserPassword</td>
					<td width="471"><input name="userpassword" type="text" size="20" value="" id="userpassword" class="validate[required,minSize[6]]" /></td>
				</tr>
                <tr> 
					<td valign="top">Email Address</td>
					<td align="left"><input name="useremail" type="text"  size="40"  value=""  id="useremail" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">Nama Lengkap</td>
					<td align="left"><input name="userfullname" type="text" size="40" value="" id="userfullname" class="validate[required]" /><br><i>Nama Lengkap di isi sesuai Nama Lengkap yang tercantum pada KTP anda.</i></td>
				</tr>
                <tr> 
					<td valign="top">Jenis Kelamin</td>
					<td align="left">
						<select id="usergender" name="usergender" class="validate[required]">
	    					<option value="">-- Pilih --</option>
	                        <option value="laki-laki">Laki-laki</option>
	                        <option value="perempuan">Perempuan</option>
	                     </select>
                   </td>
				</tr>
                <tr> 
					<td valign="top">Tempat Lahir</td>
					<td align="left"><input name="userpob" type="text" size="40" value="" id="userpob" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td valign="top">Tanggal Lahir</td>
					<td align="left"><input name="userdob" type="text" size="40" value="" id="userdob" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Nomor KTP</td>
					<td align="left"><input name="nomor_ktp" type="text" size="40" value="" id="nomor_ktp" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td valign="top">Alamat Rumah</td>
					<td align="left"><input name="useraddress" type="text"  size="60"  value=""  id="useraddress" /></td>
				</tr>
                <tr> 
					<td valign="top">Negara</td>
					<td align="left">
                    <select id="negaraid" name="negaraid">
                        <option value="">-- Pilih --</option>
                        <?php 
                        $select = sql("select id,namanegara from tbl_negara order by namanegara");
                        while($dt= sql_fetch_data($select))
                        {
                            $negaraid = $dt['id'];
                            $negara = $dt['namanegara'];
                            
                            echo "<option value=\"$negaraid\">$negara</option>";
                        } 
                        ?>
                 	</select>
                  </td>
				</tr>
                <tr> 
					<td valign="top">Propinsi</td>
					<td align="left">
                    <select id="propinsiid" name="propinsiid" onChange="getKota(this.value);">
                        <option value="">-- Pilih --</option>
                        <?php 
                        $select = sql("select propid,namapropinsi from tbl_propinsi order by namapropinsi");
                        while($dt= sql_fetch_data($select))
                        {
                            $propinsiid = $dt['propid'];
                            $namapropinsi = $dt['namapropinsi'];
                            
                            echo "<option value=\"$propinsiid\">$namapropinsi</option>";
                        } 
                        ?>
                 	</select>
                  </td>
				</tr>
                <tr> 
					<td valign="top">Kota</td>
					<td align="left">
						<select id="kotaId2" name="kotaid">
	                        <option value="">-- Pilih Kota --</option>
	                        <?php 
	                        $select = sql("select kotaid,namakota from tbl_kota order by namakota");
	                        while($dt= sql_fetch_data($select))
	                        {
	                            $kotaid2  = $dt['kotaid'];
	                            $namakota = $dt['namakota'];
	                            
	                            echo "<option value=\"$kotaid2\">$namakota</option>";
	                        } 
	                        ?>
	                 	</select>
					</td>
				</tr>
                <tr> 
					<td valign="top">Kodepos</td>
					<td align="left"><input name="userpostcode" type="text"  size="60"  value=""  id="userpostcode" /></td>
				</tr>
				<tr> 
					<td valign="top">Nomor Telepon</td>
					<td align="left"><input name="userphone" type="text"  size="60"  value=""  id="userphone" class=""/><br> <i>Contoh : +6222 664 1234</i></td>
				</tr>
                <tr> 
					<td valign="top">Nomor Whatsapp</td>
					<td align="left"><input name="userphonegsm" type="text"  size="60"  value=""  id="userphonegsm" class=""/><br><i>Contoh : 08123456789</i></td>
				</tr>
                <tr> 
					<td valign="top">Pin BBM</td>
					<td align="left"><input name="pinbb" type="text"  size="35"  value=""  id="pinbb" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Nomor Rekening Bank</td>
					<td align="left"><input name="norek" type="text"  size="60"  value=""  id="norek" class=""/></td>
				</tr>
                 <tr> 
					<td valign="top">Status Rumah</td>
					<td align="left">
                      <select name="status_rumah">
                        <option value="" selected>-- Pilih Status Rumah --</option>
                        <option value="1">Rumah Pribadi</option>
                        <option value="2">Rumah Keluarga</option>
                        <option value="3">Rumah Dinas</option>
                        <option value="4">Sewa/Kontrak</option>
                        <option value="5">Lain-lain</option>
                      </select>
                   </td>
				</tr>
                <tr> 
					<td valign="top">Lama Tinggal</td>
					<td align="left"><input name="lama_tinggal" type="text"  size="60"  value=""  id="lama_tinggal" class=""/></td>
				</tr>
                 <tr> 
					<td valign="top">Pekerjaan</td>
					<td align="left">
                    <select id="pekerjaan" name="profesiid">
                        <option value="">-- Pilih Pekerjaan --</option>
                        <?php 
                        $select = sql("select id,profesi from tbl_work order by id asc");
                        while($dt= sql_fetch_data($select))
                        {
                            $dprofesi = $dt['id'];
                            $profesi  = $dt['profesi'];
                            
                            echo "<option value=\"$dprofesi\">$profesi</option>";
                        } 
                        ?>
                 	</select>
                 	</td>
				</tr>
                <tr> 
					<td valign="top">Kantor</td>
					<td align="left"><input name="kantor" type="text"  size="60"  value=""  id="kantor" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Jabatan</td>
					<td align="left"><input name="jabatan" type="text"  size="60"  value=""  id="jabatan" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Status Pekerja</td>
					<td align="left"><input name="status_kerja" type="text"  size="60"  value=""  id="status_kerja" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Masa Kerja</td>
					<td align="left"><input name="masa_kerja" type="text"  size="60"  value=""  id="masa_kerja" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Pengeluaran per bulan</td>
					<td align="left"><input name="pengeluaran" type="text"  size="60"  value=""  id="pengeluaran" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Telepon Kantor</td>
					<td align="left"><input name="telp_kantor" type="text"  size="60"  value=""  id="telp_kantor" class=""/><br> <i>Contoh : +6222 664 1234</i></td>
				</tr>
                <tr> 
					<td valign="top">Status Pernikahan</td>
					<td align="left">
                      <select name="status_nikah">
                        <option value="" selected>-- Pilih Status Pernikahan --</option>
                        <option value="1">Belum Menikah</option>
                        <option value="2">Sudah Menikah</option>
                        <option value="3">Pernah Menikah (Duda/Janda)</option>
                      </select>
                   </td>
				</tr>
                <tr> 
					<td >Photo</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /></td>
				</tr>
				<tr>
					<th colspan="2">B. Data Pasangan</th>
				</tr>
				<tr> 
					<td valign="top">Nama Suami/Istri</td>
					<td align="left"><input name="nama_sutri" type="text" size="40" value="" id="nama_sutri" /></td>
				</tr>
                 <tr> 
					<td valign="top">Pekerjaan</td>
					<td align="left">
                    <select id="pekerjaan_sutri" name="profesiid_sutri">
                        <option value="">-- Pilih Pekerjaan --</option>
                        <?php 
                        $select = sql("select id,profesi from tbl_work order by id asc");
                        while($dt= sql_fetch_data($select))
                        {
                            $dprofesi = $dt['id'];
                            $profesi  = $dt['profesi'];
                            
                            echo "<option value=\"$dprofesi\">$profesi</option>";
                        } 
                        ?>
                 	</select>
                 	</td>
				</tr>
                <tr> 
					<td valign="top">Kantor</td>
					<td align="left"><input name="kantor_sutri" type="text"  size="60"  value=""  id="kantor_sutri" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Jabatan</td>
					<td align="left"><input name="jabatan_sutri" type="text"  size="60"  value=""  id="jabatan_sutri" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Telepon Kantor</td>
					<td align="left"><input name="telp_kantor_sutri" type="text"  size="60"  value=""  id="telp_kantor_sutri" class=""/></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Member" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveTambahMenu
	if($aksi=="saveeditadmin")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		{
			$userid          = $_POST['userid'];
			$refuserid       = $_POST['refuserid'];
			$userpassword    = $_POST['userpassword'];
			$userfullname    = $_POST['userfullname'];
			$usergender      = $_POST['usergender'];
			$userpob         = $_POST['userpob'];
			$userdob         = $_POST['userdob'];
			$nomor_ktp       = $_POST['nomor_ktp'];
			$useraddress     = $_POST['useraddress'];
			$kotaid          = $_POST['kotaid'];
			$cityname        = sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
			$propinsiid      = $_POST['propinsiid'];
			$negaraid        = $_POST['negaraid'];
			$userpostcode    = $_POST['userpostcode'];
			$userphone       = $_POST['userphone'];
			$userphonegsm    = $_POST['userphonegsm'];
			$pinbb           = $_POST['pinbb'];
			$norek           = $_POST['norek'];
			$status_rumah    = $_POST['status_rumah'];
			$lama_tinggal    = $_POST['lama_tinggal'];
			$profesiid       = cleaninsert($_POST['profesiid']);
			$pekerjaan       = sql_get_var("select profesi from tbl_work where id='$profesiid'");
			$kantor          = $_POST['kantor'];
			$jabatan         = $_POST['jabatan'];
			$status_kerja    = $_POST['status_kerja'];
			$masa_kerja      = $_POST['masa_kerja'];
			$pengeluaran     = $_POST['pengeluaran'];
			$telp_kantor     = $_POST['telp_kantor'];
			$status_nikah    = $_POST['status_nikah'];

			$nama_sutri        = $_POST['nama_sutri'];
			$profesiid_sutri   = cleaninsert($_POST['profesiid_sutri']);
			$pekerjaan_sutri   = sql_get_var("select profesi from tbl_work where id='$profesiid_sutri'");
			$kantor_sutri      = $_POST['kantor_sutri'];
			$jabatan_sutri     = $_POST['jabatan_sutri'];
			$telp_kantor_sutri = $_POST['telp_kantor_sutri'];

			$useractivestatus = $_POST['useractivestatus'];
			$userlastloggedin = $_POST['userlastloggedin'];
			$userlastactive   = $_POST['userlastactive'];
			$userstatus       = $_POST['userstatus'];
			$usercreateddate  = $_POST['usercreateddate'];
			
			$yearm	= date("Ym");
			$folderalbum = "$lokasimember/avatars/$yearm";
			if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }
			
			$folderalbum2 = "$lokasimember/avatar";
			if(!file_exists($folderalbum2)){	mkdir($folderalbum2,0777); }
			
		
			if($_FILES['gambar']['size']>0)
			{
				$filename	= $_FILES['gambar']['name'];
				$filesize	= $_FILES['gambar']['size'];
				$filetmpname	= $_FILES['gambar']['tmp_name'];
	
				$imageinfo = getimagesize($filetmpname);
				$imagewidth = $imageinfo[0];
				$imageheight = $imageinfo[1];
				$imagetype = $imageinfo[2];
				
				switch($imagetype)
				{
					case 1: $imagetype="gif"; break;
					case 2: $imagetype="jpg"; break;
					case 3: $imagetype="png"; break;
				}
				
				$photofull = "avatar-".$userid."-f.".$imagetype;
				$gambarl = resizeimg($filetmpname,"$folderalbum/$photofull",250,250);
				
				
				$photolarge = "avatar-".$userid."-l.".$imagetype;
				resizeimg($filetmpname,"$folderalbum/$photolarge",200,200);
				
				$photomedium = "avatar-".$userid."-m.".$imagetype;
				resizeimg($filetmpname,"$folderalbum/$photomedium",150,150);
				
				$photomedium2 = $userid.'.jpg';
				resizeimg($filetmpname,"$folderalbum2/$photomedium2",250,250);
				
				$photosmall = "avatar-".$userid."-s.".$imagetype;
				resizeimg($filetmpname,"$folderalbum/$photosmall",80,80);
				
				if(file_exists("$folderalbum/$photomedium")){ 
					$avatar = ",avatar='$yearm/$photofull'";
				}
			}
			
			
			$perintah = "update $nama_tabel set tipe='3',userfullname='$userfullname',usergender='$usergender',userpob='$userpob',userdob='$userdob',
						nomor_ktp='$nomor_ktp',useraddress='$useraddress',kotaid='$kotaid',cityname='$cityname',propinsiid='$propinsiid',negaraid='$negaraid',
						userpostcode='$userpostcode',userphone='$userphone',userphonegsm='$userphonegsm',pinbb='$pinbb',norek='$norek',status_rumah='$status_rumah',
						lama_tinggal='$lama_tinggal',workid='$profesiid',pekerjaan='$pekerjaan',kantor='$kantor',jabatan='$jabatan',status_kerja='$status_kerja',masa_kerja='$masa_kerja',
						pengeluaran='$pengeluaran',marriagestatusid='$status_nikah',telp_kantor='$telp_kantor',nama_sutri='$nama_sutri',pekerjaan_sutri='$pekerjaan_sutri',kantor_sutri='$kantor_sutri',
						jabatan_sutri='$jabatan_sutri',telp_kantor_sutri='$telp_kantor_sutri',useractivestatus='1',userlastloggedin='$userlastloggedin',
						userlastactive='$userlastactive',userstatus='$userstatus' $avatar where userid='$userid'";//,refuserid='$refuserid'
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah Data Member dengan username = $username");
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
		if(!$oto['edit']) { echo $error['edit']; }
		{
			$userid = $_GET['userid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select * from $nama_tabel  where userid='$userid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

		      $userid 		= $row['userid'];
		      $refuserid 	= $row['refuserid'];
			  $tipe 		= $row['tipe'];
		      $avatar       = $row['avatar'];
		      $username     = $row['username'];
		      $useremail    = $row['useremail'];
		      $userfullname = $row['userfullname'];
		      $usergender   = $row['usergender'];
		      $userpob      = $row['userpob'];
		      $userdob      = $row['userdob'];
		      $nomor_ktp    = $row['nomor_ktp'];
		      $useraddress  = $row['useraddress'];
		      $kotaid       = $row['kotaid'];
		      $cityname     = $row['cityname'];
		      $userphone    = $row['userphone'];
		      $userphonegsm = $row['userphonegsm'];
		      $pinbb        = $row['pinbb'];
		      $norek        = $row['norek'];
		      $status_rumah = $row['status_rumah'];
		      $lama_tinggal = $row['lama_tinggal'];
			  $profesiid    = $row['workid'];
		      $pekerjaan    = $row['pekerjaan'];
		      $kantor       = $row['kantor'];
		      $jabatan      = $row['jabatan'];
		      $status_kerja = $row['status_kerja'];
		      $masa_kerja   = $row['masa_kerja'];
		      $pengeluaran  = $row['pengeluaran'];
		      $telp_kantor  = $row['telp_kantor'];
			  $status_nikah = $row['marriagestatusid'];

		      $nama_sutri        = $row['nama_sutri'];
		      $pekerjaan_sutri   = $row['pekerjaan_sutri'];
		      $kantor_sutri      = $row['kantor_sutri'];
		      $jabatan_sutri     = $row['jabatan_sutri'];
		      $telp_kantor_sutri = $row['telp_kantor_sutri'];

		      $userdirname      = $row['userdirname'];
		      $userpostcode     = $row['userpostcode'];
		      $negaraid         = $row['negaraid'];
		      $propinsiid       = $row['propinsiid'];

			// Nama Ref Reseller
			$namarefuser = sql_get_var("select userfullname from tbl_member where userid='$refuserid'");
		      
		      if(!empty($avatar)) $avatar = "$lokasiwebmember/avatars/$avatar";
			
			?>
            <script src="librari/ajax/ajax_kota.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
				$( "#userdob" ).datepicker({
				  frontendOn: "button",
				  buttonImage: "template/images/calendar.gif",
				  buttonImageOnly: true
				});
			  });
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditadmin">
            <input type="hidden" name="userid" value="<?php echo $userid?>">
            <input name="username" type="hidden" value="<?php echo $username?>" />
            <table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Ubah Data Member</th>
				</tr>
				<tr>
					<th colspan="2">A. Data Pribadi</th>
				</tr>
                <tr> 
					<td width="176">Username</td>
					<td width="471"><input name="username" type="text" size="20" value="<?php echo $username?>" id="username" class="validate[required,custom[onlyLetter],minSize[3]]" disabled/></td>
				</tr>
				<tr> 
					<td valign="top">Nama Lengkap</td>
					<td align="left"><input name="userfullname" type="text" size="40" value="<?php echo $userfullname?>" id="userfullname" class="validate[required]" /><br><i>Nama Lengkap di isi sesuai Nama Lengkap yang tercantum pada KTP anda.</i></td>
				</tr>
                <tr> 
					<td valign="top">Jenis Kelamin</td>
					<td align="left">
						<select id="usergender" name="usergender" class="validate[required]">
	    					<option value="">-- Pilih --</option>
	                        <option value="laki-laki" <?php if($usergender=="laki-laki"){ ?> selected="selected" <?php } ?>>Laki-laki</option>
	                        <option value="perempuan" <?php if($usergender=="perempuan"){ ?> selected="selected" <?php } ?>>Perempuan</option>
	                     </select>
                   </td>
				</tr>
                <tr> 
					<td valign="top">Tempat Lahir</td>
					<td align="left"><input name="userpob" type="text" size="40" value="<?php echo $userpob?>" id="userpob" /></td>
				</tr>
                <tr> 
					<td valign="top">Tanggal Lahir</td>
					<td align="left"><input name="userdob" type="text" size="40" value="<?php echo $userdob?>" id="userdob" /></td>
				</tr>
				<tr> 
					<td valign="top">Nomor KTP</td>
					<td align="left"><input name="nomor_ktp" type="text" size="40" value="<?php echo $nomor_ktp?>" id="nomor_ktp" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td valign="top">Alamat Rumah</td>
					<td align="left"><input name="useraddress" type="text"  size="60"  value="<?php echo $useraddress?>"  id="useraddress" /></td>
				</tr>
                <tr> 
					<td valign="top">Negara</td>
					<td align="left">
                    <select id="negaraid" name="negaraid">
                        <option value="">-- Pilih Negara --</option>
                        <?php 
                        $select = sql("select id,namanegara from tbl_negara order by namanegara");
                        while($dt= sql_fetch_data($select))
                        {
                            $negaraids = $dt['id'];
                            $negara    = $dt['namanegara'];
                            
                            echo "<option value=\"$negaraid\""; if($negaraid==$negaraids){ echo"selected=\"selected\""; } echo">$negara</option>";
                        } 
                        ?>
                 	</select>
                  </td>
				</tr>
                <tr> 
					<td valign="top">Propinsi</td>
					<td align="left">
                    <select id="propinsiid" name="propinsiid" onChange="getKota(this.value);">
                        <option value="">-- Pilih Propinsi --</option>
                        <?php 
                        $select = sql("select propid,namapropinsi from tbl_propinsi order by namapropinsi");
                        while($dt= sql_fetch_data($select))
                        {
                            $propinsiids  = $dt['propid'];
                            $namapropinsi = $dt['namapropinsi'];
                            
                            echo "<option value=\"$propinsiids\""; if($propinsiid==$propinsiids){ echo"selected=\"selected\""; } echo">$namapropinsi</option>";
                        } 
                        ?>
                 	</select>
                  </td>
				</tr>
                <tr> 
					<td valign="top">Kota</td>
					<td align="left">
						<!-- <input name="cityname" type="text"  size="60"  value=""  id="cityname" /> -->
						<select id="kotaId2" name="kotaid">
	                        <option value="">-- Pilih Kota --</option>
	                        <?php 
	                        $select = sql("select kotaid,namakota from tbl_kota where propid='$propinsiid' order by namakota");
	                        while($dt= sql_fetch_data($select))
	                        {
	                            $kotaid1  = $dt['kotaid'];
	                            $namakota = $dt['namakota'];
	                            
	                            echo "<option value=\"$kotaid1\""; if($kotaid==$kotaid1){ echo"selected=\"selected\""; } echo">$namakota</option>";
	                        } 
	                        ?>
	                 	</select>
					</td>
				</tr>
                <tr> 
					<td valign="top">Kodepos</td>
					<td align="left"><input name="userpostcode" type="text"  size="60"  value="<?php echo $userpostcode?>"  id="userpostcode" /></td>
				</tr>
				<tr> 
					<td valign="top">Nomor Telepon</td>
					<td align="left"><input name="userphone" type="text"  size="60"  value="<?php echo $userphone?>"  id="userphone" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Nomor Whatsapp</td>
					<td align="left"><input name="userphonegsm" type="text"  size="60"  value="<?php echo $userphonegsm?>"  id="userphonegsm" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Pin BBM</td>
					<td align="left"><input name="pinbb" type="text"  size="35"  value="<?php echo $pinbb?>"  id="pinbb" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Nomor Rekening Bank</td>
					<td align="left"><input name="norek" type="text"  size="60"  value="<?php echo $norek?>"  id="norek" class=""/></td>
				</tr>
                 <tr> 
					<td valign="top">Status Rumah</td>
					<td align="left">
                      <select name="status_rumah">
                        <option value="" selected>-- Pilih Status Rumah --</option>
                        <option value="1" <?php if($status_rumah=="1"){ ?> selected="selected" <?php } ?>>Rumah Pribadi</option>
                        <option value="2" <?php if($status_rumah=="2"){ ?> selected="selected" <?php } ?>>Rumah Keluarga</option>
                        <option value="3" <?php if($status_rumah=="3"){ ?> selected="selected" <?php } ?>>Rumah Dinas</option>
                        <option value="4" <?php if($status_rumah=="4"){ ?> selected="selected" <?php } ?>>Sewa/Kontrak</option>
                        <option value="5" <?php if($status_rumah=="5"){ ?> selected="selected" <?php } ?>>Lain-lain</option>
                      </select>
                    </td>
				</tr>
                <tr> 
					<td valign="top">Lama Tinggal</td>
					<td align="left"><input name="lama_tinggal" type="text"  size="60"  value="<?php echo $lama_tinggal?>"  id="lama_tinggal" class=""/></td>
				</tr>
                 <tr> 
					<td valign="top">Pekerjaan</td>
					<td align="left">
                    <select id="pekerjaan" name="profesiid">
                        <option value="">-- Pilih Pekerjaan --</option>
                        <?php 
                        $select = sql("select id,profesi from tbl_work order by id asc");
                        while($dt= sql_fetch_data($select))
                        {
                            $dprofesi = $dt['id'];
                            $profesi  = $dt['profesi'];
                            
                            echo "<option value=\"$dprofesi\""; if($profesiid==$dprofesi){ echo "selected=\"selected\""; } echo">$profesi</option>";
                        } 
                        ?>
                 	</select>
					</td>
				</tr>
                <tr> 
					<td valign="top">Kantor</td>
					<td align="left"><input name="kantor" type="text"  size="60"  value="<?php echo $kantor?>"  id="kantor" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Jabatan</td>
					<td align="left"><input name="jabatan" type="text"  size="60"  value="<?php echo $jabatan?>"  id="jabatan" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Status Pekerja</td>
					<td align="left"><input name="status_kerja" type="text"  size="60"  value="<?php echo $status_kerja?>"  id="status_kerja" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Masa Kerja</td>
					<td align="left"><input name="masa_kerja" type="text"  size="60"  value="<?php echo $masa_kerja?>"  id="masa_kerja" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Pengeluaran per bulan</td>
					<td align="left"><input name="pengeluaran" type="text"  size="60"  value="<?php echo $pengeluaran?>"  id="pengeluaran" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Telepon Kantor</td>
					<td align="left"><input name="telp_kantor" type="text"  size="60"  value="<?php echo $telp_kantor?>"  id="telp_kantor" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Status Pernikahan</td>
					<td align="left">
                      <select name="status_nikah">
                        <option value="" selected>-- Pilih Status Pernikahan --</option>
                        <option value="1" <?php if($status_nikah=="1"){ ?> selected="selected" <?php } ?>>Belum Menikah</option>
                        <option value="2" <?php if($status_nikah=="2"){ ?> selected="selected" <?php } ?>>Sudah Menikah</option>
                        <option value="3" <?php if($status_nikah=="3"){ ?> selected="selected" <?php } ?>>Pernah Menikah (Duda/Janda)</option>
                      </select>
                   </td>
				</tr>
                <tr> 
					<td >Photo</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /></td>
				</tr>
				<tr>
					<th colspan="2">B. Data Pasangan</th>
				</tr>
				<tr> 
					<td valign="top">Nama Suami/Istri</td>
					<td align="left"><input name="nama_sutri" type="text" size="40" value="<?php echo $nama_sutri?>" id="nama_sutri" class="validate[required]" /></td>
				</tr>
                 <tr> 
					<td valign="top">Pekerjaan</td>
					<td align="left">
                    <select id="pekerjaan" name="profesiid_sutri">
                        <option value="">-- Pilih Pekerjaan --</option>
                        <?php 
                        $select = sql("select id,profesi from tbl_work order by id asc");
                        while($dt= sql_fetch_data($select))
                        {
                            $dprofesi = $dt['id'];
                            $profesi  = $dt['profesi'];
                            
                            echo "<option value=\"$dprofesi\""; if($pekerjaan_sutri==$profesi){ echo "selected=\"selected\""; } echo">$profesi</option>";
                        } 
                        ?>
                 	</select>
                 	</td>
				</tr>
                <tr> 
					<td valign="top">Kantor</td>
					<td align="left"><input name="kantor_sutri" type="text"  size="60"  value="<?php echo $kantor_sutri?>"  id="kantor_sutri" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Jabatan</td>
					<td align="left"><input name="jabatan_sutri" type="text"  size="60"  value="<?php echo $jabatan_sutri?>"  id="jabatan_sutri" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Telepon Kantor</td>
					<td align="left"><input name="telp_kantor_sutri" type="text"  size="60"  value="<?php echo $telp_kantor_sutri?>"  id="telp_kantor_sutri" class=""/></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Member" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveUbahPassword
	if($aksi=="saveubahpassword")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		{
			$userid = $_POST['userid'];
			$userpassword = $_POST['userpassword'];
			$userpassword = md5($userpassword);
			
			$perintah = "update $nama_tabel set userpassword='$userpassword' where userid='$userid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Perubahan Password berhasil dilakukan");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Password gagal dirubah dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//EditMenu
	if($aksi=="ubahpassword")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		{
			$userid = $_GET['userid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$username = sql_get_var("select username from $nama_tabel where userid='$userid'");
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveubahpassword">
            <input type="hidden" name="userid" value="<?php echo $userid?>">
            <table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Ubah Password</th>
				</tr>
				<tr> 
					<td width="176">Username</td>
					<td width="471"><input name="username" type="text" size="20" value="<?php echo $username?>" id="username" readonly="readonly" /></td>
				</tr>
				<tr> 
					<td valign="top">Password Baru</td>
					<td align="left"><input name="userpassword" type="text" size="40" value="" id="userpassword" class="validate[[required],minSize[6]]" /></td>
				</tr>
                <tr> 
					<td valign="top">Ketik UlanngPassword Baru</td>
					<td align="left"><input name="userpassword2" type="text" size="40" value="" id="userpassword2" class="validate[[required],equals[userpassword]]" /></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Perubahan" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveCID
	if($aksi=="saveeditcid")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		{
			$userid = $_POST['userid'];
			$cidnya = $_POST['cidnya'];
			
			$perintah = "update $nama_tabel set cid='$cidnya' where userid='$userid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Perubahan CID berhasil dilakukan");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("CID gagal dirubah dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//EditMenu
	if($aksi=="editcid")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		{
			$userid = $_GET['userid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$username = sql_get_var("select username from $nama_tabel where userid='$userid'");
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveeditcid">
            <input type="hidden" name="userid" value="<?php echo $userid?>">
            <table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Ubah CID</th>
				</tr>
				<tr> 
					<td width="176">Username</td>
					<td width="471"><input name="username" type="text" size="20" value="<?php echo $username?>" id="username" disabled="disabled" /></td>
				</tr>
				<tr> 
					<td valign="top">CID</td>
					<td align="left"><input name="cidnya" type="text" size="20" value="" id="cidnya" class="validate[[required],minSize[6]]" /></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Perubahan" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SAVE STATUS
	if($aksi=="saveeditstatus")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		{
			$userid = $_POST['userid'];
			$status = $_POST['status'];

				$perintah	="select userid,userfullname,avatar,posting,follower,following,tema,usergender,useraddress,cityname,useremail,userphonegsm from tbl_member where userid='$userid' limit 1";
				$hasil= sql($perintah);
				$profil= sql_fetch_data($hasil);
				sql_free_result($hasil);
				
				$iduser           = $profil['userid'];
				$contactname      = $profil['userfullname'];
				$avatar           = $profil['avatar'];
				$contactuseremail = $profil['useremail'];
				$contactuserphone = $profil['userphonegsm'];

			if($status == 3 || $status == 4)
			{
				$perintah = "update $nama_tabel set verified='$status',useractivestatus='0' where userid='$userid'";
				$hasil = sql($perintah);
			}
			elseif ($status == 1) 
			{
				$perintah = "update $nama_tabel set verified='$status',useractivestatus='1' where userid='$userid'";
				$hasil = sql($perintah);
			}
			elseif ($status == 2) 
			{
				$perintah = "update $nama_tabel set verified='$status',useractivestatus='1' where userid='$userid'";
				$hasil = sql($perintah);
				
				//Email
				$subject = "Akun Anda di Sygma Online Store Sudah Diverifikasi";
				$message = "Hai $contactname, saat ini akun Sygma Online Store Anda telah diverifikasi oleh kami dan sekarang anda sudah dapat login ke $fulldomain/member";
				
				sendmail($contactname,$contactuseremail,$subject,$message,emailhtml($message));
				kirimSMS($contactuserphone,$message);
			}
			else
			{
				$perintah = "update $nama_tabel set verified='$status',useractivestatus='1' where userid='$userid'";
				$hasil = sql($perintah);
			}
			
			if($hasil)
			{   
				$msg = base64_encode("Perubahan Status berhasil dilakukan");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Status gagal dirubah dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}
	
	//EDIT STATUS
	if($aksi=="editstatus")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		{
			$userid = $_GET['userid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$verified = sql_get_var("select verified from $nama_tabel where userid='$userid'");
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveeditstatus">
            <input type="hidden" name="userid" value="<?php echo $userid?>">
            <table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Status</th>
				</tr>
                <tr> 
					<td width="176">Status</td>
					<td width="471">
                    	<select name="status">
                        	<option value="">Pilih Status</option>
                        	<option value="0" <?php if($verified=="0") echo "selected"; ?>>Pending</option>
                            <option value="1" <?php if($verified=="1") echo "selected"; ?>>Billed</option>
                            <option value="2" <?php if($verified=="2") echo "selected"; ?>>Verified</option>
                            <option value="3" <?php if($verified=="3") echo "selected"; ?>>Expired</option>
                            <option value="4" <?php if($verified=="4") echo "selected"; ?>>Decline</option>
                        </select>
                   	</td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Perubahan" />
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