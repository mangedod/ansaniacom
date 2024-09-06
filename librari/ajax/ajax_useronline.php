<?php 
session_start();
include("../../setingan/global.inc.php");
include("../../setingan/web.config.inc.php");

if($_SESSION['username'])
{

if($_GET['aksi']=="list")
{
	//UserOnline
	$perintah = "select userId from tbl_useronline  where userId!='$_SESSION[userid]' order by userName asc ";
	$hasil = sql($perintah);
	$a = 0;
	while($data = sql_fetch_data($hasil))
	{
		$userId = $data['userId'];
		
		///Dapatkan Datauser
		$perintah1 = "select userid,username,userfullname,userdirname,avatar from tbl_member where userid='$userId'";
		$hasil1 = sql($perintah1);
		$data1 = sql_fetch_data($hasil1);
		sql_free_result($hasil1);
		$dirName = $data1['userdirname'];
		$avatar = $data1['avatar'];
		$userName = $data1['username'];
		$userFullName = $data1['userfullname'];
		
		if ($avatar)
			$gambar="$fulldomain/dirmember/$dirName/avatar/$avatar";
		else
			$gambar="$lokasiwebtemplate/images/no_pic.jpg";
		
		$link = "$fulldomain/member/profile/$userId";
		
		echo"<div class=\"plex-member-item\">
                    <div class=\"img-member-item\"><img src=\"$gambar\" alt=\"\"/></div>
                    <b><a href=\"javascript:void(0)\" onClick=\"shownotic('notifikasi2','plexbox2');chatWith('$userName')\">$userFullName</a></b> <br /><span class=\"kecil\">$cuap</span>
			</div>\n";
		$a++;
	}

}else if($_GET[aksi]=="jml")
{
	$perintah = "select count(*) as jml from tbl_useronline  where userId!='$_SESSION[userid]'";
	$hasil = sql($perintah);
	$data = sql_fetch_data($hasil);
	$jml = $data['jml'];
	echo $jml;
}
else if($_GET[aksi]=="jml")
{
	$perintah = "select count(*) as jml from tbl_useronline  where userId!='$_SESSION[userid]'";
	$hasil = sql($perintah);
	$data =sql_fetch_data($hasil);
	$jml = $data['jml'];
	echo $jml;
}
else if($_GET[aksi]=="listnotifikasi")
{
	//Notifikasi
	$perintah = "select id,fromUserName,pesan from tbl_notifikasi where (toUserId='$_SESSION[userid]' or toUserName='$_SESSION[username]') and status='0' order by tanggal desc";
	$hasil = sql($perintah);
	$jml = sql_num_rows($hasil);
	$notifikasi = array();
	while($data = sql_fetch_data($hasil))
	{
		$id = $data['id'];
		$id2 = base64_encode($id);
		$base = md5($id2);
		$fromUserName = $data['fromUserName'];
		$pesan = $data['pesan'];
		if($fromUserName=="system") { $pesan1 = "<a href=\"$fulldomain/notifikasi/go/$id2/$base\">$pesan</a>"; }
		else { $pesan1 = "<a href=\"$fulldomain/member/profile/$fromUserName\"><strong>$fromUserName</strong></a> <a href=\"$fulldomain/notifikasi/go/$id2/$base\">$pesan</a>"; }
		
		echo"<div class=\"notifikasi-item\">$pesan1</div>";
	}
}
else if($_GET[aksi]=="jmlnotifikasi")
{
	$perintah = "select count(*) as jml from tbl_notifikasi where (toUserId='$_SESSION[userid]' or toUserName='$_SESSION[username]') and status='0'";
	$hasil = sql($perintah);
	$data = sql_fetch_data($hasil);
	$jml = $data['jml'];
	
	if($jml>0)
	{
	echo "<img src=\"/template/smansa/images/icon.notifikasi.gif\" style=\"float:left;margin:3px;\" alt=\"\" />Notifikasi <span class=\"notifikasimerah\" id=\"jmlnotifikasi\">$jml</span>";
	}
	else
	{
		echo "<img src=\"/template/smansa/images/icon.notifikasi.gif\" style=\"float:left;margin:3px;\" alt=\"\" />Notifikasi";
	}
}
}
?>