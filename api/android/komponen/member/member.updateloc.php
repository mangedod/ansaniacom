<?php
$userid 		= $_POST['userid'];
$latitude 		= $_POST['latitude'];
$longitude 		= $_POST['longitude'];

if($userid!='' || $latitude!='' )
{
	//Cek
	$isdevice = sql_get_var("select count(*) as jml from tbl_location where userid='$userid'");
	
	if($isdevice==0)
	{
		$views = "insert into tbl_location(latitude,longitude,userid) values('$latitude','$longitude','$userid')";
		$hsl = sql($views);
	}
	else
	{
		$views = "update tbl_location set latitude='$latitude',longitude='$longitude' where userid='$userid'";
		$hsl = sql($views);
	}
	
	if($hsl)
	{
		$perintah	= "select userid, ( 3959 * acos( cos( radians('$latitude') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( latitude ) ) ) ) AS distance from tbl_location where userid!='' and userid!='$userid' HAVING distance < '60' order by distance ";
		$query		= sql($perintah);
		
		$jum = sql_num_rows($query);
		
		if($jum<1) $jum = 0;
		
		$result['status'] = "OK";
		$result['jmluser'] = $jum ; 
		$result['message'] = "Update posisi berhasil $isdevice. $views";
		echo json_encode($result);
		exit();

		
	}
	else
	{
		$result['status'] = "ERROR"; 
		$result['message'] = "Gagal update lokasi";
		echo json_encode($result);
		exit();


	}
}
else
{
	$result['status'] = "ERROR"; 
	$result['message'] = "UserID kosong atau lokasi kosong";	

	echo json_encode($result);
	exit();
}


?>	
