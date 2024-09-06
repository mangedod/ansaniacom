<?php
include($lokasiweb."/librari/captcha/securimage.php");
$kodegen = md5(time());
$tpl->assign('kodegen', $kodegen);
	
//testimonial
$perintah="select id,nama,testimoni,company from tbl_customdesigntesti where 1 order by rand() limit 3";
$hasil=sql($perintah);
while($data=sql_fetch_data($hasil))
{
	$id = $data['id'];
	$nama = $data['nama'];
	$testimoni = $data['testimoni'];
	$company = $data['company'];
	
	$datatesti[$id]=array("id"=>$id,"nama"=>$nama,"testimoni"=>$testimoni,"company"=>$company);
}
sql_free_result($hasil);
$tpl->assign("datatesti",$datatesti);

//step
$perintah1="select id,nama,lengkap from tbl_customdesign_step where 1 order by id asc";
$hasil1=sql($perintah1);
while($data1=sql_fetch_data($hasil1))
{
	$id = $data1['id'];
	$nama = $data1['nama'];
	$lengkap = $data1['lengkap'];
	
	$datastep[$id]=array("id"=>$id,"nama"=>$nama,"lengkap"=>$lengkap);
}
sql_free_result($hasil1);
$tpl->assign("datastep",$datastep);

//fact
$perintah2="select id,nama,lengkap,icon from tbl_customdesign_fact where 1 order by id asc";
$hasil2=sql($perintah2);
while($data2=sql_fetch_data($hasil2))
{
	$id = $data2['id'];
	$nama = $data2['nama'];
	$lengkap = $data2['lengkap'];
	$icon = $data2['icon'];
	
	if($icon)
		$icons="<img src=$fulldomain/gambar/fact-design/$icon>";
	else
		$icons="";
	
	$datafact[$id]=array("id"=>$id,"nama"=>$nama,"lengkap"=>$lengkap,"icon"=>$icon);
}
sql_free_result($hasil2);
$tpl->assign("datafact",$datafact);

if($_POST['save']==1)
{
	$tanggal 		= date("Y-m-d H:i:s");
	$judul			= $_POST['judul'];
	$userfullname	= $_POST['userfullname'];
	$email			= $_POST['email'];
	
	$sql	= "select max(customdesignid) as newid from tbl_customdesign";
	$query	= sql($sql);
	$newid	= sql_result($query,0,newid) + 1;

	$perintah ="insert into tbl_customdesign (customdesignid,create_date,nama,judul,email) values 
	('$newid','$tanggal','$userfullname','$judul','$email')";
	$hasil=sql($perintah);

	if($hasil)
	{
		$tpl->assign("pesan","Custom Design successfully saved");
		$tpl->assign("berhasil","1");

	}
	else
	{
		$tpl->assign("pesan","Data could not be saved");
		$tpl->assign("berhasil","0");
	}
}
?>