<?php
$childaksi = $var[4];
$tpl->assign("childaksi",$childaksi);

if($childaksi=="create")
{
	if(isset($_POST['namalengkap']) && !empty($_POST['namalengkap']))
	{
		$namalengkap = cleaninsert($_POST['namalengkap']);
		$pertemuan = cleaninsert($_POST['pertemuan']);
		$tanggal = cleaninsert($_POST['month'])."-".cleaninsert($_POST['month'])."-".cleaninsert($_POST['date']);
		$usia = cleaninsert($_POST['usia']);
		$jeniskelamin = cleaninsert($_POST['jeniskelamin']);
		$contact = cleaninsert($_POST['contact']);
		$masalah = cleaninsert($_POST['masalah']);
		$terapi = cleaninsert($_POST['terapi']);
		$skalaawal = cleaninsert($_POST['skalaawal']);
		$skalaakhir = cleaninsert($_POST['skalaakhir']);
		
		$date		= date("Y-m-d H:i:s");

		$new = newid("id","tbl_trackrecord");
	
		$filename	= $_FILES['gambar']['name'];
		$filesize	= $_FILES['gambar']['size'];
		$filetmpname	= $_FILES['gambar']['tmp_name'];
		
		if($filesize > 0)
		{
			$yearm	= date("Ym");
			$simpan_file		= "$lokasimember"."trackrecord/$_SESSION[useridresel]";
			if(!file_exists($simpan_file)){	mkdir($simpan_file,0777); }
			
			$imageinfo = getimagesize($filetmpname);
			$imagewidth = $imageinfo[0];
			$imageheight = $imageinfo[1];
			$imagetype = $imageinfo[2];
			
			switch($imagetype)
			{
				case 1: $imagetype="gif"; break;
				case 2: $imagetype="jpg"; break;
				case 3: $imagetype="png"; break;
			}
			
			$photofull = "trackrecord-$yearm-".$_SESSION['useridresel']."-$new-f.".$imagetype;
			resizeimg($filetmpname,"$simpan_file/$photofull",800,800);
			
			$photolarge = "trackrecord-$yearm-".$_SESSION['useridresel']."-$new-l.".$imagetype;
			resizeimg($filetmpname,"$simpan_file/$photolarge",500,500);
			
			if(file_exists("$simpan_file/$photolarge")){ $vgmbr = ",gambar,gambar1"; $isigmbr = ",'$photolarge','$photofull'"; }
			
		}
		
		$salah = false;
		$pesan = array();
		
		if(empty($namalengkap))
		{
			$pesan[] = array("pesan"=>"Nama Lengkap masih kosong, silahkan isi dengan lengkap terlebih dahulu");
			$salah = true;
		}
		else if(empty($masalah))
		{
			$pesan[] = array("pesan"=>"Masalah masih kosong, silahkan isi dengan lengkap terlebih dahulu");
			$salah = true;
		}
		else if(empty($contact))
		{
			$pesan[] = array("pesan"=>"Nomor Contact masih kosong, silahkan isi dengan lengkap terlebih dahulu");
			$salah = true;
		}
		else if(empty($terapi))
		{
			$pesan[] = array("pesan"=>"Terapi yang Anda gunakan Anda masih kosong, silahkan isi dengan lengkap terlebih dahulu");
			$salah = true;
		}
	
		
		if(!$salah)
		{
		
			$query= "insert into tbl_trackrecord(id,create_date,pertemuan,tanggal,namalengkap,usia,jeniskelamin,contact,masalah,terapi,skalaawal,skalaakhir,userid $vgmbr)
				 values ('$new','$date','$pertemuan','$tanggal','$namalengkap','$usia','$jeniskelamin','$contact','$masalah','$terapi','$skalaawal','$skalaakhir','$_SESSION[useridresel]' $isigmbr)";
			$hasil = sql($query);
			
		   if($hasil)
		   {
				$pesanhasil = "Selamat, Anda sudah berhasil menambahkan track record baru. Perbaharui trackrecord Anda setiap Anda melakukan terapi";
				$berhasil = "1";
			}
					
		}
		else
		{
			$pesanhasil = "Penyimpanan Trackrecord gagal dilakukan ada beberapa kesalahan yang mesti diperbaiki, silahkan periksa kembali kesalahan dibawah ini";
			$berhasil = "0";
		}
		
		$tpl->assign("pesan",$pesan);
		$tpl->assign("pesanhasil",$pesanhasil);
		$tpl->assign("berhasil",$berhasil);
	}
	
	//dapatkan data tanggal
	$dateloop = array();
	$tempi = 1;
	while ($tempi < 32) {
		 if ($tempi < 10){
			 array_push($dateloop,"0".$tempi);
			 $temp2 = "0".$tempi;
		 }else{
			 array_push($dateloop,$tempi);
			 $temp2 = $tempi;
		}
		if($temp2 == $dob[2]) $dateselected = $tempi;
		$tempi++;
	}
	
	$monthloop = array();
	$tempi = 1;
	while ($tempi < 13) {
		 if ($tempi < 10){
			 array_push($monthloop,"0".$tempi);
			  $temp2 = "0".$tempi;
		 }else{
			 array_push($monthloop,$tempi);
			 $temp2 = $tempi;
		}
		if($temp2 == $dob[1]) $monthselected = $tempi;
		$tempi++;
	
	}
	
	$yearloop = array();
	$tempi = date("Y")-2;
	
	while($tempi < date("Y") + 5) {
		 array_push($yearloop,$tempi);
		if($tempi == $dob[0]) $yearselected = $tempi;
		$tempi++;
	
	}
	
	if($monthselected<10) $monthselected = "0".$monthselected;
	if($dateselected<10) $dateselected = "0".$dateselected;
	
	$tpl -> assign( 'yearloop', $yearloop );
	$tpl -> assign( 'yearselected' , $yearselected);
	$tpl -> assign( 'monthloop', $monthloop );
	$tpl -> assign( 'monthselected' , $monthselected);
	$tpl -> assign( 'dateloop', $dateloop );
	$tpl -> assign( 'dateselected' , $dateselected);
	
	
	
	}
else if($childaksi=="detail")
{
	$id = $var[5];
	
	$perintah	= "select  id,create_date,create_userid,update_date,update_userid,pertemuan,tanggal,alias,namalengkap,usia,jeniskelamin,contact,masalah,terapi,skalaawal,skalaakhir,gambar,gambar1,userid from tbl_trackrecord where id='$id'  and userid='$_SESSION[useridresel]'";
	$hasil		= sql($perintah);
	$datadetail	= array();
	$no = (($hlm-1)*$judul_per_hlm)+1;
	while($data = sql_fetch_data($hasil))
	{
		$tanggal = $data['tanggal'];
		$namalengkap = ucwords($data['namalengkap']);
		$id = $data['id'];
		$masalah = $data['masalah'];
		$usia = $data['usia'];
		$tanggal = date("d/m/Y",strtotime($data['tanggal']));
		$contact = $data['contact'];
		$terapi = $data['terapi'];
		$pertemuan = $data['pertemuan'];
		$skalaawal = $data['skalaawal'];
		$skalaakhir = $data['skalaakhir'];
		$gambar = $data['gambar'];
		$jeniskelamin = $data['jeniskelamin'];

		if(!empty($gambar)) $gambar = "$fulldomain/uploads/trackrecord/$_SESSION[useridresel]/$gambar";
		
				 
		$datadetail[$id] = array("id"=>$id,"tanggal"=>$tanggal,"namalengkap"=>$namalengkap,"pertemuan"=>$pertemuan,"contact"=>$contact,"terapi"=>$terapi,
			"masalah"=>$masalah,"pertemuan"=>$pertemuan,"skalaawal"=>$skalaawal,"skalaakhir"=>$skalaakhir,"usia"=>$usia,"gambar"=>$gambar,"jeniskelamin"=>$jeniskelamin);
		$no++;
		unset($status,$kota);
	}
	sql_free_result($hasil);
	$tpl->assign("datadetail",$datadetail);
	
}
else
{
	$judul_per_hlm = 10;
	$batas_paging = 5;
	$hlm =$var[4];
	
	$sql = "select count(*) as jml from tbl_trackrecord where userid='$_SESSION[useridresel]'";
	$hsl = sql($sql);
	$tot = sql_result($hsl, 0,'jml');
	
	$tpl->assign("jml_post",$tot);
	
	$hlm_tot = ceil($tot / $judul_per_hlm);		
	if (empty($hlm)){
		$hlm = 1;
	}
	if ($hlm > $hlm_tot){
	$hlm = $hlm_tot;
	}
	$ord = ($hlm - 1) * $judul_per_hlm;
	if ($ord < 0 ) $ord=0;
	
	$perintah	= "select  id,namalengkap,tanggal,contact from tbl_trackrecord where userid='$_SESSION[useridresel]' order by id asc limit $ord, $judul_per_hlm";
	$hasil		= sql($perintah);
	$datadetail	= array();
	$no = 0;
	while($data = sql_fetch_data($hasil))
	{
		$tanggal = $data['tanggal'];
		$namalengkap = $data['namalengkap'];
		$id = $data['id'];
		$contact = $data['contact'];
		$alias = $data['alias'];
		$tanggal = date("d/m/Y",strtotime($tanggal));
	
		$datadetail[$id] = array("id"=>$id,"no"=>$i,"namalengkap"=>$namalengkap,"contact"=>$contact,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
		$no++;
	}
	sql_free_result($hasil);
	$tpl->assign("datadetail",$datadetail);
	
	//Paging 
	$batas_page =5;
	
	$stringpage = array();
	$pageid =0;
	
	$Selanjutnya 	= "&rsaquo;";
	$Sebelumnya 	= "&lsaquo;";
	$Akhir			= "&raquo;";
	$Awal 			= "&laquo;";
	
	if ($hlm > 1){
		$prev = $hlm - 1;
		$stringpage[$pageid] = array("nama"=>"$Awal","link"=>"$fulldomain/$kanal/$aksi/1");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"$Sebelumnya","link"=>"$fulldomain/$kanal/$aksi/$prev");
	
	}
	else {
		$stringpage[$pageid] = array("nama"=>"$Awal","link"=>"");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"$Sebelumnya","link"=>"");
	}
	
	$hlm2 = $hlm - (ceil($batas_page/2));
	$hlm4= $hlm+(ceil($batas_page/2));
	
	if($hlm2 <= 0 ) $hlm3=1;
	   else $hlm3 = $hlm2;
	$pageid++;
	for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
		if ($ii==$hlm){
			$stringpage[$pageid] = array("nama"=>"$ii","link"=>"","class"=>"active");
		}else{
			$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/$aksi/$ii");
		}
		$pageid++;
	}
	if ($hlm < $hlm_tot){
		$next = $hlm + 1;
		$stringpage[$pageid] = array("nama"=>"$Selanjutnya","link"=>"$fulldomain/$kanal/$aksi/$next");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"$Akhir","link"=>"$fulldomain/$kanal/$aksi/$hlm_tot");
	}
	else
	{
		$stringpage[$pageid] = array("nama"=>"$Selanjutnya","link"=>"");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"$Akhir","link"=>"");
	}
	$tpl->assign("stringpage",$stringpage);
	//Selesai Paging
}
?>