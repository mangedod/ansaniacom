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
<style>
	*{
		font-family:"Open Sans";
		font-size:14px;
		}
</style>

<body>
<div class="barcetak">
	<div class="container">
    <input type="button" class="btn btn-primary pull-right" value="Print Invoice" onClick="window.print()" />
    </div>
</div>
    
<div class="container">
<?php

$html .="<table width=100%>
	<tr>
    	<td colspan=4 align=left><img src='".$fulldomain."/template/ansania/images/img.logo.png' ></td>
        <td colspan=2 align=right width=70%><strong>".$namatk."</strong><br> ".$alamattk." <br>Phone : ".$telptk." / ".$gsmtk." </td>
    </tr>
	<tr>
    	<td colspan=6>&nbsp;</td>
    </tr>
    <tr>
    	<td colspan=5 valign=top><strong>Invoice to :</strong><br /> ".$namalengkap."<br>".$alamatpengiriman."</td>
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
$html .= "			<tr>
						<td colspan=5>Ongkos Kirim</td>
						<td align=right>".$ongkoskirim2."</td>
					</tr>";

$html .= "			<tr>
						<td colspan=5><strong>Total</strong></td>
						<td align=right><strong>".$totaltagihanakhir2."</strong></td>
					</tr>
				</table>
			</td>
		</tr>";
$html .="</table><br clear=all /><br clear=all />";


			

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
