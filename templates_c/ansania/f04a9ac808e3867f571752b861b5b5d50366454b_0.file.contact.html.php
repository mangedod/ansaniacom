<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:04:49
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/contact.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c511a51041_64452142',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f04a9ac808e3867f571752b861b5b5d50366454b' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/contact.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c511a51041_64452142 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
    
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
                    <?php if ($_smarty_tpl->tpl_vars['berhasil']->value == '1') {?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>

                        </div>
                    <?php } elseif ($_smarty_tpl->tpl_vars['berhasil']->value == '0') {?>
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $_smarty_tpl->tpl_vars['pesanhasil']->value;?>

                        </div>
                        <ul>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pesan']->value, 'i', false, 'id');
$_smarty_tpl->tpl_vars['i']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->do_else = false;
?>
                            <li><?php echo $_smarty_tpl->tpl_vars['i']->value['pesan'];?>
</li>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </ul>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['berhasil']->value != '1') {?>   
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

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
