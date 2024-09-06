<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="<?php echo $metakeyword?>" />
    <meta name="description" content="<?php echo $title." - ".$webdesc?>">

    <title><?php echo $title?></title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="<?php echo $lokasiwebtemplate?>/panel/template/stylesheet/bootstrap.min.css">

    <!-- Customizable CSS -->
    <link rel="stylesheet" href="<?php echo $lokasiwebtemplate?>/panel/template/stylesheet/cetak.css">
    <link rel="stylesheet" href="<?php echo $lokasiwebtemplate?>/panel/template/stylesheet/print.css" media="print">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="<?php echo $lokasiwebtemplate?>/panel/template/stylesheet/font-awesome.min.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $lokasiwebtemplate?>/panel/template/images/favicon.png">


</head>

<body>
<div class="barcetak">
	<div class="container">
    <input type="button" class="btn btn-primary pull-right" value="Print Invoice" onClick="window.print()" />
    </div>
</div>
    
<div class="container">
<?php

if($pengiriman == "Pickup Point")
	$ketkirim	= "Taken Myself";
else
	$ketkirim	= "Courier Service $namaagen";
	
$html .="<table width=100%>
	<tr>
    	<td colspan=4 align=left><img src='".$fulldomain."/template/trijee/images/logo.png' width=50%></td>
        <td colspan=2 align=right width=70%><strong>".$namatk."</strong><br> ".$alamattk." <br>Phone : ".$telptk." / ".$gsmtk." </td>
    </tr>
	<tr>
    	<td colspan=6>&nbsp;</td>
    </tr>
    <tr>
    	<td colspan=5 valign=top><strong>Invoice to :</strong><br /> ".$userfullname."<br>".$userphonegsm."</td>
		<td align=right valign=top><strong>Date : </strong>".$tanggaltransaksi."<br> <font color=\"$warnafont\" style=\"font-size:14px\" ><strong>$statusorder</strong></font></td>
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
			<td>$pembayarannya ";if($pembayaran == 'CreditCard'){	$html .= "- Bank $bankpaynya - $kodepaynya"; 	} elseif($pembayaran == "BankTransfer"){ $html .= "- $virtualacnya";  }
$html .= "		</td></tr>
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
				if($confee != '0')
				{
$html .= "			<tr>
						<td colspan=5>Convenience Fee</td>
						<td align=right>-".$confee."</td>
					</tr>";
				}	
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
						<td colspan=5>Postage ($namaagen - $services) </td>
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
								$html .="Payments will be transferred to the : <br />
								<ol>";
								foreach($rekening as $data)
								{
									$html .= "<li>".$data['bank']." (".$data['akun']. "a.n ".$data['namaak'].")</li>";
								}
								$html .="</ol><br>Transfer Limit : $datetransfer.";
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
				<td class=\"sub_spec\">$namaagen - $services</td>
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
		$html .="</table>";
if($dropship == '1')
{
$html .="<table border=\"0\" width=\"100%\">";
			$html .="
			<tr>
				<th width=\"100%\" colspan=\"2\" style=\"background-color:#cccccc\">Dropship</th>
			</tr>
			<tr>
				<td width=\"30%\" class=\"info_spec\">Sender's Name</td>
				<td class=\"sub_spec\">$namapengirim</td>
			</tr>
			<tr>
				<td class=\"info_spec\">The Sender's Phone Number</td>
				<td class=\"sub_spec\">$telppengirim</td>
			</tr>";
		$html .="</table><br clear=all /><br clear=all />";
}
echo "$html";
/*include($lokasiweb."librari/mpdf/mpdf.php");

$mpdf=new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output();*/

?>
</div>
<div class="barcetak">
	<div class="container">
    <input type="button" class="btn btn-primary pull-right" value="Print Invoice" onClick="window.print()" />
    </div>
</div>
</body>
</html>
