<?php 
//include($lokasiweb."/komponen/subhome/subhome.all.php");
if(file_exists($lokasiweb."/komponen/product/product.$aksi.php")) include("product.$aksi.php");
else{ $aksi = "list";  include("product.list.php"); }
include("product.kategori.php");

if($aksi=="embed")
{
	$tpl->display("product-embed.html");
}
else
{
$tpl->display("$kanal.html");
}

?>
