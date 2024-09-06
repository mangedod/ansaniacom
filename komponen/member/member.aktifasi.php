<?php 
$code = $subaksi;
if(!empty($code))
{
	$perintah = "select id,userid,username,code,status,tanggal from tbl_member_konfirmasi where code='$code'";
	$hasil    = sql($perintah);
	$jumlah   = sql_num_rows($hasil);
		
	if($jumlah < 1 )
	{
		$pesanhasil = "Sorry, the confirmation code you entered does not match. Please try again by going to e-mail you and use the URL provided to validate the registration";
		$berhasil	= "0";
	}
	else
	{
		$data = sql_fetch_data($hasil);
		$code = $data['kode'];
		$username = $data['username'];
		$status = $data['status'];
		
		if($status)
		{
			$pesanhasil = "Sorry, confirmation code failed to be registered because the code has been used or you have already done the previous registration confirmation, please try to login directly to the website $title";		
			$berhasil	= "0";
		}
		else
		{
			//update status member 
			$perintah1 = sql("update tbl_member_konfirmasi set status='1' where username='$username'");
			$perintah1 = sql("update tbl_member set userActiveStatus='1',verified='1' where username='$username'");

			$perintah2 = "select userid,userfullname,username,userdirname from tbl_member where username='$username' and useractivestatus='1'";
			
			$hasil2       = sql($perintah2);
			$row          = sql_fetch_data($hasil2);
			$userfullname = $row['userfullname'];
			$userdirname  = $row['userdirname'];
			$username     = $row['username'];
			$userid       = $row['userid'];
			
			
			$_SESSION['userid'] = $userid;
			$_SESSION['userfullname'] = $userfullname;
			$_SESSION['username'] = $username;
			$_SESSION['userdirname'] = $userdirname;
			
		
			$views = sql("update tbl_member_stats set login=login+1 where userid='$userid'");

			$pesanhasil = "Registration has been done, please log in at the top. Next you need to complement the data on profile $title in order to enjoy all the facilities that exist in $title";
			
			$berhasil	= "1";


		}
		
	}
}

$tpl->assign("pesanhasil",$pesanhasil);
$tpl->assign("berhasil",$berhasil);
		
?>
