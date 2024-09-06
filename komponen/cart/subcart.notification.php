<?php
require_once($lokasiweb."librari/veritrans/Veritrans.php");
Veritrans_Config::$isProduction = $isProduction;
Veritrans_Config::$serverKey = "$serverkey";
	
$notif = new Veritrans_Notification();

$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$fraud = $notif->fraud_status;


$ip = $_SERVER['REMOTE_ADDR'];

$input = $HTTP_RAW_POST_DATA;
$data = date('Y-m-d H:i:s')." | $ip | $transaction | $type | $order_id | $fraud $input\r\n";
$file = "logs/backlog.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);


if ($transaction == 'capture') {
  // For credit card transaction, we need to check whether transaction is challenge by FDS or not
  if ($type == 'credit_card'){
    if($fraud == 'challenge'){
	
		  // TODO set payment status in merchant's database to 'Challenge by FDS'
		  // TODO merchant should decide whether this transaction is authorized or not in MAP
		  $message = "Transaction order_id: " . $order_id ." is challenged by FDS";
      } 
      else
	  {
	  
		$ordernumber = $order_id;
			
		$sql = "update tbl_transaksi set status='3',paymentinfo='$input' where ordernumber='$ordernumber'";
		$hasil	= sql($sql);
	
		if($hasil)
		{
			$sql = sql("select transaksiid,totaltagihanafterdiskon,ongkoskirim,totalinvoice,resellerid,userid from tbl_transaksi where ordernumber='$ordernumber'");
			$dt = sql_fetch_data($sql);
			$transaksiid = $dt['transaksiid'];
			$totaltagihanafterdiskon = $dt['totaltagihanafterdiskon'];
			$ongkoskirim = $dt['ongkoskirim'];
			$totalinvoice = $dt['totalinvoice'];
			$resellerid = $dt['resellerid'];
			$userid = $dt['userid'];
			
			$sql = "select * from tbl_transaksi_detail where transaksiid='$transaksiid' order by transaksidetailid desc ";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			while ($row = sql_fetch_data($hsl))
			{
				$transaksidetailid = $row['transaksidetailid'];
				$produkpostid      = $row['produkpostid'];
				$qty               = $row['jumlah'];
				$berat             = $row['berat'];
				$matauang          = $row['matauang'];
				$harga             = "$matauang. ". number_format($row['harga'],"0",".",".");
				$total             = "$matauang. ". number_format($row['totalharga'],"0",".",".");

				$dtprodukpos        = sql_get_var_row("select title, kodeproduk, misc_harga,misc_diskon_single,misc_diskon_double,misc_diskon_triple  from tbl_product_post where produkpostid='$produkpostid'");
				$namaprod           = $dtprodukpos['title'];
				$kodeproduk         = $dtprodukpos['kodeproduk'];
				$misc_diskon_single = $dtprodukpos['misc_diskon_single'];
				$misc_diskon_double = $dtprodukpos['misc_diskon_double'];
				$misc_diskon_triple = $dtprodukpos['misc_diskon_triple'];
				$misc_harga         = $dtprodukpos['misc_harga'];
				$harga_asli         = "$matauang.".number_format($misc_harga,0,".",".");

					$diskkk          = sql_get_var_row("select nama, diskon_persen, tanggaldiskon,harga_diskonk from tbl_product_mdiskonk where produkpostid='$produkpostid'");
					$namadiskk       = $diskkk['nama'];
					$persendiskk     = $diskkk['diskon_persen']."%";
					$tgldiskk        = $diskkk['tanggaldiskon'];
					$tgldiskk2       = tanggalonly($diskkk['tanggaldiskon']);
					$hrgdiskk        = $diskkk['harga_diskonk'];
					$tanggalsekarang = date("Y-m-d");

					if($tgldiskk == $tanggalsekarang)
					{
						$ketdiskon   = "Diskon $namadiskk ($persendiskk) Khusus tanggal $tgldiskk2:<br/>";
						$hargadiskon = "$matauang.".number_format($hrgdiskk,0,".",".");
					}
					elseif($qty == 1)
					{
						$ketdiskon   = "Diskon Single Set 20%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_single,0,".",".");
					}
					elseif ($qty == 2) 
					{
						$ketdiskon   = "Diskon Double dan Multi Set 25%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_double,0,".",".");
					}
					elseif ($qty == 3) 
					{
						$ketdiskon   = "Diskon Triple dan Optimum 30%:<br/>";
						$hargadiskon = "$matauang.".number_format($misc_diskon_triple,0,".",".");
					}
					else
					{
						$ketdiskon   = "";
						$hargadiskon = "<center>-</center>";
					}
				

				// album
				$gambar_s	= sql_get_var("select gambar_s from tbl_product_image where produkpostid='$produkpostid' order by albumid asc limit 1");
				
				if(!empty($gambar_s))
					$image_s	= "$fulldomain/gambar/produk/$produkpostid/$gambar_s";
				else
					$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
				$berattotal	.= $berattotal+$row['berat'];
				
				$dt_keranjang[$transaksidetailid] = array("transaksidetailid"=>$transaksidetailid,"nama"=>$namaprod,"kodeproduk"=>$kodeproduk,"image_s"=>$image_s,"berat"=>$berat,"totalharga"=>$total,"qty"=>$qty,"harga"=>$harga,"xx"=>$a,"harga_asli"=>$harga_asli,"ketdiskon"=>$ketdiskon,"hargadiskon"=>$hargadiskon);

				$i %= 2;
				$i++;
				$a++;
			}
			

			$ongkoskirim2	= "$matauang. ". number_format($ongkoskirim,0,".",".");
				
			//tampilkan diskon voucher
			$qryv                    = sql(" SELECT voucherid, totaldiskon, totaltagihanafterdiskon, vouchercodeid, kodevoucher, totaltagihan from tbl_transaksi where transaksiid='$transaksiid'");
			$rowv                    = sql_fetch_data($qryv);
			$voucherid               = $rowv['voucherid'];
			$vouchercodeid           = $rowv['vouchercodeid'];
			$kodevoucher             = $rowv['kodevoucher'];
			$totaldiskon             = $rowv['totaldiskon'];
			$totaltagihanafterdiskon = $rowv['totaltagihanafterdiskon'];
			$totaltagihan            = $rowv['totaltagihan'];
			
			$namavoucher = sql_get_var("select nama from tbl_voucher where id = '$voucherid'");
			
			if($totaltagihanafterdiskon==0)
				$totaltagihanakhir = $totaltagihan+$ongkoskirim;
			else
				$totaltagihanakhir = $totaltagihanafterdiskon+$ongkoskirim;
			
			$totaltagihan1 = number_format($totaltagihan,0,",",".");
			$totaltagihan2 = "$matauang. $totaltagihan1";
			
			$totaltagihanakhir1 = number_format($totaltagihanakhir,0,",",".");
			$totaltagihanakhir2 = "$matauang. $totaltagihanakhir1";
			
			$totaldiskon1 = number_format($totaldiskon,0,",",".");
			$totaldiskon2 = "$matauang. $totaldiskon1";
			
			
			$kodeinvoice = base64_encode($invoiceid);
		
			$urlconfirm = "$fulldomain/cart/confirm/$kodeinvoice";
			$urldownload = "$fulldomain/cart/print/$kodeinvoice";
			
			$statusorder = "PAID";
			
			$warnafont = "#477603";
			
			// ambil data kontak admin
			$tk       = sql_get_var_row("select nama,alamat,telp,gsm from tbl_static where alias='kontak' limit 1");
			$namatk   = $tk['nama'];
			$alamattk = $tk['alamat'];
			$telptk   = $tk['telp'];
			$gsmtk    = $tk['gsm'];
		
			//Kirim Email ke Pembeli
			$sqlm = "select username,userfullname,useremail,userphonegsm from tbl_member where userid='$userid'";
			$hslm = sql($sqlm);
			$datam = sql_fetch_data($hslm);
			
			$userfullname = $datam['userfullname'];
			$useremail = $datam['useremail'];
			$userhandphone = $datam['userphonegsm'];
			
			sql_free_result($hslm);
			
			include("invoice.pdf.php");
			
			
			
			$pengirim 			= "$owner <$support_email>";
			$webmaster_email 	= "Support <$support_email>"; 
			$userEmail			= "$email"; 
			$userFullName		= "$userfullname"; 
			$headers 			= "From : $owner";
			$subject			= "$title, Bukti Belanja #$invoiceid";
			
			$sendmail			= sendmail($userfullname,$useremail,$subject,$html,$html,1);
			
			$contentsms	= "Terima kasih sukses telah melakukan belanja dengan nomor $invoiceid, kami segera mengirimkan pesanan Anda";
			$sendsms = kirimSMS($userphonegsm,$contentsms);
						
			
			//kirim email ke admin
			$to 		= "$support_email";
			$from 		= "$support_email";
			$headers 	= "From : $owner";
			$subject2 	= "Informasi Transaksi Lunas $invoiceid - $title";
			
			$sendmail	= sendmail($title,$to,$subject2,$html,$html,1);
				
			//kirim email ke reseller
			$perintah	="select userid,userfullname,avatar,posting,follower,following,tema,usergender,useraddress,cityname,useremail,userphonegsm from tbl_member where userid='$resellerid' limit 1";
			$hasil= sql($perintah);
			$profil= sql_fetch_data($hasil);
			sql_free_result($hasil);
			
			$iduser = $profil['userid'];
			$contactname = $profil['userfullname'];
			$avatar = $profil['avatar'];
			$contactuseremail = $profil['useremail'];
			$contactuserphone = $profil['userphonegsm'];
			

			$tores    = "$support_email";
			$fromres  = "$support_email";
			$headers  = "From : $owner";
			$subject3 = "Informasi Pemesanan No Invoice $invoiceid - $title";
			
			$sendmail	= sendmail($contactname,$contactuseremail,$subject3,$html,$html,1);
			
			$contentsms	= "Ada transaksi lunas dengan nomor invoice $invoiceid, silahkan dicek ke halaman sahabat sygma Anda";
			$sendsms = kirimSMS($contactuserphone,$contentsms);

			//kirim sms ke admin
			$sqlh     = "select gsm from tbl_static where alias='kontak' limit 1";
			$queryh   = sql($sqlh);
			$rowh     = sql_fetch_data($queryh);
			$gsmadmin = $rowh['gsm'];
		
			$kirimsms	= kirimSMS($gsmadmin,"info store: Informasi Pemesanan No Invoice $invoiceid - $title, silahkan login ke $fulldomain/panel utk melihat detail pemesanan. Terimakasih");
			
		}
     
	 
	 
      }
    }
  }
else if ($transaction == 'settlement')
{
  
  
   // For credit card transaction, we need to check whether transaction is challenge by FDS or not
  if ($type !='')
  {
			$ordernumber = $order_id;
			 //Proses Update Payment
/*			$sql = "select transid,create_date,create_userid,update_date,update_userid,hotelid,userid,ordernumber,checkindate,checkoutdate,folder,userfullname,useremail,userphone,guestname,note,roomid,total,paymid,status from tbl_transaksi where ordernumber='$ordernumber'";
			$hsl = sql($sql);
			$dt = sql_fetch_data($hsl);
			$userfullname = $dt['userfullname'];
			$useremail = $dt['useremail'];
			$userphone = $dt['userphone'];
			$guestname = $dt['guestname'];
			$note = $dt['note'];
			$roomid = $dt['roomid'];
			$hotelid = $dt['hotelid'];
			$transid = $dt['transid'];
			$total = $dt['total'];
			$paymid = $dt['paymid'];
			$status = $dt['status'];
			$folder = $dt['folder'];
			$userid = $dt['userid'];
			$checkindate = $dt['checkindate'];
			$checkoutdate = $dt['checkoutdate'];
			sql_free_result($hsl);
			
			$tanggal = tanggalhari($checkindate);
			$tanggal1 = tanggalhari($checkoutdate);
			
			$sqlm = "select namahotel,koordinat from tbl_hotel where hotelid='$hotelid'";
			$hslm = sql($sqlm);
			$datam = sql_fetch_data($hslm);
			
			$namahotel = $datam['namahotel'];
			$koordinat = $datam['koordinat'];
			
			sql_free_result($hslm);
			
			
			//Room
			$sql = "select transroomid,create_date,create_userid,update_date,update_userid,
					hotelid,ordernumber,roomid,date,jmlroom,rate,total,point from tbl_transaksi_room where ordernumber='$ordernumber'";
			$hsl = sql($sql);
			
			$totpoint = 0;
			
			while($data=sql_fetch_data($hsl))
			{
				$transroomid = $data['transroomid'];
				$roomid = $data['roomid'];
				$date = $data['date'];
				$dates = tanggalhari($date);
				$jmlroom = $data['jmlroom'];
				$rate = $data['rate'];
				$totals = $data['total'];
				
				$sqlk = "select nama from tbl_room where roomid='$roomid'";
				$hslk = sql($sqlk);
				$dt = sql_fetch_data($hslk);
				$tipekamar = $dt['nama'];
				sql_free_result($hslk);
				
				
				//Kurangi Inventory
				$sqlkurang = "update tbl_room_inventory set total=total-$jmlroom where tipe='0' and roomid='$roomid' and tanggal='$date'";
				$kurangi = sql($sqlkurang);
				
				
				$td .= '<tr>
				<td width="24%" style="padding:5px" align="left">'.$tipekamar.'</td>
				<td width="24%"style="padding:5px" align="left">'.$dates.'</td>
				<td width="11%" style="padding:5px" align="canter">'.$jmlroom.' room</td>
				<td width="25%" style="padding:5px" align="right">'.rupiah($rate).'</td>
				<td width="12%" style="padding:5px" align="right">'.rupiah($totals).'</td>
			  </tr>';
		
			}
			sql_free_result($hsl);
			
			//Insert Earn Point
			$lastpoint = sql_get_var("select sum(balance) as point from tbl_member_pointearn where status='1' and userid='$userid'");
			
			$totpoint = floor($total/$earnpoint);	
			
			$date = date("Y-m-d H:i:s");
			$expiredate = date('Y-m-d H:i:s', strtotime("+$pointexpire months"));
			$sql = "insert into tbl_member_pointearn(create_date,userid,transid,ordernumber,point,expiredate,status,conversion,balance)
					values('$date','$userid','$transid','$ordernumber','$totpoint','$expiredate','1','$earnpoint','$totpoint')";
			$hsl = sql($sql);
			
			//Insert Point History
			$nextbalance = $lastpoint+$totpoint;
			$date = date("Y-m-d H:i:s");
			$sql = "insert into tbl_member_point_history(create_date,userid,transid,ordernumber,point,tipe,balancetotal)
					values('$date','$userid','$transid','$ordernumber','$totpoint','CR','$nextbalance')";
			$hsl = sql($sql);
			
			$update = sql("update tbl_member set point=point+$totpoint where userid='$userid'");
			
			
			//Query Kebijakan Hotel
			$sql = "select reservasi,pembatalan,checkininfo from tbl_kebijakan_user_hotel where hotelid='$hotelid'";
			$hsl = sql($sql);
			
			$data = sql_fetch_data($hsl);
			$inforeservasi = $data['reservasi'];
			$infopembatalan = $data['pembatalan'];
			$infocheckin = $data['checkininfo'];
			
			sql_free_result($hsl);
			
			
			//Data User
			$sqlm = "select username,userfullname,useremail,userphonegsm from tbl_member where userid='$userid'";
			$hslm = sql($sqlm);
			$datam = sql_fetch_data($hslm);
			
			$userfullname = $datam['userfullname'];
			$useremail = $datam['useremail'];
			$userhandphone = $datam['userphonegsm'];
			
			sql_free_result($hslm);
			
			
			//Update Metode Pembayaran
			$update = sql("update tbl_transaksi set paymentmethod='$type',paymentinfo='$input' where ordernumber='$ordernumber'");
			
			
			
			
			$folderpdf = "$lokasiweb/pdf/$folder";
			if(!file_exists($folderpdf)) mkdir($folderpdf);
			
			
			include("booking.pdf.creditcard.php");
			
			$namafile = "voucher-$ordernumber-".md5("jc$ordernumber");
		
			
			//Kirim Email ke User
			$subject	= "JayakartaClub - Voucher #$ordernumber";

			$lokasifile	= $lokasiweb."/pdf/$folder/$namafile.pdf";
			$namafile2	= "voucher-$ordernumber.pdf";
			$qryemail	= sql("select keterangan, subject from tbl_wording where alias='voucher' and jenis = 'email' limit 1");
			$dataemail	= sql_fetch_data($qryemail);
			
		
			$subject    = $dataemail['subject'];
			$subject	= str_replace("[title]","$title",$subject);
			$subject	= str_replace("[ordernumber]","$ordernumber",$subject);
			
			$contentemail	= $dataemail['keterangan'];
			$contentemail	= str_replace("[userfullname]","$userfullname",$contentemail);
			$contentemail	= str_replace("[title]","$title",$contentemail);
			$contentemail	= str_replace("[namahotel]","$namahotel",$contentemail);
			$contentemail	= str_replace("[tipekamar]","$tipekamar",$contentemail);
			$contentemail	= str_replace("[tanggal]","$tanggal",$contentemail);
			$contentemail	= str_replace("[tanggal1]","$tanggal1",$contentemail);
			$contentemail	= str_replace("[ordernumber]","$ordernumber",$contentemail);
			
			$html = "<pre style=\"font-size:11pt\">
$contentemail
</pre>";
			$sendmail	= sendmail($userfullname,$useremail,$subject,$html,$html,$lokasifile,$namafile2);
					
			$perintah2 	= "update tbl_transaksi set status = '2', statusvoucher='1' where ordernumber='$ordernumber'";
			$hasil 		= sql($perintah2);	*/

    }
	
/*	// TODO set payment status in merchant's database to 'Settlement'
  $ordernumber = $order_id;
  $date = date("Y-m-d H:i:s");
  $perintah2 	= "update tbl_transaksi set settlement = '1',settlementdate='$date' where ordernumber='$ordernumber'";
  $hasil 		= sql($perintah2);	
  $message = "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
*/} 
else if($transaction == 'pending')
{
  
/*  	$ordernumber = $order_id;
	$sql = "select transid,create_date,create_userid,update_date,update_userid,hotelid,userid,ordernumber,checkindate,checkoutdate,folder,userfullname,useremail,userphone,guestname,note,roomid,total,paymid,status from tbl_transaksi where ordernumber='$ordernumber'";
	$hsl = sql($sql);
	$dt = sql_fetch_data($hsl);
	$userfullname = $dt['userfullname'];
	$useremail = $dt['useremail'];
	$userphone = $dt['userphone'];
	$guestname = $dt['guestname'];
	$note = $dt['note'];
	$roomid = $dt['roomid'];
	$hotelid = $dt['hotelid'];
	$transid = $dt['transid'];
	$total = $dt['total'];
	$paymid = $dt['paymid'];
	$status = $dt['status'];
	$folder = $dt['folder'];
	$userid = $dt['userid'];
	$checkindate = $dt['checkindate'];
	$checkoutdate = $dt['checkoutdate'];
	sql_free_result($hsl);
	
	$tanggal = tanggalhari($checkindate);
	$tanggal1 = tanggalhari($checkoutdate);
	
	$sqlm = "select namahotel,koordinat from tbl_hotel where hotelid='$hotelid'";
	$hslm = sql($sqlm);
	$datam = sql_fetch_data($hslm);
	
	$namahotel = $datam['namahotel'];
	$koordinat = $datam['koordinat'];
	
	sql_free_result($hslm);
	
	
	//Data User
	$sqlm = "select username,userfullname,useremail,userphonegsm from tbl_member where userid='$userid'";
	$hslm = sql($sqlm);
	$datam = sql_fetch_data($hslm);
	
	$userfullname = $datam['userfullname'];
	$useremail = $datam['useremail'];
	$userhandphone = $datam['userphonegsm'];
	
	sql_free_result($hslm);
	
	//Room
	$sql = "select transroomid,create_date,create_userid,update_date,update_userid,
			hotelid,ordernumber,roomid,date,jmlroom,rate,total,point from tbl_transaksi_room where ordernumber='$ordernumber'";
	$hsl = sql($sql);
	
	$totpoint = 0;
	
	while($data=sql_fetch_data($hsl))
	{
		$transroomid = $data['transroomid'];
		$roomid = $data['roomid'];
		$date = $data['date'];
		$dates = tanggalhari($date);
		$jmlroom = $data['jmlroom'];
		$rate = $data['rate'];
		$totals = $data['total'];
		
		$sqlk = "select nama from tbl_room where roomid='$roomid'";
		$hslk = sql($sqlk);
		$dt = sql_fetch_data($hslk);
		$tipekamar = $dt['nama'];
		sql_free_result($hslk);

	}
	sql_free_result($hsl);
	
	$subject	= "JayakartaClub - Booking Pending";
	$qryemail	= sql("select keterangan, subject from tbl_wording where alias='booking-pending' and jenis = 'email' limit 1");
	$dataemail	= sql_fetch_data($qryemail);
	

	$subject    = $dataemail['subject'];
	$subject	= str_replace("[title]","$title",$subject);
	$subject	= str_replace("[ordernumber]","$ordernumber",$subject);
	
	$contentemail	= $dataemail['keterangan'];
	$contentemail	= str_replace("[userfullname]","$userfullname",$contentemail);
	$contentemail	= str_replace("[title]","$title",$contentemail);
	$contentemail	= str_replace("[namahotel]","$namahotel",$contentemail);
	$contentemail	= str_replace("[tipekamar]","$tipekamar",$contentemail);
	$contentemail	= str_replace("[tanggal]","$tanggal",$contentemail);
	$contentemail	= str_replace("[tanggal1]","$tanggal1",$contentemail);
	$contentemail	= str_replace("[ordernumber]","$ordernumber",$contentemail);
	
	$html = "<pre style=\"font-size:11pt\">
$contentemail
</pre>";
			$sendmail	= sendmail($userfullname,$useremail,$subject,$html,$html,$lokasifile,$namafile2);
  
	// TODO set payment status in merchant's database to 'Pending'*/
	$message = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
} 
else if ($transaction == 'deny') 
{
  /*// TODO set payment status in merchant's database to 'Denied'
 	 $ordernumber = $order_id;
	$sql = "select transid,create_date,create_userid,update_date,update_userid,hotelid,userid,ordernumber,checkindate,checkoutdate,folder,userfullname,useremail,userphone,guestname,note,roomid,total,paymid,status from tbl_transaksi where ordernumber='$ordernumber'";
	$hsl = sql($sql);
	$dt = sql_fetch_data($hsl);
	$userfullname = $dt['userfullname'];
	$useremail = $dt['useremail'];
	$userphone = $dt['userphone'];
	$guestname = $dt['guestname'];
	$note = $dt['note'];
	$roomid = $dt['roomid'];
	$hotelid = $dt['hotelid'];
	$transid = $dt['transid'];
	$total = $dt['total'];
	$paymid = $dt['paymid'];
	$status = $dt['status'];
	$folder = $dt['folder'];
	$userid = $dt['userid'];
	$checkindate = $dt['checkindate'];
	$checkoutdate = $dt['checkoutdate'];
	sql_free_result($hsl);
	
	$tanggal = tanggalhari($checkindate);
	$tanggal1 = tanggalhari($checkoutdate);
	
	$sqlm = "select namahotel,koordinat from tbl_hotel where hotelid='$hotelid'";
	$hslm = sql($sqlm);
	$datam = sql_fetch_data($hslm);
	
	$namahotel = $datam['namahotel'];
	$koordinat = $datam['koordinat'];
	
	sql_free_result($hslm);
	
	
	//Data User
	$sqlm = "select username,userfullname,useremail,userphonegsm from tbl_member where userid='$userid'";
	$hslm = sql($sqlm);
	$datam = sql_fetch_data($hslm);
	
	$userfullname = $datam['userfullname'];
	$useremail = $datam['useremail'];
	$userhandphone = $datam['userphonegsm'];
	
	sql_free_result($hslm);
	
	//Room
	$sql = "select transroomid,create_date,create_userid,update_date,update_userid,
			hotelid,ordernumber,roomid,date,jmlroom,rate,total,point from tbl_transaksi_room where ordernumber='$ordernumber'";
	$hsl = sql($sql);
	
	$totpoint = 0;
	
	while($data=sql_fetch_data($hsl))
	{
		$transroomid = $data['transroomid'];
		$roomid = $data['roomid'];
		$date = $data['date'];
		$dates = tanggalhari($date);
		$jmlroom = $data['jmlroom'];
		$rate = $data['rate'];
		$totals = $data['total'];
		
		$sqlk = "select nama from tbl_room where roomid='$roomid'";
		$hslk = sql($sqlk);
		$dt = sql_fetch_data($hslk);
		$tipekamar = $dt['nama'];
		sql_free_result($hslk);

	}
	sql_free_result($hsl);
	
	$subject	= "JayakartaClub - Payment Denied";
	$qryemail	= sql("select keterangan, subject from tbl_wording where alias='payment-denied' and jenis = 'email' limit 1");
	$dataemail	= sql_fetch_data($qryemail);
	

	$subject    = $dataemail['subject'];
	$subject	= str_replace("[title]","$title",$subject);
	$subject	= str_replace("[ordernumber]","$ordernumber",$subject);
	
	$contentemail	= $dataemail['keterangan'];
	$contentemail	= str_replace("[userfullname]","$userfullname",$contentemail);
	$contentemail	= str_replace("[title]","$title",$contentemail);
	$contentemail	= str_replace("[namahotel]","$namahotel",$contentemail);
	$contentemail	= str_replace("[tipekamar]","$tipekamar",$contentemail);
	$contentemail	= str_replace("[tanggal]","$tanggal",$contentemail);
	$contentemail	= str_replace("[tanggal1]","$tanggal1",$contentemail);
	$contentemail	= str_replace("[ordernumber]","$ordernumber",$contentemail);
	
	$html = "<pre style=\"font-size:11pt\">
$contentemail
</pre>";
			$sendmail	= sendmail($userfullname,$useremail,$subject,$html,$html,$lokasifile,$namafile2);
  
  $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";*/
}
else if ($transaction == 'cancel') 
{
    // TODO set payment status in merchant's database to 'Denied'
/*  $ordernumber = $order_id;
	$sql = "select transid,create_date,create_userid,update_date,update_userid,hotelid,userid,ordernumber,checkindate,checkoutdate,folder,userfullname,useremail,userphone,guestname,note,roomid,total,paymid,status from tbl_transaksi where ordernumber='$ordernumber'";
	$hsl = sql($sql);
	$dt = sql_fetch_data($hsl);
	$userfullname = $dt['userfullname'];
	$useremail = $dt['useremail'];
	$userphone = $dt['userphone'];
	$guestname = $dt['guestname'];
	$note = $dt['note'];
	$roomid = $dt['roomid'];
	$hotelid = $dt['hotelid'];
	$transid = $dt['transid'];
	$total = $dt['total'];
	$paymid = $dt['paymid'];
	$status = $dt['status'];
	$folder = $dt['folder'];
	$userid = $dt['userid'];
	$checkindate = $dt['checkindate'];
	$checkoutdate = $dt['checkoutdate'];
	sql_free_result($hsl);
	
	$tanggal = tanggalhari($checkindate);
	$tanggal1 = tanggalhari($checkoutdate);
	
	$sqlm = "select namahotel,koordinat from tbl_hotel where hotelid='$hotelid'";
	$hslm = sql($sqlm);
	$datam = sql_fetch_data($hslm);
	
	$namahotel = $datam['namahotel'];
	$koordinat = $datam['koordinat'];
	
	sql_free_result($hslm);
	
	
	//Data User
	$sqlm = "select username,userfullname,useremail,userphonegsm from tbl_member where userid='$userid'";
	$hslm = sql($sqlm);
	$datam = sql_fetch_data($hslm);
	
	$userfullname = $datam['userfullname'];
	$useremail = $datam['useremail'];
	$userhandphone = $datam['userphonegsm'];
	
	sql_free_result($hslm);
	
	//Room
	$sql = "select transroomid,create_date,create_userid,update_date,update_userid,
			hotelid,ordernumber,roomid,date,jmlroom,rate,total,point from tbl_transaksi_room where ordernumber='$ordernumber'";
	$hsl = sql($sql);
	
	$totpoint = 0;
	
	while($data=sql_fetch_data($hsl))
	{
		$transroomid = $data['transroomid'];
		$roomid = $data['roomid'];
		$date = $data['date'];
		$dates = tanggalhari($date);
		$jmlroom = $data['jmlroom'];
		$rate = $data['rate'];
		$totals = $data['total'];
		
		$sqlk = "select nama from tbl_room where roomid='$roomid'";
		$hslk = sql($sqlk);
		$dt = sql_fetch_data($hslk);
		$tipekamar = $dt['nama'];
		sql_free_result($hslk);

	}
	sql_free_result($hsl);
	
	$subject	= "JayakartaClub - Booking is Canceled";
	$qryemail	= sql("select keterangan, subject from tbl_wording where alias='booking-cancel' and jenis = 'email' limit 1");
	$dataemail	= sql_fetch_data($qryemail);
	

	$subject    = $dataemail['subject'];
	$subject	= str_replace("[title]","$title",$subject);
	$subject	= str_replace("[ordernumber]","$ordernumber",$subject);
	
	$contentemail	= $dataemail['keterangan'];
	$contentemail	= str_replace("[userfullname]","$userfullname",$contentemail);
	$contentemail	= str_replace("[title]","$title",$contentemail);
	$contentemail	= str_replace("[namahotel]","$namahotel",$contentemail);
	$contentemail	= str_replace("[tipekamar]","$tipekamar",$contentemail);
	$contentemail	= str_replace("[tanggal]","$tanggal",$contentemail);
	$contentemail	= str_replace("[tanggal1]","$tanggal1",$contentemail);
	$contentemail	= str_replace("[ordernumber]","$ordernumber",$contentemail);
	
	$html = "<pre style=\"font-size:11pt\">
$contentemail
</pre>";
			$sendmail	= sendmail($userfullname,$useremail,$subject,$html,$html,$lokasifile,$namafile2);
*/  
  $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
}

$input = $HTTP_RAW_POST_DATA;
$data = date('Y-m-d H:i:s')." | $message\r\n";
$file = "logs/backlog.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);


?>