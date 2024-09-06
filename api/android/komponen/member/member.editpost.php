<?php 
if(isset($_POST['submit']) and $_SESSION['userid'])
{
	$nama		= cleaninsert($_POST['nama']);
	$tag		= cleaninsert($_POST['tag']);
	$ringkas	= desc($_POST['ringkas']);
	$id	= desc($_POST['id']);	
	$secid		= cleaninsert($_POST['secid']);	
	
	$sql = "select id,folder from tbl_audio where userid='$_SESSION[userid]' and id='$id'";
	$hsl = sql($sql);
	$data = sql_fetch_data($hsl);
	$new = $data['id'];
	$bulan = $data['folder'];
	sql_free_result($hsl);
	
	$folder = "$lokasimember/images/$bulan";
	if(!file_exists($folder)){ mkdir($folder); }

	$alias		= getAlias($nama);

	$filename	= $_FILES['gambar']['name'];
	$filesize	= $_FILES['gambar']['size'];
	$filetmpname	= $_FILES['gambar']['tmp_name'];
	
	if($filesize > 0)
	{
		$yearm	= date("Ym");
		$simpan_file		= "$lokasimember/waveform";
		
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
		
		$photofull = "audio-$bulan-".$_SESSION['userid']."-$new-f.".$imagetype;
		cropimg($filetmpname,"$folder/$photofull",800,800);
		
		$photolarge = "audio-$bulan-".$_SESSION['userid']."-$new-l.".$imagetype;
		cropimg($filetmpname,"$folder/$photolarge",500,500);
		
		$photomedium = "audio-$bulan-".$_SESSION['userid']."-$new-m.".$imagetype;
		cropimg($filetmpname,"$folder/$photomedium",250,250);
		
		$photosmall = "audio-$bulan-".$_SESSION['userid']."-$new-s.".$imagetype;
		cropimg($filetmpname,"$folder/$photosmall",100,100);
		
		
		if(file_exists("$folder/$photolarge")){ $vgmbr = ",gambar='$photosmall',gambar1='$photomedium',gambar2='$photolarge',gambar3='$photofull'"; }
		
	}

			
	$salah = false;
	$pesan = array();
	
	if(empty($nama))
	{
		$pesan[1] = array("pesan"=>"Judul audio anda masih kosong, silahkan isi dengan lengkap terlebih dahulu");
		$salah = true;
	}
	else if(empty($ringkas))
	{
		$pesan[3] = array("pesan"=>"Deskripsi audio anda masih kosong, silahkan isi dengan lengkap terlebih dahulu");
		$salah = true;
	}
	
	if(!$salah)
	{
	
		$query= "update tbl_audio set secid='$secid',nama='$nama',alias='$alias',ringkas='$ringkas',tags='$tag',published='1' $vgmbr where id='$new' and userid='$_SESSION[userid]'";
		$hasil = sql($query);
		
	
	   if($hasil)
	   {
			updatejmlsec();					   
			$pesanhasil = "Selamat audio anda berhasil disimpan, untuk melihat hasil perubahan dari audio anda <a href=\"$basedomain/audio/listen/$new/$alias\"><strong>disini</strong></a>";
			$berhasil = "1";
		}
				
	}
	else
	{
		$pesanhasil = "Penyimpanan audio gagal dilakukan ada beberapa kesalahan yang mesti diperbaiki, silahkan periksa kembali kesalahan dibawah ini";
		$berhasil = "0";
	}
	
$tpl->assign("pesan",$pesan);
$tpl->assign("pesanhasil",$pesanhasil);
$tpl->assign("berhasil",$berhasil);

}

$katid = $var[4];
$id = $var[4];
$katid = str_replace(".html","",$katid);

$perintah = "select id,nama,ringkas,gambar2,create_date,alias,audio,views,folder,waveform,secid,tags,userid,jmlcomment from tbl_audio where id='$id' and proses='1' and userid='$_SESSION[userid]'";
$hasil = sql($perintah);
$data =  sql_fetch_data($hasil);

$idcontent = $data['id'];
$nama=$data['nama'];
$oleh = $data['oleh'];
$lengkap= $data['lengkap'];
$tanggal = tanggal($data['create_date']);
$gambar = $data['gambar2'];
$ringkas = $data['ringkas'];
$alias = $data['alias'];
$audio = $data['audio'];
$userid = $data['userid'];
$waveform = $data['waveform'];
$youtubeid = $data['youtubeid'];
$views = $data['views'];
$folder = $data['folder'];
$secid = $data['secid'];
$tags = $data['tags'];

if(empty($idcontent)) header("location: $fulldomain");


$tpl->assign("detailid",$idcontent);
$tpl->assign("detailnama",$nama);
$tpl->assign("detailringkas",$ringkas);
$tpl->assign("detailsecid",$secid);
$tpl->assign("detailtags",$tags);
$tpl->assign("detailjenis",$jenis);
$tpl->assign("detailuser",$user);
$tpl->assign("jmlcomment",$jmlcomment);


//kategori
$datakategori = array();
$pkategori = "select secid,nama from tbl_audio_sec order by num desc";
$hkategori = sql($pkategori);
while($dkategori= sql_fetch_data($hkategori))
{
	$datakategori[$dkategori['secid']] = array("secid"=>$dkategori['secid'],"nama"=>$dkategori['nama']);
}
sql_free_result($hkategori);
$tpl->assign("datakategori",$datakategori);
?>