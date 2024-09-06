<?php 
//Variable halaman ini
$nama_tabel		= "tbl_instagram";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 500;
$gambarl_maxh = 300;
$yearm	= date("Ym");


//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];


if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Konten","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Blog","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Judul","str","text","$data");
			$cari[] = array("instagramid","Instagram ID","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");
			
			$dataselect[] = array("0","Draft");
			$dataselect[] = array("1","Published");
			
			$cari[] = array("published","Status","select","select",$dataselect);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("id","desc",$pageparam,$param);
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
			
			$sql = "select id,nama,instagramid,published,gambar from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=15%>Gambar</th>\n");
			print("<th width=65%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Judul</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=instagramid\" title=\"Urutkan\">ID Instagram</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id        = $row['id'];
				$nama      = $row['nama'];
				$instagramid   = $row['instagramid'];
				$published = $row['published'];
				$secid     = $row['secid'];
				$gambar     = $row['gambar'];

				if(!empty($gambar)) $gambar = "<img src=\"../gambar/$kanal/$gambar\">";
				else $gambar = "Kosong";

				
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				 
			
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top >$gambar</td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=detail&id=$id&hlm=$hlm\">$nama</a></td>\n
					<td  valign=top >$instagramid</td>
					<td  valign=top >$publish</td>");
					
				print("<td>");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				
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
	

	
	
	//Hapus
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id = $_GET['id'];
			$perintah 	= "select gambar,gambar1, from $nama_tabel where id='$id'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);
			
			$gambar  = $row['gambar'];
			$gambar1 = $row['gambar1'];
			
			//Upload Gambar
			$simpangambar = "$pathfile/$kanal";
			
			if(!empty($gambar)) unlink("$simpangambar/$gambar");
			if(!empty($gambar1)) unlink("$simpangambar/$gambar1");
				

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
	
	
	
}

?>