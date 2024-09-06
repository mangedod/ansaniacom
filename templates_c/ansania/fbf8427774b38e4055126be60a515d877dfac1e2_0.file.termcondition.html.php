<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:04:49
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/termcondition.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c511e842c7_59763176',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fbf8427774b38e4055126be60a515d877dfac1e2' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/termcondition.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c511e842c7_59763176 (Smarty_Internal_Template $_smarty_tpl) {
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
<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
