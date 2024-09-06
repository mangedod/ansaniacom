<?php
$dt = sql_get_var_row("select nama,lengkap from tbl_static where alias='tentangkami'");
$tentang = $dt['lengkap'];
$nama = $dt['nama'];

$tentang = strip_tags($tentang);

$result['status'] = "OK";
$result['message'] = "Data  berhasil diload";
$result['judul'] = $nama;
$result['tentang'] = $tentang;

echo json_encode($result);
?>