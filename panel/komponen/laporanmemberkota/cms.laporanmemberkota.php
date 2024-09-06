<?php
	//Variable halaman ini
	$nama_tabel		= "tbl_member";
	$judul_per_hlm 	= 25;
	$otoritas		= kodeoto($kanal);
	$oto			= $otoritas[0];

	//Variable Umum
	if(isset($_POST['pesanid'])) $pesanid = $_POST['pesanid'];
 	else $pesanid = $_GET['pesanid'];
 
	//Vie Menu
	if($aksi=="view")
	{
		$mainmenu[] = array("Lihat Laporan","lihat","$alamat&aksi=view");
		mainaction($mainmenu,$pageparam);

		//Search Paramater Fungsi namafield,Label,
		$cari[] = array("usercreateddate","Tanggal Daftar","daterange","daterange","$dataselect");
		$cari[]	= array("userlastloggedin","Last Login","daterange2","daterange2",$dataselect);	

		$formcari = cmsformcari($cari,$pageparam);
		$where = $formcari[0]['where'];
		$param = $formcari[0]['param'];
		
		$i		= 1;
		$ord 	= 1;
		
		print ("<br clear='all'><table border=0 class=\"tabel-cms\"  width=100% cellpadding=1 cellspacing=1 align=center>\n");
		print ("<tr class=nama bgcolor=$ground><th width=10% align=center>&nbsp;<b>No</b></th>\n");
		print ("<th width=30%>&nbsp;<b>Nama Propinsi</b></th>\n");
		print ("<th width=20%>&nbsp;<b>Jumlah Member</b></th>");
		print ("<th width=40%>&nbsp;<b>Persentase</b></th></tr>");
				
		$sql	= "select propid,namapropinsi from tbl_propinsi";
		$query	= sql($sql);
		while($row = sql_fetch_data($query))
		{
			$propid			= $row['propid'];
			$namapropinsi	= $row['namapropinsi'];
			
			$num1	= sql_get_var("select count(*) as jml from tbl_member where propinsiid='$propid' $where");
			$total	= $total+$num1;
			print ("<tr>");
			print ("<td valign=top align=center>$ord</td>");
			print ("<td align=left>$namapropinsi</td>");
			print ("<td align=center>$num1</td>");

			$jumtidak	= sql_get_var("select count(*) as jml from tbl_member where propinsiId=''");
			$totaljum = $total+$jumtidak;
			
			if($num1>0)
			{
				$persen = ($num1/$totaljum)*100;
				$persen = number_format($persen,2,".",".");
			}
			else
			{
				$persen = 0;
			}
			
			$color = color(6);
			
			echo"
				<td valign=top><div style=\"width:$persen%; text-align:center; background:$color; float:left; color:#fff; padding:5px 0px 5px 0px;\">$persen%</div></td>
				";

			print ("</tr>");
			$i %= 2;
			$i++;
			$ord++;
		}	
		$no=$ord;
		if($jumtidak>0)
		{
			$persen = ($jumtidak/$totaljum)*100;
			$persen = number_format($persen,2,".",".");
		}
		else
		{
			$persen = 0;
		}
		
		$color = color(6);
					
		print ("<tr>");
			print ("<td valign=top align=center>$no</td>");
			print ("<td align=left>Tidak Diketahui</td>");
			print ("<td align=center>$jumtidak</td>");
			echo"
				<td valign=top><div style=\"width:$persen%; text-align:center; background:$color; float:left; color:#fff; padding:5px 0px 5px 0px;\">$persen%</div></td>
				";
			print ("</tr>");
		print ("<tr class=nama bgcolor=$ground><th width=40% height=20 colspan=2 align=center><b>Total Member</b></th>\n");
		print ("<th width=20% align=center colspan=2><b>$totaljum</b></th></tr>");
		
		print("</table>");
		echo"</td></tr></table><br clear='all'><br clear='all'>"; // tutup tabel utama

			
	} //EndView 
?>