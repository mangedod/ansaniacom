<?php
$dbhost  = 'localhost';
$dbname  = 'flvcoba';
$dblogin = 'root';
$dbhaslo = 'Ad1cakep';
$connect = mysql_connect($dbhost, $dblogin, $dbhaslo); 
mysql_select_db($dbname, $connect);
$prefix = '';

$language = 'en';

$domain = 'www.indigo.myspeedytown.com';
$player_folder = 'flv_player'; 

$admin_login = 'admin'; 
$admin_pass = '123';
?>