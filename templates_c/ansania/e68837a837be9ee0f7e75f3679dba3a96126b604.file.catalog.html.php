<?php /* Smarty version Smarty-3.1.13, created on 2022-01-30 21:45:18
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/catalog.html" */ ?>
<?php /*%%SmartyHeaderCode:57387307161e93da2306168-88401357%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e68837a837be9ee0f7e75f3679dba3a96126b604' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/catalog.html',
      1 => 1643550548,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '57387307161e93da2306168-88401357',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61e93da2368e92_43754199',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'fulldomain' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61e93da2368e92_43754199')) {function content_61e93da2368e92_43754199($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>