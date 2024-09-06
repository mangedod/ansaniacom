<?php 
ini_set('display_errors',"on");
error_reporting(E_ALL & ~E_NOTICE);

ob_start( 'ob_gzhandler' );
session_start();
include("setingan/cms.config.inc.php");
include("template/template.php");

if(isset($_POST['kanal'])) $kanal = $_POST['kanal'];
 else $kanal = $_GET['kanal'];

if(isset($_POST['aksi'])) $aksi = $_POST['aksi'];
 else $aksi = $_GET['aksi'];
 
if(isset($_POST['tab'])) $tab = $_POST['tab'];
 else $tab = $_GET['tab'];
 
if(isset($_POST['hlm'])) $hlm = $_POST['hlm'];
 else $hlm = $_GET['hlm'];

if(isset($_POST['pop'])) $pop = $_POST['pop'];
 else $pop = $_GET['pop'];

if(isset($_POST['fav'])) $fav = $_POST['fav'];
 else $fav = $_GET['fav'];
 
if(empty($aksi)) $aksi = "view";

 
if(isset($_POST['tabsub'])) $tabsub = $_POST['tabsub'];
 else $tabsub = $_GET['tabsub'];

if(empty($tab)) $tab=1;

$topurl = $_SERVER['REQUEST_URI'];
$topurl = explode("index.php",$topurl);
$jtopurl = count($topurl);
$topurl = "index.php".$topurl[$jtopurl-1];

$date = date("Y-m-d H:i:s");
$cuserid = $_SESSION['cms_userid'];

//Filter permodul
if($_GET['showfilter'])
{
	if($_GET['showfilter']=="show"){ $_SESSION['showfilter']= "show"; }
	else { unset($_SESSION['showfilter']); }
}

if($_SESSION['cms_username'] && $kanal=="login" && $aksi=="logout") 
{ 
	
	$kanal = "login";
	include("komponen/$kanal/cms.$kanal.php");
}
else if(!$_SESSION['cms_username'] && $kanal=="login" && $aksi=="login") 
{ 
	$kanal = "login";
	include("komponen/$kanal/cms.$kanal.php");
}

else
{
	if(empty($kanal)) $kanal = "dashboard";
	
	$alamat = "index.php?tab=$tab&tabsub=$tabsub&kanal=$kanal";
	
	//Untuk Informasi Modul
	if($_GET['cominfo']==1)
	{
		$include = "setingan/cms.cominfo.php"; 
		include("template/info.tpl.php");
		exit();
	}

	if(file_exists("komponen/$kanal/cms.$kanal.php")) $include = "komponen/$kanal/cms.$kanal.php";
		else $include = "komponen/empty/cms.empty.php"; 
}
if($pop) include("template/pop.tpl.php");
else include("template/index.tpl.php");
?>
