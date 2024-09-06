<?php 
//Variable halaman ini
$nama_tabel		= "tbl_subscriber";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;


//Variable Umum
if(isset($_POST['subscriberid'])) $id = $_POST['subscriberid'];
 else $id = $_GET['subscriberid'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("View Subcribers","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("userfullname","Name","str","text","$data");
			$cari[] = array("useremail","Email","str","text","$data");
			$cari[] = array("kota","City","str","text","$data");

			$cari[] = array("create_date","Create Date","date","date","$data");
			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("subscriberid","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
						
			$sql = "select count(*) as jml from $nama_tabel where bounce='1' and 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql = "select subscriberid,userfullname,useremail,userhandphone,kota,bounce from $nama_tabel  where bounce='1' and 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>No</th>\n");
			print("<th width=70%><a href=\"$urlorder&order=userfullname\" title=\"Urutkan\">Name</a></th>\n");
			print("<th width=10%><a href=\"$urlorder&order=useremail\" title=\"Urutkan\">Email</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=userhandphone\" title=\"Urutkan\">Phone</a></th>\n");
			print("<th width=5%><a href=\"$urlorder&order=kota\" title=\"Urutkan\">City</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id        = $row['subscriberid'];
				$nama      = $row['userfullname'];
				$email     = $row['useremail'];
				$telepon   = $row['userhandphone'];
				$kota      = $row['kota'];
                                $bounche    = $row['bounce'];
                                
                                if($bounche=="1") $bounce ="Bounce";
				 else $bounce ="Aktif";
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top >$nama</td>\n
					<td  valign=top >$email</td>
					<td  valign=top >$telepon</td>
					<td  valign=top >$kota</td>");
					
				print("<td>");
                                
				$acc[] = array("Detail","detail","$alamat&aksi=detail&id=$id&hlm=$hlm");
				$acc[] = array("Delete","delete","$alamat&aksi=hapus&id=$id&hlm=$hlm");
								
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
	
        //Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Back","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select subscriberid,userfullname,useremail,userhandphone,kota, create_date from $nama_tabel  where subscriberid ='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$id            = $row['subscriberid'];
			$nama          = $row['userfullname'];
			$email         = $row['useremail'];
			$telepon       = $row['userhandphone'];
			$kota          = $row['kota'];
			$create_date   = tanggal($row['create_date']);
                        
			?>
			<form method="post" name="menufrm" id="menufrm">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail</th>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">Name</td> 
					<td align="left"><?php echo $nama?></td>
				</tr>
                <tr> 
					<td valign="top" width="20%" class="tdinfo">Email</td> 
					<td align="left"><?php echo $email?></td>
				</tr>
                <tr> 
					<td  class="tdinfo">Phone</td>
					<td ><?php echo $telepon?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >City</td>
					<td ><?php echo $kota?></td>
				</tr>
                <tr> 
					<td class="tdinfo">Create Date</td>
					<td><?php echo $create_date?></td>
				</tr>
			</table>
			</form>
            
            <?php 
		}
	}
        
	//Hapus
	if($aksi=="hapus")
	{
		
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			
			$id       = $_GET['id'];

			$perintah = "delete from $nama_tabel where subscriberid='$id'";
			$hasil = sql($perintah);
			if($hasil)
			{   
				$msg = base64_encode("Data has been successfully removed with ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data can't be deleted and please try again");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
}
?>