<?php
include("../../setingan/apps.config.inc.php");

$secid = $_GET['secid'];
$hlm = $_GET['hlm'];

if(!empty($secid))
{
	$perintah1 = "select secid,nama,alias from tbl_artikel_sec where secid='$secid'";
	$hasil1 = sql($perintah1);
	$row1 = sql_fetch_data($hasil1);
	$namasec = $row1['nama'];
	$secid = $row1['secid'];
	$secalias = $row1['alias'];
	$where = "and secid='$secid'";
	$rubrik = "$namasec";
}
else
{
	$secalias = "global";
	$rubrik = "$rubrik";
}


$judul_per_hlm = 10;
$batas_paging = 5;

$sql = "select count(*) as jml from tbl_artikel where published='1'  $where";
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

$mysql = "select id,ringkas,nama,create_date,alias,secid,gambar,gambar1 from tbl_artikel where published='1'  $where order by id  desc limit $ord, $judul_per_hlm";
$hasil = sql( $mysql);

if(sql_num_rows($hasil)>0)
{

	$content = array();		
	$i = 0;
	while ($data =  sql_fetch_data($hasil)) {	
		$tanggal = $data['create_date'];
		$nama = $data['nama'];
		$id = $data['id'];
		$ringkas = $data['ringkas'];
		$alias = $data['alias'];
		$tanggal = tanggal($tanggal);
		$gambar = $data['gambar'];
		$gambar1 = $data['gambar1'];
		$secid = $data['secid'];
		
		$perintah = "select alias,nama from tbl_artikel_sec where secid='$secid'";
		$res = sql($perintah);
		$dt =  sql_fetch_data($res);
		$secalias1 = $dt['alias'];
		$namasec = $dt['nama'];
		sql_free_result($res);
		
		
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/artikel/$gambar";
		 else $gambar = "";
			 
	
		$link = "$fulldomain/artikel/read/$secalias1/$id/$alias";
		$urlsec = "$fulldomain/artikel/list/$secalias1";
			
		$content[$id] = array("id"=>$id,"no"=>$i,"namasec"=>$namasec,"secid"=>$secid,"judul"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
		$i++;
			
	}
	sql_free_result($hasil);
	
	//Paging 
	$batas_page =5;
	
	$stringpage = array();
	$pageid =0;
	
	if ($hlm > 1){
		$prev = $hlm - 1;
		$stringpage[$pageid] = array("nama"=>"Awal","link"=>"1");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"Sebelumnya","link"=>"$prev");
	
	}
	
	$hlm2 = $hlm - (ceil($batas_page/2));
	$hlm4= $hlm+(ceil($batas_page/2));
	
	if($hlm2 <= 0 ) $hlm3=1;
	   else $hlm3 = $hlm2;
	$pageid++;
	
	for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
		if ($ii==$hlm){
			//$stringpage[$pageid] = array("nama"=>"$ii","link"=>"");
		}else{
			//$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$ii");
		}
		$pageid++;
	}
	
	if ($hlm < $hlm_tot){
		$next = $hlm + 1;
		$stringpage[$pageid] = array("nama"=>"Selanjutnya","link"=>"$next");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$hlm_tot");
	}
	else
	{
		$stringpage[$pageid] = array("nama"=>"Selanjutnya","link"=>"");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"");
	}
	
	
	$response["success"] = 1;
	$response["content"] = $content;
	$response["page"] = $stringpage;
	
	echo json_encode($response);
	

}
else
{
	$response["success"] = 0;
	echo json_encode($response);
}

?>