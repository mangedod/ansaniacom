<?php 
//Kategori Direktori
$mysql = "select secid,namasec,alias from tbl_product_sec order by secid asc";
$hasil = sql( $mysql);

$productsec = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$namasec = $data['namasec'];
	$secids = $data['secid'];
	$alias = $data['alias'];
	$smallicon = $data['smallicon'];

		$urlsec = "$fulldomain/product/category/$alias";
	
		//Sub Kategori Direktori
		$mysql2 = "select subid,namasub,alias from tbl_product_sub where secid='$secids' order by subid  asc";
		$hasil2 = sql($mysql2);
		
		$productsub = array();		
		while ($dt =  sql_fetch_data($hasil2)) {	
			$namasub = $dt['namasub'];
			$subids = $dt['subid'];
			$aliassub = $dt['alias'];
		
			$urlsub = "$fulldomain/product/cat/$alias/$aliassub";
			
				
			$productsub[] = array("subid"=>$subids,"namasub"=>$namasub,"urlsub"=>$urlsub);
		}
		sql_free_result($hasil2);
	
		
	$productsec[] = array("secid"=>$secids,"namasec"=>$namasec,"urlsec"=>$urlsec,"sub"=>$productsub,"icon"=>$smallicon);
	$i++;
	unset($productsub);
		
}
sql_free_result($hasil);

$result['status']="OK";
$result['message']="Data berhasil di load";
$result['halaman']= $hlm;
$result['section'] = $productsec;
$result['stringpage'] = $stringpage;
	
echo json_encode($result);

?>