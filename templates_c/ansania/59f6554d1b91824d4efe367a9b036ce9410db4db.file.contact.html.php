<?php /* Smarty version Smarty-3.1.13, created on 2022-01-22 18:34:15
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/contact.html" */ ?>
<?php /*%%SmartyHeaderCode:14055578561ebdda79006e8-68337645%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '59f6554d1b91824d4efe367a9b036ce9410db4db' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/contact.html',
      1 => 1642674337,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14055578561ebdda79006e8-68337645',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'contactalamat11' => 0,
    'contactemail' => 0,
    'contactemail_support' => 0,
    'contactgsm' => 0,
    'webfacebook' => 0,
    'contactig' => 0,
    'webtwitter' => 0,
    'berhasil' => 0,
    'pesanhasil' => 0,
    'pesan' => 0,
    'i' => 0,
    'fulldomain' => 0,
    'kodegen' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ebdda7996e42_66299465',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ebdda7996e42_66299465')) {function content_61ebdda7996e42_66299465($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    
    <!-- CONTENT -->
    <div class="content">

        <!-- CONTACT-map -->
        <div class="contact-map">
            <div id="contact-map"></div>
        </div>

        <!-- CONTAINER -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center text-uppercase text-title">Contact us</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                <div class="contact-list">
                    <p><i class="fa fa-map-marker"></i> <?php echo $_smarty_tpl->tpl_vars['contactalamat11']->value;?>
</p>
                    <p>
                        <i class="fa fa-envelope"></i> <?php echo $_smarty_tpl->tpl_vars['contactemail']->value;?>
 <br>
                        <?php echo $_smarty_tpl->tpl_vars['contactemail_support']->value;?>

                    </p>
                    <p>
                        <i class="fa fa-phone"></i> <?php echo $_smarty_tpl->tpl_vars['contactgsm']->value;?>

                    </p>
                    <p>
                        <i class="fa fa-facebook"></i> <?php echo $_smarty_tpl->tpl_vars['webfacebook']->value;?>

                    </p>
                    <p>
                        <i class="fa fa-instagram"></i> <?php echo $_smarty_tpl->tpl_vars['contactig']->value;?>

                    </p>
                    <p>
                        <i class="fa fa-twitter"></i> <?php echo $_smarty_tpl->tpl_vars['webtwitter']->value;?>

                    </p>
                </div>
                </div>
                <div class="col-sm-7 col-sm-offset-1">
                    <?php if ($_smarty_tpl->tpl_vars['berhasil']->value=='1'){?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>

                        </div>
                    <?php }elseif($_smarty_tpl->tpl_vars['berhasil']->value=='0'){?>
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>

                        </div>
                        <ul>
                            <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['pesan']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
                            <li><?php echo $_smarty_tpl->tpl_vars['i']->value['pesan'];?>
</li>
                            <?php } ?>
                        </ul>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['berhasil']->value!='1'){?>   
                    <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/contact" role="form" class="form-horizontal" method="post">
                        <input type="hidden" name="action" value="savepesan" />
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="firstname" placeholder="First Name">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="useremail" placeholder="Email">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" nama="phone" placeholder="Phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea name="pesan" id="pesan" cols="30" rows="10" placeholder="Message"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="secure-codebox">
                                    <img id="siimage" align="left" style="padding-right: 0px; margin-bottom: 11px;" src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/librari/captcha/securimage_show.php?sid=<?php echo $_smarty_tpl->tpl_vars['kodegen']->value;?>
" />
                                   	<a class="recaptcha-reload" tabindex="-1" style="border-style: none; float:left; margin-top: 25px;margin-left: 12px;" href="#" title="Refresh Code" onclick="document.getElementById('siimage').src = '<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/librari/captcha/securimage_show.php?sid=' + Math.random(); return false">[Refresh]</a>
                                </div>
                                <div class="col-md-6">
                                	<input class="input-text" name="code" id="scode" type="text" placeholder="Enter Code" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-9 text-right col-sm-4 col-sm-offset-8">
                                 <button type="submit" class="btn btn-primary btn-wd btn-block">Send</button>
                            </div>
                        </div>
                    </form>
                    <?php }?>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content -->
</div>
<!-- /.wrapper -->

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>