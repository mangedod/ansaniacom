<?php 
require "../librari/phpmailer/class.phpmailer.php";
include("../setingan/global.inc.php");
include("cms.fungsi.php");

//Konfigurasi Site
$sql           = "select * from tbl_konfigurasi where webid='1' limit 1";
$hsl           = sql($sql);
$row           = sql_fetch_data($hsl);
$webid         = $row['webid'];
$title         = $row['title'];
$fulldomain    = $row['domain'];
$owner         = $row['owner'];
$support       = $row['support'];
$support_email = $row['support_email'];
$smtphost      = $row['smtphost'];
$smtpname      = $row['smtpname'];
$smtpuser      = $row['smtpuser'];
$smtppass      = $row['smtppass'];
$smtpport      = $row['smtpport'];
$issmtp        = $row['issmtp'];
$deskripsi     = $row['deskripsi'];
$metakeyword   = $row['metakeyword'];
sql_free_result($hsl);



$lokasiwebmember = "$fulldomain/uploads/"; 
$lokasiwebmedia  = "$fulldomain/medias/"; 
$lokasiwebnya    = "$fulldomain/gambar"; 


//Error Message
$error['oto']    = "<center><div class=\"box-error\">Anda tidak mempunyai otoritas  menggunakan fitur ini</div></center>"; 
$error['view']   = "<center><div class=\"box-error\">Anda tidak mempunyai otoritas untuk melihat data</div></center>"; 
$error['add']    = "<center><div class=\"box-error\">Anda tidak mempunyai otoritas menambahkan data</div></center>"; 
$error['edit']   = "<center><div class=\"box-error\">Anda tidak mempunyai otoritas melakukan perubahan data</div></center>";
$error['delete'] = "<center><div class=\"box-error\">Anda tidak mempunyai otoritas untuk menghapus data ini</div></center>"; 	

	
//Warna Table
$warna[0] = "#f1f1f1";
?>