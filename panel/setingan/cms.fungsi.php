<?php 
function sql($sql)
{
	global $connect;
	$res = mysqli_query($connect,$sql);
	//if(!$res) echo mysqli_error($connect)." SQL: $sql";
	return $res;
}
function sql_result($res,$arr,$field)
{
	$res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}
function sql_fetch_object($res)
{
	$res = mysqli_fetch_object($res);
	return $res;
}
function sql_fetch_array($res)
{
	$res = mysqli_fetch_array($res);
	return $res;
}
function sql_fetch_data($res)
{
	if($res)
	{
		$res = mysqli_fetch_assoc($res);
		return $res;
	}
}
function sql_fetch_assoc($res)
{
	$res = mysqli_fetch_assoc($res);
	return $res;
}

function sql_num_rows($res)
{
	$res = mysqli_num_rows($res);
	return $res;
}
function sql_free_result($res)
{
	if($res)
	{
	$res = mysqli_free_result($res);
	return $res;
	}
}

function sql_real_escape_str($str)
{
	global $connect;

	return mysqli_real_escape_string($connect, $str);
}
function rupiah($val)
{
	$num = number_format($val,0,'','.');
	return $num;
}
function getbulan($bulan)
{
	if ($bulan=="01"){ $bulan1="Januari"; }
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

	return $bulan1;
}
function kodeoto($filename)
{
	$filename = str_replace(" ","",$filename);
	$filename = str_replace("index.php?kanal=","",$filename);
	
	$perintah = "select kode,keterangan from tbl_cms_menuchild where url='$filename'";
	$hasil = sql($perintah);
	$data= sql_fetch_data($hasil);
	$kode = $data['kode'];
	sql_free_result($hasil);
	
	if(empty($kode)) $kode = "---";
	
	$otoritas = $_SESSION['cms_otoritas'];
	$cek  = substr_count($otoritas,"$kode");
	
	$otoritas2 = explode("$kode",$otoritas);
	$test = $otoritas2[1];
	$otoritas3 = explode("~",$test);
	$test = $otoritas3[0];
	$cek1  = substr_count($otoritas,"$kode");
	
	$cek2  = substr_count($test,"1");
	if($cek2 !=0) { $lihat = "1"; }
	$cek3  = substr_count($test,"2");
	if($cek3 !=0) { $input = "1"; } 
	$cek4  = substr_count($test,"3");
	if($cek4 !=0) { $edit = "1"; }
	$cek5  = substr_count($test,"4");
	if($cek5 !=0) { $delete = "1"; }
	
	$ar[0] = array("oto"=>$cek,"view"=>$lihat,"add"=>$input,"edit"=>$edit,"delete"=>$delete);
	return $ar;

}


function getorder($defaultby,$defaultorder,$param)
{
	global $kanal,$aksi,$alamat,$hlm;
	
	if(!is_array($param)) $param = array();
	
	for($i=0;$i<count($param);$i++)
	{
		$pars = $param[$i];
		$par = $pars[0]."='".$pars[1]."'";
		$par2 = urlencode($pars[0])."=".urlencode($pars[1]);
		$params .="and $par ";
		$urlparams .="&$par2";
	}
	
	$req  = $_GET['order'];
	$sesname = "$kanal-$aksi-";
	if($req && !empty($_SESSION[$sesname.'orderby']) )
	{
		if($_SESSION[$sesname.'order']){
			if($_SESSION[$sesname.'order']=="asc") $order = "desc";
				else $order = "asc";
			}
		$_SESSION[$sesname.'order'] = $order;
		$_SESSION[$sesname.'orderby'] = $req;
	}
	elseif($req && empty($_SESSION[$sesname.'orderby']) )
	{
		$_SESSION[$sesname.'orderby'] = $req;
		if($_SESSION[$sesname.'order']){
			if($_SESSION[$sesname.'order']=="asc") $order = "desc";
				else $order = "asc";
		}
		else $order = "asc";
		$_SESSION[$sesname.'order'] = $order;
	}
	
	
	if($_SESSION[$sesname.'orderby']){ $order = "$params order by ".$_SESSION[$sesname.'orderby']." ".$_SESSION[$sesname.'order']; }
	else {	$order = "$params order by $defaultby $defaultorder";	}
	
	$res[0] = $order;
	$res[1] = "$alamat&aksi=$aksi&$urlparams&hlm=$hlm";
	
	return $res;

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

function cleaninsert($text)
{
	$text = str_replace("' OR ''='", "", $text);
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
	$text = htmlspecialchars($text);
    return $text;
}
/*function desc($text)
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
	$text = str_replace("'", "`", $text);
    return $text;
}*/

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
	/*if(eregi("jp",$jenis)) $ext = "jpg";
	if(eregi("gif",$jenis)) $ext = "gif";
	if(eregi("png",$jenis)) $ext = "png";*/

	if(preg_match("/jp/i",$jenis)) $ext = "jpg";
	if(preg_match("/gif/i",$jenis)) $ext = "gif";
	if(preg_match("/png/i",$jenis)) $ext = "png";
	return $ext;
}

function getvideoext($src)
{
	$jenis = $src['type'];
	$ext = explode("/",$jenis);
	$ext = $ext[1];
	if($ext=="octet-stream")
	{
		$ext = substr($src['name'], -3);
	}

	return $ext;
}


/*function resizeimg($src, $dst, $width, $height, $crop=0){

  if(!list($w,$h,$jenis) = getimagesize($src)) return false;
  
  
  if($jenis=="1") $type = "gif";
  if($jenis=="2") $type = "jpg";
  if($jenis=="3") $type = "png";
  if($jenis=="6") $type = "bmp";
  
  
  switch($type){
    case 'bmp': $img = imagecreatefromwbmp($src); break;
    case 'gif': $img = imagecreatefromgif($src); break;
    case 'jpg': $img = imagecreatefromjpeg($src); break;
    case 'png': $img = imagecreatefrompng($src); break;
    default : return false;
  }

	$height = ($height/$h)*$w;
	$x = 0;

  $new = imagecreatetruecolor($width, $height);

  if($type == "gif" or $type == "png"){
    imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
    imagealphablending($new, false);
    imagesavealpha($new, true);
  }

  imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

  switch($type){
    case 'bmp': imagewbmp($new, $dst,100); break;
    case 'gif': imagegif($new, $dst,100); break;
    case 'jpg': imagejpeg($new, $dst,100); break;
    case 'png': imagepng($new, $dst,100); break;
  }
  return true;
}*/

function resizeimg($src,$dst,$maxwidth,$maxheight)
{
	global $oleh,$domain;
	$ext = substr($dst,-3,3);
		
		
	if(($ext=="jpg") || ($ext=="peg"))
	{
		$src_img     = imagecreatefromjpeg($src); 
		$lebar_awal  = imagesx($src_img); 
		$tinggi_awal = imagesy($src_img);
		$new_w       = $maxwidth;
		$new_h       = ($new_w/$lebar_awal)*$tinggi_awal; 
		$dst_img     = imagecreatetruecolor($new_w,$new_h); 
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img)); 
		imagejpeg($dst_img, $dst,100); 
		$benar = true;
	}
	else if(($ext=="gif"))
	{
		$src_img     = imagecreatefromgif($src); 
		$lebar_awal  = imagesx($src_img); 
		$tinggi_awal = imagesy($src_img);
		$new_w       = $maxwidth;
		$new_h       = ($new_w/$lebar_awal)*$tinggi_awal; 
		$dst_img     = imagecreatetruecolor($new_w,$new_h); 
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img)); 
		imagegif($dst_img, $dst,100); 
		$benar = true;
	}
	else if(($ext=="png"))
	{
		$src_img     = imagecreatefrompng($src); 
		$lebar_awal  = imagesx($src_img); 
		$tinggi_awal = imagesy($src_img);
		$new_w       = $maxwidth;
		$new_h       = ($new_w/$lebar_awal)*$tinggi_awal; 
		$dst_img     = imagecreatetruecolor($new_w,$new_h); 
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img)); 
		imagepng($dst_img, $dst,9); 
		$benar = true;
	}
	return $benar;
}

function sql_get_var_row($query)
{
	$res = sql($query);
	$row = mysqli_fetch_assoc($res);

	return $row;
	sql_free_result($res);
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
	$str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '-', $str);
	$str = trim($str, '-');

	return $str;
}

function tanggal($tanggal)
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
	$hari = $array_hari[$hari['weekday']];
	$tgl="$hari, $tgl $bulan1 $tahun";			
	return $tgl;
}
function tanggaljam($tanggal)
{
	$tahun     = substr("$tanggal",0,4); 
	$bulan     = substr("$tanggal", 5, 2); 
	$tgl       = substr("$tanggal", 8, 2); 
	$jam       = substr("$tanggal", 11, 2); 
	$mnt       = substr("$tanggal", 14, 2); 
	if ($bulan =="01") { $bulan1="Januari"; }
	if ($bulan =="02"){ $bulan1="Februari"; }
	if ($bulan =="03"){ $bulan1="Maret"; }
	if ($bulan =="04"){ $bulan1="April"; }
	if ($bulan =="05"){ $bulan1="Mei"; }
	if ($bulan =="06"){ $bulan1="Juni"; }
	if ($bulan =="07"){ $bulan1="Juli"; }
	if ($bulan =="08"){ $bulan1="Agustus"; }
	if ($bulan =="09"){ $bulan1="September"; }
	if ($bulan =="10"){ $bulan1="Oktober"; }
	if ($bulan =="11"){ $bulan1="November"; }
	if ($bulan =="12") {$bulan1="Desember"; }
	
	$time = mktime(0,0,0,$bulan,$tgl,$tahun);
	$hari = getdate($time);
	$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
						"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");
	$hari = $array_hari[$hari['weekday']];
	$tgl="$tgl $bulan1 $tahun $jam:$mnt";			
	return $tgl;
}

function tanggaltok($tanggal)
{
	$tahun     = substr("$tanggal",0,4); 
	$bulan     = substr("$tanggal", 5, 2); 
	$tgl       = substr("$tanggal", 8, 2); 
	$jam       = substr("$tanggal", 11, 2); 
	$mnt       = substr("$tanggal", 14, 2); 
	if ($bulan =="01") { $bulan1="Januari"; }
	if ($bulan =="02"){ $bulan1="Februari"; }
	if ($bulan =="03"){ $bulan1="Maret"; }
	if ($bulan =="04"){ $bulan1="April"; }
	if ($bulan =="05"){ $bulan1="Mei"; }
	if ($bulan =="06"){ $bulan1="Juni"; }
	if ($bulan =="07"){ $bulan1="Juli"; }
	if ($bulan =="08"){ $bulan1="Agustus"; }
	if ($bulan =="09"){ $bulan1="September"; }
	if ($bulan =="10"){ $bulan1="Oktober"; }
	if ($bulan =="11"){ $bulan1="November"; }
	if ($bulan =="12") {$bulan1="Desember"; }
	
	$time = mktime(0,0,0,$bulan,$tgl,$tahun);
	$hari = getdate($time);
	$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
						"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");
	$hari = $array_hari[$hari['weekday']];
	$tgl="$tgl $bulan1 $tahun";			
	return $tgl;
}	

function tanggalvalid($tanggal)
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
		$hari = $array_hari[$hari['weekday']];
		$tgl="$tgl-$bulan-$tahun";			
		return $tgl;
	}


function emailhtml($content)
{
	$email = '<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>SEFTCenter</title>
   <style type="text/css">
   	a {color: #4A72AF;}
	body, #header h1, #header h2, p {margin: 0; padding: 0; font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #3f4042; line-height:22px;}
	#main {border: 1px solid #cfcece;}
	img {display: block;}
	#top-message p, #bottom-message p {color: #3f4042; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
	#header h1 {color: #ffffff !important; font-family: Arial, sans-serif; font-size: 24px; margin-bottom: 0!important; padding-bottom: 0; }
	#header h2 {color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; font-size: 24px; margin-bottom: 0 !important; padding-bottom: 0; }
	#header p {color: #ffffff !important; font-family: Arial, sans-serif; font-size: 12px;  }
	h1, h2, h3, h4, h5, h6 {margin: 0 0 0.8em 0;}
	h3 {font-size: 28px; color: #444444 !important; font-family: Arial, Helvetica, sans-serif; }
	h4 {font-size: 22px; color: #4A72AF !important; font-family: Arial, Helvetica, sans-serif; }
	h5 {font-size: 18px; color: #444444 !important; font-family: Arial, Helvetica, sans-serif; }
	p {font-size: 12px; color: #444444 !important; font-family: Arial, sans-serif; }
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
						<td width="570"><h1><img src="http://www.ansania.com/images/img.mail.jpg" width="570" height="329" alt=""></h1></td>
					</tr>
				</table><!-- header -->			</td>
		</tr><!-- header -->
		
		<tr>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2"><!-- content 1 -->			<table width="100%" border="0" cellspacing="8" cellpadding="8">
              <tr>
                <td width="77%" valign="top" class="notif">
                  '.$content.'</td>
              </tr>
              
            </table></td>
		</tr><!-- content 1 -->
		
		
		<tr>
			<td width="292" height="30"></td>
	      <td width="263"><br>
	       <p> Temukan kami di Social Media</p>
	          <table width="100%" border="0" cellspacing="5" cellpadding="5">
            <tr>
              <td align="center" bgcolor="#0099FF"><span class="style1">Follow Twitter</span></td>
              <td align="center" bgcolor="#003366"><span class="style1">Like Facebook</span></td>
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


/*function sendmail($namapenerima,$emailpenerima,$subject,$isi,$isihtml)
{
	// echo "fungsinya : $namapenerima,$emailpenerima,$subject,$isi,$isihtml <br/>";
	global $title,$smtphost,$support,$smtpuser,$smtppass,$smtpport,$issmtp;
	// echo "fungsinya : $title,$smtphost,$support,$smtpuser,$smtppass,$smtpport,$issmtp";
	$smtphost = "smtp.mandrillapp.com";
	$support = "$title";
	$smtpfrom = "info@mypangandaran.com";
	$smtpuser = "adisumaryadi@gmail.com";
	$smtppass = "mD1f4bV7BLGLVD7DPwfxWw";
	$smtpport = "587";
	
	$mail = new PHPMailer;
	//$mail->IsSMTP();
	$mail->Host			= $smtphost;
	//$mail->SMTPAuth		= true;
	$mail->Username		= $smtpuser;
	$mail->Password		= $smtppass;
	//$mail->Port			= $smtpport;
	
	$mail->From     = $smtpuser;
	$mail->FromName = $support;
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
}*/

function sendmail($namapenerima,$emailpenerima,$subject,$isi,$isihtml)
{
	global $title,$smtphost,$support,$smtpuser,$smtppass,$smtpport,$issmtp;
	
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPDebug = 0; 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 

	$mail->Host     = $smtphost;
	$mail->Port     = $smtpport;
	$mail->Username = $smtpuser;
	$mail->Password = $smtppass;
	$mail->From     = $smtpuser;
	$mail->FromName = $support;
	$mail->Subject  = $subject;
	$mail->Body     = $isihtml;
	$mail->AltBody  = $isi;
	$mail->AddAddress("$emailpenerima","$namapenerima");
	$mail->IsHTML(true);
	
	if(!$mail->Send())
	{	
		print_r($mail);
		die();
		return false;
	}
	else
	{
		return true;
	}
}

function upload_file($file,$newfile)
{
	global $pathfile,$kanal;

	$allowedExts = array("pdf", "docx", "xlsx", "doc");
    $temp = explode(".", $_FILES[$file]["name"]);
    $extension = end($temp);

    if (($_FILES[$file]["size"] > 0) && in_array($extension, $allowedExts))
      {
      if ($_FILES[$file]["error"] > 0)
        {
        echo "Error: " . $_FILES[$file]["error"] . "<br>";
        }
      else
        {
		if(!file_exists("$pathfile/$kanal/upload")) mkdir("$pathfile/$kanal/upload");
        
        if (file_exists("$pathfile/$kanal/upload" . $_FILES[$file]["name"]))
          {
          	echo "file sudah diupload";
          }
        else
          {
          move_uploaded_file($_FILES[$file]["tmp_name"],
          "$pathfile/$kanal/upload/" . $newfile);
          }
        }
      }
    else
      {
      echo "Invalid file";
      }
}
function color($characters) {
      $possible = '0123456789abcdef';
      $code = '#';
      $i = 0;
      while ($i < $characters) { 
         $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
         $i++;
      }
      return $code;
   }
function getNamaKota($kotaid)
{
	global $database;
	
	$sql 		= "select kota from tbl_kota where id='$kotaid'";
	$query 		= sql( $sql);
	$row 		= sql_fetch_data($query);
	$namakota 	= $row['kota'];
	sql_free_result($query);
	
	return $namakota;
}
function getProfile($userid)
{
		global $database,$domain,$lokasiwebmember,$lokasiweb;
		$perintah1	= "select userid,username,userfullname,avatar,userdirname,useremail,useraddress,userphonegsm from tbl_member where userid='$userid'";
		$hasil1		= sql($perintah1);
		$data1	= sql_fetch_data($hasil1);

		$userdirname 	= $data1['userdirname'];
		$avatar			= $data1['avatar'];
		$nama			= ucwords($data1['userfullname']);
		$username 		= $data1['username'];
		$useremail		= $data1['useremail'];
		$useraddress	= $data1['useraddress'];
		$userphonegsm	= $data1['userphonegsm'];
			
			
			if(empty($avatar)){ $gambar = "$domain/images/default/thumb-kosong-s.jpg"; }
			else
			{
				$avatar1  = explode("-",$avatar);
				
				$jml = count($avatar1);
				if($jml=="5"){ $albumid = $avatar1[2]; }
				else {  $albumid = $avatar1[1]; }
				
				$gambar = "$lokasiwebmember/$userdirname/album/$albumid/$avatar";
			}
	
		$data = array("username"=>$username,"userfullname"=>$nama,"avatar"=>$gambar,"useremail"=>$useremail,"useraddress"=>$useraddress,"userphonegsm"=>$userphonegsm);
		return $data;
}


function kirimSMS($dest,$pesan,$idbaru)
{
	global $lokasiweb;
	
	$kiriman = "http://sms.ansania.com/api/sms.php";
	
	$post = array('apikey'=>'b1smillah','msisdn'=>$dest,'pesan'=>$pesan);
	
	$ch = curl_init("$kiriman");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$output = curl_exec($ch);       
	curl_close($ch);
	
	
	$data = date('Y-m-d H:i:s')." | $ip | $kiriman | $output\r\n";
	$file = "$lokasiweb/api/backlog.txt";
	$open = fopen($file, "a+"); 
	fwrite($open, "$data"); 
	fclose($open);
	
	if(preg_match("/Sukses/i",$output))
	{
		
		if(!empty($idbaru))
		{
			$sql2 = "update tbl_smsc_smskeluar set status='2' where id='$idbaru'";
			$hsl2 = sql($sql2);
		}
		else
		{
			$sql2 = "insert into tbl_smsc_smskeluar(msisdn,pesan,tanggal,status) values ('$dest','$pesan',now(),'2')";
			$hsl2 = sql($sql2);

		}
		
		$berhasil = true;
	}
	else
	{
		$berhasil = false;
	}
}


function setlog($userid,$pesan,$uri,$ip)
{
	/*global $database;
	
	$date = date("Y-m-d H:i:s");
	$perintah 	= "insert into tbl_cms_log (userid,pesan,uri,ip,create_date) values ('$userid','$pesan','$uri','$ip','$date')";
	$hasil 		= sql($perintah);*/
}

function tanggalsimple($tanggal)
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
		/*
		$time = mktime(0,0,0,$bulan,$tgl,$tahun);
		$hari = getdate($time);
		$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
							"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");
		$hari = $array_hari[$hari['weekday']];*/
		$tgl="$tgl-$bulan-$tahun | $jam:$mnt WIB";			
		return $tgl;
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

function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
function kirimwa($userphonegsm,$html,$blastid)
{
	
	$userphonegsm = trim($userphonegsm);
	$userphonegsm = str_replace(" ","",$userphonegsm);
	$userphonegsm = str_replace("-","",$userphonegsm);
	$userphonegsm = str_replace("+","",$userphonegsm);
	
	if(substr($userphonegsm,0,1)=="0"){ $userphonegsm = "62".substr($userphonegsm,1,12); }
	
	if(strlen($userphonegsm)>5)
	{
	
	$html = str_replace("<br>","\r\n",$html);
	$html = str_replace("\r\n","\r\n",$html);
	$html = str_replace("</strong>","*",$html);
	$html = str_replace("<strong>","*",$html);
	$html = str_replace("<b>","*",$html);
	$html = str_replace("</b>","*",$html);
	
	$html = $html;

    $date = date("Y-m-d H:i:s");
	$pesan = sql_escape_string($html);
	$sql = "insert into tbl_wa(create_date,userphonegsm,pesan,blastid,customerid) values('$date','$userphonegsm','$pesan','$blastid','$customerid')";
	$h = sql($sql);
	}


}
function bersih($text) {

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
                 "'&(copy|#169);'i");                    // evaluate as php

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
					  chr(169));
	
	$text = preg_replace($search, $replace, $text);
	$text = str_replace("'","`",$text);
	return $text;

}
function sendwa($userphonegsm,$html)
{
	
	$token = 'cflmcESp58g8Y4o8AGgpVRdgfpWeE8fDJZwLUrfUqFhezQNG3b';
	$phone = $userphonegsm;
	$message = $html;
	$url = 'http://ruangwa.com/v2/api/send-message.php';
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_TIMEOUT,30);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, array(
		'token'    => $token,
		'phone'     => $phone,
		'message'   => $message,
	));
	$response = curl_exec($curl);
	curl_close($curl); 

}
function ringkas($str,$kata)
{
	$str = bersih($str);
	$str = strip_tags($str);
	
	$strs = explode(" ",$str);
	$newstr = "";
	for($i=0;$i<$kata;$i++)
	{
		$newstr .= "$strs[$i] ";
	}
	return $newstr;
	
}
?>