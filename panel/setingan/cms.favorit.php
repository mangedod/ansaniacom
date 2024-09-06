<?php 
if($fav=="dashboard") header("location: $alamat&aksi=view");

$q = sql("select count(*) as jumlah from tbl_cms_favorit where userid='$_SESSION[cms_userid]' and kanal='$fav'");
$h = sql_fetch_data($q);

$jm = $h['jumlah'];

if($jm<1)
{
	$perintah = "insert into tbl_cms_favorit(userid,kanal) values ('$_SESSION[cms_userid]','$fav')";
	$hasil = sql($perintah);
	
	if($hasil)
	{   
		$msg = base64_encode("Berhasil menambahkan menu baru ke Favorite");
		header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
		exit();
	}
	else
	{
		$error = base64_encode("Gagal menambahkan menu baru ke Favorite");
		header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
		exit();
	}
}
else
{
	$error = base64_encode("Menu yang dipilih telah dijadikan Favorite Sebelumnya");
	header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
	exit();
}
?>