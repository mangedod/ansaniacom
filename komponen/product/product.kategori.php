<?php
	// Kategori Produk
	$sql1		= "select secid,namasec,alias from tbl_product_sec order by secid asc";
	$query1		= sql($sql1);
	$list_sec	= array();
	$nokateg 	= 1;
	$jumkateg	= sql_num_rows($query1);
	while($row1 = sql_fetch_data($query1))
	{
		$secid		= $row1['secid'];
		$nama		= $row1["namasec"];
		$aliassec	= $row1['alias'];
		$url_sec	= "$fulldomain/product/list/$aliassec.html";
		
		$sql2		= "select subid, namasub, alias from tbl_product_sub where secid='$secid' order by subid asc";
		$query2		= sql($sql2);
		$numsubtoko	= sql_num_rows($query2);
		$nosub 		= 1;
		$i	 		= 1;
		$jumsub 	= sql_num_rows($query2);
		while($row2 = sql_fetch_data($query2))
		{
			$subid		= $row2['subid'];
			$namasub	= $row2["namasub"];
			$aliassub	= $row2['alias'];
			$url_sub	= "$fulldomain/product/list/$aliassec/$aliassub.html";
			
			$list_sub[$secid][$subid]	= array("subid"=>$subid,"namasub"=>$namasub,"url_sub"=>$url_sub,"nosub"=>$nosub,"i"=>$i);
			$i %= 2;
			$i++;
			$nosub++;
		}
		sql_free_result($query2);
		$list_sec[$secid]	= array("secid"=>$secid,"nama"=>$nama,"url_sec"=>$url_sec,"nokateg"=>$nokateg,"jumsub"=>$jumsub,"numsubtoko"=>$numsubtoko);
		$nokateg++;
	}
	sql_free_result($query1);
	$tpl->assign("list_sec",$list_sec);
?>