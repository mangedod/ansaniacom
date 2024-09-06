<?php
$id = $var[4];
$userid = $var[5];
$katid = str_replace(".html","",$katid);

$pre = sql_get_var("select premium from tbl_member where userid='$userid'");

$perintah = "select id,secid,nama,ringkas,gambar,lengkap,create_date,alias,oleh,views,video,jenis,durasi,premium,youtubeid from tbl_training_materi where id='$id' and published='1'";
$hasil = sql($perintah);

$jml = sql_num_rows($hasil);

if($jml<1)
{
	$result['status']="OK";
	$result['message']="Data Tidak Ditemukan";
	echo json_encode($result);
	exit();
}



$data =  sql_fetch_data($hasil);
$id = $data['id'];
$nama = $data['nama'];
$oleh = $data['oleh'];
$lengkap= $data['lengkap'];
$tanggal = tanggal($data['create_date']);
$gambar = $data['gambar'];
$video = $data['video'];
$ringkas = $data['ringkas'];
$alias = $data['alias'];
$views = $data['views'];
$secid = $data['secid'];
$jenis = $data['jenis'];
$durasi = $data['durasi'];
$premium = $data['premium'];
$youtubeid = $data['youtubeid'];

if($premium)
{
	if($pre==0)
	{
		$result['status']="PRE";
		$result['message']="Mohon maaf materi $nama hanya untuk member premium";
		echo json_encode($result);
		exit();
	}
}



//Sesuaikan dengan path
$lengkap = str_replace("../../","/",$lengkap);

$ringkasshare = str_replace('<br>', "\r", $ringkas);
$ringkasshare = str_replace('<br />', "\r", $ringkasshare);
$ringkasshare = str_replace('<br />', "\r", $ringkasshare);
$ringkasshare = str_replace('&nbsp;', " ", $ringkasshare);
$ringkasshare = strip_tags($ringkasshare);

if(!empty($gambar)) $detailgambar = "$fulldomain/gambar/training/$gambar";
if(!empty($video)) $detailvideo = "$fulldomain/gambar/training/$video";

sql_free_result($hasil);


//			
$user = sql_get_var_row("select username,userfullname from tbl_member where userid='$userid'");
$username = $user['username'];
$userfullname = $user['userfullname'];

$tanggal = date("Y-m-d H:i:s");
$isi = "Baru saja melihat materi <strong>$nama</strong>";
$idbaru 	= newid("postid","tbl_post");

$cek = sql_get_var("select count(*) as jml from tbl_post where userid='$userid' and isi='$isi'");
if($cek<1)
{
	$perintah2	= "insert into tbl_post (postid,userid,username,tousername,touserid,userfullname,touserfullname,isi,tanggal,home,jenis) 
				values ('$idbaru','$userid','$username','$username','$userid','$userfullname','$userfullname','$isi','$tanggal','','4')";
	$hasil2		=  sql($perintah2);
}


// Masukan data kedalam statistik
$stats = number_format($views,0,0,".");

$views = "update tbl_training set views=views+1 where secid='$secid'";
$hsl = sql($views);

$result['status']="OK";
$result['message']="Data berhasil di load";
$result['kategori'] = $namasec;
$result['detailid'] = $secid;
$result['detailnama'] = $nama;
$result['detailgambar'] = $detailgambar;
$result['detailvideo'] = $detailvideo;
$result['detaillengkap'] = $lengkap;
$result['detailringkas'] = $ringkas;
$result['detailringkasshare'] = $ringkasshare;
$result['detailcreator'] = $oleh;
$result['detailtanggal'] = $tanggal;
$result['detailalias'] = $alias;
$result['detailurl'] = $url;
$result['detailjenis'] = $jenis;
$result['detaildurasi'] = $durasi;
$result['detailyoutubeid'] = $youtubeid;

$perintah2	= "select  id,ringkas,nama,create_date,alias,gambar,gambar1,jenis,durasi,premium,youtubeid from tbl_training_materi where secid='$secid' and published='1' order by id asc";
$hasil2		= sql($perintah2);
$daftarmateri	= array();
$no = 1;
while($data2 = sql_fetch_data($hasil2))
{
	$tanggal = $data2['create_date'];
	$nama = $data2['nama'];
	$id = $data2['id'];
	$ringkas = $data2['ringkas'];
	$alias = $data2['alias'];
	$tanggal = tanggal($tanggal);
	$jenis = $data2['jenis'];
	$durasi = $data2['durasi'];
	$gambar = $data2['gambar'];
	$gambar1 = $data2['gambar1'];
	$premium = $data2['premium'];
	$youtubeid = $data2['youtubeid'];
	
	if(empty($youtubeid)) $jenis = "video";
	
	$views = number_format($data['views'],0,",",".");
	
	
	if(!empty($gambar)) $gambar = "$domain/gambar/training/$gambar";
	 else $gambar = "$fulldomain/images/noimages.jpg";
	 
	$linkdetail = "$fulldomain/member/training/join/$secid/$alias/$id";
	 
	$daftarmateri[] = array("id"=>$id,"no"=>$no,"youtubeid"=>$youtubeid,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"jmlmateri"=>$jmlmateri,"durasi"=>$durasi,"jenis"=>$jenis,"gambar"=>$gambar,"premium"=>$premium);
	$no++;
}
sql_free_result($hasil2);
	
$result['detailmateri'] = $daftarmateri;
echo json_encode($result);
?>
