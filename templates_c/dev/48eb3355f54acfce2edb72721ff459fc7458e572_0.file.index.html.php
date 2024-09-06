<?php
/* Smarty version 4.3.0, created on 2023-02-14 00:13:35
  from 'http://localhost:8080/ansaniacom/public_html/template/dev/index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ead22fba67c0_71044047',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48eb3355f54acfce2edb72721ff459fc7458e572' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/dev/index.html',
      1 => 1579394743,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63ead22fba67c0_71044047 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
<div class="homeslide">
    <div id="myCarousel" class="carousel slide" data-ride="carousel"> 
      <ol class="carousel-indicators">
       <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['slide']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $_smarty_tpl->tpl_vars['a']->value['a'];?>
"  <?php if ($_smarty_tpl->tpl_vars['a']->value['no'] == '1') {?> active <?php }?> class="active"></li>
       <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      </ol>
      <div class="carousel-inner">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['slide']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
        <div class="item <?php if ($_smarty_tpl->tpl_vars['a']->value['no'] == '1') {?> active <?php }?>">
          <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['gambar'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
" border="0" /></a>
        </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
   	</div>
</div>

<div class="container">
	<div class="row">
    <div class="marketplace animated fadeInUp">
    	 <!--<div class="col-xs-6">
        <div class="row">
        <div class="marketplace-item">
        	<div class="col-md-3 col-xs-12">
            	<div class="marketplace-item-img">
                <a href="https://shopee.co.id/ansaniahijabolshop" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.shopee.jpg" /></a>
                </div>
            </div>
            <div class="col-md-9 col-xs-12">
            	<a href="https://shopee.co.id/ansaniahijabolshop" target="_blank"><div class="marketplace-item-judul">Belanja di Shopee</div>
                <p class="hidden-xs">Temukan dan belanja produk-produk kerudung 
                pilihan Ansania di Shopee.</p></a>
            </div>
        </div>
        </div>
        </div>
        <div class="col-xs-6">
         <div class="row">
        <div class="marketplace-item">
        	<div class="col-md-3 col-xs-12">
            	<div class="marketplace-item-img">
                <a href="https://www.tokopedia.com/kerudung-ansania/" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.tokopedia.jpg" /></a>
                </div>
            </div>
            <div class="col-md-9 col-xs-12">
            	<a href="https://www.tokopedia.com/kerudung-ansania/" target="_blank"><div class="marketplace-item-judul">Belanja di Tokopedia</div>
                <p class="hidden-xs">Temukan dan belanja produk-produk kerudung 
                pilihan Ansania di Tokopedia.</p></a>
            </div>
        </div>
        </div>
        </div>
        <div class="col-xs-6">
         <div class="row">
        <div class="marketplace-item">
        	<div class="col-md-3 col-xs-12">
            	<div class="marketplace-item-img">
                <a href="https://www.bukalapak.com/u/officialansania01" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.bukalapak.jpg" /></a>
                </div>
            </div>
            <div class="col-md-9 col-xs-12">
            	<a href="https://www.bukalapak.com/u/officialansania01" target="_blank"><div class="marketplace-item-judul">Belanja di BukaLapak</div>
                <p class="hidden-xs">Temukan dan belanja produk-produk kerudung 
                pilihan Ansania di BukaLapak.</p></a>
            </div>
        </div>
        </div>
        </div> -->
        <div class="col-xs-6">
         <div class="row">
        <div class="marketplace-item">
        	<div class="col-md-3 col-xs-12">
            	<div class="marketplace-item-img">
                <a href="https://wa.me/6282110698844" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.wa.jpg" /></a>
                </div>
            </div>
            <div class="col-md-9 col-xs-12">
            	<a href="https://wa.me/6282110698844" target="_blank"><div class="marketplace-item-judul">Belanja via WhatsApp</div>
                <p class="hidden-xs">Anda juga bisa langsung belanja melalui WhatsApp kami.</p></a>
            </div>
        </div>
        </div>
        </div>
        <div class="col-xs-6">
         <div class="row">
        <div class="marketplace-item">
        	<div class="col-md-3 col-xs-12">
            	<div class="marketplace-item-img">
                <a href="https://www.instagram.com/ansania_collections/" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.ig.png" /></a>
                </div>
            </div>
            <div class="col-md-9 col-xs-12">
            	<a href="https://www.instagram.com/ansania_collections/" target="_blank"><div class="marketplace-item-judul">Belanja via Instagram</div>
                <p class="hidden-xs">Anda juga bisa langsung belanja dengan DM Instagram kami.</p></a>
            </div>
        </div>
        </div>
        </div>
        <!-- <div class="col-xs-4"> 
         <div class="row">
        <div class="marketplace-item">
        	<div class="col-md-3 col-xs-12">
            	<div class="marketplace-item-img">
                <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product"><img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.web.png" /></a>
                </div>
            </div>
            <div class="col-md-9 col-xs-12">
            	<a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product"><div class="marketplace-item-judul">Belanja via Website</div>
                <p class="hidden-xs">Cari produk-produk pilihan kami di website ini .</p></a>
            </div>
        </div>
        </div>
        </div>-->
        
    </div>
    </div>
</div>

<!-- CONTENT -->
<div class="content">
<div class="container hidden-xs">
 <div class="row">

     <!-- CONTAINER -->
    <div class="container wow fadeInUp">
        <div class="row">
            <div class="page-header2 col-md-12">
            	<center>
                <h2>Produk Terbaru</h2>
                <span>Temukan Banyak produk terbaru yang cantik dan menarik untuk menambah koleksi fashion anda</span>
                </center>
            </div>
        </div>

        <!-- row -->
        <div class="row">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['dataprodukdepan']->value, 'a', false, 'ids');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['ids']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
            <div class="col-md-3 col-sm-6">
                <div class="citem item wow fadeInUp">
                <div class="cimg">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link_detail'];?>
" class="aimg">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_m'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['namaprod'];?>
">
                        <?php if ($_smarty_tpl->tpl_vars['a']->value['misc_diskonn'] != '0') {?><div class="sticker sticker-sale">sale</div><?php }?>
                    </a>
                  
                </div>
                <h5><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link_detail'];?>
" class="black"><?php echo $_smarty_tpl->tpl_vars['a']->value['namaprod'];?>
</a></h5>
                <div class="cost">
                    <?php if ($_smarty_tpl->tpl_vars['a']->value['misc_diskonn'] != '0') {?>
                    <del><?php echo $_smarty_tpl->tpl_vars['a']->value['price'];?>
</del>
                    <span class="new"><?php echo $_smarty_tpl->tpl_vars['a']->value['misc_diskon'];?>
</span>
                    <?php } else { ?>
                    <span class="new"><?php echo $_smarty_tpl->tpl_vars['a']->value['price'];?>
</span>
                    <?php }?>
                </div>
                </div>
            </div>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
	</div>
    

</div>
<!-- /.wrapper -->
<div class="besthome">
	<div class="container">
    	<div class="col-md-4">
        	<div class="besthome-item">
            	<div class="besthome-item-icon"><span class="fa fa-gift"></span></div>
                <h3>Produk Terbaik</h3>
                Jaminan kualitas terbaik hijab asli produksi
                Indonesia
                
            </div>
        </div>
        <div class="col-md-4">
        	<div class="besthome-item">
            	<div class="besthome-item-icon"><span class="fa fa-users"></span></div>
                <h3>Layanan Terbaik</h3>
                Jaminan kualitas terbaik hijab asli produksi
                Indonesia
                
            </div>
        </div>
        <div class="col-md-4">
        	<div class="besthome-item">
            	<div class="besthome-item-icon"><span class="fa fa-thumbs-o-up"></span></div>
                <h3>Kualitas Terbaik</h3>
                Jaminan kualitas terbaik hijab asli produksi
                Indonesia
               
            </div>
        </div>

        
    </div> 
</div>   

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
