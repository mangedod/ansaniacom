<?php
/* Smarty version 4.3.0, created on 2023-08-22 02:28:07
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.addticketing.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_64e41d37e70b83_00470375',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f0e15a346786b46462538742493dfeb02f11642d' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.addticketing.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64e41d37e70b83_00470375 (Smarty_Internal_Template $_smarty_tpl) {
?><h3>Add Ticket</h3>
    <hr>
    <?php if ($_smarty_tpl->tpl_vars['error']->value != '') {?>
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
                	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ticket_sec']->value, 't', false, 'secid');
$_smarty_tpl->tpl_vars['t']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['secid']->value => $_smarty_tpl->tpl_vars['t']->value) {
$_smarty_tpl->tpl_vars['t']->do_else = false;
?>
                    	<option value="<?php echo $_smarty_tpl->tpl_vars['t']->value['secid'];?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value['nama'];?>
</option>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
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
    </form><?php }
}
