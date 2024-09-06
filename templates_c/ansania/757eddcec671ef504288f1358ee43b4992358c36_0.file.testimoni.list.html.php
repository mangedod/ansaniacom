<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:04:48
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/testimoni/testimoni.list.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c510a0abf5_73478236',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '757eddcec671ef504288f1358ee43b4992358c36' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/testimoni/testimoni.list.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c510a0abf5_73478236 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="insight-headline">

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datadetail']->value, 'ch', false, 'id');
$_smarty_tpl->tpl_vars['ch']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['ch']->value) {
$_smarty_tpl->tpl_vars['ch']->do_else = false;
?>
    <div class="list-content">
    	<div class="list-content-isi">
            <?php if ($_smarty_tpl->tpl_vars['ch']->value['gambar'] != '') {?>
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
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
<div class="paginate pull-right">
    <ul class="pagination">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['stringpage']->value, 'a', false, 'pageid');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pageid']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
            <?php if ($_smarty_tpl->tpl_vars['a']->value['link'] != '') {?>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a></li>
            <?php } else { ?>
                <li><a href="javascript:void(0)"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a></li>
            <?php }?>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
</div>
</div>
<?php }
}
