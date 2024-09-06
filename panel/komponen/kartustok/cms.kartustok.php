<?php
//Variable halaman ini
$nama_tabel		= "tbl_product_total";
$nama_tabel1	= "tbl_product_wh";
$judul_per_hlm 	= 100;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//View Data
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; } else 
		{
			$mainmenu[] = array("Lihat ","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("title","Nama Produk","str","text","$data");
			$cari[] = array("kodeproduk","Kode Produk","str","text","$data");

			$formcari     = cmsformcari($cari,$pageparam);
			$where        = $formcari[0]['where'];
			$param        = $formcari[0]['param'];

			//Orderring
			$order    = getorder("produkpostid","desc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];

			if(!preg_match('/update_date/', $where))
			{
				$thismonth = date("m");
				$thisyear  = date("Y");
			
			}

			$tot = sql_get_var("select count(*) as jml from tbl_product_post where 1 $where");

			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			$sql1 = "SELECT warehouseid,nama from tbl_warehouse where 1";

			$warehouse = array();
			$hsl1      = sql($sql1);

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Kode Produk</th><th width=45%>Nama Produk</th>\n");
			while($row1 = sql_fetch_data($hsl1))
			{
				$warehouseid = $row1['warehouseid'];
				
				print("<th>$row1[nama]</th>\n");
				
				$warehouse[$warehouseid] = array("warehouseid"=>$warehouseid,"nama"=>$row1['nama']);
			}
			print("<th width=5% align=center><b>Total</b></th></tr></thead>");
			
		


				$sql2 = "SELECT produkpostid,title,kodeproduk from tbl_product_post where 1 $where $parorder limit $ord, $judul_per_hlm";
	
				// $kartustok = array();
				$sumall        = 0;
				$hsl2           = sql($sql2);
				
				$i = 1;
				$a = 1;
					
				while($row = sql_fetch_data($hsl2))
				{
					$produkpostid = $row['produkpostid'];
					$nomor        = $row['title'];
					$kodeproduk        = $row['kodeproduk'];
					
					
					$sql2 = "SELECT produktotalid,produkpostid,totalstok from $nama_tabel where produkpostid='$produkpostid'";
					$qry2 = sql($sql2);
					$row2 = sql_fetch_data($qry2);
					$produktotalid = $row2['produktotalid'];
					$totalstok = $row2['totalstok'];
					
					print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$kodeproduk</td><td width=5% height=20 valign=top>&nbsp;$nomor</td>
						");
					
					$totalwh = 0;
					foreach($warehouse as $key => $index)
					{
						$warehouseid = $index['warehouseid'];
						$totalstokwh = sql_get_var("select totalstok from $nama_tabel1 where produkpostid='$produkpostid' and warehouseid='$warehouseid'");
						print("<td>$totalstokwh</td>\n");
					}
					print("<td>$totalstok</td>\n</tr>");
					
					$totalstokall = $totalstokall+$totalstok;
					$a++;
					$i++;
					
				
			}

			print("</table><br clear='all'>");

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
		}
	}
}
?>