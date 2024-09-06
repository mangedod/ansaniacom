<!DOCTYPE html>
<html class="backend">
<head>
        <!-- START META SECTION -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Content Management System | <?php echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="./template/plugins/selectize/css/selectize.min.css">
        <!--/ Plugins stylesheet -->

        <!-- Application stylesheet : mandatory -->
        <link rel="stylesheet" href="./template/library/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./template/stylesheet/layout.min.css">
        <link rel="stylesheet" href="./template/stylesheet/uielement.min.css">
        <link rel="stylesheet" href="./template/stylesheet/custom.pop.css">
        <link rel="stylesheet" type="text/css" href="./template/stylesheet/ui.all.css" />

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


        
        
        <!--/ App and page level script -->
        <!--/ END JAVASCRIPT SECTION -->
        <!--/ END JAVASCRIPT SECTION -->
    </head>
    <!--/ END Head -->

    <!-- START Body -->
    <body>
 <div class="panel panel-default">
         <?php
			if($_SESSION['cms_userid']) { 
			include("./".$include); 
			}else
			{
				echo "<div class=\"isa_error\"> Anda sudah logout dari sistem, silahkan login kembali <a href=\"#\" onclick=\"login()\" class=\"aerror\"> Tutup </a></div>";	
			}
		 ?>
        
</div>
</body>
</html>
