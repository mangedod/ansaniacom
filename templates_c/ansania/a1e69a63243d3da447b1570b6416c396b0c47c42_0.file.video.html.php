<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:04:47
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/video.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c50f230812_02858460',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a1e69a63243d3da447b1570b6416c396b0c47c42' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/video.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c50f230812_02858460 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
    <!-- HOME -->
    <div class="container kanal">
       <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                  <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Video</li>
                  </ul>
                </nav>
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>VIDEO</h1>
       </div>
    </div>
  
    
    <div class="insight">
    <div class="container">
            
                <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'read') {?>
                    <div class="row">
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".read.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                    </div>
                <?php } else { ?>
                    <div class="row">
                    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".list.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                    </div>
                <?php }?>
                
    </div>
</div>
<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
