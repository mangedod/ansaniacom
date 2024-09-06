<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:13:24
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.ordertracking.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c714302064_02327768',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b2dea283e3d9edef9b69dc5972d985d54a41c1ea' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.ordertracking.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c714302064_02327768 (Smarty_Internal_Template $_smarty_tpl) {
?>
            <h3>Order Tracking</h3>
            <hr>

            <div class="row text-center">
                <div class="col-md-12">
                    <center>
                        Welcome to our Order Tracking page!<br />
                        Please enter Your order number to track your order status.<br /> 
                        If you do not know Your order number, please check the order confirmation email <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 send it to your email address.<br /><br />
                        <?php if ($_smarty_tpl->tpl_vars['berhasil']->value == '1') {?>
                            <div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>
</div>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/ordertracking"  class="button">Kembali</strong></a>
                        <?php } elseif ($_smarty_tpl->tpl_vars['berhasil']->value == '0') {?>
                            <div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>
</div>
                            <ul>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pesan']->value, 'i', false, 'id');
$_smarty_tpl->tpl_vars['i']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->do_else = false;
?>
                                <li><?php echo $_smarty_tpl->tpl_vars['i']->value['pesan'];?>
</li>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </ul><br clear="all" />
                            <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/ordertracking" class="button"> Kembali</a>
                        <?php }?>
                        
                        <?php echo '<script'; ?>
>
                            function checkform()
                            {
                                var validEmail  = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                                if (document.getElementById("useremail").value == "")
                                {
                                    alert("Email tidak boleh kosong, silahkan isi terlebih dahulu");
                                    $("#useremail").focus();
                                    return false;
                                }
                                else if (! validEmail.test(document.getElementById("useremail").value))
                                {
                                    alert("Email tidak valid, silahkan ulangi kembali");
                                    $("#useremail").focus();
                                    return false;
                                }
                                if (document.getElementById("invoice").value == "")
                                {
                                    alert("Invoice cannot be empty");
                                    $("#uname").focus();
                                    return false;
                                }
                                else
                                {
                                    return true;
                                }
                            }
                        <?php echo '</script'; ?>
>
                        
                        <form role="form" action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/ordertracking" method="post" onsubmit="return checkform();">
                            <input type="hidden" name="action" value="cekorder" />
                                <div class="form-group">
                                    <input type="text" data-original-title="Invoice Number" name="invoice" data-content="Enter the number of the invoice here." data-trigger="focus" data-placement="left" data-toggle="popover" placeholder="Enter The Number Of The Invoice" id="invoiceid" class="form-control" required style="width: 36%;"/>
                                </div>

                              <button class="btn btn-primary" type="submit">Check Status</button>
                        </form>
                    </center>
                </div>
            </div>
            <br>
            <br>
            <?php if ($_smarty_tpl->tpl_vars['tracking']->value == '1') {?>
            <div class="panel-group panel-accordion" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" class="text-uppercase" data-parent="#accordion" href="" aria-expanded="true" aria-controls="collapseOne">
                                  Order #<?php echo $_smarty_tpl->tpl_vars['invoiceid']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['tanggaltransaksi']->value != '0000-00-00') {?>| Booked on : <?php echo $_smarty_tpl->tpl_vars['tanggaltransaksi']->value;?>
 <?php }?>
                                </a>
                        </h4>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['jumlahtransaksi']->value == '0') {?>
                    <div class="alert alert-warning">Transaction data with number invoice <strong>#<?php echo $_smarty_tpl->tpl_vars['invoiceid']->value;?>
</strong> not found. Please repeat it again.</div>
                    <?php } else { ?>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <?php if ($_smarty_tpl->tpl_vars['status']->value == '4') {?>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <?php echo $_smarty_tpl->tpl_vars['jmlproduk']->value;?>
 Products <?php if ($_smarty_tpl->tpl_vars['tanggaltransaksi']->value != '0000-00-00') {?>| Posted on <?php echo $_smarty_tpl->tpl_vars['tanggaltransaksi']->value;?>
 <?php }?>| Sent to <a href="#"><?php echo $_smarty_tpl->tpl_vars['namalengkap']->value;?>
</a> | Completed <i class="fa fa-check"></i>
                                </div>
                            </div>
                            <?php }?>
                            <div class="clearfix">&nbsp;</div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-simple">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php if ($_smarty_tpl->tpl_vars['tanggaltransaksi']->value != '0000-00-00') {
echo $_smarty_tpl->tpl_vars['tanggaltransaksi']->value;
}?></td>
                                            <td>
                                                <?php echo $_smarty_tpl->tpl_vars['ketstatuskirim']->value;?>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p><strong>The Package Contains :</strong> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['detailproduk']->value, 'a', false, 'transaksidetailid');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['transaksidetailid']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?><a href=""><?php echo $_smarty_tpl->tpl_vars['a']->value['namaprod'];?>
 - <?php echo $_smarty_tpl->tpl_vars['a']->value['namawarna'];?>
 (<?php echo $_smarty_tpl->tpl_vars['a']->value['namasize'];?>
), </a><?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?></p>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
            <?php }
}
}
