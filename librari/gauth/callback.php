<?php
session_start();
$access_token = $_SESSION['access_token'];

print_r($_SESSION);
 
echo  "Akses: ". $access_token;
?>