<?php 
//Variable halaman ini
$nama_tabel		= "tbl_cms_usergroup";
$nama_tabel2	= "tbl_cms_menu";
$nama_tabel3	= "tbl_cms_menusub";
$nama_tabel4	= "tbl_cms_menuchild";
$judul_per_hlm 	= 10;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['gid'])) $gid = $_POST['gid'];
 else $gid = $_GET['gid'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat User Group","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("namagroup","Nama Group","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("gid","asc",$pageparam);
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
			
			$sql = "select namagroup,gid,description from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=gid\" title=\"Urutkan\">GroupID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=namagroup\" title=\"Urutkan\">Nama Group</a></th>\n");
			print("<th width=45% ><a href=\"$urlorder&order=description\" title=\"Urutkan\">Keterangan</a></th>");
			print("");
			print("<th width=10% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$namagroup = $row['namagroup'];
				$gid = $row['gid'];
				$keterangan = $row['description'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$gid</b></td>
					<td  valign=top class=judul>$namagroup</td>\n");
				print("<td valign=top class=hitam>$keterangan</td>\n");
				print("<td>");
				
				$acc[] = array("Atur Otoritas","edit","$alamat&aksi=aturotoritas&gid=$gid&hlm=$hlm");
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
	
	//Save Otoritas
	if($aksi=="saveotoritas")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$gid = $_POST['gid'];
			$kode = $_POST['kode']; 
			$pilihan = $_POST['pilihan'];
			
			$oto = "";
			for($i=0;$i<count($kode);$i++)
			{
				$ko = $kode[$i];
				$pil = "";
				
				if(!empty($pilihan[$ko]['view'])) $pil .= "1";
				if(!empty($pilihan[$ko]['add'])) $pil .= "2";
				if(!empty($pilihan[$ko]['edit'])) $pil .= "3";
				if(!empty($pilihan[$ko]['delete'])) $pil .= "4";
				
				$oto .= $ko.$pil."~";
							
			}
		
			$perintah = "update $nama_tabel set otoritas='$oto' where gid='$gid'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Berhasil mengubah Otoritas untuk Group ID $gid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal mengubah Otoritas untuk Group ID $gid silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
			
		}
	}

	
	//Atur Otoritas
	if($aksi=="aturotoritas")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$gid = $_GET['gid'];
			
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select namagroup,gid,description,otoritas from $nama_tabel  where gid='$gid' ";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$namagroup = $row['namagroup'];
			$gid = $row['gid'];
			$keterangan = $row['description'];
			$otoritas = $row['otoritas'];
		?>
			
		<form method="post" name="formotoritas">
		<input type="hidden" name="aksi" value="saveotoritas">
		<input name="gid" type="hidden" class="textfield2" id="gid" value="<?php echo $gid ?>" >
        <table border="0" class="tabel-cms" width="100%">
            <tr>
                <th >Ubah Otoritas Group : <?php echo $namagroup;?></th>
			</tr>
            <tr>
            	<td>
				<input type="submit" name="Submit" value="Simpan Otoritas" class="button" />
            	<input type="button" onclick="javascript:history.back()" class="button" value="Batal">&nbsp;&nbsp;
				</td>
			</tr>
            
				<script type="text/javascript">
                    $(function () { 
                    $('.checkall').click(function () {
                        $(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
                        });
                    });
                                
                    function checkitem(id)
                    {
                        $("."+id).attr('checked', $('#' + id).is(':checked'));
                    }
                </script>

				<?php 
                    $perintah = "select menuid,nama,kode from $nama_tabel2 where kode!='' order by menuid asc ";
                    $hsl = sql($perintah);
                    $i=1;
                    while ($row = sql_fetch_data($hsl))
                    {
                        $menuid = $row['menuid'];
                        $kode1 = $row['kode'];
                        $name = $row['nama'];
							
						echo "<tr>
            						<th ><strong>$name</strong></th>
								</tr>
								<tr>
									<td ><table width='100%'>
							";
			
							$perintah1 = "select kode,menusubid,nama from $nama_tabel3 where kode!='' and menuid='$menuid' order by menusubid asc ";
							$hsl1 = sql($perintah1);
							$a=1;
							while ($row1 = sql_fetch_data($hsl1))
							{
								$kode1 = $row1['kode'];
								$name = $row1['nama'];
								$menusubid = $row1['menusubid'];
							
								echo "
									<tr>
										<td > <strong>$name</strong> </td>
									</tr>
									<tr>
										<td><table  width='100%' >
								";
							
								$perintah2 = "select menuchildid,kode,nama from $nama_tabel4 where kode!='' and menuid='$menuid' and menusubid='$menusubid' order by menuchildid asc ";
								$hsl2 = sql($perintah2);
								$b=1;
								while ($row2 = sql_fetch_data($hsl2))
								{
									$kode1 = $row2['kode'];
									$name = $row2['nama'];
									
									$cek1  = substr_count($otoritas,"$kode1");
									if($cek1 !=0) { $status1 = "checked"; } else $status1="";
									
									$otoritas2 = explode("$kode1",$otoritas);
									$test = $otoritas2[1];
									
									$otoritas3 = explode("~",$test);
									$test = $otoritas3[0];
									
									$cek2  = substr_count($test,"1");
									if($cek2 !=0) { $status2 = "checked"; } else $status2="";
									$cek3  = substr_count($test,"2");
									if($cek3 !=0) { $status3 = "checked"; } else $status3="";
									$cek4  = substr_count($test,"3");
									if($cek4 !=0) { $status4 = "checked"; } else $status4="";
									$cek5  = substr_count($test,"4");
									if($cek5 !=0) { $status5 = "checked"; } else $status5="";

									echo" <tr class=\"row$b\">
											<td width=20%><input name=\"kode[]\" "; if ($status1 == 'checked') echo"checked=\"checked\""; echo"type=\"checkbox\"  id=\"$kode1\" onclick=\"checkitem(this.id)\" value=\"$kode1\" /> $name </td>
											<td width=20%><input name=\"pilihan[$kode1][view]\" "; if($status2 == 'checked') echo"checked=\"checked\""; echo"type=\"checkbox\" class=\"$kode1\" value=\"1\" /> Lihat Data</td>
                                            <td width=20%><input name=\"pilihan[$kode1][add]\" "; if($status3 == 'checked') echo"checked=\"checked\""; echo"type=\"checkbox\" class=\"$kode1\" value=\"2\" /> Tambah Data</td>
                                            <td width=20%><input name=\"pilihan[$kode1][edit]\" "; if($status4 == 'checked') echo"checked=\"checked\""; echo"type=\"checkbox\" class=\"$kode1\" value=\"3\" /> Ubah Data</td>
                                            <td width=20%><input name=\"pilihan[$kode1][delete]\" "; if($status5 == 'checked') echo"checked=\"checked\""; echo"type=\"checkbox\" class=\"$kode1\" value=\"4\" /> Hapus Data</td>
									</tr>";
									$b %= 2;
									$b++;
									
								}
								echo "</table></td></tr>";
								$a %= 2;
								$a++;
							}
							
						echo "</table></td></tr>";
						$i %= 2;
						$i++;
					}
		  		?>
		  	<tr>
            	<td colspan="4"><input type="submit" name="Submit" value="Simpan Otoritas" class="button" />
            	<input type="button" onclick="javascript:history.back()" class="button" value="Batal">&nbsp;&nbsp;</td>
            </tr>
        	</table>
        </form>
		<?php 	
		}
	}
	
}
?>