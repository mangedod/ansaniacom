<?php	
//include kebutuhan data
if(file_exists($lokasiweb."/komponen/cart/cart.$aksi.php")) include($lokasiweb."komponen/cart/cart.$aksi.php");
else{
	include "cart.buy.php";
}

if($aksi=="pay")
{
	$tpl->display("pay.html");
}
elseif($aksi=="payklikbca")
{
	$tpl->display("payklikbca.html");
}
elseif($aksi=="print")
{
	$tpl->display("cetak.html");
}


else $tpl->display("cart.html");
?>