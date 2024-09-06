<?php 
//Variable halaman ini
$nama_tabel		= "tbl_product_mdiskonk";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['diskonid'])) $diskonid = $_POST['diskonid'];
 else $diskonid = $_GET['diskonid']; 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Viwe Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Data","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Data","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("diskonid","desc",$pageparam,$param);
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
			
			$sql = "select diskonid,nama,diskon_persen,tanggaldiskon,produkpostid,harga_diskonk from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Diskon</a></th>\n");
			print("<th width=40%>Produk</th>\n");
			print("<th width=15%>Tanggal Diskon</th>\n");
			print("<th width=20%>Diskon(%)</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$diskonid      = $row['diskonid'];
				$nama          = $row['nama'];
				$diskon_persen = $row['diskon_persen'];
				$tanggaldiskon = tanggal($row['tanggaldiskon']);
				$produkpostid  = $row['produkpostid'];
				$harga_diskonk = number_format($row['harga_diskonk'],0,".",".");

				$namaproduk = sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");

				print("<tr class=\"row$i\"><td width=5% height=20 align=center valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama</td>
					<td  valign=top class=judul>$namaproduk</td>
					<td align=center valign=top class=judul>$tanggaldiskon</td>
					<td align=center valign=top class=judul>$diskon_persen% (Rp. $harga_diskonk)</td>
					");
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&diskonid=$diskonid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&diskonid=$diskonid&hlm=$hlm");
								
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
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$diskonid 	  	= $_GET['diskonid'];

			$perintah 	= "delete from $nama_tabel where diskonid='$diskonid'";
			$hasil 		= sql($perintah);

			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penghapusan data Kategori Produk dengan ID $diskonid",$uri,$ip);  
				$msg = base64_encode("Berhasil menghapus Data dengan ID $diskonid");
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

	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama          = cleaninsert($_POST['nama']);
			$alias         = getAlias($nama);	
			$diskon_persen = $_POST['diskon_persen'];
			$tanggaldiskon = $_POST['tanggaldiskon'];
			$produkpostid  = $_POST['produkpostid'];
			$harga_diskonk = $_POST['harga_diskonk'];

			$new 		= newid("diskonid",$nama_tabel);
			
			$perintah 	= "insert into $nama_tabel(diskonid,nama,alias,diskon_persen,tanggaldiskon,produkpostid,harga_diskonk) 
						values ('$new','$nama','$alias','$diskon_persen','$tanggaldiskon','$produkpostid','$harga_diskonk')";
			$hasil 		= sql($perintah);
			
			if($hasil)
			{ 
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penambahan data Kategori Produk dengan ID $new",$uri,$ip);  
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
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
						$( "#tanggal" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true
						});

				});

				function popupprodukpostid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=produk&aksi=popupprodukpostid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
			</script>

			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
				<tr>
					<td width="176">Produk</td>
					<td width="471">
                    <input name="produkpostid" type="hidden" size="20" value="" id="produkpostid" />
                    <input name="produkpostid_text" type="text" size="50" value="" id="produkpostid_text" placeholder="Pilih Produk" class="validate[required]">
                    <a href="#" class="apop" onclick="popupprodukpostid('produkpostid','produkpostid_text')">..</a></td>
				</tr>
                <tr> 
					<td>Nama</td>
					<td>
                    	<input name="nama" type="text" size="40" value="" id="nama" class="validate[required]" /><br />
                        <em>Masukan nama diskon produk dengan jelas</em>
                    </td>
				</tr>
                <tr> 
					<td>Harga Diskon</td>
					<td>
                    	<input name="harga_diskonk" type="text" size="15" value="" id="harga_diskonk" class="validate[required]" />
                    </td>
				</tr>
                <tr> 
					<td>Diskon</td>
					<td>
                    	<input name="diskon_persen" type="text" size="1" value="" id="diskon_persen" class="validate[required]" />
                        <em>%</em>
                    </td>
				</tr>
                <tr> 
					<td>Tanggal</td>
					<td>
                    	<input name="tanggaldiskon" type="text" size="15" value="" id="tanggal" class="validate[required]" /><br />
                        <em>Klik icon gambar, Contoh format : 2016-11-01 (format yyyy-mm-dd)</em>
                    </td>
				</tr>
				<tr>
					<td colspan="2" align="left">
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
			$nama          = cleaninsert($_POST['nama']);
			$alias         = getAlias($nama);
			$diskon_persen = $_POST['diskon_persen'];
			$tanggaldiskon = $_POST['tanggaldiskon'];
			$produkpostid = $_POST['produkpostid'];
			$harga_diskonk = $_POST['harga_diskonk'];

			$perintah 	= "update $nama_tabel set nama='$nama',alias='$alias',diskon_persen='$diskon_persen',tanggaldiskon='$tanggaldiskon',produkpostid='$produkpostid',harga_diskonk='$harga_diskonk' where diskonid='$diskonid'";
			$hasil 		= sql($perintah);

			if($hasil)
			{  
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Kategori Produk dengan ID $diskonid",$uri,$ip); 
				$msg = base64_encode("Berhasil mengubah data dengan ID $diskonid");
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
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select diskonid,nama,diskon_persen,tanggaldiskon,produkpostid,harga_diskonk from $nama_tabel where diskonid='$diskonid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$diskonid      = $row['diskonid'];
			$nama          = $row['nama'];
			$diskon_persen = $row['diskon_persen'];
			$tanggaldiskon = $row['tanggaldiskon'];
			$produkpostid  = $row['produkpostid'];
			$harga_diskonk = $row['harga_diskonk'];
				$namaproduk = sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
						$( "#tanggal" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true
						});

				});

				function popupprodukpostid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=produk&aksi=popupprodukpostid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
			</script>

			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="diskonid" value="<?php echo $diskonid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
				<tr>
					<td width="176">Produk</td>
					<td width="471">
                    <input name="produkpostid" type="hidden" size="20" value="<?php echo $produkpostid?>" id="produkpostid" />
                    <input name="produkpostid_text" type="text" size="50" value="<?php echo $namaproduk?>" id="produkpostid_text" placeholder="Pilih Produk" class="validate[required]">
                    <a href="#" class="apop" onclick="popupprodukpostid('produkpostid','produkpostid_text')">..</a></td>
				</tr>
                <tr> 
					<td width="50%">Nama</td>
					<td>
                    	<input name="nama" type="text" size="40" value="<?php echo $nama?>" id="nama" class="validate[required]" /><br />
                        <em>Masukan nama diskon produk dengan jelas</em>
                    </td>
				</tr>
                <tr> 
					<td>Harga Diskon</td>
					<td>
                    	<input name="harga_diskonk" type="text" size="15" value="<?php echo $harga_diskonk?>" id="harga_diskonk" class="validate[required]" />
                    </td>
				</tr>
                <tr> 
					<td>Diskon</td>
					<td>
                    	<input name="diskon_persen" type="text" size="1" value="<?php echo $diskon_persen?>" id="diskon_persen" class="validate[required]" />
                        <em>%</em>
                    </td>
				</tr>
                <tr> 
					<td>Tanggal</td>
					<td>
                    	<input name="tanggaldiskon" type="text" size="15" value="<?php echo $tanggaldiskon?>" id="tanggal" class="validate[required]" /><br />
                        <em>Klik icon gambar, Contoh format : 2016-11-01 (format yyyy-mm-dd)</em>
                    </td>
				</tr>
				<tr> 
					<td colspan="2" align="left">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
	
	//Popup Diskon
	if($aksi=="popdiskonid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$var1    = $_GET['var1'];
			$var2    = $_GET['var2'];
			$eventid = $_GET['eventid'];
			
			if(empty($var1) && empty($var2))
			{
				$var1 = "hotelid";
				$var2 = "hotelid_text";
			}
			?>
            	<script type="text/javascript">
				function pushdata(diskonid,nama)
				{
					 if (window.opener && !window.opener.closed)
					 {
					 	window.opener.$("#<?php echo $var1; ?>").val(diskonid);
						window.opener.$("#<?php echo $var2; ?>").val(nama);
					 } 
					  window.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama","str","text","$data");

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
			$order = getorder("nama","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select nama,diskonid from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama 	= $row['nama'];
				$nama_en = $row['nama_english'];
				$diskonid 	 	= $row['diskonid'];

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$diskonid','$nama');\">Select</button>");
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
	
}

?>