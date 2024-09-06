<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 14:35:07
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/ask/index.html" */ ?>
<?php /*%%SmartyHeaderCode:508795231619318e42767d8-88631883%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e5bbf5ef76a8c105630faa4e1c9279ef52f416ff' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/ask/index.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '508795231619318e42767d8-88631883',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_619318e43016d3_29988382',
  'variables' => 
  array (
    'lokasiwebtemplate' => 0,
    'menu' => 0,
    'a' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_619318e43016d3_29988382')) {function content_619318e43016d3_29988382($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
<!-- =========================================Basic========================================== -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="Skincare, Casa Dr Hezz, Dr Hezz, Paket Whitening" />

<meta name="language" content="in,en" />
<meta name="distribution" content="Global" />
<meta name="rating" content="General" />
<meta name="robots" content="index,follow" />
<meta name="googlebot" content="index,follow" />
<meta name="google-site-verification" content="qcKcc9CU_-SX2hZoCUN7_MlGNoY72kZgnD-GMzX59oI" />
<meta name="revisit-after" content="20 minutes" />
<meta name="expires" content="never" />
<meta name="dc.creator.e-mail" content="adisumaryadi@gmail.com" />
<meta name="dc.creator.name" content="Adi Sumaryadi" />
<meta name="dc.creator.website" content="http://www.adisumaryadi.com" />
<meta name="tgn.name" content="Pangandaran,Bandung" />
<meta name="tgn.nation" content="Indonesia" />
<meta property="fb:app_id" content="128225700537941" />
<meta name="keywords" content="Ansania, Busana Muslimah, Baju Muslimah, Pakaian Muslimah, Hijab, Jilbab, Baju Wanita, Pakaian Wanita, Busana Wanita"> 
<meta name="dc.title" content="Ansania Hijab - Pusatnya Hijab Berkualitas" /> 
<meta name="title" property="og:title" content="Ansania Hijab - Pusatnya Hijab Berkualitas" />
<meta name="description" property="og:description" content="Toko Onlinenya Ansania, dapatkan berbagai koleksi Kerudung dan Pashmina dengan design terbaik  dan bahan berkualitas untuk anda Muslimah Indonesia., Ansania, Busana Muslimah, Baju Muslimah, Pakaian Muslimah, Hijab, Jilbab, Baju Wanita, Pakaian Wanita, Busana Wanita" />
<meta name="image" property="og:image" content="http://localhost:8080/ansaniacom/template/ansania//images/img.share.jpg" />
<meta name="twitter:title" value="Ansania Hijab - Pusatnya Hijab Berkualitas"/> 
<meta name="twitter:description" value="Toko Onlinenya Ansania, dapatkan berbagai koleksi Kerudung dan Pashmina dengan design terbaik  dan bahan berkualitas untuk anda Muslimah Indonesia., Ansania, Busana Muslimah, Baju Muslimah, Pakaian Muslimah, Hijab, Jilbab, Baju Wanita, Pakaian Wanita, Busana Wanita" /> 
<meta name="twitter:image" value="http://localhost:8080/ansaniacom/template/ansania//images/img.share.jpg" /> 
<meta name="twitter:card" value="summary_large_image"/> <meta name="twitter:creator" value="@ansania"/> 
<meta name="twitter:url" value="http://localhost:8080/ansaniacom/"/> <meta name="twitter:domain" value="http://localhost:8080/ansaniacom/"/> 
<meta name="twitter:site" value="Ansania Hijab - Pusatnya Hijab Berkualitas"/>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
ask/assets/fontawesome-pro/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
ask/css/bootstrap.min.css">
<link href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
ask/css/aos.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
ask/css/main.css">
</head>
<body>
<section class="py-5">
  <div class="container d-flex justify-content-center text-center">
    <div class="col-lg-8"> <img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
ask/assets/img/logo.png" class="img-fluid" width="120" alt="assets/img/logo.png">
      <h5 class="mb-0 text-white">Ansania Hijab</h5><br>

      <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
          <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['url'];?>
" class="btn btn-primary py-3 mb-3 btn-block"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a> 
      <?php } ?>
     
  </div>
</section>
<!-- Optional JavaScript; choose one of the two! -->
<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
ask/js/jquery-3.5.1.slim.min.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
ask/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
ask/js/aos.js"></script>
<script>
      AOS.init();
    </script>
<script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
ask/js/main.js"></script>

<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-36866276-17', 'auto');
	  ga('send', 'pageview');
	
	</script>

</body>
</html>
<?php }} ?>