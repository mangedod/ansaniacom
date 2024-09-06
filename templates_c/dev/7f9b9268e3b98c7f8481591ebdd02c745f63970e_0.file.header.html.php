<?php
/* Smarty version 4.3.0, created on 2023-02-14 00:13:35
  from 'http://localhost:8080/ansaniacom/public_html/template/dev/komponen/home/header.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ead22fc11fc2_04105460',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7f9b9268e3b98c7f8481591ebdd02c745f63970e' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/dev/komponen/home/header.html',
      1 => 1579346162,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63ead22fc11fc2_04105460 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>

<head>

	<meta content="text/html; charset=utf-8" http-equiv="Content-Type"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta content="id" http-equiv="Content-Language"> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta name="distribution" content="Global" /> 
	<meta name="robots" content="index, follow"> 
	<meta name="copyright" content="Copyright 2017 <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
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
	<meta name="twitter:card" value="summary_large_image"/> <meta name="twitter:creator" value="@ansania"/> 
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
css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/jssocials.css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/jssocials-theme-flat.css" />
    <?php echo '<script'; ?>
 src='https://www.google.com/recaptcha/api.js'><?php echo '</script'; ?>
>
</head>
<body>

<!-- Header Section Starts -->
<div class="topmenu">

<!-- Starts -->
    <div class="container">
    
    <!-- Main Header Starts -->
        <div class="main-header">
            <div class="row">
            <!-- Logo Starts -->
            		<div class="col-md-4">
                    	<span class="infotopmenu"><i class="fa fa-whatsapp"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['contacttelp']->value;?>
</span>
                        <span class="infotopmenu"><i class="fa fa-envelope-o"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['contactemail']->value;?>
</span>
                    </div>
                    <div class="col-md-8">
                        <div class="pull-right">
                            
                           <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/about">Tentang Ansania</a>
                           <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/faq">Panduan Belanja</a>
                           <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart/confirm">Konfirmasi Bayar</a>
                           <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/testimoni">Testimonial</a>
                       </div> 
                   </div>
                  <!-- <div class="col-md-4">  
                    <form class="search-form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product/list">
                            <div class="input-group">
                            	<input type="hidden" value="cari" name="aksi">
                                <input type="text" class="form-control" placeholder="Cari Produk" name="kata">
                                <div class="input-group-btn">
                                    <button class="btn" type="submit"><i class="icon-magnifier"></i></button>
                                </div>
                            </div>
                    </form>
                    </div> -->
                   
                    
            </div>
        </div>
    <!-- Main Header Ends -->
    </div>
 <!-- Ends -->
</div>
<!-- Header Section Ends -->

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
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
/cart" class="visible-xs menuicon"><i class="icon-cart"></i></i><?php if ($_smarty_tpl->tpl_vars['jumlah_cart']->value > 0) {?> <span class="label label-danger"><?php echo $_smarty_tpl->tpl_vars['jumlah_cart']->value;?>
</span> <?php }?></a>
                    <div class="hcart pull-right hidden-xs">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart" class="menuicon"><i class="icon-cart"></i> Keranjang <?php if ($_smarty_tpl->tpl_vars['jumlah_cart']->value > 0) {?> <span class="label label-danger"><?php echo $_smarty_tpl->tpl_vars['jumlah_cart']->value;?>
</span> <?php }?></a>
                        <div class="dropdown">
                            <?php if ($_smarty_tpl->tpl_vars['jumlah_cart']->value != '0') {?>
                                <nav>
                                    <ul class="hcart-list">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['topcart']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
                                        <li>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['urld'];?>
" class="fig pull-left"><img width="60" src="<?php echo $_smarty_tpl->tpl_vars['a']->value['gambarprodukd'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['namaproduk'];?>
"></a>
                                            <div class="block">
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product"><?php echo $_smarty_tpl->tpl_vars['a']->value['namaproduk'];?>
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
/cart" class="btn btn-default">Cart</a>
                                    <div class="total">Total - <ins><?php echo $_smarty_tpl->tpl_vars['totaltagihanhead']->value;?>
</ins></div>
                                </div>
                            <?php } else { ?>
                                <!-- <span>Recently added item(s) - <ins>no item</ins></span> -->
                            <?php }?>
                        </div>
                         
                      <?php if ($_smarty_tpl->tpl_vars['login']->value == '1') {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/dashboard" class="hidden-xs menuicon"><i class="icon-user"></i></a>
                        <?php } else { ?>
                         <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member" class="hidden-xs menuicon"><i class="icon-user"></i></a>
                        <?php }?>	
                       <a href="#" class="hidden-xs menuicon mt-8"><i class="icon-magnifier"></i></a>
                                
                </div>
                </div>
                <div class="col-md-2 contact-info">
                    <div class="logo pull-left">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/"><img  src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.logo.png" alt="Logo Ansania"></a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-8 mainmenu">
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
/">Home</a></li>
                                 <li class="dropdown ">
                                    <a href="#"  class="dropdown-toggle" data-toggle="dropdown">Produk </span></a>
                                    <ul class="dropdown-menu submenu">
                                    	<li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product">Semua Produk</a></li>
                                    	 <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tipeproduk']->value, 'i', false, 'tipeid');
$_smarty_tpl->tpl_vars['i']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['tipeid']->value => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->do_else = false;
?>
                                   
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menusec']->value[$_smarty_tpl->tpl_vars['i']->value['tipeid']], 's', false, 'secid');
$_smarty_tpl->tpl_vars['s']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['secid']->value => $_smarty_tpl->tpl_vars['s']->value) {
$_smarty_tpl->tpl_vars['s']->do_else = false;
?>
                                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['s']->value['url_sec'];?>
"><?php echo $_smarty_tpl->tpl_vars['s']->value['namasech'];?>
</a></li>
                                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                          
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?></ul>
                                </li>
                              
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/sale">Sale</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/video">Video</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/blog">Blog</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/reseller">Reseller</a></li>
								
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- /.header --><?php }
}
