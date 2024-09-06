<?php 
$id = $var[4];
$secid = sql_get_var("select secid from tbl_blog where id='$id'");

$query= "delete from tbl_blog where id='$id' and userid='$_SESSION[useridresel]'";
$hasil = sql($query);

if($hasil)
{
	header("location: $fulldomain/member/blog");					   
}
else
{
	$pesanhasil = "Perubahan blog gagal dilakukan ada beberapa kesalahan yang mesti diperbaiki, silahkan periksa kembali kesalahan dibawah ini";
	$berhasil = "0";
}
$tpl->assign("pesan",$pesan);
$tpl->assign("pesanhasil",$pesanhasil);
$tpl->assign("berhasil",$berhasil);
?>