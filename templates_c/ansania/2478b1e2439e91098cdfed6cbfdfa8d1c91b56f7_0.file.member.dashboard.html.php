<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:13:21
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.dashboard.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c7111d4a99_11006254',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2478b1e2439e91098cdfed6cbfdfa8d1c91b56f7' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.dashboard.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c7111d4a99_11006254 (Smarty_Internal_Template $_smarty_tpl) {
?>        <?php if ($_smarty_tpl->tpl_vars['jmldttrans']->value != '') {?>
           <h3>Order History</h3>
           <hr>

             <div class="table-responsive">
                <table class="table table-striped table-normal">
                    <thead>
                        <tr>
                            <th class="normal" width="10%">No</th>
                            <th width="15%">Transaction Date</th>
                            <th class="text-center" width="20%">Invoice</th>
                            <th class="text-center" width="20%">Method Of Payment</th>
                            <th class="text-center" width="25%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['dttransdashboard']->value, 'i', false, 'transaksiid');
$_smarty_tpl->tpl_vars['i']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['transaksiid']->value => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->do_else = false;
?>
                        <tr>
                            <td class="normal"><?php echo $_smarty_tpl->tpl_vars['i']->value['no'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value['tanggaltransaksi'];?>
</td>
                            <td class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['i']->value['urldetail'];?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value['invoiceid'];?>
</a></td>
                            <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['i']->value['pembayaran'];?>
</td>
                            <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['i']->value['stat'];?>
 <?php if ($_smarty_tpl->tpl_vars['i']->value['status'] == '1' && $_smarty_tpl->tpl_vars['i']->value['pembayaran'] == 'Transfer') {?><br /><a href="<?php echo $_smarty_tpl->tpl_vars['i']->value['link'];?>
">Do Payment Confirmation</a><?php }?></td>
                        </tr>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning"><center>Your transaction data is still empty.</center></div>
        <?php }
}
}
