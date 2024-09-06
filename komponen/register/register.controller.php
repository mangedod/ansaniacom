<?php 
if(file_exists($lokasiweb."/komponen/$kanal/$kanal.$aksi.php")) include("$kanal.$aksi.php");
if($aksi == "registrasi") include("$kanal.registrasi.php");
// include($lokasiweb."/komponen/controller/controller.controller.php");

$tpl->display("$kanal.html");
?>