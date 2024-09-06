<?php  
//Variable halaman ini
$nama_tabel		= "tbl_wa";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];


 
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Album
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Pesan","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
	
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("userphonegsm","Nomor","str","text","$data");
			$cari[] = array("pesan","Pesan","str","text","$data");

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
			
			$sql = "select id,create_date,update_date,status,userphonegsm,pesan from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=1%>Nomor</th>\n");
			print("<th width=20%>Tanggal</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=userphonegsm\" title=\"Urutkan\">Nomor Handphone</a></th>\n");
			print("<th width=40%><a href=\"$urlorder&order=pesan\" title=\"Urutkan\">Pesan</a></th>\n");
			print("<th width=10%>Status</th>");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$userphonegsm    = $row['userphonegsm'];
				$secid   = $row['secid'];
				$tanggal     = tanggaljam($row['create_date']);
				$status     = $row['status'];
				$ringkas = $row['ringkas'];
				$pesan = $row['pesan'];
				
				if($status==1) $stat = "<span class=\"label label-success\">terkirim</span>";
				else  $stat = "<span class=\"label label-default\">pending</span>";
				
				

				print("<tr class=\"row$i\"><td height=20 valign=top>&nbsp;$a</td><td height=20 valign=top>$tanggal</td>
					<td  valign=top class=judul>$userphonegsm</td>\n");
				print("<td valign=top class=hitam>$pesan</td>\n");
				print("<td valign=top class=hitam>$stat</td>\n");
				print("<td>");

								
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
	
	
	
	
}

?>