<?php
/* Smarty version 4.3.0, created on 2024-03-27 05:57:08
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/cart/payment-confirmation.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603b534da0677_23440531',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6bf7d112d667dbe81e945e389f7c42554292119a' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/cart/payment-confirmation.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603b534da0677_23440531 (Smarty_Internal_Template $_smarty_tpl) {
?>
    <!-- HOME -->
    <div class="overlay home small-medium-size">
        <div class="bg bg-shop"></div>
        <div class="container vmiddle">
            <div class="row text-center text-title-list">
                <h1 class="text-uppercase">Payment Confirmation</h1>
                <!-- <h4>Dashboard page</h4> -->
            </div>
        </div>
    </div>
    <!-- /.home -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-xs-12 no-margin">
                    <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart/save-confirm">
                        <input type="hidden" name="total" id="total" value="<?php echo $_smarty_tpl->tpl_vars['subtotalnya']->value;?>
">
                        <div class="billing-address">
                            <h4>Payment Confirmation</h4>
                            <!-- <?php echo '<script'; ?>
 type="text/javascript" src="#/librari/ajax/ajax_kota.js"><?php echo '</script'; ?>
> -->
                            <div class="row field-row">
                                <div class="col-xs-12 col-sm-6">
                                    <label>No. Invoice*</label>
                                    <input type="text" name="invoiceid" id="invoiceid" value="<?php echo $_smarty_tpl->tpl_vars['invoicenya']->value;?>
" class="le-input" required="required">
                                </div>
                                <?php if ($_smarty_tpl->tpl_vars['subtotalnya']->value != '') {?>
                                <div class="col-xs-12 col-sm-6">
                                    <label>Total Tagihan*</label>
                                    <h3><b><?php echo $_smarty_tpl->tpl_vars['subtotal2']->value;?>
</b></h3>
                                </div>
                                <?php }?>

                            </div>

                            <div class="row field-row">
                                <div class="col-xs-12 col-sm-6">
                                    <label>Sender Name*</label>
                                    <input type="text" id="userfullname" class="le-input" name="name" value="<?php echo $_smarty_tpl->tpl_vars['userfullname']->value;?>
" />
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label>Total*</label>
                                    <input type="text" name="jumlah_bayar" id="jumlah_bayar" class="le-input" value="<?php echo $_smarty_tpl->tpl_vars['subtotalnya']->value;?>
" required="required">
                                </div>

                            </div>
                            <!-- /.field-row -->

                            <div class="row field-row">
                                <div class="col-xs-12 col-sm-6" id="inputDate">
                                    <label>Date *</label>
                                    <div class="input-group date">
                                        <input type="text" name="date" value="<?php echo $_smarty_tpl->tpl_vars['now']->value;?>
" class="form-control" title="Date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label>Destination Bank*</label>
                                    <select name="bank" id="banktujuan" class="form-control">
                                        <option value="">Select Bank</option>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['bank']->value, 'b', false, 'id');
$_smarty_tpl->tpl_vars['b']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['b']->value) {
$_smarty_tpl->tpl_vars['b']->do_else = false;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['b']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['b']->value['nama'];?>
</option>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </select>
                                </div>
                            </div>
                            <!-- /.field-row -->

                            <div class="row field-row">
                                <div class="col-xs-12 col-sm-6">
                                    <label>Sender Bank*</label>
                                    <!-- <input type="text" name="bankdari" id="bankdari" class="le-input" value="" required="required"> -->
                                    <select name="bankdari" id="bankdari" class="form-control" required="required">
                                        <option value="">Select Bank</option>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['bankpengirim']->value, 'bp', false, 'id');
$_smarty_tpl->tpl_vars['bp']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['bp']->value) {
$_smarty_tpl->tpl_vars['bp']->do_else = false;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['bp']->value['nama'];?>
"><?php echo $_smarty_tpl->tpl_vars['bp']->value['nama'];?>
</option>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label>Sender Account Number*</label>
                                    <input type="text" name="norek" id="norek" class="le-input" value="<?php echo $_smarty_tpl->tpl_vars['norek']->value;?>
" required="required">
                                </div>
                            </div>
                            <!-- /.field-row -->

                            <div class="row field-row">
                                <div class="col-xs-12 col-sm-12">
                                    <label>Message</label>
                                    <textarea name="pesan" id="pesan" class="le-input" data-placeholder="Message"></textarea>
                                </div>
                            </div>

                        </div>
                        <!-- /.billing-address -->
                        <div class="col-md-12">
                            <div class="clearfix">&nbsp;</div>
                            <button class="btn btn-primary" type="submit">Confirm</button>
                        </div>
                        <!-- /.place-order-button -->
                    </form>

                </div>
                <!-- /.col -->
            </div>
        </div>
    </div><?php }
}
