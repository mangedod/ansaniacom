<?php
include("../../setingan/global.inc.php");
include("../../panel/setingan/cms.fungsi.php");

$nama_tabel = "tbl_newsletter_template";

$id = $_GET['id'];
$sql	= "select templateid,subject,plainmail,htmlmail,templatename from $nama_tabel where templateid='$id'";
	$query	= sql($sql);
	$row = sql_fetch_data($query);
	
	$templatename		= $row['templatename'];
	$subject		= $row['subject'];
	$plainmail		= stripslashes($row['plainmail']);
	$htmlmail		= stripslashes($row['htmlmail']);
        
        echo $htmlmail;
?>