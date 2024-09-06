<?php 
$detect = new Mobile_Detect;
if($detect->isMobile())
{
	$sql	= "select id,nama,url,gambar,ringkas,warna from tbl_slide_mobile where published='1' and tipe='0' order by id desc limit 6";
	$query	= sql($sql);
	$no = 1;
	$a = 0;
	while($row = sql_fetch_data($query))
	{
		$id		= $row['id'];
		$nama	= $row['nama'];
		$url	= $row['url'];
		$gambar	= $row['gambar'];
		$ringkas	= $row['ringkas'];
		$warna	= $row['warna'];
		
		if(!empty($gambar))
		{
			$gambar	= "$fulldomain/gambar/slidemobile/$gambar";
			
			$slide[$id]	= array("id"=>$id,"no"=>$no,"a"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"url"=>$url,"gambar"=>$gambar,"warna"=>$warna);
			$a++;
		}
		$no++;
	}
	sql_free_result($query);
	$tpl->assign("slide",$slide);
}
else
{
	$sql	= "select id,nama,url,gambar,ringkas,warna from tbl_slide where published='1' and tipe='0' order by id desc limit 6";
	$query	= sql($sql);
	$no = 1;
	$a = 0;
	while($row = sql_fetch_data($query))
	{
		$id		= $row['id'];
		$nama	= $row['nama'];
		$url	= $row['url'];
		$gambar	= $row['gambar'];
		$ringkas	= $row['ringkas'];
		$warna	= $row['warna'];
		
		if(!empty($gambar))
		{
			$gambar	= "$fulldomain/gambar/slide/$gambar";
			
			$slide[$id]	= array("id"=>$id,"no"=>$no,"a"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"url"=>$url,"gambar"=>$gambar,"warna"=>$warna);
			$a++;
		}
		$no++;
	}
	sql_free_result($query);
	$tpl->assign("slide",$slide);
}


//Instagram
$mysql = "select id,nama,create_date,instagramid,gambar from tbl_instagram where published='1' order by create_date desc limit 4";
$hasil = sql($mysql);

$datainstagram = array();
$a =1;
while ($data = sql_fetch_data($hasil)) {	
		$tanggal = $data['create_date'];
		$nama = $data['nama'];
		$id = $data['id'];
		$ringkas = $data['ringkas'];
		$ringkas = ringkas($data['ringkas'],22);
		$kode = $data['instagramid'];
		$tanggal1 = tanggal($tanggal);
		$gambar = $data['gambar'];

		$url = "https://www.instagram.com/p/$kode";
	
		if(!empty($gambar)) $gambar = "$domain/gambar/instagram/$gambar";
			 else $gambar = "";

				
		$datainstagram[] = array("id"=>$id,"no"=>$a,"nama"=>$nama,"tanggal"=>$tanggal1,"date"=>$tanggal,"url"=>$url,"gambar"=>$gambar);
		$a++;	
}
$a = 0;
sql_free_result($hasil);
$tpl->assign("datainstagram",$datainstagram);
?>