<?php
/* Smarty version 4.3.0, created on 2024-03-27 05:59:27
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/product.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603b5bf43e6b3_51493990',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '961de0e1bd9c9bddc7a8b6fafdc327db82b81153' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/product.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603b5bf43e6b3_51493990 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
    <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'read') {?>
     <div class="container kanal">
       <div class="row">
            <div class="col-md-12">
                 <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                  <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product">Produk</a></li>
                  <?php if ($_smarty_tpl->tpl_vars['namasec']->value != '') {?><li><a href="<?php echo $_smarty_tpl->tpl_vars['link_sec']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['namasec']->value;?>
</a></li><?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['namasub']->value != '') {?><li class="active"><?php echo $_smarty_tpl->tpl_vars['namasub']->value;?>
</li><?php }?>
                </nav>
            </div>
       </div>
      
    </div>
    <?php } else { ?>
    <div class="container kanal">
       <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                  <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                  <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product">Produk</a></li>
                  <?php if ($_smarty_tpl->tpl_vars['namasec']->value != '') {?><li><a href="<?php echo $_smarty_tpl->tpl_vars['link_sec']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['namasec']->value;?>
</a></li><?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['namasub']->value != '') {?><li class="active"><?php echo $_smarty_tpl->tpl_vars['namasub']->value;?>
</li><?php }?>
                </nav>
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>PRODUCT</h1>
       </div>
    </div>
    <?php }?>


    <div class="container">
        <div class="row">
    <!-- CONTENT -->

        <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'read') {?>
            <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".read.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
        <?php } else { ?>
            <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".list.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
        <?php }?>
 
    <!-- /.content -->
</div>
</div>
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
