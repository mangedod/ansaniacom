<?php
$alias = $var[5];

if(empty($alias))
{
	$sql = "SELECT id,nama,alias,lengkap from tbl_panduanbelanja order by id asc limit 1";
}
else
{
	$sql = "SELECT id,nama,alias,lengkap from tbl_panduanbelanja where alias='$alias'";
}
$hsl = sql($sql);
$i = 1;
$listfaq = array();
$row = sql_fetch_data($hsl);
$idfaq      = $row['id'];
$namafaq    = $row['nama'];
$aliasfaq   = $row['alias'];
$lengkapfaq = $row['lengkap'];

$tpl->assign('detailnama',$namafaq);
$tpl->assign('detaillengkap',$lengkapfaq);
	
$sql = "select secid,nama,alias from tbl_panduan_sec order by secid asc";
$hsl = sql($sql);
$i = 1;
$faqsec = array();
while($row = sql_fetch_data($hsl))
{
	$secid      = $row['secid'];
	$namasec    = $row['nama'];
	$aliassec   = $row['alias'];
	$url = "$fulldomain/faq/list/$alias";
	
	$sql2 = "SELECT id,nama,alias,lengkap from tbl_panduanbelanja where secid='$secid' order by id asc";
	$hsl2 = sql($sql2);
	$i = 1;
	$listfaq[$secid] = array();
	while($row2 = sql_fetch_data($hsl2))
	 {
		$idfaq      = $row2['id'];
		$namafaq    = $row2['nama'];
		$aliasfaq   = $row2['alias'];
		$lengkapfaq = $row2['lengkap'];
		
		$urls = "$fulldomain/faq/read/$aliassec/$aliasfaq";
	
		$listfaq[$secid][$idfaq] = array('idfaq'=>$idfaq,'namafaq'=>$namafaq,'aliasfaq'=>$aliasfaq,'lengkapfaq'=>$lengkapfaq,'no'=>$i,"url"=>$urls);
		$i++;
	}


	$faqsec[$secid] = array('secid'=>$idfaq,'namasec'=>$namasec,'url'=>$url,"list"=>$listfaq[$secid]);
	$i++;
}

$tpl->assign('faqsec',$faqsec);


$tpl->display("$kanal.html"); 
?>