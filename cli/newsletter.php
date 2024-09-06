#!/usr/bin/php
<?php 
ini_set("display_errors","On");

include("../setingan/web.config.inc.php");

$lokasiweb = str_replace("/bin","",$lokasiweb);

//GET Configuration
$sql	= "select id, smtphost, smtpport, smtpuser, apikey,smtpsender,smtpname from tbl_konfigurasi_newsletter";
$query	= sql($sql);
$row = sql_fetch_data($query);

$smtphost = $row['smtphost'];
$smtpport = $row['smtpport'];
$smtpuser = $row['smtpuser'];
$smtpsender = $row['smtpsender'];
$smtpname = $row['smtpname'];
$apikey = $row['apikey'];
$id = $row['id'];

require_once '../librari/mandrill/src/Mandrill.php'; 

$i = 1;
echo "Start on ". date("Y-m-d H:i:s");
echo "\r\n";

$date = date("Y-m-d H:i:s");

$sql = "select id,newsletterid,userfullname,useremail,plain,subject,html from tbl_newsletter_subcriber where senddate < '$date' and mandrillid='' order by id asc limit 0,250";
$hsl = sql($sql);

while($data = sql_fetch_data($hsl))
{
	$id = $data['id'];
	$userfullname = $data['userfullname'];
	$useremail = $data['useremail'];
	$newsletterid = $data['newsletterid'];
	$subject = $data['subject'];
	$plainmail = $data['plain'];
	$htmlmail = $data['html'];
	
	
	if($newsletterid!="0")
	{
	
	$sql2 = "select subject,plainmail,htmlmail,tags,subaccount from tbl_newsletter where newsletterid='$newsletterid' limit 1";
	$hsl2 = sql($sql2);
	$dt = sql_fetch_data($hsl2);
	
	$subject = $dt['subject'];
	$plainmail = $dt['plainmail'];
	$htmlmail = $dt['htmlmail'];
	$tags = $dt['tags'];
	$subaccount = $dt['subaccount'];
	$jenis= $dt['jenis'];
	
	}
	
	
	$tags = explode(",",$tags);
	
	$subject = str_replace("--userfullname--",$userfullname,$subject);
	$subject = str_replace("--useremail--",$useremail,$subject);
	
	$plainmail = str_replace("--userfullname--",$userfullname,$plainmail);
	$plainmail = str_replace("--useremail--",$useremail,$plainmail);
	$plainmail = str_replace("--useraddress--",$useraddress,$plainmail);
	
	$htmlmail = str_replace("--userfullname--",$userfullname,$htmlmail);
	$htmlmail = str_replace("--useremail--",$useremail,$htmlmail);
	$htmlmail = str_replace("--useraddress--",$useraddress,$htmlmail);
	
	$htmlmail = stripslashes($htmlmail);
	$plainmail = stripslashes($plainmail);
	
	$track = strtolower(md5("$id$useremail$newsletterid"));
	
	if(!empty($subject))
	{
	
		$message = array(
		'html' => $htmlmail,
		'text' => $plainmail,
		'subject' => $subject,
		'from_email' => $smtpsender,
		'from_name' => $smtpname,
		'to' => array(
			array(
				'email' => $useremail,
				'name' => $userfullname,
				'type' => 'to'
			)
		),
		'headers' => array('Reply-To' => $sender),
		'important' => false,
		'track_opens' => null,
		'track_clicks' => null,
		'auto_text' => null,
		'auto_html' => null,
		'inline_css' => null,
		'url_strip_qs' => null,
		'preserve_recipients' => null,
		'view_content_link' => null,
		'bcc_address' => null,
		'tracking_domain' => null,
		'signing_domain' => null,
		'return_path_domain' => null,
		'merge' => true,
		'merge_language' => 'mailchimp',
		'tags' => $tags
		);
		
		$async = false;
		$ip_pool = 'Main Pool';
		
		try
		{
			$mandrill = new Mandrill($apikey);
			
			$result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
			
			print_r($result);
			
			$mandrillid = $result[0]['_id'];
			$status = $result[0]['status'];
			
			if($status=="sent") $status1=1;
			elseif($status=="queue") $status1=2;
			else $status1 = 0;
			
			
			$sql3 = "update tbl_newsletter_subcriber set status='$status1',mandrillid='$mandrillid' where id='$id'";
			$hsl3 = sql($sql3);

		
		}
		catch(Mandrill_Error $e)
		{
			$result = 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			
		}
		
	}
	$i++;

}
sql_free_result($hsl);

echo "\r\nEnd on". date("Y-m-d H:i:s")."\r\n";

?>
