<?php 
$mysql = "select tipeid,nama,keterangan,gambar,create_date,create_userid,update_date,update_userid from tbl_product_tipe order by create_date desc limit 4";//where published='1' 
$hasil = sql($mysql);

$tipeproduk = array();
$a =1;
while ($row = sql_fetch_data($hasil)) {	
		$tipeid     = $row['tipeid'];
		$nama       = $row['nama'];
		$alias      = getAlias($nama);
		$keterangan = $row['keterangan'];
		$gambar     = $row['gambar'];

		$sql2		= "select secid, namasec, alias from tbl_product_sec where tipeid='$tipeid' order by secid asc limit 6";
		$query2		= sql($sql2);
		$numsectoko	= sql_num_rows($query2);
		$nosec 		= 1;
		$i	 		= 1;
		$jumsub 	= sql_num_rows($query2);
		while($row2 = sql_fetch_data($query2))
		{
			$secidh		= $row2['secid'];
			$namasec	= $row2["namasec"];
			$aliassec	= $row2['alias'];
			$url_sec	= "$fulldomain/product/list/$aliassec";
			
			$menusec[$tipeid][$secidh]	= array("secidh"=>$secidh,"namasech"=>$namasec,"url_sec"=>$url_sec,"nosec"=>$nosec,"i"=>$i);
			$i %= 2;
			$i++;
			$nosec++;
		}
		sql_free_result($query2);
		// print_r($menusec);
	
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/produk-tipe/$gambar";
			 else $gambar = "";
		$link = "$fulldomain/product/list/$alias";
			
		$tipeproduk[] = array("tipeid"=>$tipeid,"no"=>$a,"nama"=>$nama,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
		$a++;	
}
$a = 0;
sql_free_result($hasil);
$tpl->assign("tipeproduk",$tipeproduk);
$tpl->assign("menusec",$menusec);

//Kategori Produk
$mysql = "select secid,namasec,alias,gambar,icon from tbl_product_sec order by secid  asc";
$hasil = sql( $mysql);

$productsec = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$namasec = $data['namasec'];
	$secids  = $data['secid'];
	$alias   = $data['alias'];
	$gambar   = $data['gambar'];
	$icon   = $data['icon'];

	if(!empty($gambar)) $gambar = "$fulldomain/gambar/produk-kategori/$gambar";
	else $gambar = "";

	if(!empty($icon)) $icon = "$fulldomain/gambar/produk-kategori/$icon";
	else $icon = "";

	$urlsec = "$fulldomain/product/kat/$alias";
		
	$productsec[] = array("secid"=>$secids,"namasec"=>$namasec,"link"=>$urlsec,"gambar"=>$gambar,"icon"=>$icon);
	$i++;
		
}
sql_free_result($hasil);
$tpl->assign("productsec",$productsec);

?>