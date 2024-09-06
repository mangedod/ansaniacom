<?php 
//Variable halaman ini
$nama_tabel		= "tbl_subscriber";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;


//Variable Umum
if(isset($_POST['subscriberid'])) $id = $_POST['subscriberid'];
 else $id = $_GET['subscriberid'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Subcribers","lihat","$alamat&aksi=view");
                        $mainmenu[] = array("Tambah Subcribers","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("userfullname","Nama","str","text","$data");
			$cari[] = array("useremail","Email","str","text","$data");
			$cari[] = array("kota","Kota","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("subscriberid","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel where bounce='0' and 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select subscriberid,userfullname,useremail,userhandphone,kota, bounce from $nama_tabel  where bounce='0' and 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=70%><a href=\"$urlorder&order=userfullname\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=useremail\" title=\"Urutkan\">Email</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=userhandphone\" title=\"Urutkan\">Telepon</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=kota\" title=\"Urutkan\">Kota</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id        = $row['subscriberid'];
				$nama      = $row['userfullname'];
				$email     = $row['useremail'];
				$telepon   = $row['userhandphone'];
				$kota      = $row['kota'];
                 $bounche    = $row['bounce'];
                                
                                if($bounche=="1") $bounce ="bounce";
				 else $bounce ="aktif";
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top >$nama</td>\n
					<td  valign=top >$email</td>
					<td  valign=top >$telepon</td>
					<td  valign=top >$kota</td>");
					
				print("<td>");
                                
                                if($bounche==1) $acc[] = array("Aktif","push","$alamat&aksi=bounce&id=$id&hlm=$hlm");
				else $acc[] = array("Bounce","push","$alamat&aksi=bounce&id=$id&hlm=$hlm");
                                
				$acc[] = array("Detail","detail","$alamat&aksi=detail&id=$id&hlm=$hlm");
				$acc[] = array("Edit","edit","$alamat&aksi=edit&id=$id&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&id=$id&hlm=$hlm");
								
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
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select subscriberid,userfullname,useremail,userhandphone,kota, create_date from $nama_tabel  where subscriberid ='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id            = $row['subscriberid'];
			$nama          = $row['userfullname'];
			$email         = $row['useremail'];
			$telepon       = $row['userhandphone'];
			$kota          = $row['kota'];
			$create_date   = tanggal($row['create_date']);
                        
			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Nama</td> 
					<td align="left"><?php echo $nama?></td>
				</tr>
                <tr> 
					<td valign="top" width="20%" class="tdinfo">Email</td> 
					<td align="left"><?php echo $email?></td>
				</tr>
                <tr> 
					<td  class="tdinfo">Telepon</td>
					<td ><?php echo $telepon?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Kota</td>
					<td ><?php echo $kota?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Tanggal Buat</td>
					<td><?php echo $create_date?></td>
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
			
			$id       = $_GET['id'];

			$perintah = "delete from $nama_tabel where subscriberid='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $id");
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
}

//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
                    
			$nama    = cleaninsert($_POST['nama']);
			$email = cleaninsert($_POST['email']);
			$telepon    = cleaninsert($_POST['telepon']);
			$kota   = cleaninsert($_POST['kota']);
                        
                        $perintah = "select max(subscriberid) as baru from tbl_subscriber";
			$hasil = sql($perintah);
			$data = sql_fetch_data($hasil);
			$baru = $data['baru']+1;
               
		
			$query = "insert into $nama_tabel(subscriberid, create_date, userfullname, useremail, userhandphone, kota) 
						values ('$baru','$date','$nama','$email','$telepon','$kota')";
			$hasil = sql($query);
			
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
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			
			</script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
				<tr> 
					<td width="15%">Nama</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Email</td>
					<td><input name="email" type="text" size="90" value="" id="tags" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Telepon</td>
					<td><input name="telepon" type="text" size="20" value="" id="oleh" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Kota</td>
					<td><input name="kota" type="text" size="20" value="" id="oleh" class="validate[required]" /></td>
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
	
	if($aksi=="saveedit")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_POST['id'];
                        $nama    = cleaninsert($_POST['nama']);
			$email = cleaninsert($_POST['email']);
			$telepon    = cleaninsert($_POST['telepon']);
			$kota   = cleaninsert($_POST['kota']);
			$date = date("Y-m-d H:i:s");
                        
			$perintah = "update $nama_tabel set userfullname='$nama',useremail='$email',userhandphone='$telepon',kota='$kota', update_date='$date' where subscriberid='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{   	
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
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

	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select subscriberid,userfullname,useremail,userhandphone,kota, create_date from $nama_tabel  where subscriberid ='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id            = $row['subscriberid'];
			$nama          = $row['userfullname'];
			$email         = $row['useremail'];
			$telepon       = $row['userhandphone'];
			$kota          = $row['kota'];
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr> 
					<td width="15%">Nama</td>
					<td ><input name="nama" type="text" size="70" value="<?php= $nama ?>" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Email</td>
					<td><input name="email" type="text" size="90" value="<?php= $email ?>" id="tags" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Telepon</td>
					<td><input name="telepon" type="text" size="20" value="<?php= $telepon ?>" id="oleh" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Kota</td>
					<td><input name="kota" type="text" size="20" value="<?php= $kota ?>" id="oleh" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}

//Publish
	if($aksi=="bounce")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$id = $_GET['id'];
			
			$perintah 	= "select bounce from $nama_tabel where subscriberid='$id' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['bounce']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set bounce='$status' where subscriberid='$id' ";
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
?>