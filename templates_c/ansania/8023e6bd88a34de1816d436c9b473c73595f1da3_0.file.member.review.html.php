<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:13:26
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.review.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c716590df4_38359130',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8023e6bd88a34de1816d436c9b473c73595f1da3' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.review.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c716590df4_38359130 (Smarty_Internal_Template $_smarty_tpl) {
?><h3><?php echo $_smarty_tpl->tpl_vars['namaaksi']->value;?>
</h3>
    <hr>
<div class="table-responsive">
 <table class="table table-bordered table-center">
    <thead>
        <tr>
            <th>No</th>
            <th width="60px">Pictures</th>
            <th>Product Name</th>
            <th class="text-center">Number Of Review</th>
            <th></th>
        </tr>
    </thead>
     <tbody>
        <?php if ($_smarty_tpl->tpl_vars['jml_review']->value != '0' || $_smarty_tpl->tpl_vars['jml_review']->value != '') {?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list_transaksi']->value, 'a', false, 'transaksiid');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['transaksiid']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['a']->value['no'];?>
</td>
                <td><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link_produk'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['gambar_m'];?>
" height="70" width="80" /></a></td>
                <td><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link_produk'];?>
"><strong><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</strong></a></td>
                <td><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['jumlah_review'];?>
 review</a></td>
                <td class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"><i class="fa fa-pencil-square"></i> Write A Review</a></td>
            </tr>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <?php } else { ?>
            <tr>
                <td colspan="5">
                    <div class="alert alert-warning mb-0">
                        No data review in <strong>the Review of your product</strong>.
                    </div>
                </td>
            </tr>
        <?php }?>
     </tbody>
 </table>
</div>
<div class="pagination-holder">
    <div class="row">
<?php if ($_smarty_tpl->tpl_vars['jml_review']->value != '0') {?>
        <div class="col-md-6 text-right">
            <ul class="pagination">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['stringpage']->value, 'a', false, 'pageid');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pageid']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
                    <li class="<?php echo $_smarty_tpl->tpl_vars['a']->value['class'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"> <?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
 </a></li>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </ul><!-- /.pagination -->
        </div>
<?php }?>
    </div><!-- /.row -->
</div><!-- /.pagination-holder -->
<?php }
}
