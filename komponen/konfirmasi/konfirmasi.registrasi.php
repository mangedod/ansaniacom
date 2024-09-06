<?php 
	/*$kodeinvoice  = $var[3];
	$invoiceiduri = base64_decode($kodeinvoice);*/
if($_POST['save'] == 1)
{
	$invoiceid		= $_POST['invoiceid'];
	$bank			= $_POST['bank'];
	$total 			= $_POST['total'];
	$daribank 		= $_POST['bankdari'];
	$norek 			= $_POST['norek'];
	$name 			= $_POST['name'];
	$pesan 			= bersihHTML($_POST['pesan']);
	$tgl_konfirmasi	= date("Y-m-d H:i:s");
	$jumlah_bayar	= $_POST['jumlah_bayar'];
	
	$tgl_bayar	= $_POST['date'];
	
	$statustrans	= sql_get_var("select status from tbl_transaksi_registrasi where reginvoiceid='$invoiceid'");

	if($statustrans == '5')
	{
		$pesanhasil ="Nomor Invoice <b>$invoiceid</b> yang Anda masukan sudah dibatalkan karena melebihi batas waktu transfer yang ditentukan. Silahkan hubungi CS kami untuk melakukan invoice ulang.";
		$berhasil   = 0;
		$tpl->assign("style","alert-danger");
	}
	else
	{
		if(empty($statustrans))
		{
			$pesanhasil ="Nomor Invoice <b>$invoiceid</b> yang Anda masukan tidak terdaftar di data transaksi kami. Silahkan periksa kembali no invoice Anda.";
			$berhasil   = 0;
			$tpl->assign("style","alert-danger");
		}
		elseif($statustrans== '1')
		{
			$konfirmasiid	= sql_get_var("select id from tbl_konfirmasi_registrasi where invoiceid='$invoiceid'");
				
			if(empty($konfirmasiid))
			{
				$sql	= "insert into tbl_konfirmasi_registrasi (`bank_tujuan`, `bank_dari`, `norek`, `jumlah_bayar`, `total_bayar`, `atas_nama`, `status`, `create_date`, 
							`tanggalbayar`,`invoiceid`,`pesan`) values ('$bank', '$daribank', '$norek', '$jumlah_bayar', '$total', '$name', '1', '$tgl_konfirmasi', 
							'$tgl_bayar', '$invoiceid','$pesan')";
				$query = sql($sql);
					
				if($query)
				{
					$update	= sql("update tbl_transaksi_registrasi set status='2' where reginvoiceid='$invoiceid'");
					
					$qrys	= sql("select userid,email from tbl_transaksi_registrasi where reginvoiceid='$invoiceid'");
					$rows	= sql_fetch_data($qrys);
					
					$userid           = $rows['userid'];
					$email            = $rows['email'];
					// $orderid          = $rows['orderid'];
					$alamatpengiriman = $rows['alamatpengiriman'];

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
						
					$pengirim        = "$owner <$support_email>";
					$webmaster_email = "Support <$support_email>"; 
					$headers         = "From : $owner";
					$subject         = "$title, Konfirmasi Pembayaran Registrasi";
					$contentemail    = "
										Dear $userfullname,<br />
										<br />
										Terimakasih atas pembayaran yang dilakukan untuk <strong>$invoiceid</strong><br />
										Kami telah menerima pembayaran Anda. Kami akan melakukan validasi dan pengecekan kelengkapan dokumen pendaftaran Anda sebagai Sahabat Sygma.<br />
										<br />
										        
										Terimakasih atas kepercayaan Anda. Kami senang dapat melayani Anda.<br />
										<br />
										Regards,<br />
										<br />
										$owner";
					
					$sendmail			= sendmail($userfullname,$email,$subject,$contentemail,$contentemail,1);
					
					//kirim email ke admin
					$to       = "$support_email";
					$from     = "$support_email";
					$headers  = "From : $owner";
					$subject1 = "Konfirmasi Pembayaran Registrasi";
					$message  = "Ada Informasi mengenai Konfirmasi Registrasi Sahabat Sygma $title dengan no invoice $invoiceid";
					
					$sendmail1	= sendmail($title,$support_email,$subject1,$message,$message,1);
					
					$pesanhasil = "Terimakasih telah melakukan konfirmasi.";
					$berhasil   = 1;
					$tpl->assign("style","alert-success");
				
					//kirim sms ke admin
					$sqlh     = "select gsm from tbl_static where alias='kontak' limit 1";
					$queryh   = sql($sqlh);
					$rowh     = sql_fetch_data($queryh);
					$gsmadmin = $rowh['gsm'];
				
					$kirimsms	= kirimSMS($gsmadmin,"info registrasi sahabat sygma: pembeli dgn invoice $invoiceid telah melakukan konfirmasi pembayaran. Terimakasih");
					//,silahkan login ke $fulldomain/panel utk melihat detail pembayaran
					
					$contentsms	= sql_get_var("select keterangan from tbl_wording where alias='paid' and jenis = 'sms' limit 1");
			
					$contentsms	= str_replace("[owner]","$owner",$contentsms);
					$contentsms	= str_replace("[title]","$title",$contentsms);
					$contentsms	= str_replace("[invoiceid]","$invoiceid",$contentsms);
					$contentsms	= str_replace("[totaltagihan]","$jumlah_bayar",$contentsms);
					$contentsms	= str_replace("[pembayaran]","$pembayaran",$contentsms);

					$contentsms = "Terimakasih telah melakukan pembayaran transaksi registrasi sebagai Sahabat Sygma di $title dengan No. Invoice $invoiceid. Total $jumlah_bayar. - $owner";
			
					$sendsms = kirimSMS($userphonegsm,$contentsms);
					
					setlog($_SESSION[userfullname],"system","Melakukan Konfirmasi Pembayaran.","$fulldomain/panel/index.php?tab=5&tabsub=9&kanal=konfirmasi&invoice=$invoice","confirm");
				}
			}
			else
			{
				$pesanhasil = "Nomor Invoice <b>{$invoiceid}</b> yang Anda masukan sudah melakukan konfirmasi sebelumnya.";//<a href='$fulldomain/cart/transaction.html'>Kembali</a>
				$berhasil   = 0;
				$tpl->assign("style","alert-danger");
			}
		}
		else
		{
			$pesanhasil = "Nomor Invoice <b>{$invoiceid}</b> yang Anda masukan sudah melakukan konfirmasi sebelumnya.";// <a href='$fulldomain/member/history.html'>Kembali</a>
			$berhasil   = 0;
			$tpl->assign("style","alert-danger");
		}
	}
}
		$tpl->assign("pesanhasil",$pesanhasil);
		$tpl->assign("berhasil",$berhasil);


		$perintah 	= "select * from tbl_norek where status='1' $where";
		$hasil 		= sql($perintah);
		while ($data=sql_fetch_data($hasil)) 
		{
			$id			= $data['id'];
			$id_bank	= $data['bank'];
			$norek		= $data['norek'];
			
			$sql8	= "select namabank from tbl_bank where bankid='$id_bank'";
			$res8	= sql($sql8);
			$row8	= sql_fetch_data($res8);
			$namabank	= $row8['namabank'];
			
			sql_free_result($res8);
			
			$nama = "$namabank ($norek)";
			
			$bank[$id] = array("id"=>$id, "nama"=>$nama, "id_bank"=>$id_bank);
		}
		sql_free_result($hasil);
		$tpl->assign("bank",$bank);
		$tpl->assign("now",date("Y-m-d"));
?>