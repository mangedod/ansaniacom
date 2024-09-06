<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:13:30
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.setting.biodata.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c71a736452_97747880',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8a0c4c3c5fdd8de2e8045b4534b1f1d70f36292a' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.setting.biodata.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c71a736452_97747880 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'http://localhost:8080/ansaniacom/public_html/librari/smarty/libs/plugins/function.html_options.php','function'=>'smarty_function_html_options',),));
?>
                              <?php echo '<script'; ?>
 src="../../librari/ajax/ajax_prop.js"><?php echo '</script'; ?>
>
                              <?php echo '<script'; ?>
 src="../../librari/ajax/ajax_kota.js"><?php echo '</script'; ?>
>
                                <div class="tab-pane <?php if ($_smarty_tpl->tpl_vars['subaksi']->value == 'biodata' || $_smarty_tpl->tpl_vars['subaksi']->value == '') {?>active<?php }?>" id="biodata">
                                    <form class="form-horizontal" name="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting" method="post">
                                        <input type="hidden" name="saveacc" value="1">
                                        <div class="form-group">
                                            <label for="nama" class="col-sm-4">Username/ Email</label>
                                            <div class="col-sm-6">
                                              <input type="text" class="form-control" id="useremail" name="useremail" value="<?php echo $_smarty_tpl->tpl_vars['useremail']->value;?>
" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="nama" class="col-sm-4">Full Name&nbsp;&nbsp;<span style="color:red">*</span></label>
                                            <div class="col-sm-6">
                                              <input type="text" class="form-control" id="userfullname" placeholder="Full Name" value="<?php echo $_smarty_tpl->tpl_vars['userfullname']->value;?>
" name="userfullname" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hari" class="col-sm-4">Date of birth</label>
                                            <div class="col-sm-2">
                                              <select name="date" class="form-control" id="date" required  >
                                                <option value="">Date</option>
                                                  <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['dateLoop']->value,'output'=>$_smarty_tpl->tpl_vars['dateLoop']->value,'selected'=>$_smarty_tpl->tpl_vars['dateSelected']->value),$_smarty_tpl);?>

                                              </select>
                                            </div>
                                            <div class="col-sm-2">
                                              <select name="month" class="form-control" id="month" style="margin-left: 30px;" required >
                                                  <option value="">Month</option>
                                                  <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['monthLoop']->value,'output'=>$_smarty_tpl->tpl_vars['monthLoop']->value,'selected'=>$_smarty_tpl->tpl_vars['monthSelected']->value),$_smarty_tpl);?>

                                              </select>
                                            </div>
                                            <div class="col-sm-2">
                                              <select name="year" class="form-control" id="year" style="margin-left: 60px;"    required>
                                                <option value="">Year</option>
                                                <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['yearLoop']->value,'output'=>$_smarty_tpl->tpl_vars['yearLoop']->value,'selected'=>$_smarty_tpl->tpl_vars['yearSelected']->value),$_smarty_tpl);?>

                                              </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="laki-laki" class="col-sm-4">Gender&nbsp;&nbsp;<span style="color:red">*</span></label>
                                            <div class="col-sm-6">
                                              <label><input type="radio" name="usergender" style="display:block" id="Male" value="laki-laki" <?php if ($_smarty_tpl->tpl_vars['usergender']->value == 'laki-laki') {?>checked="checked"<?php }?>> Male</label>
                                              &nbsp;&nbsp;
                                              <label><input type="radio" name="usergender" style="display:block" id="Female" value="perempuan" <?php if ($_smarty_tpl->tpl_vars['usergender']->value == 'perempuan') {?>checked="checked"<?php }?>> Female</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hp" class="col-sm-4">Mobile phone number&nbsp;&nbsp;<span style="color:red">*</span></label>
                                            <div class="col-sm-6">
                                              <input type="text" class="form-control" id="userphonegsm" name="userphonegsm" value="<?php echo $_smarty_tpl->tpl_vars['userpgsm']->value;?>
" placeholder="Mobile phone number">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="alert alert-info">
                                                    <p style="margin:0"> <i class="fa fa-info-circle"></i> &nbsp;Asterisk (*) Mandatory.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-4 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane #biodata --><?php }
}
