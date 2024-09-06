<?php 
$rekomendasiblog = array();
$h               = 1;

$perintah 	= "select id,ringkas,nama,create_date,alias,gambar,secid from tbl_blog where published='1' order by rand() desc limit 1";
$hasil 		= sql($perintah);
while ($data =  sql_fetch_data($hasil))
{
	$tanggal    = $data['create_date'];
	$nama       = $data['nama'];
	$ids        = $data['id'];
	$ringkas    = $data['ringkas'];
	$alias      = $data['alias'];
	$tanggal    = tanggal($tanggal);
	$gambar     = $data['gambar'];
	$secid      = $data['secid'];

	$mysql1   = "select nama,alias from tbl_blog"."_sec where secid='$secid'";
	$hasil1   = sql($mysql1);
	$data1    = sql_fetch_data($hasil1);
	$secalias = $data1['alias'];
	$namasec  = $data1['nama'];

	if(!empty($gambar)) $gambar = "$fulldomain/gambar/blog/$gambar";
		 else $gambar = "";

	$link = "$fulldomain/blog/read/$secalias/$ids/$alias";

	$rekomendasiblog[$ids] = array("id"=>$ids,"no"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"namasec"=>$namasec,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
	$h %= 2;
	$h++;
}
sql_free_result($hasil);
$tpl->assign("rekomendasiblog",$rekomendasiblog);
?>