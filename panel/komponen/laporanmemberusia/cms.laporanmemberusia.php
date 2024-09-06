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
		
		$year	= date("Y");

		$sql1	= "select userid,usergender from tbl_member where ('$year' - LEFT(userdob,4) < 20)";
		$query1	= sql($sql1);
		$num1	= sql_num_rows($query1);
		$jumL1	= 0;
		$jumP1	= 0;
		$jumN1	= 0;
		while($row1 = sql_fetch_data($query1))
		{
			$jenkel	= strtolower($row1['usergender']);
	
			if($jenkel == "laki-laki")
				$jumL1++;
			elseif($jenkel == "perempuan")
				$jumP1++;
			else
				$jumN1++;
		}
		sql_free_result($query1);
	
		$sql2	= "select userid,usergender from tbl_member where ('$year' - LEFT(userdob,4) >= 20) and ('$year' - LEFT(userdob,4) <= 30)";
		$query2	= sql($sql2);
		$num2	= sql_num_rows($query2);
		$jumL2	= 0;
		$jumP2	= 0;
		$jumN2	= 0;
		while($row2 = sql_fetch_data($query2))
		{
			$jenkel	= strtolower($row2['usergender']);
	
			if($jenkel == "laki-laki")
				$jumL2++;
			elseif($jenkel == "perempuan")
				$jumP2++;
			else
				$jumN2++;
		}
		sql_free_result($query2);
	
		$sql5	= "select userid,usergender from tbl_member where ('$year' - LEFT(userdob,4) >= 31) and ('$year' - LEFT(userdob,4) <= 40)";
		$query5	= sql($sql5);
		$num5	= sql_num_rows($query5);
		$jumL5	= 0;
		$jumP5	= 0;
		$jumN5	= 0;
		while($row5 = sql_fetch_data($query5))
		{
			$jenkel	= strtolower($row5['usergender']);
	
			if($jenkel == "laki-laki")
				$jumL5++;
			elseif($jenkel == "perempuan")
				$jumP5++;
			else
				$jumN5++;
		}
		sql_free_result($query5);
	
		$sql3	= "select userid,usergender from tbl_member where ('$year' - LEFT(userdob,4) > 40) and userdob!='0000-00-00'";
		$query3	= sql($sql3);
		$num3	= sql_num_rows($query3);
		$jumL3	= 0;
		$jumP3	= 0;
		$jumN3	= 0;
		while($row3 = sql_fetch_data($query3))
		{
			$jenkel	= strtolower($row3['usergender']);
	
			if($jenkel == "laki-laki")
				$jumL3++;
			elseif($jenkel == "perempuan")
				$jumP3++;
			else
				$jumN3++;
		}
		sql_free_result($query3);
	
		$sql4	= "select userid,usergender from tbl_member where userdob='0000-00-00'";
		$query4	= sql($sql4);
		$num4	= sql_num_rows($query4);
		$jumL4	= 0;
		$jumP4	= 0;
		$jumN4	= 0;
		while($row4 = sql_fetch_data($query4))
		{
			$jenkel	= strtolower($row4['usergender']);
	
			if($jenkel == "laki-laki")
				$jumL4++;
			elseif($jenkel == "perempuan")
				$jumP4++;
			else
				$jumN4++;
		}
		sql_free_result($query4);
	
		$totMember	= $num1+ $num2 + $num5 + $num3 + $num4;
		$totL		= $jumL1+ $jumL2 + $jumL5 + $jumL3 + $jumL4;
		$totP		= $jumP1+ $jumP2 + $jumP5 + $jumP3 + $jumP4;
		$totN		= $jumN1+ $jumN2 + $jumN5 + $jumN3 + $jumN4;
		
		print ("<br clear='all'><table border=0 class=tabel-cms  width=100% cellpadding=1 cellspacing=1 align=center>\n");
		print ("<tr class=nama bgcolor=$ground>
		    	<th width=10% align=center>No</th>
		    	<th width=50% align=cente>Usia</th>
		    	<th width=40% colspan=4 align=center>Jumlah Member</th></tr>");
        print ("<tr>
		          	<td rowspan=2></td>
		            <td rowspan=2></td>
		        </tr>
		        <tr>
		            <th>L</th><th>P</th><th>!L!P</th><th>Total</th>
		        </tr>");
        print ("<tr>
		          	<td rowspan=2>1</td>
		            <td rowspan=2>Tidak Diketahui<b>(< 20 Tahun)</b></td>
		        </tr>
		        <tr>
		            <td>$jumL1</td><td>$jumP1</td><td>$jumN1</td><td>$num1</td>
		        </tr>");
        print ("<tr>
		          	<td rowspan=2>2</td>
		            <td rowspan=2>&nbsp;<b>(20 - 30 Tahun)</b></td>
		        </tr>
		        <tr>
		            <td>$jumL2</td><td>$jumP2</td><td>$jumN2</td><td>$num2</td>
		        </tr>");
        print ("<tr>
		          	<td rowspan=2>3</td>
		            <td rowspan=2>&nbsp;<b>(31 - 40 Tahun)</td>
		        </tr>
		        <tr>
		            <td>$jumL3</td><td>$jumP3</td><td>$jumN3</td><td>$num3</td>
		        </tr>");
        print ("<tr>
		          	<td rowspan=2>4</td>
		            <td rowspan=2>&nbsp;<b>(> 40 Tahun)</b></td>
		        </tr>
		        <tr>
		            <td>$jumL4</td><td>$jumP4</td><td>$jumN4</td><td>$num4</td>
		        </tr>");
        print ("<tr>
		          	<td rowspan=2>5</td>
		            <td rowspan=2>&nbsp;<b>Tidak Diketahui</b></td>
		        </tr>
		        <tr>
		            <td>$jumL5</td><td>$jumP5</td><td>$jumN5</td><td>$num5</td>
		        </tr>");
        print ("<tr>
		          	<td rowspan=2>6</td>
		            <td rowspan=2>&nbsp;<b>Total Member</b></td>
		        </tr>
		        <tr>
		            <td>$totL</td><td>$totP</td><td>$totN</td><td>$totMember</td>
		        </tr>");
		
		print("</table>");
		echo"</td></tr></table><br clear='all'><br clear='all'>"; // tutup tabel utama

			
	} //EndView 
?>