<?php 
$jarak = 60;
$latitude = $_GET['latitude'];
$longitude = $_GET['longitude'];

if(!empty($latitude))
{

	$perintah	= "select userid,latitude,longitude, ( 3959 * acos( cos( radians('$latitude') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( latitude ) ) ) ) AS distance from tbl_location where userid!='' HAVING distance < '60' order by distance asc limit 4";
	$query		= sql($perintah);
	$a = 0;
	while($row = sql_fetch_data($query))
	{
		$userid = $row['userid'];
		$distance = $row['distance'];
		$alias = $row['alias'];
		$latitude = $row['latitude'];
		$longitude = $row['longitude'];
		
		$user = sql_get_var_row("select userfullname,userphonegsm from tbl_member where userid='$userid'");
		
		$userfullname = $user['userfullname'];
		$userphonegsm = $user['userphonegsm'];
		
		$distance = number_format($distance,2,",",".");
		
		$users[] = array("userid"=>$userid,"distance"=>$distance,"latitude"=>$latitude,"longitude"=>$longitude,"userphonegsm"=>$userphonegsm,"userfullname"=>$userfullname);
		$a++;
	}
	$result['status']="OK";
	$result['message']="Data berhasil di load";
	$result['users'] = $users;
	$result['jmluser'] = $a;
	echo json_encode($result);
}
else
{
	$result['status']="ERROR";
	$result['message']="Request tidak valid";
	echo json_encode($result);
}
?>
