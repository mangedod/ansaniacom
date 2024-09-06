<?php
include("../../../setingan/global.inc.php");
include("../../setingan/cms.fungsi.php");

$nama_tabel = "tbl_newsletter";

$id = $_GET['newsletterid'];
$sql	= "select newsletterid,subject,plainmail,htmlmail,newslettername from $nama_tabel where newsletterid='$id'";
$query	= sql($sql);
$row = sql_fetch_data($query);

$templatename		= $row['templatename'];
$subject		= $row['subject'];
$plainmail		= stripslashes($row['plainmail']);
$htmlmail		= stripslashes($row['htmlmail']);

echo $htmlmail;
?>