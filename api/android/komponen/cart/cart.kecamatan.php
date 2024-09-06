<?php
$userid = $var[3];
$propinsiid = $var[5];
$kotaids = $var[6];
$kecids = $var[7];

$perintah 	= "select kecid,namakecamatan from tbl_kecamatan where propid='$propinsiid' and kotaid='$kotaids' order by namakecamatan asc";
$hasil 		= sql($perintah);
		
$datakota 	= array();
while($data = sql_fetch_data($hasil))
{	
		
	$kecid		= $data['kecid'];
	
	$nama 		= $data['namakecamatan'];
	$tipe 		= $data['tipe'];
	

	if($kecid==$kecids) $selected = "1";
	else $selected = "0";
	
	$datakota[]	= array("kecid"=>$kecid,"nama"=>$nama,"selected"=>$selected);
}
sql_free_result($hasil);


$result['status'] = "OK"; 
$result['message'] = "Sukses meload data propinsi";
$result['datalist'] = $datakota;

echo json_encode($result);
exit();
?>