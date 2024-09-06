<?php  
$space="A";
$limitbanner = 3;
$perintah ="SELECT id,gambar,jenis FROM tbl_banner where space='$space' and published='1' limit $limitbanner";
$hasil = sql($perintah);

while ($row =sql_fetch_data($hasil))
{
	$jenis = $row['jenis'];
	$gambar=$row['gambar'];
	$adsid =$row['id'];
	$akhir = $row['tglakhir'];
	$akhir = explode("-",$akhir);

	$ukuran = $row['ukuran'];
	$ukuran = explode("x",$ukuran);
	$width = $ukuran[0];
	$height = $ukuran[1];
	$target = base64_encode($adsid);

	$bannerlist[$adsid] = array("adsid"=>$adsid,"databanner"=>$databanner,"no"=>$no,"url"=>"$fulldomain/banner/lihat/$target","gambar"=>"$fulldomain/gambar/banner/$gambar");
	$no++;
}	
sql_free_result($hasil);
$tpl->assign("bannerlist",$bannerlist);
?>