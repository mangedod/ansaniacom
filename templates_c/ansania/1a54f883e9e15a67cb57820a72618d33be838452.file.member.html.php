<?php /* Smarty version Smarty-3.1.13, created on 2022-02-25 10:48:18
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/member.html" */ ?>
<?php /*%%SmartyHeaderCode:68101853461928c838ca467-54403435%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a54f883e9e15a67cb57820a72618d33be838452' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/member.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '68101853461928c838ca467-54403435',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61928c839c2061_72213831',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'fulldomain' => 0,
    'berhasilcek' => 0,
    'aksi' => 0,
    'pesanhasilcek' => 0,
    'login' => 0,
    'kanal' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61928c839c2061_72213831')) {function content_61928c839c2061_72213831($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <div class="container kanal">
       <div class="row">
            <div class="col-md-12"> 
                <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                   <li class="active" ><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member">Member</a></li>
                </ol>             
                
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>Member Area</h1>
       </div>
    </div>

    <div class="container">
        <div class="row">
           <div class="col-md-3">
           		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.menu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                
           </div>
           <div class="col-md-9">
                <?php if ($_smarty_tpl->tpl_vars['berhasilcek']->value=='1'&&$_smarty_tpl->tpl_vars['aksi']->value!='setting'){?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                    <center>
                        <?php echo $_smarty_tpl->tpl_vars['pesanhasilcek']->value;?>
<br clear="all" />
                        <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting" class="btn btn-success btn-sm tooltips"> Complete Profile</a>
                    </center>
                    </div>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='aktifasi'&&$_smarty_tpl->tpl_vars['login']->value=='1'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.aktivasi.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }elseif($_smarty_tpl->tpl_vars['aksi']->value=='setting'&&$_smarty_tpl->tpl_vars['login']->value=='1'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.setting.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }elseif($_smarty_tpl->tpl_vars['aksi']->value=='history'&&$_smarty_tpl->tpl_vars['login']->value=='1'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.history.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }elseif($_smarty_tpl->tpl_vars['aksi']->value=='wishlist'&&$_smarty_tpl->tpl_vars['login']->value=='1'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.wishlist.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }elseif($_smarty_tpl->tpl_vars['aksi']->value=='ordertracking'&&$_smarty_tpl->tpl_vars['login']->value=='1'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.ordertracking.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }elseif($_smarty_tpl->tpl_vars['aksi']->value=='ticketing'&&$_smarty_tpl->tpl_vars['login']->value=='1'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.ticketing.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }elseif($_smarty_tpl->tpl_vars['aksi']->value=='addticketing'&&$_smarty_tpl->tpl_vars['login']->value=='1'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.addticketing.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }elseif($_smarty_tpl->tpl_vars['aksi']->value=='detailticketing'&&$_smarty_tpl->tpl_vars['login']->value=='1'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.detailticketing.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }elseif($_smarty_tpl->tpl_vars['aksi']->value=='review'&&$_smarty_tpl->tpl_vars['login']->value=='1'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.review.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }elseif($_smarty_tpl->tpl_vars['aksi']->value=='addreview'&&$_smarty_tpl->tpl_vars['login']->value=='1'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.addreview.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }elseif($_smarty_tpl->tpl_vars['login']->value=='1'&&$_smarty_tpl->tpl_vars['kanal']->value=='member'&&$_smarty_tpl->tpl_vars['berhasilcek']->value!='1'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.dashboard.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }?>
           </div>
        </div>
    </div>

    
   
</div>
<!-- /.wrapper -->

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>