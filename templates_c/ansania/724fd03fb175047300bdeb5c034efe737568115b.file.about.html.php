<?php /* Smarty version Smarty-3.1.13, created on 2022-01-30 20:50:40
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/about.html" */ ?>
<?php /*%%SmartyHeaderCode:153880636261ed95a956a302-50496048%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '724fd03fb175047300bdeb5c034efe737568115b' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/about.html',
      1 => 1643547167,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '153880636261ed95a956a302-50496048',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ed95a960b987_25544446',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'fulldomain' => 0,
    'aboutmenu' => 0,
    'a' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ed95a960b987_25544446')) {function content_61ed95a960b987_25544446($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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

     <!-- HOME -->
    <div class="overlay home about-cover small-size">
        <div class="bg bg-shop"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <?php if ($_smarty_tpl->tpl_vars['a']->value['ringkasabout']!=''){?><h4 class="text-about-caption">"<?php echo $_smarty_tpl->tpl_vars['a']->value['ringkasabout'];?>
"</h4><?php }?>

                <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/contact" class="btn btn-bordered">Contact Us</a>
            </div>
        </div>
    </div>
    <!-- /.home -->
        <?php } ?>
</div>
<!-- /.wrapper -->

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>