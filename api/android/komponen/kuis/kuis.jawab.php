<?php
$id = $var[5];
$userid = $var[4];
$katid = str_replace(".html","",$katid);

$jawaban = base64_decode($id);

$jawab = explode("++",$jawaban);
$jawabs = $jawab[1];
$tanggal =  $jawab[2];
$soalid =  $jawab[0];

$cek = sql_get_var("select count(*) as jml from tbl_kuis_peserta where userid='$userid' and tanggal='$tanggal'");

if(!empty($cek))
{
	$msg = "Mohon maaf, anda tidak bisa mengikuti kuis secara berulang-ulang dihari yang sama, silahkan coba kembali untuk
	mengikuti kuis esok hari";
	$error = 1;
}
else
{

	$soalid = sql_get_var("select id from tbl_kuis_soal where tanggal='$tanggal'");
	$kunci = sql_get_var("select kunci from tbl_kuis_soal_jawaban where id='$soalid' and jawabanid='$jawabs'");
	
	if($kunci==1)
	{
		$benar = 1;
		
		earnpoin("kuis-harian",$userid);
			
		$msg = "Selamat, anda menjawab pertanyaan kuis hari ini dengan benar dan anda berhak mendapatkan tambahan poin. Kumpulkan poin sebanyak-banyaknya
		dan tukarkan dengan banyak hadiah menarik dari dfun Station";
		$error = 0;
	}
	else
	{
		$benar = 0;
			
		$msg = "Sayang sekali, jawaban anda salah untuk pertanyaan kuis hari ini, silahkan coba kuis dan pertanyaan esok hari. Kumpulkan poin sebanyak-banyaknya
		dan tukarkan dengan banyak hadiah menarik dari dfun Station";
		$error = 1;
	}
	
	$sql = "insert into tbl_kuis_peserta(userid,tanggal,jawabanid,benar) values('$userid','$tanggal','$jawabs','$benar')";
	$sql = sql($sql);


}


$result['status']="OK";
$result['message']= $msg;
echo json_encode($result);
?>
