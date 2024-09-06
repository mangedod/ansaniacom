<?php /* Smarty version Smarty-3.1.13, created on 2022-03-11 18:05:00
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.setting.changepass.html" */ ?>
<?php /*%%SmartyHeaderCode:203704005761a7f6c87e3552-35802000%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9ceab3aad3fb2ebf51a2f8b44e18a6edbcf19a9b' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.setting.changepass.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203704005761a7f6c87e3552-35802000',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61a7f6c8821fb2_18156012',
  'variables' => 
  array (
    'subaksi' => 0,
    'fulldomain' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61a7f6c8821fb2_18156012')) {function content_61a7f6c8821fb2_18156012($_smarty_tpl) {?>
                                <div class="tab-pane <?php if ($_smarty_tpl->tpl_vars['subaksi']->value=='changepass'){?>active<?php }?>" id="changepass">
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
                                <!-- /.tab-pane #changepass --><?php }} ?>