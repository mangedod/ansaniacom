<?php 
//Variable halaman ini
$nama_tabel		= "tbl_konten";
$nama_tabel1	= "tbl_konten_sec";
$nama_tabel2	= "tbl_konten_subsec";
$nama_tabel3	= "tbl_komentar";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;


//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];
if(isset($_POST['secid'])) $secid = $_POST['secid'];
 else $secid = $_GET['secid']; 
if(isset($_POST['subsecid'])) $subsecid = $_POST['subsecid'];
 else $subsecid = $_GET['subsecid']; 
 
 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Kategori","category","$alamat&aksi=viewsec");
			$mainmenu[] = array("Lihat Konten","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Konten","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");
			$cari[] = array("ringkas","Ringkas","str","text","$data");
			$cari[] = array("secid","Kategori","find","find","index.php?pop=1&kanal=video&aksi=popsecid");
			$cari[] = array("oleh","Penulis","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");
			
			$dataselect[] = array("0","Draft");
			$dataselect[] = array("1","Published");
			
			$cari[] = array("published","Status","select","select",$dataselect);
			
			$tipes[] = array("text","Text");
			$tipes[] = array("video","Video");
			$tipes[] = array("audio","Audio");
			
			$cari[] = array("tipe","Jenis Konten","select","select",$tipes);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("create_date","desc",$pageparam,$param);
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
			
			$sql = "select id,nama,idmaster,ringkas,published,secid,subsecid,views,ulamaid,gambar,tipe,master from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=40%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul</a></th>\n");
			print("<th width=20%>Artikel Terkait</th>\n");
			print("<th width=10%>Tipe</th>\n");
			print("<th width=10%>Kategori</th>\n");
			print("<th width=10%>Sub Kategori</th>\n");
			print("<th width=5%>Views</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");
			$artikel_master="";
			while ($row = sql_fetch_data($hsl))
			{
				$id 		= $row['id'];
				$nama 		= $row['nama'];
				$ringkas 	= $row['ringkas'];
				$published 	= $row['published'];
				$secid 		= $row['secid'];
				$view 		= $row['views'];
				$ulamaid 	= $row['ulamaid'];
				$gambar 	= $row['gambar'];
				$tipe 		= $row['tipe'];
				$master 	= $row['master'];
				$subsecid	= $row['subsecid'];
				$idmaster	= $row['idmaster'];
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				 $artikel_master="";
				 
				$kategori = sql_get_var("select nama from $nama_tabel1 where secid='$secid'");
				$subkategori = sql_get_var("select nama from $nama_tabel2 where subsecid='$subsecid'");
				if ($master==1)
				{
					$hasil	= sql("select nama from $nama_tabel where idmaster='$id'");
					while ($rowz = sql_fetch_data($hasil))
					{
						$artikel_master .="- $rowz[nama]<br>";
					}
				}else
				{
					$artikel_master = sql_get_var("select nama from $nama_tabel where id='$idmaster'");
				}
				
				
				$ulama = sql_get_var("select userfullname from tbl_member where userid='$ulamaid'");
				$kanal =  $tipe;
				if ($tipe=="video")
				{
					if(!empty($gambar))
						$gambar = "<img src='../media/video/$gambar'>";
				}else
				{
					if(!empty($gambar))
						$gambar = "<img src='../gambar/$kanal/$gambar'>";
				}
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$gambar<br><b><a href=\"$alamat&aksi=detail&id=$id&hlm=$hlm\">$nama</a></b><br clear=\"all\" /> $ringkas</td>\n
					<td  valign=top >$artikel_master</td>
					<td  valign=top >$tipe</td>
					<td  valign=top >$kategori</td>
					<td  valign=top >$subkategori</td>
					<td  valign=top >$view</td>
					<td  valign=top >$publish</td>");
					
				print("<td>");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				
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
			sql_free_result($hsl);
			
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
			
			$sql = "select id,subsecid,secid,ulamaid,masjidid,nama,ringkas,oleh,lengkap,durasi,audio,oleh,alias,video,youtubeid,gambar,gambar1,create_date,jenis,create_userid,update_date,update_userid,tipe from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$ringkas = $row['ringkas'];
			$lengkap = $row['lengkap'];
			$video = $row['video'];
			$jenis = $row['jenis'];
			$gambar1 = $row['gambar1'];
			$gambar = $row['gambar'];
			$youtubeid = $row['youtubeid'];
			$ulamaid = $row['ulamaid'];
			$masjidid = $row['masjidid'];
			$durasi = $row['durasi'];
			$secid = $row['secid'];
			$create_date = tanggal($row['create_date']);
			$update_date = tanggal($row['update_date']);
			$create_userid = $row['create_userid'];
			$update_userid = $row['update_userid'];
			$tipe = $row['tipe'];
			$oleh = $row['oleh'];
			$subsecid = $row['subsecid'];
			$audio = $row['audio'];

			
			$create_userid = sql_get_var("select userfullname from tbl_cms_user where userid='$create_userid'");
			$update_userid = sql_get_var("select userfullname from tbl_cms_user where userid='$update_userid'");
			$ulama = sql_get_var("select userfullname from tbl_member where userid='$ulamaid'");
			$tempat = sql_get_var("select userfullname from tbl_member where userid='$masjidid'");
			$kategori = sql_get_var("select nama from $nama_tabel1 where secid='$secid'");
			$subkategori = sql_get_var("select nama from $nama_tabel2 where subsecid='$subsecid'");
			
			if ($tipe!="video")
			{
				if(!empty($gambar)) $gambar = "<img src=\"../gambar/$tipe/$gambar\" alt=\"\" />"; else $gambar = "Masih kosong";
				if(!empty($gambar1)) $gambar1 = "<img src=\"../gambar/$tipe/$gambar1\" alt=\"\" />"; else $gambar1 = "Masih kosong";
			}else
			{
				if(!empty($gambar)) $gambar = "<img src=\"../media/$tipe/$gambar\" alt=\"\" />"; else $gambar = "Masih kosong";
				if(!empty($gambar1)) $gambar1 = "<img src=\"../media/$tipe/$gambar1\" alt=\"\" />"; else $gambar1 = "Masih kosong";
			}
			
			?>
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
                <tr> 
					<td valign="top" width="20%" class="tdinfo">Kategori</td> 
					<td align="left"><?php echo $kategori?> > <?php echo $subkategori ?></td>
				</tr>
                <tr <?php if($tipe!="video") {?> style="display:none"<?php } ?> > 
					<td valign="top" width="20%" class="tdinfo">Penceramah</td> 
					<td align="left"><?php echo $ulama?></td>
				</tr>
                <tr  <?php if($tipe!="video") {?> style="display:none"<?php } ?>> 
					<td valign="top" width="20%" class="tdinfo">Tempat</td> 
					<td align="left"><?php echo $tempat?></td>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Judul</td> 
					<td align="left"><?php echo $nama?></td>
				</tr>
                <tr> 
					<td  class="tdinfo">Ringkas</td>
					<td ><?php echo $ringkas?></td>
				</tr>
                <tr <?php if($tipe!="text") {?> style="display:none"<?php } ?>> 
					<td  class="tdinfo">Lengkap</td>
					<td ><?php echo $lengkap?></td>
				</tr>
                <tr <?php if($tipe!="text") {?> style="display:none"<?php } ?>> 
					<td  class="tdinfo">Penulis</td>
					<td ><?php echo $oleh?></td>
				</tr>
                <tr <?php if($tipe!="video") {?> style="display:none"<?php } ?>> 
					<td  class="tdinfo">Durasi</td>
					<td ><?php echo $durasi?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Create</td>
					<td><?php echo $create_date?> by <?php echo $create_userid?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Update</td>
					<td><?php echo $update_date?> by <?php echo $update_userid?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Kecil</td>
					<td><?php echo $gambar?><br />
                    <input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=editgambar&id=$id"?>'" value="Edit Gambar">
                   <?php if($gambar!="Masih kosong") { ?><input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=hapusgambar&id=$id"?>'" value="Hapus Gambar"><?php } ?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Gambar Besar</td>
					<td><?php echo $gambar1?><br />
					<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=editgambarlarge&id=$id"?>'" value="Edit Gambar">
                   <?php if($gambar1!="Masih kosong") { ?><input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=hapusgambarlarge&id=$id"?>'" value="Hapus Gambar"><?php } ?></td>
				</tr>
                
                 <tr <?php if($tipe!="video") {?> style="display:none"<?php } ?>> 
					<td class="tdinfo">Jenis Konten</td>
					<td><?php echo $jenis?></td>
				</tr>
                <tr <?php if($tipe!="video") {?> style="display:none"<?php } ?>> 
					<td class="tdinfo" >Konten</td>
					<td>
					<?php 
						if($jenis=="upload") $video = "../media/$kanal/$id/$video";
						else if($jenis=="youtube") $video = "http://www.youtube.com/watch?v=$youtubeid";
					?>
					<script src="librari/videoplayer/jwplayer.js"></script>
                    <div id='my-video'></div>
						<script type='text/javascript'>
                            jwplayer('my-video').setup({
                                file: '<?php echo $video?>',
                                image: '<?php echo $gambar1?>',
                                width: '640',
                                height: '360'
                            });
                        </script>
				</td>
				</tr>
                <tr 
				<?php if($tipe!="audio") {?> style="display:none"<?php } ?>> 
					<td class="tdinfo" >audio</td>
					<td>
					<?php 
						$audio = "/media/$tipe/$audio";
					?>
                    <embed	
					src="http://www.salingsapa.com/plugin/videoplayer/audioplayer.swf"
					width="400"	
					height="20"	
					allowscriptaccess="always"
					allowfullscreen="true"
					flashvars="height=20&width=400&file=<?php echo $fulldomain; ?><?php echo $audio?>&frontcolor=0x000000&screencolor=0x888888&link=http://www.spiritualsharing.net&showstop=false&autoscroll=false&thumbsinplaylist=false&repeat=false&shuffle=false"
					/><br>
					<span style="font-size:11px"><a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">
						Download Lastest flash player </a> | <a href=http://www.salingsapa.com/<?php echo $audio?>> Listen with Custom Player </a></span>
				</td>				
                <tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=edit&id=$id"?>'" value="Ubah Data">
					</td>
				</tr>
			</table>
            
            <?php 
		}
	}
	
	//Hapus
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id = $_GET['id'];
			$perintah 	= "select gambar,gambar1,video from $nama_tabel where id='$id'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar 	= $row['gambar'];
			$gambar1 	= $row['gambar1'];
			$video 	= $row['video'];
			
			if(!empty($gambar)) unlink("$lokasimedia/$kanal/$id/$gambar");
			if(!empty($gambar1)) unlink("$lokasimedia/$kanal/$id/$gambar1");
			if(!empty($video)) unlink("$lokasimedia/$kanal/$video");
				

			$perintah = "delete from $nama_tabel where id='$id'";
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
	
	//Publish
	if($aksi=="publish")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			
			$id = $_GET['id'];
			
			$perintah 	= "select published from $nama_tabel where id='$id' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['published']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set published='$status' where id='$id' ";
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


	
	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$secid 		= cleaninsert($_POST['secid']);
			$subsecid	= cleaninsert($_POST['subsecid']);
			$nama 		= cleaninsert($_POST['nama']);
			$ringkas 	= cleaninsert($_POST['ringkas']);
			$master 	= cleaninsert($_POST['idmaster']);
			$alias 		= getAlias($nama);
			$tipe		= $_POST['tipe'];
			$kanal		= $tipe;
			$tag		= $_POST['tag'];
			$ulamaid 	= $_POST['ulamaid'];
			$masjidid 	= $_POST['masjidid'];
			$tanggal = cleaninsert($_POST['tanggal']);
			
			if ($tipe=="text")
			{
				$oleh 		= cleaninsert($_POST['oleh']);
				$lengkap 	= cleaninsert($_POST['lengkap']);
			}
			else
			if ($tipe=="video")
			{
				$durasi 	= cleaninsert($_POST['durasi']);
				$jenis	 	= ($_POST['jenis']);
				$lengkap	= desc($_POST['ringkas']);
			}
			else
			if ($tipe=="audio")
			{
				$durasi 	= cleaninsert($_POST['durasi']);
				$lengkap	= desc($_POST['ringkas']);
			}
			
			$new = newid("id",$nama_tabel);
			if ($tipe=="text" or $tipe=="audio")
			{
				//Upload Gambar
				if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
				
				if($_FILES['gambar']['size']>0)
				{
					$ext = getimgext($_FILES['gambar']);
					$namagambars = "$kanal-$alias-$new.$ext";
					$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
					
					$namagambarl = "$kanal-$alias-$new-l.$ext";
					$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
					echo "$pathfile/$kanal/$namagambars = $pathfile/$kanal/$namagambarl<br>";
					
					if($gambarl){ 
						$fgambar = ",gambar,gambar1";
						$vgambar = ",'$namagambars','$namagambarl'";
					}
				}
			
			}
			
			if ($tipe=="video")
			{
				//Upload Gambar
				if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
				if(!file_exists("$lokasimedia/$kanal/$new")) mkdir("$lokasimedia/$kanal/$new");
				if($_FILES['gambar']['size']>0)
				{
					$ext = getimgext($_FILES['gambar']);
					$namagambars = "$kanal-$alias-$new.$ext";
					$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$lokasimedia/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
					
					$namagambarl = "$kanal-$alias-$new-l.$ext";
					$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$lokasimedia/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
					
					if($gambarl){ 
						$fgambar = ",gambar,gambar1";
						$vgambar = ",'$namagambars','$namagambarl'";
					}
				}

				if($jenis=="upload")
				{
					
					if($_FILES['video']['size']>0)
					{
						$ext = getvideoext($_FILES['video']);
						if($ext=="mp4" || $ext=="flv")
						{
							$namavideo = "$kanal-video-$alias-$new.$ext";
							$video = copy($_FILES['video']['tmp_name'],"$lokasimedia/$kanal/$namavideo");
							
							if($video){ 
								$vfield = ",video";
								$vval = ",'$namavideo'";
							}
						}
					}
					
				}
				else if($jenis=="youtube")
				{
					$youtubeid = cleaninsert($_POST['youtubeid']);
					$yfield = ",youtubeid";
					$yval  = ",'$youtubeid'";
				}
			}
			
			if ($tipe=="audio")
			{
				if($_FILES['audio']['size']>0)
				{
					$ext = getvideoext($_FILES['audio']);
					if($ext=="mp3")
					{
						$namaaudio = "$kanal-audio-$alias-$new.$ext";
						$audio = copy($_FILES['audio']['tmp_name'],"$lokasimedia/$kanal/$namaaudio");
						
						if($audio){ 
							$vfield = ",audio";
							$vval = ",'$namaaudio'";
						}
					}
				}
			}
			
			if(!empty($tanggal))
				$date = $tanggal;
			else
				$date = $date;


			
			$perintah = "insert into $nama_tabel(id,secid,subsecid,eventid,oleh,ulamaid,masjidid,nama,alias,ringkas,lengkap,jenis,durasi,create_date,create_userid,idmaster,tag,tipe $fgambar $vfield $yfield) 
						values ('$new','$secid','$subsecid','$eventid','$oleh','$ulamaid','$masjidid','$nama','$alias','$ringkas','$lengkap','$jenis','$durasi','$date','$cuserid','$master','$tag','$tipe' $vgambar $vval $yval)";
			$hasil = sql($perintah);
			
			if($hasil)
			{ 
			
				$explode = explode(",",$tag);  
				$count = count($explode);
				for($i=0;$i<$count;$i++)
				{
					$bulan = date("Y-m");
					
					$cek = sql_get_var("select id from tbl_tags where tag='$explode[$i]' and bulan='$bulan'");
					
					if ($cek != '')
					{
						$update = sql("update tbl_tags set jumlah=jumlah+1 where id='$cek'");
					}
					else
					{
						$tag = trim($explode[$i]);
						$insert = sql("insert into tbl_tags (tag,bulan,jumlah) values ('$tag','$bulan','1')");
					}
				}
			
				$perintah = "update $nama_tabel set master='1' where id='$master'";
				$hasil = sql($perintah);


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
            <script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popsecid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=konten&aksi=popsecid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res == undefined){
                            res = window.returnValue;
                            console.log(res);
                        }
                        if (res != null && res != undefined)
                        {
                            console.log(res);
							document.getElementById("secid").value = res.secid;
							document.getElementById("secid_text").value = res.secid_text;
						}
						return false;
				}
				
				function popsubsecid(n)
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=konten&aksi=popsubsecid&secid="+n+"","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res == undefined){
                            res = window.returnValue;
                            console.log(res);
                        }
                        if (res != null && res != undefined)
                        {
                            console.log(res);
							document.getElementById("subsecid").value = res.subsecid;
							document.getElementById("subsecid_text").value = res.subsecid_text;
						}
						return false;
				}
				function popmasjidid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=konten&aksi=popmasjidid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res == undefined){
                            res = window.returnValue;
                            console.log(res);
                        }
                        if (res != null && res != undefined)
                        {
                            console.log(res);
							document.getElementById("masjidid").value = res.masjidid;
							document.getElementById("masjidid_text").value = res.masjidid_text;
						}
						return false;
				}
				function populamaid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=konten&aksi=populamaid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res == undefined){
                            res = window.returnValue;
                            console.log(res);
                        }
                        if (res != null && res != undefined)
                        {
                            console.log(res);
							document.getElementById("ulamaid").value = res.ulamaid;
							document.getElementById("ulamaid_text").value = res.ulamaid_text;
						}
						return false;
				}
				function popmaster()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=konten&aksi=popmaster","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res == undefined){
                            res = window.returnValue;
                            console.log(res);
                        }
                        if (res != null && res != undefined)
                        {
                            console.log(res);
							document.getElementById("idmaster").value = res.idmaster;
							document.getElementById("idmaster_text").value = res.idmaster_text;
						}
						return false;
				}
				
				function changejenis(jenis)
				{
					$(".jenisitem").hide();
					if(jenis!=="") $("#"+jenis).show("fast");
				}
				
				function changetipekonten(tipe)
				{
					//$(".jenisitem").hide();
					if(tipe=="video") 
					{
						$("#jenis_video").show("fast");
						$("#upload").show("fast");
						$("#text_durasi").show("fast");
						$("#penulis").hide();
						$("#dlengkap").hide();
						$("#upload_audio").hide();
						
					}else
					if(tipe=="audio") 
					{
						$("#jenis_video").hide();
						$("#upload").hide();
						$("#text_durasi").hide();
						$("#penulis").hide();
						$("#dlengkap").hide();
						$("#upload_audio").show("fast");
						
					}else
					{
						$("#jenis_video").hide();
						$("#upload").hide();
						$("#text_durasi").hide();
						$("#penulis").show("fast");
						$("#dlengkap").show("fast");
						$("#penulis").show("fast");
						
					}
				}
				$(function() {
						$( "#tanggal" ).datetimepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true,
						  timeFormat: "HH:mm"
						});

				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Data</th>
				</tr>
                 <tr> 
					<td width="176">Kategori</td>
					<td width="471">
                    <input name="secid" type="hidden" size="20" value="" id="secid" />
                    <input name="secid_text" type="text" size="20" value="" id="secid_text" class="validate[required]" /> 
                    <a href="#" class="apop" onclick="popsecid()">..</a></td>
				</tr>
                   <tr> 
					<td width="176">Sub Kategori</td>
					<td width="471">
                    <input name="subsecid" type="hidden" size="20" value="" id="subsecid" />
                    <input name="subsecid_text" type="text" size="20" value="" id="subsecid_text" class="validate[required]" /> 
                    <a href="#" class="apop" onclick="popsubsecid(secid.value)">..</a></td>
				</tr>
                 <tr> 
					<td >Artikel Terkait</td>
					<td >
                        <input name="idmaster" type="hidden" size="20" value="" id="idmaster" />
                        <input name="idmaster_text" type="text" size="20" value="" id="idmaster_text" /> 
                        <a href="#" class="apop" onclick="popmaster(idmaster.value)">..</a></td>
                    </td>
				</tr>
             
                <tr> 
					<td >Tipe Konten</td>
					<td >
                    	<select name="tipe" id="type" onchange="changetipekonten(this.value);" class="validate[required]">
                            <option value="text"> Text </option>
                            <option value="video"> Video </option>
                            <option value="audio"> Audio </option>
                          </select></td>
				</tr>
                
                <tr id="penceramah" > 
					<td width="176">Penceramah/Inspirator</td>
					<td width="471">
                    <input name="ulamaid" type="hidden" size="20" value="" id="ulamaid" />
                    <input name="ulamaid_text" type="text" size="20" value="" id="ulamaid_text" /> 
                    <a href="#" class="apop" onclick="populamaid()">..</a></td>
				</tr>
                <tr id="tempat" > 
					<td width="176">Tempat/Lembaga</td>
					<td width="471">
                    <input name="masjidid" type="hidden" size="20" value="" id="masjidid" />
                    <input name="masjidid_text" type="text" size="20" value="" id="masjidid_text" /> 
                    <a href="#" class="apop" onclick="popmasjidid()">..</a></td>
				</tr>
				<tr> 
					<td width="15%">Judul</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Ringkas</td>
					<td ><textarea name="ringkas" cols="76" rows="5" id="ringkas" class="validate[required]"></textarea></td>
              </tr>
                <tr id="dlengkap" > 
					<td >Lengkap</td>
					<td ><textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" ></textarea></td>
                </tr>
                <tr id="penulis" > 
					<td>Penulis</td>
					<td><input name="oleh" type="text" size="20" value="" id="oleh" class="validate[required]" /></td>
				</tr>

                <tr>
                  <td >Gambar Konten</td>
                  <td ><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar" class="" /> <em>Ukuran Gambar <?php echo $gambarl_maxw?>  x <?php echo $gambarl_maxh?> pixel</em></td>
                </tr>
                <tr id="text_durasi" style="display:none" > 
					<td width="15%">Durasi</td>
					<td ><input name="durasi" type="text" size="70" value="" id="durasi" class="validate[required]" /></td>
				</tr>
                <tr id="jenis_video" style="display:none" > 
					<td >Jenis Video</td>
					<td ><select name="jenis" id="jenis" onchange="changejenis(this.value);" class="validate[required]">
                    		<option value=""> - Pilih Jenis Video - </option>
                            <option value="upload"> Upload </option>
                            <option value="youtube"> Youtube </option>
                          </select></td>
				</tr>
                <tr id="upload" style="display:none" class="jenisitem" valign="top"> 
					<td >Upload </td>
				  <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
                       
                        <tr>
                          <td>File Konten</td>
                          <td><input name="video" type="file" size="20" value="" id="video" title="Pilih Konten" class="" />
                          Maksimum file yang bisa dikirim<strong> <?php echo ini_get("upload_max_filesize");?></strong> format <strong>FLV</strong> dan <strong>MP4</strong></td>
                        </tr>
                      </table></td>
				</tr>

                <tr id="youtube" class="jenisitem" style="display:none"> 
					<td width="15%">YouTube ID</td>
					<td ><input name="youtubeid" type="text" size="70" value="" id="youtubeid" class="" /><br />
						Masukan Youtube ID saja, seperti yang tercetak tebal:<br />
						http://www.youtube.com/watch?v=<strong>uiPKTFLKx6o</strong></td>
				</tr>
                <tr  id="upload_audio" style="display:none"> 
					<td >Upload </td>
				  <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
                       
                        <tr>
                          <td>File Audio</td>
                          <td><input name="audio" type="file" size="20" value="" id="audio" title="Pilih audio" class="" />
                          Maksimum file yang bisa dikirim<strong> <?php echo ini_get("upload_max_filesize");?></strong> format <strong>MP3</strong></td>
                        </tr>
                      </table></td>
				</tr>
                <tr> 
					<td >Tag</td>
					<td ><input name="tag" type="text" size="70" value="" id="tag" class="" /><br />Gunakan koma (,) untuk memisahkan tag.</td>
              </tr>
              <tr> 
					<td>Tanggal</td>
					<td><input name="tanggal" type="text" size="20" value="" id="tanggal" class="validate[required]" /></td>
				</tr>

				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:history.back();" value="Batal">					</td>
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
			$id 		= $_POST['id'];
			$nama 		= cleaninsert($_POST['nama']);
			$ringkas 	= cleaninsert($_POST['ringkas']);
			$jenis 		= cleaninsert($_POST['jenis']);
			$alias 		= getAlias($nama);
			$durasi 	= cleaninsert($_POST['durasi']);
			$ulamaid 	= $_POST['ulamaid'];
			$masjidid 	= $_POST['masjidid'];
			$master		= $_POST['master'];
			$idmaster	= $_POST['idmaster'];
			$tag		= $_POST['tag'];
			$tanggal = cleaninsert($_POST['tanggal']);
			if (empty($idmaster))
			{
				$master=1;
			}
			$subsecid	= $_POST['subsecid'];
			$secid		= $_POST['secid'];

			$tipe = $_POST['tipe'];
			$kanal	= $tipe;
			if ($tipe=="text")
			{
				$oleh 		= cleaninsert($_POST['oleh']);
				$lengkap 	= cleaninsert($_POST['lengkap']);
			}
			else
			if ($tipe=="video")
			{
				$durasi 	= cleaninsert($_POST['durasi']);

				$jenis	 	= ($_POST['jenis']);
				$lengkap	= desc($_POST['ringkas']);
			}
			else
			if ($tipe=="audio")
			{
				$durasi 	= cleaninsert($_POST['durasi']);
				$ulamaid 	= $_POST['ulamaid'];
				$masjidid 	= $_POST['masjidid'];
				$lengkap	= desc($_POST['ringkas']);
			}
			
			if ($tipe=="text" or $tipe=="audio")
			{
				//Upload Gambar
				if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
				
				if($_FILES['gambar']['size']>0)
				{
					$ext = getimgext($_FILES['gambar']);
					$namagambars = "$kanal-$alias-$new.$ext";
					$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars",$gambars_maxw,$gambars_maxh);
					
					$namagambarl = "$kanal-$alias-$new-l.$ext";
					$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambarl",$gambarl_maxw,$gambarl_maxh);
					echo "$pathfile/$kanal/$namagambars = $pathfile/$kanal/$namagambarl<br>";
					
					if($gambarl){ 
						$vgambar = ",gambar='$namagambars',gambar1='$namagambarl'";
					}
				}
			
			}
						
			if ($tipe=="video")
			{
			
				//Upload Gambar
				if(!file_exists("$pathfile/$tipe")) mkdir("$pathfile/$tipe");
				if(!file_exists("$lokasimedia/$tipe/$id")) mkdir("$lokasimedia/$tipe/$id");
				
				if($_FILES['gambar']['size']>0)
				{
					$ext = getimgext($_FILES['gambar']);
					$namagambars = "$tipe-$alias-$id.$ext";
					$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$lokasimedia/$tipe/$namagambars",$gambars_maxw,$gambars_maxh);
					
					$namagambarl = "$tipe-$alias-$id-l.$ext";
					$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$lokasimedia/$tipe/$namagambarl",$gambarl_maxw,$gambarl_maxh);
					
					if($gambarl){ 
						$vgambar = ",gambar='$namagambars',gambar1='$namagambarl'";
					}
				}
					
				
				if($jenis=="upload")
				{
					
					if($_FILES['video']['size']>0)
					{
						$ext = getvideoext($_FILES['video']);
						if($ext=="mp4" || $ext=="flv")
						{
							$namavideo = "$tipe-video-$alias-$new.$ext";
							$video = copy($_FILES['video']['tmp_name'],"$lokasimedia/$tipe/$namavideo");
							
							if($video){ 
								$vval = ",video='$namavideo'";
							}
						}
					}
					
				}
				else if($jenis=="youtube")
				{
					$youtubeid = cleaninsert($_POST['youtubeid']);
					$yval  = ",youtubeid='$youtubeid'";
				}
			}
			if(!empty($tanggal))
				$vtanggal = ",create_date='$tanggal'";
			
			$perintah = "update $nama_tabel set nama='$nama',secid='$secid',subsecid='$subsecid',oleh='$oleh',tipe='$tipe',alias='$alias',ringkas='$ringkas',lengkap='$lengkap',jenis='$jenis',durasi='$durasi',ulamaid='$ulamaid',masjidid='$masjidid',master='$master',tag='$tag',idmaster='$idmaster',update_date='$date',update_userid='$cuserid' $vtanggal $vgambar $vval $yval where id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{
				$explode = explode(",",$tag);  
				$count = count($explode);
				for($i=0;$i<$count;$i++)
				{
					$bulan = date("Y-m");
					
					$cek = sql_get_var("select id from tbl_tags where tag='$explode[$i]' and bulan='$bulan'");
					
					if ($cek != '')
					{
						$update = sql("update tbl_tags set jumlah=jumlah+1 where id='$cek'");
					}
					else
					{
						$tag = trim($explode[$i]);
						$insert = sql("insert into tbl_tags (tag,bulan,jumlah) values ('$tag','$bulan','1')");
					}
				}
				   
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
			
			$sql = "select id,nama,ringkas,lengkap,oleh,secid,tag,subsecid,ulamaid,masjidid,durasi,jenis,tipe,master,idmaster,tag,durasi,create_date from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id 		= $row['id'];
			$nama 		= $row['nama'];
			$ringkas 	= $row['ringkas'];
			$lengkap 	= $row['lengkap'];
			$oleh 		= $row['oleh'];
			$secid 		= $row['secid'];
			$ulamaid 	= $row['ulamaid'];
			$masjidid 	= $row['masjidid'];
			$durasi 	= $row['durasi'];
			$jenis		= $row['jenis'];
			$subsecid 	= $row['subsecid'];
			$tipe 		= $row['tipe'];
			$master 	= $row['master'];
			$idmaster 	= $row['idmaster'];
			$tag		= $row['tag'];
			$tanggal	= $row['create_date'];
			$idmaster_text 	= sql_get_var("select nama from $nama_tabel where id='$idmaster'");

			$kategori 	= sql_get_var("select nama from $nama_tabel1 where secid='$secid'");
			$subkategori = sql_get_var("select nama from $nama_tabel2 where subsecid='$subsecid'");

			$ulama = sql_get_var("select userfullname from tbl_member where userid='$ulamaid'");
			$masjid = sql_get_var("select userfullname from tbl_member where userid='$masjidid'");
			
			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popsecid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=konten&aksi=popsecid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res == undefined){
                            res = window.returnValue;
                            console.log(res);
                        }
                        if (res != null && res != undefined)
                        {
                            console.log(res);
							document.getElementById("secid").value = res.secid;
							document.getElementById("secid_text").value = res.secid_text;
						}
						return false;
				}
				
				function popsubsecid(n)
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=konten&aksi=popsubsecid&secid="+n+"","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res == undefined){
                            res = window.returnValue;
                            console.log(res);
                        }
                        if (res != null && res != undefined)
                        {
                            console.log(res);
							document.getElementById("subsecid").value = res.subsecid;
							document.getElementById("subsecid_text").value = res.subsecid_text;
						}
						return false;
				}
				function popmasjidid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=konten&aksi=popmasjidid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res == undefined){
                            res = window.returnValue;
                            console.log(res);
                        }
                        if (res != null && res != undefined)
                        {
                            console.log(res);
							document.getElementById("masjidid").value = res.masjidid;
							document.getElementById("masjidid_text").value = res.masjidid_text;
						}
						return false;
				}
				function populamaid()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=konten&aksi=populamaid","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res == undefined){
                            res = window.returnValue;
                            console.log(res);
                        }
                        if (res != null && res != undefined)
                        {
                            console.log(res);
							document.getElementById("ulamaid").value = res.ulamaid;
							document.getElementById("ulamaid_text").value = res.ulamaid_text;
						}
						return false;
				}
				function popmaster()
				{
					 var res = window.showModalDialog("index.php?pop=1&kanal=konten&aksi=popmaster","", "dialogWidth:600px;dialogHeight:500px;dialogTop:200px;")
						if (res == undefined){
                            res = window.returnValue;
                            console.log(res);
                        }
                        if (res != null && res != undefined)
                        {
                            console.log(res);
							document.getElementById("idmaster").value = res.idmaster;
							document.getElementById("idmaster_text").value = res.idmaster_text;
						}
						return false;
				}
				
				function changejenis(jenis)
				{
					$(".jenisitem").hide();
					if(jenis!=="") $("#"+jenis).show("fast");
				}
				
				function changetipekonten(tipe)
				{
					//$(".jenisitem").hide();
					if(tipe=="video") 
					{
						$("#penceramah").show("fast");
						$("#tempat").show("fast");
						$("#jenis_video").show("fast");
						$("#upload").show("fast");
						$("#text_durasi").show("fast");
						$("#penulis").hide();
						$("#dlengkap").hide();
						$("#upload_audio").hide();
						
					}else
					if(tipe=="audio") 
					{
						$("#penceramah").hide();
						$("#tempat").hide();
						$("#jenis_video").hide();
						$("#upload").hide();
						$("#text_durasi").hide();
						$("#penulis").hide();
						$("#dlengkap").hide();
						$("#upload_audio").show("fast");
						
					}else
					{
						$("#penceramah").hide();
						$("#tempat").hide();
						$("#jenis_video").hide();
						$("#upload").hide();
						$("#text_durasi").hide();
						$("#penulis").show("fast");
						$("#dlengkap").show("fast");
						$("#penulis").show("fast");
						
					}
				}
				$(function() {
						$( "#tanggal" ).datetimepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true,
						  timeFormat: "HH:mm"
						});

				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
			<input type="hidden" name="id" value="<?php echo"$id" ?>">
			<input type="hidden" name="master" value="<?php echo"$master" ?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Data</th>
				</tr>
                 <tr> 
					<td width="176">Kategori</td>
					<td width="471">
                    <input name="secid" type="hidden" size="20" value="<?php echo"$secid" ?>" id="secid" />
                    <input name="secid_text" type="text" size="20" value="<?php echo"$kategori" ?>" id="secid_text" class="validate[required]" /> 
                    <a href="#" class="apop" onclick="popsecid()">..</a></td>
				</tr>
                   <tr> 
					<td width="176">Sub Kategori</td>
					<td width="471">
                    <input name="subsecid" type="hidden" size="20" value="<?php echo"$subsecid" ?>" id="subsecid" />
                    <input name="subsecid_text" type="text" size="20" value="<?php echo"$subkategori" ?>" id="subsecid_text" > 
                    <a href="#" class="apop" onclick="popsubsecid(secid.value)">..</a></td>
				</tr>
                 <tr> 
					<td >Artikel Terkait</td>
					<td ><?php if ($master=="1") {echo "Artikel Master"; }else{?> 
                        <input name="idmaster" type="hidden" size="20" value="<?php echo"$idmaster" ?>" id="idmaster" />
                        <input name="idmaster_text" type="text" size="20" value="<?php echo"$idmaster_text" ?>" id="idmaster_text" /> 
                        <a href="#" class="apop" onclick="popmaster()">..</a> </td> 
                        <?php }?>
                    </td>
				</tr>
             
                <tr> 
					<td >Tipe Konten</td>
					<td >
                    	<select name="tipe" id="type" onchange="changetipekonten(this.value);" class="validate[required]">
                            <option value="text" <?php if($tipe=="text"){ ?> selected="selected" <?php } ?>> Text </option>
                            <option value="video" <?php if($tipe=="video"){ ?> selected="selected" <?php } ?>> Video </option>
                            <option value="audio" <?php if($tipe=="audio"){ ?> selected="selected" <?php } ?>> Audio </option>
                          </select></td>
				</tr>
                
                <tr id="penceramah"> 
					<td width="176">Penceramah/Inspirator</td>
					<td width="471">
                    <input name="ulamaid" type="hidden" size="20" value="<?php echo $ulamaid?>" id="ulamaid" />
                    <input name="ulamaid_text" type="text" size="20" value="<?php echo $ulama?>" id="ulamaid_text" /> 
                    <a href="#" class="apop" onclick="populamaid()">..</a></td>
				</tr>
                <tr id="tempat" > 
					<td width="176">Tempat/Lembaga</td>
					<td width="471">
                    <input name="masjidid" type="hidden" size="20" value="<?php echo $masjidid?>" id="masjidid" />
                    <input name="masjidid_text" type="text" size="20" value="<?php echo $masjid?>" id="masjidid_text" /> 
                    <a href="#" class="apop" onclick="popmasjidid()">..</a></td>
				</tr>
				<tr> 
					<td width="15%">Judul</td>
					<td ><input name="nama" type="text" size="70" value="<?php echo $nama?>" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Ringkas</td>
					<td ><textarea name="ringkas" cols="76" rows="5" id="ringkas" class="validate[required]"><?php echo $ringkas?></textarea></td>
              </tr>
                <tr id="dlengkap"  <?php if($tipe!="text") {?> style="display:none"<?php } ?> > 
					<td >Lengkap</td>
					<td ><textarea name="lengkap" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" ><?php echo $lengkap?></textarea></td>
                </tr>
                <tr id="penulis" <?php if($tipe!="text") {?> style="display:none"<?php } ?> > 
					<td>Penulis</td>
					<td><input name="oleh" type="text" size="20" value="<?php echo $oleh?>" id="oleh" class="validate[required]" /></td>
				</tr>

                <tr>
                  <td >Gambar Konten</td>
                  <td ><input name="gambar" type="file" size="20" value="<?php echo $lengkap?>" id="gambar" title="Pilih Gambar" class="" /> <em>Ukuran Gambar <?php echo $gambarl_maxw?>  x <?php echo $gambarl_maxh?> pixel</em></td>
                </tr>
                <tr id="text_durasi" <?php if($tipe=="text") {?> style="display:none"<?php } ?> > 
					<td width="15%">Durasi</td>
					<td ><input name="durasi" type="text" size="70" value="<?php echo $durasi?>" id="durasi" class="validate[required]" /></td>
				</tr>
                <tr id="jenis_video" <?php if($tipe!="video") {?> style="display:none"<?php } ?> > 
					<td >Jenis Video</td>
					<td ><select name="jenis" id="jenis" onchange="changejenis(this.value);" class="validate[required]">
                    		<option value=""> - Pilih Jenis Video - </option>
                            <option value="upload"  <?php if($jenis=="upload"){ ?> selected="selected" <?php } ?>> Upload </option>
                            <option value="youtube" <?php if($jenis=="youtube"){ ?> selected="selected" <?php } ?>> Youtube </option>
                          </select></td>
				</tr>
                <tr id="upload" <?php if($jenis!="upload"){ ?> style="display:none"<?php } ?>  class="jenisitem" valign="top"> 
					<td >Upload </td>
				  <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
                       
                        <tr>
                          <td>File Konten</td>
                          <td><input name="video" type="file" size="20" value="" id="video" title="Pilih Konten" class="" />
                          Maksimum file yang bisa dikirim<strong> <?php echo ini_get("upload_max_filesize");?></strong> format <strong>FLV</strong> dan <strong>MP4</strong></td>
                        </tr>
                      </table></td>
				</tr>

                <tr id="youtube" class="jenisitem" <?php if($jenis!="youtube") {?> style="display:none"<?php } ?> > 
					<td width="15%">YouTube ID</td>
					<td ><input name="youtubeid" type="text" size="70" value="<?php echo $youtubeid; ?>" id="youtubeid" class="" /><br />
						Masukan Youtube ID saja, seperti yang tercetak tebal:<br />
						http://www.youtube.com/watch?v=<strong>uiPKTFLKx6o</strong></td>
				</tr>
                <tr  id="upload_audio" <?php if($tipe!="audio") {?> style="display:none"<?php } ?>> 
					<td >Upload </td>
				  <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
                       
                        <tr>
                          <td>File Audio</td>
                          <td><input name="audio" type="file" size="20" value="<?php echo $youtubeid; ?>" id="audio" title="Pilih audio" class="" />
                          Maksimum file yang bisa dikirim<strong> <?php echo ini_get("upload_max_filesize");?></strong> format <strong>MP3</strong></td>
                        </tr>
                      </table></td>
				</tr>
                <tr> 
					<td >Tag</td>
					<td ><input name="tag" type="text" size="70" value="<?php echo $tag;?>" id="tag" class="" /><br />Gunakan koma (,) untuk memisahkan tag.</td>
              </tr>
              <tr> 
					<td>Tanggal</td>
					<td><input name="tanggal" type="text" size="20" value="<?php echo $tanggal;?>" id="tanggal" class="validate[required]" /></td>
				</tr>

				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:history.back();" value="Batal">					</td>
				</tr>
			</table>
</form>
            <?php 
		}
	}
	
	
	//Vie Content
	if($aksi=="viewsec")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Konten","back","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Kategori","lihat","$alamat&aksi=viewsec");
			$mainmenu[] = array("Tambah Kategori","tambah","$alamat&aksi=tambahsec");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Kategori","str","text","$data");
			
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("secid","asc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel1 where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select secid,nama,keterangan from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=40%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Kategori</a></th>\n");
			print("<th width=50%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">Keterangan</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$secid = $row['secid'];
				$nama = $row['nama'];
				$keterangan = $row['keterangan'];

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=viewsubsec&secid=$secid&hlm=$hlm\">$nama</a><br clear=\"all\" /></td>\n
					<td  valign=top >$keterangan</td>
				");
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=editsec&secid=$secid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapussec&secid=$secid&hlm=$hlm");
				$acc[] = array("Tambah Sub Kategori","add","$alamat&aksi=tambahsubsec&secid=$secid&hlm=$hlm");
								
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
	if($aksi=="popsecid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(secid,nama)
				{
					var res = new Object();
					res.secid = secid;
					res.secid_text = nama;
					 window.returnValue         = res;
                    if (window.opener) {
                        window.opener.returnValue = res;
                     }
                    window.returnValue = res;
                    self.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Kategori","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from $nama_tabel1 where 1 $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("secid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select nama,secid,keterangan from $nama_tabel1  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">SecID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Kategori</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$secid = $row['secid'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$secid</b></td>
					<td  valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$secid','$nama');\">Select</button>");
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
	if($aksi=="popmaster")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(idmaster,nama)
				{
					var res = new Object();
					res.idmaster = idmaster;
					res.idmaster_text = nama;
					 window.returnValue         = res;
                    if (window.opener) {
                        window.opener.returnValue = res;
                     }
                    window.returnValue = res;
                    self.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul Konten","str","text","$data");

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
			$order = getorder("id","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select id,nama,secid from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul Konten</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$id = $row['id'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$id','$nama');\">Select</button>");
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
	if($aksi=="popsubsecid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(subsecid,nama)
				{
					var res = new Object();
					res.subsecid = subsecid;
					res.subsecid_text = nama;
					 window.returnValue         = res;
                    if (window.opener) {
                        window.opener.returnValue = res;
                     }
                    window.returnValue = res;
                    self.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Sub Kategori","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from $nama_tabel2 where 1 and secid='$secid'  $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("subsecid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select subsecid,nama,secid,keterangan from $nama_tabel2  where 1 and secid='$secid' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">SecID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Kategori</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['nama'];
				$subsecid = $row['subsecid'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$subsecid</b></td>
					<td  valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$subsecid','$nama');\">Select</button>");
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
	if($aksi=="populamaid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(ulamaid,nama)
				{
					var res = new Object();
					res.ulamaid = ulamaid;
					res.ulamaid_text = nama;
					 window.returnValue         = res;
                    if (window.opener) {
                        window.opener.returnValue = res;
                     }
                    window.returnValue = res;
                    self.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("userfullname","Nama Ulama","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from tbl_member where (tipe='1' or tipe='3') $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("userid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select userfullname,userid from tbl_member where (tipe='1' or tipe='3') $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">UlamaID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Ulama</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = str_replace("'","`",$row['userfullname']);
				$userid = $row['userid'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$secid</b></td>
					<td  valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$userid','$nama');\">Select</button>");
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
	if($aksi=="popmasjidid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(masjidid,nama)
				{
					var res = new Object();
					res.masjidid = masjidid;
					res.masjidid_text = nama;
					 window.returnValue         = res;
                    if (window.opener) {
                        window.opener.returnValue = res;
                     }
                    window.returnValue = res;
                    self.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("userfullname","Nama Tempat","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from tbl_member where (tipe='2' or tipe='4') $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("userid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select userfullname,userid from tbl_member where (tipe='2' or tipe='4') $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">MasjidID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Tempat</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama = $row['userfullname'];
				$userid = $row['userid'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$secid</b></td>
					<td  valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$userid','$nama');\">Select</button>");
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
			
			$perintah = "delete from $nama_tabel1 where secid='$secid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$perintah2 = "delete from $nama_tabel2 where secid='$secid'";
				$hasil2 = sql($perintah2);
				$msg = base64_encode("Success mengapus Data dengan ID $secid");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&error=$error");
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
			$nama = cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$alias = getAlias($nama);
			
			$new = newid("secid",$nama_tabel1);
			
			$perintah = "insert into $nama_tabel1(secid,nama,alias,keterangan,create_date,create_userid $fgambar) 
						values ('$new','$nama','$alias','$keterangan','$date','$cuserid' $vgambar)";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan Sub Kategori baru");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&error=$error");
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
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewsec");
			mainaction($mainmenu,$param);
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahsec">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Kategori</th>
				</tr>
				<tr> 
					<td width="15%">Nama Kategori</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td ><textarea name="keterangan" cols="76" rows="5" id="keterangan" class="validate[required]"></textarea></td>
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
			$nama = cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$alias = getAlias($nama);
			
			
			$perintah = "update $nama_tabel1 set nama='$nama',alias='$alias',keterangan='$keterangan',
						update_date='$date',update_userid='$cuserid' where secid='$secid'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $secid");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsec&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editsec")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewsec");
			mainaction($mainmenu,$param);
			
			$sql = "select secid,nama,keterangan from $nama_tabel1  where secid='$secid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$secid = $row['secid'];
			$nama = $row['nama'];
			$keterangan = $row['keterangan'];
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditsec">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Kategori</th>
				</tr>
				<tr> 
					<td valign="top">Nama Kategori</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td ><textarea name="keterangan" cols="76" rows="5" id="keterangan" class="validate[required]"><?php echo $keterangan?></textarea></td>
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
	
		//Hapus
	if($aksi=="hapussubsec")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$perintah = "delete from $nama_tabel2 where secid='$secid' and subsecid='$subsecid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus Data dengan ID $secid");
				header("location: $alamat&aksi=viewsubsec&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsubsec&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//SaveTambahSec
	if($aksi=="savetambahsubsec")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$secid = cleaninsert($_POST['secid']);
			$nama = cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$alias = getAlias($nama);
			
			$new = newid("subsecid",$nama_tabel2);
			
			$perintah = "insert into $nama_tabel2(subsecid,secid,nama,alias,keterangan,create_date,create_userid $fgambar) 
						values ('$new','$secid','$nama','$alias','$keterangan','$date','$cuserid' $vgambar)";
			$hasil = sql($perintah);
			
			if($hasil)
			{   
				$msg = base64_encode("Berhasil ditambahkan Sec baru");
				header("location: $alamat&aksi=viewsubsec&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsubsec&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//Tambah
	if($aksi=="tambahsubsec")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewsec");
			mainaction($mainmenu,$param);
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="secid" value="<?php echo $secid;?>">
			<input type="hidden" name="aksi" value="savetambahsubsec">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Sub Kategori</th>
				</tr>
				<tr> 
					<td width="15%">Nama Sub Kategori</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td ><textarea name="keterangan" cols="76" rows="5" id="keterangan" class="validate[required]"></textarea></td>
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
	
	if($aksi=="saveeditsubsec")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$subsecid = cleaninsert($_POST['subsecid']);
			$nama = cleaninsert($_POST['nama']);
			$keterangan = cleaninsert($_POST['keterangan']);
			$alias = getAlias($nama);
			
			
			$perintah = "update $nama_tabel2 set nama='$nama',alias='$alias',keterangan='$keterangan',
						update_date='$date',update_userid='$cuserid' where secid='$secid' and subsecid='$subsecid'";
			$hasil = sql($perintah);

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan SUB ID $subsecid");
				header("location: $alamat&aksi=viewsubsec&secid=$secid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=viewsubsec&secid=$secid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editsubsec")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewsubsec&secid=$secid");
			mainaction($mainmenu,$param);
			
			$sql = "select secid,nama,keterangan from $nama_tabel2  where secid='$secid' and subsecid='$subsecid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$secid = $row['secid'];
			$nama = $row['nama'];
			$keterangan = $row['keterangan'];
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditsubsec">
            <input type="hidden" name="secid" value="<?php echo $secid?>">
            <input type="hidden" name="subsecid" value="<?php echo $subsecid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Sub Kategori</th>
				</tr>
				<tr> 
					<td valign="top">Nama Sub Kategori</td> 
					<td align="left"><input name="nama" value="<?php echo $nama?>" type="text" size="40" id="nama" class="validate[required]"  /></td>
				</tr>
                <tr> 
					<td >Keterangan</td>
					<td ><textarea name="keterangan" cols="76" rows="5" id="keterangan" class="validate[required]"><?php echo $keterangan?></textarea></td>
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
	if($aksi=="viewsubsec")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Konten","back","$alamat&aksi=view");
			$mainmenu[] = array("Lihat Kategori","lihat","$alamat&aksi=viewsec");
			$mainmenu[] = array("Tambah Kategori","tambah","$alamat&aksi=tambahsec");
			$mainmenu[] = array("Lihat Sub Kategori","lihat","$alamat&aksi=viewsubsec&secid=$secid");
			$mainmenu[] = array("Tambah Sub Kategori","tambah","$alamat&aksi=tambahsubsec&secid=$secid");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Kategori","str","text","$data");
			
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where']." and secid='$secid'";
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("nama","asc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel2 where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select subsecid,secid,nama,keterangan from $nama_tabel2  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=40%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Kategori</a></th>\n");
			print("<th width=50%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">Keterangan</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$subsecid= $row['subsecid'];
				$secid = $row['secid'];
				$nama = $row['nama'];
				$keterangan = $row['keterangan'];

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=tambahsubsec&secid=$secid&hlm=$hlm\">$nama</a><br clear=\"all\" /></td>\n
					<td  valign=top >$keterangan</td>
				");
					
				print("<td>");
				
				$acc[] = array("Edit","edit","$alamat&aksi=editsubsec&secid=$secid&subsecid=$subsecid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapussubsec&secid=$secid&subsecid=$subsecid&hlm=$hlm");
								
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

	if($aksi=="editgambar")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,tipe from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$tipe = $row['tipe'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditgambar">
            <input type="hidden" name="id" value="<?php echo $id?>">
            <input type="hidden" name="tipe" value="<?php echo $tipe?>">
             <input type="hidden" name="nama" value="<?php echo $nama?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Gambar Depan</th>
				</tr>
				<tr> 
					<td valign="top">Judul</td> 
					<td align="left"><input name="namas" value="<?php echo $nama?>" type="text" size="40" id="namas" readonly="readonly"  /></td>
				</tr>
                <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /></td>
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
	
	if($aksi=="saveeditgambar")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_POST['id'];
			$alias = getAlias($_POST['nama']);
			$tipe = $_POST['tipe'];

			//Upload Gambar
			if(!file_exists("$pathfile/$tipe")) mkdir("$pathfile/$tipe");
			
			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "$tipe-$alias-$id.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$tipe/$namagambars",$gambars_maxw,$gambars_maxh);

				$perintah = "update $nama_tabel set gambar='$namagambars' where id='$id'";
				$hasil = sql($perintah);

			}
			

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//Hapus
	if($aksi=="hapusgambar")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id = $_GET['id'];
			$perintah 	= "select gambar,tipe from $nama_tabel where id='$id'";
			$hasil 		= sql($perintah);
			$row		= sql_fetch_data($hasil);
			
			$gambar 	= $row['gambar'];
			$tipe 		= $row['tipe'];
			if ($tipe=="text" or $tipe=="audio")
			{
				if(!empty($gambar)) unlink("$pathfile$tipe/$gambar1");
			}
				

			$perintah = "update $nama_tabel set gambar='' where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus gambar dengan Data dengan ID $id");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gambar tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	if($aksi=="hapusgambarlarge")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id = $_GET['id'];
			$perintah 	= "select gambar1,tipe from $nama_tabel where id='$id'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar1 	= $row['gambar1'];
			$tipe 	= $row['tipe'];
			
			if ($tipe=="text" or $tipe=="audio")
			{
				if(!empty($gambar1)) unlink("$pathfile$tipe/$gambar1");
			}
				

			$perintah = "update $nama_tabel set gambar1='' where id='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Success mengapus gambar dengan Data dengan ID $id");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gambar tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&error=$error");
				exit();
			}
		}
	}	
	if($aksi=="saveeditgambarlarge")
	{
		
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_POST['id'];
			$alias = getAlias($_POST['nama']);
			
			$tipe = $_POST['tipe'];
			
			if($tipe=="text" or $tipe=="audio")
			{
			
				if($_FILES['gambar']['size']>0)
				{
					$ext = getimgext($_FILES['gambar']);
					$namagambarl = "$tipe-$alias-$new-l.$ext";
					$gambarl = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/$tipe/$namagambarl",$gambarl_maxw,$gambarl_maxh);
	
					$perintah = "update $nama_tabel set gambar1='$namagambarl' where id='$id'";
					$hasil = sql($perintah);
	
				}
			}
			

			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editgambarlarge")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,tipe from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id = $row['id'];
			$nama = $row['nama'];
			$tipe = $row['tipe'];
			
			?>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditgambarlarge">
 
            <input type="hidden" name="id" value="<?php echo $id?>">
            <input type="hidden" name="tipe" value="<?php echo $tipe?>">
             <input type="hidden" name="nama" value="<?php echo $nama?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Gambar Large</th>
				</tr>
				<tr> 
					<td valign="top">Judul</td> 
					<td align="left"><input name="namsa" value="<?php echo $nama?>" type="text" size="40" id="namas" readonly="readonly"  /></td>
				</tr>
                <tr> 
					<td >Gambar</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /></td>
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