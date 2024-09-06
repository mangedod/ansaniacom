<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 13:08:52
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/blog/blog.read.html" */ ?>
<?php /*%%SmartyHeaderCode:3960256261928b1fa28293-84769631%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7ff4f5f8993481e684e937bc289d318eb1825260' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/blog/blog.read.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3960256261928b1fa28293-84769631',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61928b1fd32a74_08199326',
  'variables' => 
  array (
    'uri' => 0,
    'detailnama' => 0,
    'detailgambar' => 0,
    'detaildate' => 0,
    'detailcreator' => 0,
    'title' => 0,
    'fulldomain' => 0,
    'lokasiwebtemplate' => 0,
    'detaillengkap' => 0,
    'detailtanggal' => 0,
    'detailviews' => 0,
    'tags' => 0,
    'a' => 0,
    'lokasitemplate' => 0,
    'rubrik' => 0,
    'terkait' => 0,
    'datapopuler' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61928b1fd32a74_08199326')) {function content_61928b1fd32a74_08199326($_smarty_tpl) {?><script type="application/ld+json">
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
       "name": "<?php if ($_smarty_tpl->tpl_vars['detailcreator']->value==''){?>Adi Sumaryadi<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['detailcreator']->value;?>
<?php }?>"
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
  </script>
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
                   <?php if ($_smarty_tpl->tpl_vars['detailcreator']->value!=''){?>Oleh <span itemprop='author' itemscope='itemscope' itemtype='http://schema.org/Person'><span itemprop='name'><?php echo $_smarty_tpl->tpl_vars['detailcreator']->value;?>
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
                        <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['tags']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
                        	<a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['url'];?>
" class="tags"><?php echo $_smarty_tpl->tpl_vars['a']->value['tag'];?>
</a>&nbsp;
                        <?php } ?></div>
                        
                      <br clear="all" />
                    <hr />
                        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/komentar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                    </div>
            </div>
             
             
             <br clear="all" />
            <div class="infodetail"><span class="infodetail-1"><strong><?php echo $_smarty_tpl->tpl_vars['rubrik']->value;?>
 Lainnya</strong></span></div>
                <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['terkait']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
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
                <?php } ?><br clear="all" />
	

            </div>    
            

<div class="col-md-4" style="margin-top:-20px;">
<br clear="all" />
<div class="panel panel-dark blog-category">
    <div class="panel-heading">
        <h3 class="panel-title">BLOG TERPOPULER</h3>
    </div>
    <div class="panel-body">
          <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datapopuler']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
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
        <?php } ?>
    </div>
</div>

</div>
</div>
<br clear="all" /><?php }} ?>