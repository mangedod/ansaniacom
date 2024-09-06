<?php /* Smarty version Smarty-3.1.13, created on 2022-01-30 17:10:54
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/home/komentar.html" */ ?>
<?php /*%%SmartyHeaderCode:125856223061f6561e298253-47180579%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d4830de8bfbb697244ed547cd2d3fe59e1cfe78' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/home/komentar.html',
      1 => 1642674336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '125856223061f6561e298253-47180579',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lokasiwebtemplate' => 0,
    'uri' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61f6561e2a4725_89681955',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61f6561e2a4725_89681955')) {function content_61f6561e2a4725_89681955($_smarty_tpl) {?><div id="share"></div>
<script src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
js/jssocials.min.js"></script>
<script>
    $("#share").jsSocials({
        shares: ["facebook", "twitter", "googleplus", "whatsapp"]
    });
</script>
<br />
<br clear="all" />
<div class="bg-divider"></div>
<br clear="all" />
<div style="padding:10px">
<strong>Berikan Komentar Via Facebook</strong>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.10&appId=321539914595425';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-comments" data-href="<?php echo $_smarty_tpl->tpl_vars['uri']->value;?>
" data-width="100%" data-numposts="5"></div>

</div>
<?php }} ?>