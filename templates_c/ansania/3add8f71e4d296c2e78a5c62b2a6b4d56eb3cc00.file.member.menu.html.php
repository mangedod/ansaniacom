<?php /* Smarty version Smarty-3.1.13, created on 2022-01-21 15:41:02
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.menu.html" */ ?>
<?php /*%%SmartyHeaderCode:84451926261ea638e28ace8-00036712%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3add8f71e4d296c2e78a5c62b2a6b4d56eb3cc00' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.menu.html',
      1 => 1642674336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '84451926261ea638e28ace8-00036712',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fulldomain' => 0,
    'aksi' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ea638e302c31_12096607',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ea638e302c31_12096607')) {function content_61ea638e302c31_12096607($_smarty_tpl) {?><div class="list-group dashboard-menu">
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value==''||$_smarty_tpl->tpl_vars['aksi']->value=='dashboard'){?>active<?php }?>">
      Dashboard
    </a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/history" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='history'){?>active<?php }?>">Order History</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/ordertracking" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='ordertracking'){?>active<?php }?>">Order Tracking</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/wishlist" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='wishlist'){?>active<?php }?>">Wishlist</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/review" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='review'||$_smarty_tpl->tpl_vars['aksi']->value=='addreview'){?>active<?php }?>">Review Product</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/ticketing" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='ticketing'||$_smarty_tpl->tpl_vars['aksi']->value=='addticketing'||$_smarty_tpl->tpl_vars['aksi']->value=='detailticketing'){?>active<?php }?>">Ticketing Support</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting" class="list-group-item <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='setting'){?>active<?php }?>">Profile Setting</a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/logout" class="list-group-item">Logout</a>
</div><?php }} ?>