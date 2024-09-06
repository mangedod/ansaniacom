<?php 
$judul_per_hlm = 10;
$batas_paging = 5;
$start = $var[4];
$limit = $var[5];

if(!empty($last)) { $where = " and id < $last"; }

$sql = "select count(*) as jml from tbl_galeri where published='1' and gambar!='' $where";
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

$mysql = "select id,ringkas,nama,create_date,alias,gambar,gambar1,views from tbl_galeri where published='1' and gambar!='' $where order by id desc limit $start, $limit";
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
	
	$views = rupiah($views);
	
	

	if(!empty($gambar)) $gambar = "$fulldomain/gambar/galeri/$gambar";
	 else $gambar = "";

		 

	$link = "$fulldomain/$kanal/listen/$id/$alias";
		
	$datadetail[] = array("id"=>$id,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal1,"date"=>$tanggal,"alias"=>$alias,"url"=>$link,"gambar"=>$gambar,"views"=>$views);
	$i++;
	
	
		
}
sql_free_result($hasil);

//Paging 
$batas_page =5;

$stringpage = array();
$pageid =0;

if ($hlm > 1){
	$prev = $hlm - 1;
	$stringpage[$pageid] = array("nama"=>"Awal","link"=>"$fulldomain/$kanal/$aksi/1");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Sebelumnya","link"=>"$fulldomain/$kanal/$aksi/$prev");

}
else {
	$stringpage[$pageid] = array("nama"=>"Awal","link"=>"");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Sebelumnya","link"=>"");
}

$hlm2 = $hlm - (ceil($batas_page/2));
$hlm4= $hlm+(ceil($batas_page/2));

if($hlm2 <= 0 ) $hlm3=1;
   else $hlm3 = $hlm2;
$pageid++;
for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
	if ($ii==$hlm){
		$stringpage[$pageid] = array("nama"=>"$ii","link"=>"");
	}else{
		$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/$aksi/$ii");
	}
	$pageid++;
}
if ($hlm < $hlm_tot){
	$next = $hlm + 1;
	$stringpage[$pageid] = array("nama"=>"Selanjutnya","link"=>"$fulldomain/$kanal/$aksi/$next");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$fulldomain/$kanal/$aksi/$hlm_tot");
}
else
{
	$stringpage[$pageid] = array("nama"=>"Selanjutnya","link"=>"");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"");
}

$result['status']="OK";
$result['message']="Data berhasil di load";
$result['halaman']= $hlm;
$result['totalhalaman'] = $hlm_tot;
$result['datalist'] = $datadetail;
$result['stringpage'] = $stringpage;
	
echo json_encode($result);
	
?>
