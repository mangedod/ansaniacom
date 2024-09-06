<?php
$userid = $var[3];
$propinsiid = $var[5];
$kotaids = $var[6];

$perintah 	= "select kotaid,namakota,tipe from tbl_kota where propid='$propinsiid' order by namakota asc";
$hasil 		= sql($perintah);
		
$datakota 	= array();
while($data = sql_fetch_data($hasil))
{	
		
	$kotaid		= $data['kotaid'];
	
	$nama 		= $data['namakota'];
	$tipe 		= $data['tipe'];
	
	if($tipe=="Kota") $nama = "$nama (Kota)";
	
	if($kotaid==$kotaids) $selected = "1";
	else $selected = "0";
	
	$datakota[]	= array("kotaid"=>$kotaid,"nama"=>$nama,"selected"=>$selected);
}
sql_free_result($hasil);


$result['status'] = "OK"; 
$result['message'] = "Sukses meload data propinsi";
$result['datalist'] = $datakota;

echo json_encode($result);
exit();
?>