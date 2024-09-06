<?php 
$productpil 	= array();
$h 				= 1;
$perintah 	= "select produkpostid,title,kodeproduk,produkid from tbl_product_post where published='1' order by rand() asc limit 1";
$hasil 		= sql($perintah);
while ($data =  sql_fetch_data($hasil))
{
	$produkpostid  = $data['produkpostid'];
	$namaprod1     = ucwords($data["title"]);
	$namaprod      = substr($namaprod1, -100, 37);
	$alias         = getAlias($namaprod);
	$produkid = $data['produkid'];

	$dtprod        = sql_get_var_row("select misc_harga,misc_diskon,misc_matauang from tbl_product where  status='1' and  kodeproduk='$kodeproduk'");
	$misc_diskon   = $dtprod['misc_diskon'];
	$misc_harga    = $dtprod['misc_harga'];
	$misc_matauang = $dtprod['misc_matauang'];
	
	$sDiskon		= 0;
	$hDiskon		= 0;
	if($misc_diskon!=0)
	{
		//$sDiskon		= ceil(($misc_diskon/100)*$misc_harga);
		$hDiskon		= $misc_diskon;
		$sDiskon		= $misc_harga - $misc_diskon;
	}
	
	$misc_harga		= $misc_matauang." ". number_format($misc_harga,0,".",".");
	$misc_diskonnya	= $misc_matauang." ". number_format($hDiskon,0,".",".");
	$savenya		= $misc_matauang." ". number_format($sDiskon,0,".",".");
	
	$gambar_m	= sql_get_var("select gambar_m from tbl_product_image where produkid='$produkid' and gambar_m!='' order by albumid asc limit 1");
	
	if(!empty($gambar_m))
		$image_m	= "$fulldomain/gambar/produk/$gambar_m";
	else
		$image_m	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
	
	if($contactdomain=='')
	{
		$urlmenu = "";
	}
	else
	{
		$urlmenu	= "http://$contactdomain/product/read/$produkpostid/$alias";
	}

	$productpil[$produkpostid] = array("id"=>$produkpostid,"h"=>$h,"nama"=>$namaprod,"urlmenu"=>$urlmenu,"price"=>$misc_harga,"misc_diskon"=>$misc_diskonnya,"savenya"=>$savenya,"save"=>$sDiskon,"misc_matauang"=>$misc_matauang,"diskon"=>$misc_diskon,"misc_diskonn"=>$sDiskon,"gambar"=>$image_m);
	$h %= 2;
	$h++;
}
sql_free_result($hasil);
$tpl->assign("productpil",$productpil);
?>