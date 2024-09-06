<?php
//Variable halaman ini
$rubrik 		= "SMS Masuk";
$nama_tabel		= "tbl_smsc_smskeluar";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
$alamatsms		= "index.php?kanal=smsckirim&tab=$tab&tabsub=$tabsub";

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
			$mainmenu[] = array("Lihat SMS Keluar","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[]		  = array("msisdn","No Handphone","str","text","$data");
			$cari[]       = array("pesan","Pesan","str","text","$data");
			$cari[]		  = array("terima","Tanggal Terima","date","date","$date");	
			$formcari     = cmsformcari($cari,$pageparam);
			$where        = $formcari[0]['where'];
			$param        = $formcari[0]['param'];

			//Orderring
			$order    = getorder("id","desc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];

			$tot = sql_get_var("select count(*) as jml from $nama_tabel where 1 $where $parorder");
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select id,msisdn,create_date,terima,pesan,status from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i	 = 1;
			$no  = (($hlm - 1) * $judul_per_hlm) + 1;

			echo "<table border=0 class='tabel-cms' width=100% cellpadding='1' cellspacing='1'><thead><tr>";
			echo "<th width=5%>Nomor</th>";
			echo "<th width=15%><a href='$urlorder&order=msisdn' title='Urutkan'>No Handphone</a></th>";
			echo "<th width=15%><a href='$urlorder&order=kirim' title='Urutkan'>Tanggal Kirim</a></th>";
			echo "<th width=30%>Pesan</th>";
			echo "<th width=10%>Status</th>";
			echo "<th width=10% align='center'><b>Action</b></th>";
			echo "</tr></thead>";

			while($row = sql_fetch_data($hsl))
			{
				$id		= $row['id'];
				$msisdn	= $row['msisdn'];
				$kirim	= $row['create_date'];
				$terima = $row['terima'];
				$status	= $row['status']; 
				$pesan	= $row['pesan'];
				
				if($status == "0") 
					$namastat = "<span class='label label-warning'>Diantrikan</span>";
				else if($status == "2") 
					$namastat = "<span class='label label-success'>Terkirim</span>";
				else 
					$namastat = "<span class='label label-warning'>Proses</span>";

				echo "<tr class='row$i'>";
				echo "<td valign='top'>$no</td>";
				echo "<td valign='top'><b>$msisdn</b></td>";
				echo "<td valign='top'>$kirim</td>";
				echo "<td valign='top'>$pesan</td>";
				echo "<td valign='top'>$namastat</td>";
				echo "<td>";
				
				$acc[] = array("Teruskan","edit","$alamatsms&sms=keluar&id=$id");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&id=$id&hlm=$hlm");

				cmsaction($acc);
				unset($acc);

				echo "</td></tr>";

				$i %= 2;
				$i++;
				$no++;
				$ord++;
				unset($housekeepingtask);
				// echo"<br>";
			}
			echo "</table><br clear='all'/>";

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			sql_free_result($hsl);
		}
	}

	//Hapus Data
	if($aksi=="hapus")
	{
		if(!$oto['delete']) { echo $error['delete']; } else 
		{
			$sql1	= "select `id`,`msisdn`,`pesan`,`create_date`,`status` from $nama_tabel where id='$id'";
			$query1	= sql($sql1);
			$row1	= sql_fetch_data($query1);
			$id			= $row1['id'];
			$msisdn		= $row1['msisdn'];
			$pesan		= $row1['pesan'];
			$tanggal	= $row1['create_date'];
			$status		= $row1['status'];
			
			$sql	= "select max(id) as idbaru from tbl_smsc_trash_smskeluar";
			$query	= sql($sql);
			$idbaru	= sql_result($query,0,idbaru) + 1;
		
			$perintah 	= "insert into tbl_smsc_trash_smskeluar (`id`,`msisdn`,`pesan`,`create_date`,`status`,`create_userid`) 
							values ('$idbaru','$msisdn','$pesan','$tanggal','$status','$cuserid')";
			$hasil 		= sql($perintah);
	
			$sql = "delete from $nama_tabel where id='$id'";
			$hsl = sql($sql);
			if($hsl)
			{
				$msg = base64_encode("Success mengapus data dengan ID $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal menghapus data silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
}
?>