<?php 
if($_POST['savepass']=="1")
{
	$password1 	= $_POST['password1'];
	$password2 	= $_POST['password2'];
	$password3 	= $_POST['password3'];

	$passcode	= $salt.$password1;

	if(!empty($password1) || !empty($password2) || !empty($password3))
	{
		//Cek sudah terdaftar atau belum
		$passLama 	= sql_get_var("select userpassword from tbl_member where username='$_SESSION[username]'");
			  
		if(md5($passcode)!=$passLama)
		{
			$error 		= "Looks like your old password less true, please try again.";
			$style		= "alert-danger";
			$backlink	= "$fulldomain"."/member/setting/changepass";
		}
		else if($password2!=$password3)
		{
			$error 		= "A new password the first two are not the same, please fill first.";
			$style		= "alert-danger";
			$backlink	= "$fulldomain"."/member/setting/changepass";
		}
		else
		{
			if($password)
			{
				$usernewpassword 	= md5($password2);
				$tanggal 			= date("Y-m-d H:i:s");   
				
				$query	= "update tbl_member set userpassword='$usernewpassword',userlastactive='$tanggal' where username='$_SESSION[username]'";
				$hasil 	= sql($query);
				
				$error 		= "Password storage is successful.";
				$style		= "alert-success";
				$backlink	= "$fulldomain"."/member/setting";
			}
		}
	}
	else
	{
		if(empty($password1))
		{
			$error 		= "Old password is empty, please fill first.";
			$style		= "alert-danger";
			$backlink	= "$fulldomain"."/member/setting/changepass";
		}
		if(empty($usernewpassword))
		{
			$error 		= "A new password is empty, please fill first.";
			$style		= "alert-danger";
			$backlink	= "$fulldomain"."/member/setting/changepass";
		}
		if(empty($userRePassword))
		{
			$error 		= "The second password is empty, please fill first.";
			$style		= "alert-danger";
			$backlink	= "$fulldomain"."/member/setting/changepass";
		}
	}
	$tpl->assign("error",$error);
	$tpl->assign("style",$style);
	$tpl->assign("backlink",$backlink);
}
?>