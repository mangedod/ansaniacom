<?php 
if(empty($_SESSION['refer'])) $_SESSION['refer'] = $_SERVER['HTTP_REFERER'];

if(file_exists($lokasiweb."/komponen/$kanal/$kanal.$aksi.php")) include("$kanal.$aksi.php");
else{ $aksi = "list";  include("$kanal.list.php"); }

exit();
?>