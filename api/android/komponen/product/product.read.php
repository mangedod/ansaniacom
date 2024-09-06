<?php 
$produkid	= $var[4];


$sql	= "select kodeproduk, title, content, ringkas, misc_harga,cart, create_date, brandid,icon from tbl_product where produkid='$produkid' and published='1'";
$query	= sql($sql);
$row	= sql_fetch_data($query);
$namaprod			= $row["title$lang"];
$content			= $row["content"];
$ringkas			= $row["ringkas"];
$cart				= $row['cart'];
$body_dimension		= $row['body_dimension'];
$body_weight		= $row['body_weight'];
$harga		= $row['misc_harga'];
$postTime			= tanggaltok($row['create_date']);
$brandidnya			= $row['brandid'];
$misc_matauang		= $row['misc_matauang'];
$jenisvideo			= $row['jenisvideo'];
$screenshot			= $row['screenshot'];
$urlyoutube			= $row['urlyoutube'];
$kodeproduk			= $row['kodeproduk'];
$kinti 		= $row['kinti'];
$kdasar 		= $row['kdasar'];
$stock		= $row['stock'];
$alatbahan 		= $row['alatbahan'];
$penggunaan 		= $row['penggunaan'];
$icon		 		= $row['icon'];

if(!empty($icon))
	$icons	= "$fulldomain/gambar/produk/$produkid/$icon";
else
	$icons	= "";

$sDiskon		= 0;
$hDiskon		= 0;
if($harga!=0)
{
	//$sDiskon		= ceil(($harga/100)*$misc_harga);
	$hDiskon		= $harga;
	$sDiskon		= $misc_harga - $harga;
}

$misc_harga_reseller = 0;
if($_SESSION['secid'] == '2')
{
	$misc_harga_reseller = $row['misc_harga_reseller'];
	$misc_hargares1      = number_format($misc_harga_reseller,0,".",".");
	$misc_hargares2      = "$misc_matauang $misc_hargares1";
}

$misc_harga1 = number_format($misc_harga,0,".",".");
$misc_harga2 = "$misc_matauang $misc_harga1";
$harganya	= "$misc_matauang ". number_format($hDiskon,0,".",".");
$savenya	= "$misc_matauang ". number_format($sDiskon,0,".",".");

//Data Brand
$brand     = sql("select brandid,nama from tbl_product_brand where brandid='$brandidnya'");
$dtb       = sql_fetch_data($brand);
$namabrand = $dtb['nama'];

sql_free_result($query);

$sql	= "update tbl_product set numviews=numviews+1 where produkid='$produkid'";
$query	= sql($sql);
$totalstok	= $stock;


// Gambar
$sql3		= "select albumid,nama,gambar_m,gambar_s,gambar_l,gambar_f from tbl_product_image where produkid='$produkid' order by albumid asc";
$query3		= sql($sql3);
$list_image	= array();
$ii			= 1;
$albumarr 	= array();
while($row3		= sql_fetch_data($query3))
{
	$albumid	= $row3['albumid'];
	$nama_image	= $row3['nama'];
	$gambar_s	= $row3['gambar_s'];
	$gambar_m	= $row3['gambar_m'];
	$gambar_l	= $row3['gambar_l'];
	$gambar_f	= $row3['gambar_f'];
	
	if(!empty($gambar_m))
		$image_m	= "$fulldomain/gambar/produk/$gambar_m";
	else
		$image_m	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
		
	if(!empty($gambar_s))
		$image_s	= "$fulldomain/gambar/produk/$gambar_s";
	else
		$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
	
	if(!empty($gambar_l))
		$image_l	= "$fulldomain/gambar/produk/$gambar_f";
	else
		$image_l	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
		
	if(!empty($gambar_f))
		$image_f	= "$fulldomain/gambar/produk/$gambar_f";
	else
		$image_f	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
		
	if(($s=="m" or $s=="f") and ($var[7]))
	{
		if($albumid==$var[7])
		{
			$nama_image		= $nama_image;
			$firstImageId	= $albumid;
			$tpl->assign("detailgambar",$image_m);
		}
	}
	else if($ii == 1)
	{
		$image_besar	= $image_f;
		$image_mm		= $image_m;
		$image_ss 		= $image_s;
		$image_ll		= $image_l;
		$nama_image		= $nama_image;
		
		$firstImageId	= $albumid;
	}
	
	$list_image[]	= array("index"=>$ii,"albumid"=>$albumid,"nama"=>$nama_image,"gambar"=>$image_m,"ringkas"=>$nama_image,"image_l"=>$image_l,"image_f"=>$image_f);
	$albumarr[$ii] 			= $albumid;
	$ii++;
}
sql_free_result($query3);
$detailalias		= getAlias($namaprod);

$result['status']="OK";
$result['message']="Data berhasil di load";
$result['harganya'] = $harganya;
$result['detailid'] = $idcontent;
$result['detailnama'] = $namaprod;
$result['detailgambar'] = $image_l;
$result['detaillengkap'] = $content;
$result['detailringkas'] = $ringkas;
$result['detailringkasshare'] = $ringkasshare;
$result['detailcreator'] = $oleh;
$result['detailtanggal'] = $tanggal;
$result['detailalias'] = $alias;
$result['detailurl'] = $url;
$result['stock'] = $stock;
$result['detailgaleri'] = $list_image;	
$result['berat'] = $body_weight;	
$result['ukuran'] = $body_dimension;

if(!empty($userid))
{
	$owner = getprofileid($userid);
}
$result['owner'] = $owner;	

echo json_encode($result);


/*$tpl->assign("secId",$secId);
$tpl->assign("subId",$subId);
$tpl->assign("produkid",$produkid);
$tpl->assign("detailnama",$namaprod);

$tpl->assign("price",$misc_harga2);
$tpl->assign("savenya",$savenya);
$tpl->assign("hargan",$sDiskon);
$tpl->assign("harga",$harganya);
$tpl->assign("misc_harga_reseller",$misc_harga_reseller);
$tpl->assign("hargares",$misc_hargares2);

$tpl->assign("image_m",$image_mm);
$tpl->assign("image_s",$image_ss);
$tpl->assign("image_l",$image_ll);
$tpl->assign("namaprod",$namaprod);
$tpl->assign("detailringkas",$ringkas);
$tpl->assign("detaillengkap",$content);
$tpl->assign("detailkinti",$kinti);
$tpl->assign("detailkdasar",$kdasar);
$tpl->assign("detailalatbahan",$alatbahan);
$tpl->assign("detailstock",$stock);
$tpl->assign("detailpenggunaan",$penggunaan);
$tpl->assign("cart",$cart);
$tpl->assign("detailalias",$detailalias);
$tpl->assign("secid1",$var[3]);
$tpl->assign("subid1","$var[4]/$var[5]");
$tpl->assign("detailtanggal",$postTime);
$tpl->assign("detailgambar",$image_ll);
$tpl->assign("image_besar",$image_besar);
$tpl->assign("stock",$stock);
$tpl->assign("link_cat","$fulldomain/product/list/$aliasSec");
$tpl->assign("gambarproduk",$gambarproduk);
$tpl->assign("videoproduk",$videoproduk);
$tpl->assign("jenisvideo",$jenisvideo);
$tpl->assign("link_buy","$fulldomain/quickbuy/addpost/$produkid/$detailalias");
$tpl->assign("detailkode",$kodeproduk);
$tpl->assign("wishlist",$wishlist);
$tpl->assign("review",$review);
$tpl->assign("icon",$icons);
$tpl->assign("ispesan",$ispesan);
$tpl->assign("ispinjam",$ispinjam);
$tpl->assign("detailuserid",$userid);
*/
	

?>
