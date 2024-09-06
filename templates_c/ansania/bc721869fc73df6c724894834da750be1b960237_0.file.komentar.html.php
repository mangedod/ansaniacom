<?php
/* Smarty version 4.3.0, created on 2024-03-27 06:04:48
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/home/komentar.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603b700e79653_34144869',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bc721869fc73df6c724894834da750be1b960237' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/home/komentar.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603b700e79653_34144869 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="share"></div>
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
<br />
<br clear="all" />
<div class="bg-divider"></div>
<br clear="all" />
<div style="padding:10px">
<strong>Berikan Komentar Via Facebook</strong>

<div id="fb-root"></div>
<?php echo '<script'; ?>
>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.10&appId=321539914595425';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));<?php echo '</script'; ?>
>

<div class="fb-comments" data-href="<?php echo $_smarty_tpl->tpl_vars['uri']->value;?>
" data-width="100%" data-numposts="5"></div>

</div>
<?php }
}
