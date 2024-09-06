<?php
/* Smarty version 4.3.0, created on 2024-03-27 14:38:32
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/home/footer.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_66042f68399951_20219954',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '32bfed72069d0923defd7f42aee78cebbdf786b6' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/home/footer.html',
      1 => 1711550310,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66042f68399951_20219954 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- FOOTER -->
<footer class="footer"> 

    <!-- CONTAINER -->
    <div class="container">
        <div class="row foorow-2 foorow">

            <div class="col-md-3 col-sm-6 col-xs-6">
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
/disclaimer">Disclaimer</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/contact">Hubungi Kami</a></li>
                    </ul>
                </nav>
            </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
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

            <div class="col-md-3 col-sm-6 col-xs-6 hidden-xs">
                <h3>Katalog Produk</h3>
               <nav>
                    <ul class="links">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['productsec']->value, 's', false, 'secid');
$_smarty_tpl->tpl_vars['s']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['secid']->value => $_smarty_tpl->tpl_vars['s']->value) {
$_smarty_tpl->tpl_vars['s']->do_else = false;
?>
                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['s']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['s']->value['namasec'];?>
</a></li>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                       
                    </ul>
                </nav>
            </div>

           
            <div class="col-md-3 col-sm-6 col-xs-12">
                <h3>Terhubung</h3>
                <span class="hidden-xs">Dapatkan informasi terbaru dengan terhubung
                sosial media kami.<br clear="all" /></span>
                <ul class="social social-boxed">
                    <li class="facebook"><a href="http://www.facebook.com/<?php echo $_smarty_tpl->tpl_vars['webfacebook']->value;?>
" target=_blank><img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.facebook.png"></a></li>
                    <li class="twitter"><a href="https://tiktok.com/<?php echo $_smarty_tpl->tpl_vars['webtiktok']->value;?>
" target=_blank><img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.tiktok.png"></a></li>
                    <li class="youtube"><a href="https://www.youtube.com/<?php echo $_smarty_tpl->tpl_vars['webyoutube']->value;?>
" target=_blank><img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.youtube.png"></a></li>
                    <li class="instagram"><a href="https://www.instagram.com/<?php echo $_smarty_tpl->tpl_vars['webinstagram']->value;?>
" target=_blank><img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.instagram.png"></a></li>
                </ul>
              
            </div>
        </div>
    </div>
    <!-- /.container -->
    <div class="footer-bottom">
    	<div class="container">
        &copy; Ansania Indonesia 2022
        </div>
    </div>
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

	
    <?php if ($_smarty_tpl->tpl_vars['kanal']->value == 'contact') {?>
    <?php echo '<script'; ?>
 async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA89-Oe9NGsEYYqGCrjBnYmaQYIBgu91Hg">
        <?php echo '</script'; ?>
>
    <?php }?>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/bootstrap.min.js"><?php echo '</script'; ?>
>
    <?php if ($_smarty_tpl->tpl_vars['kanal']->value == 'cart' || $_smarty_tpl->tpl_vars['aksi']->value == 'confirm') {?>
    	
       <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jquery.basictable.min.js"><?php echo '</script'; ?>
>
	   <?php echo '<script'; ?>
>
		$("#table-cart").basictable({
			breakpoint: 768,
		});
		<?php echo '</script'; ?>
>

    <?php }?>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jquery.plugins.js"><?php echo '</script'; ?>
>

	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jssocials.js"><?php echo '</script'; ?>
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
js/sweetalert.min.js"><?php echo '</script'; ?>
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
     <?php if ($_smarty_tpl->tpl_vars['alert']->value != '') {?>
    	<?php echo '<script'; ?>
>
			swal('<?php echo $_smarty_tpl->tpl_vars['alert']->value;?>
');
		<?php echo '</script'; ?>
>
    <?php }?>
    
     <?php echo '<script'; ?>
>
	 
		 $(document).ready(function(){
		 
			 $(".aimg").hover(
				function() {
					var $img = $(this).find('img');
					var newSource = $img.data('alt-src');
					$img.attr("src", newSource);
				},
				function() {
					var $img = $(this).find('img');
					var newSource = $img.data('src');
					$img.attr("src", newSource);
				}
			);
		});


        wow = new WOW(
          {
            animateClass: 'animated',
            offset:       100
          }
        );
        wow.init();
		
      <?php echo '</script'; ?>
>

  <!-- Global site tag (gtag.js) - Google Analytics -->
<?php echo '<script'; ?>
 async src="https://www.googletagmanager.com/gtag/js?id=G-XGDVNTNV84"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-XGDVNTNV84');
<?php echo '</script'; ?>
>

    
</body>
</html><?php }
}
