<?php
$username 		= $_POST['username'];
$password 		= $_POST['password'];
$deviceid 		= $_POST['deviceid'];
$device 		= $_POST['device'];

if($username!='' || $password!='' )
{
	$username 		= str_replace("'","`",$username);	
	$password2 	    = md5($password);
	
	$perintah	= "select userid,userfullname,username,useremail,useraddress,userpostcode,usergender,avatar,negaraid,propinsiid,userphone,userphonegsm,userpob,
					userdob,userstatus,useractivestatus,userlastloggedin,userlastactive,usercreateddate from tbl_member where (username='$username' or useremail='$username') and userpassword='$password2'";
	$hasil 		= sql($perintah);
	
	
	if(sql_num_rows($hasil)<1)
	{
		$result['status'] = "ERROR"; 
		$result['message'] = "Username $username dan password anda tidak sesuai";
		echo json_encode($result);
		exit();
	}
	else
	{
		$row 			= sql_fetch_data($hasil);
 		
		$userid  		= $row['userid'];
		$username 		= $row['username'];
		$userfullname 	= $row['userfullname'];
		$userdirname 	= $row['userdirname'];
		$useremail 		= $row['useremail'];
		$useraddress 		= $row['useraddress'];
		$userpob 		= $row['userpob'];
		$userdob 		= $row['userdob'];
		$avatar 		= $row['avatar'];
		$usergender 		= $row['usergender'];
		$propinsiid 	= $row['propinsiid'];
		$negaraid 		= $row['negaraid'];
		$userpostcode = $row['userpostcode'];
		$userphone 		= $row['userphone'];
		$userphonegsm 	= $row['userphonegsm'];
		$usertipe 		= $row['usertipe'];
		$userstatus 	= $row['useractivestatus'];
		$useractivestatus =  $row["useractivestatus"];
		$userlastloggedin =  $row["userlastloggedin"];
		$userlastactive = $row["userlastactive"];
		$create_date = $row["usercreateddate"];
		
		if($usertipe==0)
		{
			if($create_date=="0000-00-00 00:00:00")
				$create_date="2016-09-20 10:10:25";
			else
				$create_date=$create_date;
			
				
			$result['status'] = "OK"; 
			$result['message'] = "Proses login berhasil.";
				
			$result['login']="1";
			$result["userid"] =  $userid;
			$result["username"] =  $username;
			$result["userfullname"] =  $userfullname;
			$result["useremail"] = $useremail;
			$result["usergender"] =  $usergender;
			$result["userdob"] =  $userdob;
			$result["useraddress"] =  $useraddress;
			$result["userpostcode"] =  $userpostcode;
			$result["country"] =  $negara;
			$result["province"] =  $propinsi;
			$result["userphone"] =  $userphone;
			$result["userphonegsm"] =  $userphonegsm;
			$result["userstatus"] =  $userstatus;
			$uid=$userid;
			
		/*	if($statsupdate==0)
			{
				$follower	= sql_get_var("select count(*) as jml from tbl_follow where fid='$uid'");
				$following	= sql_get_var("select count(*) as jml from tbl_follow where userid='$uid'");
				
				if(!empty($uid))
				{
					$insert  = "update tbl_member set follower='$follower',following='$following',posting='$posting',statsupdate='1' where userid='$uid'";
					$sinsert = sql($insert);
				}
			}
			$result['follower'] 			= $follower;
			$result['following'] 			= $following;*/
		
			//$result['posting']	= sql_get_var("select count(*) as jml from tbl_audio where userid='$uid'");
			
			if(!empty($avatar))	$avatar = "$fulldomain/uploads/avatars/".$avatar;
			
			//$notifikasibaru =sql_get_var("select count(*) as jml from tbl_notifikasi where fromusername='$username' and status='1'");
			
			$result["avatar"] = $avatar;
			$result["activestatus"] =  $useractivestatus;
			$result["notifikasiakun"] =  $notifikasi;
			$result["jumlahnotifikasibaru"] =  $notifikasibaru;
			$result["lastloggedin"] =  $userlastloggedin;
			$result["lastactive"] =  $userlastactive;
			$result["createdate"] = tanggalonly($create_date);
			$result["updatedate"] =  $update_date;
	
			$userlastloggedin = date("Y-m-d H:i:s");
			
			if($jml==1)
			{
				$result['pvemail']=$pvemail;
				$result['pvtelp']=$pvtelp;
				$result['pvnotif']=$pvnotif;
			}
			else
			{
				$result['pvemail']=0; 
				$result['pvtelp']=0;
				$result['pvnotif']=0;
			}
			
			
			
			$lastlogin = date("Y-m-d H:i:s"); 
			
			$date1 = new DateTime($userlastloggedin);
			$date2 = new DateTime($lastlogin);
			
			$diff = $date2->diff($date1);
			
			$hours = $diff->h;
			$hours = $hours + ($diff->days*24);
			
			if($hours>24)
			{
				earnpoin("login",$userid);
			}
			
			if($deviceid!="undefined" || $deviceid!="")
			{
				//Cek
				$isdevice = sql_get_var("select count(*) as jml from tbl_device where deviceid='$deviceid' and userid='$userid'");
				
				if(empty($isdevice) && !empty($deviceid) && $deviceid!="undefined")
				{
					$views = "insert into tbl_device(deviceid,userid,device) values('$deviceid','$userid','$device')";
					$hsl = sql($views);
				}
			}
			
			$views = "update tbl_member set userlastloggedin='$userlastloggedin',userlastactive='$userlastloggedin' where userid='$userid'";
			$hsl = sql($views);
		}
		else
		{
			$result['status']="ERROR";
			$result['message']="Mohon Maaf Anda tidak dapat melakukan login. Silahkan kunjungi website  untuk melakukan login.";
		}

				
		echo json_encode($result);
		exit();


	}
}
else
{
	$result['status'] = "ERROR"; 
	$result['message'] = "Username dan Password harus anda isi";	

	echo json_encode($result);
	exit();
}


?>	
