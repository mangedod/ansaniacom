<?php /* Smarty version Smarty-3.1.13, created on 2022-02-25 10:48:26
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/cart/detailinvoice.html" */ ?>
<?php /*%%SmartyHeaderCode:14750323016218437a20ba46-90563141%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5f759f9fb13818919eb7dd094606d99ff4a39ed' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/cart/detailinvoice.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14750323016218437a20ba46-90563141',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'orderid' => 0,
    'invoiceid' => 0,
    'urldownload' => 0,
    'tanggaltransaksi' => 0,
    'pembayarannya' => 0,
    'pembayaran' => 0,
    'bankpaynya' => 0,
    'kodepaynya' => 0,
    'virtualacnya' => 0,
    'pengiriman' => 0,
    'stats' => 0,
    'status' => 0,
    'urlconfirm' => 0,
    'detailproduk' => 0,
    'a' => 0,
    'i' => 0,
    'total_diskon' => 0,
    'namadiskon' => 0,
    'diskonnya' => 0,
    'kode_voucher' => 0,
    'total_diskon2' => 0,
    'ongkos_kirim' => 0,
    'totberat' => 0,
    'ongkos_kirim2' => 0,
    'totaltagihanakhird' => 0,
    'rekening' => 0,
    'b' => 0,
    'billingnama' => 0,
    'billingemail' => 0,
    'billingalamat' => 0,
    'namaagen' => 0,
    'services' => 0,
    'no_resi' => 0,
    'namalengkap' => 0,
    'alamatpengiriman' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_6218437a2e83c5_45874354',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6218437a2e83c5_45874354')) {function content_6218437a2e83c5_45874354($_smarty_tpl) {?>
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
 <?php if ($_smarty_tpl->tpl_vars['pembayaran']->value=='CreditCard'){?>- Bank <?php echo $_smarty_tpl->tpl_vars['bankpaynya']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['kodepaynya']->value;?>
 <?php }elseif($_smarty_tpl->tpl_vars['pembayaran']->value=='BankTransfer'){?>- <?php echo $_smarty_tpl->tpl_vars['virtualacnya']->value;?>
<?php }?><br>
                            <span class='infodetail'>Shipping Method</span> : <?php echo $_smarty_tpl->tpl_vars['pengiriman']->value;?>
<br>
                            <span class='infodetail'>Status</span> : <strong><?php echo $_smarty_tpl->tpl_vars['stats']->value;?>
</strong><br><br>

                                <?php if ($_smarty_tpl->tpl_vars['status']->value=='1'&&$_smarty_tpl->tpl_vars['pembayaran']->value=='Transfer'){?><a href="<?php echo $_smarty_tpl->tpl_vars['urlconfirm']->value;?>
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
                                    <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['detailproduk']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
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
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <?php if ($_smarty_tpl->tpl_vars['total_diskon']->value>0){?>
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
                                        <?php if ($_smarty_tpl->tpl_vars['ongkos_kirim']->value>0){?>
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
                                        <?php if ($_smarty_tpl->tpl_vars['pembayaran']->value=='Transfer'){?>
                                        <td>
                                            Payment is made in <strong>Transfer</strong>
                                            <br>To complete the payment transaction, please transfer to : <br><br>
                                            <ol>
                                            <?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['b']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rekening']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value){
$_smarty_tpl->tpl_vars['b']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['b']->key;
?>
                                                <li><b><?php echo $_smarty_tpl->tpl_vars['b']->value['bank'];?>
 (<?php echo $_smarty_tpl->tpl_vars['b']->value['akun'];?>
 a.n <?php echo $_smarty_tpl->tpl_vars['b']->value['namaak'];?>
)</b></li>
                                            <?php } ?>
                                            </ol>
                                        </td>
                                        <?php }elseif($_smarty_tpl->tpl_vars['pembayaran']->value=='CreditCard'){?>
                                        <td>
                                            Payment is made in <strong><?php echo $_smarty_tpl->tpl_vars['pembayarannya']->value;?>
</strong><br>
                                            Name of Bank : <strong><?php echo $_smarty_tpl->tpl_vars['bankpaynya']->value;?>
</strong><br>
                                            Card Number : <strong><?php echo $_smarty_tpl->tpl_vars['kodepaynya']->value;?>
</strong>
                                        </td>
                                        <?php }elseif($_smarty_tpl->tpl_vars['pembayaran']->value=='BankTransfer'){?>
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
                                    <?php if ($_smarty_tpl->tpl_vars['no_resi']->value!=''){?>
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
    </div><?php }} ?>