<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 13:38:52
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/testimoni.html" */ ?>
<?php /*%%SmartyHeaderCode:26273314161928210f23da3-77229690%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c23206593c3a10ecf5c69a39936b69dd1a662cc3' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/testimoni.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26273314161928210f23da3-77229690',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_6192821102f779_66460140',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'fulldomain' => 0,
    'aksi' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6192821102f779_66460140')) {function content_6192821102f779_66460140($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
               <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='read'){?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".read.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }else{ ?>
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".list.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                <?php }?>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

</div>
<!-- /.wrapper -->

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>