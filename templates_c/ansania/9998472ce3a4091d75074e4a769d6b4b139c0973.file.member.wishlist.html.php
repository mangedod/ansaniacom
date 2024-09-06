<?php /* Smarty version Smarty-3.1.13, created on 2022-01-21 16:33:11
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.wishlist.html" */ ?>
<?php /*%%SmartyHeaderCode:60956630361ea6fc762d698-74480873%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9998472ce3a4091d75074e4a769d6b4b139c0973' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.wishlist.html',
      1 => 1642674336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '60956630361ea6fc762d698-74480873',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'jumlah_keranjang' => 0,
    'dt_wishlist' => 0,
    'a' => 0,
    'fulldomain' => 0,
    'kanal' => 0,
    'lokasiwebtemplate' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ea6fc76ac913_40437181',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ea6fc76ac913_40437181')) {function content_61ea6fc76ac913_40437181($_smarty_tpl) {?><h3>Wishlist</h3>
<hr>
<?php if ($_smarty_tpl->tpl_vars['jumlah_keranjang']->value!='0'){?>

     <!-- CONTAINER: cart -->
        <div class="cart">

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="cart-table border-bottom">
                    <thead>
                    <tr>
                        <th colspan="2" class="text-center">Product</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['wishlistid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dt_wishlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['wishlistid']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
                        <tr>
                            <td class="text-center">
                               <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link_produk'];?>
" class="thumb-holder">
                                    <img  alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_s'];?>
" style="width: 30%;" />
                                </a>
                            </td>
                            <td class="td-descr">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link_produk'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a>
                            </td>
                            <td>
                                <div class="cost"><?php echo $_smarty_tpl->tpl_vars['a']->value['harga'];?>
</div>
                            </td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['a']->value['totalstok']!='0'){?>
                                <span class="label label-info wishlist-in-stock" style="margin-top:15px;display:inline-block">In Stock</span>
                                <?php }else{ ?>
                                <span class="label label-danger wishlist-in-stock" style="margin-top:15px;display:inline-block">Out of Stock</span>
                                <?php }?>
                            </td>
                            <td>
                                
                                <input type="hidden" name="product-data" data-color="" data-size="">
                            </td>
                            <td class="text-center">
                                <!-- <a href="" class="pclose small tr-remove"><i class="custom-icon custom-icon-close-s"></i></a> -->
                                <a class="close-btn" href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['kanal']->value;?>
/wishlist/delete/<?php echo $_smarty_tpl->tpl_vars['a']->value['wishlistid'];?>
"><i class="custom-icon custom-icon-close-s"></i></a>
                            </td>
                        </tr>
                    <?php }
if (!$_smarty_tpl->tpl_vars['a']->_loop) {
?>
                    <tr>
                        <td colspan="6">
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                You currently do not have the product you wishlist.<br /> 
                                To enter a wishlist, Please visit our various products.<br /><br />
                                <a class="btn btn-warning" href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product">Select The Product</a><br /><br />
                            </div>      
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>

                <div id="popover-content-" class="hidden">
                    <div style="width: 200px;">
                    <div class="form-group">
                        <select name="color" class="form-control" id="color">
                            <option value="">Select Color</option>
                            <option value="color-1">color-1</option>
                            <option value="color-2">color-2</option>
                            <option value="color-3">color-3</option>
                            <option value="color-4">color-4</option>
                            <option value="color-5">color-5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="size" class="form-control" id="size">
                            <option value="">Select Size</option>
                            <option value="size-1">size-1</option>
                            <option value="size-2">size-2</option>
                            <option value="size-3">size-3</option>
                            <option value="size-4">size-4</option>
                            <option value="size-5">size-5</option>
                        </select>
                    </div>
                        <a href="#" class="btn btn-block btn-xs btn-primary">Add &nbsp;<i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /table -->

        </div>
        <!-- /.container -->
<?php }else{ ?>
<div class="row text-center">
	<div class="col-md-12">
		<center>
	        <img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/icon.wishlist.png" alt="Wishlist" /><br />
	        You currently do not have the product you wishlist.<br /> 
	        To enter a wishlist, Please visit our various products.<br /><br />
	        <a class="btn btn-warning" href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product">Select The Product</a><br /><br />
	    </center>
	</div>
</div>
<?php }?>
          <?php }} ?>