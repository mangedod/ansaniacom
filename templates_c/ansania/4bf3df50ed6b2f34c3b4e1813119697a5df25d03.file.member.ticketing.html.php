<?php /* Smarty version Smarty-3.1.13, created on 2022-03-12 03:04:40
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.ticketing.html" */ ?>
<?php /*%%SmartyHeaderCode:164101126661bc7538c60560-71672686%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4bf3df50ed6b2f34c3b4e1813119697a5df25d03' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.ticketing.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '164101126661bc7538c60560-71672686',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61bc7538cdbc79_41423782',
  'variables' => 
  array (
    'totalticketing' => 0,
    'dataticketing' => 0,
    'k' => 0,
    'fulldomain' => 0,
    'stringpage' => 0,
    'a' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61bc7538cdbc79_41423782')) {function content_61bc7538cdbc79_41423782($_smarty_tpl) {?><h3>Ticketing</h3>
<hr>
<div class="table-responsive">
 <table class="table table-bordered table-center">
     <thead>
         <tr>
            <th>No</th>
            <th>Subject</th>
            <th>Category Question</th>
            <th width="120" class="text-center">Status</th>
            <th>Date</th>
        </tr>
     </thead>
     <tbody>
        <?php if ($_smarty_tpl->tpl_vars['totalticketing']->value!='0'){?>
            <?php  $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['k']->_loop = false;
 $_smarty_tpl->tpl_vars['ticketingid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataticketing']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['k']->key => $_smarty_tpl->tpl_vars['k']->value){
$_smarty_tpl->tpl_vars['k']->_loop = true;
 $_smarty_tpl->tpl_vars['ticketingid']->value = $_smarty_tpl->tpl_vars['k']->key;
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['k']->value['no'];?>
</td>
                <td><a href="<?php echo $_smarty_tpl->tpl_vars['k']->value['link'];?>
"><strong><?php echo $_smarty_tpl->tpl_vars['k']->value['judul'];?>
</strong></a></td>
                <td><?php echo $_smarty_tpl->tpl_vars['k']->value['kategori'];?>
</td>
                <td><?php if ($_smarty_tpl->tpl_vars['k']->value['is_closed']=='0'){?><i class="fa fa-unlock"></i><?php }else{ ?><i class="fa fa-lock"></i><?php }?> <?php echo $_smarty_tpl->tpl_vars['k']->value['stats'];?>
 </td>
                <td class="text-right mail-date"><?php echo $_smarty_tpl->tpl_vars['k']->value['tanggal'];?>
</td>
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td colspan="5">
                    <div class="alert alert-warning mb-0">
                        You have yet to submit questions to ticketing, to send us a question please click the button <strong>Create a Ticket</strong>.
                    </div>
                </td>
            </tr>
        <?php }?>
     </tbody>
 </table>
</div>
<div class="pagination-holder">
    <div class="row">
        <div class="col-md-6 text-left">
            <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/addticketing" class="btn btn-primary btn-xs">Create a Ticket</a>
        </div>
<?php if ($_smarty_tpl->tpl_vars['totalticketing']->value!='0'){?>
        <div class="col-md-6 text-right">
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
<?php }?>
    </div><!-- /.row -->
</div><!-- /.pagination-holder -->
<?php }} ?>