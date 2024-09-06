<?php 
$userid		= $var[4];
$hlm 			= $var[5];
$aksi 			= $var[4];

if($hlm=="username")
{
	$userid = sql_get_var("select userid from tbl_member where username='$userid'");
}

if(file_exists($lokasiweb."/api/komponen/$kanal/$kanal.$aksi.php")) include("$kanal.$aksi.php");
else{ $aksi = "profile";  include("$kanal.profile.php"); }

?>
