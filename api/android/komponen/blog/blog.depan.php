<?php 
$mysql = "select id,ringkas,nama,create_date,alias,secid,gambar,gambar1,views from tbl_blog where published='1' and gambar!='' order by id desc limit 3";
$hasil = sql( $mysql);


$datadetail = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$tanggal = $data['create_date'];
	$nama = $data['nama'];
	$id = $data['id'];
	$ringkas = ringkas($data['ringkas'],25);
	$alias = $data['alias'];
	//$tanggal1 = tanggal($tanggal);
	$gambar = $data['gambar'];
	$secid = $data['secid'];
	$folder = $data['folder'];
	$waveform = $data['waveform'];
	$userid = $data['userid'];
	$views = $data['views'];
	$jmlcomment = $data['jmlcomment'];
	$durasi = durasi($data['durasi']);
	$audio = $data['audio'];
	
	$views = rupiah($views);
	
	$perintah = "select alias from tbl_blog_sec where secid='$secid'";
	$res = sql($perintah);
	$dt =  sql_fetch_data($res);
	$secalias = $dt['alias'];
	sql_free_result($res);
	

	if(!empty($gambar)) $gambar = "$fulldomain/gambar/blog/$gambar";
	 else $gambar = "";

		 

	$link = "$fulldomain/$kanal/listen/$id/$alias";
		
	$datadetail[] = array("id"=>$id,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal1,"date"=>$tanggal,"alias"=>$alias,"url"=>$link,"gambar"=>$gambar,"views"=>$views);
	$i++;
	
	
		
}
sql_free_result($hasil);


$result['status']="OK";
$result['message']="Data berhasil di load";
$result['halaman']= $hlm;
$result['totalhalaman'] = $hlm_tot;
$result['datalist'] = $datadetail;
$result['stringpage'] = $stringpage;
	
echo json_encode($result);
	
?>
