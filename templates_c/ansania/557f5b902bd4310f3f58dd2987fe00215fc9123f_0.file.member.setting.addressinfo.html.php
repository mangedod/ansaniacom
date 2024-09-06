<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:14:38
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.setting.addressinfo.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c75e63dd85_91386060',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '557f5b902bd4310f3f58dd2987fe00215fc9123f' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.setting.addressinfo.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c75e63dd85_91386060 (Smarty_Internal_Template $_smarty_tpl) {
?>                                
                                <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/librari/ajax/ajax_kota.js"><?php echo '</script'; ?>
>
                                <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/librari/ajax/ajax_kec.js"><?php echo '</script'; ?>
>
                                <div class="tab-pane <?php if ($_smarty_tpl->tpl_vars['subaksi']->value == 'addressinfo') {?>active<?php }?>" id="addressinfo">
                                    <h5>Shipping Address Proof Transactions</h5>
                                    <hr />
                                    <form class="form-horizontal" action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/setting/addressinfo" method="post">
                                        <input type="hidden" name="saveper" value="1" />
                                        <div class="form-group">
                                            <label for="alamat" class="col-sm-3">Address</label>
                                            <div class="col-sm-6">
                                                <textarea name="useraddress" class="form-control" id="useraddress" cols="30" required><?php echo $_smarty_tpl->tpl_vars['useraddress']->value;?>
</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="negara" class="col-sm-3">Country</label>
                                            <div class="col-sm-6">
                                                <select name="negaraid" onchange="getNegara(this.value);" class="form-control" required="required">
                                                    <option value=""> Select Country </option>
                                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datanegara']->value, 'j', false, 'id');
$_smarty_tpl->tpl_vars['j']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['j']->value) {
$_smarty_tpl->tpl_vars['j']->do_else = false;
?>
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['j']->value['id'];?>
" <?php echo $_smarty_tpl->tpl_vars['j']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['j']->value['namanegara'];?>
</option>
                                                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="provinsi" class="col-sm-3">Province</label>
                                            <div class="col-sm-6">
                                                <select name="propinsiid" id="propinsiid" class="form-control" onChange="getKota(this.value);" required="required">
                                                    <option value=""> Select Province </option>
                                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datapropinsi']->value, 'p', false, 'id');
$_smarty_tpl->tpl_vars['p']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['p']->value) {
$_smarty_tpl->tpl_vars['p']->do_else = false;
?>
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['namapropinsi'];?>
</option>
                                                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="kota" class="col-sm-3">City</label>
                                            <div class="col-sm-6">
                                                <select name="cityname" id="kotaId2" class="form-control" onChange="getKec(this.value);" required="required">
                                                    <option value=""> Select  </option>
                                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datakota']->value, 'p', false, 'idkota');
$_smarty_tpl->tpl_vars['p']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['idkota']->value => $_smarty_tpl->tpl_vars['p']->value) {
$_smarty_tpl->tpl_vars['p']->do_else = false;
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['p']->value['idkota'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['kota'];?>
</option>
                                                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="kecamatan" class="col-sm-3">Districts</label>
                                            <div class="col-sm-6">
                                                <select name="kecid" id="kecid" class="form-control" required="required">
                                                    <option value=""> Select Districts </option>
                                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datakecamatan']->value, 'p', false, 'kecid');
$_smarty_tpl->tpl_vars['p']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['kecid']->value => $_smarty_tpl->tpl_vars['p']->value) {
$_smarty_tpl->tpl_vars['p']->do_else = false;
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['p']->value['kecid'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['namakecamatan'];?>
</option>
                                                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="emailserver" class="col-sm-3">Postal code</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['userpostcode']->value;?>
" name="userpostcode" type="text" required="required">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane #addressinfo --><?php }
}
