<?php
$mysql = "select id,ringkas,nama,create_date,alias,gambar,secid from tbl_blog where published='1' and gambar!='' and (userid='0' or userid='$contactid') order by id desc limit 3";
$hasil = sql($mysql);

$datadepanblog = array();
$a =1;
while ($data = sql_fetch_data($hasil)) {	
		$tanggal = $data['create_date'];
		$nama = $data['nama'];
		$id = $data['id'];
		$ringkas = $data['ringkas'];
		$alias = $data['alias'];
		$tanggal = tanggal($tanggal);
		$gambar = $data['gambar'];
		$secid = $data['secid'];
		
		
		$mysql1 = "select nama,alias,secid from tbl_blog_sec where secid='$secid'";
		$hasil1 = sql($mysql1);
		$data1 = sql_fetch_data($hasil1);
		$secalias = $data1['alias'];
		$namasec = $data1['nama'];

	
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/blog/$gambar";
			 else $gambar = "";
		$link = "$fulldomain/blog/read/$secalias/$id/$alias";
			
		$datadepanblog[$id] = array("id"=>$id,"no"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"namasec"=>$namasec,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
		$a++;	
}
$a = 0;
sql_free_result($hasil);
$tpl->assign("datadepanblog",$datadepanblog);

$mysql = "select id,ringkas,nama,create_date,alias,gambar,secid,views from tbl_blog where published='1' and (userid='0' or userid='$contactid') order by views desc limit 5";
$hasil = sql($mysql);

$datablogpopuler = array();
$a =1;
while ($data = sql_fetch_data($hasil)) {	
		$tanggal = $data['create_date'];
		$nama = $data['nama'];
		$id = $data['id'];
		$ringkas = $data['ringkas'];
		$alias = $data['alias'];
		$tanggal = tanggal($tanggal);
		$gambar = $data['gambar'];
		$secid = $data['secid'];
		$views = $data['views'];
		
		$views = number_format($views,0,0,".");
		
		
		$mysql1 = "select nama,alias,secid from tbl_blog_sec where secid='$secid'";
		$hasil1 = sql($mysql1);
		$data1 = sql_fetch_data($hasil1);
		$secalias = $data1['alias'];
		$namasec = $data1['nama'];

	
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/blog/$gambar";
			 else $gambar = "";
		$link = "$fulldomain/blog/read/$secalias/$id/$alias";
			
		$datablogpopuler[$id] = array("id"=>$id,"no"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"namasec"=>$namasec,"tanggal"=>$tanggal,"views"=>$views,"link"=>$link,"gambar"=>$gambar);
		$a++;	
}
$a = 0;
sql_free_result($hasil);
$tpl->assign("datablogpopuler",$datablogpopuler);

?>