<?php 
// Include Librari PHPMailer
include("global.inc.php");
include("web.fungsi.php");

//Konfigurasi Site
$sql 			= "select * from tbl_konfigurasi where webid='1' limit 1";
$hsl 			= sql($sql);
$row			= sql_fetch_data($hsl);
$webid			= $row['webid'];
$title			= $row['title'];
$domain			= $row['domain'];
$owner			= $row['owner'];
$support		= $row['support'];
$deskripsi		= $row['deskripsi'];
$support_email	= $row['support_email'];
$metakeyword	= $row['metakeyword'];
$fulldomain		= $row['domain'];
$webfacebook	= $row['webfacebook'];
$webtwitter		= $row['webtwitter'];
$webinstagram = $row['webinstagram'];
$webyoutube = $row['webyoutube'];
$issmtp			= $row['issmtp'];
$smtpuser 		= $row['smtpuser'];
$smtphost 		= $row['smtphost'];
$smtpport 		= $row['smtpport'];
$smtppass 		= $row['smtppass'];
$issmtp 		= $row['issmtp'];
$logo 			= $row['logo'];
$nummember 		= $row['nummember'];
$youtubepop 	= $row['youtubeid'];
$matauang 		= "Rp";
			
sql_free_result($hsl);


$domainmedia = "http://localhost:8080/ansaniacom/uploads/";
$domainfull = "http://localhost:8080/ansaniacom/";
$lokasiwebmember = "http://localhost:8080/ansaniacom/uploads/";



$date = date("Y-m-d H:i:s");

$uid = md5(uniqid()); 
?>