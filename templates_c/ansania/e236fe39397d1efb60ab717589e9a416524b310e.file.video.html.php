<?php /* Smarty version Smarty-3.1.13, created on 2022-01-30 20:49:54
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/video.html" */ ?>
<?php /*%%SmartyHeaderCode:15522403561e9f40bafadb7-61386662%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e236fe39397d1efb60ab717589e9a416524b310e' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/video.html',
      1 => 1643547197,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15522403561e9f40bafadb7-61386662',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61e9f40bb57984_04389491',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'fulldomain' => 0,
    'aksi' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61e9f40bb57984_04389491')) {function content_61e9f40bb57984_04389491($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <!-- HOME -->
    <div class="container kanal">
       <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                  <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Video</li>
                  </ul>
                </nav>
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>VIDEO</h1>
       </div>
    </div>
  
    
    <div class="insight">
    <div class="container">
            
                <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='read'){?>
                    <div class="row">
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".read.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                    </div>
                <?php }else{ ?>
                    <div class="row">
                    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/".((string)$_smarty_tpl->tpl_vars['kanal']->value)."/".((string)$_smarty_tpl->tpl_vars['kanal']->value).".list.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                    </div>
                <?php }?>
                
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>