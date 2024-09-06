<?php 
if(file_exists($lokasiweb."/komponen/$kanal/$kanal.$aksi.php")) include("$kanal.$aksi.php");
else{ $aksi = "list";  include("$kanal.list.php"); }
 include("$kanal.menu.php");
include($lokasiweb."/komponen/blog/blog.populer.php");
/*include($lokasiweb."/komponen/event/event.kanan.php");
include($lokasiweb."/komponen/product/product.pilihan.php");
include($lokasiweb."/komponen/banner/banner.blog.php");*/
$tpl->display("$kanal.html");
?>