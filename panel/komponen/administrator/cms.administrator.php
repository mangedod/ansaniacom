<?php 
//Variable halaman ini
$nama_tabel		= "tbl_cms_user";
$nama_tabel1	= "tbl_cms_usergroup";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['gid'])) $gid = $_POST['gid'];
 else $gid = $_GET['gid'];
 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Administrator","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Administrator","tambah","$alamat&aksi=tambahadmin");
			mainaction($mainmenu,$pageparam);
			
	
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("username","Username","int","text","$data");
			
			$cari[] = array("gid","Group","find","find","index.php?pop=1&kanal=group&aksi=popupgid");
			$cari[] = array("userfullname","Nama Lengkap","str","text","$data");
			$cari[] = array("useraddress","Alamat","str","text","$data");
			$cari[] = array("useremail","Email","str","text","$data");
			$cari[] = array("userphone","Telephone","str","text","$data");
			$cari[] = array("userhandphone","Handphone","str","text","$data");
			
			$dataselect[] = array("1","Aktif");
			$dataselect[] = array("0","Non Aktif");
			
			$cari[] = array("userstatus","Status","select","select",$dataselect);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("userfullname","asc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select userid,gid,username,userfullname,useremail from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=userid\" title=\"Urutkan\">UserID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=username\" title=\"Urutkan\">Username</a></th>\n");
			print("<th width=25% ><a href=\"$urlorder&order=userfullname\" title=\"Urutkan\">Nama Lengkap</a></th>");
			print("<th width=20%><a href=\"$urlorder&order=gid\" title=\"Urutkan\">Group</a></th>");
			print("<th width=20%><a href=\"$urlorder&order=useremail\" title=\"Urutkan\">Email</a></th>");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$userfullname = $row['userfullname'];
				$userid = $row['userid'];
				$username = $row['username'];
				$useremail = $row['useremail'];
				$gid = $row['gid'];
				
				$sql2 = "select namagroup from $nama_tabel1 where gid=$gid";
				$hsl2 = sql($sql2);
				$dt2 = sql_fetch_data($hsl2);
				$group = $dt2['namagroup'];
				
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$userid</b></td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=detail&userid=$userid\"><b>$username</b></a></td>\n");
				print("<td valign=top class=hitam>$userfullname</td>\n");
				print("<td valign=top class=hitam>$group</td>\n");
				print("<td valign=top class=hitam>$useremail</td>\n");
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
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		    
			
		}
	} //EndView 
	
	//Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$userid = $_GET['userid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select gid,userid,username,userfullname,useremail,useraddress,userphone,userhandphone from $nama_tabel  where userid='$userid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$userid = $row['userid'];
			$username = $row['username'];
			$useremail = $row['useremail'];
			$userfullname = $row['userfullname'];
			$useraddress = $row['useraddress'];
			$userphone = $row['userphone'];
			$userhandphone = $row['userhandphone'];
			$gid = $row['gid'];
			$namagroup = sql_get_var("select namagroup from $nama_tabel1 where gid='$gid'");
			
			?>
            <table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Data Detail</th>
				</tr>
                <tr> 
					<td width="176">Group</td>
					<td width="471">
                    <?php echo $namagroup?></td>
				</tr>
				<tr> 
					<td width="176">Username</td>
					<td width="471"><?php echo $username?></td>
				</tr>
				<tr> 
					<td valign="top">Nama Lengkap</td>
					<td align="left"><?php echo $userfullname?></td>
				</tr>
                <tr> 
					<td valign="top">Alamat</td>
					<td align="left"><?php echo $useraddress?></td>
				</tr>
                <tr> 
					<td valign="top">Email Address</td>
					<td align="left"><?php echo $useremail?></td>
				</tr>
				<tr> 
					<td valign="top">Phone</td>
					<td align="left"><?php echo $userphone?></td>
				</tr>
                <tr> 
					<td valign="top">Handphone</td>
					<td align="left"><?php echo $userhandphone?></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo"$alamat&aksi=edit&userid=$userid";?>'" value="Ubah Data">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}

	//HapusMenu
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$userid = $_GET['userid'];
			
			if($userid==$cuserid)
			{
				$error = base64_encode("Anda tidak dapat menghapus diri anda sendiri");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}

			$perintah = "delete from $nama_tabel where userid='$userid'";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus admin dengan ID $menuid");
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

	
	//SaveTambahMenu
	if($aksi=="savetambahadmin")
	{
		
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$gid = $_POST['gid'];
			$username = $_POST['username'];
			$userfullname = $_POST['userfullname'];
			$useremail = $_POST['useremail'];
			$useraddress = $_POST['useraddress'];
			$userphone = $_POST['userphone'];
			$userhandphone = $_POST['userhandphone'];
			$userpassword = $_POST['userpassword'];
			
			$newmenuid = newid("userid",$nama_tabel);
			
			$perintah = "INSERT INTO $nama_tabel (userid,gid,username,userfullname,useremail,useraddress,userphone,userhandphone,userstatus)
						 VALUES ('$newmenuid','$gid','$username','$userfullname','$useremail','$useraddress','$userphone','$userhandphone','1')";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan Administrator baru dengan username = $username");
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
	
	//TambahMenu
	if($aksi=="tambahadmin")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
				function popgid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=group&aksi=popupgid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("gid").value = res.gid;
							document.getElementById("gid_text").value = res.gid_text;
						}
						return false;
				}
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="savetambahadmin">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Admin</th>
				</tr>
                <tr> 
					<td width="176">Group</td>
					<td width="471">
                    <input name="gid" type="hidden" size="20" value="" id="gid" />
                    <input name="gid_text" type="text" size="20" value="" id="gid_text" class="validate[required]" /> 
                    <a href="#" class="apop" onclick="popgid()">..</a></td>
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
					<td valign="top">Nama Lengkap</td>
					<td align="left"><input name="userfullname" type="text" size="40" value="" id="userfullname" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td valign="top">Alamat</td>
					<td align="left"><input name="useraddress" type="text"  size="60"  value=""  id="useraddress" class="validate[required]"/></td>
				</tr>
                <tr> 
					<td valign="top">Email Address</td>
					<td align="left"><input name="useremail" type="text"  size="60"  value=""  id="useremail" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">Phone</td>
					<td align="left"><input name="userphone" type="text"  size="60"  value=""  id="userphone" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Handphone</td>
					<td align="left"><input name="userhandphone" type="text"  size="60"  value=""  id="userhandphone" class=""/></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Administrator" />
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
		else
        {
			$userid = cleaninsert($_POST['userid']);
			$gid = cleaninsert($_POST['gid']);
			$username = cleaninsert($_POST['username']);
			$userfullname = cleaninsert($_POST['userfullname']);
			$useremail = cleaninsert($_POST['useremail']);
			$useraddress = cleaninsert($_POST['useraddress']);
			$userphone = cleaninsert($_POST['userphone']);
			$userhandphone = cleaninsert($_POST['userhandphone']);
			
			
			$perintah = "update $nama_tabel set gid='$gid',username='$username',userfullname='$userfullname',useremail='$useremail',
			useraddress='$useraddress',userphone='$userphone',userhandphone='$userhandphone' where userid='$userid'";
				$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah Data dengan ID $menuid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//EditMenu
	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$userid = $_GET['userid'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select gid,userid,username,userfullname,useremail,useraddress,userphone,userhandphone from $nama_tabel  where userid='$userid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$userid = $row['userid'];
			$username = $row['username'];
			$useremail = $row['useremail'];
			$userfullname = $row['userfullname'];
			$useraddress = $row['useraddress'];
			$userphone = $row['userphone'];
			$userhandphone = $row['userhandphone'];
			$gid = $row['gid'];
			$namagroup = sql_get_var("select namagroup from $nama_tabel1 where gid='$gid'");
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popgid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=group&aksi=popupgid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res != null) {
							document.getElementById("gid").value = res.gid;
							document.getElementById("gid_text").value = res.gid_text;
						}
						return false;
				}
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveeditadmin">
            <input type="hidden" name="userid" value="<?php echo $userid?>">
            <table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Ubah Admin</th>
				</tr>
                <tr> 
					<td width="176">Group</td>
					<td width="471">
                    <input name="gid" type="hidden" size="20" value="<?php echo $gid?>" id="gid" />
                    <input name="gid_text" type="text" size="20" value="<?php echo $namagroup?>" id="gid_text" class="validate[required]" /> 
                     <a href="#" class="apop" onclick="popgid()">..</a></td>
				</tr>
				<tr> 
					<td width="176">Username</td>
					<td width="471"><input name="username" type="text" size="20" value="<?php echo $username?>" id="username" class="validate[required,custom[onlyLetter],minSize[3]]" /></td>
				</tr>
				<tr> 
					<td valign="top">Nama Lengkap</td>
					<td align="left"><input name="userfullname" type="text" size="40" value="<?php echo $userfullname?>" id="userfullname" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td valign="top">Alamat</td>
					<td align="left"><input name="useraddress" type="text"  size="60"  value="<?php echo $useraddress?>"  id="useraddress" class="validate[required]"/></td>
				</tr>
                <tr> 
					<td valign="top">Email Address</td>
					<td align="left"><input name="useremail" type="text"  size="60"  value="<?php echo $useremail?>" id="useremail" class="validate[required]"/></td>
				</tr>
				<tr> 
					<td valign="top">Phone</td>
					<td align="left"><input name="userphone" type="text"  size="60"  value="<?php echo $userphone?>"  id="userphone" class=""/></td>
				</tr>
                <tr> 
					<td valign="top">Handphone</td>
					<td align="left"><input name="userhandphone" type="text"  size="60"  value="<?php echo $userhandphone?>"  id="userhandphone" class=""/></td>
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
	
	//SaveUbahPassword
	if($aksi=="saveubahpassword")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
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
			{
				$error = base64_encode("Password gagal dirubah dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//EditMenu
	if($aksi=="ubahpassword")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
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