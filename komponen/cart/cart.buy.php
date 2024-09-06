<?php
$tipeid             = sql_get_var("SELECT tipeid FROM tbl_product_tipe WHERE nama='Reguler'");
$_SESSION['tipeid'] = $tipeid;

$produkpostid         = $_POST['produkpostid'];
$qty             = $_POST['qty'];
$id_qty          = $_POST['id_qty'];


$date = date("Y-m-d H:i:s");

if(empty($_SESSION['orderid']))
{
	$orderid = "ANS".date("U");
	$_SESSION['orderid'] = $orderid;
}

if(isset($produkpostid))
{	
	$stokawal    = sql_get_var("select totalstok from tbl_product_total where produkpostid='$produkpostid'");
	$stokonhold  = sql_get_var("select sum(jumlah) from tbl_product_stokonhold where produkpostid='$produkpostid' and status='0'");
	$namaprod    = sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");
	
	$stokakhir	= $stokawal-$stokonhold;//echo $stokakhir;
	
	if($qty > $stokakhir)
	{
		$benar = false;
		
	}
	else
		$benar = true;
		
	if($benar)
	{			
		$sql = "select title,misc_harga,body_weight,misc_diskon,misc_matauang from tbl_product_post where produkpostid = '$produkpostid'";
		$hsl = sql($sql);
		$row = sql_fetch_data($hsl);
		$title              = $row["title"];
		$berat              = $row['body_weight'];
		$diskon             = $row['misc_diskon'];
		$matauang           = $row['misc_matauang'];
		$harga              = $row['misc_harga'];

		$sDiskon		= 0;
		$hDiskon		= 0;
		if($diskon!=0)
		{
			$harga			= $diskon;
		}
			
		$berat 	= $berat * $qty;
		$total 	= $harga * $qty;

		sql_free_result($hsl);
		
		// Input kedalam database
		$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where orderid='$_SESSION[orderid]'");
		if (empty($transaksiid))
		{
			$new = newid("transaksiid","tbl_transaksi");
			
			$query	= ("insert into tbl_transaksi (`transaksiid`,`orderid`,`status`,userid,create_date) 
						values ('$new','$_SESSION[orderid]','0','$_SESSION[userid]','$date')");
			$hasil = sql($query);
			
			$newdetail = newid("transaksidetailid","tbl_transaksi_detail");
			$query1	= ("insert into tbl_transaksi_detail (`transaksidetailid`,`transaksiid`,`produkpostid`,`harga`,`matauang`,`totalharga`,`jumlah`,`berat`,`warehouseid`) 
						values ('$newdetail','$new','$produkpostid','$harga','$matauang','$total','$qty','$berat','2')");
			$hasil1 = sql($query1);
		}
		else
		{
			$transaksidetailid = sql_get_var("select transaksidetailid from tbl_transaksi_detail where transaksiid='$transaksiid' and produkpostid='$produkpostid'");
			if (empty($transaksidetailid))
			{
				$newdetail = newid("transaksidetailid","tbl_transaksi_detail");
				$query1	= ("insert into tbl_transaksi_detail (`transaksidetailid`,`transaksiid`,`produkpostid`,`harga`,`matauang`,`totalharga`,`jumlah`,`berat`,`warehouseid`) 
							values ('$newdetail','$transaksiid','$produkpostid','$harga','$matauang','$total','$qty','$berat','2')");
				$hasil1 = sql($query1);
			}
			else
			{
				$jml_ada      = sql_get_var("select jumlah from tbl_transaksi_detail where transaksidetailid='$transaksidetailid' and produkpostid='$produkpostid'");
				$qtyupdatenya = $jml_ada+$qty;

				$totalup 	= $harga * $qtyupdatenya;

				sql("update tbl_transaksi_detail set jumlah='$qtyupdatenya', totalharga='$totalup', berat=berat+$berat where transaksidetailid='$transaksidetailid' and produkpostid='$produkpostid'");
			}
		}
	}
	else
	{
		$salah = "Jumlah barang yang anda masukan salah, silahkan coba kembali<br><br>\n";
		$tpl->assign("style","alert-danger");
		$tpl->assign("salah",$salah);
	}
}
elseif(isset($id_qty) && isset($_POST['update']))
{
	$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where orderid='$_SESSION[orderid]'");
	$idqty       = sql_get_var("select max(transaksidetailid) as idqty from tbl_transaksi_detail");

	for($aq=1; $aq<=$idqty; $aq++)
	{
		$kode_qty 	= $_POST["kode_qty_$aq"];
		$jum_qty	= $_POST["qty_$aq"];
		
		$sql = "select title,misc_harga,body_weight,misc_diskon,produkpostid from tbl_product_post where produkpostid = '$kode_qty'";
		$hsl = sql($sql);
		$row = sql_fetch_data($hsl);
		$produkpostid 		= $row['produkpostid'];
		$berat 				= $row['body_weight'];
		$harga 				= $row['misc_harga'];
		$diskon				= $row['misc_diskon'];
	
		$sDiskon		= 0;
		$hDiskon		= 0;
		if($diskon!=0)
		{
			$harga			= $diskon;
		}
			$subtotal 	= $harga * $jum_qty;
			
		sql_free_result($hsl);
		
		$berat 		= $berat * $jum_qty;

		$query	= "update tbl_transaksi_detail set `jumlah`='$jum_qty',`berat`='$berat',`totalharga`='$subtotal' where transaksidetailid='$aq' and transaksiid='$transaksiid'";
		$hasil	= sql($query);
	}
}

$tpl->assign("namarubrik","Shopping Cart");

include "cart.data.php";

?>