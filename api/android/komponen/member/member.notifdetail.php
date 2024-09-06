<?php
$id = $_GET['id'];

$perintah = "select url from tbl_notifikasi where id='$id'";
$hasil = sql($perintah);
$data = sql_fetch_data($hasil);
sql_free_result($hasil);

$url = $data['url'];

$perintahc = "update tbl_notifikasi set status='1' where id='$id'";
$hasilc = sql($perintahc);

$perintahc = "update tbl_notifikasi set status='1' where tousername='$_SESSION[username]' and url='$url'";
$hasilc = sql($perintahc);

$result['status']="OK";
$result['message']="Notifikasi sudah dibaca";

echo json_encode($result);
?>