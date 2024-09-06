<?php 
$judul_per_hlm = 10;
$batas_paging = 5;
$start = $var[4];
$limit = $var[5];

if(!empty($last)) { $where = " and id < $last"; }

$sql = "select count(*) as jml from tbl_panduanbelanja where published='1' $where";
$hsl = sql( $sql);
$tot = sql_result($hsl, 0, jml);
$hlm_tot = ceil($tot / $judul_per_hlm);		
if (empty($hlm)){
	$hlm = 1;
	}
if ($hlm > $hlm_tot){
	$hlm = $hlm_tot;
	}

$ord = ($hlm - 1) * $judul_per_hlm;
if ($ord < 0 ) $ord=0;

$mysql = "select id,ringkas,nama,alias,secid from tbl_panduanbelanja where published='1' $where order by id desc limit $start, $limit";
$hasil = sql( $mysql);


$datadetail = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$tanggal = $data['create_date'];
	$nama = $data['nama'];
	$id = $data['id'];
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
