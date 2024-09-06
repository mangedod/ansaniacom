<?php	

$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where orderid='$_SESSION[orderid]'");
/*$kontenhemat = sql_get_var("select ringkas from tbl_static where alias='upselling'");

$tpl->assign("kontenhemat",$kontenhemat);*/
$tpl->assign("orderid",$_SESSION['orderid']);
		
// Tampilkan dalam database
$i = 1;
$a = 1;
$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
$hsl = sql($sql);
$jumlah_keranjang = sql_num_rows($hsl);
$i = 1;
$dt_keranjang = array();
while ($row = sql_fetch_data($hsl))
{
	$id 			= $row['transaksidetailid'];
	$produkpostid	= $row['produkpostid'];
	$qty 			= $row['jumlah'];
	$matauang	 	= $row['matauang'];
	$berat			= $row['berat'];
	$harga	 		= $row['harga'];
	// $tipe			= $row['tipe'];
	
	$sql2	= "select title,misc_harga, misc_diskon, kodeproduk, warnaid, nomor from tbl_product_post where produkpostid='$produkpostid'";//secid,subid,misc_harga_reseller,
	$query2	= sql($sql2);
	$row2	= sql_fetch_data($query2);

	$kodeproduk     = $row2["kodeproduk"];
	$nama           = $row2["title"];
	$alias          = getAlias($nama);
	$secId          = $row2['secid'];
	$subId          = $row2['subid'];
	$nomor        = $row2['nomor'];
	$aliasSecc      = getAliasSec($secId);
	$aliasSubb      = getAliasSub($subId);
	$misc_harga     = $row2['misc_harga'];
	$diskon         = $row2['misc_diskon'];
	$link_produk    = "$fulldomain/product/read/$produkpostid/$alias";
	
	$total		= "$matauang".number_format($row['totalharga'],0,".",".");

	// album
	$gambar_s	= sql_get_var("select gambar_s from tbl_product_image where produkpostid='$produkpostid' order by albumid asc limit 1");
	
	if(!empty($gambar_s))
		$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
	else
		$image_s	= $lokasiwebtemplate."/images/noimage.jpg";

	$hargadiskon = "$matauang.".number_format($diskon,0,".",".");
	$misc_harga1 = number_format($misc_harga,0,".",".");

	if($diskon!=0){
		$harga_asli = "$hargadiskon";
	}else{
		$harga_asli  = "$misc_harga1";
	}
	

	$dt_keranjang[] = array("id"=>$id,"nama"=>$nama,"kodeproduk"=>$kodeproduk,"produkpostid"=>$produkpostid,"nomor"=>$nomor,"size"=>$size,"berat"=>$berat,"volume"=>$volume,"image_s"=>$image_s,"qty"=>$qty,"harga_asli"=>$harga_asli,"subtotal"=>$total,"a"=>$a,"ketdiskon"=>$ketdiskon,"hargadiskon"=>$hargadiskon,"link_produk"=>$link_produk,"tipe"=>$tipe,"numupselling"=>$numup);
	$i %= 2;
	$i++;
	$a++;
}
sql_free_result ($hsl);
$tpl->assign("dt_keranjang",$dt_keranjang);
$tpl->assign("numprodup",$numprodup);
$tpl->assign("ketdiskon",$ketdiskon);
$tpl->assign("hargadiskon",$hargadiskon);
		
$totalberat = sql_get_var(" SELECT SUM(berat) as total_berat from tbl_transaksi_detail where transaksiid='$transaksiid'");

$totaltagihan = sql_get_var(" SELECT SUM(totalharga) as total_subtotal from tbl_transaksi_detail where transaksiid='$transaksiid'");

//update total tagihan di tbl_transaksi
sql("update tbl_transaksi set totaltagihan='$totaltagihan' where transaksiid='$transaksiid'");

//tampilkan diskon voucher
$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, vouchercodeid, kodevoucher from tbl_transaksi where transaksiid='$transaksiid'");
$rowv                    = sql_fetch_data($qryv);
$voucherid               = $rowv['voucherid'];
$vouchercodeid           = $rowv['vouchercodeid'];
$totaldiskon             = $rowv['totaldiskon'];
$kodevoucher             = $rowv['kodevoucher'];
$totaltagihanafterdiskon = $totaltagihan-$totaldiskon;

//update total tagihan di tbl_transaksi
sql("update tbl_transaksi set totaltagihanafterdiskon='$totaltagihanafterdiskon' where transaksiid='$transaksiid'");

$namavoucher = sql_get_var("select nama from tbl_voucher where id = '$voucherid'");

if($totaltagihanafterdiskon==0)
	$totaltagihanakhir = $totaltagihan+$ongkoskirim;
else
	$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;

$totaltagihan1 = number_format($totaltagihan,0,",",".");
$totaltagihan2 = "$matauang $totaltagihan1";

$totaltagihanakhir1 = number_format($totaltagihanakhir,0,",",".");
$totaltagihanakhir2 = "$matauang $totaltagihanakhir1";

$totaldiskon1 = number_format($totaldiskon,0,",",".");
$totaldiskon2 = "$matauang $totaldiskon1";

$tpl->assign("totalberat",$totalberat);
$tpl->assign("total_subtotal",$totaltagihan2);
$tpl->assign("total_subtotalx",$totaltagihan);
$tpl->assign("totaltagihanakhir",$totaltagihanakhir2);
$tpl->assign("total_subtotalxx",$totaltagihanakhir);
$tpl->assign("jumlah_keranjang",$jumlah_keranjang);
$tpl->assign("kodevoucher",$kodevoucher);
$tpl->assign("namavoucher",$namavoucher);
$tpl->assign("totaldiskonn",$totaldiskon);
$tpl->assign("totaldiskon",$totaldiskon2);
$tpl->assign("transaksiid",$transaksiid);

//data cart untuk header
$qrycart		= sql("select transaksiid, totaltagihan from tbl_transaksi where orderid='$_SESSION[orderid]'");
$rowcart		= sql_fetch_data($qrycart);
$transaksiidc	= $rowcart['transaksiid'];
$total_cart		= $rowcart['totaltagihan'];


$jumlah_cart 	= sql_get_var("select count(*) as jml from tbl_transaksi_detail where transaksiid='$transaksiidc'");

$total_cart1 	= number_format($total_cart,0,",",".");
$total_cart2 	= "$total_cart1";

$tpl->assign("total_cart",$total_cart2);
$tpl->assign("jumlah_cart",$jumlah_cart);	

$sekarang		= tanggaltok(date("Y-m-d H:i:s"));
$tpl->assign("sekarang",$sekarang);	

if($jumlah_cart!=0)
{
	$data2			= " SELECT transaksidetailid,produkpostid,jumlah,matauang,totalharga,berat from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc limit 3";
	$hasil2			= sql($data2);
	$topcart	 	= array();
	$no				= 1;
	while ($row2	= sql_fetch_data($hasil2))
	{
		$idprodukd	 	= $row2['produkpostid'];
		$qtyd		 	= $row2['jumlah'];
		$idd		 	= $row2['transaksidetailid'];
		$misc_matauangd	= $row2['matauang'];
		$berat			= $row2['berat'];
		$misc_hargaprodukd	= number_format($row2['totalharga'],0,".",".");
		
		$totberat		= $qtyd*$berat;
	
		//data produk
		$sql	= "select title,produkid from tbl_product_post where 
				produkpostid='$idprodukd' and published='1'";//,secid,subidstatus='1' and 
		$query	= sql($sql);
		$row	= sql_fetch_data($query);
		$namaprodukd		= $row["title"];
		$produkid				= $row['produkid'];
		$secidd				= $row['secid'];
		$aliasd				= getAlias($namaprodukd);
		sql_free_result($query);
		
		// album
		$sql1		= "select albumid,gambar_s from tbl_product_image where produkid='$produkid' and gambar_s!='' order by albumid asc limit 1";
		$query1		= sql($sql1);
		$row1 		= sql_fetch_data($query1);
		$albumid		= $row1['albumid'];
		$gambarprodukd	= $row1['gambar_s'];
		
		if(!empty($gambarprodukd))
			$gambarprodukd	= "$fulldomain/gambar/produk/$gambarprodukd";
		else
			$gambarprodukd	= $lokasiwebtemplate."/images/no_photo.gif";
		sql_free_result($query1);	
		
		$aliassecd		= getAliasSec($secidd);
		$aliassubd		= getAliasSub($subidd);
		
		$urld			= "$fulldomain/produk/read/$aliassecd/$aliassubd/$idprodukd/$aliasd.html";
		
		$topcart[$idd] = array("idd"=>$idd,"namaproduk"=>$namaprodukd,"qtyd"=>$qtyd,"gambarprodukd"=>$gambarprodukd,"misc_hargaprodukd"=>"$misc_matauangd $misc_hargaprodukd",
						"idprodukd",$idprodukd,"classd"=>$classd,"urld"=>$urld,"berat"=>$berat);
	}
	sql_free_result($hasil2);
	$tpl->assign("topcart",$topcart);
}
?>