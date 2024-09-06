<?php 
$mysql = "select id,ringkas,nama,create_date,alias,gambar,youtubeid from tbl_video where published='1' order by create_date desc limit 1";
$hasil = sql($mysql);

$datadepanvideo = array();
$a =1;
while ($data = sql_fetch_data($hasil)) {	
		$tanggal = $data['create_date'];
		$nama = $data['nama'];
		$id = $data['id'];
		$ringkas = $data['ringkas'];
		$alias = $data['alias'];
		$tanggal = tanggal($tanggal);
		$gambar = $data['gambar'];
		$youtubeid = $data['youtubeid'];
		
		$ringkas = substr(bersih($ringkas),0,350);
	
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/video/$gambar";
			 else $gambar = "";
		$link = "$fulldomain/video/read/$id/$alias";
			
		$datadepanvideo[$id] = array("id"=>$id,"a"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"namasec"=>$namasec,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar,"youtubeid"=>$youtubeid);
		$a++;	
}
$a = 0;
sql_free_result($hasil);
$tpl->assign("datadepanvideo",$datadepanvideo);

?>