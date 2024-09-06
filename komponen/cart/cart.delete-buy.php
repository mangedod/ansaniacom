<?php

$transaksidetailid = $var[4];
$sqls	= "select transaksiid, produkpostid from tbl_transaksi_detail where transaksidetailid='$transaksidetailid'";
$qrys	= sql($sqls);
$rows	= sql_fetch_data($qrys);

$transaksiid	= $rows['transaksiid'];
$produkpostid	= $rows['produkpostid'];

$sql	= "delete from tbl_transaksi_detail where transaksidetailid='$transaksidetailid'";
$query = sql($sql);

$voucherid	= sql_get_var("select voucherid from tbl_transaksi where transaksiid='$transaksiid'"); 	
if($voucherid!='0')
{
	$total_subtotal	= sql_get_var("select sum(totalharga) from tbl_transaksi_detail where transaksiid='$transaksiid'"); 
		
	$perintah	= "select nama,jenis,jumlah,ketentuan,nominal1,nominal2,maxuser,used,qty,matauang,untuk,produkpostid,kategori from tbl_voucher where published='1' and id='$voucherid'";
	$hasil		= sql($perintah);
	$data		= sql_fetch_data($hasil);
	$nama		= $data['nama'];
	$jenis		= $data['jenis'];
	$jumlah		= $data['jumlah'];
	$tglawal	= $data['tglawal'];
	$tglakhir	= $data['tglakhir'];
	$ketentuan	= $data['ketentuan'];
	$nominal1	= $data['nominal1'];
	$nominal2	= $data['nominal2'];
	$maxuser	= $data['maxuser'];
	$used		= $data['used'];
	$qty		= $data['qty'];
	$matauang	= $data['matauang'];
	$untuk		= $data['untuk'];
	$produkpostidv	= $data['produkpostid'];
	$kategori		= $data['kategori'];
	
	if($ketentuan == "lebih dari")
	{
		if($total_subtotal	< $nominal1)
		{
			sql("update tbl_transaksi set voucherid='0', vouchercodeid='0', kodevoucher='', totaldiskon='', totaltagihanafterdiskon=totaltagihan where transaksiid='$transaksiid'");
		}
	}
	else
	{
		if($untuk == "produk")
		{
			if($produkpostidv == $produkpostid)
				sql("update tbl_transaksi set voucherid='0', vouchercodeid='0', kodevoucher='', totaldiskon='', totaltagihanafterdiskon=totaltagihan where transaksiid='$transaksiid'");	
		}
	}
	
}	

if($query)
	header("location: $fulldomain"."/cart/buy");
	
?>