<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 13:08:52
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/home/komentar.html" */ ?>
<?php /*%%SmartyHeaderCode:64211624261928b1fd45339-05293350%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f358d67e76a3b65f6cd701f1554bda64821553a1' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/home/komentar.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '64211624261928b1fd45339-05293350',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61928b1fd4f609_15201661',
  'variables' => 
  array (
    'lokasiwebtemplate' => 0,
    'uri' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61928b1fd4f609_15201661')) {function content_61928b1fd4f609_15201661($_smarty_tpl) {?><div id="share"></div>
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