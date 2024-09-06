<?php
ini_set("display_errors","Off");

ob_start( 'ob_gzhandler' );
session_start();

include("setingan/web.config.inc.php");
require_once($lokasiweb.'/librari/phpmailer/class.phpmailer.php');

if($_SESSION['username'])
{
	$tpl->assign("login","1");
	$tpl->assign("username",$_SESSION['username']);
	$tpl->assign("userid",$_SESSION['userid']);
	$tpl->assign("userfullname",$_SESSION['userfullname']);
	$tpl->assign("userdirname",$_SESSION['userdirname']);
	$tpl->assign("useremail",$_SESSION['useremail']);
	$tpl->assign("useractivestatus",$_SESSION['useractivestatus']);
}
$tpl->assign("last",$_SESSION['last']);

include($lokasiweb."/komponen/contact/contact.foot.php");
include($lokasiweb."/komponen/home/home.menu.php");
include($lokasiweb."/komponen/home/home.all.php");

$tpl->assign("basedomain",$basedomain);
$tpl->assign("title",$title);
$tpl->assign("fulldomain",$fulldomain);
$tpl->assign("domainfull",$fulldomain);

$var	= getVar($_SERVER["REQUEST_URI"],"main");
$tpl->assign("uri","$fulldomain".$_SERVER['REQUEST_URI']);

$rubrik		= $var[1]; $tpl->assign("rubrik",$rubrik);
$kanal		= $var[2]; $tpl->assign("kanal",$kanal);
$aksi 		= $var[3]; $tpl->assign("aksi",$aksi);
$subaksi 	= $var[4]; $tpl->assign("subaksi",$subaksi);
$subaksi2 	= $var[5]; $tpl->assign("subaksi2",$subaksi2);
$subaksi3 	= $var[6]; $tpl->assign("subaksi3",$subaksi3);
$subaksi4 	= $var[7]; $tpl->assign("subaksi4",$subaksi4);
$subaksi5 	= $var[8]; $tpl->assign("subaksi5",$subaksi5);


if(file_exists($var[0]))
{
	include($var[0]);
}
else
{
	die("Website $title dalam masa pemeliharaan. Silahkan berkunjung lain waktu");
}
?>