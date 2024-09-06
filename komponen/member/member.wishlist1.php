<?php

$perintah = "select id,produkpostid from tbl_wishlist where userid='$_SESSION[userid]'";
$hasil = sql($perintah);
$list_wishlist=array();
while($data=sql_fetch_data($hasil))
{

	$sqlp	= "select produkpostid,kodeproduk,title,misc_harga,misc_diskon from tbl_product_post where published='1' and produkpostid='$data[produkpostid]'";
	$queryp	= sql($sqlp);
	$row2 = sql_fetch_data($queryp);
	
		$produkpostid      = $row2['produkpostid'];
		$kodeproduk    = $row2['kodeproduk'];
		$title         = $row2['title'];
		$misc_harga         = $row2['misc_harga'];
		$misc_diskon         = $row2['misc_diskon'];
		
		$sql3	= "select albumid,gambar_m,gambar_l from tbl_product_image where produkpostid='$produkpostid' order by albumid asc limit 1";
		$query3	= sql($sql3);
		$row3	= sql_fetch_data($query3);
		$albumid	= $row3['albumid'];
		$gambar_m	= $row3['gambar_m'];
		$gambar_l	= $row3['gambar_l'];
		sql_free_result($query3);
			
		if(!empty($gambar_m))
			$image_m	= "$fulldomain/gambar/produk/$produkpostid/$gambar_m";
		else
			$image_m	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
			
		if(!empty($gambar_l))
			$image_l	= "$fulldomain/gambar/produk/$produkpostid/$gambar_l";
		else
			$image_l	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
		
		$link_detail	= "$fulldomain/product/read/$produkpostid/$alias";
		$link_buy		= "$fulldomain"."quickbuy/addpost/$produkpostid/$alias";
		
		$list_wishlist[$produkpostid]	= array("produkpostid"=>$produkpostid,"namaprod"=>$title,"image_m"=>$image_m,"link_detail"=>$link_detail,"link_buy"=>$link_buy,"misc_diskon"=>$misc_diskon,"misc_harga"=>$misc_harga);
}
sql_free_result($hasil);
$tpl->assign("list_wishlist",$list_wishlist);
?>