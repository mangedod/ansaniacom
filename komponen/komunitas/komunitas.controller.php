<?php 

include($lokasiweb."/komponen/blog/blog.menu.php");
include($lokasiweb."/komponen/blog/blog.populer.php");

if(file_exists($lokasiweb."/komponen/$kanal/$kanal.$aksi.php")) include("$kanal.$aksi.php");
else{ $aksi = "list";  include("$kanal.list.php"); }


$tpl->display("$kanal.html");

?>
