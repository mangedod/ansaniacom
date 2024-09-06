<?php /* Smarty version Smarty-3.1.13, created on 2022-01-21 15:41:02
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.history.html" */ ?>
<?php /*%%SmartyHeaderCode:137932555861ea638e30b3e2-70582847%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f2e7c9498c467eacab0709a6af0ac56b84cfd4d' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.history.html',
      1 => 1642674336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '137932555861ea638e30b3e2-70582847',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'listtransaksi' => 0,
    'i' => 0,
    'stringpage' => 0,
    'a' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ea638e3703e9_48832843',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ea638e3703e9_48832843')) {function content_61ea638e3703e9_48832843($_smarty_tpl) {?>
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
 $_from = $_smarty_tpl->tpl_vars['listtransaksi']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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

            <div class="pagination-holder">
                <div class="row">
                    <div class="col-md-6 text-right" style="width: 100%;">
                        <ul class="pagination">
                            <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['pageid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['stringpage']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['pageid']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
                                <li class="<?php echo $_smarty_tpl->tpl_vars['a']->value['class'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"> <?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
 </a></li>
                            <?php } ?>
                        </ul><!-- /.pagination -->
                    </div>
                </div><!-- /.row -->
            </div><!-- /.pagination-holder -->
<?php }} ?>