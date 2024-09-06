<?php
$judul_per_hlm = 10;
$batas_paging = 5;
$hlm =$var[4];

$sql = "select count(*) as jml from tbl_faq where published='1'";
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

$perintah	= "select  id,judul,lengkap,create_date from tbl_faq where published='1' order by id asc limit $ord, $judul_per_hlm";
$hasil		= sql($perintah);
$datadetail	= array();
$no = 0;
while($data = sql_fetch_data($hasil))
{
	$tanggal = $data['create_date'];
	$nama = $data['judul'];
	$id = $data['id'];
	$lengkap = $data['lengkap'];
	$alias = $data['alias'];
	$tanggal = tanggal($tanggal);

	 
	$no++;
	$datadetail[$id] = array("id"=>$id,"no"=>$i,"nama"=>$nama,"lengkap"=>$lengkap,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
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

?>