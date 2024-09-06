<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:13:29
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.ticketing.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c719ca0416_56506686',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '31698d2228fef78c69927eaf9bd61b4975bc74f8' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.ticketing.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c719ca0416_56506686 (Smarty_Internal_Template $_smarty_tpl) {
?><h3>Ticketing</h3>
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
        <?php if ($_smarty_tpl->tpl_vars['totalticketing']->value != '0') {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['dataticketing']->value, 'k', false, 'ticketingid');
$_smarty_tpl->tpl_vars['k']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['ticketingid']->value => $_smarty_tpl->tpl_vars['k']->value) {
$_smarty_tpl->tpl_vars['k']->do_else = false;
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['k']->value['no'];?>
</td>
                <td><a href="<?php echo $_smarty_tpl->tpl_vars['k']->value['link'];?>
"><strong><?php echo $_smarty_tpl->tpl_vars['k']->value['judul'];?>
</strong></a></td>
                <td><?php echo $_smarty_tpl->tpl_vars['k']->value['kategori'];?>
</td>
                <td><?php if ($_smarty_tpl->tpl_vars['k']->value['is_closed'] == '0') {?><i class="fa fa-unlock"></i><?php } else { ?><i class="fa fa-lock"></i><?php }?> <?php echo $_smarty_tpl->tpl_vars['k']->value['stats'];?>
 </td>
                <td class="text-right mail-date"><?php echo $_smarty_tpl->tpl_vars['k']->value['tanggal'];?>
</td>
            </tr>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <?php } else { ?>
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
<?php if ($_smarty_tpl->tpl_vars['totalticketing']->value != '0') {?>
        <div class="col-md-6 text-right">
            <ul class="pagination">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['stringpage']->value, 'a', false, 'pageid');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pageid']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
                    <li class="<?php echo $_smarty_tpl->tpl_vars['a']->value['class'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"> <?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
 </a></li>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </ul><!-- /.pagination -->
        </div>
<?php }?>
    </div><!-- /.row -->
</div><!-- /.pagination-holder -->
<?php }
}
