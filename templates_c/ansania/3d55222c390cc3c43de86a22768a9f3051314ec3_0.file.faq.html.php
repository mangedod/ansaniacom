<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:04:49
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/faq.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c5114d45d4_10287327',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3d55222c390cc3c43de86a22768a9f3051314ec3' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/faq.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c5114d45d4_10287327 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

    <div class="container kanal">
       <div class="row">
            <div class="col-md-12"> 
                <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                   <li class="active" ><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/faq">Tanya dan Jawab</a></li>
                </ol>             
                
            </div>
       </div>
   
    </div>
	
    <div class="container mt-20">
        <div class="row">
            <div class="col-md-4">
            	<ul class="faqlist">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['faqsec']->value, 'f', false, 'secid');
$_smarty_tpl->tpl_vars['f']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['secid']->value => $_smarty_tpl->tpl_vars['f']->value) {
$_smarty_tpl->tpl_vars['f']->do_else = false;
?>
                   <li><span><?php echo $_smarty_tpl->tpl_vars['f']->value['namasec'];?>
</span></li>
                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['f']->value['list'], 'c', false, 'idfaq');
$_smarty_tpl->tpl_vars['c']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['idfaq']->value => $_smarty_tpl->tpl_vars['c']->value) {
$_smarty_tpl->tpl_vars['c']->do_else = false;
?>
                    	<li class="active"><a href="<?php echo $_smarty_tpl->tpl_vars['c']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['c']->value['namafaq'];?>
</a></li> 
                     <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </ul>
                <br clear="all" /><br clear="all" /> 
            </div>
            <div class="col-md-8">
            	<div class="col-md-1"></div>
                <div class="col-md-11">
                <div class="text-faq"><h2><?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
</h2><br />
                    <?php echo $_smarty_tpl->tpl_vars['detaillengkap']->value;?>
 
                     <br clear="all" /> <br clear="all" />
                     </div>
                </div>
            </div>
         </div>
    </div>
   

    
   
</div>
<!-- /.wrapper -->

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
