<?php
/* Smarty version 4.3.0, created on 2024-03-28 12:47:40
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/event.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_660566ece4d000_71743823',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a4a75b6ac3e609707760ced04193d4461b115549' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/event.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_660566ece4d000_71743823 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."komponen/home/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

    <!-- HOME -->
    <div class="overlay home small-medium-size">
        <div class="bg bg-shop"></div>
        <div class="container vmiddle">
            <div class="row text-center text-title-list">
                <h1 class="text-uppercase">Event</h1>
                <h4>Upcoming Event</h4>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <!-- CONTAINER -->
        <div class="container">

            <div class="row">
                <!-- POST -->
                <div class="col-sm-9 post">
                <?php if ($_smarty_tpl->tpl_vars['aksi']->value == 'read') {?>
                    <div class="event-item">

                        <?php if ($_smarty_tpl->tpl_vars['detailgambar']->value != '') {?>
                        <figure class="post-img">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['detailgambar']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
">
                        </figure>
                        <?php }?>

                        <h2 class="post-detail-title"><?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
</h2>

                        <table class="table table-event-detail">
                            <tr>
                                <th width="150px">Location </th><td>: <?php echo $_smarty_tpl->tpl_vars['detaillokasievent']->value;?>
</td>
                            </tr>
                            <tr>
                                <th>Date </th><td>: <?php echo $_smarty_tpl->tpl_vars['detailtanggalevent']->value;?>
</td>
                            </tr>
                            <tr>
                                <th>Time </th><td>: <?php echo $_smarty_tpl->tpl_vars['detailwaktuevent']->value;?>
</td>
                            </tr>
                            <tr>
                                <th>Organizer </th><td>: <?php echo $_smarty_tpl->tpl_vars['detailorganizer']->value;?>
</td>
                            </tr>
                        </table>


                        <h3>About Event</h3>
                        <p><?php echo $_smarty_tpl->tpl_vars['detaillengkap']->value;?>
</p>

                        <div class="post-footer">
                            <div class="post-share-button pull-left">
                                <div id="share"></div> 
                            </div>
                        </div>
                    </div>

                    <hr>
                <?php } else { ?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['datadetail']->value, 'ev', false, 'id');
$_smarty_tpl->tpl_vars['ev']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['ev']->value) {
$_smarty_tpl->tpl_vars['ev']->do_else = false;
?>
                    <div class="event-item">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['e']->value['link'];?>
">
                        <?php if ($_smarty_tpl->tpl_vars['ev']->value['gambar'] != '') {?>
                        <figure class="post-img">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['ev']->value['gambar'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['ev']->value['nama'];?>
">
                        </figure>
                        <?php }?>
                        </a>

                        <a href="<?php echo $_smarty_tpl->tpl_vars['e']->value['link'];?>
"><h2 class="post-detail-title"><?php echo $_smarty_tpl->tpl_vars['ev']->value['nama'];?>
</h2></a>

                        <table class="table table-event-detail">
                            <tr>
                                <th width="150px">Location </th><td>: <?php echo $_smarty_tpl->tpl_vars['ev']->value['lokasievent'];?>
</td>
                            </tr>
                            <tr>
                                <th>Date </th><td>: <?php echo $_smarty_tpl->tpl_vars['ev']->value['tanggalevent'];?>
</td>
                            </tr>
                            <tr>
                                <th>Time </th><td>: <?php echo $_smarty_tpl->tpl_vars['ev']->value['waktuevent'];?>
</td>
                            </tr>
                            <tr>
                                <th>Organizer </th><td>: <?php echo $_smarty_tpl->tpl_vars['ev']->value['organizer'];?>
</td>
                            </tr>
                        </table>


                        <h3>About Event</h3>
                        <p><?php echo $_smarty_tpl->tpl_vars['ev']->value['ringkas'];?>
</p>
                    </div>

                    <hr>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <div class="col-md-12 text-right pagination-box">
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
                <?php }?>
                </div>
                <!-- /.post -->
                <aside class="blogbar col-sm-3">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['eventkanan']->value, 'e', false, 'id');
$_smarty_tpl->tpl_vars['e']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['e']->value) {
$_smarty_tpl->tpl_vars['e']->do_else = false;
?>
                    <div class="upcoming-event">
                        <h2>Upcoming Event</h2>
                        <ul class="media-list">
                          <li class="media">
                            <div>
                              <?php if ($_smarty_tpl->tpl_vars['e']->value['gambar'] != '') {?>
                              <a href="<?php echo $_smarty_tpl->tpl_vars['e']->value['link'];?>
">
                                <img class="media-object img-responsive" src="<?php echo $_smarty_tpl->tpl_vars['e']->value['gambar'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['e']->value['nama'];?>
">
                              </a>
                              <?php }?>
                            </div>
                            <div class="media-body">
                              <h4 class="media-heading"><?php echo $_smarty_tpl->tpl_vars['e']->value['nama'];?>
</h4>
                              <p class="post-inf grey"><?php echo $_smarty_tpl->tpl_vars['e']->value['tanggalevent'];?>
 - <?php echo $_smarty_tpl->tpl_vars['e']->value['waktuevent'];?>
</p>
                              <p class="post-inf grey"><?php echo $_smarty_tpl->tpl_vars['e']->value['lokasievent'];?>
</p>
                              <a href="<?php echo $_smarty_tpl->tpl_vars['e']->value['link'];?>
" class="btn btn-primary btn-xs"> Readmore</a>
                            </div>
                          </li>
                        </ul>
                    </div>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

                    <div class="blog-banner">
                        <div class="blog-banner-img">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['lokasiwebtemplate']->value;?>
images/banners/blog-banner.jpg" alt="">
                        </div>
                       
                    </div>
                </aside>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

</div>
<!-- /.wrapper -->

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['lokasitemplate']->value)."/komponen/home/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
