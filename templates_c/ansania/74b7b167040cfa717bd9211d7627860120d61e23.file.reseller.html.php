<?php /* Smarty version Smarty-3.1.13, created on 2023-02-13 23:52:08
         compiled from "http://localhost:8080/ansaniacom/public_html/template/ansania/reseller.html" */ ?>
<?php /*%%SmartyHeaderCode:159148692263eacd2895ede1-92064254%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '74b7b167040cfa717bd9211d7627860120d61e23' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/reseller.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '159148692263eacd2895ede1-92064254',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'fulldomain' => 0,
    'detaillengkap' => 0,
    'pesanhasil' => 0,
    'berhasil' => 0,
    'pesan' => 0,
    'a' => 0,
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
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_63eacd289b6513_66172118',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_63eacd289b6513_66172118')) {function content_63eacd289b6513_66172118($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

   <div class="container kanal">
       <div class="row">
            <div class="col-md-12"> 
                <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                   <li class="active" ><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/reseller">Reseller</a></li>
                </ol>             
                
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>RESELLER ANSANIA</h1>
       </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
             	<div class="text-faq"><?php echo $_smarty_tpl->tpl_vars['detaillengkap']->value;?>
</div>
            
            </div>
           <div class="col-md-6">
            <div class="panel panel-primary bordered">
            <div class="panel-body">
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
          <?php if ($_smarty_tpl->tpl_vars['berhasil']->value!='1'){?>
            <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/reseller/registrasi" class="form-horizontal" method="post" name="registermember">
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
                   <div class="col-md-8 col-md-offset-4"><button class="btn btn-primary" type="submit">Daftar Menjadi Reseller</button></div>
               </div>
            </form>
            <?php }?>
            
            </div>
        </div>
           </div>
        </div>
    </div>

</div>
<!-- /.wrapper -->

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>