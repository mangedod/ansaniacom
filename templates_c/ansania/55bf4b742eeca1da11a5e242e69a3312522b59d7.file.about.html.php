<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 12:39:16
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/about.html" */ ?>
<?php /*%%SmartyHeaderCode:168775143061929673b23fd6-68081457%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55bf4b742eeca1da11a5e242e69a3312522b59d7' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/about.html',
      1 => 1645591426,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '168775143061929673b23fd6-68081457',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61929673cc0456_35231834',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'fulldomain' => 0,
    'aboutmenu' => 0,
    'a' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61929673cc0456_35231834')) {function content_61929673cc0456_35231834($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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


        <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['aboutmenu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
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

   
        <?php } ?>
</div>
<!-- /.wrapper -->

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>