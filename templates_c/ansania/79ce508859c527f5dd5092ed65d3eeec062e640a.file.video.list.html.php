<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 11:25:55
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/video/video.list.html" */ ?>
<?php /*%%SmartyHeaderCode:604877988619282129628b4-63694214%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79ce508859c527f5dd5092ed65d3eeec062e640a' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/video/video.list.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '604877988619282129628b4-63694214',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_619282129b1938_82107733',
  'variables' => 
  array (
    'datadetail' => 0,
    'ch' => 0,
    'stringpage' => 0,
    'a' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_619282129b1938_82107733')) {function content_619282129b1938_82107733($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['ch'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ch']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datadetail']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ch']->key => $_smarty_tpl->tpl_vars['ch']->value){
$_smarty_tpl->tpl_vars['ch']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['ch']->key;
?>
 <div class="col-md-6 mt-20 text-center">
        <?php if ($_smarty_tpl->tpl_vars['ch']->value['gambar']!=''){?>
        <div class="thumbVideo mb-10">
            <a href="<?php echo $_smarty_tpl->tpl_vars['ch']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['ch']->value['gambar'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['ch']->value['nama'];?>
" class="img-responsive" /></a>
        </div>
        <?php }?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['ch']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['ch']->value['nama'];?>
</a> 
 </div>
<?php } ?>
<br clear="all" /><br clear="all" />
<center>
<div class="paginate">
    <ul class="pagination">
        <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['pageid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['stringpage']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['pageid']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
            <?php if ($_smarty_tpl->tpl_vars['a']->value['link']!=''){?>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a></li>
            <?php }else{ ?>
                <li><a href="javascript:void(0)"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a></li>
            <?php }?>
        <?php } ?>
    </ul>
</div>
</center><?php }} ?>