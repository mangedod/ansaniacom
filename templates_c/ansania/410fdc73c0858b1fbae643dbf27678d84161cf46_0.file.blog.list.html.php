<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:04:49
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/blog/blog.list.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c511041274_27242142',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '410fdc73c0858b1fbae643dbf27678d84161cf46' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/blog/blog.list.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c511041274_27242142 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- BLOGBAR -->
<div class="col-sm-8">
<!-- row -->
<div class="row">

    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datadetail']->value, 'ch', false, 'id');
$_smarty_tpl->tpl_vars['ch']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['ch']->value) {
$_smarty_tpl->tpl_vars['ch']->do_else = false;
?>
    <div class="col-md-12">
    	<div class="blog-post">
        <?php if ($_smarty_tpl->tpl_vars['ch']->value['gambar'] != '') {?>
        <div class="post-thumb">
           <a href="<?php echo $_smarty_tpl->tpl_vars['ch']->value['link'];?>
" class="black"> <img src="<?php echo $_smarty_tpl->tpl_vars['ch']->value['gambar'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['ch']->value['nama'];?>
"></a>
        </div>
        <?php }?>
        <h2><a href="<?php echo $_smarty_tpl->tpl_vars['ch']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['ch']->value['nama'];?>
</a></h2>
            <a href="<?php echo $_smarty_tpl->tpl_vars['ch']->value['link'];?>
" class="grey"><?php echo $_smarty_tpl->tpl_vars['ch']->value['tanggal'];?>
</a> -
            <a href="<?php echo $_smarty_tpl->tpl_vars['ch']->value['link'];?>
" class="grey"><?php echo $_smarty_tpl->tpl_vars['ch']->value['namasec'];?>
</a> 
        <p><?php echo $_smarty_tpl->tpl_vars['ch']->value['ringkas'];?>
</p>
		</div>
    </div>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    
</div>
<!-- /.row -->

<div class="clearfix">&nbsp;</div>

<div class="col-md-12 text-right pagination-box">
    <ul class="pagination">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['stringpage']->value, 'a', false, 'pageid');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pageid']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
        <?php if ($_smarty_tpl->tpl_vars['a']->value['link'] != '') {?>
            <li class="<?php echo $_smarty_tpl->tpl_vars['a']->value['class'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a></li>
        <?php } else { ?>
            <li class="<?php echo $_smarty_tpl->tpl_vars['a']->value['class'];?>
"><a href="javascript:void(0)"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a></li>
        <?php }?>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
</div>
</div>

<aside class="blogbar col-sm-4">
<!-- widget -->
<div class="panel panel-dark blog-category">
    <div class="panel-heading">
        <h3 class="panel-title">BLOG TERPOPULER</h3>
    </div>
    <div class="panel-body">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datapopuler']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
            <div class="blog-populer-item">
                <div class="blog-populer-item-img">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['gambar'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
" />
                </div>
               <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a>
            </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </div>
</div>


</aside>
<!-- /.blogbar --><?php }
}
