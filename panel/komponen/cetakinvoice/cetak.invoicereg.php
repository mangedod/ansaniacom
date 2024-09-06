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
    <input type="button" class="btn btn-primary pull-right" value="Cetak Invoice" onClick="window.print()" />
    </div>
</div>
    
<div class="container">
<?php
	
$html .="<table width=100%>
	<tr>
    	<td colspan=4 align=left><img src='".$fulldomain."/template/sygma/images/img.logo.png' width=50%></td>
        <td colspan=2 align=right width=70%><strong>".$namatk."</strong><br> ".$alamattk." <br>Phone : ".$telptk." / ".$gsmtk." </td>
    </tr>
	<tr>
    	<td colspan=6>&nbsp;</td>
    </tr>
    <tr>
    	<td colspan=5 valign=top><strong>Invoice ke :</strong><br /> ".$userfullname."<br>".$userphonegsm."</td>
		<td align=right valign=top><strong>Tanggal : </strong>".$tanggal."<br> <font color=\"$warnafont\" style=\"font-size:14px\" ><strong>$statusorder</strong></font></td>
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
			<th colspan=3 width=10%><b>Detail Transaksi Registrasi Reseller</b></th>
		</tr>
		<tr>
			<th colspan=3 width=10%>&nbsp;</th>
		</tr></thead>";
$html .= "
		<tr>
			<td width=29%><strong>Nomor Invoice</strong></td>
			<td width=1%>:</td>
			<td width=70%>#$invoiceid</td>
		</tr>
		<tr>
			<td><strong>Kode Order Register</strong></td>
			<td>:</td>
			<td>$regorderid</td>
		</tr>
		<tr>
			<td><strong>Metode Pembayaran</strong></td>
			<td>:</td>
			<td>$pembayaran</td>
		</tr>
		<tr>
			<td><strong>Total Tagihan Registrasi</strong></td>
			<td>:</td>
			<td>$totaltagihan2</td>
		</tr>
		<tr>
			<th colspan=3 width=10%>&nbsp;</th>
		</tr>
		<tr>
			<th colspan=3 width=10%>&nbsp;</th>
		</tr>";
$html .="</table><br clear=all />";
		
$html .="<table border=\"0\" width=\"100%\">
			<tbody align=\"top\">
				<tr>
					<th width=\"50%\" style=\"background-color:#cccccc\">Informasi Pembayaran</th>
					<th width=\"50%\" colspan=\"2\" style=\"background-color:#cccccc\">Informasi Tagihan</th>
				</tr>
			</tbody>

			<tbody align=\"top\">
				<tr>
					<td rowspan=\"4\" scope=\"row\" class=\"sub_spec\">
						Pembayaran dilakukan secara <strong>$pembayaran</strong><br />";
						if($pembayaran == 'Transfer Bank')
						{
								$html .="Pembayaran akan ditransfer ke : <br />
								<ol>";
								foreach($rekening as $data)
								{
									$html .= "<li>".$data['bank']." (".$data['akun']. "a.n ".$data['namaak'].")</li>";
								}
								$html .="</ol><br>Batas Transfer : $datetransfer.";
						}
				$html .="</td>
						<td class=\"info_spec\" width=\"20%\">Nama</td>
						<td class=\"sub_spec\">$userfullname</td>
					</tr>
					<tr>
						<td class=\"info_spec\">Email</td>
						<td class=\"sub_spec\">$email</td>
					</tr>
					<tr>
						<td class=\"info_spec\">Alamat</td>
						<td class=\"sub_spec\">$billingalamat</td>
					</tr>
				</tbody>
			</table><br clear=all /><br clear=all />";
echo "$html";
/*include($lokasiweb."librari/mpdf/mpdf.php");

$mpdf=new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output();*/

?>
</div>
<div class="barcetak">
	<div class="container">
    <input type="button" class="btn btn-primary pull-right" value="Cetak Invoice" onClick="window.print()" />
    </div>
</div>
</body>
</html>
