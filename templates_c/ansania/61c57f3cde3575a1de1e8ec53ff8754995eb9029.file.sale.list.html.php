<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 20:46:49
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/sale/sale.list.html" */ ?>
<?php /*%%SmartyHeaderCode:42960233761929c4a585f51-21395214%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '61c57f3cde3575a1de1e8ec53ff8754995eb9029' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/sale/sale.list.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '42960233761929c4a585f51-21395214',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61929c4a669e07_48920712',
  'variables' => 
  array (
    'list_post' => 0,
    'p' => 0,
    'stringpage' => 0,
    'a' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61929c4a669e07_48920712')) {function content_61929c4a669e07_48920712($_smarty_tpl) {?>        <!-- CONTAINER: catalog -->
        <div class="container catalog catalog-square">

            <div class="col-md-12 text-center">
           
                <div class="row">
                <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['produkid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list_post']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['produkid']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                   <div class="col-md-3">
                   		<div class="citem item">
                        <div class="cimg">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['p']->value['link_detail'];?>
" class="aimg">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['p']->value['image_m'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['p']->value['namaprod'];?>
">
                                <?php if ($_smarty_tpl->tpl_vars['p']->value['misc_diskonn']!='0'){?><div class="sticker sticker-sale">sale</div><?php }?>
                            </a>

                            <div class="product-button">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['p']->value['link_detail'];?>
"><i class="fa fa-eye"></i></a>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['p']->value['link_detail'];?>
"><i class="fa fa-heart"></i></a>
                            </div>
                        </div>
                        <h5><a href="<?php echo $_smarty_tpl->tpl_vars['p']->value['link_detail'];?>
" class="black"><?php echo $_smarty_tpl->tpl_vars['p']->value['namaprod'];?>
</a></h5>
                        <div class="cost">
                            <?php if ($_smarty_tpl->tpl_vars['p']->value['misc_diskonn']!='0'){?>
                            <del><?php echo $_smarty_tpl->tpl_vars['p']->value['price'];?>
</del>
                            <span class="new"><?php echo $_smarty_tpl->tpl_vars['p']->value['misc_diskon'];?>
</span>
                            <?php }else{ ?>
                            <span class="new"><?php echo $_smarty_tpl->tpl_vars['p']->value['price'];?>
</span>
                            <?php }?>
                        </div>
                        <div class="rating-wrap">
                            <div class="raty" data-score="<?php echo $_smarty_tpl->tpl_vars['p']->value['totalrating'];?>
" data-readonly="true"></div>
                        </div>
                    </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
        <!-- /.container -->

        <!-- CONTAINER -->
        <div class="container">
            <div class="row">
                <div class="col-md-offset-7 col-xs-10 col-xs-offset-2 col-md-5 col-sm-offset-5 col-sm-7 text-right pagination-box">
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
        </div>
        <!-- /.container -->
        <div class="clearfix">&nbsp;</div>
<?php }} ?>