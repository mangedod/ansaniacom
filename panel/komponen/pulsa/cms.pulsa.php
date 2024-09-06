<?php 
//Variable halaman ini
$nama_tabel		= "tbl_modem";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];


//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['id'];
 

if(!$oto['oto']) { echo $error['oto']; }
else
{

	
	//Detail
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select lastupdate,pulsa,pulsasms,msisdn from $nama_tabel";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			

			$msisdn = $row['msisdn'];
			$pulsasms = $row['pulsasms'];
			$pulsa = $row['pulsa'];
			$lastupdate = $row['lastupdate'];
		
			?>
			<form method="post" name="menufrm" id="menufrm">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Detail Informasi Pulsa</th>
				</tr>
				<tr> 
					<td valign="top" width="20%" class="tdinfo">MSISDN</td> 
					<td align="left"><?php echo $msisdn?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Pulsa Reguler</td>
					<td ><?php echo $pulsa?></td>
				</tr>
                <tr> 
					<td class="tdinfo" >Pulsa SMS</td>
					<td><?php echo $pulsasms?></td>
				</tr>
                 <tr> 
					<td class="tdinfo" >Tanggal Update</td>
					<td><?php echo $lastupdate?></td>
				</tr>
			
			</table>
			</form>
            
            <?php 
		}
	}
}

?>