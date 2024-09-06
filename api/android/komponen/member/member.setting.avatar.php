<?php 
$username=$_POST['username'];

if(isset($username))
{
	$userid = sql_get_var("select userid from tbl_member where username='$username'");
	$filename	= $_FILES['avatar']['name'];
	$filesize	= $_FILES['avatar']['size'];
	$filetmpname	= $_FILES['avatar']['tmp_name'];
	
	
	if($filesize > 0)
	{
		if(($filesize>5120000) && (!empty($filename)))
		{
			$result['status'] = "Error"; 
			$result["message"] = "Gambar yang anda dikirimkan untuk avatar berukuran lebih dari 500 KB silahkan pilih gambar yang lain";
			echo json_encode($result);
			exit;
		}	
		else
		{
			$yearm	= date("Ym");
			$folderalbum = "$lokasimember/avatars/$yearm";
			if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }
			
			$folderalbum2 = "$lokasimember/avatar";
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
			
			$photofull = "avatar-".$userid."-f.".$imagetype;
			cropimg($filetmpname,"$folderalbum/$photofull",500,500);
			
			$photolarge = "avatar-".$userid."-l.".$imagetype;
			cropimg($filetmpname,"$folderalbum/$photolarge",300,300);
			
			$photomedium = "avatar-".$userid."-m.".$imagetype;
			cropimg($filetmpname,"$folderalbum/$photomedium",250,250);
			
			$photomedium2 = $userid.'.jpg';
			cropimg($filetmpname,"$folderalbum2/$photomedium2",250,250);
			
			$photosmall = "avatar-".$userid."-s.".$imagetype;
			cropimg($filetmpname,"$folderalbum/$photosmall",80,80);
			
			
			
			if(file_exists("$folderalbum/$photomedium"))
			{ 
				$query	= "update tbl_member set avatar='$yearm/$photomedium' where username='$username'";
				$hasil 	= sql($query);
			
			   if($hasil)
			   {
				   	$perintah 	= "select avatar from tbl_member where username='$username'";
					$hasil		= sql($perintah);
					$data 		= sql_fetch_data($hasil);
					$avatar = $data['avatar'];
				   
					if(empty($avatar))
					{ 
						$avatar = "$fulldomain/images/avatar-default.png"; 
					}
					else
					{
						$avatar = str_replace("-m","-f",$avatar);				
						$avatar = "$lokasiwebmember/avatars/$avatar";
					}
					
					$result['status'] = "OK"; 
					$result["message"] = "Avatar anda telah berhasil diupdate";
					$result['username']=$username;
					$result['avatar']=$avatar;
					
					echo json_encode($result);
					exit;
				} 
			}
			else
			{
				$result['status'] = "Error"; 
				$result["message"] ="Penyimpanan avatar gagal dilakukan, ada beberapa kesalahan yang mesti diperbaiki";
				echo json_encode($result);
				exit;
			}
		}
		
	}
	else
	{
		$result['status'] = "Error"; 
		$result["message"] ="Penyimpanan avatar gagal dilakukan, ada beberapa kesalahan yang mesti diperbaiki";		
		echo json_encode($result);
		exit;
	}
}
else
{
	$result['status'] = "Error"; 
	$result['message']="Tidak ada data dikirim";
	echo json_encode($result);
	exit;
}

?>