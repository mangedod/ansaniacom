<?php
//Variable halaman ini
$nama_tabel    = "tbl_wording";
$judul_per_hlm = 10;
$otoritas      = kodeoto($kanal);
$oto           = $otoritas[0];
$gambars_maxw  = 350;
$gambars_maxh  = 300;
$gambarl_maxw  = 800;
$gambarl_maxh  = 600;


//Variable Umum
if(isset($_POST['wordingid'])) $wordingid = $_POST['wordingid'];
 else $wordingid = $_GET['wordingid']; 

if(!$oto['oto']) { echo $error['oto']; }
else
{	
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Data","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Data","tambah","$alamat&aksi=tambahsec");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul Wording","str","text","$data");
			
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("nama","asc",$pageparam,$param);
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
			
			$sql = "select  `wordingid`,`nama`,`keterangan`, `jenis`, `subjek` from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul Wording</a></th>\n");
			//print("<th width=20%><a href=\"$urlorder&order=subjek\" title=\"Urutkan\">Subjek</a></th>\n");
			print("<th width=40%>Keterangan</th>\n");
			print("<th width=10%>Jenis</th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$wordingid = $row['wordingid'];
				$nama           = $row['nama'];
				$keterangan     = $row['keterangan'];
				$jenis		    = $row['jenis'];
				$subjek		    = $row['subjek'];

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama<br clear=\"all\" /></td>\n
					
					<td  valign=top >$keterangan</td>
					<td  valign=top >$jenis</td>
				");//<td  valign=top >$subjek</td>
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=editsec&wordingid=$wordingid&hlm=$hlm");
								
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
	if($aksi=="hapussec")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$perintah = "delete from $nama_tabel where wordingid='$wordingid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus Data dengan ID $wordingid");
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
	
	//SaveTambahSec
	if($aksi=="savetambahsec")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama       = cleaninsert($_POST['nama']);
			$subjek    = cleaninsert($_POST['subjek']);
			$keterangan = $_POST['keterangan'];
			$pesan = $_POST['pesan'];
			$jenis = $_POST['jenis'];
			$alias      = getAlias($nama);
			
			if($jenis == "sms")
				$keterangan = $pesan;
			
			$new = newid("wordingid",$nama_tabel);

			$perintah = "INSERT into $nama_tabel(wordingid,nama,subjek,alias,keterangan,jenis,create_date,create_userid)
						values ('$new','$nama','$subjek','$alias','$keterangan','$jenis','$date','$cuserid')";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan kategori baru");
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
	if($aksi=="tambahsec")
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
				function textCounter(field, countfield, maxlimit) 
				{
					  if (field.value.length > maxlimit) 
					  {
						field.value = field.value.substring(0, maxlimit);
					  } 
					  else 
					  {
						countfield.value = maxlimit - field.value.length;
					  }
				}
				function tampil(data)
            	{
	                if(data=="email")
	                {
	                    $(".email").show();
						$(".sms").hide();
	                }
	                else if(data=="sms")
	                {
	                    $(".email").hide();
						$(".sms").show();
	                }
					else
					{
	                    $(".email").show();
						$(".sms").hide();
	                }
            	}
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahsec">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
                <tr> 
					<td width="15%">Jenis Wording</td>
					<td ><select name="jenis" id="jenis" class="validate[required]" onchange="tampil(this.value)">
                    		<option value="email">Email</option>
                            <option value="sms">SMS</option>
                        </select>
                    </td>
				</tr>
				<tr> 
					<td width="15%">Judul Wording</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr class="sms" style="display:none">
                    <td>Isi SMS</td>
                    <td><textarea style="width:400px;height:70px" rows="3" name="pesan" class="validate[required]" onKeyDown="textCounter(document.menufrm.pesan,document.menufrm.inputcount,260);" onKeyUp="textCounter(document.menufrm.pesan,document.menufrm.inputcount,260);"></textarea><br clear="all" />
                    Karakter yang tersisa 
                            <input readonly type="text" name="inputcount" size="5" maxlength="4" value="" class="textfield1" />
                            <script language="JavaScript">
                                document.menufrm.inputcount.value = (260 - document.menufrm.pesan.value.length);
                            </script>
                    <em>Untuk variable silahkan beri tanda []. Contoh : [namavariable]</em>
                    </td>
                </tr>
                <!--<tr class="email"> 
                    <td width="15%">Subjek</td>
                    <td ><input name="subjek" type="text" size="70" value="" id="subjek" class="validate[required]" /></td>
                </tr> -->
                <tr class="email">
					<td >Keterangan</td>
					<td >
                    	<textarea name="keterangan" cols="76" rows="5" id="keterangan" class="ckeditor validate[required]"></textarea>
                        <em>Untuk variable silahkan beri tanda []. Contoh : [namavariable]</em>
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
	
	if($aksi=="saveeditsec")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$nama       = cleaninsert($_POST['nama']);
			$subjek       = cleaninsert($_POST['subjek']);
			$keterangan = $_POST['keterangan'];
			$pesan = $_POST['pesan'];
			$jenis = $_POST['jenis'];
			$alias      = getAlias($nama);
			
			if($jenis == "sms")
				$keterangan = $pesan;

			$perintah = "update $nama_tabel set nama='$nama',keterangan='$keterangan',jenis='$jenis',subjek='$subjek',
						update_date='$date',update_userid='$cuserid' where wordingid='$wordingid'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $wordingid");
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

	if($aksi=="editsec")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select wordingid,nama,keterangan, jenis,subjek from $nama_tabel  where wordingid='$wordingid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$wordingid      = $row['wordingid'];
			$nama       = $row['nama'];
			$keterangan = $row['keterangan'];
			$jenis		= $row['jenis'];
			$subjek		= $row['subjek'];
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function textCounter(field, countfield, maxlimit) 
				{
					  if (field.value.length > maxlimit) 
					  {
						field.value = field.value.substring(0, maxlimit);
					  } 
					  else 
					  {
						countfield.value = maxlimit - field.value.length;
					  }
				}
				function tampil(data)
            	{
	                if(data=="email")
	                {
	                    $(".email").show();
						$(".sms").hide();
	                }
	                else if(data=="sms")
	                {
	                    $(".email").hide();
						$(".sms").show();
	                }
					else
					{
	                    $(".email").show();
						$(".sms").hide();
	                }
            	}				
			</script>
            <script src="librari/ckeditor/ckeditor.js"></script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditsec">
            <input type="hidden" name="wordingid" value="<?php echo $wordingid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
                <tr> 
					<td width="15%">Jenis Wording</td>
					<td ><select name="jenis" id="jenis" class="validate[required]" onchange="tampil(this.value)">
                    		<option value="email"<?php if($jenis=="email") echo "selected";?>>Email</option>
                            <option value="sms"<?php if($jenis=="sms") echo "selected";?>>SMS</option>
                        </select>
                    </td>
				</tr>
				<tr> 
					<td valign="top">Judul Wording</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr class="sms" <?php if($jenis!="sms") {?>style="display:none"<?php } ?>>
                    <td>Isi SMS</td>
                    <td><textarea style="width:400px;height:70px" rows="3" name="pesan" class="validate[required]" onKeyDown="textCounter(document.menufrm.pesan,document.menufrm.inputcount,260);" onKeyUp="textCounter(document.menufrm.pesan,document.menufrm.inputcount,260);"><?php echo $keterangan?></textarea><br clear="all" />
                    Karakter yang tersisa 
                            <input readonly type="text" name="inputcount" size="5" maxlength="4" value="" class="textfield1" />
                            <script language="JavaScript">
                                document.menufrm.inputcount.value = (260 - document.menufrm.pesan.value.length);
                            </script>
                    <em>Untuk variable silahkan beri tanda []. Contoh : [namavariable]</em>
                    </td>
                </tr>
                <!--<tr class="email" <?php if($jenis!="email") {?>style="display:none"<?php } ?>> 
                    <td width="15%">Subjek</td>
                    <td ><input name="subjek" type="text" size="70" value="<?php echo $subjek?>" id="subjek" class="validate[required]" /></td>
                </tr>-->
                <tr class="email" <?php if($jenis!="email") {?>style="display:none"<?php } ?>> 
					<td >Keterangan</td>
					<td >
                        <textarea name="keterangan" cols="76" rows="5" id="keterangan" class="ckeditor validate[required]"><?php echo $keterangan?></textarea>
                        <em>Untuk variable silahkan beri tanda []. Contoh : [namavariable]</em>
                    </td>
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
	
}

?>