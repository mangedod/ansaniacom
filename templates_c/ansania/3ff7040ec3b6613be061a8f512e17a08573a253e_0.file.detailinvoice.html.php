<?php
/* Smarty version 4.3.0, created on 2023-08-16 06:53:48
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/cart/detailinvoice.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_64dc727c3a7d69_99497741',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3ff7040ec3b6613be061a8f512e17a08573a253e' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/cart/detailinvoice.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64dc727c3a7d69_99497741 (Smarty_Internal_Template $_smarty_tpl) {
?>
    <!-- HOME -->
    <div class="overlay home small-medium-size">
        <div class="bg bg-shop"></div>
        <div class="container vmiddle">
            <div class="row text-center text-title-list">
                <h1 class="text-uppercase" style="font-size: 50px">Order Detail</h1>
                <!-- <h4>Dashboard page</h4> -->
            </div>
        </div>
    </div>
    <!-- /.home -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-xs-12 no-margin">
                        <div class="billing-address">
                            <h4>Order Detail #<?php echo $_smarty_tpl->tpl_vars['orderid']->value;?>
, Invoice #<?php echo $_smarty_tpl->tpl_vars['invoiceid']->value;?>
</h4>
                            <br clear="all" /><br />
                            <a href="<?php echo $_smarty_tpl->tpl_vars['urldownload']->value;?>
" target="_blank" class="btn btn-primary btn-xs">Print Invoice</a><br clear="all" /><br />
                            <span class='infodetail'>Date </span>: <?php echo $_smarty_tpl->tpl_vars['tanggaltransaksi']->value;?>
<br>
                            <span class='infodetail'>Method Of Payment</span> : <?php echo $_smarty_tpl->tpl_vars['pembayarannya']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['pembayaran']->value == 'CreditCard') {?>- Bank <?php echo $_smarty_tpl->tpl_vars['bankpaynya']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['kodepaynya']->value;?>
 <?php } elseif ($_smarty_tpl->tpl_vars['pembayaran']->value == 'BankTransfer') {?>- <?php echo $_smarty_tpl->tpl_vars['virtualacnya']->value;
}?><br>
                            <span class='infodetail'>Shipping Method</span> : <?php echo $_smarty_tpl->tpl_vars['pengiriman']->value;?>
<br>
                            <span class='infodetail'>Status</span> : <strong><?php echo $_smarty_tpl->tpl_vars['stats']->value;?>
</strong><br><br>

                                <?php if ($_smarty_tpl->tpl_vars['status']->value == '1' && $_smarty_tpl->tpl_vars['pembayaran']->value == 'Transfer') {?><a href="<?php echo $_smarty_tpl->tpl_vars['urlconfirm']->value;?>
" target="_blank" class="btn btn-primary btn-xs">Payment Confirmation</a><br /><br /><?php }?>
                        </div>
                        <!-- /.billing-address -->
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-cart">
                                    <thead>
                                        <tr>
                                            <th class="normal" width="10%">No</th>
                                            <th width="15%">Product Name</th>
                                            <th class="text-center" width="20%">Product Code</th>
                                            <th class="text-center" width="20%">Description</th>
                                            <th class="text-center" width="10%">Quantity</th>
                                            <th class="text-center" width="10%">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['detailproduk']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
                                        <tr>
                                            <td class="normal"><?php echo $_smarty_tpl->tpl_vars['a']->value['xx'];?>
</td>
                                            <td><?php echo $_smarty_tpl->tpl_vars['a']->value['namaprod'];?>
</td>
                                            <td class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['i']->value['urldetail'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['kodeproduk'];?>
</a></td>
                                            <td class="text-center">Color : <?php echo $_smarty_tpl->tpl_vars['a']->value['namawarna'];?>
 <br/>Size : <?php echo $_smarty_tpl->tpl_vars['a']->value['size'];?>
</td>
                                            <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['a']->value['qty'];?>
</td>
                                            <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['a']->value['harga'];?>
</td>
                                        </tr>
                                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </tbody>
                                    <tfoot>
                                        <?php if ($_smarty_tpl->tpl_vars['total_diskon']->value > 0) {?>
                                        <tr>
                                            <td colspan="5" class="text-right">
                                                <span class="text-uppercase"><b>Discount Voucher <?php echo $_smarty_tpl->tpl_vars['namadiskon']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['diskonnya']->value;?>
 (<?php echo $_smarty_tpl->tpl_vars['kode_voucher']->value;?>
)</b></span>
                                            </td>
                                            <td colspan="1" class="text-right">
                                                <b>(-) <?php echo $_smarty_tpl->tpl_vars['total_diskon2']->value;?>
</b>
                                            </td>
                                        </tr>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['ongkos_kirim']->value > 0) {?>
                                        <tr>
                                            <td colspan="5" class="text-right">
                                                <span class="text-uppercase"><b>Shipping (<?php echo $_smarty_tpl->tpl_vars['totberat']->value;?>
 Gram)</b></span>
                                            </td>
                                            <td colspan="1" class="text-right">
                                                <b><?php echo $_smarty_tpl->tpl_vars['ongkos_kirim2']->value;?>
</b>
                                            </td>
                                        </tr>
                                        <?php }?>
                                        <tr>
                                            <td colspan="5" class="text-right">
                                                <span class="text-uppercase"><b>Grand Total</b></span>
                                            </td>
                                            <td colspan="1" class="text-right">
                                                <b><?php echo $_smarty_tpl->tpl_vars['totaltagihanakhird']->value;?>
</b>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div> 

                        <!-- <div class="col-md-12">
                        </div> -->
                        <div class="col-md-6">
                            <h4>Payment Information</h4>
                            <table class="table table-cart table-description">
                                <tbody>
                                    <tr>
                                        <?php if ($_smarty_tpl->tpl_vars['pembayaran']->value == 'Transfer') {?>
                                        <td>
                                            Payment is made in <strong>Transfer</strong>
                                            <br>To complete the payment transaction, please transfer to : <br><br>
                                            <ol>
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rekening']->value, 'b', false, 'id');
$_smarty_tpl->tpl_vars['b']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['b']->value) {
$_smarty_tpl->tpl_vars['b']->do_else = false;
?>
                                                <li><b><?php echo $_smarty_tpl->tpl_vars['b']->value['bank'];?>
 (<?php echo $_smarty_tpl->tpl_vars['b']->value['akun'];?>
 a.n <?php echo $_smarty_tpl->tpl_vars['b']->value['namaak'];?>
)</b></li>
                                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                            </ol>
                                        </td>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['pembayaran']->value == 'CreditCard') {?>
                                        <td>
                                            Payment is made in <strong><?php echo $_smarty_tpl->tpl_vars['pembayarannya']->value;?>
</strong><br>
                                            Name of Bank : <strong><?php echo $_smarty_tpl->tpl_vars['bankpaynya']->value;?>
</strong><br>
                                            Card Number : <strong><?php echo $_smarty_tpl->tpl_vars['kodepaynya']->value;?>
</strong>
                                        </td>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['pembayaran']->value == 'BankTransfer') {?>
                                        <td>
                                            Payment is made in <strong><?php echo $_smarty_tpl->tpl_vars['pembayarannya']->value;?>
</strong><br>
                                            Please do payment with<br>
                                            Virtual Account No : <strong><?php echo $_smarty_tpl->tpl_vars['virtualacnya']->value;?>
</strong>
                                        </td>
                                        <?php }?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Billing Information</h4>
                            <table class="table table-cart table-description">
                                <tbody>
                                    <tr>
                                        <td>Name</td><td><b>: &nbsp;<?php echo $_smarty_tpl->tpl_vars['billingnama']->value;?>
</b></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td><td><b>: &nbsp;<?php echo $_smarty_tpl->tpl_vars['billingemail']->value;?>
</b></td>
                                    </tr>
                                    <tr>
                                        <td>Address</td><td><b>: &nbsp;<?php echo $_smarty_tpl->tpl_vars['billingalamat']->value;?>
</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <div class="clearfix">&nbsp;</div>
                            <h4>Shipping Information</h4>
                            <table class="table table-cart table-description">
                                <tbody>
                                    <tr>
                                        <td>Shipping Agent</td><td><b>: &nbsp;<?php echo $_smarty_tpl->tpl_vars['namaagen']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['services']->value;?>
</b></td>
                                    </tr>
                                    <?php if ($_smarty_tpl->tpl_vars['no_resi']->value != '') {?>
                                    <tr>
                                        <td>Delivery Receipt Number</td><td><b>: &nbsp;<?php echo $_smarty_tpl->tpl_vars['no_resi']->value;?>
</b></td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td>Full Name</td><td><b>: &nbsp;<?php echo $_smarty_tpl->tpl_vars['namalengkap']->value;?>
</b></td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Address</td><td><b>: &nbsp;<?php echo $_smarty_tpl->tpl_vars['alamatpengiriman']->value;?>
</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.place-order-button -->

                </div>
                <!-- /.col -->
            </div>
        </div>
    </div><?php }
}
