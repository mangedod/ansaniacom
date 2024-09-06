<?php
/* Smarty version 4.3.0, created on 2024-03-27 05:59:27
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/product/product.list.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603b5bf4b9373_52484072',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8ab52286f726bba58c18874c950ca1d7a9073705' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/product/product.list.html',
      1 => 1647424590,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603b5bf4b9373_52484072 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="col-md-3">
                 
<form>
    <input value="<?php echo $_smarty_tpl->tpl_vars['xsecid']->value;?>
" name="xsecid" id="xsecid" type="hidden" />
    <input value="<?php echo $_smarty_tpl->tpl_vars['kata']->value;?>
" name="xkeyword" id="xkeyword" type="hidden" />
    <div class="box-filter">
     
        <div class="box-filter-judul">Tipe Produk</div>
        <div class="box-filter-isi">
            <ul>
                
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datajenis']->value, 'u', false, 'jenisid');
$_smarty_tpl->tpl_vars['u']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['jenisid']->value => $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->do_else = false;
?>
            <li class="filter-content-item">
                <input type="checkbox" class="filter filterjenisid" name="jenisid" value="<?php echo $_smarty_tpl->tpl_vars['u']->value['jenisid'];?>
" <?php if ($_smarty_tpl->tpl_vars['u']->value['selected'] == '1') {?> checked="checked"<?php }?>/> <?php echo $_smarty_tpl->tpl_vars['u']->value['nama'];?>

            </li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
              
           </ul>
        </div>
        <div class="box-filter-judul">Kategori</div>
        <div class="box-filter-isi">
            <ul>
                
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datasec']->value, 'u', false, 'secid');
$_smarty_tpl->tpl_vars['u']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['secid']->value => $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->do_else = false;
?>
            <li class="filter-content-item">
                <input type="checkbox" class="filter filtersecid" name="secid" value="<?php echo $_smarty_tpl->tpl_vars['u']->value['secid'];?>
" <?php if ($_smarty_tpl->tpl_vars['u']->value['selected'] == '1') {?> checked="checked"<?php }?>/> <?php echo $_smarty_tpl->tpl_vars['u']->value['nama'];?>

            </li>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
              
           </ul>
        </div>
       
         <div class="box-filter-judul">Kisaran Harga</div>
        <div class="box-filter-isi">
                <ul>
                   <li class="filter-content-item"><input type="radio" class="filter filterhargaid" name="hargaid" value="0" <?php if ($_smarty_tpl->tpl_vars['hargaid']->value == '0') {?> checked="checked"<?php }?> /> Semua Harga</li>
                   <li class="filter-content-item"><input type="radio" class="filter filterhargaid" name="hargaid" value="1" <?php if ($_smarty_tpl->tpl_vars['hargaid']->value == '1') {?> checked="checked"<?php }?>/> 0-10.000</li>
                   <li class="filter-content-item"><input type="radio"class="filter filterhargaid" name="hargaid" value="2" <?php if ($_smarty_tpl->tpl_vars['hargaid']->value == '2') {?> checked="checked"<?php }?> /> 10.000-25.000</li>
                   <li class="filter-content-item"><input type="radio"class="filter filterhargaid" name="hargaid" value="3" <?php if ($_smarty_tpl->tpl_vars['hargaid']->value == '3') {?> checked="checked"<?php }?> /> 25.000-50.000</li>
                   <li class="filter-content-item"><input type="radio"class="filter filterhargaid" name="hargaid" value="4" <?php if ($_smarty_tpl->tpl_vars['hargaid']->value == '4') {?> checked="checked"<?php }?> /> 50.000-100.000</li>
                   <li class="filter-content-item"><input type="radio"class="filter filterhargaid" name="hargaid" value="5" <?php if ($_smarty_tpl->tpl_vars['hargaid']->value == '5') {?> checked="checked"<?php }?> /> > 100.000</li>
               </ul>
           </ul>
        </div>
        
         <div class="box-filter-judul">Pilihan Warna</div>
        <div class="box-filter-isi">
            <div id="listResults">
            <div class="row">

            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['warna']->value, 'u', false, 'warnaid');
$_smarty_tpl->tpl_vars['u']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['warnaid']->value => $_smarty_tpl->tpl_vars['u']->value) {
$_smarty_tpl->tpl_vars['u']->do_else = false;
?>
             <div class="col-xs-3 text-center">
             <style type="text/css">
                 .warna-<?php echo $_smarty_tpl->tpl_vars['u']->value['warnaid'];?>
{background-color: <?php echo $_smarty_tpl->tpl_vars['u']->value['kode'];?>
;  border: 1px solid #ccc; border-color: #ccc;}
             </style>
              <div class="checkbox checkbox-circle warna-<?php echo $_smarty_tpl->tpl_vars['u']->value['warnaid'];?>
">
                <input id="warna-<?php echo $_smarty_tpl->tpl_vars['u']->value['warnaid'];?>
" type="checkbox" value='<?php echo $_smarty_tpl->tpl_vars['u']->value['warnaid'];?>
' class="filter filterwarnaid warna-<?php echo $_smarty_tpl->tpl_vars['u']->value['warnaid'];?>
" <?php if ($_smarty_tpl->tpl_vars['u']->value['selected'] == '1') {?> checked <?php }?>>
                <label></label>
              </div>
            </div>

            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>
        </div>
   </div>

  <?php echo '<script'; ?>
>
    
    $( ".filter" ).click(function() {
    
        var secid = $("#xsecid").val();
        var keyword = $("#xkeyword").val();
       
        
        
        var filterjenisid = "";
        $(".filterjenisid").each(function() {
            if($(this).is(':checked')) {
                filterjenisid = filterjenisid+$(this).val()+",";
            }
        });
        
        var filtersecid = "";
        $(".filtersecid").each(function() {
            if($(this).is(':checked')) {
                filtersecid = filtersecid+$(this).val()+",";
            }
        });
        
        var filterhargaid = "";
        $(".filterhargaid").each(function() {
            if($(this).is(':checked')) {
                filterhargaid = filterhargaid+$(this).val();
            }
        });
        
        
        var filterwarnaid = "";
        $(".filterwarnaid").each(function() {
             if($(this).is(':checked')) {
                filterwarnaid = filterwarnaid+$(this).val()+",";
             }

        });
        
         
        var filter = "/?keyword="+keyword+"&fjenisid="+filterjenisid+"&filterhargaid="+filterhargaid+"&fsecid="+filtersecid+"&fwarnaid="+filterwarnaid;
        var url = $(location).attr('href');
        var res = url.split("/?");
        var realurl = res[0];
        //var lasturl = realurl+filter;
        var lasturl = "<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product"+filter;
        window.location.href = lasturl;     
        
    });
    
    
    $( "#showr" ).click(function() {
       $( "#filter" ).show();
    });
     
    $( "#hidr" ).click(function() {
      $( "#filter" ).hide();
    });
    <?php echo '</script'; ?>
>
    
</div>

</div>
<div class="col-md-9">
    <div class="row">

        <?php if (!$_smarty_tpl->tpl_vars['list_post']->value) {?>
            <center>
                <img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/img.kosong.png" alt="Kosong">
                <br>Mohon maaf produk yang anda cari belum ditemukan, silahkan<br>
                pilih model atau warna yang lain
            </center>
        <?php } else { ?>

                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list_post']->value, 'p', false, 'produkid');
$_smarty_tpl->tpl_vars['p']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['produkid']->value => $_smarty_tpl->tpl_vars['p']->value) {
$_smarty_tpl->tpl_vars['p']->do_else = false;
?>
                   <div class="col-md-4">
                   		<div class="citem wow fadeIn">
                        <div class="cimg">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['p']->value['link_detail'];?>
" class="aimg">
                                  <img src="<?php echo $_smarty_tpl->tpl_vars['p']->value['image_m'];?>
" data-src="<?php echo $_smarty_tpl->tpl_vars['p']->value['image_m'];?>
" data-alt-src="<?php echo $_smarty_tpl->tpl_vars['p']->value['image_m1'];?>
" class="product-img" alt="<?php echo $_smarty_tpl->tpl_vars['p']->value['namaprod'];?>
">
                                  <!-- <?php if ($_smarty_tpl->tpl_vars['p']->value['misc_diskonn'] != '0') {?><div class="sticker sticker-sale">sale</div><?php }?> -->
                            </a>
                        </div>
                        <h5><a href="<?php echo $_smarty_tpl->tpl_vars['p']->value['link_detail'];?>
" class="black"><?php echo $_smarty_tpl->tpl_vars['p']->value['namaprod'];?>
</a></h5>
                       <div class="cost">
                            <?php if ($_smarty_tpl->tpl_vars['p']->value['misc_diskonn'] != '0') {?>
                            <del><?php echo $_smarty_tpl->tpl_vars['p']->value['price'];?>
</del>
                            <span class="new"><?php echo $_smarty_tpl->tpl_vars['p']->value['misc_diskon'];?>
</span>
                            <?php } else { ?>
                            <span class="new"><?php echo $_smarty_tpl->tpl_vars['p']->value['price'];?>
</span>
                            <?php }?>
                        </div>                        
                    </div>
                    </div>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

           <?php }?>


            </div>
          
              
        </div>
        <!-- /.container -->

        <!-- CONTAINER -->
        <div class="container">
            <div class="row">
                <div class="col-md-offset-7 col-xs-10 col-xs-offset-2 col-md-5 col-sm-offset-5 col-sm-7 text-right pagination-box">
                    <ul class="pagination">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['stringpage']->value, 'a', false, 'pageid');
$_smarty_tpl->tpl_vars['a']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pageid']->value => $_smarty_tpl->tpl_vars['a']->value) {
$_smarty_tpl->tpl_vars['a']->do_else = false;
?>
                            <?php if ($_smarty_tpl->tpl_vars['a']->value['link'] != '') {?>
                                <li class="<?php echo $_smarty_tpl->tpl_vars['a']->value['class'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a></li>
                            <?php } else { ?>
                                <li class="<?php echo $_smarty_tpl->tpl_vars['a']->value['class'];?>
"><a href="javascript:void(0)"><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</a></li>
                            <?php }?>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.container -->
        <div class="clearfix">&nbsp;</div>
<?php }
}
