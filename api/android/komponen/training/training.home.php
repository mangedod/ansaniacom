<?php 
$mysql = "select secid,ringkas,nama,create_date,alias,gambar,gambar1,views from tbl_training where published='1' order by secid desc limit 5";
$hasil = sql( $mysql);

$d = strtotime("now");
$datadetail = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$tanggal = $data['create_date'];
	$nama = $data['nama'];
	$secid = $data['secid'];
	$ringkas = ringkas($data['ringkas'],25);
	$alias = $data['alias'];
	$tanggal1 = tanggal($tanggal);
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
	
	if(!empty($gambar)) $gambar = "$fulldomain/gambar/training/$gambar?$d";
	 else $gambar = "";

	$link = "$fulldomain/$kanal/listen/$id/$alias";
		
	$datadetail[] = array("secid"=>$secid,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal1,"date"=>$tanggal,"alias"=>$alias,"url"=>$link,"gambar"=>$gambar,"views"=>$views);
	$i++;
	
}
sql_free_result($hasil);

$result['status']="OK";
$result['message']="Data berhasil di load";
$result['halaman']= $hlm;
$result['totalhalaman'] = $hlm_tot;
$result['datalist'] = $datadetail;
	
echo json_encode($result);
	
?>
