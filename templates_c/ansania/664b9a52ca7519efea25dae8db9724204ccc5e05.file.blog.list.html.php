<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 11:26:36
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/blog/blog.list.html" */ ?>
<?php /*%%SmartyHeaderCode:88038967261928214369ae2-13591478%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '664b9a52ca7519efea25dae8db9724204ccc5e05' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/blog/blog.list.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '88038967261928214369ae2-13591478',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_619282143c4fe6_57665333',
  'variables' => 
  array (
    'datadetail' => 0,
    'ch' => 0,
    'stringpage' => 0,
    'a' => 0,
    'datapopuler' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_619282143c4fe6_57665333')) {function content_619282143c4fe6_57665333($_smarty_tpl) {?><!-- BLOGBAR -->
<div class="col-sm-8">
<!-- row -->
<div class="row">

    <?php  $_smarty_tpl->tpl_vars['ch'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ch']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datadetail']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ch']->key => $_smarty_tpl->tpl_vars['ch']->value){
$_smarty_tpl->tpl_vars['ch']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['ch']->key;
?>
    <div class="col-md-12">
    	<div class="blog-post">
        <?php if ($_smarty_tpl->tpl_vars['ch']->value['gambar']!=''){?>
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
    <?php } ?>
    
</div>
<!-- /.row -->

<div class="clearfix">&nbsp;</div>

<div class="col-md-12 text-right pagination-box">
    <ul class="pagination">
    <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['pageid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['stringpage']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['pageid']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
        <?php if ($_smarty_tpl->tpl_vars['a']->value['link']!=''){?>
            <li class="<?php echo $_smarty_tpl->tpl_vars['a']->value['class'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a></li>
        <?php }else{ ?>
            <li class="<?php echo $_smarty_tpl->tpl_vars['a']->value['class'];?>
"><a href="javascript:void(0)"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a></li>
        <?php }?>
    <?php } ?>
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
          <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datapopuler']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
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
        <?php } ?>
    </div>
</div>


</aside>
<!-- /.blogbar --><?php }} ?>