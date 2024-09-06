<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:04:48
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/testimoni.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c5109dd1c6_09635546',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '98c3265a4d72bc5245be0e4cc1d503c0419e1254' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/testimoni.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c5109dd1c6_09635546 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
<div class="container kanal">
       <div class="row">
            <div class="col-md-12"> 
                <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                   <li class="active" ><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/testimoni">Testimoni</a></li>
                </ol>             
                
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>Testimoni</h1>
       </div>
    </div>


    <!-- CONTAINER -->
        <div class="container mt-20">

            <div class="row">
               <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'read') {?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".read.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php } else { ?>
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".list.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php }?>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

</div>
<!-- /.wrapper -->

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
