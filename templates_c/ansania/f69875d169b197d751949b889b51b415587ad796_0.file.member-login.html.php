<?php
/* Smarty version 4.3.0, created on 2024-03-27 14:36:01
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/member-login.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_66042ed1eab066_57702166',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f69875d169b197d751949b889b51b415587ad796' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/member-login.html',
      1 => 1711550159,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66042ed1eab066_57702166 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
if ($_smarty_tpl->tpl_vars['aksi']->value == 'daftar' || $_smarty_tpl->tpl_vars['aksi']->value == 'daftaranggota') {?>
    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.register.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
} elseif ($_smarty_tpl->tpl_vars['aksi']->value == 'lupapassword') {?>
    <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/lupapassword.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
} else { ?>
    <!-- HOME -->
    <div class="container kanal">
       <div class="row">
            <div class="col-md-12"> 
                <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                   <li class="active" ><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member">Member</a></li>
                </ol>             
                
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>Member Area</h1>
       </div>
    </div>

    <div class="container mt-30">  
        <div class="row">
           <div class="col-md-4">
           <h3 class="text-center">Login ke Ansania</h3>

            <?php if ($_smarty_tpl->tpl_vars['notifpesan']->value != '') {?>
            <div class="alert <?php if ($_smarty_tpl->tpl_vars['berhasil']->value == '1') {?>  alert-success <?php } else { ?> alert-danger<?php }?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo $_smarty_tpl->tpl_vars['notifpesan']->value;?>

            </div>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['login']->value == '') {?>
			Bila anda sudah memiliki login di Ansania.com, silahkan lanjutkan proses belanja anda dengan login terlebih dahulu<br clear="all" />
            
            <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/login" role="form" class="form-horizontal" method="post" name="login">
                <?php if ($_smarty_tpl->tpl_vars['last']->value != '') {?><input type="hidden" name="uri" value="<?php echo $_smarty_tpl->tpl_vars['last']->value;?>
" /><?php }?>
               <br>
                <div class="form-group">
                   <div class="col-md-12">
                   <label class="control-label"><b>Username / Handphone / Email :</b></label>
                       <input type="text" placeholder="Masukan Username atau Email" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['cookname']->value;?>
" name="user">
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-md-12">
                   <label class="control-label"><b>Password :</b></label>
                       <input type="password" placeholder="Password" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['cookpass']->value;?>
" name="pass">
                   </div>
               </div>
               <div class="form-group">
                   
                   <div class="col-md-6">
                       <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/lupapassword">Forgot Password ?</a>
                   </div>
                   <div class="col-md-6 text-right">
                       <button class="btn btn-primary" type="submit">Login</button>
                   </div>
               </div>
            </form>
            <?php }?>
          
                
           </div>
           <div class="col-md-1">
           </div>
           <div class="col-md-6">
           <h3 class="text-center">Daftarkan Dulu</h3>

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
			Bila anda belum memiliki akun di ansaniapremium.com, silahkan daftarkan diri anda terlebih
            dahulu dengan melengkapi isian pendaftaran berikut ini.<br clear="all" /><br clear="all" />
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
<?php }?>

</div>
<!-- /.wrapper -->

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
