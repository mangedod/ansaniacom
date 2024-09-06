<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:14:44
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.setting.changepass.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c764973ca2_28423154',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5b28cc6c3c7737277c6f170c05a21193ff856aa6' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.setting.changepass.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c764973ca2_28423154 (Smarty_Internal_Template $_smarty_tpl) {
?>
                                <div class="tab-pane <?php if ($_smarty_tpl->tpl_vars['subaksi']->value == 'changepass') {?>active<?php }?>" id="changepass">
                                    <form class="form-horizontal" action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting/changepass" method="post">
                                        <input type="hidden" name="savepass" value="1">
                                        <div class="form-group">
                                            <label for="password" class="col-sm-3">Old Password</label>
                                            <div class="col-sm-6">
                                                <input type="password" id="password1" name="password1" class="form-control" placeholder="******" required="required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password-baru" class="col-sm-3">New Password</label>
                                            <div class="col-sm-6">
                                                <input type="password" id="password2" name="password2" class="form-control" placeholder="******" required="required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password-konfirm" class="col-sm-3">Confirm New Password</label>
                                            <div class="col-sm-6">
                                                <input type="password" id="password3" name="password3" class="form-control" placeholder="******" required="required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane #changepass --><?php }
}
