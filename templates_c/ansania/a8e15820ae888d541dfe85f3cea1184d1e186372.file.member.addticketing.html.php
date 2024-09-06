<?php /* Smarty version Smarty-3.1.13, created on 2022-04-11 11:04:45
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.addticketing.html" */ ?>
<?php /*%%SmartyHeaderCode:161189876062539acd030ec4-54214143%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a8e15820ae888d541dfe85f3cea1184d1e186372' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.addticketing.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161189876062539acd030ec4-54214143',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
    'style' => 0,
    'backlink' => 0,
    'fulldomain' => 0,
    'ticket_sec' => 0,
    't' => 0,
    'fileallowed' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_62539acd07afe3_45545198',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62539acd07afe3_45545198')) {function content_62539acd07afe3_45545198($_smarty_tpl) {?><h3>Add Ticket</h3>
    <hr>
    <?php if ($_smarty_tpl->tpl_vars['error']->value!=''){?>
        <div class="alert <?php echo $_smarty_tpl->tpl_vars['style']->value;?>
 alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" onclick="window.location=('<?php echo $_smarty_tpl->tpl_vars['backlink']->value;?>
')">
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
 
        </div>
    <?php }?>
                    
    <form class="form-horizontal" role="form" action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/addticketing.html" method="post" enctype="multipart/form-data">
    	<input type="hidden" name="aksi" value="save">
        <div class="form-group">
            <label class="col-sm-3">Category</label>
            <div class="col-sm-6">
            	<select name="secid" id="secid" class="form-control" required>
                	<option value=""> Choose </option>
                	<?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_smarty_tpl->tpl_vars['secid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ticket_sec']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value){
$_smarty_tpl->tpl_vars['t']->_loop = true;
 $_smarty_tpl->tpl_vars['secid']->value = $_smarty_tpl->tpl_vars['t']->key;
?>
                    	<option value="<?php echo $_smarty_tpl->tpl_vars['t']->value['secid'];?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value['nama'];?>
</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-3">Title</label>
            <div class="col-sm-6">
                <input class="form-control" name="judul" id="judul" required>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-3">Question</label>
            <div class="col-sm-6">
                <textarea class="form-control" id="inputComment" name="isipertanyaan" rows="10" required></textarea>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-3">File Upload</label>
            <div class="col-sm-6">
                <input type="file" id="files" name="files" class="form-control">
                <p class="help-block">File formats are allowed : <?php echo $_smarty_tpl->tpl_vars['fileallowed']->value;?>
</p>
            </div>
        </div>
		<div class="form-group">
       		<div class="col-md-8 col-md-offset-4"><button class="btn btn-primary" type="submit">Send Ticketing</button></div>
        </div>
    </form><?php }} ?>