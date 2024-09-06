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
			$cari[] = array("username","Username","str","text","$data");
			$cari[] = array("userfullname","Nama Lengkap","str","text","$data");
			$cari[] = array("useremail","Email","str","text","$data");
			$cari[] = array("userphonegsm","Handphone","str","text","$data");
			
			$dataselect[] = array("1","Aktif");
			$dataselect[] = array("0","Non Aktif");
			
			$cari[] = array("userstatus","Status","select","select",$dataselect);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("userid","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel where tipe='0' $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select userid,username,tipe,userfullname,useremail,verified,pilihan,avatar from $nama_tabel  where tipe='0' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=1%>Nomor</th>\n");
			// print("<th width=20%>Avatar</th>\n");
			print("<th width=25%><a href=\"$urlorder&order=userfullname\" title=\"Urutkan\">Nama Lengkap</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=username\" title=\"Urutkan\">Username</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=useremail\" title=\"Urutkan\">Email</a></th>");
			// print("<th width=10%><a href=\"$urlorder&order=tipe\" title=\"Urutkan\">Tipe</a></th>");
			// print("<th width=10%><a href=\"$urlorder&order=pilihan\" title=\"Urutkan\">Pilihan</a></th>");
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
				$pilihan      = $row['pilihan'];
				$avatar       = $row['avatar'];
				$verified     = $row['verified'];
				
				if($tipe=="0") $tipe = "Member";
				elseif($tipe=="1") $tipe = "Reseller";
				
					
				if($pilihan == 0)
					$status = "<img src='./template/images/publish_r.png'>";
				elseif($pilihan == 1)
					$status = "<img src='./template/images/publish_g.png'>";
				
				if($verified == 0)
					$verified = "<img src='./template/images/publish_r.png'>";
				elseif($verified == 1)
					$verified = "<img src='./template/images/publish_g.png'>";
					
				if(!empty($avatar)) $avatar = "<img src='$lokasiwebmember/avatars/$avatar' style='width:80px'>";
				
			
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top><b>$userfullname</b></td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=detail&userid=$userid\"><b>$username</b></a></td>\n");
					// <td width=10% height=20 valign=top>$avatar</td>
				print("<td valign=top class=hitam>$useremail</td>\n");
				// print("<td valign=top class=hitam>$tipe</td>\n");
				// print("<td align=center><a href=\"$alamat&aksi=pilihan&userid=$userid\">$status</a></td>");
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&userid=$userid&hlm=$hlm");
				$acc[] = array("Ganti Password","ganti-password","$alamat&aksi=ubahpassword&userid=$userid&hlm=$hlm");
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
			$refuserid    = $row['refuserid'];
			$avatar       = $row['avatar'];
			$username     = $row['username'];
			$useremail    = $row['useremail'];
			$userfullname = $row['userfullname'];
			$usergender   = $row['usergender'];
			$userdob      = tanggaltok($row['userdob']);
			$nomor_ktp    = $row['nomor_ktp'];
			$useraddress  = $row['useraddress'];
			$cityname     = $row['cityname'];
			$userphone    = $row['userphone'];
			$userphonegsm = $row['userphonegsm'];

			$userdirname      = $row['userdirname'];
			$userpostcode     = $row['userpostcode'];
			$negaraid         = $row['negaraid'];
			$propinsiid       = $row['propinsiid'];
			
			$propinsiid = sql_get_var("select namapropinsi from tbl_propinsi where propid='$propinsiid'");
			$negaraid   = sql_get_var("select namanegara from tbl_negara where id='$negaraid'");
			if(!empty($avatar)) $avatar = "$lokasiwebmember/avatars/$avatar";
			$alamat11 = $useraddress.", ".$cityname.", ".$propinsiid.", ".$negaraid;
			?>
            <table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Data Detail</th>
				</tr>
				<tr> 
					<!--<td width="260" valign="top"><table border="0" class="tabel-cms" width="100%">
                    	<tr>
                        	<td >Photo</td>
                      	</tr>
                      	<tr>
                        	<td ><?php 
			                    /*if(!empty($avatar)) echo "<img src=\"$avatar\" alt=\"\" border=\"0\" />"; 
								else echo "Kosong";*/
							?><!--</td>
                      	</tr>
                      	<tr>
                        	<td >&nbsp;</td>
                      	</tr>
                    </table></td>
					<td width="auto" valign="top">-->
                    <table border="0" class="tabel-cms" width="100%">
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
                        	<td valign="top">Tanggal Lahir</td>
                        	<td align="left"><?php echo $userdob?></td>
                      	</tr>
                      	<tr>
                        	<td valign="top">Alamat Lengkap</td>
                        	<td align="left"><?php echo $alamat11?></td>
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

	//Vie Menu
	if($aksi=="popupuserid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(userid,username)
				{
					var res = new Object();
					res.userid = userid;
					res.userid_text = username;
					window.returnValue = res;
					window.close();
					return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("userfullname","Nama Lengkap","str","text","$data");
			$cari[] = array("username","Username","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where']."and tipe='0'";
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
			
			$sql = "select userid,username,userfullname from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=userid\" title=\"Urutkan\">UserID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=username\" title=\"Urutkan\">Username</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=userfullname\" title=\"Urutkan\">Nama Lengkap</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$username = $row['username'];
				$userid = $row['userid'];
				$userfullname = $row['userfullname'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$userid</b></td>
					<td  valign=top class=judul>$username</td><td  valign=top class=judul>$userfullname</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$userid','$userfullname');\">Select</button>");
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
	//Publish
	if($aksi=="verified")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$userid = $_GET['userid'];
			
			$perintah 	= "select verified from $nama_tabel where userid='$userid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['verified']=="0") $status = 1;
				else $status=0;
			
			if($status==1)
			{
				$perintah	="select userid,userfullname,avatar,posting,follower,following,tema,usergender,useraddress,cityname,useremail,userphonegsm from tbl_member where userid='$userid' limit 1";
				$hasil= sql($perintah);
				$profil= sql_fetch_data($hasil);
				sql_free_result($hasil);
				
				$iduser = $profil['userid'];
				$contactname = $profil['userfullname'];
				$avatar = $profil['avatar'];
				$contactuseremail = $profil['useremail'];
				$contactuserphone = $profil['userphonegsm'];
				
				//Email
				$subject = "Your account at $title Already Verified";
				$message = "Hi $contactname, current account $title you have been verified by us and now you can already login to $fulldomain";
				
				sendmail($contactname,$contactuseremail,$subject,$message,emailhtml($message));
				// kirimSMS($contactuserphone,$message);

			}
				
			$perintah 	= "update $nama_tabel set verified='$status',useractivestatus='$status' where userid='$userid' ";
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
			$username        = $_POST['username'];
			$useremail       = $_POST['useremail'];
			$userpassword    = $_POST['userpassword'];
			$userfullname    = $_POST['userfullname'];
			$usergender      = $_POST['usergender'];
			$userdob         = $_POST['userdob'];
			$useraddress     = $_POST['useraddress'];
			$kotaid          = $_POST['kotaid'];
			$cityname        = sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
			$propinsiid      = $_POST['propinsiid'];
			$negaraid        = $_POST['negaraid'];
			$userpostcode    = $_POST['userpostcode'];
			$userphone       = $_POST['userphone'];
			$userphonegsm    = $_POST['userphonegsm'];

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
				
				$perintah = "INSERT INTO $nama_tabel (userid,tipe,username,useremail,userpassword,userfullname,usergender,userdob,useraddress,kotaid,cityname,
							propinsiid,negaraid,userpostcode,userphone,userphonegsm,useractivestatus,userlastloggedin,userlastactive,userstatus,usercreateddate $avatar1)
							 VALUES ('$baru','0','$username','$useremail','$userpassword','$userfullname','$usergender','$userdob','$useraddress','$kotaid','$cityname',
							 '$propinsiid','$negaraid','$userpostcode','$userphone','$userphonegsm','1','$userlastloggedin','$userlastactive','$userstatus','$date' $avatar)";
				$hasil = sql($perintah);
				
				if($hasil)
				{   
					$query=("insert into tbl_member_stats (userid,login) values ('$baru','0')");
					$hasil = sql($query);
					
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
					  frontendOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true
					});
				  });
				function poprefuserid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=member-reseller&aksi=poprefuserid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahadmin">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Member</th>
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
					<td valign="top">Tanggal Lahir</td>
					<td align="left"><input name="userdob" type="text" size="40" value="" id="userdob" /></td>
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
					<td valign="top">Nomor Handphone</td>
					<td align="left"><input name="userphonegsm" type="text"  size="60"  value=""  id="userphonegsm" class=""/></td>
				</tr>

                <!--<tr> 
					<td >Photo</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file validate[required]" /></td>
				</tr>-->
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
			$userdob         = $_POST['userdob'];
			$useraddress     = $_POST['useraddress'];
			$kotaid          = $_POST['kotaid'];
			$cityname        = sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
			$propinsiid      = $_POST['propinsiid'];
			$negaraid        = $_POST['negaraid'];
			$userpostcode    = $_POST['userpostcode'];
			$userphone       = $_POST['userphone'];
			$userphonegsm    = $_POST['userphonegsm'];
			$status_nikah    = $_POST['status_nikah'];

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
			
			
			$perintah = "update $nama_tabel set tipe='0',refuserid='$refuserid',userfullname='$userfullname',usergender='$usergender',userdob='$userdob',
						useraddress='$useraddress',kotaid='$kotaid',cityname='$cityname',propinsiid='$propinsiid',negaraid='$negaraid',
						userpostcode='$userpostcode',userphone='$userphone',userphonegsm='$userphonegsm',
						useractivestatus='1',userlastloggedin='$userlastloggedin',
						userlastactive='$userlastactive',userstatus='$userstatus' $avatar where userid='$userid'";//echo $perintah;die();
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
			  $tipe 		= $row['tipe'];
		      $avatar       = $row['avatar'];
		      $username     = $row['username'];
		      $useremail     = $row['useremail'];
		      $userfullname = $row['userfullname'];
		      $usergender   = $row['usergender'];
		      $userdob      = $row['userdob'];
		      $useraddress  = $row['useraddress'];
		      $kotaid       = $row['kotaid'];
		      $cityname     = $row['cityname'];
		      $userphone    = $row['userphone'];
		      $userphonegsm = $row['userphonegsm'];

		      $userdirname      = $row['userdirname'];
		      $userpostcode     = $row['userpostcode'];
		      $negaraid         = $row['negaraid'];
		      $propinsiid       = $row['propinsiid'];
		      
		      if(!empty($avatar)) $avatar = "$lokasiwebmember/avatars/$avatar";
			// Nama Ref Reseller
			$namarefuser = sql_get_var("select userfullname from tbl_member where userid='$refuserid'");
			
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
				function poprefuserid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=member-reseller&aksi=poprefuserid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
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
					<td width="176">Username</td>
					<td width="471"><input name="username" type="text" size="20" value="<?php echo $username?>" id="username" class="validate[required,custom[onlyLetter],minSize[3]]" disabled/></td>
				</tr>
				<tr> 
					<td valign="top">Nama Lengkap</td>
					<td align="left"><input name="userfullname" type="text" size="40" value="<?php echo $userfullname?>" id="userfullname" class="validate[required]" /></td>
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
					<td valign="top">Tanggal Lahir</td>
					<td align="left"><input name="userdob" type="text" size="40" value="<?php echo $userdob?>" id="userdob" /></td>
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
					<td valign="top">Nomor Handphone</td>
					<td align="left"><input name="userphonegsm" type="text"  size="60"  value="<?php echo $userphonegsm?>"  id="userphonegsm" class=""/></td>
				</tr>
                <!--<tr> 
					<td >Photo</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /></td>
				</tr>-->
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
	

}

?>