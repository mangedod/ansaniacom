<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:04:47
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/catalog.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c50f4d29c7_44592969',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '78611beb3606bbbc28bc14ee4901229698a28092' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/catalog.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c50f4d29c7_44592969 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
    <!-- /.header -->

  <div class="container kanal">
       <div class="row">
            <div class="col-md-12"> 
                <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                   <li class="active" ><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/catalog">Download Katalog</a></li>
                </ol>             
                
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>Download Katalog</h1>
       </div>
    </div>


    <div class="container">
        <div class="row">
           <div class="col-md-3 mt-20 text-center">
                <img src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/images/shinar.jpg" class="img-responsive">
                <h4>Shinar</h4>
                <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/download/shinar.pdf" class="btn btn-default">Download Catalog   <i class="fal fa-arrow-right"></i> </a>
           </div>
           <div class="col-md-3 mt-20  text-center">
                <img src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/images/saudiarawis.jpg" class="img-responsive">
                <h4>Saudia Rawis</h4>
                 <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/download/saudiarawis.pdf" class="btn btn-default">Download Catalog   <i class="fal fa-arrow-right"></i> </a>
           </div>
           <div class="col-md-3  mt-20 text-center">
                <img src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/images/bella.jpg" class="img-responsive">
                <h4>Bella</h4>
                 <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/download/bella.pdf" class="btn btn-default">Download Catalog   <i class="fal fa-arrow-right"></i> </a>
           </div>
            <div class="col-md-3  mt-20 text-center">
                <img src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/images/andine.jpg" class="img-responsive">
                <h4>Andine Premium</h4>
                 <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/download/andine-premium.pdf" class="btn btn-default">Download Catalog   <i class="fal fa-arrow-right"></i> </a>
           </div>
        </div>
    </div>

    
   
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
