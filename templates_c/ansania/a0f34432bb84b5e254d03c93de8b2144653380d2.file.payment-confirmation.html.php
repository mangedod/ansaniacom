<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 18:26:09
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/cart/payment-confirmation.html" */ ?>
<?php /*%%SmartyHeaderCode:10774777426192965079e196-11516696%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a0f34432bb84b5e254d03c93de8b2144653380d2' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/cart/payment-confirmation.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10774777426192965079e196-11516696',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61929650845d02_73746470',
  'variables' => 
  array (
    'fulldomain' => 0,
    'subtotalnya' => 0,
    'invoicenya' => 0,
    'subtotal2' => 0,
    'userfullname' => 0,
    'now' => 0,
    'bank' => 0,
    'b' => 0,
    'bankpengirim' => 0,
    'bp' => 0,
    'norek' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61929650845d02_73746470')) {function content_61929650845d02_73746470($_smarty_tpl) {?>
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
                            <!-- <script type="text/javascript" src="#/librari/ajax/ajax_kota.js"></script> -->
                            <div class="row field-row">
                                <div class="col-xs-12 col-sm-6">
                                    <label>No. Invoice*</label>
                                    <input type="text" name="invoiceid" id="invoiceid" value="<?php echo $_smarty_tpl->tpl_vars['invoicenya']->value;?>
" class="le-input" required="required">
                                </div>
                                <?php if ($_smarty_tpl->tpl_vars['subtotalnya']->value!=''){?>
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
                                        <?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['b']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bank']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value){
$_smarty_tpl->tpl_vars['b']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['b']->key;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['b']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['b']->value['nama'];?>
</option>
                                        <?php } ?>
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
                                        <?php  $_smarty_tpl->tpl_vars['bp'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['bp']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bankpengirim']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['bp']->key => $_smarty_tpl->tpl_vars['bp']->value){
$_smarty_tpl->tpl_vars['bp']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['bp']->key;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['bp']->value['nama'];?>
"><?php echo $_smarty_tpl->tpl_vars['bp']->value['nama'];?>
</option>
                                        <?php } ?>
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
    </div><?php }} ?>