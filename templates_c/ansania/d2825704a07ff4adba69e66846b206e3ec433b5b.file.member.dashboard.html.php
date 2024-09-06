<?php /* Smarty version Smarty-3.1.13, created on 2022-01-21 16:33:07
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.dashboard.html" */ ?>
<?php /*%%SmartyHeaderCode:143990052561ea6fc3643af3-92880732%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd2825704a07ff4adba69e66846b206e3ec433b5b' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.dashboard.html',
      1 => 1642674336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143990052561ea6fc3643af3-92880732',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'jmldttrans' => 0,
    'dttransdashboard' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ea6fc36ce203_66005516',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ea6fc36ce203_66005516')) {function content_61ea6fc36ce203_66005516($_smarty_tpl) {?>        <?php if ($_smarty_tpl->tpl_vars['jmldttrans']->value!=''){?>
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
                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['transaksiid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dttransdashboard']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['transaksiid']->value = $_smarty_tpl->tpl_vars['i']->key;
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
 <?php if ($_smarty_tpl->tpl_vars['i']->value['status']=='1'&&$_smarty_tpl->tpl_vars['i']->value['pembayaran']=='Transfer'){?><br /><a href="<?php echo $_smarty_tpl->tpl_vars['i']->value['link'];?>
">Do Payment Confirmation</a><?php }?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php }else{ ?>
            <div class="alert alert-warning"><center>Your transaction data is still empty.</center></div>
        <?php }?><?php }} ?>