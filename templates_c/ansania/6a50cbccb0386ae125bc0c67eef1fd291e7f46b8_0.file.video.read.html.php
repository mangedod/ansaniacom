<?php
/* Smarty version 4.3.0, created on 2024-03-27 07:04:51
  from 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/video/video.read.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_6603c5130bfbf1_00643045',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6a50cbccb0386ae125bc0c67eef1fd291e7f46b8' => 
    array (
      0 => 'http://localhost:8080/ansaniacom/public_html/template/ansania/komponen/video/video.read.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603c5130bfbf1_00643045 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="sub-location hidden-lg hidden-md">
    <?php echo $_smarty_tpl->tpl_vars['bahasa']->value['news'];?>

</div>
<div class="box-content">
    	<div class="col-md-8">
         <?php if ($_smarty_tpl->tpl_vars['detailgambar']->value != '') {?>
         
         <?php if ($_smarty_tpl->tpl_vars['detailjenis']->value == 'youtube') {?>
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="<?php echo $_smarty_tpl->tpl_vars['detailvideo']->value;?>
"></iframe>
          </div>
          
         <?php } else { ?>
         
        <div class="thumbDetail1">
             <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
/librari/videoplayer/jwplayer.js"><?php echo '</script'; ?>
>
             <?php echo '<script'; ?>
 type="text/javascript">jwplayer.key="uzBbpYh+pgrOIlodl46+LloYU9avwUZ/lR5yAw==";<?php echo '</script'; ?>
>
                    <div id='mediaplayer'></div>
                    
		            <?php echo '<script'; ?>
 type="text/javascript">
                      jwplayer('mediaplayer').setup({
					    playlist: [{
							image: "<?php echo $_smarty_tpl->tpl_vars['detailgambar']->value;?>
",
							sources: [
								{ file: "<?php echo $_smarty_tpl->tpl_vars['detailvideo']->value;?>
" }
							],
							title: "<?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
"
						}],
                        width: '100%',
                        height: '640',
                        autostart: 'true',
                        stretching: 'exactfit',
						
                      });
                    <?php echo '</script'; ?>
>
                    

        </div>
        <?php }?>
        <?php }?>
        </div>
        <div class="col-md-4">
        <div class="title-headline">
            <span><h1><?php echo $_smarty_tpl->tpl_vars['detailnama']->value;?>
</h1></span>

        </div>
       
        <p><?php echo $_smarty_tpl->tpl_vars['detaillengkap']->value;?>
. <em><?php if ($_smarty_tpl->tpl_vars['detailcreator']->value != '') {?>Oleh <?php echo $_smarty_tpl->tpl_vars['detailcreator']->value;?>
 | <?php }?> <?php echo $_smarty_tpl->tpl_vars['detailtanggal']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['detailstats']->value;?>
 Views</em></p>
        
        <br clear="all" />
       <div id="share"></div> 
        <br clear="all" /><br clear="all" />
    </div>
           <div class="bg-divider"></div>
        


           
</div>
<?php }
}
