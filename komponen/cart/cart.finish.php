<?php
$pesan = $var[4];
if($pesan=="sukses")
{
	$ordernumber = $_GET['order_id'];
	$statuscode = $_GET['status_code'];
	$transstatus = $_GET['transaction_status'];
	
	$tpl->assign("urlpdf","$fulldomain"."/cart/print/".base64_encode($ordernumber));
	
	if($statuscode=="200")
	{
		if($transstatus=="capture")
		{
			$message = "Thank you for shopping at $title, your transactions with a transaction number <strong> $ordernumber </strong> has been successfully done. <br> we will immediately process your transactions and do delivery order, We will inform the delivery receipt number and other information via email or SMS. <br>";
			$sukses = 1;
		}
		elseif($transstatus=="settlement")
		{
			$message = "Thank you for shopping at $title, your transactions with a transaction number <strong> $ordernumber </strong> has been successfully done. <br> we will immediately process your transactions and do delivery order, we will inform the delivery receipt number and other information via email or SMS. <br>.";
			$sukses = 1;
		}
		else
		{
			$message = "Your transaction number <strong> $ordernumber </strong> incomplete or delayed <br>, chances are you have not made payment via Your payment channel Select. Our <br> will process your transaction if you have make payment in advance.";
			$sukses = 1;
		}
		
	}
	else if ($statuscode=="202")
	{
		$message = "Your transaction number <strong> $ordernumber </strong> failed <br> the transaction is already done, but they fraud. <br> Please feel free to try the transaction again";
		$sukses = 0;
	}
	else
	{
		$message = "Sorry your transaction by transaction number <strong> $ordernumber </strong> not completed or pending, <br> Please do payment in advance by chanel payment you have selected
					<br> we will cancel your transaction if in the time of $jedatransfer hours does not make a payment";
		$sukses = 0;
	}
	unset($_SESSION['ordernumber']);
}
else if($pesan=="gagal")
{
	$ordernumber = $_GET['order_id'];
	$statuscode = $_GET['status_code'];
	$transstatus = $_GET['transaction_status'];
	
	if($statuscode=="200")
	{
		if($transstatus=="capture")
		{
			$message = "Thank you for shopping at $title, your transactions with a transaction number <strong> $ordernumber </strong> has been successfully done. <br> we will immediately process your transactions and do delivery order, we will inform the delivery receipt number and other information via email or SMS. <br>";
			$sukses = 1;
		}
		else
		{
		$message = "Your transaction number <strong> $ordernumber </strong> incomplete or delayed <br>, chances are you have not made payment via Your payment channel Select. Our <br> will process your transaction if you have make payment in advance.";
			$sukses = 1;
		}
	}
	else if ($statuscode=="202")
	{
		$message = "Your transaction number <strong> $ordernumber </strong> failed <br> the transaction is already done, but they fraud. <br> Please feel free to try the transaction again";
		$sukses = 0;
	}
	else
	{
		$message = "Your transaction number <strong> $ordernumber </strong> failed. <br> Please feel free to try the transaction again";
		$sukses = 0;
	}
	
}
else if($pesan=="error")
{
	$ordernumber = $_GET['order_id'];
	$statuscode = $_GET['status_code'];
	$transstatus = $_GET['transaction_status'];
	
	if($statuscode=="200")
	{
		if($transstatus=="capture")
		{
			$message = "Thank you for shopping at $title, your transactions with a transaction number <strong> $ordernumber </strong> has been successfully done. <br> we will immediately process your transactions and do delivery order, we will inform the delivery receipt number and other information via email or SMS. <br>";
			$sukses = 1;
		}
		else
		{
		$message = "Your transaction number <strong> $ordernumber </strong> incomplete or delayed <br>, chances are you have not made payment via Your payment channel Select. Our <br> will process your transaction if you have make payment in advance.";
			$sukses = 1;
		}
	}
	else if ($statuscode=="202")
	{
		$message = "Your transaction number <strong> $ordernumber </strong> failed <br> the transaction is already done, but they fraud. <br> Please feel free to try the transaction again";
		$sukses = 0;
	}
}
else
{
	$message = "Sorry your transaction by transaction number <strong> $ordernumber </strong> failed, <br>Please retry transaction";
		$sukses = 0;
}

$tpl->assign("message",$message);
$tpl->assign("pesan",$pesan);
$tpl->assign("sukses",$sukses);

unset($_SESSION['orderid']);
?>