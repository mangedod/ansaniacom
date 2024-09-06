<?php 
if(isset($_POST['userfullname']))
{
	$userfullname     = cleaninsert($_POST['userfullname']);
	$usergender       = $_POST['usergender'];
	$userpob          = $_POST['userpob'];
	$date             = $_POST['date'];
	$month            = $_POST['month'];
	$year             = $_POST['year'];
	$nomor_ktp        = $_POST['nomor_ktp'];
	$useraddress      = cleaninsert($_POST['useraddress']);
	$kotaid           = cleaninsert($_POST['kotaid']);
	$propinsiid       = $_POST['propinsiid'];
	$negaraid     = "97";
	// $negaraid     = $_POST['negaraid'];
	$userpostcode     = cleaninsert($_POST['userpostcode']);
	$userphone        = cleaninsert($_POST['userphone']);
	$userphonegsm     = cleaninsert($_POST['userphonegsm']);
	$pinbb            = $_POST['pinbb'];
	$norek            = cleaninsert($_POST['norek']);
	$status_rumah     = cleaninsert($_POST['status_rumah']);
	$lama_tinggal     = cleaninsert($_POST['lama_tinggal']);
	$pekerjaan        = cleaninsert($_POST['pekerjaan']);
	$kantor           = cleaninsert($_POST['kantor']);
	$jabatan          = cleaninsert($_POST['jabatan']);
	$status_kerja     = cleaninsert($_POST['status_kerja']);
	$masa_kerja       = cleaninsert($_POST['masa_kerja']);
	$pengeluaran      = cleaninsert($_POST['pengeluaran']);
	$telp_kantor      = cleaninsert($_POST['telp_kantor']);
	$marriagestatusid = cleaninsert($_POST['marriagestatusid']);
	$profesiid        = cleaninsert($_POST['profesiid']);
	$userhomepage     = cleaninsert($_POST['userhomepage']);
	$useremail        = cleaninsert($_POST['useremail']);
	$fbid             = cleaninsert($_POST['fbid']);
	$twitterid        = cleaninsert($_POST['twitterid']);
	$userdob          = "$year-$month-$date";
	
	$nama_sutri        = cleaninsert($_POST['nama_sutri']);
	$pekerjaan_sutri   = cleaninsert($_POST['pekerjaan_sutri']);
	$kantor_sutri      = cleaninsert($_POST['kantor_sutri']);
	$jabatan_sutri     = cleaninsert($_POST['jabatan_sutri']);
	$telp_kantor_sutri = cleaninsert($_POST['telp_kantor_sutri']);

	
	//validasi userphone
	$notlp= str_split($userphone);
	$length=strlen($userphone);
	if($notlp[0] == '0')
	{
		$notlp2 = '62';
	for ($i=1;$i<$length;$i++)
	{
		$baru.=$notlp[$i];
	}
	$userphone2 = "$notlp2"."$baru";
	}
	else
		$userphone2=$userphone;
	//validasi userphonegsm
/*	$nohp = str_split($userphonegsm);
	$panjang=strlen($userphonegsm);
	if($nohp[0] == '0')
	{
		$nohp2 = '62';
	for ($i=1;$i<$panjang;$i++)
	{
		$baru1.=$nohp[$i];
	}
	$userphonegsm2 = "$nohp2"."$baru1";
	}
	else*/
		$userphonegsm2=$userphonegsm;

	$filename	= $_FILES['avatar']['name'];
	$filesize	= $_FILES['avatar']['size'];
	$filetmpname	= $_FILES['avatar']['tmp_name'];
	
	if($filesize > 0)
	{
		$folderalbum = "$lokasimember/avatar/";
		if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }
		
		$imageinfo = getimagesize($filetmpname);
		$imagewidth = $imageinfo[0];
		$imageheight = $imageinfo[1];
		$imagetype = $imageinfo[2];
		
		switch($imagetype)
		{
			case 1: $imagetype="gif"; break;
			case 2: $imagetype="jpg"; break;
			case 3: $imagetype="png"; break;
		}
		
		$photofull = "avatar-".$_SESSION['userid']."-f.".$imagetype;
		resizeimg($filetmpname,"$folderalbum$photofull",800,800);
		
		$photolarge = "avatar-".$_SESSION['userid']."-l.".$imagetype;
		resizeimg($filetmpname,"$folderalbum$photolarge",500,500);
		
		$photomedium = "avatar-".$_SESSION['userid']."-m.".$imagetype;
		resizeimg($filetmpname,"$folderalbum$photomedium",250,250);
		
		$photosmall = "avatar-".$_SESSION['userid']."-s.".$imagetype;
		resizeimg($filetmpname,"$folderalbum$photosmall",80,80);
		
		if(file_exists("$folderalbum$photomedium")){ $avatars = ",avatar='$photomedium'"; }
		
	}

			
	$salah = false;
	$pesan = array();
	
	if(empty($userfullname))
	{
		$pesan[9] = array("pesan"=>"UserfullName Anda masih kosong, silahkan isi dengan lengkap terlebih dahulu");
		$salah = true;
	}
	else if(empty($usergender))
	{
		$pesan[10] = array("pesan"=>"Jenis kelamin, silahkan isi dengan lengkap terlebih dahulu");
		$salah = true;
	}
	else if(empty($userphonegsm))
	{
		$pesan[14] = array("pesan"=>"Nomor Telp  Anda masih kosong, silahkan isi dengan lengkap terlebih dahulu");
		$salah = true;
	}
	else if(!preg_match("/^[a-z0-9]+([\w-])*(((?<![_-])\.(?![_-]))[\w-]*[a-z0-9])*@(?![-])([a-z0-9-]){2,}((?<![-])\.[a-z]{2,6})+$/i", $useremail))
		{
		$pesan[15] = array("pesan"=>"Email masih kosong atau penulisan email kurang benar, silahkan isi Terlebih Dahulu");
		$salah = true;
	}
	else if($date=="00" || $month=="00" || $year=="00")
	{
		$pesan[17] = array("pesan"=>"Tanggal lahir Anda belum benar, silahkan isi dengan lengkap terlebih dahulu");
		$salah = true;
	}

	
	if(!$salah)
	{
		$query= "update tbl_member set userfullname='$userfullname',usergender='$usergender',userpob='$userpob',useraddress='$useraddress',kotaid='$kotaid',norek='$norek',
				userphone='$userphone2',userphonegsm='$userphonegsm2',nomor_ktp='$nomor_ktp',pinbb='$pinbb',userdob='$userdob',negaraid='$negaraid',propinsiid='$propinsiid',
				pekerjaan='$pekerjaan',kantor='$kantor',jabatan='$jabatan',status_kerja='$status_kerja',masa_kerja='$masa_kerja',pengeluaran='$pengeluaran',telp_kantor='$telp_kantor',
				marriagestatusid='$marriagestatusid',workid='$profesiid',userhomepage='$userhomepage',useremail='$useremail',fbid='$fbid',twitterid='$twitterid',
				userpostcode='$userpostcode',status_rumah='$status_rumah',lama_tinggal='$lama_tinggal',nama_sutri='$nama_sutri',pekerjaan_sutri='$pekerjaan_sutri',
				kantor_sutri='$kantor_sutri',jabatan_sutri='$jabatan_sutri',telp_kantor_sutri='$telp_kantor_sutri' where username='$_SESSION[username]'";
		
		$hasil = sql($query);
		
	   if($hasil)
	   {
							   
		$pesanhasil = "Selamat Data Anda di $title telah berhasil diupdate, Lakukan perubahan profil secara berkala disesuaikan dengan kondisi Anda saat ini.";
		$berhasil = "1";
		}
				
	}
	else
	{
		$pesanhasil = "Penyimpanan setting gagal dilakukan ada beberapa kesalahan yang mesti diperbaiki, silahkan periksa kembali kesalahan dibawah ini";
		$berhasil = "0";
	}
	
$tpl->assign("pesan",$pesan);
$tpl->assign("pesanhasil",$pesanhasil);
$tpl->assign("berhasil",$berhasil);

}

$perintah = sql("select * from tbl_member where username='$_SESSION[username]'");
$data = sql_fetch_data($perintah);
sql_free_result($perintah);

$username          = $data['username'];
$userfullname      = $data['userfullname'];
$usergender        = $data['usergender'];
$userpob           = $data['userpob'];
$nomor_ktp         = $data['nomor_ktp'];
$useraddress       = $data['useraddress'];
$cityname          = $data['cityname'];
$kotaid            = $data['kotaid'];
$propinsiid        = $data['propinsiid'];
$negaraid          = $data['negaraid'];
$userpostcode      = $data['userpostcode'];
$userphone         = $data['userphone'];
$userphonegsm      = $data['userphonegsm'];
$pinbb             = $data['pinbb'];
$norek             = $data['norek'];
$status_rumah      = $data['status_rumah'];
$lama_tinggal      = $data['lama_tinggal'];
$pekerjaan         = $data['pekerjaan'];
$kantor            = $data['kantor'];
$jabatan           = $data['jabatan'];
$status_kerja      = $data['status_kerja'];
$masa_kerja        = $data['masa_kerja'];
$pengeluaran       = $data['pengeluaran'];
$telp_kantor       = $data['telp_kantor'];
$marriagestatusid  = $data['marriagestatusid'];
$profesiid         = $data['workid'];
$userhomepage      = $data['userhomepage'];
$useremail         = $data['useremail'];
$fbid              = $data['fbid'];
$twitterid         = $data['twitterid'];
$nama_sutri        = $data['nama_sutri'];
$pekerjaan_sutri   = $data['pekerjaan_sutri'];
$kantor_sutri      = $data['kantor_sutri'];
$jabatan_sutri     = $data['jabatan_sutri'];
$telp_kantor_sutri = $data['telp_kantor_sutri'];

if(empty($negaraid))
	$negaraid		= "97";
	// $negaraid		= "99";

$dob = explode("-","$data[userdob]");

$tpl->assign("username",$username);
$tpl->assign("userfullname",$userfullname);
$tpl->assign("usergender",$usergender);
$tpl->assign("userpob",$userpob);
$tpl->assign("nomor_ktp",$nomor_ktp);
$tpl->assign("useraddress",$useraddress);
$tpl->assign("cityname",$cityname);
$tpl->assign("kotaid",$kotaid);
$tpl->assign("propinsiid",$propinsiid);
$tpl->assign("negaraid",$negaraid);
$tpl->assign("userpostcode",$userpostcode);
$tpl->assign("userphone",$userphone);
$tpl->assign("userphonegsm",$userphonegsm);
$tpl->assign("pinbb",$pinbb);
$tpl->assign("norek",$norek);
$tpl->assign("status_rumah",$status_rumah);
$tpl->assign("lama_tinggal",$lama_tinggal);
$tpl->assign("pekerjaan",$pekerjaan);
$tpl->assign("kantor",$kantor);
$tpl->assign("jabatan",$jabatan);
$tpl->assign("status_kerja",$status_kerja);
$tpl->assign("masa_kerja",$masa_kerja);
$tpl->assign("pengeluaran",$pengeluaran);
$tpl->assign("telp_kantor",$telp_kantor);
$tpl->assign("marriagestatusid",$marriagestatusid);
$tpl->assign("profesiid",$profesiid);
$tpl->assign("userhomepage",$userhomepage);
$tpl->assign("useremail",$useremail);
$tpl->assign("fbid",$fbid);
$tpl->assign("twitterid",$twitterid);
$tpl->assign("nama_sutri",$nama_sutri);
$tpl->assign("pekerjaan_sutri",$pekerjaan_sutri);
$tpl->assign("kantor_sutri",$kantor_sutri);
$tpl->assign("jabatan_sutri",$jabatan_sutri);
$tpl->assign("telp_kantor_sutri",$telp_kantor_sutri);



//dapatkan data tanggal
$dateloop = array();
$tempi = 1;
while ($tempi < 32) {
	 if ($tempi < 10){
		 array_push($dateloop,"0".$tempi);
		 $temp2 = "0".$tempi;
	 }else{
		 array_push($dateloop,$tempi);
		 $temp2 = $tempi;
	}
	if($temp2 == $dob[2]) $dateselected = $tempi;
	$tempi++;
}

$monthloop = array();
$tempi = 1;
while ($tempi < 13) {
	 if ($tempi < 10){
		 array_push($monthloop,"0".$tempi);
		  $temp2 = "0".$tempi;
	 }else{
		 array_push($monthloop,$tempi);
		 $temp2 = $tempi;
	}
	if($temp2 == $dob[1]) $monthselected = $tempi;
	$tempi++;

}

$yearloop = array();
$tempi = date("Y")-80;

while($tempi < date("Y") - 10) {
	 array_push($yearloop,$tempi);
	if($tempi == $dob[0]) $yearselected = $tempi;
	$tempi++;

}

if($monthselected<10) $monthselected = "0".$monthselected;
if($dateselected<10) $dateselected = "0".$dateselected;

$tpl -> assign( 'yearloop', $yearloop );
$tpl -> assign( 'yearselected' , $yearselected);
$tpl -> assign( 'monthloop', $monthloop );
$tpl -> assign( 'monthselected' , $monthselected);
$tpl -> assign( 'dateloop', $dateloop );
$tpl -> assign( 'dateselected' , $dateselected);

//negara
$datanegara = array();
$pnegara = "select id,namanegara from tbl_negara order by namanegara asc";
$hnegara = sql($pnegara);
while($dnegara= sql_fetch_data($hnegara))
{
	$datanegara[$dnegara['id']] = array("id"=>$dnegara['id'],"namanegara"=>$dnegara['namanegara']);
}
sql_free_result($hnegara);
$tpl->assign("datanegara",$datanegara);

//propinsi
$datapropinsi = array();
$ppropinsi = "select propid,namapropinsi from tbl_propinsi order by namapropinsi asc";
$hpropinsi = sql($ppropinsi);
while($dpropinsi=sql_fetch_data($hpropinsi))
{
	$datapropinsi[$dpropinsi['propid']] = array("id"=>$dpropinsi['propid'],"namapropinsi"=>$dpropinsi['namapropinsi']);
}
mysql_free_result($hpropinsi);
$tpl->assign("datapropinsi",$datapropinsi);

//kota
$datakota = array();
$pkota = "select kotaid,namakota from tbl_kota order by namakota asc";
$hkota = sql($pkota);
while($dkota=sql_fetch_data($hkota))
{
	$datakota[$dkota['kotaid']] = array("id"=>$dkota['kotaid'],"namakota"=>$dkota['namakota']);
}
mysql_free_result($hkota);
$tpl->assign("datakota",$datakota);

//profesi
$dataprofesi = array();
$pprofesi = "select id,profesi from tbl_work order by profesi asc";
$hprofesi = mysql_query($pprofesi);
while($dprofesi= mysql_fetch_object($hprofesi))
{
	$dataprofesi[$dprofesi->id] = array("id"=>$dprofesi->id,"profesi"=>$dprofesi->profesi);
}
mysql_free_result($hprofesi);
$tpl->assign("dataprofesi",$dataprofesi);



/*//avatar
$avatar = $data->avatar;
$dirname = getdirname($_session[userid]);

if(empty($avatar)) $avatar = "$domain/images/noavatar.png";
else $avatar = "$lokasiwebmember$dirname/avatar/$avatar"; 
$tpl->assign("avatar",$avatar);
*/
?>