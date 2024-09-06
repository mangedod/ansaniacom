<?php 
if(isset($_POST['userEmail']))
{
	// $username	= $_POST['userName'];
	$useremail	= $_POST['userEmail'];

	$pesan = array();	

	 if(!preg_match("/^[a-z0-9]+([\w-])*(((?<![_-])\.(?![_-]))[\w-]*[a-z0-9])*@(?![-])([a-z0-9-]){2,}((?<![-])\.[a-z]{2,6})+$/i", $useremail))
	{
		$pesanhasil = "Mohon maaf penggantian Password gagal dilakukan,Sepertinya ada kesalahan penulisan email Anda, silahkan periksa kembali";
		$berhasil = "0";
	}
	else
	{

		$perintah     = "select userid,userfullname,username from tbl_member where useremail='$useremail' and useractivestatus ='1'";// username='$username'
		$hasil        = sql($perintah);
		$data         = sql_fetch_data($hasil);
		$userid       = $data['userid'];
		$userfullname = $data['userfullname'];
		$username     = $data['username'];
		
		if(sql_num_rows($hasil) > 0)
		{
			
			$kode = generateCode(6);
			$pass = md5($kode);
			// $pass = md5($kode."jcow");

			$query = "update tbl_member set userpassword='$pass' where useremail='$useremail'";
			$hasil = sql($query);
			//$hasil=1;
		
		if($hasil)
	   	{
			$subject = "$userfullname, Informasi password baru untuk Anda";
			$isi =" 
				Penggantian Password $title
				======================================================================
					
				Yth. $userfullname
				Selamat $userfullname , Password Anda di $title sekarang telah diganti 
				dapat digunakan kembali. Silahkan Anda login menggunakan :
					
				Email  	  : $useremail
				Username  : $username
				Password  : $kode
					
				Jika Password dirasa terlalu panjang, silahkan ganti password secepatnnya. 
				Terimakasih atas kesetiaan Anda kepada $title
					
				$owner
				======================================================================	
						";
						$isihtml = "
				Penggantian Password $title<br />
				======================================================================<br />
				<br />	
				Yth. $userfullname<br />
				Selamat $userfullname , Password Anda di $title sekarang telah diganti 
				dapat digunakan kembali. Silahkan Anda login menggunakan :<br /><br />
					
				Email     : $useremail<br />
				Username  : $username<br />
				Password  : $kode<br />
				<br /><br />	
				Jika Password dirasa terlalu panjang, silahkan ganti password secepatnnya. 
				Terimakasih atas kesetiaan Anda kepada $title
				<br /><br />	
				$owner<br />
				======================================================================	
				<br />";
			
			sendmail($userfullname,$useremail,$subject,$isi,$isihtml);
			/*echo "$userfullname,$useremail,$subject,$isi,$isihtml";
			die();*/
		   
			$pesanhasil = "Selamat Anda telah mereset password Anda yang telah lupa, sekarang password Anda telah kami kirim ke email sahabat, terkadang
			email kami masuk kedalam bulk inbox jika sahabat menggunakan email yahoo. Silahkan gunakan dengan sebaik mungkin atau
			ganti dengan password yang mudah Anda ingat."; 
			$berhasil = "1";
		}
 	}
	else
	{
	
	$pesanhasil = "Mohon maaf penggantian Password gagal dilakukan, kemungkian email Anda tidak terdaftar dalam database kami, Jika
				 Anda belum menjadi member, silahkan daftar terlebih dahulu";
	$berhasil = "0";
	}
	}
}
$tpl->assign("pesanhasil",$pesanhasil);
$tpl->assign("berhasil",$berhasil);
?>