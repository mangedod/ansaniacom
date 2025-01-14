<?php 
$katid = $var[4];
$katid = str_replace(".html","",$katid);

if(!empty($katid) and $katid!="uncategorize")
{
	$perintah1 	= "select * from tbl_$kanal"."_sec where alias='$katid'";
	$hasil1 	= sql($perintah1);
	$row1	 	= sql_fetch_data($hasil1);
		$namasec 		= $row1['nama'];
		$secid 			= $row1['secid'];
		$secalias 		= $row1['alias'];
	sql_free_result($hasil1);
	
	$where 	= "and secid='$secid'";
	$rubrik = "$namasec";
	$tpl->assign("rubrik","$rubrik");
	$tpl->assign("arsip","$fulldomain/$kanal/list/$secalias/");
}
else
{
	$secalias = "uncategorize";
	$tpl->assign("rubrik","$rubrik");
	$tpl->assign("arsip","$fulldomain/$kanal/");
}

$judul_per_hlm = 10;
$batas_paging = 5;
$hlm = $var[5];

$sql = "select count(*) as jml from tbl_$kanal where published='1' $where";
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

$mysql = "select id,ringkas,nama,create_date,alias,secid,gambar,gambar1 from tbl_$kanal where published='1'  $where order by id  desc limit $ord, $judul_per_hlm";
$hasil = sql( $mysql);
$datadetail = array();		
$i 			= 0;
while ($data =  sql_fetch_data($hasil)) 
{	
	$tanggal 	= $data['create_date'];
	$nama 		= $data['nama'];
	$id 		= $data['id'];
	$ringkas 	= ringkas($data['ringkas'],30);
	$alias 		= $data['alias'];
	$tanggal 	= tanggaltok_english($tanggal);
	$gambar 	= $data['gambar'];
	$gambar1 	= $data['gambar1'];
	$secid 		= $data['secid'];
	
	$perintah = "select alias,nama from tbl_$kanal"."_sec where secid='$secid'";
	$res = sql($perintah);
	$dt =  sql_fetch_data($res);
	$secalias1 	= $dt['alias'];
	$namasec 	= $dt['nama'];
	sql_free_result($res);
	
	if(empty($secalias1))
	{
		$secalias1	= "uncategorize";
		$namasec	= "Uncategorize";
	}
	
	if($i==0){ $gambar= $gambar1; }
	else { $gambar = $gambar; }
	
	if(!empty($gambar)) $gambar = "$fulldomain/gambar/$kanal/$gambar";
	 else $gambar = "$fulldomain/images/img.blog.jpg";
		 
	$link = "$fulldomain/$kanal/read/$secalias1/$id/$alias";
		
	$datadetail[$id] = array("id"=>$id,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar,"namasec"=>$namasec);
	$i++;
}
sql_free_result($hasil);
$tpl->assign("datadetail",$datadetail);
$tpl->assign("namasec",$namasec);

$perintah = "select id,nama,ringkas,lengkap,gambar1,gambar,create_date,alias,views,oleh,tags from tbl_$kanal where id='$id'";
$hasil = sql($perintah);
$data =  sql_fetch_data($hasil);

$idcontent   = $data['id'];
$nama        = $data['nama'];
$lengkap     = $data['lengkap'];
$tanggal     = tanggaltok_english($data['create_date']);
$gambar      = $data['gambar1'];
$gambarshare = $data['gambar'];
$ringkas     = $data['ringkas'];
$alias       = $data['alias'];
$views       = $data['views'];
$oleh        = $data['oleh'];
$tag         = $data['tags'];

$t = explode(",",$tag);
$tags = array();
for($c=0;$c<count($t);$c++)
{
	$tags[$c] = "<a href='$fulldomain/$kanal/tag/'>".trim($t[$c])."</a>";
}
$hasiltag = implode("/ ",$tags);
$tpl->assign("tags",$tags);
$tpl->assign("hasiltag",$hasiltag);

//Paging 
$batas_page = 5;
$stringpage = array();
$pageid 	= 0;

if ($hlm > 1){
	$prev = $hlm - 1;
	// $stringpage[$pageid] = array("nama"=>"Awal","link"=>"$fulldomain/$kanal/$aksi/$secalias/1");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"PREV","link"=>"$fulldomain/$kanal/$aksi/$secalias/$prev");

}
else {
	// $stringpage[$pageid] = array("nama"=>"Awal","link"=>"","disabled"=>"disabled");
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
		$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/$aksi/$secalias/$ii");
	}
	$pageid++;
}
if ($hlm < $hlm_tot){
	$next = $hlm + 1;
	$stringpage[$pageid] = array("nama"=>"NEXT","link"=>"$fulldomain/$kanal/$aksi/$secalias/$next");
	$pageid++;
	// $stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$fulldomain/$kanal/$aksi/$secalias/$hlm_tot");
}
else
{
	$stringpage[$pageid] = array("nama"=>"NEXT","link"=>"");
	$pageid++;
	// $stringpage[$pageid] = array("nama"=>"Akhir","link"=>"","disabled"=>"disabled");
}
$tpl->assign("stringpage",$stringpage);
?>