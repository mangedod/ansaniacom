<?php
	//Variable halaman ini
	$nama_tabel		= "tbl_transaksi_channel";
	$judul_per_hlm 	= 25;
	$otoritas		= kodeoto($kanal);
	$oto			= $otoritas[0];

	//Variable Umum
	if(isset($_POST['transaksiid'])) $transaksiid = $_POST['transaksiid'];
 	else $transaksiid = $_GET['transaksiid'];
	
	if(isset($_POST['bulan'])) $bulan = $_POST['bulan'];
 	else $bulan = $_GET['bulan'];
	
	if(isset($_POST['tahun'])) $tahun= $_POST['tahun'];
 	else $tahun= $_GET['tahun'];
	
	//View Menu
	if($aksi=="view")
	{
		$mainmenu[] = array("Lihat Laporan Transaksi","lihat","$alamat&aksi=view");
		//$mainmenu[] = array("Export Excel","excel","$alamat&aksi=exportxls");
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
		$order = getorder("transaksiid","asc",$pageparam,$param);
		$parorder = $order[0];
		$urlorder = $order[1];	
		
		if(!preg_match('/tahun/', $where))
			$tahun=date("Y");
		else
			$tahun= $_POST['tahun'];
			
		if(!preg_match('/bulan/', $where))
			$bulan=date("m");
		else
			$bulan= $_POST['bulan'];
		
		if(empty($cetak))
		{
			if(!empty($where))
			{
				$_SESSION['whereprint']	= $where;
				$_SESSION['tahun']		= $tahun;
				$_SESSION['bulan']		= $bulan;
			}
			
			if(!empty($_SESSION['whereprint']) and $cetak == "1")
			{
				$where	= $_SESSION['whereprint'];
				$_SESSION['tahun']		= $tahun;
				$_SESSION['bulan']		= $bulan;
			}
	
			if(empty($_SESSION['showfilter']))
			{
				unset($_SESSION['whereprint']);
				unset($_SESSION['tahun']);
				unset($_SESSION['bulan']);
			}
		}
		else
		{
			$where	= $_SESSION['whereprint'];
			$tahun	= $_SESSION['tahun'];
			$bulan	= $_SESSION['bulan'];
		}
		
		$namabulan=getBulan($bulan);
		print("<h2 align=center>Laporan Bulanan</h2>");
		print("<h3 align=center>Periode $namabulan $tahun</h3>");
		print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
		print("<tr>");
		print("<th width='40%'>Tanggal</th>\n");
		print("<th width='15%'>Jumlah Transaksi</th>\n");
		print("<th width='15%'>Total Invoice</th>\n");
		print("</tr></thead>");
		
		$namabulan = getBulan($bulan);
		$jumHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
		
		for($h=1; $h<=$jumHari; $h++)
		{	
			if($h<10)
				$tgl="0".$h;
			else
				$tgl=$h;
				
			$tanggal = "$tahun-$bulan-$tgl";
			$day = date('l', strtotime($tanggal));
			if($day=="Sunday")
				$color="#cacac9";
			else
				$color="";
			
			//transaksi
			$jml 	= sql_get_var("select count(*) as jumlah from  $nama_tabel where tanggaltransaksi='$tanggal'");
			$jmlinv	= sql_get_var("select sum(totalinvoice) as jumlah from  $nama_tabel where tanggaltransaksi='$tanggal'");

			//$jumtot	= number_format($jmlinv,0,".",".");
			
			print("<tr style=\"background-color:$color\">
				<td width=10% height=20 valign=top>$h $namabulan $tahun</td>
				<td  valign=top align=right>".number_format($jml,0,".",".")."</td>
				<td  valign=top align=right>".number_format($jmlinv,0,".",".")."</td></tr>");
		}
		$totaljml = sql_get_var("select count(*) as jumlah from  $nama_tabel where (MONTH(tanggaltransaksi)='".$bulan."') 
				and (YEAR(tanggaltransaksi)='".$tahun."')");
		$total = sql_get_var("select sum(totalinvoice) as jumlah from  $nama_tabel where (MONTH(tanggaltransaksi)='".$bulan."') 
				and (YEAR(tanggaltransaksi)='".$tahun."')");
		
		print("<tr>
			<td><strong>Jumlah</strong></td>
			<td align=right><strong>".number_format($totaljml,0,".",".")."</strong></td>
			<td align=right><strong>".number_format($total,0,".",".")."</strong></td>
		</tr>");
		print("</table><br clear='all'>");
		cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		//print("<a href='./komponen/cetak/laporanbulanan.php?tahun=$tahun&bulan=$bulan&cms_userid=$_SESSION[cms_userid]' target=\"_blank\" class=button>Cetak</a>");
	} //EndView 
	
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$jenistrx=$_GET['jenistrx'];
			if(!preg_match("/-/i", $jenistrx))
			{
				$where1="and jenistrx='$jenistrx'";
			}
			else
			{
				$jn=explode("-",$jenistrx);
				
				$where1="and (jenistrx='$jn[0]') or (jenistrx='$jn[1]')";
			}
			
			$mainmenu[] = array("Lihat Data","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("invoice-id","No. Invoice","str","text","$data");
			//$cari[] = array("crea","Tanggal Pesan","date","date","$data");
			
			$dataselect[] = array("0","Billed");
			$dataselect[] = array("1","Confirmed");
			$dataselect[] = array("2","Paid");
			
			$cari[] = array("statustagihan","Status Tagihan","select","select",$dataselect);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("create_date","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];	
						
			$sql = "select count(*) as jml from $nama_tabel where (substring(create_date,6,2)='$bulan') 
						and (substring(create_date,1,4)='$tahun') $where1";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			$sql1 = "select transaksiid,invoiceid,kodetrx,totaltagihan,conveniencefee,total,statustagihan,tipebayar from $nama_tabel where (substring(create_date,6,2)='$bulan') 
						and (substring(create_date,1,4)='$tahun') $where1 $parorder limit $ord, $judul_per_hlm";
			$hsl1 = sql($sql1);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Kode Transaksi</th>\n");
			print("<th width=20%>Invoice</th>\n");
			print("<th width=20%>Total</th>\n");
			print("<th width=20%>Conveinencefee</th>\n");
			print("<th width=20%>Total Tagihan</th>\n");
			print("<th width=20%>Metode Pembayaran</th>\n");
			print("<th width=20%>Status</th>\n");
			print("</tr></thead>");

			while ($row = sql_fetch_data($hsl1))
			{
				$transaksiid	= $row['transaksiid'];
				$invoiceid= $row['invoiceid'];
				$kodetrx= $row['kodetrx'];
				$totaltagihan= number_format($row['totaltagihan'],0,".",".");
				$conveniencefee= number_format($row['conveniencefee'],0,".",".");
				$total= number_format($row['total'],0,".",".");
				$statustagihan= $row['statustagihan'];
				$tipebayar= $row['tipebayar'];
				
				if($statustagihan==0)
					$stat="Billed";
				else if($statustagihan==1)
					$stat="Confirmed";
				else if($statustagihan==2)
					$stat="Paid";
				
				if($tipebayar==0)
					$payment="Transfer";
				else if($tipebayar==1)
					$payment="Debit Saldo";
					
				print("<tr class=\"row$i\"><td width=5% height=20 valign=center>$kodetrx</td>
					<td valign=top>$invoiceid</td>
					<td valign=top>Rp.$totaltagihan</td>
					<td valign=top>Rp. $conveniencefee</td>
					<td valign=top>Rp. $total</td>
					<td valign=top>$payment</td>
					<td valign=top>$stat</td>
					");
				
				/*print("<td>");
				
				$acc[] = array("Detail","detail","$alamat&aksi=detail&tanggal=$tanggal&userid=$userIdMember&hlm=$hlm");

				cmsaction($acc);
				unset($acc);
				
				print("</td></tr>");*/

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		}
	} //EndView 
	
	elseif(($aksi=="exportxls"))
	{
		if(!$oto['view']) { echo $error['view']; } else
		{
			
			if (!empty($_SESSION['whereprint']))
			{
				$where	= $_SESSION['whereprint'];
				$tahun	= $_SESSION['tahun'];
				$bulan	= $_SESSION['bulan'];	
			}
			$namabulan=getBulan($bulan);

			/** Error reporting */


			/** PHPExcel */
			require_once "$lokasiweb/librari/Classes/PHPExcel.php";

			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();

			// Set properties
			$objPHPExcel->getProperties()->setCreator("DKExpress")
										 ->setLastModifiedBy("DKExpress")
										 ->setTitle("Office 2007 XLSX Penjualan - Laporan Bulanan")
										 ->setSubject("Office 2007 XLSX Penjualan - Laporan Bulanan")
										 ->setDescription("Penjualan - Laporan Bulanan for Office 2007 XLSX, generated using PHP classes.")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Penjualan - Laporan Bulanan");
			
			// Create a sheet
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objPHPExcel->getActiveSheet()->mergeCells("A1:J1");
			$objPHPExcel->getActiveSheet()->setCellValue("A1", "Laporan Bulanan");
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize("14");
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle("A1:J1")->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			
			// sheet 2
			$objPHPExcel->getActiveSheet()->setCellValue("A2", "Periode $namabulan $tahun");
			$objPHPExcel->getActiveSheet()->mergeCells("A2:J2");
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize("12");
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle("A2:J2")->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));


			//border
			$styleThinBlackBorderOutline = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => 'FF000000'),),),);
			
			$isijudul	= array("A3"=>"Tanggal","B3"=>"Cash","C3"=>"Credit","D3"=>"Tagihan","E3"=>"Total Transaksi");
			foreach($isijudul as $col=>$isi)
			{
				$objPHPExcel->getActiveSheet()->getCell("$col")->setValue("$isi");
			}
			

			$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray(array('borders' => array('allborders'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
			$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
			$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray(array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,)));
			// Set thin black border outline around column
			$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($styleThinBlackBorderOutline);

			//width column
			$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth("25");
			$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth("20");
			$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth("20");
			$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth("20");
			$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth("20");

			$namabulan = getBulan($bulan);
			$jumHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
			
			$i = 4;
		
			for($h=1; $h<=$jumHari; $h++)
			{	
				if($h<10)
					$tgl="0".$h;
				else
					$tgl=$h;
					
				$tanggal = "$tahun-$bulan-$tgl";
				$day = date('l', strtotime($tanggal));
				if($day=="Sunday")
					$color="#cacac9";
				else
					$color="";
				
				//transaksi
				$cash 	= sql_get_var("select sum(totalbayar) as jumlah from  tbl_transaksi where tanggal='$tanggal' and tipebayar='1' and (kodecounter='000' or kodecounter='')");
				$credit	= sql_get_var("select sum(totalbayar) as jumlah from  tbl_transaksi where tanggal='$tanggal' and tipebayar='2' and (kodecounter='000' or kodecounter='')");
				$tagihan	= sql_get_var("select sum(totalbayar) as jumlah from  tbl_transaksi where tanggal='$tanggal' and tipebayar='3' and (kodecounter='000' or kodecounter='')");
				//total transaksi
				$jumtot = sql_get_var("select sum(totalbayar) from tbl_transaksi where tanggal='$tanggal' and (kodecounter='000' or kodecounter='')");
				//$jumtot	= number_format($jumtot,0,".",".");

				$isidata	= array("A$i"=>"$h $namabulan $tahun","B$i"=>$cash,"C$i"=>$credit,"D$i"=>$tagihan,"E$i"=>$jumtot);

				foreach($isidata as $col=>$isi)
				{
					$objPHPExcel->getActiveSheet()->getCell("$col")->setValue("$isi");
				}

				$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($styleThinBlackBorderOutline);
				$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray(array('borders' => array('allborders'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
				$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray(array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,)));

				$a++;
				$i++;
			}
			
			$totcash 	= sql_get_var("select sum(totalbayar) as jumlah from  tbl_transaksi where (MONTH(tanggal)='".$bulan."')
					and (YEAR(tanggal)='".$tahun."') and tipebayar='1' and (kodecounter='000' or kodecounter='')");
			$totcredit	= sql_get_var("select sum(totalbayar) as jumlah from  tbl_transaksi where (MONTH(tanggal)='".$bulan."') 
					and (YEAR(tanggal)='".$tahun."') and tipebayar='2' and (kodecounter='000' or kodecounter='')");
			$tottagihan	= sql_get_var("select sum(totalbayar) as jumlah from  tbl_transaksi where (MONTH(tanggal)='".$bulan."') 
					and (YEAR(tanggal)='".$tahun."') and tipebayar='3' and (kodecounter='000' or kodecounter='')");
			$total = sql_get_var("select sum(totalbayar) as jumlah from  tbl_transaksi where (MONTH(tanggal)='".$bulan."') 
					and (YEAR(tanggal)='".$tahun."' and (kodecounter='000' or kodecounter=''))");
			
			/**/

			$isidata	= array("A$i"=>"Total","B$i"=>$totcash,"C$i"=>$totcredit,"D$i"=>$tottagihan,"E$i"=>$total);

				foreach($isidata as $col=>$isi)
				{
					$objPHPExcel->getActiveSheet()->getCell("$col")->setValue("$isi");
				}
			
			$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray($styleThinBlackBorderOutline);
			$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray(array('borders' => array('allborders'=> array('style' => PHPExcel_Style_Border::BORDER_THIN))));
			$objPHPExcel->getActiveSheet()->getStyle("A$i:E$i")->applyFromArray(array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,)));


			sql_free_result($hsl1);
			//die();

			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle("Laporan Bulanan");

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			/** PHPExcel_IOFactory */
			require_once "$lokasiweb/librari/Classes/PHPExcel/IOFactory.php";
			$tglname = date("U");

			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header("Content-Disposition: attachment;filename=\"LaporanBulanan-$tglname.xlsx\"");
			header('Cache-Control: max-age=0');


			// Save Excel 2007 file
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save("$lokasiweb/lapexcel/LaporanBulanan-$tglname.xlsx");

			$link1	= "/demo/lapexcel/LaporanBulanan-$tglname.xlsx";
			header("location: ".$link1);

			exit;
		}
	}
?>