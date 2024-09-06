<?php /* Smarty version Smarty-3.1.13, created on 2022-02-23 11:25:57
         compiled from "/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/video/video.read.html" */ ?>
<?php /*%%SmartyHeaderCode:171595005619285c518ae17-94888979%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69fbb43b008d6d318a6a69e35862733e4d91ec71' => 
    array (
      0 => '/home/host/user/q8001/sites/ansania.com/htdocs/template/ansania/komponen/video/video.read.html',
      1 => 1645585019,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '171595005619285c518ae17-94888979',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_619285c51f5913_55335086',
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
<?php if ($_valid && !is_callable('content_619285c51f5913_55335086')) {function content_619285c51f5913_55335086($_smarty_tpl) {?><div class="sub-location hidden-lg hidden-md">
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