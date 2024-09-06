<?php
/* Smarty version 4.3.0, created on 2023-02-17 01:58:27
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/register.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63eedf4313f389_72901137',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f4237e32a6333a99039970b228bc5c537f059d40' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/register.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63eedf4313f389_72901137 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
    <!-- HOME -->
    <div class="overlay home small-medium-size">
        <div class="bg bg-shop"></div>
        <div class="container vmiddle">
            <div class="row text-center text-title-list">
                <h1 class="text-uppercase" style="font-size: 50px">Register</h1>
                <h4>Please register yourself</h4>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <div class="container">
        <div class="row">
           <div class="col-md-6 col-md-offset-2">

            <?php if ($_smarty_tpl->tpl_vars['pesanhasil']->value != '') {?>
            <div class="alert <?php if ($_smarty_tpl->tpl_vars['berhasil']->value == '1') {?>  alert-success <?php } else { ?> alert-danger<?php }?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                 <?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>
.
                 <ul>
                 <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pesan']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
                    <li><?php echo $_smarty_tpl->tpl_vars['a']->value['pesan'];?>
</li>
                 <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                 </ul>
            </div>
            <?php }?>

            <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/register/registrasi" class="form-horizontal" method="post" name="registermember">
                <input type="hidden" name="register" value="1" />
                <?php if ($_smarty_tpl->tpl_vars['fbid']->value != '') {?><input type="hidden" name="fbcid" value="<?php echo $_smarty_tpl->tpl_vars['fbid']->value;?>
" /><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['twid']->value != '') {?><input type="hidden" name="twcid" value="<?php echo $_smarty_tpl->tpl_vars['twid']->value;?>
" /><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['gpid']->value != '') {?><input type="hidden" name="gpcid" value="<?php echo $_smarty_tpl->tpl_vars['gpid']->value;?>
" /><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['tw_token']->value != '') {?><input type="hidden" name="tw_token" value="<?php echo $_smarty_tpl->tpl_vars['tw_token']->value;?>
" /><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['tw_secret']->value != '') {?><input type="hidden" name="tw_secret" value="<?php echo $_smarty_tpl->tpl_vars['tw_secret']->value;?>
" /><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['last']->value != '') {?><input type="hidden" name="uri" value="<?php echo $_smarty_tpl->tpl_vars['last']->value;?>
" /><?php }?>
               <div class="form-group">
                   <label class="control-label col-md-4">Username :</label>
                   <div class="col-md-8"><input type="text" name="username"  value="<?php echo $_smarty_tpl->tpl_vars['daftarusername']->value;?>
" class="form-control" placeholder="Masukan username anda minimal 3 karakter tanpa simbol" required="required"></div>
               </div>
               <div class="form-group">
                   <label class="control-label col-md-4">Nama Lengkap :</label>
                   <div class="col-md-8"><input type="text" name="userfullname"  value="<?php echo $_smarty_tpl->tpl_vars['daftarname']->value;?>
" class="form-control"  placeholder="Masukan nama lengkap anda" required="required"></div>
               </div>
               <div class="form-group">
                   <label class="control-label col-md-4">Alamat Email :</label> 
                   <div class="col-md-8"><input type="email" name="useremail"  value="<?php echo $_smarty_tpl->tpl_vars['daftaremail']->value;?>
" class="form-control"  placeholder="Ketik email anda dengan benar" required="required"></div>
               </div>
               <div class="form-group">
                   <label class="control-label col-md-4">Nomor Handphone :</label>
                   <div class="col-md-8"><input type="text" name="userphonegsm"  value="<?php echo $_smarty_tpl->tpl_vars['daftaruserphonegsm']->value;?>
" class="form-control"  placeholder="Masukan nomor handphone anda"></div>
               </div>
               <div class="form-group">
                   <label class="control-label col-md-4">Password :</label>
                   <div class="col-md-8"><input type="password" name="userpassword"  class="form-control"   placeholder="Ketik password anda" required="required"></div>
               </div>
                <div class="form-group">
                   <label class="control-label col-md-4">Confirm Password :</label>
                   <div class="col-md-8"><input type="password" name="userpasswordconf"  class="form-control" required="required"  placeholder="Ketik Ulang Password anda"></div>
               </div>
                <fieldset class="custom">
                <div class="col-md-8 col-md-offset-4">
                    <div class="checkbox-group">
                        <label for="confirm-register"><input id="confirm-register" required="required" type="checkbox">&nbsp; <span>Saya memahami dan menyetujui <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/termcondition">Aturan dan kebijakan</a> dari <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
.</span></label>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                </div>
                </fieldset>
               <div class="form-group">
                   <div class="col-md-8 col-md-offset-4"><button class="btn btn-primary" type="submit">Daftar Sekarang</button></div>
               </div>
            </form>
           </div>
        </div>
    </div>

</div>
<!-- /.wrapper -->

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
