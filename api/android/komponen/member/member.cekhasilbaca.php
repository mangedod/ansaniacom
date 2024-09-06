<?php
$bukuid = $_POST['bukuid'];
$userid = $_POST['userid'];
$nomor = $_POST['nomor'];
$jawabanid = $_POST['jawabanid'];

if(!empty($jawabanid))
{
	$jawab = base64_decode($jawabanid);
	$dt = explode("--",$jawab);
	$soalids = $dt[0];
	$jids = $dt[1];
	$bukuids = $dt[2];
	$userids = $dt[3];
	
	//Cek Benar
	$cek = sql_get_var("select kunci from tbl_soal_jawaban where id='$soalids' and jawabanid='$jids'");
	if($cek=="1") $benar = 1;
	else $benar  = 0;
	
	sql("update tbl_peserta set benar='$benar',jawaban='$jids' where bukuid='$bukuids' and soalid='$soalids' and userid='$userids'");
	
	$data = date('Y-m-d H:i:s')." | update tbl_peserta set benar='$benar',jawaban='$jids' where bukuid='$bukuids' and soalid='$soalids' and userid='$userids'\r\n";
	$file = "backlog.txt";
	$open = fopen($file, "a+"); 
	fwrite($open, "$data"); 
	fclose($open);

}

$cek = sql_get_var_row("select soalid,benar,jawabanid,jawaban from tbl_peserta where userid='$userid' and bukuid='$bukuid'");
$soalid = $cek['soalid'];
$dijawab = $cek['jawaban'];
$benar = $cek['benar'];

if(empty($soalid) && !empty($userid) && !empty($bukuid))
{
	$data = date('Y-m-d H:i:s')." | Input Pertanyaan\r\n";
	$file = "backlog.txt";
	$open = fopen($file, "a+"); 
	fwrite($open, "$data"); 
	fclose($open);
	
	//Tampilkan Soal
	$sql = "select id,pertanyaan,materi from tbl_soal where bukuid='$bukuid' order by rand() limit 10";
	$hsl = sql($sql);
	while($data = sql_fetch_data($hsl))
	{
		$pertanyaan = $data['pertanyaan'];
		$id = $data['id'];
		$materi = $data['materi'];
		
		$alfa = array("A","B","C","D");
		$sql3 = "select jawabanid,jawaban from tbl_soal_jawaban where id='$id' order by rand() limit 4";
		$hsl3 = sql($sql3);
		$a = 0;
		
		while($data3 = sql_fetch_data($hsl3))
		{
			$jawabanid = $data3['jawabanid'];
			$jawaban =  $data3['jawaban'];
			
			$hash = base64_encode("$id--$jawabanid--$bukuid--$userid");
			
			$jawabans[] = array("alfabet"=>$alfa[$a],"hash"=>$hash,"jawabanid"=>$jawabanid,"jawaban"=>$jawaban);
			
			$jawab[] = array("alfabet"=>$alfa[$a],"jawabanid"=>$jawabanid);
			$jawabans1 = serialize($jawab);
			$a++;
		}
		
		$sql2 = "insert into tbl_peserta(userid,userfullname,soalid,bukuid,jawabanid,jawaban,create_date) values('$userid','$_SESSION[userfullname]','$id','$bukuid','$jawabans1','',now())";
		$sql2 = sql($sql2);
		unset($jawab,$jawabans);
	}


}

if(empty($nomor)) { $nomor = 1; $lim = $nomor-1; }

//Tampilkan Soal
$sql = "select soalid,jawabanid  from tbl_peserta where userid='$userid' and bukuid='$bukuid' and jawaban='0' limit 1";
$hsl = sql($sql);
$data = sql_fetch_data($hsl);
$soalid = $data['soalid'];
$jawabanid = $data['jawabanid'];

$pertanyaan = sql_get_var("select pertanyaan from tbl_soal where id='$soalid'");


$jw = unserialize($jawabanid);

$alfa = array("A","B","C","D");
for($i=0;$i<count($jw);$i++)
{
	$row = $jw[$i];
	$jawabanid = $row['jawabanid'];
	$jawaban = sql_get_var("select jawaban from tbl_soal_jawaban where id='$soalid' and jawabanid='$jawabanid'");
	
	$hash = base64_encode("$soalid--$jawabanid--$bukuid--$userid");
	
	$jawabans[] = array("alfabet"=>$row['alfabet'],"hash"=>$hash,"jawabanid"=>$jawabanid,"jawaban"=>$jawaban);
	
}

if(!empty($pertanyaan)) { $jmlsoal = 1; }
else $jmlsoal = 0;

$sisa = sql_get_var("select count(*) as jml from tbl_peserta where userid='$userid' and bukuid='$bukuid' and jawaban='0'");
if($sisa<1)
{
	$benar = sql_get_var("select count(*) as jml from tbl_peserta where userid='$userid' and bukuid='$bukuid' and benar='1'");
	$jsoal = sql_get_var("select count(*) as jml from tbl_peserta where userid='$userid' and bukuid='$bukuid'");
	
	if($jsoal>1)
	{
	
		$presentase = ($benar/$jsoal)*100;
		if($presentase>80)
		{
			$hasil = "Telah Membaca Dengan Sangat Baik";
		}
		elseif($presentase>=60 && $presentase<=80)
		{
			$hasil = "Telah Membaca Dengan Baik";
		}
		elseif($presentase>=30 && $presentase<=60)
		{
			$hasil = "Telah Membaca Kurang Baik";
		}
		else
		{
			$hasil = "Belum Pernah Membaca";
		}
		$presentase = number_format($presentase,0,0,"");
		$result['poin'] = $presentase;
		$result['hasil'] = $hasil;
	}
}

$data = date('Y-m-d H:i:s')." | $jmlsoal\r\n";
$file = "backlog.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);


$result['status']="OK";
$rerult['jmlsoal'] = $jmlsoal;
$result['bukuid']= $bukuid;
$result['message']="Data berhasil di load";
$result['pertanyaan']= $pertanyaan;
$result['jawabans'] = $jawabans;
$result['nomor'] = $nomor;

	
echo json_encode($result);

?>