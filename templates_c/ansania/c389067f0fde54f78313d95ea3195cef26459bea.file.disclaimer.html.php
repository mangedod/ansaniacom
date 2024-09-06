<?php /* Smarty version Smarty-3.1.13, created on 2022-02-24 02:34:51
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/disclaimer.html" */ ?>
<?php /*%%SmartyHeaderCode:183384610161929679f18531-31048229%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c389067f0fde54f78313d95ea3195cef26459bea' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/disclaimer.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '183384610161929679f18531-31048229',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_6192967a041de4_50521802',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'fulldomain' => 0,
    'discnama' => 0,
    'disclengkap' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6192967a041de4_50521802')) {function content_6192967a041de4_50521802($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <!-- /.header -->


  <div class="container kanal">
       <div class="row">
            <div class="col-md-12"> 
                <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                   <li class="active" ><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/disclaimer">Disclaimer</a></li>
                </ol>             
                
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>Disclaimer</h1>
       </div>
    </div>

    <div class="container">
        <div class="row">
           <div class="col-md-12">
           <h4><?php echo $_smarty_tpl->tpl_vars['discnama']->value;?>
</h4>
               <div><?php echo $_smarty_tpl->tpl_vars['disclengkap']->value;?>
</div>
           </div>
        </div>
    </div>

    
   
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>