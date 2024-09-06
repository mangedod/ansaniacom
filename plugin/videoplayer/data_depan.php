<?
$perintah = "select id,screenshot1,video from tbl_video where published='1' and jenis='0' order by rand() limit 1";
$hasil = mysql_db_query($database,$perintah);
while($data=mysql_fetch_object($hasil))
{
	$id =$data->id;
	$kode = strtotime("now").".flv";
	$kode = base64_encode($kode);
	$idkode = base64_encode($id);
	$tpl->assign("kode",$kode);
	$tpl->assign("idkode",$idkode);
}
mysql_free_result($hasil);

$datavideo = array();
$perintah = "select id,screenshot,nama,urutan from tbl_video where published='1' order by tanggal limit 2";
$hasil = mysql_db_query($database,$perintah);
while($data=mysql_fetch_object($hasil))
{
	$id =$data->id;
	$nama = $data->nama;
	$alias = getAlias($nama);
	$screenshot = $data->screenshot;
	$urutan = $data->urutan;
	
	$datavideo[$id] = array("id"=>$id,"link"=>"$fulldomain/video/play/$urutan/$id/$alias","screenshot"=>"$domain/gambar/$screenshot");
}
$tpl->assign("datavideo",$datavideo);
mysql_free_result($hasil);
?>
