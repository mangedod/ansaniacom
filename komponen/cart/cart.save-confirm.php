<?php
	$invoiceid      = $_POST['invoiceid'];
	$bank           = $_POST['bank'];
	$total          = $_POST['total'];
	$daribank       = $_POST['bankdari'];
	$norek          = $_POST['norek'];
	$atas_nama      = $_POST['name'];
	$pesan          = bersihHTML($_POST['pesan']);
	$tgl_konfirmasi = date("Y-m-d H:i:s");
	$jumlah_bayar   = $_POST['jumlah_bayar'];
	
	$tgl_bayar	= $_POST['date'];
	
	$statustrans = sql_get_var("select status from tbl_transaksi where invoiceid='$invoiceid'");
	$kodeinvoice = base64_encode($invoiceid);
	if(!empty($kodeinvoice)){
		$urlkembali  = "$fulldomain"."cart/confirm/$kodeinvoice";
	}else{
		$urlkembali = "$fulldomain"."cart/confirm";
	}
	
	
	if($statustrans == '5')
	{
		$pesanhasil ="Invoice Number <b>$invoiceid</b> you already aborted due to exceeding the specified transfer deadline. Please contact our CS to do an invoice.";
		$tpl->assign("style","alert-danger");
	}
	else
	{
		if(empty($statustrans))
		{
			$pesanhasil ="Invoice Number <b>$invoiceid</b> you input is not listed in our transaction data. Please double check Your invoice no.<br> <a href='$urlkembali' >Back</a>";
			$tpl->assign("style","alert-danger");
		}
		else if(!preg_match("/^[a-zA-Z ]*$/",$atas_nama))
		{
			$pesanhasil ="Wrong writing sender's name, sender's name can only use letters. Please check back with perngirim account account name is correct.<br> <a href='$urlkembali' >Back</a>";
			$tpl->assign("style","alert-danger");
		}
		else if(!preg_match("/^[0-9]*$/",$jumlah_bayar))
		{
			$pesanhasil ="Wrong writing the amount of the transfer, the amount of the Transfer can only use numbers. Example : 150000. <br> <a href='$urlkembali' >Back</a>";
			$tpl->assign("style","alert-danger");
		}
		else if(!preg_match("/^[0-9 .]*$/",$norek))
		{
			$pesanhasil ="Writing the wrong account number of the sender, the sender's account number can only use numbers. Example : 99956587974. Please check back with the correct account number.<br> <a href='$urlkembali' >Back</a>";
			$tpl->assign("style","alert-danger");
		}
		elseif( $statustrans== '1')
		{
			$konfirmasiid	= sql_get_var("select id from tbl_konfirmasi where invoiceid='$invoiceid'");
				
			if(empty($konfirmasiid))
			{
				$sql	= "insert into tbl_konfirmasi (`bank_tujuan`, `bank_dari`, `norek`, `jumlah_bayar`, `total_bayar`, `metode_pembayaran`, `atas_nama`, `status`, `create_date`, 
							`tanggalbayar`,`invoiceid`,`pesan`) values ('$bank', '$daribank', '$norek', '$jumlah_bayar', '$total','$pembayaran', '$atas_nama', '1', '$tgl_konfirmasi', 
							'$tgl_bayar', '$invoiceid','$pesan')";
				$query = sql($sql);
					
				if($query)
				{
					$update	= sql("update tbl_transaksi set status='2',bank_tujuan='$bank' where invoiceid='$invoiceid'");
					
					$qrys	= sql("select userid,email,orderid,alamatpengiriman,vouchercodeid,kodevoucher from tbl_transaksi where invoiceid='$invoiceid'");
					$rows	= sql_fetch_data($qrys);
					
					$userid           = $rows['userid'];
					$email            = $rows['email'];
					$orderid          = $rows['orderid'];
					$alamatpengiriman = $rows['alamatpengiriman'];
					$vouchercodeid    = $rows['vouchercodeid'];
					$kodevoucher      = $rows['kodevoucher'];

					sql("update tbl_voucher_kode set dikirim='1' where kodevoucher='$kodevoucher' and vouchercodeid='$vouchercodeid'");
					
					if(empty($userid) or ($userid=='0'))
					{
						$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
						$hasil 		= sql($perintah);
						$data 		= sql_fetch_data($hasil);
			
						$userfullname	= $data['userfullname'];
						$idtamu			= $data['id'];
						$useraddress 	= $data['useraddress'];
						$propinsiid		= $data['propinsiid'];
						$kotaid 		= $data['kotaid'];
						$userpostcode 	= $data['userpostcode'];
						$email 			= $data['useremail'];
						$telephone 		= $data['userphone'];
						$userphonegsm 	= $data['userphonegsm'];
					}
					else
					{
						$perintah 	= "SELECT * FROM tbl_member WHERE userid='$userid'";
						$hasil 		= sql($perintah);
						$data 		= sql_fetch_data($hasil);
			
						$userfullname	= $data['userfullname'];
						$userid			= $data['userid'];
						$propinsiid		= $data['propinsiid'];
						$useraddress 	= $data['useraddress'];
						$kotaid 		= $data['cityname'];
						$userpostcode	= $data['userpostcode'];
						$email 			= $data['useremail'];
						$telephone 		= $data['userphone'];
						$userphonegsm	= $data['userphonegsm'];
					}
					
					//kota
					$kota 		= sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
					
					$billingalamat = "$useraddress<br>$kota<br>$userpostcode<br>Telp. $userphonegsm";
					
					$contentemail	= sql_get_var("select keterangan from tbl_wording where alias='konfirmasi' and jenis = 'email' limit 1");
					$contentemail	= str_replace("[userfullname]","$userfullname",$contentemail);
					$contentemail	= str_replace("[title]","$title",$contentemail);
					$contentemail	= str_replace("[invoiceid]","$invoiceid",$contentemail);
					$contentemail	= str_replace("[alamatpengiriman]","$alamatpengiriman",$contentemail);
					$contentemail	= str_replace("[owner]","$owner",$contentemail);
					$contentemail	= str_replace("[fulldomain]","$fulldomain",$contentemail);
						
					$pengirim 			= "$owner <$support_email>";
					$webmaster_email 	= "Support <$support_email>"; 
					$headers 			= "From : $owner";
					$subject			= "$title, Payment Confirmation";
					
					$sendmail			= sendmail($userfullname,$email,$subject,$contentemail,$contentemail,1);
					
					//kirim email ke admin
					$to       = "$support_email";
					$from     = "$support_email";
					$headers  = "From : $owner";
					$subject1 = "Payment Confirmation";
					$message  = "There is information about the online Confirmation $title with no invoice $invoiceid";
					
					$sendmail1	= sendmail($title,$support_email,$subject1,$message,$message,1);
					
					//kirim email ke reseller
					/*$tores      = "$owner <$support_email>";
					$fromres    = "Support <$support_email>";
					$headers    = "From : $owner";
					$subjectres = "Payment Confirmation";
					$message    = "There is information about the online Confirmation $title with no invoice $invoiceid";
					
					$sendmail1	= sendmail($contactname,$contactuseremail,$subjectres,$message,$message,1);*/
					
					$pesanhasil = "Thank you've done confirm. Items will be immediately sent to your place.";
					$tpl->assign("style","alert-success");
				
					//kirim sms ke admin
					$sqlh     = "select gsm from tbl_static where alias='kontak' limit 1";
					$queryh   = sql($sqlh);
					$rowh     = sql_fetch_data($queryh);
					$gsmadmin = $rowh['gsm'];
				
					$kirimsms	= kirimSMS($gsmadmin,"info store: the buyer with an invoice $invoiceid been doing Payment Confirmation, please login to $fulldomain"."panel to view the payment details. Thanks");
					
					//kirim sms ke reseller
					// $kirimsms	= kirimSMS($contactuserphone,"info store: the buyer with an invoice $invoiceid been doing Payment Confirmation, please login to $fulldomain"."/member to view the payment details. Thanks");
					
					if(!empty($smsKeuangan))
					{
						//kirim sms ke bagian Keuangan
						$kirimsms	= kirimSMS($smsKeuangan,"info store - $title: the buyer with an invoice $invoiceid have done a transfer payment. Thanks");
					}
					
					$contentsms	= sql_get_var("select keterangan from tbl_wording where alias='paid' and jenis = 'sms' limit 1");
			
					$contentsms	= str_replace("[owner]","$owner",$contentsms);
					$contentsms	= str_replace("[title]","$title",$contentsms);
					$contentsms	= str_replace("[invoiceid]","$invoiceid",$contentsms);
					$contentsms	= str_replace("[totaltagihan]","$jumlah_bayar",$contentsms);
					$contentsms	= str_replace("[pembayaran]","$pembayaran",$contentsms);
			
					$sendsms = kirimSMS($userphonegsm,$contentsms);
					
					setlog($_SESSION[userfullname],"system","Do The Payment Confirmation.","$fulldomain"."panel/index.php?tab=5&tabsub=9&kanal=konfirmasi&invoice=$invoice","confirm");
				}
			}
			else
			{
				$pesanhasil = "Invoice Number <b>{$invoiceid}</b> you've done the previous confirmation.<a href='$fulldomain"."cart/transaction'>Back</a>";
				$tpl->assign("style","alert-danger");
			}
		}
		else
		{
			$pesanhasil = "Invoice Number <b>{$invoiceid}</b> you've done the previous confirmation. <a href='$fulldomain"."/member/history'>Back</a>";
			$tpl->assign("style","alert-danger");
		}
	}
		$tpl->assign("salah",$pesanhasil);
?>