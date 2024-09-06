<?php 
$where = "";
$judul_per_hlm = 12;

if($_POST['sorting'])
{
	$sorting 	= $_POST[sorting];
	$_SESSION['sorting'] = $sorting;
}
elseif($_SESSION['sorting']) $sorting = $_SESSION['sorting'];
else $sorting = "produkid";


$batas_paging 	= 5;

if($aksi == "list")
{
	
	$hlm 			= $var[5];
	$aliassec		= $var[3];
	$aliassub		= $var[4];
	$aliaschild		= $var[5];
	
	$secid			= getSecId($aliassec);
	$subid			= getSubId($aliassub,$secid);


	if($hlm=="?callback=$getdomain") $hlm = "";
	
	if(isset($_GET['secid']) && $_GET['secid']!="all") $secid = cleaninsert($_GET['secid']);
	if(isset($_GET['subid']) && $_GET['subid']!="all") $subid = cleaninsert($_GET['subid']);
	if(isset($_GET['chilid']) && $_GET['chilid']!="all") $chilid = cleaninsert($_GET['chilid']);
	
	if(!empty($secid))
	{
		$hlm 			= $var[6];
		$where			.= "and secid='$secid'";
		$aksipage		= "$aksi/$aliassec/$aliassub/";
		$tpl->assign("xsecid",$secid);
	}

	if($var[3]=="jenis")
	{
		$jenisid = sql_get_var("select jenisid from tbl_product_jenis where alias='$var[4]'");
		if($jenisid>0) $where .= " and jenisid='$jenisid' ";
		$jenis1= "jenis";
		$aksipage = "jenis";
		$key = $var[4];
		$hlm = $var[5];
	}

	if($var[3]=="kat")
	{
		$secid1 = sql_get_var("select secid from tbl_product_sec where alias='$var[4]'");
		if($secid1>0) $where .= " and secid='$secid1' ";
		$jenis1= "kat";
		$aksipage = "kat";
		$key = $var[4];
		$hlm = $var[5];
	}

	
	if(!empty($_GET['keyword']))
	{
		$kata = $_GET['keyword'];
		
		$wherearray = array();
		if($kata != "")
		{
			$tempk	= explode(" ",$kata);
			for($i=0;$i<count($tempk);$i++)
			{
				$wherearray[] = "title$lang like '%$tempk[$i]%'";
			}
			
			$impwhere = implode("or ",$wherearray);
			$where	.= " and ($impwhere)";
		}

	}
	
	if(!empty($_GET['fjenisid']))
	{
		$jenis = $_GET['fjenisid'];
		
		$wherearray = array();
		if($jenis!= "")
		{
			$tempk	= explode(",",$jenis);
			for($i=0;$i<count($tempk);$i++)
			{
				if(!empty($tempk[$i])) $wherearray[] = " jenisid='$tempk[$i]' ";
			}
			
			$impwhere = implode("or ",$wherearray);
			$where	.= " and ($impwhere)";

		}

	}

	if(!empty($_GET['fsecid']))
	{
		$sec = $_GET['fsecid'];
		
		$wherearray = array();
		if($sec!= "")
		{
			$tempk	= explode(",",$sec);
			for($i=0;$i<count($tempk);$i++)
			{
				if(!empty($tempk[$i])) $wherearray[] = " secid='$tempk[$i]' ";
			}
			
			$impwhere = implode("or ",$wherearray);
			$where	.= " and ($impwhere)";

		}

	}
	
	if(!empty($_GET['fwarnaid']))
	{
		$warna = $_GET['fwarnaid'];
		
		$wherearray = array();
		if($warna!= "")
		{
			$tempk	= explode(",",$warna);
			for($i=0;$i<count($tempk);$i++)
			{
				if(!empty($tempk[$i])) $wherearray[] = " warna like '%~$tempk[$i]~%' ";
			}
			
			$impwhere = implode("or ",$wherearray);
			$where	.= " and ($impwhere)";
		}

	}
	
	if(!empty($_GET['filterhargaid']))
	{
		$harga = $_GET['filterhargaid'];
		if($harga==1){	$where	.= " and misc_harga < 10000"; }
		else if($harga==2){	$where	.= " and ( misc_harga > 10000 and misc_harga <= 25000)"; }
		else if($harga==3){	$where	.= " and ( misc_harga > 25000 and misc_harga <= 50000)"; }
		else if($harga==4){	$where	.= " and ( misc_harga > 50000 and misc_harga <= 100000)"; }
		else if($harga==5){	$where	.= " and misc_harga > 100000 "; }
		$tpl->assign("hargaid",$harga);
	}
	else $tpl->assign("hargaid",0);
	
	
	if(!empty($subId))
	{
		$nama_sub = getNamaSub($subId,$lang);
		$tpl->assign("namasub",$nama_sub);
	}
	if(!empty($secid))
	{
		$nama_cat = getNamaSec($secid,$lang);
		$tpl->assign("link_sec","$fulldomain/$kanal/$aksi/$aliassec.html");
		$tpl->assign("namasec",$nama_cat);
	}
	if(!empty($tipeid))
	{
		$nama_cat = getNamaSec($tipeid,$lang);
		$tpl->assign("link_tipe","$fulldomain/$kanal/$aksi/$aliastipe.html");
		$tpl->assign("namatipe",$nama_cat);
	}
	
	
}
elseif($aksi=="terlaris")
{
	$hlm 			= $var[5];
	$where 			= "and topseller='1'";
	$aksipage		= "$aksi/";
}
elseif($aksi=="list-brand")
{
	$hlm 			= $var[5];
	$aliasbrand		= $var[4];
	$brandid		= sql_get_var("select brandid from tbl_product_brand where alias='$aliasbrand'");
	$where 			= "and brandid='$brandid'";
	$aksipage		= "$aksi/$aliasbrand/";
}
else
{
	$hlm 			= $var[5];
	$where			= "";
	$aksipage		= "all/";
}

$tpl->assign("subidxxx",$subId);
$tpl->assign("secidxxx",$secid);

echo $hlm;

if(!empty($subId)) $whereref = "secid='$secid' and subid='$subId'";
else $whereref = "secid='$secid'";

$sqlb	= "select brandid, nama from tbl_product_brand where published='1'";
$resb	= sql($sqlb);
$brandd	= array();
while($rowb = sql_fetch_data($resb))
{
	$brandid	= $rowb['brandid'];
	$namabrand	= $rowb['nama'];
	
	$brandd[$brandid] = array("brandid"=>$brandid,"namabrand"=>$namabrand);
}
sql_free_result($resb);
$tpl->assign("brandd",$brandd);

$sql = "select count(*) as jml from tbl_product_post where published='1' $where";
$hsl = sql($sql);
$tot = sql_result($hsl, 0,'jml');
$hlm_tot = ceil($tot / $judul_per_hlm);		
if (empty($hlm)){
	$hlm = 1;
	}
if ($hlm > $hlm_tot){
	$hlm = $hlm_tot;
	}

$ord = ($hlm - 1) * $judul_per_hlm;
if ($ord < 0 ) $ord=0;
$tpl->assign("tot",$tot);
$tpl->assign("hlm_tot",$hlm_tot);
$tpl->assign("hlm",$hlm);
$tpl->assign("judul_per_hlm",$judul_per_hlm);
$tpl->assign("ord",$ord+1);
	
$sqlp	= "select produkpostid,kodeproduk,title,misc_harga,misc_diskon,tag from tbl_product_post where published='1' $where order by $sorting desc limit $ord, $judul_per_hlm";
$queryp	= sql($sqlp);
$nump	= sql_num_rows($queryp);

$list_post	= array();
$no	= 1;
while($row2 = sql_fetch_data($queryp))
{
	$produkid      = $row2['produkpostid'];
	$produkpostid = $row2['produkpostid'];
	$kodeproduk    = $row2['kodeproduk'];
	$secid         = $row2['secid'];
	$subId         = $row2['subid'];
	$aliasSecc     = getAliasSec($secid);
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
		$jmlrating   = sql_get_var("select SUM(score) as jmlscore from tbl_product_comment where userid='$_SESSION[userid]' and produkpostid='$produkpostid'");
		$jmlorang    = sql_get_var("select count(*) as jml from tbl_product_comment where userid='$_SESSION[userid]' and produkpostid='$produkpostid'");
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
	
		$sql3	= "select albumid,gambar_m,gambar_l from tbl_product_image where produkpostid='$produkpostid' and utama='1' order by albumid asc limit 1";
		$query3	= sql($sql3);
		$row3	= sql_fetch_data($query3);
		$albumid	= $row3['albumid'];
		$gambar_m	= $row3['gambar_m'];
		$gambar_l	= $row3['gambar_l'];
		sql_free_result($query3);
		
		if(!empty($gambar_m))
			$image_m	= "$fulldomain/gambar/produk/$produkpostid/$gambar_m";
		else
			$image_m	= $lokasiwebtemplate."/images/noimage.jpg";
			
		if(!empty($gambar_l))
			$image_l	= "$fulldomain/gambar/produk/$produkpostid/$gambar_l";
		else
			$image_l	= $lokasiwebtemplate."/images/noimage.jpg";
	
		
		$sql3	= "select albumid,gambar_m,gambar_l from tbl_product_image where produkpostid='$produkpostid' and gambar_l!='' and utama='1' order by albumid asc  limit 1,1";
		$query3	= sql($sql3);
		$row3	= sql_fetch_data($query3);
		$albumid	= $row3['albumid'];
		$gambar_m	= $row3['gambar_m'];
		$gambar_l	= $row3['gambar_l'];
		sql_free_result($query3);
		
		if(!empty($gambar_m))
			$image_m1	= "$fulldomain/gambar/produk/$produkpostid/$gambar_m";
		else
			$image_m1	= $lokasiwebtemplate."/images/noimage.jpg";
			
		if(!empty($gambar_l))
			$image_l1	= "$fulldomain/gambar/produk/$produkpostid/$gambar_l";
		else
			$image_l1	= $image_l;
			
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
	


	$list_post[]	= array("produkid"=>$produkpostid,"produkpostid"=>$produkpostid,"namaprod"=>$namaprod,"totalrating"=>$totalrating,"image_m"=>$image_m,"image_m1"=>$image_m1,"link_detail"=>$link_detail,"ringkas"=>$ringkas,
								"price"=>$misc_harga,"misc_diskon"=>$misc_diskonnya,"savenya"=>$savenya,"save"=>$sDiskon,"misc_matauang"=>$misc_matauang,"no"=>$no,
								"pilihan"=>$pilihan,"diskon"=>$misc_diskon,"link_buy"=>$link_buy,"link_compare"=>$link_compare,"misc_diskonn"=>$sDiskon,"secid"=>$secid,
								"misc_harga_reseller"=>$misc_harga_reseller,"hargares"=>$misc_hargares2,"wishlist"=>$wishlist,"icon"=>$icons);
	$no++;
}
sql_free_result($queryp);
$tpl->assign("no",$no);
$tpl->assign("nump",$nump);
$tpl->assign("list_post",$list_post);
$tpl->assign("kata",$kata);

//Paging 
if(empty($aksipage)) $aksipage = "list";

$batas_page = 5;
$stringpage = array();
$pageid 	= 0;

if ($hlm > 1){
$prev = $hlm - 1;
$pageid++;
$stringpage[$pageid] = array("nama"=>"<","link"=>"$fulldomain/$kanal/$aksipage/$key/"."$prev");

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
		$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/$aksipage/$key/"."$ii","class"=>""); 
	}
	$pageid++;
}

if ($hlm < $hlm_tot){
	$next = $hlm + 1;
	$stringpage[$pageid] = array("nama"=>">","link"=>"$fulldomain/$kanal/$aksipage/$key/"."$next"); //,"class"=>"next"
	$pageid++;
}
else
{
	$pageid++;
}

$tpl->assign("stringpage",$stringpage);
//Selesai Paging



//
$fjenisids = cleaninsert($_GET['fjenisid']);
$fjenisid = explode(",",$fjenisids);

$datajenis = array();
$pkategori = "select jenisid,nama from tbl_product_jenis order by jenisid asc";
$hkategori = sql($pkategori);
while($dkategori= sql_fetch_data($hkategori))
{
	
	$jenisids = $dkategori['jenisid'];
	
	if (in_array("$jenisids", $fjenisid)) {
		$selected = 1;
	}
	else
	{
		$selected = 0;
	}
	$datajenis[] = array("jenisid"=>$dkategori['jenisid'],"nama"=>$dkategori['nama'],"selected"=>$selected);
}
sql_free_result($hkategori);
$tpl->assign("datajenis",$datajenis);

//
$fsecids = cleaninsert($_GET['fsecid']);
$fsecid = explode(",",$fsecids);

$datasec = array(); 
$pkategori = "select secid,namasec from tbl_product_sec order by secid asc";
$hkategori = sql($pkategori);
while($dkategori= sql_fetch_data($hkategori))
{
	
	$secids = $dkategori['secid'];
	
	if (in_array("$secids", $fsecid)) {
		$selected = 1;
	}
	else
	{
		$selected = 0;
	}
	$datasec[] = array("secid"=>$dkategori['secid'],"nama"=>$dkategori['namasec'],"selected"=>$selected);
}
sql_free_result($hkategori);
$tpl->assign("datasec",$datasec);

$fwarnaids = cleaninsert($_GET['fwarnaid']);
$fwarna = explode(",",$fwarnaids);

$datawarna = array(); 
$pkategori = "select id,nama,kode from tbl_warna order by id asc";
$hkategori = sql($pkategori);
while($dkategori= sql_fetch_data($hkategori))
{
	
	$secids = $dkategori['id'];
	
	if (in_array("$secids", $fwarna)) {
		$selected = 1;
	}
	else
	{
		$selected = 0;
	}
	$datawarna[] = array("warnaid"=>$dkategori['id'],"nama"=>$dkategori['nama'],"kode"=>$dkategori['kode'],"selected"=>$selected);
}
sql_free_result($hkategori);
$tpl->assign("warna",$datawarna);
		


?>
