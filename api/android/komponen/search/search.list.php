<?php 
$judul_per_hlm = 10;
$batas_paging = 5;
$start = $var[4];
$limit = $var[5];
$q = cleaninsert($var[3]);


if(!empty($last)) { $where = " and id < $last"; }

$sql = "select count(*) as jml from tbl_search where (kanal!='download') and nama like '%$q%'  or ringkas like '%$q%'  $where";
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

$mysql = "select id,ringkas,nama,create_date,gambar,url,kanal,namakanal,itemid from tbl_search where  (kanal!='download') and nama like '%$q%' or ringkas like '%$q%' order by urutan asc, create_date desc, views desc limit $start, $limit";
$hasil = sql( $mysql);


$datadetail = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
$tanggal = $data['create_date'];
	$nama = $data['nama'];
	$id = $data['id'];
	$ringkas = ringkas($data['ringkas'],20);
	$alias = $data['alias'];
	$tanggal1 = tanggal($tanggal);
	$gambar = $data['gambar'];
	$namasec = $data['kanal'];
	$url = $data['url'];
	$namakanal = $data['namakanal'];
	$itemid = $data['itemid'];
	
	if(!empty($gambar)) $gambar = "$fulldomain/$gambar";
	else $gambar = "";
	
	$link = $url;
	

	if($namakanal!=="download")
	{
		$datadetail[] = array("id"=>$id,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal1,"date"=>$tanggal,"itemid"=>$itemid,"namakanal"=>$namakanal,"gambar"=>$gambar,"namasec"=>$namasec);
		$i++;
	}
	
	
		
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
$result['total'] = $tot;
$result['datalist'] = $datadetail;
$result['stringpage'] = $stringpage;
	
echo json_encode($result);
	
?>
