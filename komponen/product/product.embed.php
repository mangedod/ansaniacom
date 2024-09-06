<?php 
$limit = $var[4];
$limit = $limit*1;

if($limit>10) $limit = 10;
if($limit<1) $limit = 1;

$sqlp	= "select produkid,kodeproduk,title,misc_harga,misc_diskon,tag from tbl_product where published='1' limit $limit ";
$queryp	= sql($sqlp);
$nump	= sql_num_rows($queryp);

$list_post	= array();
$no	= 1;
while($row2 = sql_fetch_data($queryp))
{
	$produkid      = $row2['produkid'];
	$kodeproduk    = $row2['kodeproduk'];
	$produkpostid  = sql_get_var("select produkpostid from tbl_product_post where kodeproduk='$kodeproduk' order by utama desc");
	$secId         = $row2['secid'];
	$subId         = $row2['subid'];
	$aliasSecc     = getAliasSec($secId);
	$aliasSubb     = getAliasSub($subId);
	$namaprod      = ucwords($row2["title"]);
	$alias         = getAlias($namaprod);
	$ringkas       = bersih($row2["ringkas"]);
	$misc_matauang = $row2['misc_matauang'];
	$pilihan       = $row2['pilihan'];
	$misc_diskon   = $row2['misc_diskon'];
	$misc_harga    = $row2['misc_harga'];
	$tag           = $row2['tag'];

		$totalrating = 0;
		$jmlrating   = sql_get_var("select SUM(score) as jmlscore from tbl_product_comment where userid='$_SESSION[userid]' and produkid='$produkid'");
		$jmlorang    = sql_get_var("select count(*) as jml from tbl_product_comment where userid='$_SESSION[userid]' and produkid='$produkid'");
		if($jmlorang>0) $totalrating = $totalrating + $jmlrating/$jmlorang;
		
	$t = explode(",",$tag);
	$tags = array();
	for($c=0;$c<count($t);$c++)
	{
		// $tags[$c] = array("tagid"=>$c,"tag"=>trim($t[$c]),"url"=>"$fulldomain/$kanal/tag/".urlencode(trim($t[$c])));
		$tags[$c] = trim($t[$c]);
		// $tags[$c] = "<a href='$fulldomain/$kanal/tag/'>".trim($t[$c])."</a>";
		// $tags[$c] = trim($t[$c]);
	}
	$hasiltag = implode("/ ",$tags);
	$tpl->assign("tags",$tags);
	$tpl->assign("hasiltagp",$hasiltag);
	
	$sDiskon		= 0;
	$hDiskon		= 0;
	if($misc_diskon!=0)
	{
		$hDiskon		= $misc_diskon;
		$sDiskon		= $misc_harga - $misc_diskon;
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
	
	$link_detail	= "$fulldomain/product/read/$produkpostid/$alias";
	$link_buy		= "$fulldomain"."quickbuy/addpost/$produkpostid/$alias";
	
	//produk wishlist 
	if($_SESSION['userid'])
	{
		$cekwl	= sql_get_var("select count(*) as jml from tbl_wishlist where userid='$_SESSION[userid]' and produkpostid='$produkpostid'");
		
		if($cekwl>0)
			$wishlist = 1;
		else
			$wishlist = 0;
	}
	
	$list_post[$produkid]	= array("produkid"=>$produkid,"produkpostid"=>$produkpostid,"namaprod"=>$namaprod,"totalrating"=>$totalrating,"image_m"=>$image_m,"link_detail"=>$link_detail,"ringkas"=>$ringkas,
								"price"=>$misc_harga,"misc_diskon"=>$misc_diskonnya,"savenya"=>$savenya,"save"=>$sDiskon,"misc_matauang"=>$misc_matauang,"no"=>$no,
								"pilihan"=>$pilihan,"diskon"=>$misc_diskon,"link_buy"=>$link_buy,"link_compare"=>$link_compare,"misc_diskonn"=>$sDiskon,"secid"=>$secId,
								"misc_harga_reseller"=>$misc_harga_reseller,"hargares"=>$misc_hargares2,"wishlist"=>$wishlist,"icon"=>$icons);
	$no++;
}
sql_free_result($queryp);
$tpl->assign("no",$no);
$tpl->assign("nump",$nump);
$tpl->assign("list_post",$list_post);
$tpl->assign("kata",$kata);

//Paging 

$batas_page = 5;
$stringpage = array();
$pageid 	= 0;

if ($hlm > 1){
$prev = $hlm - 1;
$pageid++;
$stringpage[$pageid] = array("nama"=>"<","link"=>"$fulldomain/$kanal/$aksipage"."$prev");

}
else {
	$pageid++;
}

$hlm2 = $hlm - (ceil($batas_page/2));
$hlm4 = $hlm+(ceil($batas_page/2));

if($hlm2 <= 0 ) $hlm3=1;
   else $hlm3 = $hlm2;
$pageid++;

for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
	if ($ii==$hlm){
		$stringpage[$pageid] = array("nama"=>"$ii","link"=>"","class"=>"active");
	}else{
		$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/$aksipage"."$ii","class"=>""); 
	}
	$pageid++;
}

if ($hlm < $hlm_tot){
	$next = $hlm + 1;
	$stringpage[$pageid] = array("nama"=>">","link"=>"$fulldomain/$kanal/$aksipage"."$next"); //,"class"=>"next"
	$pageid++;
}
else
{
	$pageid++;
}

$tpl->assign("stringpage",$stringpage);
//Selesai Paging
		
?>
