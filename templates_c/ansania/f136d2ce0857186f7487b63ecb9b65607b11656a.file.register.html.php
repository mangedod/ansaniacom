<?php /* Smarty version Smarty-3.1.13, created on 2022-03-17 22:20:22
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/register.html" */ ?>
<?php /*%%SmartyHeaderCode:678287562619f0bb8db8348-99253755%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f136d2ce0857186f7487b63ecb9b65607b11656a' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/register.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '678287562619f0bb8db8348-99253755',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_619f0bb8e774a0_10908656',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'pesanhasil' => 0,
    'berhasil' => 0,
    'pesan' => 0,
    'a' => 0,
    'fulldomain' => 0,
    'fbid' => 0,
    'twid' => 0,
    'gpid' => 0,
    'tw_token' => 0,
    'tw_secret' => 0,
    'last' => 0,
    'daftarusername' => 0,
    'daftarname' => 0,
    'daftaremail' => 0,
    'daftaruserphonegsm' => 0,
    'title' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_619f0bb8e774a0_10908656')) {function content_619f0bb8e774a0_10908656($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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

</div>
<!-- /.wrapper -->

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>