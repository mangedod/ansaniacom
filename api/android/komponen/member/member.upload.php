<?php 
$userid = $var[4];

if(isset($_POST['status']))
{
	
		$isi = $_POST['status'];
		
		$namafile = $_FILES['file']['tmp_name'];
		$namafiles = $_FILES['file']['name'];
		
		$jmlstring = strlen($isi)-substr_count($isi, ' ');
		
		if($jmlstring<10)
		{
			$result['status']="ERROR";
			$result['upload']="no";
			$result['message']="Status yang anda buat terlalu pendek, minimal 10 karakter";
			echo json_encode($result);
		}
	
		
		//Post Media
		$gambars_maxw = 250;
		$gambars_maxh = 330;
		$gambarm_maxw = 350;
		$gambarm_maxh = 470;
		$gambarl_maxw = 600;
		$gambarl_maxh = 800;
		$gambarf_maxw = 800;
		$gambarf_maxh = 1050;
		
		if(!empty($isi))
		{
			if($isi == "Apa yang Anda pikirkan?") $isi = "";
			
			$tanggal	= date("Y-m-d H:i:s");
			$idbaru 	= newid("postid","tbl_post");
			
			$user = sql_get_var_row("select username,userfullname from tbl_member where userid='$userid'");
			$username = $user['username'];
			$userfullname = $user['userfullname'];
		
			$perintah2	= "insert into tbl_post (postid,userid,username,tousername,touserid,userfullname,touserfullname,isi,tanggal,home) 
						values ('$idbaru','$userid','$username','$username','$userid','$userfullname','$userfullname','$isi','$tanggal','')";
			$hasil2		=  sql($perintah2);			
		
			if($hasil2)
			{
				$mention = "";
				$isii = explode(" ",$isi);
				for($u=0;$u<count($isii);$u++)
				{
					$kata = $isii[$u];
					if($kata[0]=="@")
					{
						$katax = str_replace("@","",$kata);
						
						$mnt = sql_get_var("select username from tbl_member where username='$katax' limit 1");
						
						if(!empty($mnt))
						{
							$mention .="$katax,";
							setlog($username,$katax,"menyebut sahabat dalam statusnya","$fulldomain/user/post/$idbaru","comment");
							$isi = str_replace("$kata","<a href=\"$fulldomain/$mnt\">$kata</a>",$isi);
						}
						
					}
					/*if($kata[0]=="#")
					{
						$katax = str_replace("#","",$kata);
						$isi = str_replace("$kata","<a href=\"$fulldomain/user/cari/$katax\">$kata</a>",$isi);
					}
					if(preg_match("/http:\/\//i",$kata))
					{
						$isi = str_replace("$kata","<a href=\"$kata\" target=\"_blank\"  title=\"$kata\">Tautan</a>",$isi);
					}*/
				}
				
				$sqlp	= "update tbl_member set posting=posting+1 where username='$username'";
				$qry 	= sql($sqlp);
			}
			
				
			//Upload Gambar
			$fbulan = date("Ym");
			if(!file_exists("$lokasimember/userfiles/$fbulan")) mkdir("$lokasimember/userfiles/$fbulan");
			
			if($_FILES['file']['size']>0)
			{
				$uri = $_SERVER['REQUEST_URI'];
				
				$post = serialize($_POST);
				$data = date('Y-m-d H:i:s')." | $ip | $_FILES[file][tmp_name]\r\n";
				$file = "backlog.txt";
				$open = fopen($file, "a+"); 
				fwrite($open, "$data"); 
				fclose($open);
		
				$newid = newid("mediaid","tbl_post_media");
				
				$ext 			= getimgext($_FILES['file']);
				$namagambars 	= "media-$fbulan-$userid-$newid-s.$ext";
				$gambars 		= resizeimg($_FILES['file']['tmp_name'],"$lokasimember/userfiles/$fbulan/$namagambars",$gambars_maxw,$gambars_maxh);
				
				$namagambarm 	= "media-$fbulan-$userid-$newid-m.$ext";
				$gambarm 		= resizeimg($_FILES['file']['tmp_name'],"$lokasimember/userfiles/$fbulan/$namagambarm",$gambarm_maxw,$gambarm_maxh);
				
				$namagambarl 	= "media-$fbulan-$userid-$newid-l.$ext";
				$gambarl 		= resizeimg($_FILES['file']['tmp_name'],"$lokasimember/userfiles/$fbulan/$namagambarl",$gambarl_maxw,$gambarl_maxh);
				
				$namagambarf 	= "media-$fbulan-$userid-$newid-f.$ext";
				$gambarf 		= resizeimg($_FILES['file']['tmp_name'],"$lokasimember/userfiles/$fbulan/$namagambarf",$gambarf_maxw,$gambarf_maxh);
				
				if(file_exists("$lokasimember/userfiles/$fbulan/$namagambarl"))
				{ 
					$perintah	= "insert into tbl_post_media(create_date,jenis,userid,nama,ringkas,gambar,gambar_s,gambar_m,gambar_l,gambar_f,url,published) 
								values ('$tanggal','photo','$userid','$isi','$isi','$namagambarm','$namagambars','$namagambarm','$namagambarl','$namagambarf','','1')";
					$hasil		=  sql($perintah);
					
					$media = array("mediaid"=>$newid,"jenis"=>"photo","lokasi"=>"$fbulan","media"=>"uploads/userfiles/$fbulan/$namagambarl");
					$media = serialize($media);
					
					$sql = "update tbl_post set media='$media' where postid='$idbaru'";
					$res = sql($sql);
					
					$photo = true;
				}
			}
		
			//if($tousername!=$_SESSION['username']) setlog($_SESSION['username'],"$tousername","menulis status didinding anda","$fulldomain/user/post/$idbaru");
			
			//Earn Point
			earnpoin("update-status",$userid);
		
		
		if($hasil2)
		{
		
		
			$result['status']="OK";
			$result['upload']="yes";
			$result['message']="Berhasil upload status";
			$result['kategori']= $kategori;
				
			echo json_encode($result);
		}
		else
		{
			$result['status']="OK";
			$result['upload']="no";
			$result['message']="User belum diizinkan untuk upload Audio";
			echo json_encode($result);
		}
	}
} 
?>
