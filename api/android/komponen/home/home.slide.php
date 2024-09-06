<?php
$query = "select id,gambar,url FROM tbl_slide_mobile where published='1' order by id asc";
$hsl   = sql($query);
$no = 1;
$a = 0;
while ($row = sql_fetch_data($hsl))
{
	$ids      = $row['id'];
	$url = $row['url'];
	$gambar = $row['gambar'];
	
	if(!empty($gambar)) 
	{
		$gambar = "$fulldomain/gambar/slidemobile/$gambar";
		$slide[$ids] = array("id"=>$ids,"no"=>$no, "gambar"=>$gambar);
		$no++;
		$a++;
	}
	
}
$result['status'] = "OK";
$result['message'] = "Data  berhasil diload";
$result['jmlgambar'] = $a;
$result['slide'] = $slide;

echo json_encode($result); 

?>