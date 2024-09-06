<?php /* Smarty version Smarty-3.1.13, created on 2022-02-24 02:35:23
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/lupapassword.html" */ ?>
<?php /*%%SmartyHeaderCode:120834683461928c4d2038c0-76138108%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a43517c2ccda2748607df0ca14747d074e2b57d2' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/member/lupapassword.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '120834683461928c4d2038c0-76138108',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61928c4d2b8386_43956333',
  'variables' => 
  array (
    'pesanhasil' => 0,
    'berhasil' => 0,
    'fulldomain' => 0,
    'daftarusername' => 0,
    'daftaremail' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61928c4d2b8386_43956333')) {function content_61928c4d2b8386_43956333($_smarty_tpl) {?>     <!-- HOME -->
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