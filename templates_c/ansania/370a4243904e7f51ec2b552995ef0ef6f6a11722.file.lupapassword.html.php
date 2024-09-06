<?php /* Smarty version Smarty-3.1.13, created on 2022-01-23 09:42:36
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/lupapassword.html" */ ?>
<?php /*%%SmartyHeaderCode:53198802361ecb28c61c581-30875107%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '370a4243904e7f51ec2b552995ef0ef6f6a11722' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/member/lupapassword.html',
      1 => 1642674336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '53198802361ecb28c61c581-30875107',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pesanhasil' => 0,
    'berhasil' => 0,
    'fulldomain' => 0,
    'daftarusername' => 0,
    'daftaremail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ecb28c671265_22445109',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ecb28c671265_22445109')) {function content_61ecb28c671265_22445109($_smarty_tpl) {?>     <!-- HOME -->
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
            <?php if ($_smarty_tpl->tpl_vars['pesanhasil']->value!=''){?>
              <div class="alert <?php if ($_smarty_tpl->tpl_vars['berhasil']->value=='1'){?>  alert-success <?php }else{ ?> alert-danger<?php }?> alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>

              </div>
            <?php }else{ ?>
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
    </div><?php }} ?>