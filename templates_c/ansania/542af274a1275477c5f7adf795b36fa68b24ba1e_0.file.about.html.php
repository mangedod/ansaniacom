<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:04:48
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/about.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c5106c8853_23106065',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '542af274a1275477c5f7adf795b36fa68b24ba1e' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/about.html',
      1 => 1645591426,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c5106c8853_23106065 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
   <div class="container kanal">
       <div class="row">
            <div class="col-md-12"> 
                <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                   <li class="active" ><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/about">Tentang Kami</a></li>
                </ol>             
                
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>TENTANG ANSANIA</h1>
       </div>
    </div>


        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['aboutmenu']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
    <div class="container p-0">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['gambarabout'];?>
" class="img-responsive" alt="">
            </div>
            <div class="col-md-6">
            <div class="text-about-section">
                <h4><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</h4>
                <?php echo $_smarty_tpl->tpl_vars['a']->value['lengkapabout'];?>

                <br clear="all" /> <br clear="all" />
            </div>
            </div>
        </div>
    </div>

   
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</div>
<!-- /.wrapper -->

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
