<?php /* Smarty version Smarty-3.1.13, created on 2022-03-11 18:04:03
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.setting.addressinfo.html" */ ?>
<?php /*%%SmartyHeaderCode:90258398461a7f6b2def6d4-07819963%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '75bc88cffdcaaddbf0dd644cf4a8195971a9d134' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.setting.addressinfo.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '90258398461a7f6b2def6d4-07819963',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61a7f6b2e7aa13_04498944',
  'variables' => 
  array (
    'fulldomain' => 0,
    'subaksi' => 0,
    'useraddress' => 0,
    'datanegara' => 0,
    'j' => 0,
    'datapropinsi' => 0,
    'p' => 0,
    'datakota' => 0,
    'datakecamatan' => 0,
    'userpostcode' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61a7f6b2e7aa13_04498944')) {function content_61a7f6b2e7aa13_04498944($_smarty_tpl) {?>                                
                                <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/librari/ajax/ajax_kota.js"></script>
                                <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/librari/ajax/ajax_kec.js"></script>
                                <div class="tab-pane <?php if ($_smarty_tpl->tpl_vars['subaksi']->value=='addressinfo'){?>active<?php }?>" id="addressinfo">
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
                                                    <?php  $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['j']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datanegara']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['j']->key => $_smarty_tpl->tpl_vars['j']->value){
$_smarty_tpl->tpl_vars['j']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['j']->key;
?>
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['j']->value['id'];?>
" <?php echo $_smarty_tpl->tpl_vars['j']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['j']->value['namanegara'];?>
</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="provinsi" class="col-sm-3">Province</label>
                                            <div class="col-sm-6">
                                                <select name="propinsiid" id="propinsiid" class="form-control" onChange="getKota(this.value);" required="required">
                                                    <option value=""> Select Province </option>
                                                    <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datapropinsi']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['namapropinsi'];?>
</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="kota" class="col-sm-3">City</label>
                                            <div class="col-sm-6">
                                                <select name="cityname" id="kotaId2" class="form-control" onChange="getKec(this.value);" required="required">
                                                    <option value=""> Select  </option>
                                                    <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['idkota'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datakota']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['idkota']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['p']->value['idkota'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['kota'];?>
</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="kecamatan" class="col-sm-3">Districts</label>
                                            <div class="col-sm-6">
                                                <select name="kecid" id="kecid" class="form-control" required="required">
                                                    <option value=""> Select Districts </option>
                                                    <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['kecid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datakecamatan']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['kecid']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['p']->value['kecid'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['namakecamatan'];?>
</option>
                                                    <?php } ?>
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
                                <!-- /.tab-pane #addressinfo --><?php }} ?>