<?php 

include($lokasiweb."/komponen/controller/controller.controller.php");

if(file_exists($lokasiweb."/komponen/$kanal/$kanal.$aksi.php")) include("$kanal.$aksi.php");
else{ include("$kanal.list.php"); }

/*include("$kanal.populer.php");
include($lokasiweb."/komponen/video/video.populer.php");*/

$tpl->display("$kanal.html");

?>
