<?php 
if(isset($_POST['submit']))
{

	$filename	= $_FILES['avatar']['name'];
	$filesize	= $_FILES['avatar']['size'];
	$filetmpname	= $_FILES['avatar']['tmp_name'];
	
	$pesan = array();
	
	if($filesize > 0)
	{
		if(($filesize>5120000) && (!empty($filename)))
		{
			$pesan[8] = array("pesan"=>"Gambar yang Anda dikirimkan untuk avatar berukuran lebih dari 500 KB silahkan pilih gambar yang lain");
			$salah = true;
		}	
		else
		{
			$yearm	= date("Ym");
			$folderalbum = "$lokasimember"."avatars/$yearm";
			// $folderalbum = "$lokasimember/avatars/$yearm";
			if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }
			
			$folderalbum2 = "$lokasimember"."avatar";
			if(!file_exists($folderalbum2)){	mkdir($folderalbum2,0777); }
			
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
			
			$photofull = "avatar-".$_SESSION['useridresel']."-f.".$imagetype;
			resizeimg($filetmpname,"$folderalbum/$photofull",250,250);
			
			$photolarge = "avatar-".$_SESSION['useridresel']."-l.".$imagetype;
			resizeimg($filetmpname,"$folderalbum/$photolarge",150,150);
			
			$photomedium = "avatar-".$_SESSION['useridresel']."-m.".$imagetype;
			resizeimg($filetmpname,"$folderalbum/$photomedium",100,100);
			
			$photomedium2 = $_SESSION['useridresel'].'.jpg';
			resizeimg($filetmpname,"$folderalbum2/$photomedium2",250,250);
			
			$photosmall = "avatar-".$_SESSION['useridresel']."-s.".$imagetype;
			resizeimg($filetmpname,"$folderalbum/$photosmall",50,50);
			
			
			
			if(file_exists("$folderalbum/$photomedium"))
			{ 
				$query	= "update tbl_member set avatar='$yearm/$photomedium' where username='$_SESSION[usernameresel]'";
				$hasil 	= sql($query);
			
			   if($hasil)
			   {
									   
				$pesanhasil = "Selamat Data Anda di $title telah berhasil diupdate, Lakukan perubahan profil secara berkala disesuaikan dengan kondisi Anda saat ini.";
				$berhasil = "1";
				} 
			}
			else
			{
				$pesanhasil = "Penyimpanan setting gagal dilakukan ada beberapa kesalahan yang mesti diperbaiki, silahkan periksa kembali kesalahan dibawah ini";
				$berhasil = "0";
			}
		}
		
	}
	else
	{
		$pesanhasil = "Penyimpanan setting gagal dilakukan ada beberapa kesalahan yang mesti diperbaiki, silahkan periksa kembali kesalahan dibawah ini";
		$berhasil = "0";
	}

			
	$tpl->assign("pesan",$pesan);
	$tpl->assign("pesanhasil",$pesanhasil);
	$tpl->assign("berhasil",$berhasil);

}


$yearm	= date("Ym");
$folderalbum = "$lokasiwebmemberava/avatars/$yearm";
// $folderalbum = "$lokasiwebmember/avatars/$yearm";

if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }

$folderalbum2 = "$lokasiwebmemberava/avatar/";

$locuploads = base64_encode($folderalbum."/");
$locuploads2 = base64_encode($folderalbum2);
$tpl->assign("locuploads",$locuploads);
$tpl->assign("locuploads2",$locuploads2);

$perintah = sql("select avatar from tbl_member where username='$_SESSION[usernameresel]'");
$data = sql_fetch_data($perintah);
sql_free_result($perintah);

$avatar 		= $data['avatar'];
if(empty($avatar)) $avatar = "$domain/images/noavatar.png";
else 
{
	$avatar = "$lokasiwebmemberava/avatars/$avatar"; 
	// $avatar = "$lokasiwebmember$dirname/avatars/$avatar"; 
	$avatar = str_replace("m.jpg","l.jpg",$avatar);
}
$tpl->assign("avatarnya",$avatar);


$yearm	= date("Ym");
$folderalbum = "$lokasiwebmemberava/avatars/$data[avatar]";
$tpl->assign("folderalbum",$folderalbum);

$folderalbum2 = "$lokasiwebmemberava/avatar/$_SESSION[useridresel]".".jpg";
$tpl->assign("folderalbum2",$folderalbum2);


?>