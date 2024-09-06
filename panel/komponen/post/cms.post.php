<?php 
//Variable halaman ini
$nama_tabel    = "tbl_post";
$nama_tabel1   = "tbl_post_komen";
$judul_per_hlm = 25;
$otoritas      = kodeoto($kanal);
$oto           = $otoritas[0];

//Variable Umum
if(isset($_POST['postid'])) $postid = $_POST['postid'];
 else $postid = $_GET['postid'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Post","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("username","From","str","text",$data);
			$cari[] = array("tousername","To Username","str","text",$data);
			$cari[] = array("isi","Isi","str","text",$data);
			$cari[] = array("tanggal","Tanggal","date","date",$data);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("postid","desc",$pageparam,$param);
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
			
			$sql = "select postid,username,tousername,isi,tanggal,jmlkomen,jmlLike,home from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=userName\" title=\"Urutkan\">From</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=toUserName\" title=\"Urutkan\">To Username</a></th>\n");
			print("<th width=30%><a href=\"$urlorder&order=isi\" title=\"Urutkan\">Isi</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&order=tanggal\" title=\"Urutkan\">Tanggal</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=jmlkomen\" title=\"Urutkan\">Jml Komen</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=jmlLike\" title=\"Urutkan\">Jml Like</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=jmlLike\" title=\"Urutkan\">Home</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$postid     = $row['postid'];
				$username   = $row['username'];
				$tousername = $row['tousername'];
				$isi        = $row['isi'];
				$tanggal    = tanggal($row['tanggal']);
				$jmlKomen   = $row['jmlkomen'];
				$jmlLike    = $row['jmlLike'];
				$published		= $row['home'];
				
				if($published=="1") $publish ="Ya";
				 else $publish ="Tidak";
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td valign=top>$username</td>
					<td valign=top>$tousername</td>
					<td valign=top>$isi</td>
					<td valign=top>$tanggal</td>
					<td valign=top><a href=\"$alamat&aksi=viewkomen&postid=$postid&hlm=$hlm\">$jmlKomen</a></td>
					<td valign=top>$jmlLike</td>
					<td valign=top>$publish</td>");
					
				print("<td>");

				if($published==0) $acc[] = array("Set Home","push","$alamat&aksi=publish&postid=$postid&hlm=$hlm");
				else $acc[] = array("Unset Home","push","$alamat&aksi=publish&postid=$postid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&postid=$postid&hlm=$hlm");
								
				cmsaction($acc);
				unset($acc);
				
				print("</td></tr>");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			sql_free_result($hsl);
			print("</table><br clear='all'>");
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		    
			
		}
	} //EndView 
	
		//Publish
	if($aksi=="publish")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$postid = $_GET['postid'];
			
			$perintah 	= "select home from $nama_tabel where postid='$postid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['home']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set home='$status' where postid='$postid' ";
			$hasil		= sql($perintah);
		
			if($hasil)
			{   
				$msg = base64_encode("Success merubah status data dengan ID $id");
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

	//Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,ringkas,alias,create_date,create_userid,update_date,update_userid from $nama_tabel where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id            = $row['id'];
			$nama          = $row['nama'];
			$ringkas       = $row['ringkas'];
			$alias         = $row['alias'];
			$create_date   = tanggal($row['create_date']);
			$update_date   = tanggal($row['update_date']);
			$create_userid = $row['create_userid'];
			$update_userid = $row['update_userid'];
			$create_userid = sql_get_var("select userfullname from tbl_cms_user where userid='$create_userid'");
			$update_userid = sql_get_var("select userfullname from tbl_cms_user where userid='$update_userid'");
	
			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Judul</td> 
					<td align="left"><?php echo $nama?></td>
				</tr>
                <tr> 
					<td valign="top" width="20%" class="tdinfo">Alias</td> 
					<td align="left"><?php echo $alias?></td>
				</tr>
                <tr> 
					<td  class="tdinfo">Ringkas</td>
					<td ><?php echo $ringkas?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Tanggal Buat</td>
					<td><?php echo $create_date?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Pembuat</td>
					<td><?php echo $create_userid?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Tanggal Update</td>
					<td><?php echo $update_date?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Pengedit</td>
					<td><?php echo $update_userid?></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=edit&id=$id"?>'" value="Ubah Data">
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
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$perintah = "delete from $nama_tabel where postid='$postid'";
			$hasil = sql($perintah);
			$perintah1 = "delete from $nama_tabel1 where postid='$postid'";
			$hasil1 = sql($perintah1);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $postid");
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

	if($aksi=="viewkomen")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Post","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Komentar","lihat","$alamat&aksi=viewkomen&postid=$postid");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("userName","From","str","text",$data);
			$cari[] = array("toUserName","To Username","str","text",$data);
			$cari[] = array("isi","Isi","str","text",$data);
			$cari[] = array("tanggal","Tanggal","date","date",$data);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("id","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel1 where postid='$postid' $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select id,postid,username,isi,tanggal,`like` from $nama_tabel1 where postid='$postid' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=id\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=username\" title=\"Urutkan\">From</a></th>\n");
			print("<th width=25%><a href=\"$urlorder&order=isi\" title=\"Urutkan\">Isi</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&order=tanggal\" title=\"Urutkan\">Tanggal</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=like\" title=\"Urutkan\">Jml Like</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$postid     = $row['postid'];
				$username   = $row['username'];
				$id 		= $row['id'];
				$isi        = $row['isi'];
				$tanggal    = tanggal($row['tanggal']);
				$like    	= $row['like'];
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top>&nbsp;<b>$postid</b></td>
					<td valign=top>$username</td>
					<td valign=top>$isi</td>
					<td valign=top>$tanggal</td>
					<td valign=top>$like</td>");
					
				print("<td>");

				$acc[] = array("Hapus","delete","$alamat&aksi=hapuskomen&postid=$postid&id=$id&hlm=$hlm");
								
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
	
	//Hapus
	if($aksi=="hapuskomen")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id = $_GET['id'];

			$perintah1 = "delete from $nama_tabel1 where id='$id'";
			$hasil1 = sql($perintah1);
			
			if($hasil)
			{
				$perintah1 = "update $nama_tabel set jmlkomen=jmlkomen-1 where postid='$postid'";
				$hasil1 = sql($perintah1);  
				 
				$msg = base64_encode("Success mengapus gambar dengan Data dengan ID $id");
				header("location: $alamat&aksi=viewkomen&postid=$postid&id=$id&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gambar tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewkomen&postid=$postid&id=$id&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
}

?>