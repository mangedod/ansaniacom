<?php 


$socmed_id			= $_POST['socmed_id'];
$socmed_type		= $_POST['socmed_type'];
$userfullname		= clean($_POST['userfullname']);
$useremail			= clean($_POST['useremail']);
$username			= $useremail;

$salah = false;
$pesan = array();

$jumlah = sql_get_var("select count(*) as jumlah from tbl_member where socmed_id='$socmed_id'");
$jumlahemail = sql_get_var("select count(*) as jumlah from tbl_member where useremail='$useremail' and socmed_id<>'$socmed_id'");

$fbid = ''; $twid = ''; $gpid = ''; 

if($socmed_type == 'fb')
	$fbid = '';
if($socmed_type == 'twitter')
	$twid = '';
if($socmed_type == 'gplus')
	$gpid = '';
  
if($jumlahemail > 0)
{
	$result['status'] = "ERROR"; 
	$result['message']="Email $useremail sudah digunakan oleh orang lain, silahkan gunakan akun yang lain";
	echo json_encode($result);
	exit;
}

if($jumlah == 0 ) // sign up
{  

	$username = strtolower($username); 
   
  	$perintah = "select max(userid) as baru from tbl_member";
	$hasil = sql($perintah);
	$data = sql_fetch_data($hasil);
	$baru = $data['baru']+1;
	
	$tanggal = date("Y-m-d H:i:s");
	
    $query = "insert into tbl_member (userid,socmed_id,socmed_type,username,userfullname,useremail,usercreateddate,useractivestatus,create_date,fbcid,twcid,gpcid)
			 values ('$baru','$socmed_id','$socmed_type', '$username','$userfullname','$useremail','$tanggal','1',now(),'$fbid','$twid','$gpid')";
    $hasil = sql($query);
	
   if($hasil)
   {
		// buat recod untuk konfirmasi
		$code = "$baru"."$username".date("YmdHis");
		$code = md5($code);
		//$perintah4= "insert into tbl_member_konfirmasi(userid,username,code) values ('$baru','$username','$code')";
		//$hasil4 = sql($perintah4);
		
		$perintah5= "update tbl_konfigurasi set nummember=nummember+1";
		$hasil5 = sql($perintah5);
		
		
   	}
	else
	{
		$result['status'] = "ERROR"; 
		$result['message']= "Proses login gagal";
		
		echo json_encode($result);
		exit();
	}
} 

// login
$perintah	= "select userid, socmed_id, socmed_type, userfullname,username,useremail,useraddress,userpostcode,usertipe,usergender,avatar,negaraid,propinsiid,userphone,userphonegsm,userpob,
					userdob,userstatus,useractivestatus,userlastloggedin,userlastactive,create_date,update_date from tbl_member where socmed_id = '$socmed_id'";
$hasil 		= sql($perintah);

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
		$create_date = $row["create_date"];
		$update_date = $row["update_date"];

		
		$negara = sql_get_var("select namanegara from tbl_negara where id='$negaraid'");
		$propinsi = sql_get_var("select namapropinsi from tbl_propinsi where propid='$propinsiid'");
		
		
		$result['status'] = "OK"; 
		$result['message'] = "Proses login berhasil.";
			
		$result['login']="1";
		$result['socmed_id'] = $socmed_id;
		$result['socmed_type'] = $socmed_type;
		$result["user_id"] =  $userid;
		$result["user_type"] = $usertipe;
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
		
		if(!empty($avatar))	$avatar = "$domainmedia/avatar/".$avatar;
		
		$result["avatar"] = $avatar;
		$result["activestatus"] =  $useractivestatus;
		$result["lastloggedin"] =  $userlastloggedin;
		$result["lastactive"] =  $userlastactive;
		$result["createdate"] = $create_date;
		$result["updatedate"] =  $update_date;

		$userlastloggedin = date("Y-m-d H:i:s");
		
		

		$views = "update tbl_member set userlastloggedin='$userlastloggedin',userlastactive='$userlastloggedin' where userid='$userid'";
		$hsl = sql($views);
				
		echo json_encode($result);
		exit();
		

?>
