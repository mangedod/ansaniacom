<?php 
$postid = $var[4];

$perintah = "select id,nama,ringkas,gambar1,create_date,alias,audio,views,folder,waveform from tbl_audio where id='$postid' and userid='$userid'";
$hasil = sql($perintah);
$data =  sql_fetch_data($hasil);

$idcontent = $data['id'];
$nama=$data['nama'];
$oleh = $data['oleh'];
$lengkap= $data['lengkap'];
$tanggal = tanggal($data['create_date']);
$gambar = $data['gambar1'];
$ringkas = $data['ringkas'];
$alias = $data['alias'];
$audio = $data['audio'];
$waveform = $data['waveform'];
$youtubeid = $data['youtubeid'];
$views = $data['views'];
$folder = $data['folder'];

//delete file
if(!empty($gambar)){  unlink("$lokasimember/images/$folder/$gambar"); }
if(!empty($audio)) unlink("$lokasimember//audio/$folder/$audio");
if(!empty($waveform)) unlink("$lokasimember//images/$folder/$waveform");

$perintah	= "delete from tbl_audio_comment where username='$_SESSION[username]' and id='$postid'";
$hasil	=  sql($perintah);

if($hasil)
{
	$perintah2	= "delete from tbl_audio where userid='$userid' and id='$postid'";
	$hasil2		=  sql($perintah2);
	
	$query= "update tbl_member set jmlaudio=jmlaudio-1 where userid='$userid'";
	$hasil = sql($query);
	
	if($hasil2)
	{
		$pesan = base64_encode("Anda berhasil menghapus audio yang telah anda upload, jangan lupa untuk upload kembali audio yang lain");
		header("location: $fulldomain/member/?message=$pesan");
		
	}
}
?>