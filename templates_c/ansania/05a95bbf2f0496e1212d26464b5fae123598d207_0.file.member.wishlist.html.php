<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:13:25
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.wishlist.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c7156bb127_61452346',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '05a95bbf2f0496e1212d26464b5fae123598d207' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.wishlist.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c7156bb127_61452346 (Smarty_Internal_Template $_smarty_tpl) {
?><h3>Wishlist</h3>
<hr>
<?php if ($_smarty_tpl->tpl_vars['jumlah_keranjang']->value != '0') {?>

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
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['dt_wishlist']->value, 'a', false, 'wishlistid');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['wishlistid']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
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
                                <?php if ($_smarty_tpl->tpl_vars['a']->value['totalstok'] != '0') {?>
                                <span class="label label-info wishlist-in-stock" style="margin-top:15px;display:inline-block">In Stock</span>
                                <?php } else { ?>
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
                    <?php
}
if ($_smarty_tpl->tpl_vars['a']->do_else) {
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
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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
<?php } else { ?>
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
          <?php }
}
