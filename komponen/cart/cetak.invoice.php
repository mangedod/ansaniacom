<?php

if($pengiriman == "Pickup Point")
	$ketkirim	= "Taken Myself";
else
	$ketkirim	= "Courier Service $namaagen";
	
$html .="<table width=100%>
	<tr>
    	<td align=left><img src='".$fulldomain."/template/ansania/images/img.logo.png' width=50%></td>
        <td  align=right width=70%><strong>".$namatk."</strong><br> ".$alamattk." <br>Phone : ".$telptk." / ".$gsmtk." </td>
    </tr>
    <tr>
    	<td valign=top><strong>Invoice to :</strong><br /> ".$userfullname."<br>".$userphonegsm."</td>
		<td align=right valign=top><strong>Date : </strong>".$tanggaltransaksi."<br> <font color=\"$warnafont\" style=\"font-size:14px\" ><strong>$statusorder</strong></font></td>
    </tr>

</table>";
$html .="<table width=100% >
		<thead>
		<tr style=\"background-color:#cccccc\">
			<th colspan=3 width=10%><b>Informasi Transaksi</b></th>
		</tr>
		<tr>
			<th colspan=3 width=10%>&nbsp;</th>
		</tr></thead>";
$html .= "
		<tr>
			<td width=29%><strong>Nomor Order</strong></td>
			<td width=1%>:</td>
			<td width=70%>#$invoiceid</td>
		</tr>
		
		<tr>
			<td><strong>Metode Pembayaran</strong></td>
			<td>:</td>
			<td>$pembayaran ";if($pembayaran == 'CreditCard'){	$html .= "- Bank $bankpaynya - $kodepaynya"; 	} elseif($pembayaran == "BankTransfer"){ $html .= "- $virtualacnya";  }
$html .= "		</td></tr>
		<tr>
			<td><strong>Metode Pengiriman</strong></td>
			<td>:</td>
			<td>$ketkirim</td>
		</tr>
		<tr>
			<th colspan=3 width=10%>&nbsp;</th>
		</tr>
		<tr>
			<th colspan=3 width=10%>&nbsp;</th>
		</tr>
		<tr>
			<td colspan=3>
				<table style=\"border:1px solid #ddd\" width=100%>
					<thead>
					<tr>
						<td style=\"border:1px solid #ddd; padding:5px\"><strong>Nama Produk</strong></td>
						<td style=\"border:1px solid #ddd; padding:5px\"><strong>Kode Produk</strong></td>
						<td style=\"border:1px solid #ddd; padding:5px\"><strong>Deskripsi</strong></td>
						<td style=\"border:1px solid #ddd; padding:5px\"><strong>Jumlah</strong></td>
						<td style=\"border:1px solid #ddd; padding:5px\"><strong>Price</strong></td>
					</tr>
					</thead>";
foreach($dt_keranjang as $datatr)
{
				
$html .= "			<tr>
						<td style=\"border:1px solid #ddd; padding:5px\">".$datatr['nama']."</td>
						<td style=\"border:1px solid #ddd; padding:5px\">".$datatr['kodeproduk']."</td>
						<td style=\"border:1px solid #ddd; padding:5px\">Nomor : ".$datatr['nomor']."</td>
						<td style=\"border:1px solid #ddd; padding:5px\">".$datatr['qty']."</td>
						<td style=\"border:1px solid #ddd; padding:5px\">".$datatr['totalharga']."</td>
					</tr>";
}
$html .= "			<tr>
						<td colspan=5>The amount to be paid</td>
						<td align=right>".$totaltagihan2."</td>
					</tr>";
				if($totaldiskon != '0')
				{
$html .= "			<tr>
						<td colspan=5>Discount Voucher ($kodevoucher)</td>
						<td align=right>(-)".$totaldiskon2."</td>
					</tr>";
				}	
				if($pengiriman != 'Pickup Point')
				{
$html .= "			<tr>
						<td colspan=5>Postage ($namaagen - $ongkosinfo) </td>
						<td align=right>".$ongkoskirim2."</td>
					</tr>";
				}	
$html .= "			<tr>
						<td colspan=5><strong>Total</strong></td>
						<td align=right><strong>".$totaltagihanakhir2."</strong></td>
					</tr>
				</table>
			</td>
		</tr>";
$html .="</table><br clear=all /><br clear=all />";

$html .="<table border=\"0\" width=\"100%\">
			<tbody align=\"top\">
				<tr>
					<th width=\"50%\" style=\"background-color:#cccccc\">Payment Information</th>
					<th width=\"50%\" colspan=\"2\" style=\"background-color:#cccccc\">Billing Information</th>
				</tr>
			</tbody>

			<tbody align=\"top\">
				<tr>
					<td rowspan=\"4\" scope=\"row\" class=\"sub_spec\">
						Payment is made in <strong>$pembayarannya</strong><br />";
						if($pembayaran == 'Transfer')
						{
								$html .="To complete the payment transaction, please transfer to : <br /><br>
								<ol>";
								foreach($rekening as $data)
								{
									$html .= "<li><b>".$data['bank']." (".$data['akun']. "a.n ".$data['namaak'].")</b></li>";
								}
								$html .="</ol><br>After making the payment we expect to confirm the payment.
								<br>Transfer Limit : $datetransfer.";
						}
						elseif($pembayaran == 'CreditCard')
						{
							$html .="Name of Bank : <strong>$bankpaynya</strong><br>
                                     Card Number : <strong>$kodepaynya</strong>";
						}
						elseif($pembayaran == 'BankTransfer')
						{
							$html .="Please do payment with<br>
                                    Virtual Account No : <strong>$virtualacnya</strong>";
						}
				$html .="</td>
						<td class=\"info_spec\" width=\"20%\">Name</td>
						<td class=\"sub_spec\">$userfullname</td>
					</tr>
					<tr>
						<td class=\"info_spec\">Email</td>
						<td class=\"sub_spec\">$email</td>
					</tr>
					<tr>
						<td class=\"info_spec\">Address</td>
						<td class=\"sub_spec\">$billingalamat</td>
					</tr>
				</tbody>
			</table><br clear=all /><br clear=all />";
			
$html .="<table border=\"0\" width=\"100%\">";
		if($pengiriman != 'Pickup Point')
		{
			$html .="
			<tr>
				<th width=\"100%\" colspan=\"2\" style=\"background-color:#cccccc\">Shipping Information</th>
			</tr>

			<tr>
				<td width=\"30%\" class=\"info_spec\">Shipping Agent</td>
				<td class=\"sub_spec\">$namaagen - $ongkosinfo</td>
			</tr>";
            if (!empty($no_resi))
			{
				$html .="<tr>
					<td class=\"info_spec\">Delivery Receipt Number</td>
					<td class=\"sub_spec\">$no_resi</td>
				</tr>";
            }
             $html .="<tr>
				<td class=\"info_spec\">Full Name</td>
				<td class=\"sub_spec\">$namalengkap</td>
			</tr>
			<tr>
				<td class=\"info_spec\">Shipping Address</td>
				<td class=\"sub_spec\">$alamatpengiriman</td>
			</tr>";
		}
		else
		{
			$html .="
			<tr>
				<th width=\"100%\" colspan=\"2\" style=\"background-color:#cccccc\">Information Retrieval Of Goods</th>
			</tr>
			<tr>
				<td width=\"30%\" class=\"info_spec\">Store Name</td>
				<td class=\"sub_spec\">$warehouse</td>
			</tr>
			<tr>
				<td class=\"info_spec\">Address</td>
				<td class=\"sub_spec\">$alamattk<br>$telptk</td>
			</tr>";
		}
		$html .="</table><br clear=all /><br clear=all />";

$tpl->assign("html",$html);

/*include($lokasiweb."librari/mpdf/mpdf.php");

$mpdf=new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output();*/
?>