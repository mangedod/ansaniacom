<?php 
function sql($sql)
{
	global $connect;
	$res = mysqli_query($connect,$sql);
	if(!$res) echo "ERROR: $sql ".mysqli_error($connect);
	return $res;
}
function sql_result($res,$arr,$field)
{
	$res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}
function sql_fetch_data($res)
{
	$data = mysqli_fetch_assoc($res);
	return $data;
}
function sql_num_rows($res)
{
	$data = mysqli_num_rows($res);
	return $data;
}
function sql_get_var_row($query)
{
	$res = sql($query);
	$row = mysqli_fetch_assoc($res);

	return $row;
	sql_free_result($res);
}
function sql_free_result($res)
{
	mysqli_free_result($res);
}

function newid($field,$tbl)
{
	$perintah	= "select max($field) as jml from $tbl";
	$query		= sql($perintah);
	$row		= sql_fetch_data($query);
	if($query) $newid = ($row['jml']) + 1; else $newid = 1;
	
	return $newid;
	sql_free_result($query);
}
function tanggal($tanggal)
	{
		global $site;
		
		if(!empty($tanggal))
		{
		$tahun = substr("$tanggal",0,4); 
		$bulan = substr("$tanggal", 5, 2); 
		$tgl = substr("$tanggal", 8, 2); 
		$jam = substr("$tanggal", 11, 2); 
		$mnt = substr("$tanggal", 14, 2); 
		if ($bulan=="01") { $bulan1="Januari"; }
		if ($bulan=="02"){ $bulan1="Februari"; }
		if ($bulan=="03"){ $bulan1="Maret"; }
		if ($bulan=="04"){ $bulan1="April"; }
		if ($bulan=="05"){ $bulan1="Mei"; }
		if ($bulan=="06"){ $bulan1="Juni"; }
		if ($bulan=="07"){ $bulan1="Juli"; }
		if ($bulan=="08"){ $bulan1="Agustus"; }
		if ($bulan=="09"){ $bulan1="September"; }
		if ($bulan=="10"){ $bulan1="Oktober"; }
		if ($bulan=="11"){ $bulan1="November"; }
		if ($bulan=="12") {$bulan1="Desember"; }
		
		$time = mktime(0,0,0,$bulan,$tgl,$tahun);
		$hari = getdate($time);
		$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
							"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");
		$hari = $array_hari[$hari[weekday]];
		
		if($site=="m")
		{
			$tgl="$hari, $tgl/$bulan/$tahun $jam:$mnt WIB ";
		}
		else
		{
			$tgl="$hari, $tgl $bulan1 $tahun $jam:$mnt WIB ";
		}
		return $tgl;
		}
		
	}
function tanggaltok($tanggal)
	{
		$tahun = substr("$tanggal",0,4); 
		$bulan = substr("$tanggal", 5, 2); 
		$tgl = substr("$tanggal", 8, 2); 
		$jam = substr("$tanggal", 11, 2); 
		$mnt = substr("$tanggal", 14, 2); 
		if ($bulan=="01") { $bulan1="Januari"; }
		if ($bulan=="02"){ $bulan1="Februari"; }
		if ($bulan=="03"){ $bulan1="Maret"; }
		if ($bulan=="04"){ $bulan1="April"; }
		if ($bulan=="05"){ $bulan1="Mei"; }
		if ($bulan=="06"){ $bulan1="Juni"; }
		if ($bulan=="07"){ $bulan1="Juli"; }
		if ($bulan=="08"){ $bulan1="Agustus"; }
		if ($bulan=="09"){ $bulan1="September"; }
		if ($bulan=="10"){ $bulan1="Oktober"; }
		if ($bulan=="11"){ $bulan1="November"; }
		if ($bulan=="12") {$bulan1="Desember"; }
		
		$time = mktime(0,0,0,$bulan,$tgl,$tahun);
		$hari = getdate($time);
		$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
							"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");
		$hari = $array_hari[$hari[weekday]];
		$tgl="$hari, $tgl $bulan1 $tahun ";			
		return $tgl;
	}
function tanggalonly($tanggal)
	{
		$tahun = substr("$tanggal",0,4); 
		$bulan = substr("$tanggal", 5, 2); 
		$tgl = substr("$tanggal", 8, 2); 
		$jam = substr("$tanggal", 11, 2); 
		$mnt = substr("$tanggal", 14, 2); 
		
		if ($bulan=="01") { $bulan1="Januari"; }
		if ($bulan=="02"){ $bulan1="Februari"; }
		if ($bulan=="03"){ $bulan1="Maret"; }
		if ($bulan=="04"){ $bulan1="April"; }
		if ($bulan=="05"){ $bulan1="Mei"; }
		if ($bulan=="06"){ $bulan1="Juni"; }
		if ($bulan=="07"){ $bulan1="Juli"; }
		if ($bulan=="08"){ $bulan1="Agustus"; }
		if ($bulan=="09"){ $bulan1="September"; }
		if ($bulan=="10"){ $bulan1="Oktober"; }
		if ($bulan=="11"){ $bulan1="November"; }
		if ($bulan=="12") {$bulan1="Desember"; }
		
		if(!empty($bulan)) 
		{
		$time = mktime(0,0,0,$bulan,$tgl,$tahun);
		$hari = getdate($time);
		$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
							"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");
		$hari = $array_hari[$hari[weekday]];
		$tgl="$tgl $bulan1 $tahun ";
		}
		return $tgl;
	}
function tanggalsingkat($tanggal)
	{
		$tahun = substr("$tanggal",0,4); 
		$bulan = substr("$tanggal", 5, 2); 
		$tgl = substr("$tanggal", 8, 2); 
		$jam = substr("$tanggal", 11, 2); 
		$mnt = substr("$tanggal", 14, 2); 
		if ($bulan=="01") { $bulan1="Jan"; }
		if ($bulan=="02"){ $bulan1="Feb"; }
		if ($bulan=="03"){ $bulan1="Mar"; }
		if ($bulan=="04"){ $bulan1="Apr"; }
		if ($bulan=="05"){ $bulan1="Mei"; }
		if ($bulan=="06"){ $bulan1="Jun"; }
		if ($bulan=="07"){ $bulan1="Jul"; }
		if ($bulan=="08"){ $bulan1="Ags"; }
		if ($bulan=="09"){ $bulan1="Sept"; }
		if ($bulan=="10"){ $bulan1="Okt"; }
		if ($bulan=="11"){ $bulan1="Nov"; }
		if ($bulan=="12") {$bulan1="Des"; }
		
		$time = mktime(0,0,0,$bulan,$tgl,$tahun);
		$hari = getdate($time);
		$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
							"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");
		$hari = $array_hari[$hari[weekday]];
		$tgl="$tgl $bulan1 $tahun ";			
		return $tgl;
	}
function clean($text)
{
	$text = strip_tags($text);
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1�', "", $text);
	$text = str_replace('or 0=0 --', "", $text);
	$text = str_replace("' or 1=1 #", "", $text);
	$text = str_replace('" or 1=1 #', "", $text);
	$text = str_replace('or 0=0 #', "", $text);
	$text = str_replace("' or 'x' = 'x", "", $text);
	$text = str_replace('" or "x" = "x', "", $text);
	$text = str_replace("') or ('x' = 'x", "", $text);
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1--', "", $text);
	$text = str_replace('or 1=1--', "", $text);
	$text = str_replace('" or a=a--', "", $text);
	$text = htmlspecialchars($text);
    return $text;
}

function cleaninsert($text)
{
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1�', "", $text);
	$text = str_replace('or 0=0 --', "", $text);
	$text = str_replace("' or 1=1 #", "", $text);
	$text = str_replace('" or 1=1 #', "", $text);
	$text = str_replace('or 0=0 #', "", $text);
	$text = str_replace("' or 'x' = 'x", "", $text);
	$text = str_replace('" or "x" = "x', "", $text);
	$text = str_replace("') or ('x' = 'x", "", $text);
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1--', "", $text);
	$text = str_replace('or 1=1--', "", $text);
	$text = str_replace('" or a=a--', "", $text);
	// $text = str_replace("'", "&apos;", $text);
	$text = htmlspecialchars($text);
    return $text;
}
function desc($text)
{
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1�', "", $text);
	$text = str_replace('or 0=0 --', "", $text);
	$text = str_replace("' or 1=1 #", "", $text);
	$text = str_replace('" or 1=1 #', "", $text);
	$text = str_replace('or 0=0 #', "", $text);
	$text = str_replace("' or 'x' = 'x", "", $text);
	$text = str_replace('" or "x" = "x', "", $text);
	$text = str_replace("') or ('x' = 'x", "", $text);
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1--', "", $text);
	$text = str_replace('or 1=1--', "", $text);
	$text = str_replace('" or a=a--', "", $text);
	$text = str_replace("'", "&apos;", $text);
    return $text;
}

function getimgext($src)
{
	$jenis = $src['type'];
	if(preg_match("/jp/i",$jenis)) $ext = "jpg";
	if(preg_match("/gif/i",$jenis)) $ext = "gif";
	if(preg_match("/png/i",$jenis)) $ext = "png";
	return $ext;
}

function resizeimg($src, $dst, $width, $height, $crop=0){

  if(!list($w,$h,$jenis) = getimagesize($src)) return false;
  
  if($jenis==1) $type = "gif";
  if($jenis==2) $type = "jpg";
  if($jenis==3) $type = "png";
  if($jenis==6) $type = "bmp";
  
  
  switch($type){
    case 'bmp': $img = imagecreatefromwbmp($src); break;
    case 'gif': $img = imagecreatefromgif($src); break;
    case 'jpg': $img = imagecreatefromjpeg($src); break;
    case 'png': $img = imagecreatefrompng($src); break;
    default : return false;
  }

  /*if($crop){
    if($w < $width or $h < $height) return false;
    $ratio = max($width/$w, $height/$h);
    $h = $height / $ratio;
    $x = ($w - $width / $ratio) / 2;
    $w = $width / $ratio;
  }
  else{
    if($w < $width and $h < $height) return false;
    $ratio = min($width/$w, $height/$h);
    $width = $w * $ratio;
    $height = $h * $ratio;
    $x = 0;
  }*/
  
    $ratio = min($width/$w, $height/$h);
    $width = $w * $ratio;
    $height = $h * $ratio;
    $x = 0;

  $new = imagecreatetruecolor($width, $height);

  if($type == "gif" or $type == "png"){
    imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
    imagealphablending($new, false);
    imagesavealpha($new, true);
  }

  imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

  switch($type){
    case 'bmp': imagewbmp($new, $dst); break;
    case 'gif': imagegif($new, $dst); break;
    case 'jpg': imagejpeg($new, $dst); break;
    case 'png': imagepng($new, $dst); break;
  }
  return true;
}

function cropimg($path,$dest,$w,$h)
{
	$image = new Imagick($path);
	$image->cropThumbnailImage($w,$h);
	$image->writeImage($dest);
	return true;
}

function sql_get_var($query)
{
	$res = sql($query);
	$row = mysqli_fetch_array($res);
	$rec = $row[0];
	return $rec;
	sql_free_result($res);
}

function getalias($string)
{
	$str = str_replace('-', ' ', $string);
	$str = trim(strtolower($str));
	$str = strip_tags($str);
	$str = trim($str, '-');
	return $str;
}

function getVar($url){
	$url  = str_replace("index.php?","",$url);
	$url  = str_replace("/index.php","",$url);
	$url  = str_replace("/api/android","",$url);
	$url  = str_replace(".html","",$url);
	
	$variable	= explode("/",$url);
	$kanal		= trim($variable[1]);
	
	$perintah	= "select count(*) as jumlah from tbl_kanal where nama='$kanal'";
	 
	$hasil		= sql($perintah);
	$data		= sql_fetch_data($hasil);
	$jumlah		= $data['jumlah'];
	sql_free_result($hasil);
	
	if($jumlah > 0)
	{
		$perintah	= "select id,nama,rubrik from tbl_kanal where nama='$kanal'  and site='$jenis' limit 1";
		$hasil		= sql($perintah);
		$data		= sql_fetch_data($hasil);
		$include	= "komponen/$kanal/$kanal.controller.php";
		$rubrik		= $data['rubrik'];
		sql_free_result($hasil);
		
		$jmlvar = count($variable);
		$var = "$include~~$rubrik~~";
		for($i=1;$i<=$jmlvar;$i++)
		{
			if($i==1) $var .="$kanal~~";
			else $var .= $variable[$i]."~~";
		}
		$var = substr($var,0,-2);
		$var = explode("~~",$var);
		return $var;
	}
	else
	{
		if(!empty($kanal))
		{
			$perintah =  "select count(*) as jumlah from tbl_member where username='$kanal'";
			$hasil = sql($perintah);
			$data = sql_fetch_data($hasil);
			$member = $data['jumlah'];
			
			$user_member=$kanal;
			
			if($member > 0)
			{
				$perintah =  "select id,nama,rubrik from tbl_kanal where nama='profile' limit 1";
				$hasil = sql($perintah);
				$data = sql_fetch_data($hasil);
				$include = "komponen/profile/profile.controller.php";
				$rubrik		= $data['rubrik'];
				sql_free_result($hasil);
				
				$jmlvar = count($variable);
				$var = "$include~~$rubrik~~";
				for($i=1;$i<=$jmlvar;$i++)
				{
					if($i==1) $var .="profile~~$kanal~~";
					else $var .= $variable[$i]."~~";
				}
				$var = substr($var,0,-2);
				$var = explode("~~",$var);
				return $var;
		
			}
			else
			{
				$perintah	= "select id,nama,rubrik from tbl_kanal where nama='home' limit 1";
				$hasil		= sql($perintah);
				$data		= sql_fetch_data($hasil);
				$include	= "komponen/home/home.controller.php";
				$rubrik		= $data['rubrik'];
				sql_free_result($hasil);
				
				$jmlvar = count($variable);
				$var = "$include~~$rubrik~~";
				for($i=1;$i<=$jmlvar;$i++)
				{
					if($i==1) $var .="home~~";
					else $var .= $variable[$i]."~~";
				}
				$var = substr($var,0,-2);
				$var = explode("~~",$var);
				return $var;
			}
		}
		else
		{
			$perintah	= "select id,nama,rubrik from tbl_kanal where nama='home' limit 1";
			$hasil		= sql($perintah);
			$data		= sql_fetch_data($hasil);
			$include	= "komponen/home/home.controller.php";
			$rubrik		= $data['rubrik'];
			sql_free_result($hasil);
			
			$jmlvar = count($variable);
			$var = "$include~~$rubrik~~";
			for($i=1;$i<=$jmlvar;$i++)
			{
				if($i==1) $var .="home~~";
				else $var .= $variable[$i]."~~";
			}
			$var = substr($var,0,-2);
			$var = explode("~~",$var);
			return $var;
		}
	}
}
function getNamaLengkap($username)
{
	global $database;
	$perintah = "select userfullname from tbl_member where username='$username'";
	$hasil = sql( $perintah);
	$data = sql_fetch_data($hasil);
	$userFullName = $data['userfullname'];
	sql_free_result($hasil);
	return $userFullName;
}
function getNamalengkapId($userid)
{
	global $database;
	$perintah = "select userfullname from tbl_member where userid='$userid'";
	$hasil = sql( $perintah);
	$data = sql_fetch_data($hasil);
	$userFullName = $data['userfullname'];
	sql_free_result($hasil);
	return $userFullName;
}
function generateCode($characters) {
      $possible = '23456789bcdfghjknpqrstvwxyz';
      $code = '';
      $i = 0;
      while ($i < $characters) { 
         $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
         $i++;
      }
      return $code;
   }
  
function emailhtml($content)
{
	global $fulldomain;
	$email = '<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Smart Life Business School</title>
   <style type="text/css">
   	a {color: #4A72AF;}
	body, #header h1, #header h2, p {margin: 0; padding: 0; font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #3f4042; line-height:22px;}
	#main {border: 1px solid #cfcece;}
	img {display: block;}
	#top-message p, #bottom-message p {color: #3f4042; font-size: 14px; font-family: Arial, Helvetica, sans-serif; }
	#header h1 {color: #ffffff !important; font-family: Arial, sans-serif; font-size: 24px; margin-bottom: 0!important; padding-bottom: 0; }
	#header h2 {color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; font-size: 24px; margin-bottom: 0 !important; padding-bottom: 0; }
	#header p {color: #ffffff !important; font-family: Arial, sans-serif; font-size: 14px;  }
	h1, h2, h3, h4, h5, h6 {margin: 0 0 0.8em 0;}
	h3 {font-size: 28px; color: #444444 !important; font-family: Arial, Helvetica, sans-serif; }
	h4 {font-size: 22px; color: #4A72AF !important; font-family: Arial, Helvetica, sans-serif; }
	h5 {font-size: 18px; color: #444444 !important; font-family: Arial, Helvetica, sans-serif; }
	p {font-size: 14px; color: #555555 !important; font-family: Arial, sans-serif; }
   .style1 {color: #FFFFFF;	font-weight: bold; }
   .notif{ font-size:14px; line-height:24px; }
   </style>
</head>

<body>
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="e4e4e4"><tr><td><!-- top message -->
<br />
	<table id="main" width="600" align="center" cellpadding="0" cellspacing="15" bgcolor="ffffff">
		<tr>
			<td colspan="2">
				<table id="header" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td width="570"><h1><img src="'.$fulldomain.'/images/img.mail.jpg" width="570" height="309" alt=""></h1></td>
					</tr>
				</table><!-- header -->			</td>
		</tr><!-- header -->
		
		<tr>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2"><!-- content 1 --><table width="100%" border="0" cellspacing="8" cellpadding="8">
              <tr>
                <td width="77%" valign="top" class="notif" >
                  <p style="font-size:14px; font-family:arial; line-height:24px;">'.$content.'</p></td>
              </tr>
              
            </table></td>
		</tr><!-- content 1 -->
		<tr>
			<td colspan="2"><p style="font-size:14px; font-family:arial; line-height:24px;"><strong> dFunStation.com </strong> Website yang menyajikan informasi tentang dunia anak dan jugaparenting. Semua hal tentang anak, ibu dan ayah bisa anda temukan di website ini.
</p></td>
		</tr><!-- content-2 -->
		
		<tr>
			<td width="292" height="30"></td>
	      <td width="263"><br>
	       <p> Temukan kami di Social Media</p>
	          <table width="100%" border="0" cellspacing="5" cellpadding="5">
            <tr>
              <td align="center" bgcolor="#003366"><span class="style1"><a href="http://www.facebook.com/ansania.com" style="color:#ffffff; text-decoration:none;">Facebook</a></span></td>
              <td align="center" bgcolor="#a02316"><span class="style1"><a href="https://www.instagram.com/ansania.com" style="color:#ffffff; text-decoration:none;">Instagram</a></span></td>
			  <td align="center" bgcolor="#0099FF"><span class="style1"><a href="http://www.twitter.com/ansania.com" style="color:#ffffff; text-decoration:none;">Twitter</a></span></td>
            </tr>
          </table>
          <br></td>
		</tr>
	</table>
	<!-- main -->
	<table id="bottom-message" cellpadding="20" cellspacing="0" width="600" align="center">
		<tr>
			<td align="center"><p>Anda bisa mengatur atau unsubcribe notifikasi dengan melakukan setting notifikasi dibagian menu setting akun. <a href="#">Setting Email Notifikasi </a> | <a href="#">Forward to a friend</a></p>
				</td>
		</tr>
	</table><!-- top message -->
</td></tr></table><!-- wrapper -->

</body>
</html>';
return $email; 
}

function sendmail($namapenerima,$emailpenerima,$subject,$isi,$isihtml)
{
	global $smtphost,$support,$smtpuser,$smtppass,$smtpport,$issmtp;
	
	$mail = new PHPMailer;
	if($issmtp)
	{
		$mail->IsSMTP();
		$mail->Host			= $smtphost;
		$mail->SMTPAuth		= true;
		$mail->Username		= $smtpuser;
		$mail->Password		= $smtppass;
		//$mail->SMTPSecure	= 'ssl';
		$mail->Port			= $smtpport;
	}
	$mail->From			= $smtpuser;
	$mail->FromName 	= $support;
	$mail->AddAddress("$emailpenerima","$namapenerima");
	$mail->IsHTML(true);
	$mail->Subject		= $subject;
	$mail->Body 		= $isihtml;
	$mail->AltBody		= $isi;
	

	if(!$mail->Send())
	{
		return false;
	}
	else
	{
		return true;
	}
}

function bersihHTML($text) {

	$text = str_replace("<strong>","--strong--",$text);
	$text = str_replace("</strong>","--/strong--",$text);
	$text = str_replace("</strong>","--/strong--",$text);
	$text = str_replace("<b>","--b--",$text);
	$text = str_replace("</b>","--/b--",$text);
	$text = str_replace("<i>","--i--",$text);
	$text = str_replace("</i>","--/i--",$text);
	$text = str_replace("<em>","--em--",$text);
	$text = str_replace("</em>","--/em--",$text);
	$text = str_replace("<u>","--u--",$text);
	$text = str_replace("</u>","--/u--",$text);
	$text = str_replace("<br />","--br--",$text);
	$text = str_replace("</p>","--br-- --br--",$text);

	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out HTML tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace HTML entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

	$replace = array ("",
					  "",
					  "\\1",
					  "\"",
					  "&",
					  "<",
					  ">",
					  " ",
					  chr(161),
					  chr(162),
					  chr(163),
					  chr(169),
					  "chr(\\1)");
	
	$text = strip_tags($text);
		
	$text = str_replace("--strong--","<b>",$text);
	$text = str_replace("--/strong--","</b>",$text);
	$text = str_replace("--b--","<b>",$text);
	$text = str_replace("--/b--","</b>",$text);
	$text = str_replace("--i--","<i>",$text);
	$text = str_replace("--/i--","</i>",$text);
	$text = str_replace("--br--","\n",$text);
	$text = str_replace("--em--","<i>",$text);
	$text = str_replace("--/em--","</i>",$text);
	$text = str_replace("--u--","<u>",$text);
	$text = str_replace("--/u--","</u>",$text);
	$text = str_replace("<br />","\n",$text);
	$text = str_replace("<br>","\n",$text);
	$text = str_replace("'","`",$text);
	
	return $text;


}
function bersihPDF($text) {

	$text = str_replace("<strong>","--strong--",$text);
	$text = str_replace("</strong>","--/strong--",$text);
	$text = str_replace("</strong>","--/strong--",$text);
	$text = str_replace("<b>","--b--",$text);
	$text = str_replace("</b>","--/b--",$text);
	$text = str_replace("<i>","--i--",$text);
	$text = str_replace("</i>","--/i--",$text);
	$text = str_replace("<em>","--em--",$text);
	$text = str_replace("</em>","--/em--",$text);
	$text = str_replace("<u>","--u--",$text);
	$text = str_replace("</u>","--/u--",$text);
	$text = str_replace("<br />","--br--",$text);
	$text = str_replace("</p>","--br-- --br--",$text);

	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out HTML tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace HTML entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

	$replace = array ("",
					  "",
					  "\\1",
					  "\"",
					  "&",
					  "<",
					  ">",
					  " ",
					  chr(161),
					  chr(162),
					  chr(163),
					  chr(169),
					  "chr(\\1)");
	
	$text = strip_tags($text);
		
	$text = str_replace("--strong--","<b>",$text);
	$text = str_replace("--/strong--","</b>",$text);
	$text = str_replace("--b--","<b>",$text);
	$text = str_replace("--/b--","</b>",$text);
	$text = str_replace("--i--","<i>",$text);
	$text = str_replace("--/i--","</i>",$text);
	$text = str_replace("--br--","\n",$text);
	$text = str_replace("--em--","<i>",$text);
	$text = str_replace("--/em--","</i>",$text);
	$text = str_replace("--u--","<u>",$text);
	$text = str_replace("--/u--","</u>",$text);
	$text = str_replace("<br />","\n",$text);
	$text = str_replace("<br>","\n",$text);
	$text = str_replace("'","`",$text);
	
	return $text;


}
function bersih($text) {

	/*$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out HTML tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace HTML entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

	$replace = array ("",
					  "",
					  "\\1",
					  "\"",
					  "&",
					  "<",
					  ">",
					  " ",
					  chr(161),
					  chr(162),
					  chr(163),
					  chr(169),
					  "chr(\\1)");
	
	$text = preg_replace_callback($search, $replace, $text);
	$text = str_replace("'","`",$text);
	$text = strip_tags($text);
	$text = nl2br($text);*/
	$text = strip_tags($text);
	return $text;

}
function getProfileName($userName)
{
		global $database,$domain,$lokasiwebmember,$lokasiweb,$fulldomain;
		$perintah1	= "select userid,username,userfullname,avatar from tbl_member where username='$userName'";
		$hasil1		= sql($perintah1);
		$data1	= sql_fetch_data($hasil1);

		$userdirname = $data1['userdirname'];
		$avatar		= $data1['avatar'];
		$userid = $data1['userid'];
		$nama	= ucwords($data1['userfullname']);
		$username = $data1['username'];
		$profileurl = "$domain/$username";
			
			if(empty($avatar)){ $gambar = "$fulldomain/images/no_pic.jpg"; }
			else
			{				
				$gambar = "$lokasiwebmember/avatars/$avatar";
			}
	
		$data = array("userid"=>$userid,"username"=>$username,"userfullname"=>$nama,"avatar"=>$gambar,"url"=>$profileurl);
		return $data;

}
function getProfileId($userid)
{
		global $database,$domain,$lokasiwebmember,$lokasiweb,$fulldomain;
		$perintah1	= "select userid,username,userfullname,avatar,aboutme,userphonegsm from tbl_member where userid='$userid'";
		$hasil1		= sql($perintah1);
		$data1	= sql_fetch_data($hasil1);
		
		$userdirname = $data1['userdirname'];
		$avatar		= $data1['avatar'];
		$userid = $data1['userid'];
		$aboutme = $data1['aboutme'];
		$nama	= ucwords($data1['userfullname']);
		$username = $data1['username'];
		$userphonegsm = $data1['userphonegsm'];
		$profileurl = "$domain/$username";
			
			if(empty($avatar)){ $gambar = "$domain/images/no_pic.jpg"; }
			else
			{
				$gambar = "$lokasiwebmember/avatars/$avatar";
			}
	
		$data = array("userid"=>$userid,"username"=>$username,"userfullname"=>$nama,"avatar"=>$gambar,"url"=>$profileurl,"aboutme"=>$aboutme,"userphonegsm"=>$userphonegsm);
		return $data;

}
function tanggalLahir($tanggal)
	{
		$tahun = substr("$tanggal",0,4); 
		$bulan = substr("$tanggal", 5, 2); 
		$tgl = substr("$tanggal", 8, 2); 
		$jam = substr("$tanggal", 11, 2); 
		$mnt = substr("$tanggal", 14, 2); 
		if ($bulan=="01") { $bulan1="January"; }
		if ($bulan=="02"){ $bulan1="February"; }
		if ($bulan=="03"){ $bulan1="March"; }
		if ($bulan=="04"){ $bulan1="April"; }
		if ($bulan=="05"){ $bulan1="May"; }
		if ($bulan=="06"){ $bulan1="June"; }
		if ($bulan=="07"){ $bulan1="July"; }
		if ($bulan=="08"){ $bulan1="August"; }
		if ($bulan=="09"){ $bulan1="September"; }
		if ($bulan=="10"){ $bulan1="October"; }
		if ($bulan=="11"){ $bulan1="November"; }
		if ($bulan=="12") {$bulan1="December"; }
		
		$tgl="$bulan1 $tgl, $tahun";			
		return $tgl;
	}

/*video youtube*/

//Fungsi mendapatkan Title
function getTitle($str)
{
	$final=array();
	$returnArray=array();
	$pattern="/<title type='text'>(.*)\<\/title\>/Uis";
	preg_match_all($pattern, $str, $returnArray, PREG_SET_ORDER);
	if(isset($returnArray[0][1]))
	{
		return $returnArray[0][1];
	}
	else {
		return "NA";
	}
}

//Fungsi mendapatkan Desk
function getDesc($str)
{
	$final=array();
	$returnArray=array();
	$pattern="/<content type='text'>(.*)\<\/content\>/Uis";
	preg_match_all($pattern, $str, $returnArray, PREG_SET_ORDER);
	if(isset($returnArray[0][1])) {
		return $returnArray[0][1];
	}
	else {
		return "NA";
	}
}

//Fungsi Mendapatkan URL Video
function getFlvUrl($str) 
{
	$final=array();
	$returnArray=array();
	$pattern="/<media:player url='(.*)'/Uis";
	//$pattern="/<media:content url='(.*)' type='application\/x-shockwave-flash'/Uis";
	preg_match_all($pattern, $str, $returnArray, PREG_SET_ORDER);

	if(isset($returnArray[0][1])) {
		return $returnArray[0][1];
	}
	else {
		return "#";
	}
}

//Fungsi Mendapatkan Thumbnail
function getThumbnailUrl($str,$returnAllThumbsAsArray=false) 
{
	$final=array();
	$returnArray=array();
	$imgArray=array();
	$imgPattern="/<media:thumbnail url='(.*)'/Uis";
	preg_match_all($imgPattern, $str, $tmp, PREG_SET_ORDER);
	
	$c=count($tmp);
	$l=-1;
	foreach($tmp as $key=>$value){
		$value=$value[1];
		$imgArray[]=$value;
	}
	if($returnAllThumbsAsArray===true){
		return $imgArray;
	}
	else{
		return $imgArray[1];
	}
}
function save_image($inPath,$outPath)
{ //Download images from remote server
    $in=    fopen($inPath, "rb");
    $out=   fopen($outPath, "wb");
    while ($chunk = fread($in,8192))
    {
        fwrite($out, $chunk, 8192);
    }
    fclose($in);
    fclose($out);
}
function setlog($from,$to,$pesan,$url)
{
	global $database;
	$perintah = "insert into tbl_notifikasi(fromusername,tousername,pesan,url) values ('$from','$to','$pesan','$url')";
	$hasil = sql( $perintah);
	
	//Pengirim
	$sql = "select username,userfullname,pvnotif,useremail,bounching from tbl_member where username='$from'";
	$hsl = sql($sql);
	$data = sql_fetch_data($hsl);
	$fromuserfullname = $data['userfullname'];
	sql_free_result($hsl);
	
	//Kirim Email
	$sql = "select userid,username,userfullname,pvnotif,useremail,bounching from tbl_member where username='$to'";
	$hsl = sql($sql);
	$data = sql_fetch_data($hsl);
	$username = $data['username'];
	$userid = $data['userid'];
	$userfullname = $data['userfullname'];
	$pvnotif = $data['pvnotif'];
	$useremail = $data['useremail'];
	$bounching = $data['bounching'];
	sql_free_result($hsl);
	
	$title = "Interaksi Status";
	$message = "$fromuserfullname $pesan";
	
	//Page
	$urls = explode("/",$url);
	$kanal = $urls[3];
	$aksi = $urls[4];
	$id = $urls[5];
	

	$data = array("title"=>$title,"message"=>$message,"tipe"=>$tipe,"kanal"=>$kanal,"aksi"=>$aksi,"postid"=>$id);
	
	sendGCMbyName($title,$message, $username, $data);
	 

	
	
	if($bounching==0 && $pvnotif==0)
	{
		if($pesan=="mengomentari status anda")
		{
			$isi = "
$fromuserfullname Mengomentari Laporan Anda
=========================================================================

Yth. $userfullname,

$fromuserfullname telah mengomentari sebuah laporan anda di SEFTMentoring
Silahkan login untuk membalas komentar yang diberikan atau klik url dibawah
ini:

$url

Terima Kasih
$owner
___________________________________________________________
Jika sahabat tidak ingin menerima email pemberitahuan ini
silahkan login ke SEFTMentoring dan update notifikasi setting
";

$isihtml = "<br>
$fromuserfullname Mengomentari Laporan anda di SEFTMentoring<br>
=========================================================================<br><br>

Yth. $userfullname,<br>
$fromuserfullname telah mengomentari sebuah laporan anda di SEFTMentoring
Silahkan login untuk membalas komentar yang diberikan atau klik url dibawah
ini:<br>
<br>

<a href=\"$url\">Lihat Komentar</a>
<br>
<br>
Terima Kasih<br>

$owner<br />
___________________________________________________________<br />
Jika sahabat tidak ingin menerima email pemberitahuan ini
silahkan login ke SEFTMentoring dan update notifikasi setting
<br />";

$subject = "$fromuserfullname Mengomentari laporan Sahabat di SEFTMentoring";

sendmail($userfullname,$useremail,$subject,$isi,$isihtml);
		}
		
		if($pesan=="mengikuti anda di SEFTMentoring")
		{
			$isi = "
$fromuserfullname mengikuti anda di SEFTMentoring
=========================================================================

Yth. $userfullname,

Sahabat memilik pengikut baru di SEFTMentoring bernama $fromuserfullname
Silahkan login untuk melihat profile pengikut baru sahabat di url
dibawah ini:

$url

Terima Kasih
$owner
___________________________________________________________
Jika sahabat tidak ingin menerima email pemberitahuan ini
silahkan login ke SEFTMentoring dan update notifikasi setting";

$isihtml = "<br>
$fromuserfullname mengikuti anda di SEFTMentoring<br>
=========================================================================<br><br>

Yth. $userfullname,<br>
Sahabat memilik pengikut baru di SEFTMentoring bernama $fromuserfullname
Silahkan login untuk melihat profile pengikut baru sahabat di url
dibawah ini:<br>
<br>

<a href=\"$url\">Lihat Pengikut</a>
<br>
<br>
Terima Kasih<br>

$owner<br />
___________________________________________________________<br />
Jika sahabat tidak ingin menerima email pemberitahuan ini
silahkan login ke SEFTMentoring dan update notifikasi setting
<br />";

$subject = "$fromuserfullname Mengikuti Sahabat di SEFTMentoring";

sendmail($userfullname,$useremail,$subject,$isi,$isihtml);
		}
		
		if($pesan=="menulis status didinding anda")
		{
			$isi = "
$fromuserfullname Menyapa Sahabat di SEFTMentoring
=========================================================================

Yth. $userfullname,

$fromuserfullname telah memberikan sebuah laporan di SEFTMentoring, untuk
membalas laporannya silahkan login atau dengan mengklik url dibawah ini:

$url

Terima Kasih
$owner
___________________________________________________________
Jika sahabat tidak ingin menerima email pemberitahuan ini
silahkan login ke SEFTMentoring dan update notifikasi setting";

$isihtml = "<br>
$fromuserfullname Menyapa Sahabat di SEFTMentoring<br>
=========================================================================<br><br>

Yth. $userfullname,<br>
$fromuserfullname telah memberikan sebuah laporan di SEFTMentoring, untuk
membalas laporannya silahkan login atau dengan mengklik url dibawah ini:<br>
<br>

<a href=\"$url\">Lihat laporan</a>
<br>
<br>
Terima Kasih<br>

$owner<br />
___________________________________________________________<br />
Jika sahabat tidak ingin menerima email pemberitahuan ini
silahkan login ke SEFTMentoring dan update notifikasi setting
<br />
";

$subject = "$fromuserfullname menyapa Sahabat di SEFTMentoring";

sendmail($userfullname,$useremail,$subject,$isi,$isihtml);
		}
		
	}
	
	
}
function multisort (&$array, $key) 
{
	$valsort	= array();
	$ret		= array();
	reset($array);
	foreach ($array as $ii => $va) 
	{
		$valsort[$ii] = $va[$key];
	}
	
	arsort($valsort);
	
	foreach ($valsort as $ii => $va) 
	{
		$ret[$ii]=$array[$ii];
	}
	$array = $ret;
	
	return $array;
}

function geturl($text)
{
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	if(preg_match($reg_exUrl, $text, $url)) 
	{
		$urls = $url[0];
		$urls = strip_tags($urls);
		$text =  preg_replace($reg_exUrl, "<a href=\"$urls\" target=\"_blank\">$urls</a> ", $text);  
	} else {
		   $text = $text;
	}
	return $text;
}

function confirmUser($username, $password){

   global $conn;

   /* Add slashes if necessary (for query) */

   if(!get_magic_quotes_gpc()) {

	$username = addslashes($username);

   }

/* Verify that user is in database */
   $q = "select userpassword from tbl_member where username = '$username'";
  
   $result = sql($q);
   $num = sql_num_rows($result);
   if(!$result or  ( $num< 1)){

      return 1; //Indicates username failure

   }

/* Retrieve password from result, strip slashes */
   $dbarray = sql_fetch_data($result);

   $dbarray['userpassword']  = stripslashes($dbarray['userpassword']);

   $password = stripslashes($password);

/* Validate that password is correct */
   if($password == $dbarray['userpassword']){

      return 0; //Success! Username and password confirmed

   }

   else{

      return 2; //Indicates password failure

   }

}



function checkLogin(){

   /* Check if user has been remembered */

   if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){

      $_SESSION['username'] = $_COOKIE['cookname'];

      $_SESSION['password'] = $_COOKIE['cookpass'];

   }

/* Username and password have been set */
   if(isset($_SESSION['username']) && isset($_SESSION['password'])){

      /* Confirm that username and password are valid */

      if(confirmUser($_SESSION['username'], $_SESSION['password']) != 0){

         /* Variables are incorrect, user not logged in */

         unset($_SESSION['username']);

         unset($_SESSION['password']);

         return false;

      }

      return true;

   }

   /* User not logged in */

   else{

      return false;

   }

}

function getemoticon($string)
{
	global $domain,$database;
	
	$string = str_replace("'","",$string);
	
	$string = explode(" ",$string);
	$jstring = count($string);
	$string2 = "";
	for($i=0;$i<$jstring;$i++)
	{
		$kata = $string[$i];
		
		$perintah = "select gambar_emoticon,kode from tbl_emoticon where kode='$kata'";
		$hasil = sql($perintah);
		$data = sql_fetch_data($hasil);
		sql_free_result($hasil);
		
		$gambar = $data['gambar_emoticon'];
		if(!empty($gambar))
		{
			$string2 .=" <img src=\"$domain/images/emoticon/$gambar\" style=\"width: 22px !important; height: auto !important; \"; alt=\"\" border=\"0\" /> ";
		}
		else
		{
			$string2 .= "$kata ";
		}	
		
	}
	
	$perintah = "select gambar_emoticon,kode from tbl_emoticon";
	$hasil = sql($perintah);
	while($data = sql_fetch_data($hasil))
	{
		$gambar = $data['gambar_emoticon'];
		$kode = $data['kode'];
		$img = " <img src=\"$domain/images/emoticon/$gambar\" alt=\"$kode\" border=\"0\" /> ";
		$string2 = str_replace($kode,"$img",$string2);
	}
	sql_free_result($hasil);
	
	return $string2;
}
function hp($nohp) {
    // kadang ada penulisan no hp 0811 239 345
    $nohp = str_replace(" ","",$nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace("(","",$nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace(")","",$nohp);
    // kadang ada penulisan no hp 0811.239.345
    $nohp = str_replace(".","",$nohp);

    // cek apakah no hp mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($nohp))){
        // cek apakah no hp karakter 1-3 adalah +62
       /* if(substr(trim($nohp), 0, 2)=='62'){
            $hp = trim($nohp);
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif(substr(trim($nohp), 0, 1)=='0'){
            $hp = '62'.substr(trim($nohp), 1);
        }*/
		
		$hp = trim($nohp);
    }
	
	$hp = str_replace("+","",$hp);
    return $hp;
}

function kirimSMS($dest,$pesan,$idbaru="")
{
	global $smshost,$smsusername,$smspasswd,$database,$lokasiweb,$smshost,$smsapikey;
	
	$dest = hp($dest);
	
	$url = "http://$smshost/api/sms.php";
	$fields = array(
		'apikey' => $smsapikey,
		'msisdn' => $dest,
		'pesan' => $pesan
	);

	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');

	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$output = curl_exec($ch);
	curl_close($ch);
	
	
	if(preg_match("/accepted/i",$output) || preg_match("/1/i",$output))
	{
		if(!empty($idbaru))
		{	
			//Input Ke Database dulu
			$date = date("Y-m-d H:i:s");
			$insert	= "insert into tbl_smsc_smskeluar(create_date,msisdn,pesan,tanggal,status) values('$date','$dest','$pesan','$date','2')";
			$qinsert	= sql($insert);
			$berhasil = true;
		}
		else
		{
			$insert	= "update tbl_smsc_smskeluar set status=2 where id='$ibaru'";
			$qinsert	= sql($insert);
		}
			
	}
	else
	{
		$berhasil = false;
	}
	return $berhasil;
}


function encode($string) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string,$i,1));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
    }
    return $hash;
}

function decode($string) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}


function rupiah($val)
{
	$num = number_format($val,0,'','.');
	return $num;
}

function durasi($sec)
{
	
	if(gmdate("H",$sec)=="00") $durasi = gmdate("i:s",$sec);
	else $durasi = gmdate("H:i:s", $sec);
	
	return $durasi;
}
function ringkas($str,$panjang)
{
	$str = strip_tags($str);
	$arr = explode(" ",$str);
	
	for($i=0;$i<$panjang;$i++)
	{
		$newstr .="$arr[$i] ";
	}
	return $newstr;
}

function updatejmlsec()
{
	$sql = "select secid from tbl_audio_sec";
	$hsl = sql($sql);
	while($data=sql_fetch_data($hsl))
	{
		$secid = $data['secid'];
		$jml = sql_get_var("select count(*) as jml from tbl_audio where secid='$secid' and published='1'");
		
		sql("update tbl_audio_sec set num='$jml' where secid='$secid'");
	}
}

function mil2km($miles)
{ 
	$ratio = 1.609344; 
	$kms = $miles *$ratio;
	$kms = number_format($kms,2,",",".");
	return $kms; 
}

function earnpoin($activity,$userid)
{
	global $pointexpire;
	
	$totpoint = sql_get_var("select poin from tbl_poin_config where alias='$activity'");
	$lastpoint = sql_get_var("select sum(balance) as point from tbl_member_pointearn where status='1' and userid='$userid'");
	
	$date = date("Y-m-d H:i:s");
	$expiredate = date('Y-m-d H:i:s', strtotime("+$pointexpire months"));
	$sql = "insert into tbl_member_pointearn(activity,create_date,userid,transid,ordernumber,point,expiredate,status,conversion,balance)
			values('$activity','$date','$userid','$transid','$ordernumber','$totpoint','$expiredate','1','$earnpoint','$totpoint')";
	$hsl = sql($sql);
	
	//Insert Point History
	$nextbalance = $lastpoint+$totpoint;
	$date = date("Y-m-d H:i:s");
	$sql = "insert into tbl_member_point_history(activity,create_date,userid,transid,ordernumber,point,tipe,balancetotal)
			values('$activity','$date','$userid','$transid','$ordernumber','$totpoint','CR','$nextbalance')";
	$hsl = sql($sql);
	
	$update = sql("update tbl_member set point=point+$totpoint where userid='$userid'");
}
function sendGCMbyName($judul,$pesan, $username , $datainfo)
{
	 define( 'API_ACCESS_KEY', 'AAAA9gfXVKg:APA91bG5DEgY1bfvIr4ym3kwG1J6aJCofXB3Jn09P2Bk-VeZj85PcBPH0ixxRs9AB0HbTOGqVTCev5LYjWSVNswk2srATpgk9JTS-fxpBVoenNXaCxgy-h5YxG7UgMjIpoZlCELrYkhqeb2UZ9219DiTGuJesP4UfQ' );

	 $userid = sql_get_var("select userid from tbl_member where username='$username'");
	 $ks = sql("select deviceid from tbl_device where userid='$userid'");
	 
	 	
	$uri = $_SERVER['REQUEST_URI'];
	$post = serialize($_POST);
	$data = date('Y-m-d H:i:s')." | $userid | $judul | $pesan | $datainfo\r\n";
	$file = "backlog-gcm.txt";
	$open = fopen($file, "a+"); 
	fwrite($open, "$data"); 
	fclose($open);

	 
	 while($data= sql_fetch_data($ks))
	 {
	 
	 	$deviceid = $data['deviceid'];
		
		if(!empty($deviceid))
		{
	
		 $registrationIds = $deviceid;
		 $msg = array
			  (
			'body' 	=> $pesan,
			'title'	=> $judul,
					'icon'	=> 'myicon',/*Default Icon*/
					'sound' => 'mySound'/*Default sound*/
			  );
		$fields = array
				(
					'to'		=> $registrationIds,
					'notification'	=> $msg,
					'data' => $datainfo
				);
		
		
		$headers = array
				(
					'Authorization: key=' . API_ACCESS_KEY,
					'Content-Type: application/json'
				);

		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );

		
		}
	}

}



function cleanword($text, $allowed_tags = '<b><img><i><sup><sub><em><strong><u><br><p>')
{
        $text = str_replace('<img', '~~img',$text);
		mb_regex_encoding('UTF-8');
        //replace MS special characters first
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        //make sure _all_ html entities are converted to the plain ascii equivalents - it appears
        //in some MS headers, some html entities are encoded and some aren't
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        //try to strip out any C style comments first, since these, embedded in html comments, seem to
        //prevent strip_tags from removing html comments (MS Word introduced combination)
        if(mb_stripos($text, '/*') !== FALSE){
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
		
		//m:r
		 $text = preg_replace(array('#<m:r[^>]*>(.*?)</m:r>#isu'), array(''), $text);
		
        //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be
        //'<1' becomes '< 1'(note: somewhat application specific)
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        //strip out inline css and simplify style tags
        $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
        $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears
        //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains
        //some MS Style Definitions - this last bit gets rid of any leftover comments */
        $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        if($num_matches){
              $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
        }
		$text = str_replace('~~img', '<img',$text);
        return $text;
    }

function getNamaSec($secid,$lang)
{
	global $database;
	
	$sql 		= "select namasec$lang from tbl_product_sec where secid='$secid'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$namasec 	= $row["namasec$lang"];
	sql_free_result($query);
	
	return $namasec;
}
function getAliasSec($secid)
{
	global $database;
	
	$sql 		= "select alias from tbl_product_sec where secid='$secid'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$alias	 	= $row['alias'];
	sql_free_result($query);
	
	return $alias;
}
function getSecId($alias)
{
	global $database;
	
	$sql 		= "select secid from tbl_product_sec where alias='$alias'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$secid	 	= $row['secid'];
	sql_free_result($query);
	
	return $secid;
}
function getNamaSub($subid,$lang)
{
	global $database;
	
	$sql 		= "select namasub$lang from tbl_product_sub where subid='$subid'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$namasub 	= $row["namasub$lang"];
	sql_free_result($query);
	
	return $namasub;
}
function getAliasSub($subid)
{
	global $database;
	
	$sql 		= "select alias from tbl_product_sub where subid='$subid'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$alias	 	= $row['alias'];
	sql_free_result($query);
	
	return $alias;
}
function getSubId($alias)
{
	global $database;
	
	$sql 		= "select subid from tbl_product_sub where alias='$alias'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$subid	 	= $row['subid'];
	sql_free_result($query);
	
	return $subid;
}
?>