<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:13:21
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.menu.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c7111b1ba9_67018677',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd66b0beaf0f2da712ad3bc1600f448f8f5322a5e' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.menu.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c7111b1ba9_67018677 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="list-group dashboard-menu">
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value == '' || $_smarty_tpl->tpl_vars['aksi']->value == 'dashboard') {?>active<?php }?>">
      Dashboard
    </a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/history" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'history') {?>active<?php }?>">Order History</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/ordertracking" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'ordertracking') {?>active<?php }?>">Order Tracking</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/wishlist" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'wishlist') {?>active<?php }?>">Wishlist</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/review" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'review' || $_smarty_tpl->tpl_vars['aksi']->value == 'addreview') {?>active<?php }?>">Review Product</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/ticketing" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'ticketing' || $_smarty_tpl->tpl_vars['aksi']->value == 'addticketing' || $_smarty_tpl->tpl_vars['aksi']->value == 'detailticketing') {?>active<?php }?>">Ticketing Support</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'setting') {?>active<?php }?>">Profile Setting</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/logout" class="list-group-item">Logout</a>
</div><?php }
}
