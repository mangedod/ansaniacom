<?php /* Smarty version Smarty-3.1.13, created on 2022-01-30 22:27:16
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/product.html" */ ?>
<?php /*%%SmartyHeaderCode:125026093761e9774f9a8156-72398478%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e453f0047d510c64faef107b8741417cdab85ef5' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/product.html',
      1 => 1643553066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '125026093761e9774f9a8156-72398478',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61e9774fa6a000_83247156',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'aksi' => 0,
    'fulldomain' => 0,
    'namasec' => 0,
    'link_sec' => 0,
    'namasub' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61e9774fa6a000_83247156')) {function content_61e9774fa6a000_83247156($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='read'){?>
     <div class="container kanal">
       <div class="row">
            <div class="col-md-12">
                 <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                  <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product">Produk</a></li>
                  <?php if ($_smarty_tpl->tpl_vars['namasec']->value!=''){?><li><a href="<?php echo $_smarty_tpl->tpl_vars['link_sec']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['namasec']->value;?>
</a></li><?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['namasub']->value!=''){?><li class="active"><?php echo $_smarty_tpl->tpl_vars['namasub']->value;?>
</li><?php }?>
                </nav>
            </div>
       </div>
      
    </div>
    <?php }else{ ?>
    <div class="container kanal">
       <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                  <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                  <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product">Produk</a></li>
                  <?php if ($_smarty_tpl->tpl_vars['namasec']->value!=''){?><li><a href="<?php echo $_smarty_tpl->tpl_vars['link_sec']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['namasec']->value;?>
</a></li><?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['namasub']->value!=''){?><li class="active"><?php echo $_smarty_tpl->tpl_vars['namasub']->value;?>
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

        <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='read'){?>
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".read.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <?php }else{ ?>
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".list.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <?php }?>
 
    <!-- /.content -->
</div>
</div>
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>