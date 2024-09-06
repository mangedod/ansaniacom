<?php
if($_SESSION['cms_userid'])
{ 
?>
	
<!DOCTYPE html>
<html class="backend">
<head>
        <!-- START META SECTION -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Content Management System | <?php echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <!--/ END META SECTION -->

        <!-- START STYLESHEETS -->
        <!-- Plugins stylesheet : optional -->
        
        <link rel="stylesheet" href="./template/plugins/selectize/css/selectize.min.css">
        <link href='https://fonts.googleapis.com/css?family=Poppins&display=swap' rel='stylesheet' type='text/css'>
        <!--/ Plugins stylesheet -->

        <!-- Application stylesheet : mandatory -->
        <link rel="stylesheet" href="./template/stylesheet/font-awesome.css">
        <link rel="stylesheet" href="./template/library/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./template/stylesheet/layout.min.css">
        <link rel="stylesheet" href="./template/stylesheet/uielement.min.css">
        <link rel="stylesheet" href="./template/stylesheet/custom.css">
        <link rel="stylesheet" type="text/css" href="./template/stylesheet/ui.all.css" />
        <link rel="stylesheet"  type="text/css" href="./template/stylesheet/validationEngine.jquery.css" />
        <!--/ Application stylesheet -->
        <!-- END STYLESHEETS -->

        <!-- START JAVASCRIPT SECTION - Load only modernizr script here -->
        <script src="./template/library/modernizr/js/modernizr.min.js"></script>
                <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
        <!-- Library script : mandatory -->
        <script type="text/javascript" src="./template/library/jquery/js/jquery.min.js"></script>
        <script type="text/javascript" src="./template/library/jquery/js/jquery-migrate.min.js"></script>
        <script type="text/javascript" src="./template/library/core/js/core.min.js"></script>        
		<script type="text/javascript" src="./template/library/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="./template/javascript/ui.core.js"></script>
        <script type="text/javascript" src="./template/javascript/ui.tabs.js"></script>
        <script type="text/javascript" src="./template/javascript/ui.datepicker.js"></script>
        <script type="text/javascript" src="./template/javascript/ui.datepicker-id.js"></script>
		<script type="text/javascript" src="./template/javascript/sweetalert.min.js"></script>
        <script type="text/javascript" src="./template/library/stacktable/stacktable.js"></script>
        <!--/ Library script -->
        
     

        <!-- App and page level script -->
        <script type="text/javascript" src="./template/plugins/sparkline/js/jquery.sparkline.min.js"></script><!-- will be use globaly as a summary on sidebar menu -->
        <script type="text/javascript" src="./template/javascript/app.min.js"></script>

        
        <script type="text/javascript" src="./template/plugins/selectize/js/selectize.min.js"></script>
        <script type="text/javascript" src="./template/javascript/jquery.validationEngine.js"></script>
		<script type="text/javascript" src="./template/javascript/jquery.validationEngine-en.js"></script>
        
                

        
        <!--/ App and page level script -->
        <!--/ END JAVASCRIPT SECTION -->
        <!--/ END JAVASCRIPT SECTION -->
    </head>
    <!--/ END Head -->

    <!-- START Body -->
    <body>
    	 
    	<div class="topheader">
        	<a href="./"><img src="template/images/img.logo.png"></a>
            
            
            <div class="menu pull-right visible-xs-block hidden-xs"><a href="../" target="_blank" class="visible-xs-block hidden-xs"><i class="fal fa-tv"></i> Halaman Depan</a></div>
        </div>
        <!-- START Template Header -->
        <header id="header" class="navbar navbar-fixed-top">
           
			<div class="header-box"></div>
            <!-- START Toolbar -->
            <div class="navbar-toolbar clearfix">
                <!-- START Left nav -->
                <ul class="nav navbar-nav navbar-left">
                    <!-- Sidebar shrink -->
                    <li class="hidden-xs hidden-sm">
                        <a href="javascript:void(0);" class="sidebar-minimize" data-toggle="minimize" title="Minimize sidebar">
                            <span class="meta">
                                <span class="icon"></span>
                            </span>
                        </a>
                    </li>
                    <!--/ Sidebar shrink -->
                    <script>
						$( ".sidebar-minimize" ).click(function() {
							alert($.cookie('name'));
						});
						
					</script>

                    <!-- Offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
                    <li class="navbar-main hidden-lg hidden-md hidden-sm">
                        <a href="javascript:void(0);" data-toggle="sidebar" data-direction="ltr" rel="tooltip" title="Menu sidebar">
                            <span class="meta">
                                <span class="icon"><i class="ico-paragraph-justify3"></i></span>
                            </span>
                        </a>
                    </li>
                    <!--/ Offcanvas left -->

                </ul>
                <!--/ END Left nav -->

                <!-- START navbar form -->

                <!-- START Right nav -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Profile dropdown -->
                    <li class="dropdown profile">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="meta">
                                <span class="avatar"><img src="./template/image/avatar/avatar7.jpg" class="img-circle" alt="" /></span>
                                <span class="text hidden-xs hidden-sm pl5"><?php echo $_SESSION['cms_userfullname']?></span>
                                <span class="caret"></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="./index.php?kanal=profil"><span class="icon"><i class="fal fa-user"></i></span> My Accounts</a></li>
                            <li><a href="./index.php?kanal=gantipassword"><span class="icon"><i class="fal fa-key"></i></span> Ganti Password</a></li>
                            <li class="divider"></li>
                            <li><a href="./index.php?kanal=login&aksi=logout"><span class="icon"><i class="fal fa-unlock"></i></span> Sign Out</a></li>
                        </ul>
                    </li>
                    <!-- Profile dropdown -->

                   
                </ul>
                <!--/ END Right nav -->
            </div>
            <!--/ END Toolbar -->
        </header>
        <!--/ END Template Header -->

        <!-- START Template Sidebar (Left) -->
        <aside class="sidebar sidebar-left sidebar-menu">
        	
            <!-- START Sidebar Content -->
            <section class="content slimscroll">
             
            <h5 class="heading">Main Menu</h5>
                <!-- START Template Navigation/Menu -->
                <ul class="topmenu topmenu-responsive" data-toggle="menu">
                  
                     <li >
                        <a href="./" >
                            <span class="figure"><i class="fal fa-home"></i></span>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>
                    <?php
					$urlnya		= $_GET['kanal'];
					$tabnya		= $_GET['tab'];
					$perintah1 	= "select nama,kode,menuid,icon from tbl_cms_menu order by urutan asc ";
					$hasil1 	= sql($perintah1);
					while ($data1 = sql_fetch_data($hasil1))
					{
						$namamenu 	= $data1['nama'];
						$menuid	= $data1['menuid'];
						$kode	= $data1['kode'];
						$icon	= $data1['icon'];
						$kode1	= strtolower($kode);
						
						
							$perintah2 	= "select nama,menuchildid,url,kode from tbl_cms_menuchild where menuid='$menuid' order by urutan asc ";
							$hasil2 	= sql($perintah2);
							$jml = sql_num_rows($hasil2);
							
							if($jml>0)
							{
								$a  = 0;
								while ($data2 = sql_fetch_data($hasil2))
								{
									$namachild 	= $data2['nama'];
									$url 		= $data2['url'];
									$kode 		= $data2['kode'];
									$katId 		= $data2['menuid'];
									
									if(preg_match("/$kode/i",$_SESSION['cms_otoritas']))
									{	
										
										$childmenu	.= "<li";
										//if ($urlnya == $url) $childmenu .= " class='active' ";
										$childmenu	.= ">
											<a href=\"index.php?tab=$menuid&amp;kanal=$url\">
											<span class=\"text\">$namachild</span></a>
											</li>";
										
										//echo $childmenu;
										$a++;
									}
								}
								
							}
							sql_free_result($hasil2); 
							
							if($a>0)
							{
								echo  "<li>
								 <a href=\"javascript:void(0);\" data-target=\"#$kode\" data-toggle=\"submenu\" data-parent=\".topmenu\">
									<span class=\"figure\"><i class=\"fal fa-$icon\"></i></span>
									<span class=\"text\"><strong>$namamenu</strong></span>
									<span class=\"arrow\"></span>
								</a>
								<ul id=\"$kode\" class=\"submenu collapse"; if($menuid==$tabnya){ echo " in"; } echo  "\">
								<li class=\"submenu-header ellipsis\">$namamenu</li>";
								
								if($a>0) echo $childmenu;
								
								echo "</li></ul>";	
							}
							
							unset($menu,$childmenu,$a);
						
					}
							
                       ?>
                </ul>
                <!--/ END Template Navigation/Menu -->

              
            </section>
            <!--/ END Sidebar Container -->
        </aside>
        <!--/ END Template Sidebar (Left) -->

        <!-- START Template Maiaan -->
        <section id="main" role="main">
            <!-- START Template Container -->
            <div class="container-fluid">
            	<!-- Page Header -->
                <div class="page-header page-header-block">
                    <div class="page-header-section">
                        <h4 class="title semibold">
                        <?php
							if(!empty($kanal) && $kanal!="dashboard")
							{
								$perintah 	= "select nama from tbl_cms_menuchild where url='$kanal'";
								$hasil 		= sql($perintah);
								$data		= sql_fetch_data($hasil);
								$namamenu 	= $data['nama'];
								sql_free_result($hasil);
							}
							else if(!empty($topnamamenu) && !empty($topnamasub) && !empty($kanal) && $kanal=="dashboard")
							{
								$namamenu = "$topnamasub Main Menu";
							}
							else if(!empty($topnamamenu) && empty($topnamasub) && !empty($kanal) && $kanal=="dashboard")
							{
								$namamenu = $topnamamenu;
							}
							else
							{						
								$namamenu = "$title";
							}	
							echo "<a href=\"$alamat\">$namamenu</a>";
							
							
						?>
                        </h4>
                    </div>
                </div>
                <!-- Page Header -->
				
                <div class="panel panel-default">
            	<?php
					
				 if(!empty($_GET['msg']))
					{ 
					
					?>
						<script>
						swal("Sukses", "<?php echo base64_decode($_GET['msg']); ?>", "success", {
						  button: "OK",
						});
						</script>
					<?php
					}
					if(!empty($_GET['error']))
					{ 
						?>
                        <script>
						swal("Gagal", "<?php echo base64_decode($_GET['msg']); ?>", "warning", {
						  button: "OK",
						});
						</script>
                        <?php
					}
					
					include("./".$include); 
				?>
                </div>

            </div>
            <!--/ END Template Container -->

            <!-- START To Top Scroller -->
            <a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
            <!--/ END To Top Scroller -->

        </section>
        <!--/ END Template Main -->

		<script>
		//$('.tabel-cms').stacktable({myClass:'stacktable small-only'});
		$('.st-key:empty').hide();
		
		function confirmDelete(delUrl)
		{
			swal({
			  title: "Apakah Anda Yakin?",
			  text: "Data yang sudah terhapus tidak dapat dikembalikan kembali. Apakah anda yakin akan menghapus data ini?",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
				window.location = delUrl;
			  } 
			});
			
			return false;
		}
		function showinfomodul(){ window.showModalDialog("index.php?cominfo=1&kanal=<?php echo $kanal?>","", "dialogWidth:800px;dialogHeight:600px;dialogTop:100px;") }
		
		$(".tabel-cms th a").append('&nbsp;<i class="fal fa-sort"></i>');
		
		</script>


    </body>
    <!--/ END Body -->

</html>
<?php }
else
{
	include("login.tpl.php");
}

 ?>