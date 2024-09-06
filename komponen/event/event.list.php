<?php 
$hlm = $var[5];
$judul_per_hlm = 10;;

$sql = "select count(*) as jml from tbl_event where published='1' $where";
$hsl = sql( $sql);
$tot = sql_result($hsl, 0,'jml');

$hlm_tot = ceil($tot / $judul_per_hlm);		
if (empty($hlm)){
	$hlm = 1;
	}
if ($hlm > $hlm_tot){
	$hlm = $hlm_tot;
	}

$ord = ($hlm - 1) * $judul_per_hlm;
if ($ord < 0 ) $ord=0;

$mysql = "select id,ringkas,nama,organizer,lokasievent,tanggalevent,waktuevent,create_date,alias,gambar,gambar1 from tbl_event where published='1' order by id  asc limit $ord, $judul_per_hlm";
$hasil = sql( $mysql);


$datadetail = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$tanggal      = $data['create_date'];
	$nama         = $data['nama'];
	$id           = $data['id'];
	$ringkas      = $data['ringkas'];
	$alias        = $data['alias'];
	$tanggal      = tanggal($tanggal);
	$gambar       = $data['gambar1'];
	$organizer    = $data['organizer'];
	$lokasievent  = $data['lokasievent'];
	$tanggalevent = tanggal($data['tanggalevent']);
	$waktuevent   = $data['waktuevent'];
	
	

	if(!empty($gambar)) $gambar = "$fulldomain/gambar/event/$gambar";
	 else $gambar = "";
		 

	$link = "$fulldomain/$kanal/read/$id/$alias";
		
	$datadetail[$id] = array("id"=>$id,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"organizer"=>$organizer,"lokasievent"=>$lokasievent,"tanggalevent"=>$tanggalevent,"waktuevent"=>$waktuevent,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
	$i++;
		
}
sql_free_result($hasil);
$tpl->assign("datadetail",$datadetail);

//Paging 
$batas_page =5;

$stringpage = array();
$pageid =0;

if ($hlm > 1){
	$prev = $hlm - 1;
	// $stringpage[$pageid] = array("nama"=>"Awal","link"=>"$fulldomain/$kanal/$aksi/1");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"PREV","link"=>"$fulldomain/$kanal/$aksi/$prev");

}
else {
	// $stringpage[$pageid] = array("nama"=>"Awal","link"=>"");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"PREV","link"=>"");
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
	$stringpage[$pageid] = array("nama"=>"NEXT","link"=>"$fulldomain/$kanal/$aksi/$next");
	$pageid++;
	// $stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$fulldomain/$kanal/$aksi/$hlm_tot");
}
else
{
	$stringpage[$pageid] = array("nama"=>"NEXT","link"=>"");
	$pageid++;
	// $stringpage[$pageid] = array("nama"=>"Akhir","link"=>"");
}
$tpl->assign("stringpage",$stringpage);
		
?>
