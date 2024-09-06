<?php
$katid = str_replace(".html","",$katid);

if(!empty($katid))
{
	$perintah1 = "select * from tbl_$kanal"."_sec where alias='$katid'";
	$hasil1 = sql($perintah1);
	$row1 = sql_fetch_data($hasil1);
	$namasec = $row1['nama'];
	$secid = $row1['secid'];
	$secalias = $row1['alias'];
	$where = "and secid='$secid'";
	$rubrik = "$namasec";
	$tpl->assign("rubrik","$rubrik");
	$tpl->assign("arsip","$fulldomain/artikel/arsip/$secalias/");
}
else
{
	$secalias = "global";
	$tpl->assign("rubrik","$rubrik");
	$tpl->assign("arsip","$fulldomain/artikel/arsip/$secalias/");
}
$perintah = "select id,nama,oleh,ringkas,lengkap,gambar1,gambar,create_date,alias,views,tags,userid from tbl_$kanal where published='1' and id='$id'  and (userid='0' or userid='$contactid')";
$hasil = sql($perintah);
$data =  sql_fetch_data($hasil);

$idcontent = $data['id'];
$nama=$data['nama'];
$oleh = $data['oleh'];
$lengkap= $data['lengkap'];
$tanggal = tanggal($data['create_date']);
$gambar = $data['gambar1'];
$gambarshare = $data['gambar'];
$ringkas = $data['ringkas'];
$alias = $data['alias'];
$views = $data['views'];
$tag = $data['tags'];
$penulisid = $data['userid'];

$t = explode(",",$tag);
$tags = array();
for($c=0;$c<count($t);$c++)
{
	$tags[$c] = array("tagid"=>$c,"tag"=>trim($t[$c]),"url"=>"$fulldomain/$kanal/tag/".urlencode(trim($t[$c])));
}
$tpl->assign("tags",$tags);


if(empty($katid)) $katid="0";

//Sesuaikan dengan path
$lengkap = str_replace("jscripts/tiny_mce/plugins/emotions","$domain/plugin/emotion",$lengkap);
$lengkap = str_replace("../../","/",$lengkap);


if(empty($oleh))
{
	$oleh = sql_get_var("select userfullname from tbl_member where userid='$penulisid'");
}

$tpl->assign("detailid",$idcontent);
$tpl->assign("detailnama",$nama);
$tpl->assign("detaillengkap",$lengkap);
$tpl->assign("detailringkas",$ringkas);
$tpl->assign("detailcreator",$oleh);
$tpl->assign("detailtanggal",$tanggal);


if(!empty($gambar)) $tpl->assign("detailgambar","$fulldomain/gambar/$kanal/$gambar");
if(!empty($gambarshare)) $tpl->assign("detailgambarshare","$fulldomain/gambar/$kanal/$gambarshare");


//assign fasilitas penunjang
if($fasilitasprint) $tpl->assign("urlprint","$fulldomain/$kanal/print/$katid/$idcontent");
if($fasilitaspdf) $tpl->assign("urlpdf","$fulldomain/$kanal/pdf/$katid/$idcontent");
if($fasilitasemail) $tpl->assign("urlemail","$fulldomain/$kanal/kirim/$katid/$idcontent");
if($fasilitasarsip) $tpl->assign("urlarsip","$fulldomain/$kanal/arsip/$secalias");
if($fasilitasrss) $tpl->assign("urlrss","$fulldomain/$kanal/rss");

sql_free_result($hasil);

	//Add Comment
	if($_POST['aksi'] == 1)
	{
		$blogid   = $_POST['blogid'];
		$postUser = $_POST['postUser'];
		$namanya  = $_POST['nama'];
		$emailnya = $_POST['email'];
		$komentar = bersih($_POST['isi']);
		$tanggal  = date("Y-m-d H:i:s");
		
		$perintahk = "insert into tbl_blog_komen(blogid,nama,email,isi,tanggal) values ('$blogid', '$namanya', '$emailnya', '$komentar', '$tanggal')";
		/*echo "hasil query ".$perintahk;
		die();*/
		$hasilk    = sql($perintahk);
		if($hasilk)
		{
			$prnth	= "update tbl_blog set jmlkomen=jmlkomen+1 where id='$blogid'";
			$re		=  sql($prnth);

			//Setlog kedalam Sistem
			// setsyslog($postUserid,"0","$_SESSION[userFullName] berkomentar di Komentar News","index.php?tab=22&tabsub=128&kanal=komentar-news");
		}
	}
	//comment
	$sql       = "select komenblogid,blogid,nama,email,isi,tanggal from tbl_blog_komen where blogid='$idcontent' and status='1' order by tanggal desc";
	$hslkom       = sql($sql);
	$jml_komen = sql_num_rows($hslkom);
	while($row = sql_fetch_data($hslkom))
	{
		$komenblogid = $row['komenblogid'];
		$blogid2     = $row['blogid'];
		$namakom     = $row['nama'];
		$emailkom    = $row['email'];
		
		$komentar = geturl(trim($row['isi']));
		$jmlkom   = strlen($komentar);

		$ttggll		= $row['tanggal'];
		$skr		= date("Y-m-d");
		
		//explode tanggal
		$tgl1		= explode(" ",$ttggll);
		$tegeel1	= $tgl1[0];
		$tegeel2	= tanggalonly($tegeel1);
		$jam1		= $tgl1[1];
		$jam2		= $jam1;
		//explode waktu
		$time1		= explode(":",$jam2);
		$tm11		= $time1[0];
		$tm22		= $time1[1];
		$tm32		= $time1[2];

		if($tm11>12)
			$ket1	= "pm";
		else
			$ket1	= "am";
		
		if($tegeel1==$skr)
			$tgltampil1	= $tm11.":".$tm22;
		else
			$tgltampil1	= $tegeel2." at ".$tm11.":".$tm22;
		
		$datakomen[$komenblogid] = array("komenblogid"=>$komenblogid,"nama"=>$namakom,"emailnya"=>$emailkom,"komentar"=>$komentar,"tgltampil1"=>$tgltampil1,
									"via"=>$cvia);
	}
	sql_free_result($hslkom);
	
	$tpl->assign("datakomen",$datakomen);
	$tpl->assign("jml_komen",$jml_komen);

// Masukan data kedalam statistik
$stats = number_format($views,0,0,".");
$tpl->assign("detailstats",$stats);
$view = 1;

$views = "update tbl_$kanal set views=views+1 where id='$id'";
$hsl = sql($views);


//Berita Pilihan
$mysql = "select id,ringkas,nama,create_date,alias,gambar,secid from tbl_$kanal where published='1' and id!='$id' and (userid='0' or userid='$contactid') order by rand() limit 4";
$hasil = sql($mysql);

$datapilihan = array();
$a =1;
while ($data = sql_fetch_data($hasil)) {	
		$tanggal = $data['create_date'];
		$nama = $data['nama'];
		$id = $data['id'];
		$ringkas = $data['ringkas'];
		$alias = $data['alias'];
		$tanggal = tanggal($tanggal);
		$gambar = $data['gambar'];
		$secid = $data['secid'];
		
		
		$mysql1 = "select nama,alias,secid from tbl_$kanal"."_sec where secid='$secid'";
		$hasil1 = sql($mysql1);
		$data1 = sql_fetch_data($hasil1);
		$secalias = $data1['alias'];

	
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/$kanal/$gambar";
			 else $gambar = "";
		$link = "$fulldomain/$kanal/read/$secalias/$id/$alias";
			
		$datapilihan[$id] = array("id"=>$id,"a"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"namasec"=>$namasec,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
		$a++;	
}
$a = 0;
sql_free_result($hasil);
$tpl->assign("terkait",$datapilihan);
?>
