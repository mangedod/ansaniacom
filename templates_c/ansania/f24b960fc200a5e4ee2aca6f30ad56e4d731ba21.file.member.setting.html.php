<?php /* Smarty version Smarty-3.1.13, created on 2022-01-21 16:33:18
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.setting.html" */ ?>
<?php /*%%SmartyHeaderCode:18140053061ea6fcedf9ad5-25666004%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f24b960fc200a5e4ee2aca6f30ad56e4d731ba21' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/member.setting.html',
      1 => 1642674336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18140053061ea6fcedf9ad5-25666004',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'subaksi' => 0,
    'fulldomain' => 0,
    'error' => 0,
    'style' => 0,
    'backlink' => 0,
    'lokasitemplate' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ea6fcf0375c5_04875550',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ea6fcf0375c5_04875550')) {function content_61ea6fcf0375c5_04875550($_smarty_tpl) {?>
           <h3>Setting</h3>
           <hr>
            <!-- =========================================TAB SETTING START ========================================= -->
                <section id="single-product-tab" class="setting-tab">
                    
                    <script type="text/javascript">
                        function tampil(data) {
                            if (data == "tampil") {
                                $(".shippingaddres").show();
                            } else {
                                $(".shippingaddres").hide();
                            }
                        }
                    </script>
                    

                    <div class="no-container">
                        <div class="tab-holder tab-product-detail">

                            <ul class=" nav nav-tabs text-center">
                                <li <?php if ($_smarty_tpl->tpl_vars['subaksi']->value=='biodata'||$_smarty_tpl->tpl_vars['subaksi']->value==''){?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting/biodata">Personal Biodata</a></li>
                                <li <?php if ($_smarty_tpl->tpl_vars['subaksi']->value=='addressinfo'||$_smarty_tpl->tpl_vars['subaksi']->value=='deleteaddress'){?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting/addressinfo">Address Information</a></li>
                                <li <?php if ($_smarty_tpl->tpl_vars['subaksi']->value=='changepass'){?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting/changepass">Change Password</a></li>
                            </ul>
                            <!-- /.nav-tabs -->

                            <div class="tab-content">
                            <br/>
                            <?php if ($_smarty_tpl->tpl_vars['error']->value!=''){?>
                                <div class="alert <?php echo $_smarty_tpl->tpl_vars['style']->value;?>
 alert-dismissible" role="alert" style="min-height: 0px;">
                                    <button type="button" class="close" data-dismiss="alert" onclick="window.location=('<?php echo $_smarty_tpl->tpl_vars['backlink']->value;?>
')">
                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

                                </div>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['subaksi']->value=='addressinfo'||$_smarty_tpl->tpl_vars['subaksi']->value=='deleteaddress'){?>
                                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.setting.addressinfo.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                            <?php }elseif($_smarty_tpl->tpl_vars['subaksi']->value=='changepass'){?>
                                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.setting.changepass.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                            <?php }elseif($_smarty_tpl->tpl_vars['subaksi']->value=='biodata'||$_smarty_tpl->tpl_vars['subaksi']->value==''){?>
                                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.setting.biodata.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                            <?php }?>
                            </div>
                            <!-- /.tab-content -->

                        </div>
                        <!-- /.tab-holder -->
                    </div>
                    <!-- /.container -->
                </section>
                <!-- /#single-product-tab -->
                <!-- ========================================= SETTING TAB : END ========================================= -->
          <?php }} ?>