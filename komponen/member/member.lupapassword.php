<?php 

if(isset($_POST['userName']))
{
	$username	= $_POST['userName'];
	$useremail	= $_POST['userEmail'];

	$pesan = array();	

	 if(!preg_match("/^[a-z0-9]+([\w-])*(((?<![_-])\.(?![_-]))[\w-]*[a-z0-9])*@(?![-])([a-z0-9-]){2,}((?<![-])\.[a-z]{2,6})+$/i", $useremail))
	{
		$pesanhasil = "Sorry replacement Passwords fail to do so, there seems to be a typing error in your email, please check back.";
		$berhasil = "0";
	}
	else
	{

		$perintah     = "select userid,userfullname,username from tbl_member where username='$username' and useremail='$useremail' and useractivestatus ='1'";
		$hasil        = sql($perintah);
		$data         = sql_fetch_data($hasil);
		$userid       = $data['userid'];
		$userfullname = $data['userfullname'];
		$username     = $data['username'];
		
		if(sql_num_rows($hasil) > 0)
		{
			
			$kode = generateCode(6);
			$pass = md5($kode);

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
		   
			$pesanhasil = "Congratulations you have reset your password that has been forgotten, now your password has been sent to your email, sometimes
we enter into bulk email inbox if you use a yahoo email. Please use the best possible or
replace it with a password that you can remember."; 
			$berhasil = "1";
		}
 	}
	else
	{
	
	$pesanhasil = "Sorry reimbursement Password failed to do, the possibility of your email is not listed in our database, If
You are not yet a member, please register first";
	$berhasil = "0";
	}
	}
}
$tpl->assign("pesanhasil",$pesanhasil);
$tpl->assign("berhasil",$berhasil);
?>