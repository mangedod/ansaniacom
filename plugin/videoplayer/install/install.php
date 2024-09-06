<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css.css" type="text/css" rel="stylesheet" />
<title>Web-Anatomy: Flv-Player</title>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>

    <td align="center"><table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="1000px">
<div class="page">
	  <div class="bigFont">Web-Anatomy: Flv Player - installation</div> 
    
    <div class="content"><div class="inside">
<div class="gra"> <div class="gradient"><div class="title">Installation</div> 
    <div class="men1">
<div class="pos"><div class="pos1">- <?php if(!isset($_GET['step'])){ echo'<b>Checking files</b>'; }else{echo 'Checking files';}?></div></div>
<div class="pos"><div class="pos1">- <?php if(isset($_GET['step']) && $_GET['step'] == 2){ echo'<b>Configuration file</b>'; }else{echo 'Configuration file';}?></div></div>
<div class="pos"><div class="pos1">- <?php if(isset($_GET['step']) && $_GET['step'] == 3){ echo'<b>Database</b>'; }else{echo 'Database';}?></div></div>
    </div>
    
    </div><div class="ct">
<?php
if(!isset($_GET['step'])){ include('step1.php'); }else{
if($_GET['step'] == 2){ include('step2.php'); }
if($_GET['step'] == 3){ include('step3.php'); }
}
?>
</div></div>
    </div></div>
	<div class="footer">Copyrights (c) 2008 by <a href="http://web-anatomy.com" class="white">www.Web-Anatomy.com</a> All rights reserved  	 </div>
</div>
</td></tr></table></td></tr></table>
</body>
</html>
