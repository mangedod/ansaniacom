<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 20:46:49
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/sale.html" */ ?>
<?php /*%%SmartyHeaderCode:128415687361929c4a482f01-65353146%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cbddec41c6841cafb48344e0c5d6fde88adf9cd4' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/sale.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '128415687361929c4a482f01-65353146',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61929c4a573f94_66477107',
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
<?php if ($_valid && !is_callable('content_61929c4a573f94_66477107')) {function content_61929c4a573f94_66477107($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


    <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='read'){?>
        <div class="section-breadcrumb">
            <div class="container">
                <ol class="breadcrumb">
                  <li>&nbsp;&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                  <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product">Product</a></li>
                  <?php if ($_smarty_tpl->tpl_vars['namasec']->value!=''){?><li><a href="<?php echo $_smarty_tpl->tpl_vars['link_sec']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['namasec']->value;?>
</a></li><?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['namasub']->value!=''){?><li class="active"><?php echo $_smarty_tpl->tpl_vars['namasub']->value;?>
</li><?php }?>
                </ol>
            </div>  
        </div>
    <?php }else{ ?>
        <!-- HOME -->
        <div class="overlay home small-medium-size">
            <div class="bg bg-shop" data-stellar-background-ratio="0.5"></div>
            <div class="container vmiddle">
                <div class="row text-center text-title-list">
                    <h1>Produk Terlaris</h1>
                    <h4>Banyak produk-produk pilihan kami yang dapat anda miliki <br />seperti produk-produk dibawah ini</h4>
                </div>
            </div>
        </div>
        <!-- /.home -->
    <?php }?>

    <!-- CONTENT -->
    <div class="content">
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".list.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </div>
    <!-- /.content -->

</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>