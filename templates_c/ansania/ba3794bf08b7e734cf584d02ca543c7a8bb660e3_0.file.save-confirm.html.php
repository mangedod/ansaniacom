<?php
/* Smarty version 4.3.0, created on 2023-05-30 01:11:07
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/cart/save-confirm.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_64754d2bbe8295_87446455',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ba3794bf08b7e734cf584d02ca543c7a8bb660e3' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/cart/save-confirm.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64754d2bbe8295_87446455 (Smarty_Internal_Template $_smarty_tpl) {
?>
    <!-- HOME -->
    <div class="overlay home small-medium-size">
        <div class="bg bg-shop"></div>
        <div class="container vmiddle">
            <div class="row text-center text-title-list">
                <h1 class="text-uppercase" style="font-size: 50px">Payment Confirmation</h1>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-xs-12 no-margin">
                    <form method="post" action="#/cart/save-confirm">
                        <input type="hidden" name="total" id="total" value="">
                        <div class="billing-address">
                            <h4>Payment Confirmation</h4>
                            <div class="row field-row">
                                <!-- <div class="col-xs-12 col-sm-6">
                                    <label>No. Invoice*</label>
                                    <input type="text" name="invoiceid" id="invoiceid" value="" class="le-input" required="required">
                                </div> -->
                                <?php if ($_smarty_tpl->tpl_vars['salah']->value != '') {?>
                                    <div class="alert <?php echo $_smarty_tpl->tpl_vars['style']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['salah']->value;?>
</div>
                                <?php }?>

                            </div>
                        </div>
                    </form>

                </div>
                <!-- /.col -->
            </div>
        </div>
    </div><?php }
}
