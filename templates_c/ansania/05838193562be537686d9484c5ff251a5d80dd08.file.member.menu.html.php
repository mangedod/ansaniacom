<?php /* Smarty version Smarty-3.1.13, created on 2022-02-25 10:48:18
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.menu.html" */ ?>
<?php /*%%SmartyHeaderCode:17891489561928c839cf574-40889873%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05838193562be537686d9484c5ff251a5d80dd08' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.menu.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17891489561928c839cf574-40889873',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61928c83a16355_00755737',
  'variables' => 
  array (
    'fulldomain' => 0,
    'aksi' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61928c83a16355_00755737')) {function content_61928c83a16355_00755737($_smarty_tpl) {?><div class="list-group dashboard-menu">
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