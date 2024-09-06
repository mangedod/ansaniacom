<?php 
/*$userName=$_SESSION[userName];
$tpl->assign("userName",$userName);
$avatarP= getAvatarName($_SESSION[userName]);
$tpl->assign("avatarP",$avatarP);

//data profil
$sql			= "select userFullName,aboutme,userDOB,negaraId,userGender from tbl_member where userName='$userName'";
$hsl			= mysql_query($sql);
$row			= mysql_fetch_object($hsl);
$userFullName	= $row->userFullName;
$userDOB		= $row->userDOB;
$tanggalLahir	= tanggalLahir($userDOB);
$tahunLahir		= substr($userDOB,0,4);
$umur			= date("Y") - $tahunLahir;
$negaraId		= $row->negaraId;
$negara			= getNegara($negaraId);
$userGender		= $row->userGender;
$userId			= $_SESSION[userId];
$link 			= getAvatarL($userId);
$tpl->assign("tanggalLahir",$tanggalLahir);
$tpl->assign("umur",$umur);
$tpl->assign("userFullName",$userFullName);
$tpl->assign("negara",$negara);
$tpl->assign("userGender",$userGender);
$tpl->assign("link",$link);*/

// data news member
	$nm	= "select id,nama,ringkas,create_date,gambar,alias,secid from tbl_blog where published='1' order by create_date desc limit 2";
	$qn	= sql($nm);
	$dtnews	= array();
	while($rn = sql_fetch_data($qn))
	{
		$tanggal = $rn['create_date'];
		$nama = $rn['nama'];
		$id = $rn['id'];
		$ringkas = $rn['ringkas'];
		$alias = $rn['alias'];
		$tanggal = tanggal($tanggal);
		$gambar = $rn['gambar'];
		$gambar1 = $rn['gambar1'];
		$secid = $rn['secid'];
		
		$perintah = "select alias,nama from tbl_blog_sec where secid='$secid'";
		$res = sql($perintah);
		$dt =  sql_fetch_data($res);
		$secalias1 = $dt['alias'];
		$namasec = $dt['nama'];
		sql_free_result($res);
		
		if($i==0){ $gambar= $gambar1; }
		else { $gambar = $gambar; }
		
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/blog/$gambar";
		 else $gambar = "";
			 
	
		$link = "$fulldomain/blog/read/$secalias1/$id/$alias";
		$urlsec = "$fulldomain/blog/list/$secalias1";
			
		$dtnews[$id] = array("id"=>$id,"no"=>$i,"namasec"=>$namasec,"urlsec"=>$urlsec,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
		$i++;
	}
	sql_free_result($qn);
	$tpl->assign("dtnews",$dtnews);
	
	// data transaksi
	$sql1 	= "select transaksiid, invoiceid, orderid, pembayaran, pengiriman, tanggaltransaksi, batastransfer, totaltagihan, totaltagihanafterdiskon, ongkoskirim, status from tbl_transaksi where userid='$_SESSION[userid]' and status != '0' order by transaksiid desc limit 5";
	$hsl1 	= sql($sql1);
	$listtransaksi	= array();
	$no	= 1;
	while ($row1 = sql_fetch_data($hsl1))
	{
		$transaksiid		= $row1['transaksiid'];
		$invoiceid			= $row1['invoiceid'];
		$orderid			= $row1['orderid'];
		$pembayaran			= $row1['pembayaran'];
		$pengiriman			= $row1['pengiriman'];
		$tanggaltransaksi	= tanggal($row1['tanggaltransaksi']);
		$batastransfer		= tanggal($row1['batastransfer']);
		$totaltagihan		= $row1['totaltagihan'];
		$totaltagihanafterdiskon	= $row1['totaltagihanafterdiskon'];
		$ongkoskirim		= $row1['ongkoskirim'];
		$status				= $row1['status'];
		
		if($totaltagihanafterdiskon==0)
			$totaltagihanakhir = $totaltagihan;
		else
			$totaltagihanakhir = $totaltagihanafterdiskon;
			
		$total_bayar 		= "IDR. ".number_format($totaltagihanakhir,0,".",".");
		
		$kodeinvoice = base64_encode($invoiceid);
		
		$link = "$fulldomain/cart/confirm/$kodeinvoice";
		
		if($status=="0") $stat = "Keranjang";
		elseif($status=="1") $stat = "Invoice";
		elseif($status=="2") $stat = "Konfirmasi";
		elseif($status=="3") $stat = "Lunas";
		elseif($status=="4") $stat = "Terkirim";
		elseif($status=="5") $stat = "Batal";
		
		$urldetail = "$fulldomain/cart/detailinvoice/$invoiceid"; 
		
		/*if($pembayaran == "COD")
			$pembayaran = "Cash On Delivery";
		elseif($pembayaran == "Transfer")
			$pembayaran = "Transfer Bank";
		elseif($pembayaran == "klikbca")
			$pembayaran = "BCA KlikPay";
		else
			$pembayaran = sql_get_var("select nama from tbl_payment_method where paymentid='$pembayaran'");*/
		
		$listtransaksi[$transaksiid] = array("transaksiid"=>$transaksiid,"invoiceid"=>$invoiceid,"status"=>$status,"stat"=>$stat,"pembayaran"=>$pembayaran,"link"=>$link,
					"tanggaltransaksi"=>$tanggaltransaksi,"total_bayar"=>$total_bayar,"urldetail"=>$urldetail,"no"=>$no);
		$no++;
	}
	sql_free_result($hsl1);
	$tpl->assign("listtransaksi",$listtransaksi);

?>