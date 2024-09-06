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
			
			$sql1 = "SELECT warehouseid,nama from tbl_warehouse where 1";

			$warehouse = array();
			$hsl1      = sql($sql1);
			?>
            	<script>
					$(function() {
						$(document).on('change keyup', '.stock-item',function(){
							var total = 0;
							
							var tr = this.closest("tr"); 
							
								$('td',tr).each(function(e){
									$('.stock-item',$(this)).each(function(){
											if ($(this).val() && !isNaN($(this).val())){
												total += parseInt($(this).val());
												console.log($(this).val());
											}
									});
								});
								
								$(".totalstok",tr).val(total);
							
						});
					});
				</script>
            
            <?php
			
			echo"<form method=\"post\" name=\"menufrm\" id=\"menufrm\">
				<input type=\"hidden\" name=\"aksi\" value=\"saveupdatestok\">";
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr>\n");
			print("<th width=2%>Kode</th><th width=20%>Nama Produk</th>\n");
			while($row1 = sql_fetch_data($hsl1))
			{
				$warehouseid = $row1['warehouseid'];
				
				print("<th width=5%>$row1[nama]</th>\n");
				
				$warehouse[$warehouseid] = array("warehouseid"=>$warehouseid,"nama"=>$row1['nama']);
			}
			print("<th width=5% align=center><b>Total</b></th></tr></thead>");


				$sql = "SELECT produkpostid,title,kodeproduk from tbl_product_post where 1 $where $parorder limit $ord, $judul_per_hlm";

				$kartustok = array();
				$sumall        = 0;
				$hsl           = sql($sql);
				
				$i = 1;
				$a = 1;
	
				while($row = sql_fetch_data($hsl))
				{
					$produkpostid = $row['produkpostid'];
					$nomor        = $row['title'];
					$kode        = $row['kodeproduk'];
					
					$sql2 = "SELECT produktotalid,produkpostid,totalstok from $nama_tabel where produkpostid='$produkpostid'";
					$qry2 = sql($sql2);
					$row2 = sql_fetch_data($qry2);
					$produktotalid = $row2['produktotalid'];
					$totalstok = $row2['totalstok'];
					
					
					print("<tr class=\"row$i\">
						<td  valign=top class=judul>$kode</td><td  valign=top class=judul>
							<input type=\"hidden\" name=\"produktotalid[]\" value=\"$produktotalid\" />
							<input type=\"hidden\" name=\"produkpostid[]\" value=\"$produkpostid\" />$nomor</td>");
					
					$totalwh = 0;
					foreach($warehouse as $key => $index)
					{
						$warehouseid = $index['warehouseid'];
						$hsl2 = sql("select produkwhid, totalstok from $nama_tabel1 where produkpostid='$produkpostid' and warehouseid='$warehouseid'");
						$row2 = sql_fetch_data($hsl2);
						$produkwhid = $row2['produkwhid'];
						$totalstokwh = $row2['totalstok'];
						
						print("<td>
								<input type=\"hidden\" name=\"produkwhid[$produkpostid][]\" value=\"$produkwhid\" />
								<input type=\"hidden\" name=\"warehouseid[$produkpostid][]\" value=\"$warehouseid\" />
								<input type=\"text\" name=\"totalstokwh[$produkpostid][]\" value=\"$totalstokwh\" class=\"stock-item\" size=\"5\" /></td>\n");
					}
					print("<td><input type=\"text\" size=\"5\" name=\"totalstok[]\" value=\"$totalstok\" class=\"totalstok\" readonly /></td>\n</tr>");
					
					$totalstokall = $totalstokall+$totalstok;
					$a++;
					$i++;
				
			}
			print("</table><br clear='all'>");
			print("<div class=\"btn-group\" >
              	<input type=\"submit\" class=\"btn\"  value=\"Save Stok\" />
	            </div>");
			print("</form>");
			sql_free_result($hsl);

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
		}
	}
	
	if($aksi == "saveupdatestok")
	{
		if(!$oto['add']) { echo $error['add']; } else
		{
			// --------------------------------------------------------- CHECK STATUS GUDANG -----------------------------------------
			//$cekgudang = cekgudangfreeze(1);
			if(empty($cekgudang))
				echo '';
			else{
				header("location:$alamat&aksi=view&hlm=$hlm&error=$cekgudang");
				exit();
			}

			$produktotalid	= $_POST['produktotalid'];

			// print_r($_POST["totalstok"]);
//			 exit;

			foreach ($produktotalid as $key => $id) {
				$produktotalid		= $_POST['produktotalid'][$key];
				$produkpostid       = $_POST["produkpostid"][$key];
				$totalstok         = $_POST["totalstok"][$key];
				
				$warehouseid = $_POST['warehouseid'][$produkpostid];
				foreach ($warehouseid as $key2 => $id) {
					$produkwhid		= $_POST['produkwhid'][$produkpostid][$key2];
					$warehouseid	= $_POST['warehouseid'][$produkpostid][$key2];
					$totalstokwh	= $_POST['totalstokwh'][$produkpostid][$key2];
					
					if(empty($produkwhid))
					{
						$perintah 	= "insert into $nama_tabel1 (`produkpostid`,`warehouseid`,`totalstok`) values ('$produkpostid','$warehouseid','$totalstokwh')";
						$hasil 		= sql($perintah);
					}
					else
					{
						$perintah 	= "update $nama_tabel1 set totalstok='$totalstokwh' where produkwhid='$produkwhid' and produkpostid='$produkpostid' and warehouseid='$warehouseid'";
						$hasil 		= sql($perintah);
					}
				}
				if(empty($produktotalid))
				{
					$newproduktotalid 	= newid("produktotalid",$nama_tabel);
					$sqlinsptl        	= "insert into $nama_tabel (produktotalid,produkpostid,totalstok)
											values ('$newproduktotalid','$produkpostid','$totalstok')";
			    	$hslsql 			= sql($sqlinsptl);
				}
				else
				{
					$perintah 	= "update $nama_tabel set totalstok='$totalstok' where produktotalid='$produktotalid' and produkpostid='$produkpostid'";
					// echo $perintah."<br>";
					$hasil 		= sql($perintah);
				}
			}
			// die();

 		if($hasil)
			{
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perubahan Stok Produk dengan ID $produkpostid",$uri,$ip);
					
				$msg = base64_encode("Spesifikasi produk $namabarang berhasil diupdate");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				/*else header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");*/
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error&msg=$msg");
				exit();
			}
		}
	}

}
?>