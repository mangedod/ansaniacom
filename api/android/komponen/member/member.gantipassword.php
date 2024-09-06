<?php 
if(isset($_POST['new_password']))
{
	$userPassword		= $_POST['old_password'];
	$userNewPassword	= $_POST['new_password'];
	$userRePassword		= $_POST['new_password2'];
	$userid		= $_POST['userid'];

	$username = sql_get_var("select username from tbl_member where userid='$userid'");

	if(!empty($userPassword) || !empty($userRePassword) || !empty($userNewPassword))
	{
		$password = true;
		
		$passLama = sql_get_var("select userpassword from tbl_member where username='$username'");
			  
		if(md5($userPassword)!=$passLama)
			{
				$result['status'] = "ERROR"; 
				$result['message']="Password lama anda salah, silahkan dicoba kembali";
				echo json_encode($result);
				exit;
			}
		else if(empty($userPassword))
			{
				$result['status'] = "ERROR"; 
				$result['message']="Password lama masih kosong, silahkan isi terlebih dahulu";
				echo json_encode($result);
				exit;
			}
		else if(empty($userNewPassword))
			{
				$result['status'] = "ERROR"; 
				$result['message']="Password baru masih kosong, silahkan isi terlebih dahulu";
				echo json_encode($result);
				exit;
			}
		else if(empty($userRePassword))
			{
				$result['status'] = "ERROR"; 
				$result['message']="Password kedua masih kosong, silahkan isi terlebih dahulu";
				echo json_encode($result);
				exit;
			}
		else if($userNewPassword!=$userRePassword)
			{
				$result['status'] = "ERROR"; 
				$result['message']="Password baru yang pertama dan kedua tidak sama, silahkan isi terlebih dahulu";
				echo json_encode($result);
				exit;
			}
		else
		{
			
			$userNewPassword = md5($userNewPassword);
			$tanggal = date("Y-m-d H:i:s");   
			
			$query=("update tbl_member set userpassword='$userNewPassword',userlastactive='$tanggal' where username='$username'");
			$hasil = sql($query);
			if($hasil)
			{
			
			$result['status'] = "OK"; 
			$result['message']="Pergantian password berhasil dilakukan.";
			$result['username']= $username;
			echo json_encode($result);
			exit;
			}
			else
			{
				$result['status'] = "ERROR"; 
				$result['message']="Pergantian password gagal ada beberapa kesalahan yang mesti diperbaiki, silahkan periksa kembali kesalahan dibawah ini";
				echo json_encode($result);
				exit;
			}
		}
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