<?php /* Smarty version Smarty-3.1.13, created on 2022-01-21 16:33:12
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.review.html" */ ?>
<?php /*%%SmartyHeaderCode:7743058561ea6fc856f511-98988199%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '59c200335fbc837e6dcd97f2570e0eb5c9c0e33c' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.review.html',
      1 => 1642674336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7743058561ea6fc856f511-98988199',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'namaaksi' => 0,
    'jml_review' => 0,
    'list_transaksi' => 0,
    'a' => 0,
    'stringpage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ea6fc85e6628_49892835',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ea6fc85e6628_49892835')) {function content_61ea6fc85e6628_49892835($_smarty_tpl) {?><h3><?php echo $_smarty_tpl->tpl_vars['namaaksi']->value;?>
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
        <?php if ($_smarty_tpl->tpl_vars['jml_review']->value!='0'||$_smarty_tpl->tpl_vars['jml_review']->value!=''){?>
            <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['transaksiid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list_transaksi']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['transaksiid']->value = $_smarty_tpl->tpl_vars['a']->key;
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
            <?php } ?>
        <?php }else{ ?>
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
<?php if ($_smarty_tpl->tpl_vars['jml_review']->value!='0'){?>
        <div class="col-md-6 text-right">
            <ul class="pagination">
                <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['pageid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['stringpage']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['pageid']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
                    <li class="<?php echo $_smarty_tpl->tpl_vars['a']->value['class'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"> <?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
 </a></li>
                <?php } ?>
            </ul><!-- /.pagination -->
        </div>
<?php }?>
    </div><!-- /.row -->
</div><!-- /.pagination-holder -->
<?php }} ?>