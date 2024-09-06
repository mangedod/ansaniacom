<?php 
if($_SESSION['fbid'])
{
	$result['fbid'] = $_SESSION['fbid'];
	$result['daftaremail'] = $_SESSION['fbemail'];
	$result['daftarname'] = $_SESSION['fbname'];
	$result['daftaravatar'] = $_SESSION['fbavatar'];
	
	echo json_encode($result);
};

if($_SESSION['twid'])
{
	$result['twid'] = $_SESSION['twid'];
	$result['daftaremail'] = $_SESSION['fbemail'];
	$result['daftarname'] = $_SESSION['twname'];
	$result['daftaravatar'] = $_SESSION['twpicture'];
	$result['daftarusername'] = strtolower($_SESSION['twuname']);
	
	echo json_encode($result);
};

if($_SESSION['me'])
{
	$result['gdata'] = $_SESSION['me'];
	
	$result['gpid'] = $gdata['id'];
	$result['daftaremail'] = $gdata['emails'][0]['value'];
	$result['daftarname'] = $gdata['displayName'];
	$result['daftaravatar'] = $gdata['image']['url'];
	$result['daftarusername'] = $gdata['twuname'];
	
	echo json_encode($result);
};

?>