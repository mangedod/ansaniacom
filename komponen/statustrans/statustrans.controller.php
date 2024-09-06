<?php 
include($lokasiweb."/komponen/blog/blog.rekomendasi.php");
include($lokasiweb."/komponen/product/product.pilihan.php");
if (empty($aksi)) $aksi = "read";
	
if(file_exists($lokasiweb."/komponen/$kanal/$kanal.$aksi.php")) include("$kanal.$aksi.php");
else{ $aksi = "list";  include("$kanal.list.php"); }

$tpl->display("$kanal.html");
?>