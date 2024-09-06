<?php /* Smarty version Smarty-3.1.13, created on 2022-02-24 21:43:55
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.register.html" */ ?>
<?php /*%%SmartyHeaderCode:321722922619298eb71ffb4-46293937%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '07a93c213faa292abcf44cba82d654a58039967e' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/member.register.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '321722922619298eb71ffb4-46293937',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_619298eb7ce036_38975594',
  'variables' => 
  array (
    'pesanhasil' => 0,
    'berhasil' => 0,
    'pesan' => 0,
    'a' => 0,
    'daftaravatar' => 0,
    'daftarname' => 0,
    'title' => 0,
    'fulldomain' => 0,
    'fbid' => 0,
    'gpid' => 0,
    'last' => 0,
    'daftarusername' => 0,
    'daftaremail' => 0,
    'daftaruserphonegsm' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_619298eb7ce036_38975594')) {function content_619298eb7ce036_38975594($_smarty_tpl) {?>    <!-- HOME -->
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

                <?php if ($_smarty_tpl->tpl_vars['pesanhasil']->value!=''){?>
                  <div class="alert <?php if ($_smarty_tpl->tpl_vars['berhasil']->value=='1'){?>  alert-success <?php }else{ ?> alert-danger<?php }?> alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                       <?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>
.
                       <ul>
                       <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['pesan']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
                          <li><?php echo $_smarty_tpl->tpl_vars['a']->value['pesan'];?>
</li>
                       <?php } ?>
                       </ul>
                  </div>
                <?php }else{ ?>
                    <?php if ($_smarty_tpl->tpl_vars['daftaravatar']->value!=''){?>
                        <div class="daftar-avatar" ><img src="<?php echo $_smarty_tpl->tpl_vars['daftaravatar']->value;?>
" alt="" border="0" /></div>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['daftarname']->value!=''){?>
                      Hi <strong><?php echo $_smarty_tpl->tpl_vars['daftarname']->value;?>
</strong>, continue by completing the registration process you
                       the form provided below correctly<hr />
                      <div class="alert alert-warning">
                      If you already have an account <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 before and will be linked
                       with your sosmed, enter the username and password that you have.
                      </div>
                    <?php }else{ ?>
                    <?php }?>
                <?php }?>

              
                  <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/daftaranggota" class="form-horizontal" method="post" name="registermember">
                      <input type="hidden" name="register" value="1" />
                      <?php if ($_smarty_tpl->tpl_vars['fbid']->value!=''){?><input type="hidden" name="fbid" value="<?php echo $_smarty_tpl->tpl_vars['fbid']->value;?>
" /><?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['gpid']->value!=''){?><input type="hidden" name="gpid" value="<?php echo $_smarty_tpl->tpl_vars['gpid']->value;?>
" /><?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['last']->value!=''){?><input type="hidden" name="uri" value="<?php echo $_smarty_tpl->tpl_vars['last']->value;?>
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
    </div><?php }} ?>