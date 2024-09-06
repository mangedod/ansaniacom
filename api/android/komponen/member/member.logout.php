<?php
$username = $_POST['username'];
if(!empty($username))
{
	$tanggal = date("Y-m-d H:i:s");
	$query=("update tbl_member set userlastactive='$tanggal' where username='$username'");
	$hasil = sql($query);

	$result['status'] = "OK"; 
	$result['message'] = "User logout";
	echo json_encode($result);
	exit();
	
}
else
{
	$result['status'] = "ERROR"; 
	$result['message'] = "User tidak terdaftar atau tidak login";
	echo json_encode($result);
	exit();
}
?>
