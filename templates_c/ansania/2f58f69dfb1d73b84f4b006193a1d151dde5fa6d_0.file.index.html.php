<?php
/* Smarty version 4.3.0, created on 2024-03-27 05:57:20
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603b54006c692_74547970',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2f58f69dfb1d73b84f4b006193a1d151dde5fa6d' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/index.html',
      1 => 1645586649,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603b54006c692_74547970 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
<div class="homeslide wow fadeIn">
    <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel"> 
      <ul class="carousel-indicators">
       <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['slide']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $_smarty_tpl->tpl_vars['a']->value['a'];?>
"  <?php if ($_smarty_tpl->tpl_vars['a']->value['no'] == '1') {?>  class="active" <?php }?>></li>
       <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      </ul>
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

<div class="benefit  wow fadeIn">
    <div class="container">
	<div class="col-md-3" style="background: #f99cbf;">
    	<div class="benefit-item">
        	<div class="benefit-icon"><i class="fal fa-flag"></i></div>
        
            <div class="benefit-info">
                <div class="benefit-info-judul">Produk Asli Indonesia</div>
                Tercipta dari cinta akan
                produk asli indonesia.
            </div>
        </div>
    </div>
    <div class="col-md-3" style="background: #ea729f;">
    	<div class="benefit-item">
        	<div class="benefit-icon"><i class="fal fa-heart"></i></div>
        
            <div class="benefit-info">
                <div class="benefit-info-judul">Didesain Penuh Cinta</div>
                Tercipta dari cinta akan
                produk asli indonesia.
            </div>
        </div>
    </div>
    <div class="col-md-3" style="background: #e54883;">
    	<div class="benefit-item">
        	<div class="benefit-icon"><i class="fal fa-tag"></i></div>
        
            <div class="benefit-info">
                <div class="benefit-info-judul">Harga Terjangkau</div>
                Kualitas Menawan tetapi harga tetap terjangkau.
            </div>
        </div>
    </div>
    <div class="col-md-3" style="background: #cc3772;">
    	<div class="benefit-item">
        	<div class="benefit-icon"><i class="fal fa-palette"></i></div>
        
            <div class="benefit-info">
                <div class="benefit-info-judul">Desain Paling Beda</div>
                Tercipta dari cinta akan
                produk asli indonesia.
            </div>
        </div>
    </div>
   
 </div>
</div>

<div class="container  wow fadeIn">
     <!-- CONTAINER -->
    <div class="wow fadeIn" id="productlist">
        <div class="row">
            <div class="page-header2 col-md-12">
                <center>
                <h2>COLLECTION FEATURED</h2>
                </center>
            </div>
        </div>

         <!-- row -->
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['dataprodukdepan']->value, 'a', false, 'ids');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['ids']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
            <div class="col-md-4 col-xs-12">
                <div class="citem item wow fadeIn">
                <div class="cimg">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link_detail'];?>
" class="aimg">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_m'];?>
" data-src="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_m'];?>
" data-alt-src="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_m1'];?>
" class="product-img" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['namaprod'];?>
">
                    </a>                  
                </div>
                <h5><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link_detail'];?>
" class="black"><?php echo $_smarty_tpl->tpl_vars['a']->value['namaprod'];?>
</a></h5>
               <!-- <div class="cost">
                    <?php if ($_smarty_tpl->tpl_vars['a']->value['misc_diskonn'] != '0') {?>
                    <del><?php echo $_smarty_tpl->tpl_vars['a']->value['price'];?>
</del>
                    <span class="new"><?php echo $_smarty_tpl->tpl_vars['a']->value['misc_diskon'];?>
</span>
                    <?php } else { ?>
                    <span class="new"><?php echo $_smarty_tpl->tpl_vars['a']->value['price'];?>
</span>
                    <?php }?>
                </div> -->
                </div>
            </div>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
           
        <!-- /.row -->
    </div>
    <!-- /.container -->

</div>

<section class="video-sec  wow fadeIn">
    <div class="container">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datadepanvideo']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
        <div class="col-md-6">
            <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $_smarty_tpl->tpl_vars['a']->value['youtubeid'];?>
"></iframe>
          </div>
      </div>
        <div class="col-md-6">
            <h2><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</h2>
            <?php echo $_smarty_tpl->tpl_vars['a']->value['ringkas'];?>
<br clear="all">
        </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </div>
</section>
<div class="section-ig  wow fadeIn">
    <div class="container">
     
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datainstagram']->value, 'a', false, 'ids');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['ids']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
        <div class="col-md-3 col-xs-6">
            <div class="instagram-img">
                <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['url'];?>
" target="_blank">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['gambar'];?>
" class="w-100 terang" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['namaprod'];?>
">
                </a>                  
            </div>             
        </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>           
       

    </div>
</div>


<br clear="all" />

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
