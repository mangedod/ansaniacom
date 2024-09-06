<?php
/* Smarty version 4.3.0, created on 2024-03-28 16:46:08
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.register.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_66059ed01d0688_01020266',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '51c8ddf3a4ce378608b91bf2be19c2b93c5990d4' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/member.register.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66059ed01d0688_01020266 (Smarty_Internal_Template $_smarty_tpl) {
?>    <!-- HOME -->
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
                <?php } else { ?>
                    <?php if ($_smarty_tpl->tpl_vars['daftaravatar']->value != '') {?>
                        <div class="daftar-avatar" ><img src="<?php echo $_smarty_tpl->tpl_vars['daftaravatar']->value;?>
" alt="" border="0" /></div>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['daftarname']->value != '') {?>
                      Hi <strong><?php echo $_smarty_tpl->tpl_vars['daftarname']->value;?>
</strong>, continue by completing the registration process you
                       the form provided below correctly<hr />
                      <div class="alert alert-warning">
                      If you already have an account <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 before and will be linked
                       with your sosmed, enter the username and password that you have.
                      </div>
                    <?php } else { ?>
                    <?php }?>
                <?php }?>

              
                  <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/daftaranggota" class="form-horizontal" method="post" name="registermember">
                      <input type="hidden" name="register" value="1" />
                      <?php if ($_smarty_tpl->tpl_vars['fbid']->value != '') {?><input type="hidden" name="fbid" value="<?php echo $_smarty_tpl->tpl_vars['fbid']->value;?>
" /><?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['gpid']->value != '') {?><input type="hidden" name="gpid" value="<?php echo $_smarty_tpl->tpl_vars['gpid']->value;?>
" /><?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['last']->value != '') {?><input type="hidden" name="uri" value="<?php echo $_smarty_tpl->tpl_vars['last']->value;?>
" /><?php }?>
                     <div class="form-group">
                         <label class="control-label col-md-4">Username :</label>
                         <div class="col-md-8"><input type="text" name="username"  value="<?php echo $_smarty_tpl->tpl_vars['daftarusername']->value;?>
" placeholder="Masukan username anda minimal 3 karakter tanpa simbol" class="form-control" required="required"></div>
                     </div>
                     <div class="form-group">
                         <label class="control-label col-md-4">Name :</label>
                         <div class="col-md-8"><input type="text" name="userfullname"  value="<?php echo $_smarty_tpl->tpl_vars['daftarname']->value;?>
"  placeholder="Masukan nama lengkap anda" class="form-control" required="required"></div>
                     </div>
                     <div class="form-group">
                         <label class="control-label col-md-4">Email :</label>
                         <div class="col-md-8"><input type="email" name="useremail"  value="<?php echo $_smarty_tpl->tpl_vars['daftaremail']->value;?>
"  placeholder="Tulis alamat email anda" class="form-control" required="required"></div>
                     </div>
                     <div class="form-group">
                         <label class="control-label col-md-4">Phone Number :</label>
                         <div class="col-md-8"><input type="text" name="userphonegsm"  placeholder="Masukan nomor telephone anda"  value="<?php echo $_smarty_tpl->tpl_vars['daftaruserphonegsm']->value;?>
" class="form-control"></div>
                     </div>
                     <div class="form-group">
                         <label class="control-label col-md-4">Password :</label>
                         <div class="col-md-8"><input type="password" name="userpassword"  placeholder="Ketik password anda"  class="form-control" required="required"></div>
                     </div>
                      <div class="form-group">
                         <label class="control-label col-md-4">Confirm Password :</label>
                         <div class="col-md-8"><input type="password" name="userpasswordconf"  placeholder="Ketik ulang password anda"  class="form-control" required="required"></div>
                     </div>
                      <fieldset class="custom">
                      <div class="col-md-8 col-md-offset-4">
                          <div class="checkbox-group">
                              <label for="confirm-register"><input id="confirm-register" required="required" type="checkbox">&nbsp; <span>Saya paham dan menyetujui <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/termcondition">Aturan dan kebijakan </a> dari <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
.</span></label>
                          </div>
                          <div class="clearfix">&nbsp;</div>
                      </div>
                      </fieldset>
                     <div class="form-group">
                         <div class="col-md-3 col-md-offset-4"><button class="btn btn-primary" type="submit">Daftarkan Sekarang</button></div>
                       
                        
                     </div>
                  </form>
                  
           </div>
        </div>
    </div><?php }
}
