<?php 
$mysql = "select kodeproduk,produkpostid,secid,subid,brandid,title,ringkas,misc_harga,misc_diskon,misc_matauang,pilihan from tbl_product_post where grosir='0' and home='1' order by produkpostid desc limit 4";
$hasil = sql($mysql);

$dataprodukdepan = array();
$a =1;
while ($data = sql_fetch_data($hasil)) {	
		$kodeproduk    = $data['kodeproduk'];
		$ids           = $data['produkpostid'];
		$secId         = $data['secid'];
		$subId         = $data['subid'];
		$aliasSecc     = getAliasSec($secId);
		$aliasSubb     = getAliasSub($subId);
		$tanggal       = $data['create_date'];
		$nama          = $data['title'];
		$ringkas       = $data['ringkas'];
		$misc_matauang = $data['misc_matauang'];
		$pilihan       = $data['pilihan'];
		$alias         = getalias($nama);
		$tanggal       = tanggal($tanggal);
		$misc_diskon   = $data['misc_diskon'];
		$misc_harga    = $data['misc_harga'];
		$harga         = rupiah($harga);

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
		
		$sql3	= "select albumid,gambar_m,gambar_l from tbl_product_image where produkpostid='$ids' and gambar_l!='' order by albumid asc limit 1";
		$query3	= sql($sql3);
		$row3	= sql_fetch_data($query3);
		$albumid	= $row3['albumid'];
		$gambar_m	= $row3['gambar_m'];
		$gambar_l	= $row3['gambar_l'];
		sql_free_result($query3);
		
		if(!empty($gambar_m))
			$image_m	= "$fulldomain/gambar/produk/$ids/$gambar_m";
		else
			$image_m	= $fulldomain.$lokasiwebtemplate."images/noimage.jpg";
			
		if(!empty($gambar_l))
			$image_l	= "$fulldomain/gambar/produk/$ids/$gambar_l";
		else
			$image_l	= $fulldomain.$lokasiwebtemplate."images/noimage.jpg";
		
		
		
		$sql3	= "select albumid,gambar_m,gambar_l from tbl_product_image where produkpostid='$ids' and gambar_l!='' order by albumid asc limit 1,1";
		$query3	= sql($sql3);
		$row3	= sql_fetch_data($query3);
		$albumid	= $row3['albumid'];
		$gambar_m	= $row3['gambar_m'];
		$gambar_l	= $row3['gambar_l'];
		sql_free_result($query3);
		
		if(!empty($gambar_m))
			$image_m1	= "$fulldomain/gambar/produk/$ids/$gambar_m";
		else
			$image_m1	= $image_m;
			
		if(!empty($gambar_l))
			$image_l1	= "$fulldomain/gambar/produk/$ids/$gambar_l";
		else
			$image_l1	= $image_l;


		$link = "$fulldomain/product/read/$ids/$alias";
		
		$dataprodukdepan[] = array("produkid"=>$ids,"namaprod"=>$nama,"image_m"=>$image_m,"image_m1"=>$image_m1,"link_detail"=>$link,"ringkas"=>$ringkas,
								"price"=>$misc_harga,"misc_diskon"=>$misc_diskonnya,"savenya"=>$savenya,"save"=>$sDiskon,"misc_matauang"=>$misc_matauang,"no"=>$no,
								"pilihan"=>$pilihan,"diskon"=>$misc_diskon,"link_buy"=>$link_buy,"link_compare"=>$link_compare,"misc_diskonn"=>$sDiskon,"secid"=>$secId,
								"misc_harga_reseller"=>$misc_harga_reseller,"hargares"=>$misc_hargares2,"wishlist"=>$wishlist);
		$a++;	
}
$a = 0;
sql_free_result($hasil);
$tpl->assign("dataprodukdepan",$dataprodukdepan);

$mysql2 = "select kodeproduk,produkpostid,secid,subid,brandid,title,ringkas,misc_harga,misc_diskon,misc_matauang,pilihan from tbl_product_post where status='1' and published='1'  order by numviews desc limit 4";
$hasil2 = sql($mysql2);

$dtbestseller = array();
$a =1;
while ($data = sql_fetch_data($hasil2)) {	
		$kodeproduk    = $data['kodeproduk'];
		$prodbestid    = $data['produkpostid'];
		$secId         = $data['secid'];
		$subId         = $data['subid'];
		$aliasSecc     = getAliasSec($secId);
		$aliasSubb     = getAliasSub($subId);
		$tanggal       = $data['create_date'];
		$nama          = $data['title'];
		$ringkas       = $data['ringkas'];
		$misc_matauang = $data['misc_matauang'];
		$pilihan       = $data['pilihan'];
		$alias         = getalias($nama);
		$tanggal       = tanggal($tanggal);
		$misc_diskon   = $data['misc_diskon'];
		$misc_harga    = $data['misc_harga'];
		$harga         = rupiah($harga);
		
		$sDiskon		= 0;
		$hDiskon		= 0;
		if($misc_diskon!=0)
		{
			$hDiskon		= $misc_diskon;
			$sDiskon		= $misc_harga - $misc_diskon;
		}
		
		$misc_harga_reseller = 0;
		
		$misc_harga		= $misc_matauang." ". number_format($misc_harga,0,".",".");
		$misc_diskonnya	= $misc_matauang." ". number_format($hDiskon,0,".",".");
		$savenya		= $misc_matauang." ". number_format($sDiskon,0,".",".");
		
			$sql3	= "select albumid,gambar_m,gambar_l from tbl_product_image where produkpostid='$prodbestid' and gambar_m!='' and gambar_l!='' order by albumid asc limit 1";
			$query3	= sql($sql3);
			$row3	= sql_fetch_data($query3);
			$albumid	= $row3['albumid'];
			$gambar_m	= $row3['gambar_m'];
			$gambar_l	= $row3['gambar_l'];
			sql_free_result($query3);
			
			if(!empty($gambar_m))
				$image_m	= "$fulldomain/gambar/produk/$ids/$ids/$gambar_m";
			else
				$image_m	= $fulldomain.$lokasiwebtemplate."images/noimage.jpg";
				
			if(!empty($gambar_l))
				$image_l	= "$fulldomain/gambar/produk/$ids/$gambar_l";
			else
				$image_l	= $image_m;

			$link = "$fulldomain/product/read/$prodbestid/$alias";
		
		$dtbestseller[] = array("produkid"=>$prodbestid,"namaprod"=>$nama,"image_m"=>$image_m,"link_detail"=>$link,"ringkas"=>$ringkas,
								"price"=>$misc_harga,"misc_diskon"=>$misc_diskonnya,"savenya"=>$savenya,"save"=>$sDiskon,"misc_matauang"=>$misc_matauang,"no"=>$no,
								"pilihan"=>$pilihan,"diskon"=>$misc_diskon,"link_buy"=>$link_buy,"link_compare"=>$link_compare,"misc_diskonn"=>$sDiskon,"secid"=>$secId,
								"misc_harga_reseller"=>$misc_harga_reseller,"hargares"=>$misc_hargares2,"wishlist"=>$wishlist);
		$a++;	
}
$a = 0;
sql_free_result($hasil2);
$tpl->assign("dtbestseller",$dtbestseller);
?>