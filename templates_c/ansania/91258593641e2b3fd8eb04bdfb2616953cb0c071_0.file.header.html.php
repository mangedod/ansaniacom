<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:56:54
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/home/header.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603d1466f9051_44085920',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '91258593641e2b3fd8eb04bdfb2616953cb0c071' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/home/header.html',
      1 => 1711526211,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603d1466f9051_44085920 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
<head>

	<meta content="text/html; charset=utf-8" http-equiv="Content-Type"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta content="id" http-equiv="Content-Language"> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta name="distribution" content="Global" /> 
	<meta name="robots" content="index, follow"> 
	<meta name="copyright" content="Copyright 2019 <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" /> 
	<meta name="language" content="in,en" /> 
	<meta name="rating" content="General" /> 
	<meta name="robots" content="index,follow" /> 
	<meta name="googlebot" content="index,follow" /> 
	<meta name="revisit-after" content="1 days" /> 
	<meta name="expires" content="never" /> 
	<meta name="dc.creator.e-mail" content="<?php echo $_smarty_tpl->tpl_vars['support_email']->value;?>
" /> 
	<meta name="dc.creator.name" content="<?php echo $_smarty_tpl->tpl_vars['support']->value;?>
" /> 
	<meta name="dc.creator.website" content="<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
" /> 
	<meta name="tgn.name" content="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" /> 
	<meta name="tgn.nation" content="Indonesia" /> 
	<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['metakeyword']->value;?>
"> 
	<meta name="dc.title" content="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" /> 
	<?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'detail' || $_smarty_tpl->tpl_vars['aksi']->value == 'read') {?>
		<meta name="title" property="og:title" content="<?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
" />
		<meta name="description" property="og:description" content="<?php if ($_smarty_tpl->tpl_vars['detailringkas']->value != '') {
echo $_smarty_tpl->tpl_vars['detailringkas']->value;
}?>" />
		<meta name="image" property="og:image" content="<?php if ($_smarty_tpl->tpl_vars['gambarshare']->value != '') {
echo $_smarty_tpl->tpl_vars['gambarshare']->value;
} else {
echo $_smarty_tpl->tpl_vars['detailgambar']->value;
}?>" />
		
		<meta name="twitter:title" value="<?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
"/> 
		<meta name="twitter:description" value="<?php if ($_smarty_tpl->tpl_vars['detailringkas']->value != '') {
echo $_smarty_tpl->tpl_vars['detailringkas']->value;
}?>" /> 
		<meta name="twitter:image" value="<?php if ($_smarty_tpl->tpl_vars['gambarshare']->value != '') {
echo $_smarty_tpl->tpl_vars['gambarshare']->value;
} else {
echo $_smarty_tpl->tpl_vars['detailgambar']->value;
}?>" /> 
	
	<?php } elseif ($_smarty_tpl->tpl_vars['kanal']->value == 'home') {?>
		<meta name="title" property="og:title" content="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" />
		<meta name="description" property="og:description" content="<?php echo $_smarty_tpl->tpl_vars['webdesc']->value;?>
, <?php echo $_smarty_tpl->tpl_vars['metakeyword']->value;?>
" />
		<meta name="image" property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
/images/img.share.jpg" />
		
		<meta name="twitter:title" value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
"/> 
		<meta name="twitter:description" value="<?php echo $_smarty_tpl->tpl_vars['webdesc']->value;?>
, <?php echo $_smarty_tpl->tpl_vars['metakeyword']->value;?>
" /> 
		<meta name="twitter:image" value="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
/images/img.share.jpg" /> 
	<?php }?>
	<meta name="twitter:card" value="summary_large_image"/> <meta name="twitter:creator" value="@<?php echo $_smarty_tpl->tpl_vars['contactig']->value;?>
"/> 
	<meta name="twitter:url" value="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/"/> <meta name="twitter:domain" value="<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
"/> 
	<meta name="twitter:site" value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
"/>

    <title><?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'detail' || $_smarty_tpl->tpl_vars['aksi']->value == 'isi' || $_smarty_tpl->tpl_vars['aksi']->value == 'read') {
echo $_smarty_tpl->tpl_vars['detailnama']->value;
} else {
echo $_smarty_tpl->tpl_vars['title']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['rubrik']->value;
}?></title>

    <link rel="icon" type="image/png"  href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/favicon.ico">
    <meta name="theme-color" content="#ffffff">
    <link href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/bootstrap.css" rel="stylesheet">
    <?php if ($_smarty_tpl->tpl_vars['kanal']->value == 'product' && $_smarty_tpl->tpl_vars['aksi']->value == 'read') {?>
    <link href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/bootstrap-spinner.css" rel="stylesheet">
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['kanal']->value == 'cart' && $_smarty_tpl->tpl_vars['aksi']->value == 'confirm') {?>
    <link href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <?php }?>
    <link href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/style.css?ansania" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/jssocials.css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/jssocials-theme-flat.css" />
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jquery-2.1.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src='https://www.google.com/recaptcha/api.js'><?php echo '</script'; ?>
>
    <!-- Meta Pixel Code -->

<?php echo '<script'; ?>
>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1592926571081538');
  fbq('track', 'PageView');
<?php echo '</script'; ?>
>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1592926571081538&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
</head>
<body <?php if ($_smarty_tpl->tpl_vars['kanal']->value != 'home') {?> style="padding-top: 20px" id="deep" <?php }?>>

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
    <div class="topheader">
        <div class="container">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['toppromo']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>
    </div>
    <header class="header sides">

        <div class="hbottom right-pos dark">
                <div class="container">
                <div class="col-md-2 col-sm-3 logo not-sticky hidden-xs">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/"><img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.logo.png" alt=""> </a>
                </div>
                <div class="col-md-4 col-sm-4 iconmenu pull-right">
                	
                    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart" class="visible-xs menuicon"><i class="fal fa-shopping-cart"></i></i><?php if ($_smarty_tpl->tpl_vars['jumlah_cart']->value > 0) {?> <span class="label label-danger"><?php echo $_smarty_tpl->tpl_vars['jumlah_cart']->value;?>
</span> <?php }?></a>
                    <div class="hcart pull-right">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart" class="menuicon hidden-xs"><i class="fal fa-shopping-cart"></i> Keranjang <?php if ($_smarty_tpl->tpl_vars['jumlah_cart']->value > 0) {?> <span class="label label-danger"><?php echo $_smarty_tpl->tpl_vars['jumlah_cart']->value;?>
</span> <?php }?></a>
                        <div class="dropdown hidden-xs">
                            <?php if ($_smarty_tpl->tpl_vars['jumlah_cart']->value != '0') {?>
                                <nav>
                                    <ul class="hcart-list">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['topcarts']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
                                        <li>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['urld'];?>
" class="fig pull-left">
                                            <img width="60" src="<?php echo $_smarty_tpl->tpl_vars['a']->value['gambarprodukd'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['namaproduk'];?>
"></a>
                                            <div class="block">
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['urld'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['namaproduk'];?>
</a>
                                                <div class="cost"><?php echo $_smarty_tpl->tpl_vars['a']->value['qtyd'];?>
 x <?php echo $_smarty_tpl->tpl_vars['a']->value['misc_hargaprodukd'];?>
</div>
                                            </div>
                                        </li>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </ul>
                                </nav>
                                <div class="hcart-total">
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart" class="btn btn-primary add-cart">Cart</a>
                                    <div class="total">Total - <ins><?php echo $_smarty_tpl->tpl_vars['totaltagihanhead']->value;?>
</ins></div>
                                </div>
                            <?php } else { ?>
                                <!-- <span>Recently added item(s) - <ins>no item</ins></span> -->
                            <?php }?>
                        </div>
                         
                        <?php if ($_smarty_tpl->tpl_vars['login']->value == '1') {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/dashboard" class="menuicon"><i class="fal fa-user"></i></a>
                        <?php } else { ?>
                         <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member" class="menuicon"><i class="fal fa-user"></i></a>
                        <?php }?>	 
                       <a href="#" class="hidden-xs menuicon mt-8" data-toggle="modal" data-target="#myModal"><i class="fal fa-search"></i></a>
                                
                </div>
                </div>
                <div class="col-md-2 contact-info">
                    <div class="logo pull-left">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/"><img  src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.logo.png" alt="Logo Ansania"></a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-2 mainmenu">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="mobile-logo visible-xs">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/"><img  src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.logo.png" alt="Logo Ansania"></a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <nav class="text-center">
                           
                            <ul class="nav navbar-nav navbar-right">

                                 <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product">New Arrival</a></li>
                                 <li class="dropdown ">
                                    <a href="#"  class="dropdown-toggle" data-toggle="dropdown">Kategori </span></a>
                                    <ul class="dropdown-menu submenu">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['jenis']->value, 's', false, 'secid');
$_smarty_tpl->tpl_vars['s']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['secid']->value => $_smarty_tpl->tpl_vars['s']->value) {
$_smarty_tpl->tpl_vars['s']->do_else = false;
?>
                                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['s']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['s']->value['nama'];?>
</a></li>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                      </ul>
                                </li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/video">Video</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/catalog">Katalog</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/reseller">Reseller</a></li>
                                 <li class="dropdown ">
                                    <a href="#"  class="dropdown-toggle" data-toggle="dropdown">About </span></a>
                                    <ul class="dropdown-menu submenu wow fadein">
                                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/about">Tentang Ansania</a></li>
                                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/testimoni">Testimoni</a></li>
                                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/marketplace">Marketplace Kami</a></li>
                                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/video">Video Galeri</a></li>
                                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/blog">Blog</a></li>
                                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/faq">Tanya Jawab (FAQ)</a></li>
                                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/instagram">Instagram</a></li>
                                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/contact">Hubungi Kami</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </header>
    <!-- /.header -->
    <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" style="margin-top: 80px;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form method="GET" action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product/list/">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cari Produk</h4>
      </div>
      <div class="modal-body">
        <input type="text" name="keyword" class="form-control" placeholder="Ketik nama produk">
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-default" value="Cari Produk">
      </div>
    </div>
</form>
  </div>
</div><?php }
}
