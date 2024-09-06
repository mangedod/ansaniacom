<?php
$userid = $var[3];
$propinsiid = $var[5];

$perintah 	= "select propid,namapropinsi from tbl_propinsi order by namapropinsi asc";
$hasil 		= sql($perintah);
		
$datakota 	= array();
while($data = sql_fetch_data($hasil))
{	
		
	$propid		= $data['propid'];
	
	$nama 		= $data['namapropinsi'];
	$tipe 		= $data['tipe'];
	
	if($tipe=="Kota") $kota = "$kota (Kota)";
	
	if($propid==$propinsiid) $selected = "1";
	else $selected = "0";
	
	$datakota[]	= array("propid"=>$propid,"nama"=>$nama,"selected"=>$selected);
}
sql_free_result($hasil);


$result['status'] = "OK"; 
$result['message'] = "Sukses meload data propinsi";
$result['datalist'] = $datakota;

echo json_encode($result);
exit();
?>