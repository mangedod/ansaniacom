<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Max-Age: 3600");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Access-Control-Allow-Methods: GET, OPTIONS, PUT, POST, DELETE, HEAD');

header("Pragma: no-cache");
date_default_timezone_set('Asia/Jakarta');

$action = input($_POST['action']);

if($action=="section")
{
	$section = array();
	$perintah = "select secid,nama,keterangan,alias from tbl_blog_sec order by secid asc";
	$hasil = sql($perintah);
	while ($data =  sql_fetch_data($hasil))
	{
		$secid = $data['secid'];
		$namamenu = $data['nama'];
		$aliasmenu = $data['alias'];
		$ketmenu = $data['keterangan'];
		
		$jml = sql_get_var("select count(*) as jml from tbl_blog where secid='$secid' and published='1'");
		
		$urlmenu = "$fulldomain/$aliasmenu";

		$section[] = array("secid"=>$secid,"nama"=>$namamenu,"urlmenu"=>$urlmenu,"jml"=>$jml);
	

	}
	sql_free_result($hasil);

	$response['status'] = "OK";
	$response['message'] = "Success load data";
	$response['section'] = $section;

}
elseif ($action=="post")
{
	$nama = $_POST['nama'];
	$secid = $_POST['secid'];
	$tags = $_POST['tags'];
	$ringkas = $_POST['ringkas'];
	$lengkap = $_POST['lengkap'];
	$create_date = $_POST['tanggal'];
	$oleh = $_POST['oleh'];
	$cuserid = "1";
	$headline = $_POST['headline'];
	$section = $_POST['section'];
	$idpbn = $_POST['idpbn'];

	$alias = getalias($nama);

	$new = newid("id","tbl_blog");

	if(empty($secid))
	{
		$secid = sql_get_var("select secid from tbl_blog_sec where nama like '%$section%' or keterangan like '%$section%' limit 1");
	}
	if(empty($secid))
	{
		$secid = sql_get_var("select secid from tbl_blog_sec where nama like '%ragam%' or keterangan like '%ragam%' limit 1");
	}
	if(empty($secid))
	{
		$secid = sql_get_var("select secid from tbl_blog_sec order by rand() limit 1");
	}

	//Upload Gambar
	if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");
	
	if($_FILES['gambar']['size']>0)
	{
		$ext = substr($_FILES['gambar']['name'],-4,4);
		$ext = str_replace(".","",$ext);
		$namagambars = "$kanal-$alias-$new.$ext";
		$gambars = move_uploaded_file($_FILES['gambar']['tmp_name'],"$pathfile/$kanal/$namagambars");
		
		$namagambarl = "$kanal-$alias-$new-l.$ext";
		$gambarl = move_uploaded_file($_FILES['gambar1']['tmp_name'],"$pathfile/$kanal/$namagambarl");	
		
	
		if($gambarl){ 
			$fgambar = ",gambar,gambar1";
			$vgambar = ",'$namagambars','$namagambarl'";
		}
	}
	
	$perintah = "insert into tbl_blog(id,idpbn,secid,nama,alias,ringkas,lengkap,oleh,tags,create_date,create_userid,published,headline $fgambar) 
				values ('$new','$idpbn','$secid','$nama','$alias','$ringkas','$lengkap','$oleh','$tags','$create_date','$cuserid','1','$headline' $vgambar)"; 
	$hasil = sql($perintah);



	if($hasil)
	{  
		
		//secalias
		$secalias = sql_get_var("select alias from tbl_blog_sec where secid='$secid'");
		$url = "$fulldomain/$secalias/read/$new/$alias";
		
		$response['status'] = "OK";
		$response['message'] = "Success save data ID $new - $nama";
		$response['url'] = $url;
	}
	else
	{
		
		$response['status'] = "ERROR";
		$response['message'] = "Success load data";
	}

}
elseif ($action=="hapus")
{
	$idpbn = $_POST['idpbn'];


	if(empty($idpbn)) exit();

	$s = sql("select nama,gambar,gambar1 from tbl_blog where idpbn='$idpbn'");
	$dt = sql_fetch_data($s);
	$gambar = $dt['gambar'];
	$gambar1 = $dt['gambar1'];
	$nama = $dt['nama'];

	if(!empty($nama))
	{
		//Upload Gambar
		if(file_exists("$pathfile/$kanal/$gambar")) unlink("$pathfile/$kanal/$gambar");
		if(file_exists("$pathfile/$kanal/$gambar1")) unlink("$pathfile/$kanal/$gambar1");

		$h = sql("delete from tbl_blog where idpbn='$idpbn'");

		if($h)
		{
			$response['status'] = "OK";
			$response['message'] = "Success delete data ID $idpbn - $nama";
		}
		else
		{
			$response['status'] = "ERROR";
			$response['message'] = "Success delete data";
		}
	}
	else
	{
		$response['status'] = "ERROR";
		$response['message'] = "Konten tidak ditemukan";
	}
	

}
else
{
	$response['status'] = "ERROR";
	$response['message'] = "No Action or Action is not Registered";
}

echo json_encode($response);

exit();		
?>
