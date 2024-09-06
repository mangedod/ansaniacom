<?php 
include($lokasiweb."/komponen/subhome/subhome.all.php");
if(file_exists($lokasiweb."/komponen/subproduct/subproduct.$aksi.php")) include("subproduct.$aksi.php");
else{ $aksi = "list";  include("subproduct.list.php"); }

include("subproduct.pilihan.php");

$tpl->display("$kanal.html");

?>
