<?php 
if(isset($_POST['submit']) and $_SESSION['useridresel'])
{
	$nama         = cleaninsert($_POST['nama']);
	$tag          = cleaninsert($_POST['tag']);
	$ringkas      = desc($_POST['ringkas']);
	$lengkap      = desc($_POST['lengkap']);	
	$secid        = cleaninsert($_POST['secid']);	
	$produkpostid = cleaninsert($_POST['produkpostid']);	
	
	$alias		= getAlias($nama);
	$date		= date("Y-m-d H:i:s");

	$new = newid("id","tbl_blog");

	$filename	= $_FILES['gambar']['name'];
	$filesize	= $_FILES['gambar']['size'];
	$filetmpname	= $_FILES['gambar']['tmp_name'];
	
	if($filesize > 0)
	{
		$yearm	= date("Ym");
		$simpan_file		= "$pathfile/blog";
		
		$imageinfo = getimagesize($filetmpname);
		$imagewidth = $imageinfo[0];
		$imageheight = $imageinfo[1];
		$imagetype = $imageinfo[2];
		
		switch($imagetype)
		{
			case 1: $imagetype="gif"; break;
			case 2: $imagetype="jpg"; break;
			case 3: $imagetype="png"; break;
		}
		
		$photofull = "blog-$alias-$yearm-".$_SESSION['useridresel']."-$new-f.".$imagetype;
		resizeimg($filetmpname,"$simpan_file/$photofull",760,600);
		
		$photolarge = "blog-$alias-$yearm-".$_SESSION['useridresel']."-$new-l.".$imagetype;
		resizeimg($filetmpname,"$simpan_file/$photolarge",500,400);
		
		
		if(file_exists("$simpan_file/$photolarge")){ $vgmbr = ",gambar,gambar1"; $isigmbr = ",'$photolarge','$photofull'"; }
		
	}

			
	$salah = false;
	$pesan = array();
	
	if(empty($nama))
	{
		$pesan[1] = array("pesan"=>"Judul blog Anda masih kosong, silahkan isi dengan lengkap terlebih dahulu");
		$salah = true;
	}
	else if(empty($tag))
	{
		$pesan[2] = array("pesan"=>"Tag blog Anda masih kosong, silahkan isi dengan lengkap terlebih dahulu");
		$salah = true;
	}
	else if(empty($ringkas))
	{
		$pesan[3] = array("pesan"=>"Ringkas blog Anda masih kosong, silahkan isi dengan lengkap terlebih dahulu");
		$salah = true;
	}
	else if(empty($lengkap))
	{
		$pesan[4] = array("pesan"=>"Lengkap blog Anda masih kosong, silahkan isi dengan lengkap terlebih dahulu");
		$salah = true;
	}

	
	if(!$salah)
	{
	
		$query= "insert into tbl_blog(id,secid,produkpostid,nama,alias,ringkas,lengkap,tags,create_date,userid,published $vgmbr) values ('$new','$secid','$produkpostid','$nama','$alias','$ringkas','$lengkap','$tag','$date','$_SESSION[useridresel]','0' $isigmbr)";
		$hasil = sql($query);
		
	   if($hasil)
	   {
								   
			$pesanhasil = "Selamat blog Anda berhasil disimpan, untuk melihat hasil perubahan dari blog Anda <a href=\"$fulldom/member/readblog/$secid/$new/$alias\"><strong>disini</strong></a>";
			$berhasil = "1";
		}
				
	}
	else
	{
		$pesanhasil = "Penyimpanan blog gagal dilakukan ada beberapa kesalahan yang mesti diperbaiki, silahkan periksa kembali kesalahan dibawah ini";
		$berhasil = "0";
	}
	
$tpl->assign("pesan",$pesan);
$tpl->assign("pesanhasil",$pesanhasil);
$tpl->assign("berhasil",$berhasil);

}

//kategori
$datakategori = array();
$pkategori = "select secid,nama from tbl_blog_sec order by nama asc";
$hkategori = sql($pkategori);
while($dkategori= sql_fetch_data($hkategori))
{
	$datakategori[$dkategori['secid']] = array("secid"=>$dkategori['secid'],"nama"=>$dkategori['nama']);
}
sql_free_result($hkategori);
$tpl->assign("datakategori",$datakategori);

//produk
$dataproduk = array();
$pproduk = "select produkpostid,title from tbl_product_post where published='1' order by title asc";
$hproduk = sql($pproduk);
while($dprod= sql_fetch_data($hproduk))
{
	$dataproduk[$dprod['produkpostid']] = array("produkpostid"=>$dprod['produkpostid'],"namaprod"=>$dprod['title']);
}
sql_free_result($hproduk);
$tpl->assign("dataproduk",$dataproduk);
?>