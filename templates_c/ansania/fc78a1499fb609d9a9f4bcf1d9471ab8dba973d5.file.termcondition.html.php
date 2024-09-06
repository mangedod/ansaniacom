<?php /* Smarty version Smarty-3.1.13, created on 2022-01-30 21:19:34
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/termcondition.html" */ ?>
<?php /*%%SmartyHeaderCode:78290899161ecc7fd934a68-92930364%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc78a1499fb609d9a9f4bcf1d9471ab8dba973d5' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/termcondition.html',
      1 => 1643549004,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '78290899161ecc7fd934a68-92930364',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ecc7fd9801b1_56537237',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'fulldomain' => 0,
    'termnama' => 0,
    'termlengkap' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ecc7fd9801b1_56537237')) {function content_61ecc7fd9801b1_56537237($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <!-- /.header -->

  <div class="container kanal">
       <div class="row">
            <div class="col-md-12"> 
                <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                   <li class="active" ><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/term">Term and Condition</a></li>
                </ol>             
                
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>Term and Condition</h1>
       </div>
    </div>

    <div class="container">
        <div class="row">
           <div class="col-md-12">
           <h4><?php echo $_smarty_tpl->tpl_vars['termnama']->value;?>
</h4>
               <div><?php echo $_smarty_tpl->tpl_vars['termlengkap']->value;?>
</div>
           </div>
        </div>
    </div>

    
   
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>