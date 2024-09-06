<?php 
session_start();
$url = $_GET['url'];
$title = $_GET['title'];
$detailgambar = $_GET['media'];
$aksi = $_GET['aksi'];

?>

<style>
body{margin: 0;padding: 0;}.sharebox_top{vertical-align: bottom;}img{border: 0 none;}
.fl{float: left;}.pr5 {padding-right: 5px;}.pb5 { padding-bottom: 5px;}#___plusone_0 { width: 50px !important;}.comment_balon { width: 65px;}.comment_balon a { text-decoration: none;}.comment_balon a:hover { opacity: 0.8;}.comment_balon .satu { background: url("http://news.detik.com/image/detik.sprite.gif") no-repeat scroll 0 -720px transparent; color: #666666; font-family: Arial,Helvetica,sans-serif; font-size: 20px; height: 35px; padding-top: 7px; text-align: center; text-decoration: none !important;}
.boxf{
	float:left;
	width:65px;
	height:80px;
	overflow:hidden;
}.fb_share_no_count {display: block !important;}
.count-o {
    border: 1px solid #ddd;
    border-radius: 3px;
    height: 35px;
    margin-top: 3px;
    width: 63px;
}
#like-btn {
    background: #687c29; /* Old browsers */
	background: -moz-linear-gradient(top, #687c29 0%, #516c03 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#687c29), color-stop(100%,#516c03)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #687c29 0%,#516c03 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #687c29 0%,#516c03 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #687c29 0%,#516c03 100%); /* IE10+ */
	background: linear-gradient(to bottom, #687c29 0%,#516c03 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#687c29', endColorstr='#516c03',GradientType=0 ); /* IE6-9 */


    bottom: 0;
    color: #fff;
    font-size: 13px;
    line-height: 20px;
    padding: 0;
    position: absolute;
    text-align: center;
    width: 15%;
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    -ms-border-radius: 2px;
    -o-border-radius: 2px;
    border-radius: 2px;
    border:1px solid #5C7A02;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -o-box-sizing: border-box;
    box-sizing: border-box;
}
.pluginCountBoxNub {
    bottom: -2px;
    height: 7px;
    left: 7px;
    position: relative;
    width: 0;
    z-index: 2;
}
.pluginCountBoxNub s, .pluginCountBoxNub i {
    border-color: #dddddd transparent transparent;
    border-style: solid;
    border-width: 5px;
    display: block;
    position: relative;
}

.pluginCountBoxNub i {
    border-top-color: #fff;
    left: 0;
    top: -12px;
}

.count-o > span {
    display: block;
    text-align: center;
    width: 100%;
    margin-top: 5px;
}
</style>
<div class="boxf">
<a name="fb_share" type="box_count" display="block" share_url="<?php echo $url?>" style="margin-top:-20px;"></a>
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share"  type="text/javascript"></script>
</div>
<div class="boxf">
<a style="float:left" href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url?>" data-lang="en" data-counturl="<?php echo $url?>" data-count="vertical" data-text="<?php echo $title?>">Tweet</a>&nbsp;
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
<div class="boxf">
<g:plusone size="tall" href="<?php echo $url?>"></g:plusone>
<script type="text/javascript">
  (function() {
 var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
 po.src = 'https://apis.google.com/js/plusone.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
</div>
<div class="fl comment_balon">
 <div class="fb-like" data-href="<?php echo $url?>" data-send="false" data-layout="box_count" data-width="450" data-show-faces="true"></div>
</div>
<div class="boxf">
<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-url="<?php echo $url?>" data-counter="top"></script>
</div>
<script>
jQuery(document).ready(function(){
  jQuery("span.fb_share_no_count").each(function(){
    jQuery(this).removeClass("fb_share_no_count");
    jQuery(".fb_share_count_inner", this).html("0");
  });
});
</script>

<?

	if($aksi == "save")
	{
		if(!empty($_SESSION['username']))
		{
			$cek = sql_get_var("select id from tbl_content_like where userid='$_SESSION[userid]' and uri='$url'");
			
			if(!$cek)
			{
				$perintah = "insert into tbl_content_like (userid,uri) values ('$_SESSION[userid]','$url')";
				$hasil = sql($perintah);
			}
		}
		else
		{
		  echo "<script>
			alert(\"Anda harus Login terlebih dahulu.\");
			</script>";
		}
	}

?>
