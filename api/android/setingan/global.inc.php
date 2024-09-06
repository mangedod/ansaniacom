<?php 
error_reporting(E_ALL & ~E_NOTICE);
ini_set('log_errors', 1);
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/error.txt');

//Konfigurasi Database
$hostname = "localhost";
$username = "ansa_newansania"; 
$password = "y1lOIeFj0-1r9Cn5";
$database = "ansa_newansania";

//Konfigurasi Letak File dan Folder
$perintah_delete                = "rm";
$lokasiweb                      = "/home/ansania.com/public_html/";
$pathfile 				= "$lokasiweb/gambar/";
$lokasimember	 		= "$lokasiweb/uploads/"; 
$lokasimedia	 		= "$lokasiweb/medias/";
$slash_jenis 			= "/";


//Lakukan Koneksi dalam database
$connect = mysqli_connect($hostname,$username,$password,$database);
if (!$connect) die ("Could not establish connection");


//Poin
$pointexpire = 12;
?>
