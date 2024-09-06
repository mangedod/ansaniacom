<?php /* Smarty version Smarty-3.1.13, created on 2022-01-30 20:47:55
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/faq.html" */ ?>
<?php /*%%SmartyHeaderCode:50147100961eda93f819289-97751096%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8cbb2375eeafbf462f965881cccc8834ac11b6f' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/faq.html',
      1 => 1643547105,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '50147100961eda93f819289-97751096',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61eda93f87a792_94721949',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'fulldomain' => 0,
    'faqsec' => 0,
    'f' => 0,
    'c' => 0,
    'detailnama' => 0,
    'detaillengkap' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61eda93f87a792_94721949')) {function content_61eda93f87a792_94721949($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


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
                <?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_smarty_tpl->tpl_vars['secid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['faqsec']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
 $_smarty_tpl->tpl_vars['secid']->value = $_smarty_tpl->tpl_vars['f']->key;
?>
                   <li><span><?php echo $_smarty_tpl->tpl_vars['f']->value['namasec'];?>
</span></li>
                     <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_smarty_tpl->tpl_vars['idfaq'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['f']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['idfaq']->value = $_smarty_tpl->tpl_vars['c']->key;
?>
                    	<li class="active"><a href="<?php echo $_smarty_tpl->tpl_vars['c']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['c']->value['namafaq'];?>
</a></li> 
                     <?php } ?>
                <?php } ?>
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

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>