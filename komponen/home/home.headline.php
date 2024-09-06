<?php 
$mysql = "select id,ringkas,nama,create_date,alias,gambar,url from tbl_headline order by id desc limit 5";
$hasil = sql($mysql);

$no = 0;
$a = 1;
while ($data = sql_fetch_data($hasil)) {	
		$tanggal = $data['create_date'];
		$nama = $data['nama'];
		$idheadline = $data['id'];
		$ringkas = $data['ringkas'];
		$url = $data['url'];
		$tanggal = tanggal($tanggal);
		$gambar = $data['gambar'];
		
		$link = "$fulldomain$url";
		$gambar = "$fulldomain".$gambar;
			
		$dataheadline[] = array("id"=>$idheadline,"a"=>$a,"no"=>$no,"nama"=>$nama,"ringkas"=>$ringkas,"namasec"=>$namasec,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
		$a++;
		$no++;	
}
sql_free_result($hasil);
$tpl->assign("dataheadline",$dataheadline);

?>