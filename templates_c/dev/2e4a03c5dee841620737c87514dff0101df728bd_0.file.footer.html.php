<?php
/* Smarty version 4.3.0, created on 2023-02-14 00:13:35
  from 'http://localhost:8080/ansaniacom/public_html/template/dev/komponen/home/footer.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63ead22fc4e4e8_47693095',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2e4a03c5dee841620737c87514dff0101df728bd' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/dev/komponen/home/footer.html',
      1 => 1579346162,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63ead22fc4e4e8_47693095 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- FOOTER -->
<footer class="footer">

    <!-- CONTAINER -->
    <div class="container">
        <div class="row foorow-2 foorow">

             <div class="col-md-3 col-sm-6 col-xs-6">
                <h3>Ansania Collection</h3>
                <address>
                <?php echo $_smarty_tpl->tpl_vars['contactringkas']->value;?>

                <br>
                    <?php echo $_smarty_tpl->tpl_vars['contacttelp']->value;?>
<br>
                    <a href="mailto:<?php echo $_smarty_tpl->tpl_vars['contactemail']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['contactemail']->value;?>
</a><br>
                    <br>
                  
                </address>
            </div>
            
            <div class="col-md-2 col-sm-6 col-xs-6">
                <h3>Informasi</h3>
               <nav>
                    <ul class="links">
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/about">Tentang Kami</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/video">Galeri Video</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/termcondition">Terms and Conditions</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/privacypolicy">Kebijakan Privasi</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/disclaimer">Disclaimer</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/reseller">Menjadi Reseller</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/contact">Hubungi Kami</a></li>
                    </ul>
                </nav>
            </div>
              <div class="col-md-2 col-sm-6 col-xs-6">
                <h3>Pelanggan</h3>
               <nav>
                    <ul class="links">
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart">Keranjang Belanja</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member">Login Pelanggan</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/mnember/daftar">Pendaftaran Pelanggan</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/konfirmasi">Konfirmasi Pembayaran</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/faq">Bantuan Belanja</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/testimonial">Testimonial</a></li>
                    </ul>
                </nav>
            </div>

            <div class="col-md-2 col-sm-6 col-xs-6">
                <h3>Katalog Produk</h3>
               <nav>
                    <ul class="links">
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product">Katalog Produk</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product/bestdeal">Best Deal</a></li>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tipeproduk']->value, 'i', false, 'tipeid');
$_smarty_tpl->tpl_vars['i']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['tipeid']->value => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->do_else = false;
?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menusec']->value[$_smarty_tpl->tpl_vars['i']->value['tipeid']], 's', false, 'secid');
$_smarty_tpl->tpl_vars['s']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['secid']->value => $_smarty_tpl->tpl_vars['s']->value) {
$_smarty_tpl->tpl_vars['s']->do_else = false;
?>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['s']->value['url_sec'];?>
"><?php echo $_smarty_tpl->tpl_vars['s']->value['namasech'];?>
</a></li>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                       
                    </ul>
                </nav>
            </div>

           
            <div class="col-md-3 col-sm-6 col-xs-6">
                <h3>Terhubung</h3>
                Dapatkan informasi terbaru dengan terhubung
                sosial media kami.
                <ul class="social social-boxed">
                    <li class="facebook"><a href="http://www.facebook.com/<?php echo $_smarty_tpl->tpl_vars['webfacebook']->value;?>
" target=_blank><i class="fa fa-facebook"></i></a></li>
                    <li class="twitter"><a href="https://twitter.com/<?php echo $_smarty_tpl->tpl_vars['webtwitter']->value;?>
" target=_blank><i class="fa fa-twitter"></i></a></li>
                    <li class="youtube"><a href="https://www.youtube.com/<?php echo $_smarty_tpl->tpl_vars['contactyoutube']->value;?>
" target=_blank><i class="fa fa-youtube-play"></i></a></li>
                    <li class="instagram"><a href="https://www.instagram.com/<?php echo $_smarty_tpl->tpl_vars['contactig']->value;?>
" target=_blank><i class="fa fa-instagram"></i></a></li>
                </ul>
              
            </div>
        </div>
    </div>
    <!-- /.container -->
</footer>
<!-- /.footer -->

<!-- Popup: Login -->
<div class="block-popup popup plogin" id="login">
    <a href="" class="pclose small"><i class="custom-icon custom-icon-close-s"></i></a>
    <h3 class="text-center">Login to account</h3>

    <?php if ($_smarty_tpl->tpl_vars['notifpesan']->value != '') {?>
    <hr>
    <div class="alert <?php if ($_smarty_tpl->tpl_vars['berhasil']->value == '1') {?>  alert-success <?php } else { ?> alert-danger<?php }?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <?php echo $_smarty_tpl->tpl_vars['notifpesan']->value;?>

    </div>
    <hr>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['login']->value == '') {?>
        <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/login" class="loginform" method="post" name="login">
            <?php if ($_smarty_tpl->tpl_vars['last']->value != '') {?><input type="hidden" name="uri" value="<?php echo $_smarty_tpl->tpl_vars['last']->value;?>
" /><?php }?>
            <div class="formwrap">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Masukan Username atau Email" value="<?php echo $_smarty_tpl->tpl_vars['cookname']->value;?>
" name="user">
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control login-password" placeholder="Password" value="<?php echo $_smarty_tpl->tpl_vars['cookpass']->value;?>
" name="pass" id="login-password">
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-default block btn-validation">Login</button>
                <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/lupapassword">Forgot password?</a>
            </div>
        </form>
    <?php }?>
   
</div>
<!-- /.popup -->


<!-- ScrollTop Button -->
<a href="#" class="scrolltop">
    <i class="custom-icon custom-icon-scrolltop"></i>
</a>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jquery-2.1.1.min.js"><?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['kanal']->value == 'contact') {
echo '<script'; ?>
 async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA89-Oe9NGsEYYqGCrjBnYmaQYIBgu91Hg">
    <?php echo '</script'; ?>
>
<?php }
echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['kanal']->value == 'cart' && $_smarty_tpl->tpl_vars['aksi']->value == 'confirm') {?>

<?php }
echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jquery.plugins.js"><?php echo '</script'; ?>
>

        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jssocials.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
>
            $("#share").jsSocials({
               shares: ["facebook", "twitter", "googleplus", "whatsapp"]
            });
        <?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/moment.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/bootstrap-datepicker/js/bootstrap-datepicker.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/bootstrap-datepicker/locales/bootstrap-datepicker.en-IE.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/holder.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/wow.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/custom.js"><?php echo '</script'; ?>
>

 <?php echo '<script'; ?>
>
    wow = new WOW(
      {
        animateClass: 'animated',
        offset:       100
      }
    );
    wow.init();
  <?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-36866276-17', 'auto');
	  ga('send', 'pageview');
	
	<?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 async data-id="5782" src="https://cdn.widgetwhats.com/script.min.js"><?php echo '</script'; ?>
>
    <!--
	<?php echo '<script'; ?>
 type="text/javascript">
    window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
    d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
    _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
    $.src="//v2.zopim.com/?3blmYqTU7tfYH99zFl83tDWnYxnWVtnT";z.t=+new Date;$.
    type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
    <?php echo '</script'; ?>
>
    <!--End of Zopim Live Chat Script-->
    
</body>
</html><?php }
}
