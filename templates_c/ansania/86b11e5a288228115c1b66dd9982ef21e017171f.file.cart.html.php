<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 13:37:33
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/cart.html" */ ?>
<?php /*%%SmartyHeaderCode:1565010657619286f326bbc4-10995098%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '86b11e5a288228115c1b66dd9982ef21e017171f' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/cart.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1565010657619286f326bbc4-10995098',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_619286f353bc24_51386379',
  'variables' => 
  array (
    'lokasitemplate' => 0,
    'kanal' => 0,
    'aksi' => 0,
    'fulldomain' => 0,
    'sukses' => 0,
    'message' => 0,
    'jumlah_keranjang' => 0,
    'transaksiid' => 0,
    'dt_keranjang' => 0,
    'a' => 0,
    'orderid' => 0,
    'total_subtotalxx' => 0,
    'kodevoucher' => 0,
    'namavoucher' => 0,
    'totaldiskon' => 0,
    'totaltagihanakhir' => 0,
    'email' => 0,
    'salah' => 0,
    'style' => 0,
    'login' => 0,
    'namapenerima' => 0,
    'hp' => 0,
    'datanegara' => 0,
    'j' => 0,
    'datapropinsi' => 0,
    'p' => 0,
    'datakota' => 0,
    'datakecamatan' => 0,
    'kodepos' => 0,
    'useraddress' => 0,
    'dataagen' => 0,
    'dataongkir' => 0,
    'databank' => 0,
    'lokasiwebtemplate' => 0,
    'totaldiskonn' => 0,
    'totalberat' => 0,
    'ongkoskirim' => 0,
    'detailproduk' => 0,
    'total_diskon' => 0,
    'namadiskon' => 0,
    'diskonnya' => 0,
    'kode_voucher' => 0,
    'total_diskon2' => 0,
    'ongkos_kirim' => 0,
    'totberat' => 0,
    'ongkos_kirim2' => 0,
    'totaltagihanakhird' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_619286f353bc24_51386379')) {function content_619286f353bc24_51386379($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php if ($_smarty_tpl->tpl_vars['kanal']->value=='cart'&&$_smarty_tpl->tpl_vars['aksi']->value=='confirm'){?>
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/cart/payment-confirmation.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php }elseif($_smarty_tpl->tpl_vars['kanal']->value=='cart'&&$_smarty_tpl->tpl_vars['aksi']->value=='save-confirm'){?>
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/cart/save-confirm.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php }elseif($_smarty_tpl->tpl_vars['kanal']->value=='cart'&&$_smarty_tpl->tpl_vars['aksi']->value=='detailinvoice'){?>
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/cart/detailinvoice.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php }elseif($_smarty_tpl->tpl_vars['kanal']->value=='cart'&&$_smarty_tpl->tpl_vars['aksi']->value=='tamu'){?>
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/cart/tamu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php }else{ ?>
    <div class="container kanal">
       <div class="row">
            <div class="col-md-12"> 
                <ol class="breadcrumb">
                   <li><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">Home</a></li>
                   <li class="active" ><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart">Keranjang Belanja</a></li>
                </ol>             
                
            </div>
       </div>
       <div class="text-left text-title-list">
            <h1>Keranjang Belanja</h1>
       </div>
    </div>
    <!-- CONTENT -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='finish'){?>
                    <?php if ($_smarty_tpl->tpl_vars['sukses']->value=='1'){?>
                        <center>
                            <div class="alert alert-success"><center><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</center></div>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/history" class="btn btn-warning">Lihat Histori Transaksi</a> </center>
                    <?php }else{ ?>
                        <center>
                            <div class="alert alert-danger"><center><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</center></div>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/history" class="btn btn-warning">Lihat Histori Transaksi</a> </center>
                     <?php }?>
                <?php }else{ ?>
                    <?php if ($_smarty_tpl->tpl_vars['jumlah_keranjang']->value!='0'){?>

                        <div class="cart-tab tab-product-detail">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="<?php if ($_smarty_tpl->tpl_vars['kanal']->value=='cart'&&($_smarty_tpl->tpl_vars['aksi']->value=='buy'||$_smarty_tpl->tpl_vars['aksi']->value=='')){?>  active<?php }?>"><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart/buy" aria-controls="shoppingcart" role="tab" >Shopping Cart</a></li>
                                <li role="presentation" class="<?php if ($_smarty_tpl->tpl_vars['aksi']->value=='checkout'){?>  active<?php }?>"><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart/checkout" aria-controls="shippingadd" role="tab" >Shipping&Payment</a></li>
                                <li role="presentation" class="<?php if ($_smarty_tpl->tpl_vars['aksi']->value=='invoice'||$_smarty_tpl->tpl_vars['aksi']->value=='response'){?>  active<?php }?>"><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart/invoice" aria-controls="summary" role="tab" >Summary</a></li>
                            </ul>

                            <div class="tab-content">
                            <?php if ($_smarty_tpl->tpl_vars['kanal']->value=='cart'&&($_smarty_tpl->tpl_vars['aksi']->value=='buy'||$_smarty_tpl->tpl_vars['aksi']->value=='')){?>
                                <div role="tabpanel" class="tab-pane p-0 <?php if ($_smarty_tpl->tpl_vars['kanal']->value=='cart'&&($_smarty_tpl->tpl_vars['aksi']->value=='buy'||$_smarty_tpl->tpl_vars['aksi']->value=='')){?>active<?php }?>" id="shoppingcart">
                                    
                                    <script type="text/javascript">
                                        function submitform()
                                        {
                                          document.myform.submit();
                                        }
                                        function number_format(num,dig,dec,sep) {
                                            x=new Array();
                                            s=(num<0?"-":"");
                                            num=Math.abs(num).toFixed(dig).split(".");
                                            r=num[0].split("").reverse();
                                            for(var i=1;i<=r.length;i++){x.unshift(r[i-1]);if(i%3==0&&i!=r.length)x.unshift(sep);}
                                            return s+x.join("")+(num[1]?dec+num[1]:"");
                                        }
                                        function getVoucher(kodevoucher,total_subtotal,orderid)
                                        {
                                            // alert ("ok " + total_subtotal);
                                            $("#hasilvoucher").innerHTML = "";
                                            jQuery.ajax({
                                               type: "POST",
                                               url: "<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/komponen/cart/diskon.php",
                                               data: 'kodevoucher='+ kodevoucher +'&&total_subtotal=' + total_subtotal +'&&orderid=' + orderid,
                                               cache: false,
                                               success: function(responsecek)
                                               {
                                                    if(responsecek)
                                                    {
                                                        /*$('#inline1').show();
                                                        $('#inline1').html("Add as Friend Succes.");
                                                        $('#various1').hide();*/
                                                        var des3    = responsecek.split('||');
                                                        var htmlnya3  = des3[0];
                                                        var subtotal  = des3[1];

                                                        var subtotal2 = "IDR " + number_format (subtotal, 0, ".", "." );
                                                        $("#hasilvoucher").html(htmlnya3);
                                                        $("#total_subtotal").val(subtotal);
                                                        $("#totalpembelian").html("<strong>"+subtotal2+"</strong>");

                                                        $.session.set("totalHarga", subtotal);
                                                        alert($.session.get("totalHarga"));
                                                        return false;
                                                    }
                                                    else
                                                    {
                                                        /*alert ("not ok " + kodevoucher + responsecek)
                                                        $('#inline1').show();
                                                        $('#inline1').html("Add as Friend Failed.");
                                                        return false;*/
                                                    }
                                                }
                                            });
                                        };
                                    </script>
                                    
                                    <table class="table table-bordered table-cart">
                                    <form name="myform" enctype="multipart/form-data" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart/buy/">
                                      <input type="hidden" value="1" name="update">
                                      <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['transaksiid']->value;?>
" name="transaksiid">

                                        <thead>
                                            <tr class="hidden-xs">
                                                <th>Produk</th>
                                                <th>Keterangan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Total</th>
                                            </tr>
                                             <tr class="visible-xs">
                                                <th>Item</th>
                                            </tr>
                                        </thead>
                                        <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dt_keranjang']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
                                            <tr>
                                                <td class="text-center hidden-xs">
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link_produk'];?>
">
                                                    <div class="cart-item-thumb img-thumbnail">
                                                        <img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_s'];?>
" class="img-responsive" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
">
                                                    </div>
                                                    </a>
                                                </td>
                                                <td class="hidden-xs"><span class="text-uppercase"><b><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</b></span> <br><span><b>Item Nomor </b><?php echo $_smarty_tpl->tpl_vars['a']->value['nomor'];?>
 </td>
                                                <td class="text-center hidden-xs">
                                                    <b><?php echo $_smarty_tpl->tpl_vars['a']->value['harga_asli'];?>
</b>
                                                </td>
                                                <td>
                                                	<span class="visible-xs"> 
                                                    	<span class="text-uppercase"><b><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</b></span> <br><span><b>Item Nomor </b><?php echo $_smarty_tpl->tpl_vars['a']->value['nomor'];?>
 <br />
                                                         <b><?php echo $_smarty_tpl->tpl_vars['a']->value['harga_asli'];?>
</b><br />
                                                         Subtotal: <b><?php echo $_smarty_tpl->tpl_vars['a']->value['subtotal'];?>
</b>
                                                         </span>
                                                    </span>
                                                     <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
" name="as" size="10">
                                                     <div class="input-group spinner" data-trigger="spinner">
                                                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
" name="id_qty" size="10">
                                                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['produkpostid'];?>
" name="kode_qty_<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
">
                                                        <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['qty'];?>
" name="qty_<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
" data-rule="quantity" style="width:50px">
                                                        <div class="input-group-addon">
                                                            <a href="javascript:;" class="spin-up" data-spin="up">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a href="javascript:;" class="spin-down" data-spin="down">
                                                                <i class="fa fa-minus"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <a onclick="submitform();">update</a> - 
                                                    <a  href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart/delete-buy/<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
">hapus</a>
                                                </td>
                                                <td class="text-center hidden-xs" ><b><?php echo $_smarty_tpl->tpl_vars['a']->value['subtotal'];?>
</b></td>
                                            </tr>
                                        <?php } ?>
       								</table>
                                    </form>
                                    
                                    <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart/checkout" >
                                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['orderid']->value;?>
" id="orderid" name="orderid">
                                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['total_subtotalxx']->value;?>
" id="total_subtotal" name="total_subtotal">
                                     <table class="table table-bordered table-cart">
                                        <tfoot>
                                            <tr>
                                                <td class="pull-right" align="right" >
                                                <div class="col-md-9 col-xs-6">Voucher Code :<br class="visible-xs" />
                                                <input data-placeholder="Enter the product code" name="kodevoucher" id="kodevoucher" type="text" style="width:65%" >
                                                
                                                	<a onclick="getVoucher(kodevoucher.value,total_subtotal.value,orderid.value);" class="btn btn-primary">Check</a>
                                                	</div>
                                                <br clear="all">
                                                  <span id="hasilvoucher" class="price">
                                                  <?php if ($_smarty_tpl->tpl_vars['kodevoucher']->value!=''){?>
                                                  <div class='alert alert-success'><?php echo $_smarty_tpl->tpl_vars['namavoucher']->value;?>
 (<strong><?php echo $_smarty_tpl->tpl_vars['kodevoucher']->value;?>
</strong>) <?php echo $_smarty_tpl->tpl_vars['totaldiskon']->value;?>
</div>
                                                  <?php }?>
                                                  </span>
                                                </td>
                                            </tr>
                                            <tr>
                                               
                                                <td >
                                                    <span id="totalpembelian" class="price pull-right"><b>Total: <?php echo $_smarty_tpl->tpl_vars['totaltagihanakhir']->value;?>
</b></span>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                        <button type="submit" class="btn btn-primary pull-right">Checkout &nbsp;<i class="fa fa-arrow-right"></i></button>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i> Pilih Lagi</a>
                                    </form>
                                </div>
                            <?php }elseif($_smarty_tpl->tpl_vars['kanal']->value=='cart'&&$_smarty_tpl->tpl_vars['aksi']->value=='checkout'){?>
                                <div role="tabpanel" class="tab-pane p-0 <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='checkout'){?>active<?php }?>" id="shippingadd">
                                
                                <script>
                                    function validasi_input(form){
                                      if (form.userfullname.value == ""){
                                        alert("Your full name is empty!");
                                        form.userfullname.focus();
                                        return (false);
                                      }
                                      else if (form.kecid.value == ""){
                                        alert("Districts cannot be empty!");
                                        form.kecid.focus();
                                        return (false);
                                      }
                                    return (true);
                                    }
                                </script>
                                
                                <form method="post" id="checkout-form" action="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart/invoice" class="form-horizontal" role="form" onsubmit="return validasi_input(this)">
                                    <input type="hidden" name="email" id="email" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
">
                                    <input type="hidden" name="domain" id="domain" value="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/">
                                    <input type="hidden" name="transaksiid" id="transaksiid" value="<?php echo $_smarty_tpl->tpl_vars['transaksiid']->value;?>
">
                                    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['orderid']->value;?>
" id="orderid" name="orderid">
                                    <table class="table table-bordered table-cart">
                                        <tbody>
                                            <tr>
                                                <td class="text-left" colspan="2">
                                                    <div class="row p-25">
                                                        <?php if ($_smarty_tpl->tpl_vars['salah']->value!=''){?>
                                                            <div class="alert <?php echo $_smarty_tpl->tpl_vars['style']->value;?>
">
                                                                <center><?php echo $_smarty_tpl->tpl_vars['salah']->value;?>
<br /><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/cart" class="btn btn-primary">Kembali</a></center>
                                                            </div>
                                                        <?php }?>
                                                        
                                                        <script type="text/javascript">
                                                            function tampil(data) {
                                                                if (data == "8") {
                                                                    $("#diambil").hide();
                                                                    // $("#dikirim").hide();
                                                                    // $("#tamong").hide();
                                                                    $("#metodep").show();
                                                                } else if (data == "Pickup Point") {
                                                                    $("#diambil").show();
                                                                    // $("#dikirim").hide();
                                                                    // $("#tamong").show();
                                                                    $("#metodep").show();
                                                                } else if (data != "Pickup Point") {
                                                                    $("#diambil").hide();
                                                                    // $("#dikirim").show();
                                                                    // $("#tamong").show();
                                                                    $("#metodep").show();
                                                                } else {
                                                                    $("#diambil").hide();
                                                                    // $("#dikirim").hide();
                                                                    // $("#tamong").show();
                                                                    $("#metodep").show();
                                                                }
                                                            }

                                                            function tampil2(data) {
                                                                if (data == "Transfer") {
                                                                    $("#transfer").show();
                                                                } else if (data != "Transfer") {
                                                                    $("#transfer").hide();
                                                                } else {
                                                                    $("#transfer").hide();
                                                                }
                                                            }

                                                            function tampildrop(data) {
                                                                if (data.checked) {
                                                                    $("#dropship").show();
                                                                } else {
                                                                    $("#dropship").hide();
                                                                }
                                                            }

                                                            function tampilbtn(data) {
                                                                if (data.checked) {
                                                                    $("#btn-notif").removeAttr("disabled");
                                                                } else {
                                                                    $("#btn-notif").attr("disable", true);
                                                                }
                                                            }
                                                        </script>
                                                        <style>
                                                            #dikirim {
                                                                display: none;
                                                            }
                                                            
                                                            #diambil {
                                                                display: none;
                                                            }
                                                            
                                                            #transfer {
                                                                display: none;
                                                            }
                                                            
                                                            #dropship {
                                                                display: none;
                                                            }
                                                        </style>
                                                        
                                                        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/librari/ajax/ajax_kota.js"></script>
                                                        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/librari/ajax/ajax_kec.js"></script>
                                                        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/librari/ajax/ajax_agen.js"></script>
                                                        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/librari/ajax/ajax_ongkos.js"></script>
                                                        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/librari/ajax/ajax_total.js"></script>
                                                        <?php if ($_smarty_tpl->tpl_vars['login']->value=='1'){?>
                                                            <div class="col-md-6">
                                                                <h4>Shipping Address</h4>
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <input type="text" name="userfullname" value="<?php echo $_smarty_tpl->tpl_vars['namapenerima']->value;?>
" id="nama-penerima" placeholder="Enter your name" required="required">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="text" name="userphonegsm" value="<?php echo $_smarty_tpl->tpl_vars['hp']->value;?>
" id="no-hp" placeholder="Enter your phone number" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <input type="text" name="useremail" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" id="" placeholder="Enter your email address" required="required">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <select name="negaraid" onchange="getNegara(this.value);" class="form-control" required="required">
                                                                            <option  value=""> Select Country </option>
                                                                            <?php  $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['j']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datanegara']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['j']->key => $_smarty_tpl->tpl_vars['j']->value){
$_smarty_tpl->tpl_vars['j']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['j']->key;
?>
                                                                            <option  value="<?php echo $_smarty_tpl->tpl_vars['j']->value['id'];?>
" <?php echo $_smarty_tpl->tpl_vars['j']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['j']->value['namanegara'];?>
</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <select name="propinsiid" id="propinsiid" class="form-control" onChange="getKota(this.value);" required="required">
                                                                            <option  value=""> Select Province </option>
                                                                            <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datapropinsi']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                                            <option  value="<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['namapropinsi'];?>
</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <select name="cityname" id="kotaId2" class="form-control" onChange="getKec(this.value);" required="required">
                                                                            <option  value=""> Select City  </option>
                                                                            <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['idkota'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datakota']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['idkota']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                                                <option value="<?php echo $_smarty_tpl->tpl_vars['p']->value['kotaid'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['namakota'];?>
</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <select name="kecid" id="kecid" class="form-control" onChange="getAgen(orderid.value,this.value);" required="required">
                                                                            <option  value=""> Select Districts </option>
                                                                            <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['kotaid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datakecamatan']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['kotaid']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                                                <option  value="<?php echo $_smarty_tpl->tpl_vars['p']->value['kecid'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['namakecamatan'];?>
</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="text" name="userpostcode" value="<?php echo $_smarty_tpl->tpl_vars['kodepos']->value;?>
" id="" placeholder="Enter your postal code" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <textarea name="useraddress" id="alamat" placeholder="Enter your full address" cols="30" rows="10"><?php echo $_smarty_tpl->tpl_vars['useraddress']->value;?>
</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php }else{ ?>
                                                            <div class="col-md-6">
                                                                <h4>Shipping Address</h4>
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <input type="text" name="userfullname" value="<?php echo $_smarty_tpl->tpl_vars['namapenerima']->value;?>
" id="nama-penerima" placeholder="Enter your name" required="required">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="text" name="userphonegsm" value="<?php echo $_smarty_tpl->tpl_vars['hp']->value;?>
" id="no-hp" placeholder="Enter your phone number" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <input type="text" name="useremail" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" id="" placeholder="Enter your email address" required="required">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <select name="negaraid" onchange="getNegara(this.value);" class="form-control" required="required">
                                                                            <option  value=""> Select Country </option>
                                                                            <?php  $_smarty_tpl->tpl_vars['j'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['j']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datanegara']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['j']->key => $_smarty_tpl->tpl_vars['j']->value){
$_smarty_tpl->tpl_vars['j']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['j']->key;
?>
                                                                            <option  value="<?php echo $_smarty_tpl->tpl_vars['j']->value['id'];?>
" <?php echo $_smarty_tpl->tpl_vars['j']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['j']->value['namanegara'];?>
</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <select name="propinsiid" id="propinsiid" class="form-control" onChange="getKota(this.value);" required="required">
                                                                            <option  value=""> Pilih Propinsi </option>
                                                                            <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datapropinsi']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                                            <option  value="<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['namapropinsi'];?>
</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <select name="cityname" id="kotaId2" class="form-control" onChange="getKec(this.value);" required="required">
                                                                            <option  value=""> Pilih Kota  </option>
                                                                            <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['idkota'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datakota']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['idkota']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                                                <option value="<?php echo $_smarty_tpl->tpl_vars['p']->value['kotaid'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['namakota'];?>
</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-6">
                                                                        <select name="kecid" id="kecid" class="form-control" onChange="getAgen(orderid.value,this.value);" required="required">
                                                                            <option  value=""> Pilih Kecamatan </option>
                                                                            <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['kotaid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['datakecamatan']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['kotaid']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                                                <option  value="<?php echo $_smarty_tpl->tpl_vars['p']->value['kecid'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['namakecamatan'];?>
</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="text" name="userpostcode" value="<?php echo $_smarty_tpl->tpl_vars['kodepos']->value;?>
" id="" placeholder="Masukan kode pos" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <textarea name="alamat" id="alamat" placeholder="Masukan alamat lengkap anda" cols="30" rows="10"><?php echo $_smarty_tpl->tpl_vars['useraddress']->value;?>
</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                        <div class="col-md-6">
                                                            <h4>Informasi Pengiriman</h4>
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <select name="pengiriman" id="pengiriman" class="form-control" onChange="getOngkir(kecid.value,orderid.value,this.value);tampil(this.value);" required="required">
                                                                        <option  value="">Pilih Shipping</option>
                                                                        <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['agenid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataagen']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['agenid']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                                        <option  value="<?php echo $_smarty_tpl->tpl_vars['p']->value['agenid'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['namaagen'];?>
</option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <select name="ongkiridnya" id="ongkirid" class="form-control" required="required" onChange="getTotal(orderid.value,this.value);">
                                                                        <option  value="">Select Service</option>
                                                                        <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['ongkirid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataongkir']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['ongkirid']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                                        <option  value="<?php echo $_smarty_tpl->tpl_vars['p']->value['ongkirid'];?>
" <?php echo $_smarty_tpl->tpl_vars['p']->value['select'];?>
><?php echo $_smarty_tpl->tpl_vars['p']->value['ongkir'];?>
</option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix">&nbsp;</div>
                                                            <div class="pembayaran" id="metodep">
                                                                <h4>Metode Pembayaran</h4>
                                                                <div class="form-group">
                                                                    <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['bankid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['databank']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['bankid']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
                                                                    <div class="col-md-6">
                                                                        <input type="hidden" name="bank" value="<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
">
                                                                        <label><img width="150" src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/payment/bank-transfer.png" alt="<?php echo $_smarty_tpl->tpl_vars['p']->value['nama'];?>
"></label><br>
                                                                        <input type="radio" name="pembayaran" value="Transfer" style="display:inline" required="required"> Manual Transfer
                                                                    </div>
                                                                    <?php } ?>
                                                                    <div class="col-md-6">
                                                                        <label><img width="150" src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/payment/master-card.png" alt="CreditCard Master"></label><br>
                                                                        <input type="radio" name="pembayaran" value="CreditCard"  style="display:inline" required="required"> CreditCard (Visa/Master)
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label><img width="150" src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/payment/atm-bersama.png" alt="ATM Transfer (Bersama)"></label><br>
                                                                        <input type="radio" name="pembayaran" value="BankTransfer"  style="display:inline" required="required"> Virtual Account (Transfer)
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-cart">
                                     <thead>
                                            <tr class="hidden-xs">
                                                <th>Produk</th>
                                                <th>Keterangan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Total</th>
                                            </tr>
                                             <tr class="visible-xs">
                                                <th>Item</th>
                                            </tr>
                                        </thead>
                                        <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dt_keranjang']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
                                            <tr>
                                                <td class="text-center hidden-xs">
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['link_produk'];?>
">
                                                    <div class="cart-item-thumb img-thumbnail">
                                                        <img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_s'];?>
" class="img-responsive" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
">
                                                    </div>
                                                    </a>
                                                </td>
                                                <td class="hidden-xs"><span class="text-uppercase"><b><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</b></span> <br><span><b>Item Nomor </b><?php echo $_smarty_tpl->tpl_vars['a']->value['nomor'];?>
 </td>
                                                <td class="text-center hidden-xs">
                                                    <b><?php echo $_smarty_tpl->tpl_vars['a']->value['harga_asli'];?>
</b>
                                                </td>
                                                <td>
                                                	<span class="visible-xs"> 
                                                    	<span class="text-uppercase"><b><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</b></span> <br><span><b>Item Nomor </b><?php echo $_smarty_tpl->tpl_vars['a']->value['nomor'];?>
 <br />
                                                         <b><?php echo $_smarty_tpl->tpl_vars['a']->value['harga_asli'];?>
</b><br />
                                                         Subtotal: <b><?php echo $_smarty_tpl->tpl_vars['a']->value['subtotal'];?>
</b>
                                                         </span>
                                                    </span>
                                                     <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
" name="as" size="10">
                                                     <div class="input-group spinner" data-trigger="spinner">
                                                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
" name="id_qty" size="10">
                                                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['produkpostid'];?>
" name="kode_qty_<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
">
                                                        <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['qty'];?>
" name="qty_<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
" data-rule="quantity" style="width:50px">
                                                       
                                                    </div>
                                                 
                                                </td>
                                                <td class="text-center hidden-xs" ><b><?php echo $_smarty_tpl->tpl_vars['a']->value['subtotal'];?>
</b></td>
                                            </tr>
                                        <?php } ?>
                                        </span>
                                        </table>
                                        <table class="table">
                                        <tfoot>
                                        <div id="total-area">
                                        <div id="subtotal-holder">
                                            <?php if ($_smarty_tpl->tpl_vars['totaldiskonn']->value!='0'){?>
                                            <tr>
                                                <td colspan="4" class="text-right">
                                                    <span class="text-uppercase"><b>Voucher Discount (<?php echo $_smarty_tpl->tpl_vars['kodevoucher']->value;?>
)</b></span>
                                                </td>
                                                <td colspan="2">
                                                    <div class="value pull-right" id=""><b>(-) <?php echo $_smarty_tpl->tpl_vars['totaldiskon']->value;?>
</b></div>
                                                </td>
                                            </tr>
                                            <?php }?>
                                            <tr>
                                                <td colspan="4" class="text-right">
                                                    <span class="text-uppercase"><b>Shipping (<?php echo $_smarty_tpl->tpl_vars['totalberat']->value;?>
 Gram)</b></span>
                                                    <input type="hidden" value="totalberat" value="<?php echo $_smarty_tpl->tpl_vars['totalberat']->value;?>
" id="totalberat" />
                                                </td>
                                                <td colspan="2">
                                                    <div class="value pull-right" id="ongkosawal_text"><b>0</b></div>
                                                    <input type="hidden" value="ongkoskirim" value="<?php echo $_smarty_tpl->tpl_vars['ongkoskirim']->value;?>
" id="ongkoskirim" />
                                                </td>
                                            </tr>
                                            <tr id="total-field">
                                                <td colspan="4" class="text-right">
                                                    <span class="text-uppercase"><b>Grand Total</b></span>
                                                </td>
                                                <td colspan="2">
                                                    <div class="value pull-right" id="totalpembelian"><b><?php echo $_smarty_tpl->tpl_vars['totaltagihanakhir']->value;?>
</b></div>
                                                </td>
                                            </tr>
                                        </div>
                                        </div>
                                        </tfoot>
                                    </table>
                                    <button class="btn btn-primary pull-right" type="submit" id="btn-notif">Checkout &nbsp;<i class="fa fa-arrow-right"></i></button>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i>Pilih Lagi</a>
                                </form>
                                </div>
                            <?php }elseif($_smarty_tpl->tpl_vars['aksi']->value=='invoice'||$_smarty_tpl->tpl_vars['aksi']->value=='response'){?>
                                <div role="tabpanel" class="tab-pane p-0 <?php if ($_smarty_tpl->tpl_vars['aksi']->value=='invoice'||$_smarty_tpl->tpl_vars['aksi']->value=='response'){?>active<?php }?>" id="summary">
                                    <table class="table table-bordered table-cart">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="row p-25">
                                                        <div class="col-md-12">
                                                            <h4>Order Details</h4>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="alert <?php echo $_smarty_tpl->tpl_vars['style']->value;?>
 checkout-alert" ><?php echo $_smarty_tpl->tpl_vars['salah']->value;?>
</div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php if ($_smarty_tpl->tpl_vars['style']->value!='alert-danger'){?>
                                    <table class="table table-bordered table-cart" id="table-cart">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th>Keterangan</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['detailproduk']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['a']->key;
?>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="cart-item-thumb img-thumbnail">
                                                        <img src="<?php echo $_smarty_tpl->tpl_vars['a']->value['image_s'];?>
" class="img-responsive" alt="<?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
">
                                                    </div>
                                                </td>
                                                <td><span class="text-uppercase"><b><?php echo $_smarty_tpl->tpl_vars['a']->value['nama'];?>
</b></span> <br><span><b>Item Nomor <?php echo $_smarty_tpl->tpl_vars['a']->value['nomor'];?>
</b></span></td>
                                                <td class="text-center">
                                                    <b><?php echo $_smarty_tpl->tpl_vars['a']->value['harga_asli'];?>
</b>
                                                </td>
                                                <td>
                                                    <center><?php echo $_smarty_tpl->tpl_vars['a']->value['qty'];?>
</center>
                                                </td>
                                                <td class="text-center"><b><?php echo $_smarty_tpl->tpl_vars['a']->value['totalharga'];?>
</b></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <?php if ($_smarty_tpl->tpl_vars['total_diskon']->value>0){?>
                                            <tr>
                                                <td colspan="4" class="text-right">
                                                    <span class="text-uppercase"><b>Discount Voucher <?php echo $_smarty_tpl->tpl_vars['namadiskon']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['diskonnya']->value;?>
 (<?php echo $_smarty_tpl->tpl_vars['kode_voucher']->value;?>
)</b></span>
                                                </td>
                                                <td colspan="2">
                                                    <b>(-) <?php echo $_smarty_tpl->tpl_vars['total_diskon2']->value;?>
</b>
                                                </td>
                                            </tr>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['ongkos_kirim']->value>0){?>
                                            <tr>
                                                <td colspan="4" class="text-right">
                                                    <span class="text-uppercase"><b>Pengiriman (<?php echo $_smarty_tpl->tpl_vars['totberat']->value;?>
 Gram)</b></span>
                                                </td>
                                                <td colspan="2">
                                                    <b><?php echo $_smarty_tpl->tpl_vars['ongkos_kirim2']->value;?>
</b>
                                                </td>
                                            </tr>
                                            <?php }?>
                                            <tr>
                                                <td colspan="4" class="text-right">
                                                    <span class="text-uppercase"><b>Grand Total</b></span>
                                                </td>
                                                <td colspan="2">
                                                    <b><?php echo $_smarty_tpl->tpl_vars['totaltagihanakhird']->value;?>
</b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <?php }?>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/member/history" class="btn btn-primary pull-right">Bayar &nbsp;<i class="fa fa-arrow-right"></i></a>
                                </div>
                            <?php }?>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <?php if ($_smarty_tpl->tpl_vars['salah']->value!=''){?>
                            <div class="alert <?php echo $_smarty_tpl->tpl_vars['style']->value;?>
"><center><?php echo $_smarty_tpl->tpl_vars['salah']->value;?>
 
                            <br /><br /><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product" class="btn btn-primary">Katalog Produk</a><br /></center></div>
                        <?php }else{ ?>
                            <div class="alert alert-warning"><center>Keranjang belanja anda saat ini masih kosong<br class="hidden-xs" />Silahkan memilih produk-produk terbaik kami 
                            <br /><br /><a href="<?php echo $_smarty_tpl->tpl_vars['fulldomain']->value;?>
/product" class="btn btn-primary">Pilih Produk <i class="fal fa-arrow-circle-right"></i> </a><br /></center></div>
                         <?php }?>
                    <?php }?>
                <?php }?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
    <?php }?>

</div>
<!-- /.wrapper -->


<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>