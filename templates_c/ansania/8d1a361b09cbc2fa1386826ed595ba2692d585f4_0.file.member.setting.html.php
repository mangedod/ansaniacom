<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:13:30
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.setting.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c71a6f42f0_77744068',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8d1a361b09cbc2fa1386826ed595ba2692d585f4' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.setting.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c71a6f42f0_77744068 (Smarty_Internal_Template $_smarty_tpl) {
?>
           <h3>Setting</h3>
           <hr>
            <!-- =========================================TAB SETTING START ========================================= -->
                <section id="single-product-tab" class="setting-tab">
                    
                    <?php echo '<script'; ?>
 type="text/javascript">
                        function tampil(data) {
                            if (data == "tampil") {
                                $(".shippingaddres").show();
                            } else {
                                $(".shippingaddres").hide();
                            }
                        }
                    <?php echo '</script'; ?>
>
                    

                    <div class="no-container">
                        <div class="tab-holder tab-product-detail">

                            <ul class=" nav nav-tabs text-center">
                                <li <?php if ($_smarty_tpl->tpl_vars['subaksi']->value == 'biodata' || $_smarty_tpl->tpl_vars['subaksi']->value == '') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting/biodata">Personal Biodata</a></li>
                                <li <?php if ($_smarty_tpl->tpl_vars['subaksi']->value == 'addressinfo' || $_smarty_tpl->tpl_vars['subaksi']->value == 'deleteaddress') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting/addressinfo">Address Information</a></li>
                                <li <?php if ($_smarty_tpl->tpl_vars['subaksi']->value == 'changepass') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting/changepass">Change Password</a></li>
                            </ul>
                            <!-- /.nav-tabs -->

                            <div class="tab-content">
                            <br/>
                            <?php if ($_smarty_tpl->tpl_vars['error']->value != '') {?>
                                <div class="alert <?php echo $_smarty_tpl->tpl_vars['style']->value;?>
 alert-dismissible" role="alert" style="min-height: 0px;">
                                    <button type="button" class="close" data-dismiss="alert" onclick="window.location=('<?php echo $_smarty_tpl->tpl_vars['backlink']->value;?>
')">
                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

                                </div>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['subaksi']->value == 'addressinfo' || $_smarty_tpl->tpl_vars['subaksi']->value == 'deleteaddress') {?>
                                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.setting.addressinfo.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['subaksi']->value == 'changepass') {?>
                                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.setting.changepass.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['subaksi']->value == 'biodata' || $_smarty_tpl->tpl_vars['subaksi']->value == '') {?>
                                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.setting.biodata.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
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
          <?php }
}
