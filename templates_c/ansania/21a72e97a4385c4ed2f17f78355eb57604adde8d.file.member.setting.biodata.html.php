<?php /* Smarty version Smarty-3.1.13, created on 2022-03-11 18:02:20
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.setting.biodata.html" */ ?>
<?php /*%%SmartyHeaderCode:182512492061928c91632c42-04472155%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21a72e97a4385c4ed2f17f78355eb57604adde8d' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.setting.biodata.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '182512492061928c91632c42-04472155',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61928c916849c6_44228183',
  'variables' => 
  array (
    'subaksi' => 0,
    'fulldomain' => 0,
    'useremail' => 0,
    'userfullname' => 0,
    'dateLoop' => 0,
    'dateSelected' => 0,
    'monthLoop' => 0,
    'monthSelected' => 0,
    'yearLoop' => 0,
    'yearSelected' => 0,
    'usergender' => 0,
    'userpgsm' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61928c916849c6_44228183')) {function content_61928c916849c6_44228183($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/home/host/user/q8001/sites/ansania.com/htdocs/librari/smarty/libs/plugins/function.html_options.php';
?>                              <script src="../../librari/ajax/ajax_prop.js"></script>
                              <script src="../../librari/ajax/ajax_kota.js"></script>
                                <div class="tab-pane <?php if ($_smarty_tpl->tpl_vars['subaksi']->value=='biodata'||$_smarty_tpl->tpl_vars['subaksi']->value==''){?>active<?php }?>" id="biodata">
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
                                              <label><input type="radio" name="usergender" style="display:block" id="Male" value="laki-laki" <?php if ($_smarty_tpl->tpl_vars['usergender']->value=='laki-laki'){?>checked="checked"<?php }?>> Male</label>
                                              &nbsp;&nbsp;
                                              <label><input type="radio" name="usergender" style="display:block" id="Female" value="perempuan" <?php if ($_smarty_tpl->tpl_vars['usergender']->value=='perempuan'){?>checked="checked"<?php }?>> Female</label>
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
                                <!-- /.tab-pane #biodata --><?php }} ?>