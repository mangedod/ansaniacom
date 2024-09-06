<?php
/* Smarty version 4.3.0, created on 2024-03-27 06:04:48
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/blog/blog.read.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603b700e6a095_80710949',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1d0fb288abe44331b8cd829ea5712aad1bf20407' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/blog/blog.read.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603b700e6a095_80710949 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage":{
      "@type":"WebPage",
      "@id":"<?php echo $_smarty_tpl->tpl_vars['uri']->value;?>
"
    },
    "headline": "<?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
",
    "image": {
      "@type": "ImageObject",
      "url": "<?php echo $_smarty_tpl->tpl_vars['detailgambar']->value;?>
",
      "height": 800,
      "width": 800
    },
    "datePublished": "<?php echo $_smarty_tpl->tpl_vars['detaildate']->value;?>
",
    "dateModified": "<?php echo $_smarty_tpl->tpl_vars['detaildate']->value;?>
",
    "author": {
      "@type": "Person",
       "name": "<?php if ($_smarty_tpl->tpl_vars['detailcreator']->value == '') {?>Adi Sumaryadi<?php } else {
echo $_smarty_tpl->tpl_vars['detailcreator']->value;
}?>"
    },
    "publisher": {
      "@type": "Organization",
      "name": "<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
",
      "logo": {
        "@type": "ImageObject",
        "url": "<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.logo.png",
        "width": 253,
        "height": 49
      }
    },
    "description": "<?php echo $_smarty_tpl->tpl_vars['detaillengkap']->value;?>
"
  }
  <?php echo '</script'; ?>
>
<div class="container">
	<div class="row">
        <div class="col-md-8">
            	<div class="img-detail mt-20" style="height:auto">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['detailgambar']->value;?>
" style="width:100%" alt="<?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
" />
                </div>
            	<div class="title-headline">
                    <h1 itemprop='headline'><?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
</h1>
                </div>
                 <div class="detail-info">
                   <?php if ($_smarty_tpl->tpl_vars['detailcreator']->value != '') {?>Oleh <span itemprop='author' itemscope='itemscope' itemtype='http://schema.org/Person'><span itemprop='name'><?php echo $_smarty_tpl->tpl_vars['detailcreator']->value;?>
</span></span> | <?php }?> <?php echo $_smarty_tpl->tpl_vars['detailtanggal']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['detailviews']->value;?>
 Views
                   <span itemprop='datePublished' title='<?php echo $_smarty_tpl->tpl_vars['detaildate']->value;?>
' style="display:none"><?php echo $_smarty_tpl->tpl_vars['detaildate']->value;?>
</span>
                   <span itemprop='dateModified' title='<?php echo $_smarty_tpl->tpl_vars['detaildate']->value;?>
' style="display:none"><?php echo $_smarty_tpl->tpl_vars['detaildate']->value;?>
</span>
                </div>
                
                
                 <div class="box-content" itemprop='blogPost' itemscope='itemscope' itemtype='http://schema.org/BlogPosting'>
                    <div class="large-content">
                        <p class="lengkap" itemprop='description articleBody'><?php echo $_smarty_tpl->tpl_vars['detaillengkap']->value;?>
</p>
                        <span itemprop='publisher' style="display:none"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</span>
                        
                        <div class="tags" itemprop="keywords">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tags']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
                        	<a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['url'];?>
" class="tags"><?php echo $_smarty_tpl->tpl_vars['a']->value['tag'];?>
</a>&nbsp;
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?></div>
                        
                      <br clear="all" />
                    <hr />
                        <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/komentar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                    </div>
            </div>
             
             
             <br clear="all" />
            <div class="infodetail"><span class="infodetail-1"><strong><?php echo $_smarty_tpl->tpl_vars['rubrik']->value;?>
 Lainnya</strong></span></div>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['terkait']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
                 <div class="col-md-12">
                 <div class="boxnewspilihan">
                    <div class="boxnewspilihan-isi">
                        <div class="box-boxnewspilihan">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['url'];?>
" class="judul1"><img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['gambar'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
" border="0" /></a>
                        </div>
                        <span><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['url'];?>
" class="judul1"><strong><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</strong></a></span><br />
                        <?php echo $_smarty_tpl->tpl_vars['a']->value['ringkas'];?>

                    </div>
                </div>
                </div>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?><br clear="all" />
	

            </div>    
            

<div class="col-md-4" style="margin-top:-20px;">
<br clear="all" />
<div class="panel panel-dark blog-category">
    <div class="panel-heading">
        <h3 class="panel-title">BLOG TERPOPULER</h3>
    </div>
    <div class="panel-body">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datapopuler']->value, 'a', false, 'id');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
            <div class="blog-populer-item">
                <div class="blog-populer-item-img">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['gambar'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
" />
                </div>
               <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a>
            </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </div>
</div>

</div>
</div>
<br clear="all" /><?php }
}
