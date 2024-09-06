<!DOCTYPE html>
<html class="backend">
<head>
        <!-- START META SECTION -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Content Management System |  <?php echo $title?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
         <link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet' type='text/css'>
        <!-- Application stylesheet : mandatory -->
        <link rel="stylesheet" href="./template/library/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./template/stylesheet/layout.min.css">
        <link rel="stylesheet" href="./template/stylesheet/uielement.min.css">
        <link rel="stylesheet" href="./template/stylesheet/login.css">
        <!-- END STYLESHEETS -->

    </head>
    <!--/ END Head -->

    <!-- START Body -->
    <body>
        <!-- START Template Main -->
        <section id="main" role="main">
            <!-- START Template Container -->
            <section class="container">
                <!-- START row -->
                <div class="row"><br><br><br>
                    <div class="col-lg-4 col-lg-offset-4">
                    
                        <!-- Login form -->
                        <form class="panel" method="post" name="form-login" action="./index.php?kanal=login">
                        <input type="hidden" name="aksi" value="login" />
                            <div class="panel-body">
                            	<br /><center><img src="./template/images/img.logo.png" alt="" /></center>
                                <br />
								Selamat datang di Content Management System  <?php echo $title?>. Silahkan gunakan email dan password yang
                                anda miliki
                                <!--/ Alert message -->
                                <br /><br /><div class="form-group">
                                    <div class="form-stack has-icon pull-left">
                                        <input name="user" type="text" class="form-control input-lg" placeholder="Masukan Username" data-parsley-errors-container="#error-container" data-parsley-error-message="Please fill in your email" data-parsley-required>
                                        <i class="ico-user2 form-control-icon"></i>
                                    </div>
                                    <div class="form-stack has-icon pull-left">
                                        <input name="pass" type="password" class="form-control input-lg" placeholder="Masukan Password" data-parsley-errors-container="#error-container" data-parsley-error-message="Please fill in your password" data-parsley-required>
                                        <i class="ico-lock2 form-control-icon"></i>
                                    </div>
                                </div>

                                <!-- Error container -->
                                <div id="error-container" class="mb15"></div>
                                <!--/ Error container -->

                                <div class="form-group nm">
                                    <button type="submit" class="btn btn-block btn-primary">Masuk</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <!--/ END row -->
            </section>
            <!--/ END Template Container -->
        </section>
        <!--/ END Template Main -->

        <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
        <!-- Library script : mandatory -->
        <script type="text/javascript" src="./template/library/jquery/js/jquery.min.js"></script>
        <script type="text/javascript" src="./template/library/jquery/js/jquery-migrate.min.js"></script>
        <script type="text/javascript" src="./template/library/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./template/library/core/js/core.min.js"></script>
        <!--/ Library script -->

        <!--/ END JAVASCRIPT SECTION -->
    </body>
    <!--/ END Body -->

</html>