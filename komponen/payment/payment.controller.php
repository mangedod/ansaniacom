<?php
if(file_exists($lokasiweb."/komponen/payment/payment.$aksi.php")) include("payment.$aksi.php");
else{ $aksi = "list";  include("payment.list.php"); }

exit();
?>