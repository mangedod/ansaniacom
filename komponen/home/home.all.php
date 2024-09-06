<?php
	// Kategori Produk
	$sql1		= "select secid,namasec,alias from tbl_product_sec order by secid asc";
	$query1		= sql($sql1);
	$list_sec	= array();
	$nokateg 	= 1;
	$jumkateg	= sql_num_rows($query1);
	while($row1 = sql_fetch_data($query1))
	{
		$secid		= $row1['secid'];
		$nama		= $row1["namasec"];
		$aliassec	= $row1['alias'];
		$url_sec	= "$fulldomain/produk/list/$aliassec";
		
		$sql2		= "select subid, namasub, alias from tbl_product_sub where secid='$secid' order by subid asc";
		$query2		= sql($sql2);
		$numsubtoko	= sql_num_rows($query2);
		$nosub 		= 1;
		$i	 		= 1;
		$jumsub 	= sql_num_rows($query2);
		while($row2 = sql_fetch_data($query2))
		{
			$subid		= $row2['subid'];
			$namasub	= $row2["namasub"];
			$aliassub	= $row2['alias'];
			$url_sub	= "$fulldomain/produk/list/$aliassec/$aliassub";
			
			$list_sub[$secid][$subid]	= array("subid"=>$subid,"namasub"=>$namasub,"url_sub"=>$url_sub,"nosub"=>$nosub,"i"=>$i);
			$i %= 2;
			$i++;
			$nosub++;
		}
		sql_free_result($query2);
		$list_sec[]	= array("secid"=>$secid,"nama"=>$nama,"url_sec"=>$url_sec,"nokateg"=>$nokateg,"jumsub"=>$jumsub,"numsubtoko"=>$numsubtoko);
		$nokateg++;
	}
	sql_free_result($query1);
		
	$tpl->assign("list_sec",$list_sec);
	$tpl->assign("list_sub",$list_sub);
	$tpl->assign("jumkateg",$jumkateg);
	$tpl->assign("jumkategakhir",$jumkateg+1);

	//Topmenu
	$sqlsub	= "select id,nama from tbl_top where published='1' order by rand() limit 1";
	$querysub	= sql($sqlsub);
	$toppromo= array();
	while($rowsub = sql_fetch_data($querysub))
	{
		$idx		= $rowsub['id'];
		$nama	= $rowsub["nama"];
		$url	= "$fulldomain/top/read/$idx";
		
		$toppromo[]	= array("id"=>$idx,"nama"=>$nama,"url"=>$url);
	}
	sql_free_result($querysub);
	$tpl->assign("toppromo",$toppromo);

	
	// Sub kategori
	$sqlsub	= "select subid, secid, namasub$lang, alias from tbl_product_sub order by rand() limit 5";
	$querysub	= sql($sqlsub);
	$subkategori= array();
	while($rowsub = sql_fetch_data($querysub))
	{
		$subid		= $rowsub['subid'];
		$secid		= $rowsub['secid'];
		$namasub	= $rowsub["namasub$lang"];
		$aliassub	= $rowsub['alias'];
		$aliassec 	= getAliasSec($secid);
		$url_sub	= "http://{$basedomain}/produk/list/$aliassec/$aliassub";
		
		$subkategori[$subid]	= array("subid"=>$subid,"namasub"=>$namasub,"url_sub"=>$url_sub,"nosub"=>$nosub);
	}
	sql_free_result($querysub);
	$tpl->assign("subkategori",$subkategori);

	// Brand Produk
	$sql1	= "select brandid,nama,alias from tbl_product_brand order by rand() limit 5";
	$query1	= sql($sql1);
	$list_brand	= array();
	while($row1 = sql_fetch_data($query1))
	{
		$brandid	= $row1['brandid'];
		$nama		= $row1['nama'];
		$aliasbrand	= $row1['alias'];
		$url_brand	= "$fulldomain/product/brand/$aliasbrand";
		
		$list_brand[$brandid]	= array("brandid"=>$brandid,"nama"=>$nama,"url_brand"=>$url_brand);
	}
	sql_free_result($query1);
	$tpl->assign("list_brand",$list_brand);

	// Jenis Produk
	$sql1	= "select jenisid,nama,alias from tbl_product_jenis order by jenisid asc";
	$query1	= sql($sql1);
	$jenis	= array();
	while($row1 = sql_fetch_data($query1))
	{
		$jenisid	= $row1['jenisid'];
		$nama		= $row1['nama'];
		$aliasbrand	= $row1['alias'];
		$url_brand	= "$fulldomain/product/jenis/$aliasbrand";
		
		$jenis[]	= array("jenisid"=>$jenisid,"nama"=>$nama,"url"=>$url_brand);
	}
	sql_free_result($query1);
	$tpl->assign("jenis",$jenis);


	

	if($s=="m") $limit = 6;
	else $limit = 6;

	//data cart
	if($_SESSION['orderid'])
	{
		$qrycart       = sql("select transaksiid, totaltagihan from tbl_transaksi where orderid='$_SESSION[orderid]'");
		$rowcart       = sql_fetch_data($qrycart);
		$transaksiidc  = $rowcart['transaksiid'];
		$total_cart    = $rowcart['totaltagihan'];
		$jumlah_cart   = sql_get_var("select count(*) as jml from tbl_transaksi_detail where transaksiid='$transaksiidc'");
		$totaltagihan1 = sql_get_var(" SELECT SUM(totalharga) as total_subtotal from tbl_transaksi_detail where transaksiid='$transaksiidc'");
		$totaltagihan  = "IDR ".number_format($totaltagihan1,0,",",".");
	}
	else
	{
		$total_cart		= 0;
		$jumlah_cart 	= 0;
	}
	
	$total_cart1 	= number_format($total_cart,0,",",".");
	$total_cart2 	= "$total_cart1";
	
	$tpl->assign("total_cart",$total_cart2);
	$tpl->assign("jumlah_cart",$jumlah_cart);	
	$tpl->assign("totaltagihanhead",$totaltagihan);	
	
	$sekarang		= tanggaltok(date("Y-m-d H:i:s"));
	$tpl->assign("sekarang",$sekarang);	
	
	if($jumlah_cart > 0)
	{
		$data2			= " SELECT transaksidetailid,produkpostid,jumlah,matauang,totalharga from tbl_transaksi_detail where transaksiid='$transaksiidc' order by transaksidetailid desc limit 3";
		$hasil2			= sql($data2);
		$topcart	 	= array();
		$no				= 1;
		while ($row2	= sql_fetch_data($hasil2))
		{
			$idprodukd	 	= $row2['produkpostid'];
			$qtyd		 	= $row2['jumlah'];
			$idd		 	= $row2['transaksidetailid'];
			$misc_matauangd	= $row2['matauang'];
			$misc_hargaprodukd	= number_format($row2['totalharga'],0,".",".");
	
			//data produk
			$sql	= "select title,produkid from tbl_product_post where produkpostid='$idprodukd' and published='1'";
			$query	= sql($sql);
			$row	= sql_fetch_data($query);
			$namaprodukd		= $row["title"];
			$subidd				= $row['subid'];
			$produkid				= $row['produkid'];
			$secidd				= $row['secid'];
			$aliasd				= getAlias($namaprodukd);
			sql_free_result($query);
			
			// album
			$gambarprodukd		= sql_get_var("select gambar_s from tbl_product_image where produkid='$produkid' and gambar_s!='' order by albumid asc limit 1");
			
			
			if(!empty($gambarprodukd))
				$gambarprodukd	= "$fulldomain/gambar/produk/$gambarprodukd";
			else
				$gambarprodukd	= $lokasiwebtemplate."/images/no_photo.gif";
			
			$aliassecd		= getAliasSec($secidd);
			$aliassubd		= getAliasSub($subidd);
			
			$urld			= "$fulldomain"."/product/read/$idprodukd/$aliasd";
			
			$topcart[] = array("idd"=>$idd,"namaproduk"=>$namaprodukd,"qtyd"=>$qtyd,"gambarprodukd"=>$gambarprodukd,"misc_hargaprodukd"=>"$misc_matauangd $misc_hargaprodukd",
							"idprodukd",$idprodukd,"classd"=>$classd,"urld"=>$urld);
		}
		sql_free_result($hasil2);
		$tpl->assign("topcart",$topcart);
	}
		

	$jumwishlist 	= sql_get_var("select count(*) as jml from tbl_wishlist where userid='$_SESSION[userid]'");
	$tpl->assign("jumwishlist",$jumwishlist);
	
	$sql = "select id,produkpostid from tbl_wishlist where userid='$_SESSION[userid]' order by produkpostid desc limit 3";
	$hsl = sql($sql);
	$i = 1;
	$dt_wishlist = array();
	while ($row = sql_fetch_data($hsl))
	{
		$id 			= $row['id'];
		$produkpostid	= $row['produkpostid'];
		
		$sql2	= "select title,misc_harga, misc_diskon, misc_matauang,productid from tbl_product_post where produkpostid='$produkpostid'";//,secid,subid
		$query2	= sql($sql2);
		$row2	= sql_fetch_data($query2);
		$nama			= $row2["title"];
		$alias			= getAlias($nama);
		$secId			= $row2['secid'];
		$subId			= $row2['subid'];
		$upsellingid	= $row2['upsellingid'];
		$aliasSecc		= getAliasSec($secId);
		$aliasSubb		= getAliasSub($subId);
		$jenisvideo		= $row2['jenisvideo'];
		$screenshot		= $row2['screenshot'];
		$upsellingid	= $row2['upsellingid'];
		$diskon		= $row2['misc_diskon'];
		$matauang		= $row2['misc_matauang'];
		$misc_harga 		= $row2['misc_harga'];
		$misc_diskon 		= $row2['misc_diskon'];
		$productid 		= $row2['productid'];
		
		$sDiskon		= "";
		
		if($misc_diskon!=0)
		{
			//$sDiskon		= ($diskon/100)*$misc_harga;
			//$hDiskon		= $misc_harga - $sDiskon;
			$hDiskon		= $misc_diskon;
			$sDiskon		= $misc_harga - $misc_diskon;
		}
		else
			$hDiskon		= $misc_harga;	
		//echo($diskon);
		
		$misc_harga_reseller = 0;
		if($_SESSION['secid'] == '2')
		{
			$misc_harga_reseller = $row2['misc_harga_reseller'];
			$misc_hargares1 = number_format($misc_harga_reseller,0,".",".");
			$misc_hargares2 = "$misc_matauang $misc_hargares1";
		}
		
	
		$harga2		= number_format($hDiskon,0,".",".");
		
		$harga2		= "$matauang. $harga2";
	
		
		// album
		$sql1	= "select albumid,nama,gambar_m,gambar_s from tbl_product_image where productid='$productid' order by albumid asc limit 1";
		$query1	= sql($sql1);
		$row1 = sql_fetch_data($query1);
		$albumid	= $row1['albumid'];
		$namas		= $row1['nama'];
		$gambar_m	= $row1['gambar_m'];
		$gambar_s	= $row1['gambar_s'];
		
		if(!empty($gambar_m))
			$image_m	= "$fulldomain/gambar/produk/$gambar_m";
		else
			$image_m	= $lokasiwebtemplate."/images/no_photo.gif";
			
		if(!empty($gambar_s))
			$image_s	= "$fulldomain/gambar/produk/$gambar_s";
		else
			$image_s	= $lokasiwebtemplate."/images/no_photo.gif";
		
		
	
		
		
		$totalstok	= sql_get_var("select totalstok from tbl_product_total where produkpostid='$productid'");
		
		$link_detail	= "$fulldomain/produk/detail/$aliasSecc/$aliasSubb/$produkpostid/$alias";

		$dt_wishlist[$id] = array("id"=>$id,"nama"=>$nama,"produkpostid"=>$produkpostid,"berat"=>$berat,"volume"=>$volume,"image_s"=>$image_s,"harga"=>$harga2,"qty"=>$qty,
							"subtotal"=>$total,"diskon"=>$diskon,"a"=>$a,"hargadiskon"=>$hargadiskon,"link_produk"=>$link_detail,"totalstok"=>$totalstok,"misc_harga_reseller"=>$misc_harga_reseller,"hargares"=>$misc_hargares2,);
		$i %= 2;
		$i++;
		$a++;
	}
	sql_free_result ($hsl);
	$tpl->assign("dt_wishlist",$dt_wishlist);
		
	
?>