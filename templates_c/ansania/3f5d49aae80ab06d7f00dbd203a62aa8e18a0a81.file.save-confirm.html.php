<?php /* Smarty version Smarty-3.1.13, created on 2022-03-18 17:25:12
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/cart/save-confirm.html" */ ?>
<?php /*%%SmartyHeaderCode:70885644261acb16c734e02-97281747%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f5d49aae80ab06d7f00dbd203a62aa8e18a0a81' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/cart/save-confirm.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '70885644261acb16c734e02-97281747',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61acb16c78d0f6_99723439',
  'variables' => 
  array (
    'salah' => 0,
    'style' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61acb16c78d0f6_99723439')) {function content_61acb16c78d0f6_99723439($_smarty_tpl) {?>
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
                                <?php if ($_smarty_tpl->tpl_vars['salah']->value!=''){?>
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
    </div><?php }} ?>