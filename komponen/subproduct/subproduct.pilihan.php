<?php

$productpil 	= array();
$h 				= 1;
$perintah 	= "select produkpostid,title,misc_harga,misc_diskon,misc_matauang from tbl_product_post where published='1' order by rand() asc limit 4";
$hasil 		= sql($perintah);
while ($data =  sql_fetch_data($hasil))
{
	$produkpostid = $data['produkpostid'];
	$namaprod1    = ucwords($data["title"]);
	$namaprod     = substr($namaprod1, -100, 37);
	$alias        = getAlias($namaprod);
	$misc_diskon 	= $data['misc_diskon'];
	$misc_harga 	= $data['misc_harga'];
	$misc_matauang 	= $data['misc_matauang'];
	
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
	
	$gambar_m	= sql_get_var("select gambar_m from tbl_product_image where produkpostid='$produkpostid' order by albumid asc limit 1");
	
	if(!empty($gambar_m))
		$image_m	= "$fulldomain/gambar/produk/$produkpostid/$gambar_m";
	else
		$image_m	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
	
	if($fulldomainreseller=='')
	{
		$urlmenu = "$fulldomain/product/read/$produkpostid/$alias";
	}
	else
	{
		$urlmenu	= "http://$fulldomainreseller/product/read/$produkpostid/$alias";
	}

	$productpil[$produkpostid] = array("id"=>$produkpostid,"h"=>$h,"nama"=>$namaprod,"urlmenu"=>$urlmenu,"price"=>$misc_harga,"misc_diskon"=>$misc_diskonnya,"savenya"=>$savenya,"save"=>$sDiskon,"misc_matauang"=>$misc_matauang,"diskon"=>$misc_diskon,"misc_diskonn"=>$sDiskon,"gambar"=>$image_m);
	$h %= 2;
	$h++;
}
sql_free_result($hasil);
$tpl->assign("productpil",$productpil);

$mysql = "select produkpostid,ringkas,title,create_date,alias from tbl_product_post where published='1' order by produkpostid desc";
$hasil = sql($mysql);

$dataprodukpilihan = array();
$a =1;
while ($data = sql_fetch_data($hasil)) {	
		$tanggal = $data['create_date'];
		$nama    = $data['title'];
		$ids     = $data['produkpostid'];
		$ringkas = $data['ringkas'];
		$alias   = $data['alias'];
		$tanggal = tanggal($tanggal);
		$secid   = $data['secid'];
		
		
		// Gambar
		$sql3		= "select albumid,nama,gambar_m,gambar_s,gambar_l,gambar_f from tbl_product_image where produkpostid='$produkpostid' order by albumid asc";
		$query3		= sql($sql3);
		$list_image2	= array();
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
				$image_m	= "$fulldomain/gambar/produk/$produkpostid/$gambar_m";
			else
				$image_m	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
			if(!empty($gambar_s))
				$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
			else
				$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
			
			if(!empty($gambar_l))
				$image_l	= "$fulldomain/gambar/produk/$produkpostid/$gambar_f";
			else
				$image_l	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
			if(!empty($gambar_f))
				$image_f	= "$fulldomain/gambar/produk/$produkpostid/$gambar_f";
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
			
			$list_image2[$albumid]	= array("index"=>$ii,"albumid"=>$albumid,"nama_image"=>$nama_image,"image_m"=>$image_m,"image_s"=>$image_s,"image_l"=>$image_l,"image_f"=>$image_f);
			$albumarr[$ii] 			= $albumid;
			$ii++;
		}
		sql_free_result($query3);
		$tpl->assign("list_image_pilihan",$list_image2);

		$link = "$fulldomain/produk/read/$ids/$alias";
			
		$dataprodukpilihan[$ids] = array("id"=>$id,"no"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"namasec"=>$namasec,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$image_m);
		$a++;	
}
$a = 0;
sql_free_result($hasil);
$tpl->assign("dataprodukpilihan",$dataprodukpilihan);

	//Data Kategori
	$qsec     = "select secid,namasec,alias from tbl_product_sec order by secid desc";
	$hsec     = sql($qsec);
	while ($dts = sql_fetch_data($hsec))
	{
		$secid    = $dts['secid'];
		$namasec  = $dts['namasec'];
		$aliassec = $dts['alias'];

		$linksecnya = "$fulldomain/$kanal/list/$aliassec.html";

		$secnya[$secid] = array("secid"=>$secid,"namasec"=>$namasec,"linksecnya"=>$linksecnya);
		$i++;
	}
	$tpl->assign("secnya",$secnya);

	//Data Produk
	$qprod     = "select produkpostid,title,alias from tbl_product_post order by produkpostid desc";
	$hprod     = sql($qprod);
	while ($dtp = sql_fetch_data($hprod))
	{
		$idprod    = $dtp['produkpostid'];
		$namaprod  = $dtp['title'];
		$aliasprod = $dtp['alias'];

		$linkprodnya = "$fulldomain/produk/read/$idprod/$alias";

		$prodnya[$idprod] = array("idprod"=>$idprod,"namaprod"=>$namaprod,"linkprodnya"=>$linkprodnya);
		$i++;
	}
	$tpl->assign("prodnya",$prodnya);

	//Data Brand
	$qbrand     = "select brandid,nama,alias from tbl_product_brand order by brandid desc";
	$hbrand     = sql($qbrand);
	while ($dtb = sql_fetch_data($hbrand))
	{
		$brandid    = $dtb['brandid'];
		$namabrand  = $dtb['nama'];
		$aliasbrand = $dtb['alias'];

		$linkbrandnya = "$fulldomain/$kanal/list-brand/$aliasbrand";

		$brandnya[$brandid] = array("brandid"=>$brandid,"namabrand"=>$namabrand,"linkbrandnya"=>$linkbrandnya);
		$i++;
	}
	$tpl->assign("brandnya",$brandnya);


?>