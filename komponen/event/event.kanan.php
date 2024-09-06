<?php
$mysql = "select id,nama,organizer,lokasievent,tanggalevent,waktuevent,alias,gambar,gambar1,create_date,create_userid,update_date,update_userid from tbl_event where published='1' order by create_date desc limit 1";
$hasil = sql($mysql);

$eventkanan = array();
$a =1;
while ($data = sql_fetch_data($hasil)) {	
		$tanggal      = $data['create_date'];
		$tanggalevent = $data['tanggalevent'];
		$nama         = $data['nama'];
		$ids          = $data['id'];
		$organizer    = $data['organizer'];
		$lokasievent  = $data['lokasievent'];
		$alias        = $data['alias'];
		$tanggalevent = tanggaltok_english($tanggalevent);
		$gambar       = $data['gambar'];
		$waktuevent   = $data['waktuevent'];

	
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/event/$gambar";
			 else $gambar = "";
		$link = "$fulldomain"."event/read/$ids/$alias";
			
		$eventkanan[$ids] = array("id"=>$ids,"no"=>$a,"nama"=>$nama,"organizer"=>$organizer,"lokasievent"=>$lokasievent,"tanggalevent"=>$tanggalevent,"waktuevent"=>$waktuevent,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
		$a++;	
}
$a = 0;
sql_free_result($hasil);
$tpl->assign("eventkanan",$eventkanan);

?>