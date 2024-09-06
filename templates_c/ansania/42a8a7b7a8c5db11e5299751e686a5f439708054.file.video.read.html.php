<?php /* Smarty version Smarty-3.1.13, created on 2022-02-06 18:00:18
         compiled from "/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/video/video.read.html" */ ?>
<?php /*%%SmartyHeaderCode:100788242061ed3084b587d4-02747112%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '42a8a7b7a8c5db11e5299751e686a5f439708054' => 
    array (
      0 => '/home/host/user/q8012/sites/ansaniasignature.com/htdocs/template/ansania/komponen/video/video.read.html',
      1 => 1644141860,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '100788242061ed3084b587d4-02747112',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_61ed3084bd5f77_91905322',
  'variables' => 
  array (
    'bahasa' => 0,
    'detailgambar' => 0,
    'detailjenis' => 0,
    'detailvideo' => 0,
    'domain' => 0,
    'detailnama' => 0,
    'detaillengkap' => 0,
    'detailcreator' => 0,
    'detailtanggal' => 0,
    'detailstats' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_61ed3084bd5f77_91905322')) {function content_61ed3084bd5f77_91905322($_smarty_tpl) {?><div class="sub-location hidden-lg hidden-md">
    <?php echo $_smarty_tpl->tpl_vars['bahasa']->value['news'];?>

</div>
<div class="box-content">
    	<div class="col-md-8">
         <?php if ($_smarty_tpl->tpl_vars['detailgambar']->value!=''){?>
         
         <?php if ($_smarty_tpl->tpl_vars['detailjenis']->value=='youtube'){?>
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="<?php echo $_smarty_tpl->tpl_vars['detailvideo']->value;?>
"></iframe>
          </div>
          
         <?php }else{ ?>
         
        <div class="thumbDetail1">
             <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
/librari/videoplayer/jwplayer.js"></script>
             <script type="text/javascript">jwplayer.key="uzBbpYh+pgrOIlodl46+LloYU9avwUZ/lR5yAw==";</script>
                    <div id='mediaplayer'></div>
                    
		            <script type="text/javascript">
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
                    </script>
                    

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
. <em><?php if ($_smarty_tpl->tpl_vars['detailcreator']->value!=''){?>Oleh <?php echo $_smarty_tpl->tpl_vars['detailcreator']->value;?>
 | <?php }?> <?php echo $_smarty_tpl->tpl_vars['detailtanggal']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['detailstats']->value;?>
 Views</em></p>
        
        <br clear="all" />
       <div id="share"></div> 
        <br clear="all" /><br clear="all" />
    </div>
           <div class="bg-divider"></div>
        


           
</div>
<?php }} ?>