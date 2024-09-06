<?php 
$tanggal = date("Y-m-d");
//Tampilkan Soal
$sql = "select id,pertanyaan from tbl_kuis_soal where tanggal='$tanggal'";
$hsl = sql($sql);
$data = sql_fetch_data($hsl);
$pertanyaan = $data['pertanyaan'];
$soalid = $data['id'];
$materi = $data['materi'];

$alfa = array("A","B","C","D");
$a = 0;
$k = 1;
$jawabanss = sql("select jawaban,kunci,jawabanid from tbl_kuis_soal_jawaban where id='$soalid'  order by rand()");
while($dt=sql_fetch_data($jawabanss))
{
	$jawabanid = $dt['jawabanid'];

	$jawaban = $dt['jawaban'];
	$kunci = $dt['kunci'];
	
	
	$hash = base64_encode("$soalid++$jawabanid++$tanggal");
	
	$jawabans[] = array("alfabet"=>$alfa[$a],"hash"=>$hash,"jawabanid"=>$jawabanid,"jawaban"=>$jawaban,"hide"=>$hide);
	$a++;
	
}


$result['status']="OK";
$result['message']="Data berhasil di load";
$result['pertanyaan'] = $pertanyaan;
$result['jawaban'] = $jawabans;
$result['stringpage'] = $stringpage;
	
echo json_encode($result);
	
?>
