<?php 
//Variable halaman ini
$nama_tabel    = "tbl_member_abuse";
$judul_per_hlm = 25;
$otoritas      = kodeoto($kanal);
$oto           = $otoritas[0];

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
			$mainmenu[] = array("Lihat Abuse","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("userid","From","str","text",$data);
			$cari[] = array("touserid","To Usermembe","str","text",$data);
			$cari[] = array("keterangan","Keterangan","str","text",$data);
			$cari[] = array("create_date","Tanggal","date","date",$data);

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
			
			$sql = "select id,userid,touserid,keterangan,create_date from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=id\" title=\"Urutkan\">ID</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&order=userName\" title=\"Urutkan\">From</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&order=toUserName\" title=\"Urutkan\">To Username</a></th>\n");
			print("<th width=25%><a href=\"$urlorder&order=isi\" title=\"Urutkan\">Keterangan</a></th>\n");
			print("<th width=15%><a href=\"$urlorder&order=tanggal\" title=\"Urutkan\">Tanggal</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id     = $row['id'];
				$userid   = $row['userid'];
				$touserid = $row['touserid'];
				$isi        = $row['keterangan'];
				$tanggal    = tanggal($row['create_date']);
				
				$username = sql_get_var("select username from tbl_member where userid='$userid'");
				$tousername = sql_get_var("select username from tbl_member where userid='$touserid'");
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top>&nbsp;<b>$id</b></td>
					<td valign=top>$username</td>
					<td valign=top>$tousername</td>
					<td valign=top>$isi</td>
					<td valign=top>$tanggal</td>");
					
				print("<td>");

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
	
		
	//Hapus
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
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
	
}

?>