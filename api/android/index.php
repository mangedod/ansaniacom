<?php
ini_set("display_errors","Off");
header('Content-Type: application/json');
header('Access-Control-Allow-Origin:*');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/*$uri = $_SERVER['REQUEST_URI'];
$post = serialize($_POST);
$data = date('Y-m-d H:i:s')." | $ip | $uri \ $post\r\n";
$file = "backlog.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);
*/
	
include("setingan/web.config.inc.php");
require_once('plugin/phpmailer/class.phpmailer.php');
$path = str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']);

$fulldomain = "http://localhost:8080/ansaniacom/";
$basedomain = "http://localhost:8080/ansaniacom/";
$var	= getVar($_SERVER['REQUEST_URI']);

$rubrik		= $var[1]; 
$kanal		= $var[2];
$aksi 		= $var[3]; 
$katid	 	= $var[4]; 
$id		 	= $var[5];
$subaksi3 	= $var[6];
$subaksi4 	= $var[7]; 
$subaksi5 	= $var[8];

if(file_exists($var[0]))
{
	include($var[0]);
}
?> 