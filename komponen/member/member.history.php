<?php
$nama_aksi 	= "Order History";
$deskripsiaksi 	= "History your transaction";
$tpl->assign("namaaksi",$nama_aksi);
$tpl->assign("deskripsiaksi",$deskripsiaksi);

	$judul_per_hlm	= 10;
	$batas_paging 	= 5;
	$hlm 			= $var[4];
	
	$sql = "select count(*) as jml from tbl_transaksi where userid='$_SESSION[userid]'";
	$hsl = sql($sql);
	$tot = sql_result($hsl, 0,'jml');
	$hlm_tot = ceil($tot / $judul_per_hlm);		
	if (empty($hlm)){
		$hlm = 1;
		}
	if ($hlm > $hlm_tot){
		$hlm = $hlm_tot;
		}
	
	$ord = ($hlm - 1) * $judul_per_hlm;
	if ($ord < 0 ) $ord=0;
	$tpl->assign("totalhis",$tot);
	$tpl->assign("hlm_tot",$hlm_tot);
	$tpl->assign("hlm",$hlm);
	$tpl->assign("judul_per_hlm",$judul_per_hlm);
		
	$sql1 	= "select transaksiid, invoiceid, orderid, pembayaran, pengiriman, tanggaltransaksi, batastransfer, totaltagihan, totaltagihanafterdiskon, ongkoskirim, status from tbl_transaksi where userid='$_SESSION[userid]' and status != '0' order by transaksiid desc limit $ord, $judul_per_hlm";
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
		$tanggaltransaksi	= tanggal_english($row1['tanggaltransaksi']);
		$batastransfer		= tanggal_english($row1['batastransfer']);
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
		
		$link = "$fulldomain"."/cart/confirm/$kodeinvoice";
		
		if($status=="0") $stat = "<label class=\"label label-info\">Cart</label>";
		elseif($status=="1") $stat = "<label class=\"label label-warning\">Invoice</label>";
		elseif($status=="2") $stat = "<label class=\"label label-success\">Confirm</label>";
		elseif($status=="3") $stat = "<label class=\"label label-success\">Paid</label>";
		elseif($status=="4") $stat = "<label class=\"label label-info\">Shipped</label>";
		elseif($status=="5") $stat = "<label class=\"label label-danger\">Cancel</label>";
		elseif($status=="6") $stat = "<label class=\"label label-danger\">Canceled</label>";
		
		if($pembayaran == "COD"){
			$pembayarannya = "Cash On Delivery";
		}
		elseif($pembayaran == "Transfer"){
			$pembayarannya = "Manual Bank Transfer";
		}
		elseif($pembayaran == "BankTransfer"){
			$pembayarannya = "ATM (Virtual Account)";
		}
		elseif($pembayaran == "CreditCard"){
			$pembayarannya = "Credit Card";
		}
		elseif($pembayaran == "CreditCard-Cicilan"){
			$pembayarannya = "Credit Card Cicilan";
		}
		/*elseif($pembayaran == "klikbca"){
			$pembayarannya == "BCA KlikPay";
		}
		else{
			$pembayarannya = sql_get_var("select nama from tbl_payment_method where paymentid='$pembayaran'");
		}*/
		
		$urldetail = "$fulldomain"."/cart/detailinvoice/$invoiceid";
		
		$listtransaksi[$transaksiid] = array("transaksiid"=>$transaksiid,"invoiceid"=>$invoiceid,"status"=>$status,"stat"=>$stat,"pembayaran"=>$pembayaran,"pembayarannya"=>$pembayarannya,"link"=>$link,
					"tanggaltransaksi"=>$tanggaltransaksi,"total_bayar"=>$total_bayar,"urldetail"=>$urldetail,"no"=>$no);
		$no++;
	}
	sql_free_result($hsl1);
	$tpl->assign("listtransaksi",$listtransaksi);

	//Paging
	$batas_page = 5;
	$stringpage = array();
	$pageid 	= 0;

	if ($hlm > 1){
		$prev = $hlm - 1;
		$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"$fulldomain"."/member/history/1");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"&lsaquo;","link"=>"$fulldomain"."/member/history/$prev");

	}
	else {
		$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"&lsaquo;","link"=>"");
	}

	$hlm2 = $hlm - (ceil($batas_page/2));
	$hlm4= $hlm+(ceil($batas_page/2));

	if($hlm2 <= 0 ) $hlm3=1;
	   else $hlm3 = $hlm2;
	$pageid++;
	for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
		if ($ii==$hlm){
			$stringpage[$pageid] = array("nama"=>"$ii","link"=>"","class"=>"active");
		}else{
			$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain"."/member/history/$ii");
		}
		$pageid++;
	}
	if ($hlm < $hlm_tot){
		$next = $hlm + 1;
		$stringpage[$pageid] = array("nama"=>"&rsaquo;","link"=>"$fulldomain"."/member/history/$next");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"$fulldomain"."/member/history/$hlm_tot");
	}
	else
	{
		$stringpage[$pageid] = array("nama"=>"&rsaquo;","link"=>"");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"");
	}

	$tpl->assign("stringpage",$stringpage);
?>