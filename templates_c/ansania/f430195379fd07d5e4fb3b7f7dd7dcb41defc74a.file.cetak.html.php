<?php /* Smarty version Smarty-3.1.13, created on 2022-04-09 12:30:05
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/cetak.html" */ ?>
<?php /*%%SmartyHeaderCode:131669990662510bcdb01433-15733094%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f430195379fd07d5e4fb3b7f7dd7dcb41defc74a' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/cetak.html',
      1 => 1645585020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '131669990662510bcdb01433-15733094',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'metakeyword' => 0,
    'title' => 0,
    'webdesc' => 0,
    'lokasiwebtemplate' => 0,
    'html' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_62510bcdb55175_31299887',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62510bcdb55175_31299887')) {function content_62510bcdb55175_31299887($_smarty_tpl) {?><!DOCTYPE html>
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
<?php }} ?>