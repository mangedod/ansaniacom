<?php
/* Smarty version 4.3.0, created on 2024-03-27 12:24:22
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/lupapassword.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_66040ff62b3260_21765378',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '69e6cebdef9346e0ae5f6ec44babcbd2c28e7261' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/member/lupapassword.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66040ff62b3260_21765378 (Smarty_Internal_Template $_smarty_tpl) {
?>     <!-- HOME -->
    <div class="overlay home small-medium-size">
        <div class="bg bg-shop"></div>
        <div class="container vmiddle">
            <div class="row text-center text-title-list">
                <h1 class="text-uppercase" style="font-size: 50px">MY Account</h1>
                <h4>Forgot Password Account</h4>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <div class="container">
        <div class="row">
           <div class="col-md-6 col-md-offset-3">
           <h3 class="text-center">Forgot Password</h3>
            <?php if ($_smarty_tpl->tpl_vars['pesanhasil']->value != '') {?>
              <div class="alert <?php if ($_smarty_tpl->tpl_vars['berhasil']->value == '1') {?>  alert-success <?php } else { ?> alert-danger<?php }?> alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>

              </div>
            <?php } else { ?>
              <p>Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.</p>
            <?php }?>
           <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/lupapassword" method="post" role="form" class="form-horizontal">
               <div class="form-group">
                   <div class="col-md-12">
                   <label class="control-label">Username :</label>
                       <input type="text" name="userName"  value="<?php echo $_smarty_tpl->tpl_vars['daftarusername']->value;?>
" class="form-control">
                   </div>
               </div>
               <div class="form-group">
                   <div class="col-md-12">
                   <label class="control-label">Email address :</label>
                       <input type="text" name="userEmail"  value="<?php echo $_smarty_tpl->tpl_vars['daftaremail']->value;?>
" class="form-control">
                   </div>
               </div>
        
               <div class="form-group">
                   
                   <div class="col-md-6">
                   </div>
                   <div class="col-md-6 text-right">
                       <button class="btn btn-primary" type="submit">Reset Password</button>
                   </div>
               </div>
           </form>
                
           </div>
        </div>
    </div><?php }
}
