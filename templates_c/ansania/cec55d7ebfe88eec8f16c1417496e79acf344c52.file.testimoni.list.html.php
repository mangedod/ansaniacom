<?php /* Smarty version Smarty-3.1.13, created on 2022-01-30 13:39:29
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/testimoni/testimoni.list.html" */ ?>
<?php /*%%SmartyHeaderCode:80235563161f62491cc8815-19190994%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cec55d7ebfe88eec8f16c1417496e79acf344c52' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/testimoni/testimoni.list.html',
      1 => 1642674336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '80235563161f62491cc8815-19190994',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'datadetail' => 0,
    'ch' => 0,
    'stringpage' => 0,
    'a' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61f62491d1d3e1_98548580',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61f62491d1d3e1_98548580')) {function content_61f62491d1d3e1_98548580($_smarty_tpl) {?><div class="insight-headline">

<?php  $_smarty_tpl->tpl_vars['ch'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ch']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datadetail']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ch']->key => $_smarty_tpl->tpl_vars['ch']->value){
$_smarty_tpl->tpl_vars['ch']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['ch']->key;
?>
    <div class="list-content">
    	<div class="list-content-isi">
            <?php if ($_smarty_tpl->tpl_vars['ch']->value['gambar']!=''){?>
            <div class="col-md-3"><img src="<?php echo $_smarty_tpl->tpl_vars['ch']->value['gambar'];?>
" style="width:90%" /></div>
            <?php }?>
            <div class="col-md-8">
                <h3 style="width:100%"><?php echo $_smarty_tpl->tpl_vars['ch']->value['nama'];?>
</h3>
                <p><?php echo $_smarty_tpl->tpl_vars['ch']->value['testimoni'];?>
<br />
                <span><?php echo $_smarty_tpl->tpl_vars['ch']->value['tanggal'];?>
</span>
            </p>
            </div>
                   
        </div>
    </div>
<?php } ?>
<div class="paginate pull-right">
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
</div>
<?php }} ?>