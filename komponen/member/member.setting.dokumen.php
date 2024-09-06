<?php 
if(isset($_POST['submit']))
{
	$idusernya       = $_SESSION['useridresel'];
	$nonpwp          = $_POST['nonpwp'];
	$filename_ktp    = $_FILES['dok_ktp']['name'];
	$filename_npwp   = $_FILES['dok_npwp']['name'];
	$filename_buktab = $_FILES['dok_buktab']['name'];

	if(!empty($filename_ktp))
	{
		$filesize    = $_FILES['dok_ktp']['size'];
		$filetmpname = $_FILES['dok_ktp']['tmp_name'];
		
		if($filesize > 0)
		{
			$yearm	= date("Ym");
			$simpan_file		= "$pathfile"."dokumen/";
			
			$imageinfo   = getimagesize($filetmpname);
			$imagewidth  = $imageinfo[0];
			$imageheight = $imageinfo[1];
			$imagetype   = $imageinfo[2];
			
			switch($imagetype)
			{
				case 1: $imagetype="gif"; break;
				case 2: $imagetype="jpg"; break;
				case 3: $imagetype="png"; break;
			}
			
			$photolarge = "dokumen-ktp-$idusernya.".$imagetype;
			resizeimg($filetmpname,"$simpan_file/"."$photolarge",1140,400);
			
			if(file_exists("$simpan_file"."$photolarge")){ $up_dok_ktp = "dok_ktp='$photolarge'"; }
		}
	}
	if(!empty($filename_npwp))
	{
		$filesize    = $_FILES['dok_npwp']['size'];
		$filetmpname = $_FILES['dok_npwp']['tmp_name'];
		
		if($filesize > 0)
		{
			$yearm	= date("Ym");
			$simpan_file		= "$pathfile"."dokumen/";
			
			$imageinfo   = getimagesize($filetmpname);
			$imagewidth  = $imageinfo[0];
			$imageheight = $imageinfo[1];
			$imagetype   = $imageinfo[2];
			
			switch($imagetype)
			{
				case 1: $imagetype="gif"; break;
				case 2: $imagetype="jpg"; break;
				case 3: $imagetype="png"; break;
			}
			
			$photolarge = "dokumen-npwp-$idusernya.".$imagetype;
			resizeimg($filetmpname,"$simpan_file/"."$photolarge",2550,3300);

			if(!empty($filename_ktp))
			{
				if(file_exists("$simpan_file"."$photolarge")){ $up_dok_npwp = ",dok_npwp='$photolarge'"; }
			}
			else
			{
				if(file_exists("$simpan_file"."$photolarge")){ $up_dok_npwp = "dok_npwp='$photolarge'"; }
			}
		}
	}
	if(!empty($filename_buktab))
	{	 
		$filesize    = $_FILES['dok_buktab']['size'];
		$filetmpname = $_FILES['dok_buktab']['tmp_name'];
		
		if($filesize > 0)
		{
			$yearm	= date("Ym");
			$simpan_file		= "$pathfile"."dokumen/";
			
			$imageinfo   = getimagesize($filetmpname);
			$imagewidth  = $imageinfo[0];
			$imageheight = $imageinfo[1];
			$imagetype   = $imageinfo[2];
			
			switch($imagetype)
			{
				case 1: $imagetype="gif"; break;
				case 2: $imagetype="jpg"; break;
				case 3: $imagetype="png"; break;
			}
			
			$photolarge = "dokumen-bukutabungan-$idusernya.".$imagetype;
			resizeimg($filetmpname,"$simpan_file/"."$photolarge",2550,3300);
			
			if(!empty($filename_ktp) || !empty($filename_npwp))
			{
				if(file_exists("$simpan_file"."$photolarge")){ $up_dok_buktab = ",dok_buktab='$photolarge'"; }
			}
			else
			{
				if(file_exists("$simpan_file"."$photolarge")){ $up_dok_npwp = "dok_buktab='$photolarge'"; }
			}
			
		}
	}
	
	$query= "update tbl_member set nonpwp='$nonpwp',$up_dok_ktp $up_dok_npwp $up_dok_buktab where username='$_SESSION[usernameresel]'";
	$hasil = sql($query);
	
   	if($hasil)
   	{
						   
		$pesanhasil = "Selamat Data Anda di $title telah berhasil diupdate, Lengkapi dokumen Anda secara berkala disesuaikan dengan kondisi Anda saat ini.";
		$berhasil = "1";
	}

	$tpl->assign("pesan",$pesan);
	$tpl->assign("pesanhasil",$pesanhasil);
	$tpl->assign("berhasil",$berhasil);

}

$perintah = sql("select dok_ktp,nonpwp,dok_npwp,dok_buktab from tbl_member where username='$_SESSION[usernameresel]'");
$data = sql_fetch_data($perintah);
sql_free_result($perintah);

$dok_ktp    = $data['dok_ktp'];
$nonpwp     = $data['nonpwp'];
$dok_npwp   = $data['dok_npwp'];
$dok_buktab = $data['dok_buktab'];

if(!empty($dok_ktp))
{ 
	$tpl->assign("detaildok_ktp","$fulldomain/gambar/dokumen/$dok_ktp");
}
else
{
	$tpl->assign("detaildok_ktp","$domain/images/gambar.kosong.jpg");
}
if(!empty($dok_npwp))
{
	$tpl->assign("detaildok_npwp","$fulldomain/gambar/dokumen/$dok_npwp");
} 
else
{
	$tpl->assign("detaildok_npwp","$domain/images/gambar.kosong.jpg");
}
if(!empty($dok_buktab)) 
{
	$tpl->assign("detaildok_buktab","$fulldomain/gambar/dokumen/$dok_buktab");
}
else
{
	$tpl->assign("detaildok_buktab","$domain/images/gambar.kosong.jpg");
}

$tpl->assign("dok_ktp",$dok_ktp);
$tpl->assign("nonpwp",$nonpwp);
$tpl->assign("dok_npwp",$dok_npwp);
$tpl->assign("dok_buktab",$dok_buktab);

$tpl->assign("url_dok_ktp","$fulldomain/gambar/dokumen/$dok_ktp");
$tpl->assign("url_dok_npwp","$fulldomain/gambar/dokumen/$dok_npwp");
$tpl->assign("url_dok_buktab","$fulldomain/gambar/dokumen/$dok_buktab");
?>