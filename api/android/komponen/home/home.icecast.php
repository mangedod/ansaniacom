<?php
$action = $_POST['action'];
$mount = $_POST['mount'];
$mount = str_replace("/","",$mount);

if($action=="mount_add")
{
	$cek = sql_get_var("select count(*) as jml from tbl_live where username='$mount'");

	if($cek<1)
	{
		$date = date("Y-m-d H:i:s");
		$dt = sql("insert into tbl_live(username,listener) values('$mount','0')");
	
	}
}

if($action=="mount_remove")
{
	$dt = sql("delete from tbl_live where username='$mount'");
}

if($action=="listener_add")
{
	$cek = sql_get_var("select count(*) as jml from tbl_live where username='$mount'");

	if($cek<1)
	{
		$date = date("Y-m-d H:i:s");
		$dt = sql("insert into tbl_live(username,listener) values('$mount','0')");
	
	}
	//Update
	sql("update tbl_live set listener=listener+1 where username='$mount'");
}
if($action=="listener_remove")
{
	sql("update tbl_live set listener=listener-1 where username='$mount'");
}

header('icecast-auth-user: 1');

$ip = $_SERVER['REMOTE_ADDR'];
$input = $HTTP_RAW_POST_DATA;
$uri = $_SERVER['REQUEST_URI'];
$data = date('Y-m-d H:i:s')." | $ip | $action | $uri\r\n";
$file = "$lokasiweb/logs/icast.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);

echo "Access from $ip";

?>