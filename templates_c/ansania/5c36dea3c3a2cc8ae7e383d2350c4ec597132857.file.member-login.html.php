<?php /* Smarty version Smarty-3.1.13, created on 2022-01-30 22:29:03
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/member-login.html" */ ?>
<?php /*%%SmartyHeaderCode:188036345761ea6319d450e4-24162687%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5c36dea3c3a2cc8ae7e383d2350c4ec597132857' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/member-login.html',
      1 => 1643553173,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '188036345761ea6319d450e4-24162687',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ea6319e21305_71954026',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'aksi' => 0,
    'fulldomain' => 0,
    'notifpesan' => 0,
    'berhasil' => 0,
    'login' => 0,
    'last' => 0,
    'cookname' => 0,
    'cookpass' => 0,
    'pesanhasil' => 0,
    'pesan' => 0,
    'a' => 0,
    'fbid' => 0,
    'twid' => 0,
    'gpid' => 0,
    'tw_token' => 0,
    'tw_secret' => 0,
    'daftarusername' => 0,
    'daftarname' => 0,
    'daftaremail' => 0,
    'daftaruserphonegsm' => 0,
    'title' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ea6319e21305_71954026')) {function content_61ea6319e21305_71954026($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php if ($_smarty_tpl->tpl_vars['aksi']->value=='daftar'||$_smarty_tpl->tpl_vars['aksi']->value=='daftaranggota'){?>
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/member.register.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }elseif($_smarty_tpl->tpl_vars['aksi']->value=='lupapassword'){?>
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/member/lupapassword.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
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

            <?php if ($_smarty_tpl->tpl_vars['notifpesan']->value!=''){?>
            <div class="alert <?php if ($_smarty_tpl->tpl_vars['berhasil']->value=='1'){?>  alert-success <?php }else{ ?> alert-danger<?php }?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo $_smarty_tpl->tpl_vars['notifpesan']->value;?>

            </div>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['login']->value==''){?>
			Bila anda sudah memiliki login di ansaniapremium.com, silahkan lanjutkan proses belanja anda dengan login terlebih dahulu<br clear="all" />
            
            <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/login" role="form" class="form-horizontal" method="post" name="login">
                <?php if ($_smarty_tpl->tpl_vars['last']->value!=''){?><input type="hidden" name="uri" value="<?php echo $_smarty_tpl->tpl_vars['last']->value;?>
" /><?php }?>
               <div class="form-group">
                   <div class="col-md-12">
                   <label class="control-label">Username :</label>
                       <input type="text" placeholder="Masukan Username atau Email" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['cookname']->value;?>
" name="user">
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-md-12">
                   <label class="control-label">Password :</label>
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
            <?php }?>
			Bila anda belum memiliki akun di ansaniapremium.com, silahkan daftarkan diri anda terlebih
            dahulu dengan melengkapi isian pendaftaran berikut ini.<br clear="all" /><br clear="all" />
            <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/register/registrasi" class="form-horizontal" method="post" name="registermember">
                <input type="hidden" name="register" value="1" />
                <?php if ($_smarty_tpl->tpl_vars['fbid']->value!=''){?><input type="hidden" name="fbcid" value="<?php echo $_smarty_tpl->tpl_vars['fbid']->value;?>
" /><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['twid']->value!=''){?><input type="hidden" name="twcid" value="<?php echo $_smarty_tpl->tpl_vars['twid']->value;?>
" /><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['gpid']->value!=''){?><input type="hidden" name="gpcid" value="<?php echo $_smarty_tpl->tpl_vars['gpid']->value;?>
" /><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['tw_token']->value!=''){?><input type="hidden" name="tw_token" value="<?php echo $_smarty_tpl->tpl_vars['tw_token']->value;?>
" /><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['tw_secret']->value!=''){?><input type="hidden" name="tw_secret" value="<?php echo $_smarty_tpl->tpl_vars['tw_secret']->value;?>
" /><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['last']->value!=''){?><input type="hidden" name="uri" value="<?php echo $_smarty_tpl->tpl_vars['last']->value;?>
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

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>