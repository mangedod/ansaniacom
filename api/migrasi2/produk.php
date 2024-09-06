<?php
include("../setingan/web.config.inc.php");

$nama_tabel		= "tbl_product_post";
$nama_tabel1	= "tbl_product_image";
$nama_tabel2	= "tbl_product_comment";
$nama_tabel3	= "tbl_product";

//sql("truncate $nama_tabel");
//sql("truncate $nama_tabel1");
//sql("truncate $nama_tabel2");
//sql("truncate $nama_tabel3");


$perintah 	= "select * from q8001_ansania.tbl_product_post";
$hasil 		= sql($perintah);

$tipeid = 1;
$secid = 1;
$subid = 1;
$brandid = 1;
$status = 1;
$published = 1;
		
while($data = sql_fetch_data($hasil))
{	
	$produkid		= $data['produkpostid'];
	$title 		= $data['title'];
	$tag 		= $data['tag'];
	$content 		= $data['content'];
	$misc_harga 		= $data['harga'];
	$ukuran 		= $data['ukuran'];
	$body_weight = $data['berat']*1000;
	$alias = getalias($title);
	
	$kode = 10000+$produkid;
	$kode = substr($kode,1,4);
	
	if(empty($content)) $ringkas = $title;
	if(empty($content)) $content = $title;
	
	$kodeproduk = "ANS$kode";
	
	$sizeid = sql_get_var("select sizeid from tbl_size where nama='$ukuran'");
	
	$perintah2	= "insert into $nama_tabel3 (`produkid`,`kodeproduk`,`numitem`, `title`, `alias`, `tag`, `content`, `ringkas`, `tipeid`, `secid`, `subid`, `brandid`, 
					`published`, `misc_matauang`, `misc_matauangid`, `misc_harga`, `misc_jharga`, `misc_diskon`, 
					`tgl_expired`, `kondisi`, `status`, `blok`, `flag`, `create_date`, `create_userid`,`urlyoutube`,`jenisvideo` $fgambarsc)
					values ('$produkid','$kodeproduk','1','$title','$alias','$tag','$content','$ringkas','$tipeid','$secid','$subid','$brandid',
					'$published',  'Rp', '1', '$misc_harga', '$misc_jharga', '$misc_diskon', 
					'$tgl_expired', '$kondisi', '$status', '$blok', '$flag','$date','$cuserid','$urlyoutube','$jenisvideo' $vgambarsc)";

	$hasil2 	  = sql($perintah2);
	
	//input produk
	$perintah3 = "insert into $nama_tabel (`produkpostid`, `title`,`warnaid`,`sizeid`,`kodeproduk`,`body_dimension`,`body_weight`, `misc_matauang`, `misc_matauangid`, `misc_harga`, `misc_jharga`, `misc_diskon`)
					values ('$produkid','$title','$warnaid','$sizeid','$kodeproduk','$body_dimension','$body_weight',  'Rp', '1', '$misc_harga', '$misc_jharga', '$misc_diskon')";
	$hasil3 = sql($perintah3);
	
	
	//Galeri
	$perintah4 	= "select * from q8001_ansania.tbl_product_image where produkpostid='$produkid' order by albumid asc";
	$hasil4 		= sql($perintah4);
	
	while($data4 = sql_fetch_data($hasil4))
	{	
		$albumid		= $data4['albumid'];
		$nama 		= $data4['keterangan'];
		$gambar_f 		= $data4['gambar_f'];
		$gambar_l 		= $data4['gambar_l'];
		$gambar_m 		= $data4['gambar_m'];
		$gambar_s 		= $data4['gambar_s'];
		$date = $data4['create_date'];
	
		$perintah5	= "insert into $nama_tabel1(albumid,produkpostid,produkid,create_date,create_userid,gambar_f,gambar_l,gambar_m,gambar_s)
									values ('$new','$produkid','$produkid','$date','$cuserid','$gambar_f','$gambar_l','$gambar_m','$gambar_s')";
		$hasil5		= sql($perintah5);
	}
							
	//sql("insert into tbl_product_brand(brandid,nama,alias,published) values('$brandid','$nama','$alias','1')");


}
sql_free_result($hasil);
?>