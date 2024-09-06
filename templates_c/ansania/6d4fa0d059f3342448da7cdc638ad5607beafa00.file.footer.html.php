<?php /* Smarty version Smarty-3.1.13, created on 2022-01-30 22:45:58
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/home/footer.html" */ ?>
<?php /*%%SmartyHeaderCode:142756532961e93cacc7a3c5-83969241%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d4fa0d059f3342448da7cdc638ad5607beafa00' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/home/footer.html',
      1 => 1643554187,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '142756532961e93cacc7a3c5-83969241',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61e93cacd00ce1_69020415',
  'variables' => 
  array (
    'fulldomain' => 0,
    'productsec' => 0,
    's' => 0,
    'webfacebook' => 0,
    'webtwitter' => 0,
    'contactyoutube' => 0,
    'contactig' => 0,
    'notifpesan' => 0,
    'berhasil' => 0,
    'login' => 0,
    'last' => 0,
    'cookname' => 0,
    'cookpass' => 0,
    'kanal' => 0,
    'lokasiwebtemplate' => 0,
    'aksi' => 0,
    'alert' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61e93cacd00ce1_69020415')) {function content_61e93cacd00ce1_69020415($_smarty_tpl) {?><!-- FOOTER -->
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
                        <?php  $_smarty_tpl->tpl_vars['s'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['s']->_loop = false;
 $_smarty_tpl->tpl_vars['secid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['productsec']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['s']->key => $_smarty_tpl->tpl_vars['s']->value){
$_smarty_tpl->tpl_vars['s']->_loop = true;
 $_smarty_tpl->tpl_vars['secid']->value = $_smarty_tpl->tpl_vars['s']->key;
?>
                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['s']->value['urlsec'];?>
"><?php echo $_smarty_tpl->tpl_vars['s']->value['namasec'];?>
</a></li>
                            <?php } ?>
                                       
                    </ul>
                </nav>
            </div>

           
            <div class="col-md-3 col-sm-6 col-xs-12">
                <h3>Terhubung</h3>
                <span class="hidden-xs">Dapatkan informasi terbaru dengan terhubung
                sosial media kami.<br clear="all" /></span>
                <ul class="social social-boxed">
                    <li class="facebook"><a href="http://www.facebook.com/<?php echo $_smarty_tpl->tpl_vars['webfacebook']->value;?>
" target=_blank><i class="fab fa-facebook"></i></a></li>
                    <li class="twitter"><a href="https://twitter.com/<?php echo $_smarty_tpl->tpl_vars['webtwitter']->value;?>
" target=_blank><i class="fab fa-twitter"></i></a></li>
                    <li class="youtube"><a href="https://www.youtube.com/<?php echo $_smarty_tpl->tpl_vars['contactyoutube']->value;?>
" target=_blank><i class="fab fa-youtube"></i></a></li>
                    <li class="instagram"><a href="https://www.instagram.com/<?php echo $_smarty_tpl->tpl_vars['contactig']->value;?>
" target=_blank><i class="fab fa-instagram"></i></a></li>
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

    <?php if ($_smarty_tpl->tpl_vars['notifpesan']->value!=''){?>
    <hr>
    <div class="alert <?php if ($_smarty_tpl->tpl_vars['berhasil']->value=='1'){?>  alert-success <?php }else{ ?> alert-danger<?php }?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <?php echo $_smarty_tpl->tpl_vars['notifpesan']->value;?>

    </div>
    <hr>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['login']->value==''){?>
        <form action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/login" class="loginform" method="post" name="login">
            <?php if ($_smarty_tpl->tpl_vars['last']->value!=''){?><input type="hidden" name="uri" value="<?php echo $_smarty_tpl->tpl_vars['last']->value;?>
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

	
    <?php if ($_smarty_tpl->tpl_vars['kanal']->value=='contact'){?>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA89-Oe9NGsEYYqGCrjBnYmaQYIBgu91Hg">
        </script>
    <?php }?>
    <script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/bootstrap.min.js"></script>
    <?php if ($_smarty_tpl->tpl_vars['kanal']->value=='cart'||$_smarty_tpl->tpl_vars['aksi']->value=='confirm'){?>
    	
       <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jquery.basictable.min.js"></script>
	   <script>
		$("#table-cart").basictable({
			breakpoint: 768,
		});
		</script>

    <?php }?>
    <script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jquery.plugins.js"></script>

	<script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jssocials.js"></script>
    <script>
        $("#share").jsSocials({
           shares: ["facebook", "twitter", "googleplus", "whatsapp"]
        });
    </script>
	<script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/moment.min.js"></script>
    <script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/bootstrap-datepicker/locales/bootstrap-datepicker.en-IE.min.js"></script>
    
    <script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/sweetalert.min.js"></script>
	<script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/holder.js"></script>
    <script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/wow.js"></script>
    <script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/custom.js"></script>
     <?php if ($_smarty_tpl->tpl_vars['alert']->value!=''){?>
    	<script>
			swal('<?php echo $_smarty_tpl->tpl_vars['alert']->value;?>
');
		</script>
    <?php }?>
    
     <script>
	 
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
		
      </script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XGDVNTNV84"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-XGDVNTNV84');
</script>

    
</body>
</html><?php }} ?>