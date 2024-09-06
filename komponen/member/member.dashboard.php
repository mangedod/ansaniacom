<?php 
	// data transaksi
	$sql1 	= "select transaksiid, invoiceid, orderid, pembayaran, pengiriman, tanggaltransaksi, batastransfer, totaltagihan, totaltagihanafterdiskon, ongkoskirim, status from tbl_transaksi where userid='$_SESSION[userid]' and status != '0' order by transaksiid desc limit 5";
	$hsl1 	= sql($sql1);
	$jmldttrans = sql_num_rows($hsl1);
	// $listtransaksi	= array();
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
		elseif($status=="4") $stat = "<label class=\"label label-info\">Delivered</label>";
		elseif($status=="5") $stat = "<label class=\"label label-danger\">Cancel</label>";
		elseif($status=="6") $stat = "<label class=\"label label-danger\">Canceled</label>";
		
		$urldetail = "$fulldomain"."/cart/detailinvoice/$invoiceid"; 
		
		$listtransaksi[$transaksiid] = array("transaksiid"=>$transaksiid,"invoiceid"=>$invoiceid,"status"=>$status,"stat"=>$stat,"pembayaran"=>$pembayaran,"link"=>$link,
					"tanggaltransaksi"=>$tanggaltransaksi,"total_bayar"=>$total_bayar,"urldetail"=>$urldetail,"no"=>$no);
		$no++;
	}
	sql_free_result($hsl1);
	$tpl->assign("jmldttrans",$jmldttrans);
	$tpl->assign("dttransdashboard",$listtransaksi);
?>