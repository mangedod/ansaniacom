<?php 
if(isset($_POST['userid']))
{
	$userid = $_POST['userid'];
	$username = sql_get_var("select username from tbl_member where userid='$userid'");

	if(isset($_POST['userfullname'])=="1")
	{
		$userfullname	= cleaninsert($_POST['userfullname']);
		$useraddress	= cleaninsert($_POST['useraddress']);
		$userphonegsm	= cleaninsert($_POST['userphonegsm']);
		$userhomepage	= cleaninsert($_POST['userhomepage']);
		$useremail		= cleaninsert($_POST['useremail']);
		$userabout		= cleaninsert($_POST['userabout']);
		$userdob		= cleaninsert($_POST['userdob']);
		
		$dob = explode("-",$userdob);
		
		$userdob = "$dob[0]-$dob[1]-$dob[2]";


		if(empty($userfullname))
		{
			$result['status'] = "ERROR"; 
			$result["message"] = "UserfullName anda masih kosong, silahkan isi dengan lengkap terlebih dahulu";
			echo json_encode($result);
			exit;
		}
		else if(empty($userphonegsm))
		{
			$result['status'] = "ERROR"; 
			$result["message"] = "Nomor Telp  anda masih kosong, silahkan isi dengan lengkap terlebih dahulu";
			echo json_encode($result);
			exit;
		}
		else if(empty($useremail))
		{
			$result['status'] = "ERROR"; 
			$result["message"] = "email  anda masih kosong, silahkan isi dengan lengkap terlebih dahulu";
			echo json_encode($result);
			exit;
		}
		else if(empty($useraddress))
		{
			$result['status'] = "ERROR"; 
			$result["message"] = "Nomor handphone  anda masih kosong, silahkan isi dengan lengkap terlebih dahulu";
			echo json_encode($result);
			exit;
		}
			
		else
		{
		
			$query= "update tbl_member set userfullname='$userfullname',useraddress='$useraddress',userphonegsm='$userphonegsm',userdob='$userdob',useremail='$useremail',aboutme='$userabout' $vpassword where username='$username'";
			$hasil = sql($query);
			
		   	if($hasil)
			{
				$result['status'] = "OK"; 
				$result["message"] ="Profil anda berhasil diperbaharui";
				
				
				$perintah	= "select userid,userfullname,username,useremail,useraddress,userpostcode,usergender,avatar,negaraid,propinsiid,userphone,userphonegsm,userpob,
					userdob,userstatus,useractivestatus,userlastloggedin,userlastactive from tbl_member where username='$username'";
				$hasil 		= sql($perintah);
				$datam = sql_fetch_data($hasil);
	
				$result['userid'] 		= $datam['userid'];

		
				echo json_encode($result);
				exit;
			}
			else
			{
				$result['status'] = "ERROR"; 
				$result["message"] ="Penyimpanan setting gagal dilakukan, ada beberapa kesalahan yang mesti diperbaiki";
				echo json_encode($result);
				exit;
			}
		}
	}
	else
	{
		$perintah = sql("select * from tbl_member where username='$username'");
		$data = sql_fetch_data($perintah);
		sql_free_result($perintah);
		
		$result['username'] 		= $data['username'];
		$result['userfullname']	= $data['userfullname'];
		$result['useraddress']	= $data['useraddress'];
		$result['userphonegsm']	= $data['userphonegsm'];
		$result['useremail']		= $data['useremail'];
		
		echo json_encode($result);
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