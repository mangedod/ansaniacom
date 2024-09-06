<?php 
//Variable halaman ini
$nama_tabel    = "tbl_warehouse";
$nama_tabel1   = "tbl_warehouse_ongkir";
$judul_per_hlm = 25;
$otoritas      = kodeoto($kanal);
$oto           = $otoritas[0];
$gambars_maxw  = 350;
$gambars_maxh  = 300;
$gambarl_maxw  = 800;
$gambarl_maxh  = 600;


//Variable Umum
if(isset($_POST['warehouseid'])) $warehouseid = $_POST['warehouseid'];
 else $warehouseid = $_GET['warehouseid'];
 
if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Gudang","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Gudang","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Depo","str","text","$data");
			$cari[] = array("keterangan","Keterangan","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");
			
			$dataselect[] = array("0","NonFreeze");
			$dataselect[] = array("1","Freeze");
			
			$cari[] = array("freeze","Status","select","select",$dataselect);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("warehouseid","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel where 1 $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select warehouseid,nama,freeze,keterangan,status,kotaid,nogsm,nilaisubsidi from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=45%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&order=kotaid\" title=\"Urutkan\">Kota Kurir</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&order=nogsm\" title=\"Urutkan\">Nomor HP</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$warehouseid  = $row['warehouseid'];
				$nama         = $row['nama'];
				$keterangan   = $row['keterangan'];
				$freeze       = $row['freeze'];
				$status       = $row['status'];
				$kotaid       = $row['kotaid'];
				$nogsm        = $row['nogsm'];
				$nilaisubsidi1= $row['nilaisubsidi'];
				if($nilaisubsidi1!='0')
				{
					$nilaisubsidi = "IDR ".number_format($nilaisubsidi1,0,".",".");
				}else{
					$nilaisubsidi = "";
				}
				
				$namakota = sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
				
				if($status==0)
				{
					$status = "Tidak Aktif";
					$label 	= "";
				}
				else
				{
					$status = "Aktif";
					$label 	= "label-success";
				}
				
				/*$data          = sql_get_var_row("select free, subsidi, nilaisubsidi from $nama_tabel1 where warehouseid='$warehouseid'");
				$freeong       = $data['free'];
				$subsidi       = $data['subsidi'];
				$nilaisubsidi1 = $data['nilaisubsidi'];
				if($nilaisubsidi1 == 0){ $nilaisubsidi = $nilaisubsidi1;}else{ $nilaisubsidi = "IDR ".number_format($nilaisubsidi1,0,".",".");}

				if($freeong == 1){ $freeong = "Ya"; }else{ $freeong = "Tidak";}
				if($subsidi == 1){ $subsidi = "Ya"; }else{ $subsidi = "Tidak";}*/
				 
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top align=center>&nbsp;$a</td>
					<td  valign=top class=judul><b>$nama</b><br clear=\"all\" /> $keterangan</td>\n
					<td  valign=top class=judul>$namakota</td>\n
					<td  valign=top class=judul>$nogsm</td>\n
					");
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=edit&warehouseid=$warehouseid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&warehouseid=$warehouseid&hlm=$hlm");
				// $acc[] = array("Manage Kota","edit","$alamat&aksi=kotaintkur&warehouseid=$warehouseid&hlm=$hlm");
								
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
	
	//Popup Brand
	if($aksi=="popwarehouseid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(warehouseid,nama)
				{
					var res = new Object();
					res.warehouseid = warehouseid;
					res.warehouseid_text = nama;
					window.returnValue = res;
					window.close();
					return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Gudang","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from $nama_tabel where freeze='0' $where";
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
			
			$sql = "select nama,warehouseid from $nama_tabel where freeze='0' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Gudang</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama 	 = $row['nama'];
				$warehouseid = $row['warehouseid'];

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$warehouseid','$nama');\">Select</button>");
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

			$perintah = "delete from $nama_tabel where warehouseid='$warehouseid'";
			$hasil = sql($perintah);
			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penghapusan data Gudang dengan ID $warehouseid",$uri,$ip);
				  
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $warehouseid");
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
	
	//Publish
	if($aksi=="publish")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$warehouseid = $_GET['warehouseid'];
			
			$perintah 	= "select status from $nama_tabel where warehouseid='$warehouseid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['status']=="0") $stats = 1;
				else $stats=0;
				
			$perintah 	= "update $nama_tabel set status='$stats' where warehouseid='$warehouseid' ";
			$hasil		= sql($perintah);
		
			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data status Gudang dengan ID $warehouseid",$uri,$ip);  
				$msg = base64_encode("Success merubah status data dengan ID $warehouseid");
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


	
	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama         = cleaninsert($_POST['nama']);
			$keterangan   = cleaninsert($_POST['keterangan']);
			$kotaid       = cleaninsert($_POST['kotaid']);
			$nogsm        = cleaninsert($_POST['nogsm']);
			$nilaisubsidi = cleaninsert($_POST['nilaisubsidi']);
			$alias        = getAlias($nama);
			
			$new = newid("warehouseid",$nama_tabel);
						
			$perintah 	= "insert into $nama_tabel(warehouseid,nama,alias,keterangan,create_date,create_userid,kotaid,nogsm,nilaisubsidi $fgambar) 
						values ('$new','$nama','$alias','$keterangan','$date','$cuserid','$kotaid','$nogsm','$nilaisubsidi' $vgambar)";
			$hasil 		= sql($perintah);
			
			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penambahan data Gudang dengan ID $wareouseid",$uri,$ip);
				  
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
				function popkotaid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=master-gudang&aksi=popkotaid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
				
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="3">Tambah Data</th>
				</tr>
                <tr>
					<td width="176">Kota Kurir</td>
					<td width="471">
                    <input name="kotaid" type="hidden" size="20" value="" id="kotaid" />
                    <input name="kotaid_text" type="text" size="20" value="" id="kotaid_text" placeholder="Pilih Kota" class="validate[required]">
                    <a href="#" class="apop" onclick="popkotaid('kotaid','kotaid_text')">..</a></td>
				</tr>
                
				<tr> 
					<td width="16%">Nama</td>
					<td colspan="2"><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td >
                    	<textarea name="keterangan" cols="70" rows="10" id="keterangan" class="validate[required]" ></textarea><br />
                        <em>Masukan keterangan gudang dengan jelas</em>
                    </td>
				</tr>
				<tr> 
					<td width="16%">Nomor HP</td>
					<td colspan="2"><input name="nogsm" type="text" size="70" value="" id="nogsm" class="" /><br><i>Contoh : 08123456789</i></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
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
			$nama         = cleaninsert($_POST['nama']);
			$keterangan   = cleaninsert($_POST['keterangan']);
			$kotaid       = cleaninsert($_POST['kotaid']);
			$nogsm        = cleaninsert($_POST['nogsm']);
			$nilaisubsidi = cleaninsert($_POST['nilaisubsidi']);
			$alias        = getAlias($nama);
			
			
			$perintah 	= "update $nama_tabel set nama='$nama',alias='$alias',keterangan='$keterangan',kotaid='$kotaid',nogsm='$nogsm',
						nilaisubsidi='$nilaisubsidi',update_date='$date',update_userid='$cuserid' $vgambar where warehouseid='$warehouseid'";
			//die($perintah);
			$hasil 		= sql($perintah);

			if($hasil)
			{  
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Gudang dengan ID $warehouseid",$uri,$ip); 
				$msg = base64_encode("Berhasil mengubah data dengan ID $warehouseid");
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
			
			$sql = "select warehouseid,nama,keterangan,kotaid,nogsm,nilaisubsidi from $nama_tabel where warehouseid='$warehouseid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$warehouseid  = $row['warehouseid'];
			$nama         = $row['nama'];
			$keterangan   = $row['keterangan'];
			$kotaid       = $row['kotaid'];
			$nogsm        = $row['nogsm'];
			$nilaisubsidi = $row['nilaisubsidi'];
			
			$namakota = sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popkotaid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=master-gudang&aksi=popkotaid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
				
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="warehouseid" value="<?php echo $warehouseid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="3">Edit Data</th>
				</tr>
                <tr>
					<td width="176">Kota Kurir</td>
					<td width="471">
                    <input name="kotaid" type="hidden" size="20" value="<?php echo $kotaid?>" id="kotaid" />
                    <input name="kotaid_text" type="text" size="20" value="<?php echo $namakota?>" placeholder="Pilih Kota" id="kotaid_text" class="">
                    <a href="#" class="apop" onclick="popkotaid('kotaid','kotaid_text')">..</a></td>
				</tr>
				<tr> 
					<td valign="top">Nama</td> 
					<td colspan="2" align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td>
                    	<textarea name="keterangan" cols="70" rows="10" id="keterangan" class="validate[required]" ><?php echo $keterangan?></textarea><br />
                        <em>Masukan keterangan gudang  dengan jelas</em>
                    </td>
				</tr>
				<tr> 
					<td valign="top">Nomor HP</td> 
					<td colspan="2" align="left"><input name="nogsm" value="<?php echo $nogsm?>" type="text" size="40" id="nogsm" class=""  /><br><i>Contoh : 08123456789</i></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
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
	
	if($aksi=="savekotaintkur")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$warehouseid  = cleaninsert($_POST['warehouseid']);
			$free         = cleaninsert($_POST['free']);
			$subsidi      = cleaninsert($_POST['subsidi']);
			$nilaisubsidi = cleaninsert($_POST['nilaisubsidi']);
			
			$kotaid         = sql_get_var("select kotaid from $nama_tabel where warehouseid='$warehouseid'");
			$adawarehouseid = sql_get_var("select warehouseid from $nama_tabel1 where warehouseid='$warehouseid'");
			if(empty($adawarehouseid))
			{
				$new      = newid("wonid",$nama_tabel1);
				$perintah = "insert into $nama_tabel1(wonid,warehouseid,kotaid,free,subsidi,nilaisubsidi,create_date,create_userid) 
							values ('$new','$warehouseid','$kotaid','$free','$subsidi','$nilaisubsidi','$date','$cuserid')";
				$hasil 	  = sql($perintah);
			}
			else
			{
				if($subsidi==0){
					$perintah 	= "update $nama_tabel1 set kotaid='$kotaid',free='$free',subsidi='$subsidi',nilaisubsidi='0',
								update_date='$date',update_userid='$cuserid' where warehouseid='$warehouseid'";
					$hasil 		= sql($perintah);
				}else{
					$perintah 	= "update $nama_tabel1 set kotaid='$kotaid',free='$free',subsidi='$subsidi',nilaisubsidi='$nilaisubsidi',
								update_date='$date',update_userid='$cuserid' where warehouseid='$warehouseid'";
					$hasil 		= sql($perintah);
				}
				
			}
			
			if($hasil)
			{  
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan data Gudang dengan ID $warehouseid",$uri,$ip); 
				$msg = base64_encode("Berhasil mengubah data dengan ID $warehouseid");
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

	if($aksi=="kotaintkur")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select warehouseid,wonid,kotaid,free,subsidi,nilaisubsidi from $nama_tabel1 where warehouseid='$warehouseid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			// $warehouseid  = $row['warehouseid'];
			$wonid        = $row['wonid'];
			$kotaid       = $row['kotaid'];
			$freeong      = $row['free'];
			$subsidi      = $row['subsidi'];
			$nilaisubsidi = $row['nilaisubsidi'];
			
			// $namakota = sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
		          function tampil(data) {
		            if(data=="1")
		            {
		              $("#nilaisubs").show();
		            }
		            else
		            {
		              $("#nilaisubs").hide();
		            }
		          }
				
			</script>
            <style>
                #nilaisubs { display:none; }
            </style>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savekotaintkur">
            <input type="hidden" name="warehouseid" value="<?php echo $_GET['warehouseid']?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="3">Manage Kota Internal Kurir</th>
				</tr>
				<tr> 
					<td valign="top">Free Ongkir</td> 
					<td colspan="2" align="left">
						<input type="radio" name="free" value="1" <?php if($freeong == '1') echo "checked" ?> class="validate[required]"> Ya &nbsp;
  						<input type="radio" name="free" value="0" <?php if($freeong == '0') echo "checked" ?> class="validate[required]"> Tidak
					</td>
				</tr>
				<tr> 
					<td valign="top">Subsidi Ongkir</td> 
					<td colspan="2" align="left">
						<input type="radio" name="subsidi" value="1" <?php if($subsidi == '1') echo "checked" ?> class="validate[required]" onChange="tampil(this.value);"> Ya &nbsp;
  						<input type="radio" name="subsidi" value="0" <?php if($subsidi == '0') echo "checked" ?> class="validate[required]" onChange="tampil(this.value);"> Tidak
					</td>
				</tr>
				<tr id="nilaisubs"> 
					<td valign="top">Nilai Subsidi</td> 
					<td colspan="2" align="left"><input name="nilaisubsidi" value="<?php echo $nilaisubsidi?>" type="text" size="5" id="nilaisubsidi" class="validate[required]"  /><br><i>Contoh : 25000</i></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
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
	
	//Popup Reseller Refuserid
	if($aksi=="popkotaid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$var1    = $_GET['var1'];
			$var2    = $_GET['var2'];
			?>
            	<script type="text/javascript">
				function pushdata(kotaid,kotaid_text)
				{
					 if (window.opener && !window.opener.closed)
					 {
					 	window.opener.$("#<?php echo $var1; ?>").val(kotaid);
						window.opener.$("#<?php echo $var2; ?>").val(kotaid_text);
					 } 
					  window.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("namakota","Nama Kota","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from tbl_kota where 1 $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("namakota","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select kotaid,namakota,tipe from tbl_kota where 1 $where $parorder limit $ord, $judul_per_hlm";
			// echo $sql;
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=80%><a href=\"$urlorder&order=userfullname\" title=\"Urutkan\">Nama Kota</a></th>\n");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$namakota = $row['namakota'];
				$kotaid   = $row['kotaid'];
				$tipe = $row['tipe'];
				
				if($tipe=="Kota") $tipe = "(Kota)";
				else $tipe = "";
				

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td valign=top class=judul>$namakota $tipe</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$kotaid','$namakota');\">Select</button>");
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