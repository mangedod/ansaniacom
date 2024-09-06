<?php
	// Kategori Produk
	$sql1		= "select secid,namasec,alias from tbl_ticketing_sec order by secid asc";
	$query1		= sql($sql1);
	$ticket_sec	= array();
	while($row1 = sql_fetch_data($query1))
	{
		$secid		= $row1['secid'];
		$nama		= $row1["namasec"];
		$aliassec	= $row1['alias'];
		
		$ticket_sec[$secid]	= array("secid"=>$secid,"nama"=>$nama);
	}
	sql_free_result($query1);
		
	$tpl->assign("ticket_sec",$ticket_sec);
	$tpl->assign("namarubrik","Tambah Ticketing");
?>