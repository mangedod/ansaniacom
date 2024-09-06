<?php

if($pengiriman == "Pickup Point")
	$ketkirim	= "Taken Myself";
else
	$ketkirim	= "Courier Service $namaagen";
	
$html .="<table width=100%>
	<tr>
    	<td colspan=4 align=left><img src='".$fulldomain."template/ansania/images/logo.png' width=100%></td>
        <td colspan=2 align=right><strong>".$namatk."</strong><br> ".$alamattk." <br>Phone : ".$telptk." / ".$gsmtk." </td>
    </tr>
	<tr>
    	<td colspan=6>&nbsp;</td>
    </tr>
    <tr>
    	<td colspan=5 valign=top><strong>Invoice to :</strong><br /> ".$userfullname."<br>".$userphonegsm."</td>
		<td align=right valign=top><strong>Date : </strong>".$tanggal."<br> <font color=\"$warnafont\" style=\"font-size:14px\" ><strong>$statusorder</strong></font></td>
    </tr>
    <tr>
    	<td colspan=6>&nbsp;</td>
    </tr>
	<tr>
    	<td colspan=6>&nbsp;</td>
    </tr>
</table>";
$html .="<table width=100% >
		<thead>
		<tr style=\"background-color:#cccccc\">
			<th colspan=3 width=10%><b>Transaction Detail</b></th>
		</tr>
		<tr>
			<th colspan=3 width=10%>&nbsp;</th>
		</tr></thead>";
$html .= "
		<tr>
			<td width=29%><strong>Invoice Number</strong></td>
			<td width=1%>:</td>
			<td width=70%>#$invoiceid</td>
		</tr>
		<tr>
			<td><strong>Order Code</strong></td>
			<td>:</td>
			<td>$orderid</td>
		</tr>
		<tr>
			<td><strong>Method Of Payment</strong></td>
			<td>:</td>
			<td>$pembayaran</td>
		</tr>
		<tr>
			<td><strong>Shipping Method</strong></td>
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
						<td>Product Name</td>
						<td >Product Code</td>
						<td >Description</td>
						<td >Quantity</td>
						<td >Price</td>
					</tr>
					</thead>";
foreach($dt_keranjang as $datatr)
{
				
$html .= "			<tr>
						<td>".$datatr['nama']."</td>
						<td>".$datatr['kodeproduk']."</td>
						<td>Color : ".$datatr['namawarna']."<br/>Size : ".$datatr['size']."</td>
						<td>".$datatr['qty']."</td>
						<td>".$datatr['totalharga']."</td>
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
						<td colspan=5>Postage($namaagen - $ongkosinfo)</td>
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

if($pembayaran == "Transfer")
{
	$html .="<br>You can perform a transfer payment through one of the following account: <br><ol>";
	foreach($rekening as $data)
	{
		$html .= "<li>".$data['bank']." (".$data['akun']. "a.n ".$data['namaak'].")</li>";
	}
	$html .="</ol><br>After making the payment transfer or cash payment, we expect can do a payment confirmation via the URL:<br> $urlconfirm  <br><br>
			Please make payment before the date $datetransfer. When the appointed time until we have received your payment of your Invoice then automatically cancelled.  <br><br>
			";
	//echo $html;
}
elseif($pembayaran != "Transfer")
{
	if($statusorder=="INVOICED" || $statusorder=="BILLED")
	{
	
		$html .="<br>The current status of your transaction is still PENDING or have yet to make a payment, please do payment using payment methods
		you have chosen before. If payment is not made until the date of $batastransfer then we'll do the cancellation of your transactions automatically.<br><br>
		";
	}
	if($statusorder=="CANCEL")
	{
	
		$html .="<br>This transaction has been cancelled over your request or payment time has run out to buy a new product, please
		do the transaction back.<br><br>
		";
	}
}

include($lokasiweb."librari/mpdf/mpdf.php");

$mpdf=new mPDF('P'); 

$mpdf->WriteHTML($html);
$mpdf->Output($lokasiweb."gambar/pdf/$invoiceid.pdf");
?>