<?php /* Smarty version Smarty-3.1.13, created on 2022-03-17 16:44:30
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/product/product.read.html" */ ?>
<?php /*%%SmartyHeaderCode:1775829160619281e1265f79-09883371%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd33f3461075564633750af1371e839c69bbe4163' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/product/product.read.html',
      1 => 1647506918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1775829160619281e1265f79-09883371',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_619281e12f5219_45701396',
  'variables' => 
  array (
    'lokasiwebtemplate' => 0,
    'list_image' => 0,
    'a' => 0,
    'detailnama' => 0,
    'misc_diskonn' => 0,
    'price' => 0,
    'misc_diskon' => 0,
    'jenisid' => 0,
    'detaillengkap' => 0,
    'detailkode' => 0,
    'body_weight' => 0,
    'totalstok' => 0,
    'fulldomain' => 0,
    'produkpostid' => 0,
    'uri' => 0,
    'produklain' => 0,
    'p' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_619281e12f5219_45701396')) {function content_619281e12f5219_45701396($_smarty_tpl) {?><!-- CONTAINER: product -->
<div class="container product">
<div class="row">
    <!-- Product Gallery -->
     <script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jquery.izoomify.js"></script>
    <div class="col-sm-6">
      
       <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['albumid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list_image']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['albumid']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
         <?php if ($_smarty_tpl->tpl_vars['a']->value['index']=='1'){?>
         <div class="target">
            <img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_l'];?>
" style="width: 100%" id="photo-<?php echo $_smarty_tpl->tpl_vars['a']->value['index'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
"  data-izoomify-url="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_f'];?>
" data-izoomify-magnify="2"  data-izoomify-duration="300">        
         </div>
         <?php }?>

       <?php } ?>  
        <script type="text/javascript">
             $(document).ready(function(){
                  $('.target').izoomify();
              });
         </script>   
    </div>
    <!-- /product gallery -->
    <div class="col-sm-6 product-description">
            <h2 class="text-uppercase judul-item"><?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
</h2>
            <div class="cost">
                <?php if ($_smarty_tpl->tpl_vars['misc_diskonn']->value!='0'){?>
                <del><?php echo $_smarty_tpl->tpl_vars['price']->value;?>
</del>
                <span class="new"><?php echo $_smarty_tpl->tpl_vars['misc_diskon']->value;?>
</span> 
                <?php }else{ ?>
                <span class="new"><?php echo $_smarty_tpl->tpl_vars['price']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['jenisid']->value=='3'){?> /kodi<?php }else{ ?>/pcs<?php }?></span> 
                <?php }?>
            </div>
     
        <div class="text-description mt-20">
            <p><?php echo $_smarty_tpl->tpl_vars['detaillengkap']->value;?>
 <br />
            <br />
            Kode Produk: <?php echo $_smarty_tpl->tpl_vars['detailkode']->value;?>

            <br />
            Berat Produk: <?php echo $_smarty_tpl->tpl_vars['body_weight']->value;?>
 kilogram
             <br />
            Stok Tersedia: <?php echo $_smarty_tpl->tpl_vars['totalstok']->value;?>
 item
            </p>
             
        
	
      
        <?php if ($_smarty_tpl->tpl_vars['totalstok']->value!='0'){?>
       	 <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart/buy" method="post" id="product_addtocart_form">
            <input name="form_key" value="6UbXroakyQlbfQzK" type="hidden">
                
                
                   	 <input type="hidden" id="produkpostid" name="produkpostid" value="<?php echo $_smarty_tpl->tpl_vars['produkpostid']->value;?>
">
                       
                   
            </div>
              
			<script>
                function submitcart() {
                    document.getElementById("product_addtocart_form").submit();
                }
            </script>
             

            <div class=" product-count">
                <div id="product-navigation">
                    <div class="input-group spinner pull-left mr-15" data-trigger="spinner">
                        <input type="text" name="qty" value="1" data-rule="quantity" required>
                        <div class="input-group-addon">
                            <a href="javascript:;" class="spin-up" data-spin="up">
                                <i class="fa fa-plus"></i>
                            </a>
                            <a href="javascript:;" class="spin-down" data-spin="down">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default add-cart  btn-wa" value="Beli" onclick="submitcart();" ><i class="fal fa-shopping-cart"></i> Masuk Keranjang</button>
                    <a href="https://api.whatsapp.com/send?phone=6281224182900&text=Apakah%20produk%20<?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
%20masih%20tersedia? <?php echo $_smarty_tpl->tpl_vars['uri']->value;?>
"  target="_blank"class="btn btn-success"><i class="fab fa-whatsapp"></i> Beli via WhatsApp</a>
                </div>
            </div>
        <?php }else{ ?>
            <div class=" text-description">
                <div class="alert alert-danger">
                    <strong>Produk ini saat ini tidak tersedia atau stok sudah habis</strong>
                </div>
            </div>
            <br clear="all" /> <br clear="all" /> 
        </form>
        <?php }?>
       	</div> 
 </div>      
    </div>

    <div class="container mt-20">
        <div class="row">
             <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['albumid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list_image']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['albumid']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
             <?php if ($_smarty_tpl->tpl_vars['a']->value['index']>'1'){?>
             <div class="col-md-6">
             <div class="target">
                <img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_l'];?>
" style="width: 100%" id="photo-<?php echo $_smarty_tpl->tpl_vars['a']->value['index'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
"  data-izoomify-url="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_f'];?>
" data-izoomify-magnify="2"  data-izoomify-duration="300">        
             </div>
            </div>
             <?php }?>

           <?php } ?>

        </div>
    </div>

	
    <!-- CONTAINER -->
    <div class="container catalog-square">
        <div class="row">
            <div class="page-header2 col-md-12">
                <h4>Produk Lainnya</h4>
            </div>
        </div>

        <!-- row -->
        <div class="row text-center">
            <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['produkid1'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['produklain']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['produkid1']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
             <div class="col-md-3">
                <div class="citem wow fadeIn">
                <div class="cimg">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['p']->value['link_detail'];?>
" class="aimg">
                          <img src="<?php echo $_smarty_tpl->tpl_vars['p']->value['image_m'];?>
" data-src="<?php echo $_smarty_tpl->tpl_vars['p']->value['image_m'];?>
" data-alt-src="<?php echo $_smarty_tpl->tpl_vars['p']->value['image_m1'];?>
" class="product-img" alt="<?php echo $_smarty_tpl->tpl_vars['p']->value['namaprod'];?>
">
                          <!-- <?php if ($_smarty_tpl->tpl_vars['p']->value['misc_diskonn']!='0'){?><div class="sticker sticker-sale">sale</div><?php }?> -->
                    </a>
                </div>
                <h5><a href="<?php echo $_smarty_tpl->tpl_vars['p']->value['link_detail'];?>
" class="black"><?php echo $_smarty_tpl->tpl_vars['p']->value['namaprod'];?>
</a></h5>
               <div class="cost">
                    <?php if ($_smarty_tpl->tpl_vars['p']->value['misc_diskonn']!='0'){?>
                    <del><?php echo $_smarty_tpl->tpl_vars['p']->value['price'];?>
</del>
                    <span class="new"><?php echo $_smarty_tpl->tpl_vars['p']->value['misc_diskon'];?>
</span>
                    <?php }else{ ?>
                    <span class="new"><?php echo $_smarty_tpl->tpl_vars['p']->value['price'];?>
</span>
                    <?php }?>
                </div>                        
            </div>
            </div>
           
            <?php } ?>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container --><?php }} ?>