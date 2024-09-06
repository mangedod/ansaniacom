<?php /* Smarty version Smarty-3.1.13, created on 2022-02-19 19:16:51
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/index.html" */ ?>
<?php /*%%SmartyHeaderCode:185298397061e93caca35206-60827492%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f49265fd45db10d7067b1142e58ae5733c3431c9' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/index.html',
      1 => 1645269675,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '185298397061e93caca35206-60827492',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61e93cacb59030_94408303',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'slide' => 0,
    'a' => 0,
    'dataprodukdepan' => 0,
    'datadepanvideo' => 0,
    'datainstagram' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61e93cacb59030_94408303')) {function content_61e93cacb59030_94408303($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="homeslide wow fadeIn">
    <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel"> 
      <ul class="carousel-indicators">
       <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['slide']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $_smarty_tpl->tpl_vars['a']->value['a'];?>
"  <?php if ($_smarty_tpl->tpl_vars['a']->value['no']=='1'){?>  class="active" <?php }?>></li>
       <?php } ?>
      </ul>
      <div class="carousel-inner">
        <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['slide']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
        <div class="item <?php if ($_smarty_tpl->tpl_vars['a']->value['no']=='1'){?> active <?php }?>">
          <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['gambar'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
" border="0" /></a>
        </div>
        <?php } ?>
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
            <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['ids'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataprodukdepan']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['ids']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
            <div class="col-md-3 col-xs-6">
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
                    <?php if ($_smarty_tpl->tpl_vars['a']->value['misc_diskonn']!='0'){?>
                    <del><?php echo $_smarty_tpl->tpl_vars['a']->value['price'];?>
</del>
                    <span class="new"><?php echo $_smarty_tpl->tpl_vars['a']->value['misc_diskon'];?>
</span>
                    <?php }else{ ?>
                    <span class="new"><?php echo $_smarty_tpl->tpl_vars['a']->value['price'];?>
</span>
                    <?php }?>
                </div> -->
                </div>
            </div>
            <?php } ?>
           
        <!-- /.row -->
    </div>
    <!-- /.container -->

</div>

<section class="video-sec  wow fadeIn">
    <div class="container">
        <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datadepanvideo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
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
        <?php } ?>
    </div>
</section>
<div class="section-ig  wow fadeIn">
    <div class="container">
     
        <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['ids'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datainstagram']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['ids']->value = $_smarty_tpl->tpl_vars['a']->key;
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
        <?php } ?>           
       

    </div>
</div>


<br clear="all" />

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>