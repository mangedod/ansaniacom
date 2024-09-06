<?php 
//Variable halaman ini
$nama_tabel		= "tbl_cms_usergroup";
$judul_per_hlm 	= 10;
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
			$mainmenu[] = array("Lihat User Group","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah User Group","tambah","$alamat&aksi=tambahusergroup ");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("namagroup","Nama Group","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
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
			$order = getorder("gid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select namagroup,gid,description from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=gid\" title=\"Urutkan\">GroupID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=namagroup\" title=\"Urutkan\">Nama Group</a></th>\n");
			print("<th width=45% ><a href=\"$urlorder&order=description\" title=\"Urutkan\">Keterangan</a></th>");
			print("");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$namagroup = $row['namagroup'];
				$gid = $row['gid'];
				$keterangan = $row['description'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$gid</b></td>
					<td  valign=top class=judul>$namagroup</td>\n");
				print("<td valign=top class=hitam>$keterangan</td>\n");
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&gid=$gid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&gid=$gid&hlm=$hlm");
								
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
	
	//Vie Menu
	if($aksi=="popupgid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(gid,nama)
				{
					var res = new Object();
					res.gid = gid;
					res.gid_text = nama;
					window.returnValue = res;
					window.close();
					return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("namagroup","Nama Group","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
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
			$order = getorder("gid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select namagroup,gid,description from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=gid\" title=\"Urutkan\">GroupID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=namagroup\" title=\"Urutkan\">Nama Group</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$namagroup = $row['namagroup'];
				$gid = $row['gid'];
				$keterangan = $row['description'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$gid</b></td>
					<td  valign=top class=judul>$namagroup</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$gid','$namagroup');\">Select</button>");
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
	
	//HapusGroup
	if($aksi=="hapus")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$gid = $_GET['gid'];

			$perintah = "delete from $nama_tabel where gid='$gid'";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus Group dengan Group ID $gid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dihapus dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//TambahMenu
	if($aksi=="tambahusergroup")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="savetambahgroup">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Group</th>
				</tr>
				<tr> 
					<td valign="top">Nama Group</td>
					<td align="left"><input name="namagroup" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><textarea cols="70" rows="5" name="description" class="validate[required]"></textarea></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Menu" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		    
			
		}
	}
	
	//SaveTambahGroup
	if($aksi=="savetambahgroup")
	{
		
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$namagroup = $_POST['namagroup'];
			$description = $_POST['description'];
			$namagroup = cleaninsert($namagroup);
			$description = cleaninsert($description);

			$newgid = newid('gid',$nama_tabel);
			
			$perintah = "INSERT INTO $nama_tabel (`gid`, `description`,`namagroup`) VALUES ('$newgid', '$description','$namagroup')";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan group baru dengan GroupId = $newgid");
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
	
	//EditGroup
	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select namagroup,gid,description from $nama_tabel  where gid='$gid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$namagroup = $row['namagroup'];
			$gid = $row['gid'];
			$description = $row['description'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveeditgroup">
            <input type="hidden" name="gid" value="<?php echo $gid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Group</th>
				</tr>
				<tr> 
					<td valign="top">Nama Group</td> 
					<td align="left"><input name="namagroup" value="<?php echo $namagroup?>" type="text" size="40" value="" id="nama" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">Keterangan</td>
					<td align="left"><textarea cols="70" rows="5" name="description" class="validate[required]"><?php echo $description?></textarea></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Menu" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//SaveEditGroup
	if($aksi=="saveeditgroup")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$namagroup = $_POST['namagroup'];
			$description = $_POST['description'];
			$namagroup = cleaninsert($namagroup);
			$description = cleaninsert($description);
			
			$perintah = "update $nama_tabel set namagroup='$namagroup',description='$description' where gid='$gid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah Group $namagroup dengan Group ID $gid");
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
}
?>