<?php 
$mysql = "select id,ringkas,nama,create_date,alias,gambar from tbl_liputan where published='1' order by rand() limit 12";
$hasil = sql($mysql);

$datadepanliputan = array();
$a =1;
while ($data = sql_fetch_data($hasil)) {	
		$tanggal = $data['create_date'];
		$nama = $data['nama'];
		$id = $data['id'];
		$ringkas = $data['ringkas'];
		$alias = $data['alias'];
		$tanggal = tanggal($tanggal);
		$gambar = $data['gambar'];
	
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/liputan/$gambar";
			 else $gambar = "";
		$link = "$fulldomain/liputan/read/$id/$alias";
			
		$datadepanliputan[$id] = array("id"=>$id,"a"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"namasec"=>$namasec,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
		$a++;	
}
$a = 0;
sql_free_result($hasil);
$tpl->assign("datadepanliputan",$datadepanliputan);

?>