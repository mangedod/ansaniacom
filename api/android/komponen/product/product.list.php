<?php 
$judul_per_hlm = 10;
$batas_paging = 5;
$secid = $var[4];
$subid = $var[5];
$start = $var[6];
$limit = $var[7];

$where = "";
if($secid>0)
{
	$where .=" and secid='$secid'";
	$namasec = sql_get_var("select namasec from tbl_product_sec where secid='$secid'");
}
if($subid>0)
{
	$where .=" and subid='$subid'";
	$namasec = sql_get_var("select namasub from tbl_product_sub where subid='$subid'");
}

if(!empty($last)) { $where = " and id < $last"; }




$sql = "select count(*) as jml from tbl_product where published='1' $where";
$hsl = sql($sql);
$tot = sql_result($hsl, 0, "jml");
$hlm_tot = ceil($tot / $judul_per_hlm);		
if (empty($hlm)){
	$hlm = 1;
	}
if ($hlm > $hlm_tot){
	$hlm = $hlm_tot;
	}

$ord = ($hlm - 1) * $judul_per_hlm;
if ($ord < 0 ) $ord=0;


$sqlp	= "select produkid,secid,subid,brandid,title,ringkas,misc_harga from tbl_product where published='1' $where order by produkid desc limit $start, $limit";
$queryp	= sql($sqlp);
$nump	= sql_num_rows($queryp);

$list_post	= array();
$no	= 1;
while($row2 = sql_fetch_data($queryp))
{
	$produkid	= $row2['produkid'];
	$secId			= $row2['secid'];
	$subId			= $row2['subid'];
	$aliasSecc		= getAliasSec($secId);
	$aliasSubb		= getAliasSub($subId);
	$namaprod		= ucwords($row2["title"]);
	$alias			= getAlias($namaprod);
	$ringkas		= bersih($row2['ringkas']);
	$ringkas = ringkas($ringkas,20);
	$misc_matauang	= $row2['misc_matauang'];
	$pilihan		= $row2['pilihan'];
	$jenisvideo		= $row2['jenisvideo'];
	$screenshot		= $row2['screenshot'];
	$harga 	= $row2['misc_harga'];
	$misc_diskon 	= $row2['misc_diskon'];
	$misc_harga 	= $row2['misc_harga'];
	$icon		 	= $row2['icon'];
	

	$sDiskon		= 0;
	$hDiskon		= 0;
	if($misc_diskon!=0)
	{
		//$sDiskon		= ceil(($misc_diskon/100)*$misc_harga);
		$hDiskon		= $misc_diskon;
		$sDiskon		= $misc_harga - $misc_diskon;
	}
	
	$misc_harga_reseller = 0;
	if($_SESSION['secid'] == '2')
	{
		$misc_harga_reseller = $row2['misc_harga_reseller'];
		$misc_hargares1 = number_format($misc_harga_reseller,0,".",".");
		$misc_hargares2 = "$misc_matauang $misc_hargares1";
	}
	
	$misc_harga		= $misc_matauang." ". number_format($misc_harga,0,".",".");
	$misc_diskonnya	= $misc_matauang." ". number_format($hDiskon,0,".",".");
	$savenya		= $misc_matauang." ". number_format($sDiskon,0,".",".");
	
	$sql3	= "select albumid,gambar_m,gambar_l from tbl_product_image where produkid='$produkid' order by albumid asc limit 1";
	$query3	= sql($sql3);
	$row3	= sql_fetch_data($query3);
	$albumid	= $row3['albumid'];
	$gambar_m	= $row3['gambar_m'];
	$gambar_l	= $row3['gambar_l'];
	sql_free_result($query3);
	
	if(!empty($gambar_m))
		$image_m	= "$fulldomain/gambar/produk/$gambar_m";
	else
		$image_m	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
		
	if(!empty($gambar_l))
		$image_l	= "$fulldomain/gambar/produk/$gambar_l";
	else
		$image_l	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
			
	
	$link_detail	= "$fulldomain/product/read/$produkid/$alias";
	$link_buy		= "$fulldomain/quickbuy/addpost/$produkid/$alias";
	
	$harga = rupiah($harga);
	
	
	$list_post[]	= array("id"=>$produkid,"nama"=>$namaprod,"gambar"=>$image_m,"link_detail"=>$link_detail,"ringkas"=>$ringkas,
								"price"=>$misc_harga,"misc_diskon"=>$misc_diskonnya,"savenya"=>$savenya,"save"=>$sDiskon,"misc_matauang"=>$misc_matauang,"no"=>$no,"harga"=>$harga,
								"pilihan"=>$pilihan,"diskon"=>$misc_diskon,"link_buy"=>$link_buy,"link_compare"=>$link_compare,"misc_diskonn"=>$sDiskon,"secid"=>$secId,
								"misc_harga_reseller"=>$misc_harga_reseller,"hargares"=>$misc_hargares2,"wishlist"=>$wishlist,"icon"=>$icons,"seller"=>$seller,"kota"=>$kota);
	$no++;
}
sql_free_result($queryp);

$result['status']="OK";
$result['message']="Data berhasil di load";
$result['halaman']= $hlm;
$result['totalhalaman'] = $hlm_tot;
$result['datalist'] = $list_post;
$result['stringpage'] = $stringpage;
$result['namasec'] = $namasec;
	
echo json_encode($result);

		
?>
