<?php
if(file_exists($lokasiweb."/komponen/subblog/subblog.$aksi.php")) include("subblog.$aksi.php");
else{ $aksi = "list";  include("subblog.list.php"); }

include("subblog.menu.php");
include($lokasiweb."/komponen/subhome/subhome.all.php");

include($lokasiweb."/komponen/subblog/subblog.rekomendasi.php");
include($lokasiweb."/komponen/subblog/subblog.populer.php");
include($lokasiweb."/komponen/subproduct/subproduct.pilihan.php");

$tpl->display("$kanal.html");

?>
