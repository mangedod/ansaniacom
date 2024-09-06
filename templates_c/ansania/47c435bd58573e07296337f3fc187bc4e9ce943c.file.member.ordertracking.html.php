<?php /* Smarty version Smarty-3.1.13, created on 2022-01-21 16:33:10
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.ordertracking.html" */ ?>
<?php /*%%SmartyHeaderCode:72011542261ea6fc66b0bb1-73928274%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '47c435bd58573e07296337f3fc187bc4e9ce943c' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.ordertracking.html',
      1 => 1642674336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '72011542261ea6fc66b0bb1-73928274',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'berhasil' => 0,
    'pesanhasil' => 0,
    'fulldomain' => 0,
    'pesan' => 0,
    'i' => 0,
    'tracking' => 0,
    'invoiceid' => 0,
    'tanggaltransaksi' => 0,
    'jumlahtransaksi' => 0,
    'status' => 0,
    'jmlproduk' => 0,
    'namalengkap' => 0,
    'ketstatuskirim' => 0,
    'detailproduk' => 0,
    'a' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ea6fc6789e91_61650506',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ea6fc6789e91_61650506')) {function content_61ea6fc6789e91_61650506($_smarty_tpl) {?>
            <h3>Order Tracking</h3>
            <hr>

            <div class="row text-center">
                <div class="col-md-12">
                    <center>
                        Welcome to our Order Tracking page!<br />
                        Please enter Your order number to track your order status.<br /> 
                        If you do not know Your order number, please check the order confirmation email <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 send it to your email address.<br /><br />
                        <?php if ($_smarty_tpl->tpl_vars['berhasil']->value=='1'){?>
                            <div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>
</div>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/ordertracking"  class="button">Kembali</strong></a>
                        <?php }elseif($_smarty_tpl->tpl_vars['berhasil']->value=='0'){?>
                            <div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>
</div>
                            <ul>
                                <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['pesan']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
                                <li><?php echo $_smarty_tpl->tpl_vars['i']->value['pesan'];?>
</li>
                                <?php } ?>
                            </ul><br clear="all" />
                            <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/ordertracking" class="button"> Kembali</a>
                        <?php }?>
                        
                        <script>
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
                        </script>
                        
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
            <?php if ($_smarty_tpl->tpl_vars['tracking']->value=='1'){?>
            <div class="panel-group panel-accordion" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" class="text-uppercase" data-parent="#accordion" href="" aria-expanded="true" aria-controls="collapseOne">
                                  Order #<?php echo $_smarty_tpl->tpl_vars['invoiceid']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['tanggaltransaksi']->value!='0000-00-00'){?>| Booked on : <?php echo $_smarty_tpl->tpl_vars['tanggaltransaksi']->value;?>
 <?php }?>
                                </a>
                        </h4>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['jumlahtransaksi']->value=='0'){?>
                    <div class="alert alert-warning">Transaction data with number invoice <strong>#<?php echo $_smarty_tpl->tpl_vars['invoiceid']->value;?>
</strong> not found. Please repeat it again.</div>
                    <?php }else{ ?>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <?php if ($_smarty_tpl->tpl_vars['status']->value=='4'){?>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <?php echo $_smarty_tpl->tpl_vars['jmlproduk']->value;?>
 Products <?php if ($_smarty_tpl->tpl_vars['tanggaltransaksi']->value!='0000-00-00'){?>| Posted on <?php echo $_smarty_tpl->tpl_vars['tanggaltransaksi']->value;?>
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
                                            <td><?php if ($_smarty_tpl->tpl_vars['tanggaltransaksi']->value!='0000-00-00'){?><?php echo $_smarty_tpl->tpl_vars['tanggaltransaksi']->value;?>
<?php }?></td>
                                            <td>
                                                <?php echo $_smarty_tpl->tpl_vars['ketstatuskirim']->value;?>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p><strong>The Package Contains :</strong> <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['transaksidetailid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['detailproduk']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['transaksidetailid']->value = $_smarty_tpl->tpl_vars['a']->key;
?><a href=""><?php echo $_smarty_tpl->tpl_vars['a']->value['namaprod'];?>
 - <?php echo $_smarty_tpl->tpl_vars['a']->value['namawarna'];?>
 (<?php echo $_smarty_tpl->tpl_vars['a']->value['namasize'];?>
), </a><?php } ?></p>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
            <?php }?><?php }} ?>