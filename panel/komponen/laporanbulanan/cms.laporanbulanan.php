<?php 
//Variable halaman ini
$nama_tabel		= "tbl_member";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['pesanid'])) $pesanid = $_POST['pesanid'];
 else $pesanid = $_GET['pesanid'];
 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Laporan Bulanan","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$month	= array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
			while(list($bln,$namabulan) = each($month))
			{
				$dataselect[] = array("$bln","$namabulan");
			}
			
			$cari[] = array("bulan","Bulan","select","select",$dataselect);
			
			for($thn=2012; $thn<=date("Y"); $thn++)
			{
				$dataselect1[] = array("$thn","$thn");
			}
			
			$cari[] = array("tahun","Tahun","select","select",$dataselect1);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("userfullname","asc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
			
			if($_POST['bulan'])
				$bulan	= $_POST['bulan'];

			if($_GET['bulan'])
				$bulan	= $_GET['bulan'];

			if($_POST['tahun'])
				$tahun	= $_POST['tahun'];

			if($_GET['tahun'])
				$tahun	= $_GET['tahun'];

			if(empty($bulan))
				$bulan		= date("m");

			if(empty($tahun))
				$tahun		= date("Y");

			//echo "$bulan $tahun";

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th>Hari</th>\n");
			print("<th>Tanggal</th>\n");
			print("<th>Member Baru</th>\n");
			print("<th>Jumlah Order</th>\n");
			print("<th>Total Order</th>\n");
			print("<th>Paid Invoice</th>");
			print("<th>Total Paid</th>
					<th>Konfirmasi Pembayaran</th></tr></thead>");
			
			$totalhari	= cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
			$laporan	= array();
			for($h=1; $h<=$totalhari; $h++)
			{	
				$timeStamp	= mktime(0,0,0,$bulan,$h,$tahun);
				$hari		= getdate($timeStamp); 
				
				$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
								"Friday" => "Jumat", "Saturday" => "Sabtu", "Sunday" => "Minggu");
				$hari = $array_hari[$hari[weekday]];
				
				if ($bulan=="01") { $bulan1="Jan"; }
				if ($bulan=="02") { $bulan1="Feb"; }
				if ($bulan=="03") { $bulan1="Mar"; }
				if ($bulan=="04") { $bulan1="Apr"; }
				if ($bulan=="05") { $bulan1="Mei"; }
				if ($bulan=="06") { $bulan1="Jun"; }
				if ($bulan=="07") { $bulan1="Jul"; }
				if ($bulan=="08") { $bulan1="Agst"; }
				if ($bulan=="09") { $bulan1="Sep"; }
				if ($bulan=="10") { $bulan1="Okt"; }
				if ($bulan=="11") { $bulan1="Nov"; }
				if ($bulan=="12") { $bulan1="Des"; }
				
				if($h<10) $hh = "0".$h;
				else $hh = $h;
				
				$tanggal 	= "$hh $bulan1 $tahun";
				$tgll		= "$tahun-$bulan-$hh";
				
				//jumlah member
				$jummember	= sql_get_var("select count(userid) as jummember from tbl_member where left(usercreateddate,10)='$tgll'");
					$urlmember	= "$fulldomain/{$cms}/komunitas/member/data";
				
				//jumlah order & total order
				$sqlo	= "select count(id) as jumorder, sum(total_bayar) as torder from tbl_transaksi_konfirmasi where left(tgl_trans,10)='$tgll'";
				$reso	= sql($sqlo);
				$rowo	= sql_fetch_data($reso);
					$jumorder	= $rowo['jumorder'];
					$torder		= $rowo['torder'];
					
					if(!empty($torder)) $torder1 = number_format($torder,0,".",".");
					else $torder1 = 0;
					
					$urlorder	= "$fulldomain/{$cms}/transaksi/transaksi/data";
				sql_free_result($reso);
				
				//jumlah invoice
				$sqli	= "select count(id) as paidinv, sum(total_bayar) as tpaid from tbl_transaksi_konfirmasi where left(tgl_bayar,10)='$tgll' and (status='1' or status='3')";
				$resi	= sql($sqli);
				$rowi	= sql_fetch_data($resi);
					$paidinv	= $rowi['paidinv'];
					$tpaid		= $rowi['tpaid'];
					

					if(!empty($tpaid)) $tpaid1 = number_format($tpaid,0,".",".");
					else $tpaid1 = 0;
					
				sql_free_result($resi);
				
				//jumlah konfirmasi
				$konfirmasi	= sql_get_var("select count(id) as konfirmasi from tbl_transaksi_konfirmasi where left(tgl_konfirmasi,10)='$tgll'");
				
				print("<tr><td width=10% height=20 valign=top>$hari</td>
					<td width=10% height=20 valign=top>$tanggal</td>
					<td  valign=top class=judul>$jummember</td>
					<td  valign=top class=judul>$jumorder</td>
					<td  valign=top class=judul>Rp. $torder1,-</td>\n");
				print("<td valign=top class=hitam>$paidinv</td>
					<td valign=top class=hitam>Rp. $tpaid1,-</td>
					<td valign=top class=hitam>$konfirmasi</td></tr>");

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
	if($aksi=="popupuserid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			
			?>
            	<script type="text/javascript">
				function pushdata(userid,userfullname)
				{
					var res = new Object();
					res.userid = userid;
					res.userid_text = userfullname;
					window.returnValue = res;
					window.close();
					return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("userfullname","Nama Lengkap","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from tbl_member where 1 $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("userfullname","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select userfullname,userid from tbl_member  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">User Id</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Lengkap</a></th>\n");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$userfullname = $row['userfullname'];
				$userid = $row['userid'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$userid</b></td>
					<td  valign=top class=judul>$userfullname</td>");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$userid','$userfullname');\">Select</button>");
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