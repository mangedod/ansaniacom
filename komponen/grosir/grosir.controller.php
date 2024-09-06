<?php 
//include($lokasiweb."/komponen/subhome/subhome.all.php");
if(file_exists($lokasiweb."/komponen/grosir/grosir.$aksi.php")) include("grosir.$aksi.php");
else{ $aksi = "list";  include("grosir.list.php"); }
include("grosir.kategori.php");

if($aksi=="embed")
{
	$tpl->display("product-embed.html");
}
else
{
$tpl->display("$kanal.html");
}

?>
