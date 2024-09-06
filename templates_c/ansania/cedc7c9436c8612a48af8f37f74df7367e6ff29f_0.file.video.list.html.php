<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:04:47
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/video/video.list.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c50f272ab7_49626470',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cedc7c9436c8612a48af8f37f74df7367e6ff29f' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/video/video.list.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c50f272ab7_49626470 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datadetail']->value, 'ch', false, 'id');
$_smarty_tpl->tpl_vars['ch']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['ch']->value) {
$_smarty_tpl->tpl_vars['ch']->do_else = false;
?>
 <div class="col-md-6 mt-20 text-center">
        <?php if ($_smarty_tpl->tpl_vars['ch']->value['gambar'] != '') {?>
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
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
<br clear="all" /><br clear="all" />
<center>
<div class="paginate">
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
</center><?php }
}
