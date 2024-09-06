<?php /* Smarty version Smarty-3.1.13, created on 2022-02-20 23:58:55
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/home/header.html" */ ?>
<?php /*%%SmartyHeaderCode:60917878461e93cacb73257-96699707%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'beae1567117bee6835e6c2d8e8d7b645dcb3f31d' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/home/header.html',
      1 => 1645373001,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '60917878461e93cacb73257-96699707',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61e93cacc72070_08219860',
  'variables' => 
  array (
    'title' => 0,
    'support_email' => 0,
    'support' => 0,
    'domain' => 0,
    'metakeyword' => 0,
    'aksi' => 0,
    'detailnama' => 0,
    'detailringkas' => 0,
    'gambarshare' => 0,
    'detailgambar' => 0,
    'kanal' => 0,
    'webdesc' => 0,
    'lokasiwebtemplate' => 0,
    'contactig' => 0,
    'fulldomain' => 0,
    'rubrik' => 0,
    'toppromo' => 0,
    'a' => 0,
    'jumlah_cart' => 0,
    'topcarts' => 0,
    'totaltagihanhead' => 0,
    'login' => 0,
    'jenis' => 0,
    's' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61e93cacc72070_08219860')) {function content_61e93cacc72070_08219860($_smarty_tpl) {?><!DOCTYPE html>
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
	<?php if ($_smarty_tpl->tpl_vars['aksi']->value=='detail'||$_smarty_tpl->tpl_vars['aksi']->value=='read'){?>
		<meta name="title" property="og:title" content="<?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
" />
		<meta name="description" property="og:description" content="<?php if ($_smarty_tpl->tpl_vars['detailringkas']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['detailringkas']->value;?>
<?php }?>" />
		<meta name="image" property="og:image" content="<?php if ($_smarty_tpl->tpl_vars['gambarshare']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['gambarshare']->value;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['detailgambar']->value;?>
<?php }?>" />
		
		<meta name="twitter:title" value="<?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
"/> 
		<meta name="twitter:description" value="<?php if ($_smarty_tpl->tpl_vars['detailringkas']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['detailringkas']->value;?>
<?php }?>" /> 
		<meta name="twitter:image" value="<?php if ($_smarty_tpl->tpl_vars['gambarshare']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['gambarshare']->value;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['detailgambar']->value;?>
<?php }?>" /> 
	
	<?php }elseif($_smarty_tpl->tpl_vars['kanal']->value=='home'){?>
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

    <title><?php if ($_smarty_tpl->tpl_vars['aksi']->value=='detail'||$_smarty_tpl->tpl_vars['aksi']->value=='isi'||$_smarty_tpl->tpl_vars['aksi']->value=='read'){?><?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['rubrik']->value;?>
<?php }?></title>

    <link rel="icon" type="image/png"  href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/favicon.ico">
    <meta name="theme-color" content="#ffffff">
    <link href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/bootstrap.css" rel="stylesheet">
    <?php if ($_smarty_tpl->tpl_vars['kanal']->value=='product'&&$_smarty_tpl->tpl_vars['aksi']->value=='read'){?>
    <link href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/bootstrap-spinner.css" rel="stylesheet">
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['kanal']->value=='cart'&&$_smarty_tpl->tpl_vars['aksi']->value=='confirm'){?>
    <link href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <?php }?>
    <link href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/jssocials.css" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/jssocials-theme-flat.css" />
    <script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jquery-2.1.1.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body <?php if ($_smarty_tpl->tpl_vars['kanal']->value!='home'){?> style="padding-top: 20px" id="deep" <?php }?>>

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
    <div class="topheader">
        <div class="container">
            <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['toppromo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a>
            <?php } ?>
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
/cart" class="visible-xs menuicon"><i class="fal fa-shopping-cart"></i></i><?php if ($_smarty_tpl->tpl_vars['jumlah_cart']->value>0){?> <span class="label label-danger"><?php echo $_smarty_tpl->tpl_vars['jumlah_cart']->value;?>
</span> <?php }?></a>
                    <div class="hcart pull-right">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart" class="menuicon hidden-xs"><i class="fal fa-shopping-cart"></i> Keranjang <?php if ($_smarty_tpl->tpl_vars['jumlah_cart']->value>0){?> <span class="label label-danger"><?php echo $_smarty_tpl->tpl_vars['jumlah_cart']->value;?>
</span> <?php }?></a>
                        <div class="dropdown hidden-xs">
                            <?php if ($_smarty_tpl->tpl_vars['jumlah_cart']->value!='0'){?>
                                <nav>
                                    <ul class="hcart-list">
                                        <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['topcarts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
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
                                        <?php } ?>
                                    </ul>
                                </nav>
                                <div class="hcart-total">
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart" class="btn btn-primary add-cart">Cart</a>
                                    <div class="total">Total - <ins><?php echo $_smarty_tpl->tpl_vars['totaltagihanhead']->value;?>
</ins></div>
                                </div>
                            <?php }else{ ?>
                                <!-- <span>Recently added item(s) - <ins>no item</ins></span> -->
                            <?php }?>
                        </div>
                         
                        <?php if ($_smarty_tpl->tpl_vars['login']->value=='1'){?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/dashboard" class="menuicon"><i class="fal fa-user"></i></a>
                        <?php }else{ ?>
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
                                        <?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_smarty_tpl->tpl_vars['secid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['jenis']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
$_smarty_tpl->tpl_vars['s']->_loop = true;
 $_smarty_tpl->tpl_vars['secid']->value = $_smarty_tpl->tpl_vars['s']->key;
?>
                                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['s']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['s']->value['nama'];?>
</a></li>
                                        <?php } ?>
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
</div><?php }} ?>