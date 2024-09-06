<?php
include("../../setingan/web.config.inc.php");
	session_start();

	$kodevoucher 		= $_POST[kodevoucher];
	$total_subtotal		= $_POST[total_subtotal];
	$orderid			= $_POST[orderid];
	if(empty($kodevoucher))
	{
		echo "<div class='alert alert-danger'>Please enter the voucher code in advance.</div>||$total_subtotal";
	}
	else
	{
		$today		= date("Y-m-d");
		$voucherid 	= sql_get_var("select voucherid from tbl_voucher_kode where kodevoucher='$kodevoucher' and status='0'");
		
		if($voucherid)
		{
			$vouchercodeid 	= sql_get_var("select vouchercodeid from tbl_voucher_kode where kodevoucher='$kodevoucher' and status='0'");
			$perintah	= "select nama,jenis,jumlah,tglawal,tglakhir,ketentuan,nominal1,nominal2,maxuser,used,qty,matauang,untuk,produkpostid,kategori from tbl_voucher where published='1' and id='$voucherid'";
			$hasil		= sql($perintah);
			$jumlahnya	= sql_num_rows($hasil);
			if($jumlahnya>0)
			{
				$data         = sql_fetch_data($hasil);
				$nama         = $data['nama'];
				$jenis        = $data['jenis'];
				$jumlah       = $data['jumlah'];
				$tglawal      = $data['tglawal'];
				$tglakhir     = $data['tglakhir'];
				$ketentuan    = $data['ketentuan'];
				$nominal1     = $data['nominal1'];
				$nominal2     = $data['nominal2'];
				$maxuser      = $data['maxuser'];
				$used         = $data['used'];
				$qty          = $data['qty'];
				// $matauang  = $data['matauang'];
				$matauang     = "IDR";
				$untuk        = $data['untuk'];
				$produkpostid = $data['produkpostid'];
				$kategori     = $data['kategori'];
				
				if($ketentuan == "lebih dari")
				{
					if($total_subtotal	< $nominal1)
					{
						$nom	= "IDR. ". number_format($nominal1,0,".",".");
						echo "<div class='alert alert-danger'>Voucher codes <strong>$kodevoucher</strong> can be used if your total spend over $nom.</div>||$total_subtotal";
						exit();
					}
				}
				
				if($used<$qty)
				{
					if($untuk == "produk")
					{
						if (($today>=$tglawal) and ($today<=$tglakhir))
						{
							$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where kodevoucher!='' and orderid='$orderid'");
							
							if(empty($transaksiid))
							{
								$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where orderid='$orderid'");
								
								$cekproduk = sql_get_var("select count(*) as jml from tbl_transaksi_detail where produkpostid='$produkpostid' and transaksiid='$transaksiid'"); 
								
								if($cekproduk)
								{
									if ($jenis=="persen")
									{
										$jumdis		= $jumlah ."%";
										$totaldis	= ($jumlah/100)*$total_subtotal;
										$totaldis2	= "IDR. ". number_format($totaldis,0,".",".");
									}
									else
									{
										$jumdis		= "IDR. ". number_format($jumlah,0,".",".");
										$totaldis	= $jumlah;
										$totaldis2	= "IDR. ". number_format($totaldis,0,".",".");
							
									}
								
									$totalsub	= $total_subtotal - $totaldis;
									$totalsub2	= "IDR. ". number_format($totalsub,0,".",".");
									
									sql("update tbl_transaksi set voucherid='$voucherid', kodevoucher='$kodevoucher', vouchercodeid='$vouchercodeid', totaldiskon='$totaldis', totaltagihanafterdiskon='$totalsub' where orderid='$orderid'");
								}
								else
								{
									echo "<div class='alert alert-danger'>Voucher codes <strong>$kodevoucher</strong> can not be used. Voucher is valid only for a specific product.</div>||$total_subtotal";
									exit();
								}
							}
							else
							{
								$totalsub	= $total_subtotal;
								$totaldis	= $jumlah;
								$totaldis2	= "IDR. ". number_format($totaldis,0,".",".");
							}
							
							//sql("update tbl_voucher_kode set status='1' where kodevoucher='$kodevoucher' and vouchercodeid='$vouchercodeid'");
							
							//sql("update tbl_voucher set used=used+'1' where id='$voucherid'");
							
							$_SESSION['voucherid']     = $voucherid;
							$_SESSION['kodevoucher']   = $kodevoucher;
							$_SESSION['vouchercodeid'] = $vouchercodeid;
							
							echo "
									<input type='hidden' name='kode_voucher' value='$kodevoucher'>
									<input type='hidden' name='diskon' value='$totaldis'>
									<div class='alert alert-success'>$nama (<strong>$kodevoucher</strong>) $totaldis2</div>||$totalsub
							";
						}
						else
						{
							echo "<div class='alert alert-danger'>Voucher code <strong> $kodevoucher </strong> is not valid and can not be used.</div>||$total_subtotal";
						}
					}
					elseif($untuk == "kategori")
					{
						if (($today>=$tglawal) and ($today<=$tglakhir))
						{
							$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where kodevoucher!='' and orderid='$orderid'");
							
							if(empty($transaksiid))
							{
								$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where orderid='$orderid'");
								
								$sqls	= "select produkpostid from tbl_product_post where secid='$kategori'";
								$qrys	= sql($sqls);
								while($rows = sql_fetch_data($qrys))
								{
									$produkpostid1 = $rows['produkpostid'];
								
									$cekproduk = sql_get_var("select count(*) as jml from tbl_transaksi_detail where produkpostid='$produkpostid1' and transaksiid='$transaksiid'"); 
									
									if(!empty($cekproduk))
									{
										$cekproduk = 1;
										exit();
									}
									else
										$cekproduk = "";
								}
								
								if($cekproduk)
								{
									if ($jenis=="persen")
									{
										$jumdis		= $jumlah ."%";
										$totaldis	= ($jumlah/100)*$total_subtotal;
										$totaldis2	= "IDR. ". number_format($totaldis,0,".",".");
									}
									else
									{
										$jumdis		= "IDR. ". number_format($jumlah,0,".",".");
										$totaldis	= $jumlah;
										$totaldis2	= "IDR. ". number_format($totaldis,0,".",".");
							
									}
								
									$totalsub	= $total_subtotal - $totaldis;
									$totalsub2	= "IDR. ". number_format($totalsub,0,".",".");
									
									sql("update tbl_transaksi set voucherid='$voucherid', kodevoucher='$kodevoucher', vouchercodeid='$vouchercodeid', totaldiskon='$totaldis', totaltagihanafterdiskon='$totalsub' where orderid='$orderid'");
								}
								else
								{
									echo "<div class='alert alert-danger'>Voucher code <strong> $kodevoucher </strong> can not be used. Voucher is valid only for certain categories.</div>||$total_subtotal";
									exit();
								}
							}
							else
							{
								$totalsub	= $total_subtotal;
								$totaldis	= $jumlah;
								$totaldis2	= "IDR. ". number_format($totaldis,0,".",".");
							}
							
							//sql("update tbl_voucher_kode set status='1' where kodevoucher='$kodevoucher' and vouchercodeid='$vouchercodeid'");
							
							//sql("update tbl_voucher set used=used+'1' where id='$voucherid'");
							
							$_SESSION['voucherid'] = $voucherid;
							$_SESSION['kodevoucher'] = $kodevoucher;
							$_SESSION['vouchercodeid'] = $vouchercodeid;
							
							echo "
									<input type='hidden' name='kode_voucher' value='$kodevoucher'>
									<input type='hidden' name='diskon' value='$totaldis'>
									<div class='alert alert-success'>$nama (<strong>$kodevoucher</strong>) $totaldis2</div>||$totalsub
							";
						}
						else
						{
							echo "<div class='alert alert-danger'>Voucher code <strong> $kodevoucher </strong> is not valid and can not be used.</div>||$total_subtotal";
						}
					}
					else
					{
						if (($today>=$tglawal) and ($today<=$tglakhir))
						{
							$transaksiid = sql_get_var("select transaksiid from tbl_transaksi where kodevoucher!='' and orderid='$orderid'");
							
							if(empty($transaksiid))
							{
								if ($jenis=="persen")
								{
									$jumdis		= $jumlah ."%";
									$totaldis	= ($jumlah/100)*$total_subtotal;
									$totaldis2	= "IDR. ". number_format($totaldis,0,".",".");
								}
								else
								{
									$jumdis		= "IDR. ". number_format($jumlah,0,".",".");
									$totaldis	= $jumlah;
									$totaldis2	= "IDR. ". number_format($totaldis,0,".",".");
						
								}
							
								$totalsub	= $total_subtotal - $totaldis;
								$totalsub2	= "IDR. ". number_format($totalsub,0,".",".");
								
								sql("update tbl_transaksi set voucherid='$voucherid', kodevoucher='$kodevoucher', vouchercodeid='$vouchercodeid', totaldiskon='$totaldis', totaltagihanafterdiskon='$totalsub' where orderid='$orderid'");
							}
							else
							{
								$totalsub	= $total_subtotal;
								$totaldis	= $jumlah;
								$totaldis2	= "IDR. ". number_format($totaldis,0,".",".");
							}
							
							//sql("update tbl_voucher_kode set status='1' where kodevoucher='$kodevoucher' and vouchercodeid='$vouchercodeid'");
							
							//sql("update tbl_voucher set used=used+'1' where id='$voucherid'");
							
							$_SESSION['voucherid'] = $voucherid;
							$_SESSION['kodevoucher'] = $kodevoucher;
							$_SESSION['vouchercodeid'] = $vouchercodeid;
							
							echo "
									<input type='hidden' name='kode_voucher' value='$kodevoucher'>
									<input type='hidden' name='diskon' value='$totaldis'>
									<div class='alert alert-success'>$nama (<strong>$kodevoucher</strong>) $totaldis2</div>||$totalsub
							";
						}
						else
						{
							echo "<div class='alert alert-danger'>Voucher code <strong> $kodevoucher </strong> is not valid and can not be used.</div>||$total_subtotal";
						}
					}
				}
				else
				{
					
					echo "<div class='alert alert-danger'>Voucher code <strong> $kodevoucher </strong> can not be used.</div>||$total_subtotal";
				}
			}
			else
			{
				echo "<div class='alert alert-danger'>Voucher code <strong> $kodevoucher </strong> can not be used.</div>||$total_subtotal";
			}
			sql_free_result($hasil);
		}
		else
		{
			echo "<div class='alert alert-danger'>Voucher code <strong> $kodevoucher </strong> is not registered.</div>||$total_subtotal";
		}
	}
?>