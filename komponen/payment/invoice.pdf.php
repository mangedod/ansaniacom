<?php

if($pengiriman == "Pickup Point")
	$ketkirim	= "Diambil Sendiri";
else
	$ketkirim	= "Jasa Kurir $namaagen";
	
$html .="<table width=100%>
	<tr>
    	<td colspan=4 align=left><img src='".$fulldomain."/template/sygma/images/img.logo.png' width=100%></td>
        <td colspan=2 align=right><strong>".$namatk."</strong><br> ".$alamattk." <br>Phone : ".$telptk." / ".$gsmtk." </td>
    </tr>
	<tr>
    	<td colspan=6>&nbsp;</td>
    </tr>
    <tr>
    	<td colspan=5 valign=top><strong>Invoice ke :</strong><br /> ".$userfullname."<br>".$userhandphone."</td>
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
			<th colspan=3 width=10%><b>Detail Transaksi</b></th>
		</tr>
		<tr>
			<th colspan=3 width=10%>&nbsp;</th>
		</tr></thead>";
$html .= "
		<tr>
			<td width=29%><strong>Nomor Invoice</strong></td>
			<td width=1%>:</td>
			<td width=70%>#$orderid</td>
		</tr>
		<tr>
			<td><strong>Kode Order</strong></td>
			<td>:</td>
			<td>$orderid</td>
		</tr>
		<tr>
			<td><strong>Metode Pembayaran</strong></td>
			<td>:</td>
			<td>$pembayaran</td>
		</tr>
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
						<td width=45%>Nama Produk</td>
						<td width=10%>Kode Produk</td>
						<td width=5%>Jumlah</td>
						<td width=10%>Harga</td>
						<td width=20%>Diskon</td>
						<td width=10%>Subtotal</td>
					</tr>
					</thead>";
foreach($dt_keranjang as $datatr)
{
				
$html .= "			<tr>
						<td>".$datatr['nama']."</td>
						<td>".$datatr['kodeproduk']."</td>
						<td>".$datatr['qty']."</td>
						<td>".$datatr['harga_asli']."</td>
						<td>".$datatr['ketdiskon']." ".$datatr['hargadiskon']."</td>
						<td align=right>".$datatr['totalharga']."</td>
					</tr>";
}
$html .= "			<tr>
						<td colspan=5>Jumlah yang harus dibayarkan</td>
						<td align=right>".$totaltagihan2."</td>
					</tr>";
				if($totaldiskon != '0')
				{
$html .= "			<tr>
						<td colspan=5>Diskon Voucher ($kodevoucher)</td>
						<td align=right>(-)".$totaldiskon2."</td>
					</tr>";
				}
				if($confee2 != '0')
				{
$html .= "			<tr>
						<td colspan=5>Convenience Fee</td>
						<td align=right>(-)".$confee2."</td>
					</tr>";
				}	
				if($pengiriman != 'Pickup Point')
				{
$html .= "			<tr>
						<td colspan=5>Ongkos Kirim: $ongkosinfo</td>
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
$html .="<br>Anda dapat melakukan transfer pembayaran melalui salah satu rekening berikut : <br><ol>";
foreach($rekening as $data)
{
	$html .= "<li>".$data['bank']." (".$data['akun']. "a.n ".$data['namaak'].")</li>";
}
$html .="</ol><br>Setelah melakukan pembayaran transfer atau pembayaran tunai Anda, kami harapkan dapat melakukan konfirmasi pembayaran melalui URL :<br> $urlconfirm  <br><br>
		Harap melakukan pembayaran sebelum tanggal $datetransfer. Apabila sampai waktu yang telah ditentukan Kami belum menerima pembayaran Anda maka secara otomatis Invoice Anda Dibatalkan.  <br><br>
		";
//echo $html;
}
include($lokasiweb."librari/mpdf/mpdf.php");

$mpdf=new mPDF('P'); 

$mpdf->WriteHTML($html);
$mpdf->Output($lokasiweb."/gambar/pdf/$orderid.pdf");
?>