<?php 
include("$kanal.registrasi.php");

$mysql = "select id,lengkap,nama,create_date,alias,gambar,gambar1 from tbl_static where alias='inforeseller'  limit 1";
$hasil = sql( $mysql);

$data =  sql_fetch_data($hasil);	
$tanggal = $data['create_date'];
$nama = $data['nama'];
$id = $data['id'];
$lengkap = $data['lengkap'];
$alias = $data['alias'];
$tanggal = tanggal($tanggal);
$gambar = $data['gambar'];
$gambar1 = $data['gambar1'];
$urlradio = $data['urlradio'];

if(!empty($gambar1)) $gambar1 = "$fulldomain/gambar/$kanal/$gambar1";
 else $gambar1 = "";
 
sql_free_result($hasil);
$tpl->assign("detailid",$id);
$tpl->assign("detailnama",$nama);
$tpl->assign("detailringkas",$ringkas);
$tpl->assign("detaillengkap",$lengkap);
$tpl->assign("detailgambar",$gambar1);
$tpl->assign("detailtanggal",$tanggal);

//Jenis Reseller
$sql = "select resellerjenisid,nama from tbl_reseller_jenis";
$hsl = sql($sql);

while($dt = sql_fetch_data($hsl))
{
	$resellerjenisid = $dt['resellerjenisid'];
	$namareseller = $dt['nama'];
	$datajenis[] = array("resellerjenisid"=>$resellerjenisid,"nama"=>$namareseller);
}
sql_free_result($hsl);
$tpl->assign("datajenis",$datajenis);

$tpl->display("$kanal.html");
?>