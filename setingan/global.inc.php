<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('log_errors', 1);
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/error.txt');

//Konfigurasi Database
$hostname = "localhost";
$username = "root"; 
$password = "";
$database = "ansa_newansania";

//Konfigurasi Letak File dan Folder
$perintah_delete                = "rm";
$lokasiweb                      = "http://localhost:8080/ansaniacom/";
$pathfile                       = "$lokasiweb/gambar/";
$lokasimember                   = "$lokasiweb/uploads/";
$lokasimedia                    = "$lokasiweb/media/"; 
$slash_jenis                    = "/";

//Lakukan Koneksi dalam database
$connect = mysqli_connect($hostname,$username,$password,$database);
if (!$connect) die ("Could not establish connection");

//Konfigurasi Veritrans Sanbox
/*$merchantid		= "M100313";
$serverkey		= "VT-server-cSOGx0h-1RxTuAIRILNKNrf5";
$clientid		= "VT-client-4gmKPeDl3uxIHyJM";
$isProduction	= false;*/

//Konfigurasi Veritrans Production
$merchantid		= "M100313";
$serverkey		= "VT-server-jdiKgTvp9TB0uNAXnHT89__G";
$clientid		= "VT-client-suBRETu_ipz5F1Ar";
$isProduction	= true;

//Spam
$spam = "emeyle.com";
?>
