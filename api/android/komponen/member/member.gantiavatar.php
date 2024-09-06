<?php 
$userid = $var[4];
$filetmpname = $_FILES['file']['tmp_name'];
$rawData = file_get_contents("php://input");

$uri = $_SERVER['REQUEST_URI'];
$post = serialize($_POST);
$data = date('Y-m-d H:i:s')." | $ip | Namafile: $filetmpname | $rawData\r\n";
$file = "backlog.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);

if(!empty($filetmpname))
{
		$username = sql_get_var("select username from tbl_member where userid='$userid'");
		$namafiles = $_FILES['file']['name'];
	
		//Post Media
		$gambars_maxw = 250;
		$gambars_maxh = 330;
		$gambarm_maxw = 350;
		$gambarm_maxh = 470;
		$gambarl_maxw = 600;
		$gambarl_maxh = 800;
		$gambarf_maxw = 800;
		$gambarf_maxh = 1050;
		
		if(!empty($filetmpname))
		{
			
			$yearm	= date("Ym");
			$folderalbum = "$lokasimember/avatars/$yearm";
			if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }
			
			copy($filetmpname,"$folderalbum/$userid-".date("Ymdhis").".jpg");
			
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
			resizeimg($filetmpname,"$folderalbum/$photofull",250,250);
			
			$photolarge = "avatar-".$userid."-l.".$imagetype;
			resizeimg($filetmpname,"$folderalbum/$photolarge",150,150);
			
			$photomedium = "avatar-".$userid."-m.".$imagetype;
			resizeimg($filetmpname,"$folderalbum/$photomedium",100,100);
			
			$photomedium2 = $userid.'.jpg';
			resizeimg($filetmpname,"$folderalbum2/$photomedium2",250,250);
			
			$photosmall = "avatar-".$userid."-s.".$imagetype;
			resizeimg($filetmpname,"$folderalbum/$photosmall",50,50);
			
			$uri = $_SERVER['REQUEST_URI'];
			$post = serialize($_POST);
			$data = date('Y-m-d H:i:s')." | $photofull | $uri | $filetmpname\r\n";
			$file = "backlog.txt";
			$open = fopen($file, "a+"); 
			fwrite($open, "$data"); 
			fclose($open);
	
			
			
			
			if(file_exists("$folderalbum/$photomedium"))
			{ 
				$query	= "update tbl_member set avatar='$yearm/$photomedium' where username='$username'";
				$hasil 	= sql($query);
			
			    if($hasil)
			    {
									   
					$pesanhasil = "Selamat Data anda di $title telah berhasil diupdate, Lakukan perubahan profil secara berkala disesuaikan dengan kondisi anda saat ini.";
					$berhasil = "1";
					
					$result['status']="OK";
					$result['upload']="yes";
					$result['message']="Berhasil upload status";
					$result['kategori']= $kategori;
						
					echo json_encode($result);
					exit();
			
				} 
			}
			else
			{
				$pesanhasil = "Penyimpanan setting gagal dilakukan ada beberapa kesalahan yang mesti diperbaiki, silahkan periksa kembali kesalahan dibawah ini";
				$berhasil = "0";
				
				$result['status']="ERROR";
				$result['upload']="yes";
				$result['message']= $pesanhasil;
				$result['kategori']= $kategori;
					
				echo json_encode($result);
				exit();
			}
		
	}
} 
?>
