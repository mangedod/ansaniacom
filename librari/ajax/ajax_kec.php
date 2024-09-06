<?php
include("../../setingan/web.config.inc.php");

$kotaid = $_GET[kotaid];
$perintah = "select kecid,namakecamatan from tbl_kecamatan where kotaid='$kotaid' order by namakecamatan asc";
$hasil = sql($perintah);
		
$datakec = "";

while ($data = sql_fetch_data($hasil)){	
		$kecid = $data['kecid'];
		$namakecamatan = $data['namakecamatan'];
		$datakec .= "$kecid~~$namakecamatan|";
}
sql_free_result($hasil);
echo"$datakec";

?>