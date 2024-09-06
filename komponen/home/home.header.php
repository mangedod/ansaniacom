<?php 
	/*$sql	= "select id,nama,gambar from tbl_background where published='1' and kanal='$kanal' order by rand() limit 1";
	$query	= sql($sql);
	$row 	= sql_fetch_data($query);
	$header	= $row['gambar'];
	if(!empty($header)){ $header	= "$fulldomain/gambar/background/$header"; }
	else { $header = "$lokasiwebtemplate/images/bg.default.jpg"; }
	$tpl->assign("header",$header);
	sql_free_result($query);
	
	$sql1	= "select id, nama, ringkas from tbl_scroll_text where published='1' order by create_date desc limit 4";
	$res1	= sql($sql1);
	$scroll_text = array();
	while($row1	= sql_fetch_data($res1))
	{
		$id			= $row1['id'];
		$nama		= $row1['nama'];
		$ringkas	= $row1['ringkas'];
		$scroll_text[$id] = array("id"=>$id,"nama"=>$nama,"ringkas"=>$ringkas);
	}
	sql_free_result($res1);
	$tpl->assign("scroll_text",$scroll_text);*/
?>