<?php
/* Smarty version 4.3.0, created on 2024-03-27 06:00:26
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/cetak.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603b5fa7762e9_20241867',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c1ca2c7a992d2c847741d7e4bbcfc889412a0e8e' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/cetak.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603b5fa7762e9_20241867 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">

<head>
    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['metakeyword']->value;?>
" />
    <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['webdesc']->value;?>
">

    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
assets/css/bootstrap.min.css">

    <!-- Customizable CSS -->
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/cetak.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
css/print.css" media="print">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
assets/css/font-awesome.min.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
assets/images/favicon.png">


</head>

<body>
<div class="barcetak">
	<div class="container">
    <input type="button" class="btn btn-primary pull-right" value="Print Invoice" onClick="window.print()" />
    </div>
</div>
    
<div class="container">
<?php echo $_smarty_tpl->tpl_vars['html']->value;?>

</div>
<div class="barcetak">
	<div class="container">
    <input type="button" class="btn btn-primary pull-right" value="Print Invoice" onClick="window.print()" />
    </div>
</div>
</body>
</html>
<?php }
}
