<?php 
$url = $_GET['url'];
$title = $_GET['title'];
$detailgambar = $_GET['media'];

if(empty($detailgambar)) $detailgambar = "http://www.mypangandaran.com/template/newmypangandaran/images/img.mypangandaran.jpg";
$detailgambar = urlencode($detailgambar);
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
</style>
<div class="boxf">
<a name="fb_share" type="box_count" display="block" share_url="<?php echo $url?>" style="margin-top:-20px;"></a>
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share"  type="text/javascript"></script>
</div>
<div class="boxf">
<a style="float:left" href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $url?>" data-via="mypangandaran"  data-lang="en" data-counturl="<?php echo $url?>" data-count="vertical" data-text="<?php echo $title?>">Tweet</a>&nbsp;
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
<div class="boxf" style="padding-top:22px; padding-left:5px;">
<a data-pin-config="above"href="//pinterest.com/pin/create/button/?url=<?php echo $url?>&media=<?php echo $detailgambar?>&description=<?php echo $title?>" data-pin-do="buttonPin" ><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
<script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script></div>
<script>
jQuery(document).ready(function(){
  jQuery("span.fb_share_no_count").each(function(){
    jQuery(this).removeClass("fb_share_no_count");
    jQuery(".fb_share_count_inner", this).html("0");
  });
});
</script>
