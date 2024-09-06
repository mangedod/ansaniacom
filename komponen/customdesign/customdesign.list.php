<?php 
//detail info
$detailinfo = sql_get_var("select lengkap from tbl_static where alias='customdesigninfo'");
$tpl->assign("detailinfo",$detailinfo);

//detail ukuran
$detailukuran = sql_get_var("select lengkap from tbl_static where alias='customdesignukuran'");
$tpl->assign("detailukuran",$detailukuran);

//jenis bahan
$perintah = "select id,nama,ringkas,gambar from tbl_customdesignjenis where published='1'";
$hasil = sql($perintah);
while($data=sql_fetch_data($hasil))
{
	$id = $data['id'];
	$nama = $data['nama'];
	$ringkas = $data['ringkas'];
	$gambar = $data['gambar'];
	if($gambar)
		$image=$gambar;
	else
		$image="$fulldomain/images/img.none.jpg";
	
	$datajenis[$id]=array("id"=>$id,"nama"=>$nama,"ringkas"=>$ringkas,"gambar"=>$image);
}
sql_free_result($hasil);
$tpl->assign("datajenis",$datajenis);
?>