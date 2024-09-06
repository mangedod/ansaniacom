<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:13:21
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/member.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c711186393_40301247',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '70f64e34264688049b56f490bbbe6764be86f868' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/member.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c711186393_40301247 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
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
           		<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.menu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                
           </div>
           <div class="col-md-9">
                <?php if ($_smarty_tpl->tpl_vars['berhasilcek']->value == '1' && $_smarty_tpl->tpl_vars['aksi']->value != 'setting') {?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                    <center>
                        <?php echo $_smarty_tpl->tpl_vars['pesanhasilcek']->value;?>
<br clear="all" />
                        <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting" class="btn btn-success btn-sm tooltips"> Complete Profile</a>
                    </center>
                    </div>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'aktifasi' && $_smarty_tpl->tpl_vars['login']->value == '1') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.aktivasi.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php } elseif ($_smarty_tpl->tpl_vars['aksi']->value == 'setting' && $_smarty_tpl->tpl_vars['login']->value == '1') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.setting.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php } elseif ($_smarty_tpl->tpl_vars['aksi']->value == 'history' && $_smarty_tpl->tpl_vars['login']->value == '1') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.history.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php } elseif ($_smarty_tpl->tpl_vars['aksi']->value == 'wishlist' && $_smarty_tpl->tpl_vars['login']->value == '1') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.wishlist.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php } elseif ($_smarty_tpl->tpl_vars['aksi']->value == 'ordertracking' && $_smarty_tpl->tpl_vars['login']->value == '1') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.ordertracking.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php } elseif ($_smarty_tpl->tpl_vars['aksi']->value == 'ticketing' && $_smarty_tpl->tpl_vars['login']->value == '1') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.ticketing.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php } elseif ($_smarty_tpl->tpl_vars['aksi']->value == 'addticketing' && $_smarty_tpl->tpl_vars['login']->value == '1') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.addticketing.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php } elseif ($_smarty_tpl->tpl_vars['aksi']->value == 'detailticketing' && $_smarty_tpl->tpl_vars['login']->value == '1') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.detailticketing.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php } elseif ($_smarty_tpl->tpl_vars['aksi']->value == 'review' && $_smarty_tpl->tpl_vars['login']->value == '1') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.review.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php } elseif ($_smarty_tpl->tpl_vars['aksi']->value == 'addreview' && $_smarty_tpl->tpl_vars['login']->value == '1') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.addreview.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php } elseif ($_smarty_tpl->tpl_vars['login']->value == '1' && $_smarty_tpl->tpl_vars['kanal']->value == 'member' && $_smarty_tpl->tpl_vars['berhasilcek']->value != '1') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.dashboard.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php }?>
           </div>
        </div>
    </div>

    
   
</div>
<!-- /.wrapper -->

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
