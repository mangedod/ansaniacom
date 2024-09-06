<?php 
if(isset($_POST['useremail']))
{
	$useremail	= $_POST['useremail'];

	$pesan = array();	

	 if(!preg_match("/^[a-z0-9]+([\w-])*(((?<![_-])\.(?![_-]))[\w-]*[a-z0-9])*@(?![-])([a-z0-9-]){2,}((?<![-])\.[a-z]{2,6})+$/i", $useremail))
	{
		$result['status']="ERROR";
		$result['message']="Mohon maaf penggantian Password gagal dilakukan,Sepertinya ada kesalahan penulisan email anda, silahkan periksa kembali";
		$result['berhasil']="0";
		
		echo json_encode($result);
		exit;
	}
	else
	{
		$perintah = "select userid,userfullname,username from tbl_member where useremail='$useremail'";
		$hasil = sql($perintah);
		$data = sql_fetch_data($hasil);
		$userid = $data['userid'];
		$userfullname = $data['userfullname'];
		$username = $data['username'];
		
		if(sql_num_rows($hasil) > 0)
		{
			
			$kode = generateCode(6);
			$pass = md5($kode);

			$query = "update tbl_member set userpassword='$pass' where useremail='$useremail'";
			$hasil = sql($query);
			//$hasil=1;
			if($hasil)
			{
				$subject = "$userfullname, Informasi password baru untuk anda";
				$isi =" 
						Penggantian Password $title
						======================================================================
							
						Yth. $userfullname
						Selamat $userfullname , Password anda di $title sekarang telah diganti 
						dapat digunakan kembali. Silahkan anda login menggunakan :
							
						Email  : $useremail
						Password : $kode
							
						Jika Password dirasa terlalu panjang, silahkan ganti password secepatnnya. 
						Terimakasih atas kesetiaan anda kepada $title
							
						$owner
						======================================================================	
					";
				$isihtml = "
					Penggantian Password $title<br />
					======================================================================<br />
					<br />	
					Yth. $userfullname<br />
					Selamat $userfullname , Password anda di $title sekarang telah diganti 
					dapat digunakan kembali. Silahkan anda login menggunakan :<br /><br />
						
					Username  : $username<br />
					Password : $kode<br />
					<br /><br />	
					Jika Password dirasa terlalu panjang, silahkan ganti password secepatnnya. 
					Terimakasih atas kesetiaan anda kepada $title
					<br /><br />	
					$owner<br />
					======================================================================	
					<br />";
			
				sendmail($userfullname,$useremail,$subject,$isi,emailhtml($isihtml));
		   
				$result['status'] = "OK"; 
				$result['message']="Password Anda berhasil di set ulang. Cek email untuk melihat password baru."; 
				$result['userEmail']  = $useremail;
				echo json_encode($result);
				exit;
			}
		}
		else
		{
			$result['status'] = "ERROR"; 
			$result['message']="Password Anda gagal di set ulang.";
			echo json_encode($result);
			exit;
		}
	}
}
else
{
	$result['status'] = "ERROR"; 
	$result['message']="Tidak ada data dikirim";
	echo json_encode($result);
	exit;
}
?>