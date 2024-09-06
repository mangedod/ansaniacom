<?php 
$mysql = "select id,ringkas,nama,create_date,alias,gambar,gambar1 from tbl_perusahaan where published='1' order by id  asc";
$hasil = sql( $mysql);

$menuperusahaan = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$tanggal = $data['create_date'];
	$nama = $data['nama'];
	$ids = $data['id'];
	$ringkas = $data['ringkas'];
	$alias = $data['alias'];
	$tanggal = tanggal($tanggal);
	$secid = $data['secid'];

		 

	$link = "$fulldomain/perusahaan/read/$ids/$alias";
		
	$menuperusahaan[$ids] = array("id"=>$ids,"no"=>$i,"namasec"=>$namasec,"urlsec"=>$urlsec,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
	$i++;
		
}
sql_free_result($hasil);
$tpl->assign("menuperusahaan",$menuperusahaan);

//Kategori Produk
$mysql = "select secid,namasec,alias from tbl_product_sec order by secid  asc";
$hasil = sql( $mysql);

$productsec = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$namasec = $data['namasec'];
	$secids = $data['secid'];
	$alias = $data['alias'];

	$urlsec = "$fulldomain/product/category/$alias";
		
	$productsec[$secids] = array("secid"=>$secids,"namasec"=>$namasec,"urlsec"=>$urlsec);
	$i++;
		
}
sql_free_result($hasil);
$tpl->assign("productsec",$productsec);


/*$mysql = "select produkpostid,ringkas,title,create_date,alias from tbl_product_post where published='1' order by produkpostid  asc";
$hasil = sql( $mysql);

$menuproduk = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$tanggal = $data['create_date'];
	$nama    = $data['title'];
	$ids     = $data['produkpostid'];
	$ringkas = $data['ringkas'];
	$alias   = $data['alias'];
	$tanggal = tanggal($tanggal);
	$secid   = $data['secid'];

		 

	$link = "$fulldomain/produk/read/$ids/$alias";
		
	$menuproduk[$ids] = array("id"=>$ids,"no"=>$i,"namasec"=>$namasec,"urlsec"=>$urlsec,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
	$i++;
		
}
sql_free_result($hasil);
$tpl->assign("menuproduk",$menuproduk);*/


$mysql = "select id,ringkas,nama,create_date,alias,gambar,gambar1 from tbl_peluang where published='1' order by id  asc";
$hasil = sql( $mysql);

$menupeluang = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$tanggal = $data['create_date'];
	$nama = $data['nama'];
	$ids = $data['id'];
	$ringkas = $data['ringkas'];
	$alias = $data['alias'];
	$tanggal = tanggal($tanggal);
	$secid = $data['secid'];

		 

	$link = "$fulldomain/peluang/read/$ids/$alias";
		
	$menupeluang[$ids] = array("id"=>$ids,"no"=>$i,"namasec"=>$namasec,"urlsec"=>$urlsec,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
	$i++;
		
}
sql_free_result($hasil);
$tpl->assign("menupeluang",$menupeluang);

?>