<?php 
if(file_exists($lokasiweb."/komponen/$kanal/$kanal.$aksi.php")) include("$kanal.$aksi.php");
else{ $aksi = "list";  include("$kanal.list.php"); }

include($lokasiweb."/komponen/blog/blog.rekomendasi.php");
include($lokasiweb."/komponen/product/product.pilihan.php");


$tpl->display("$kanal.html");

?>
