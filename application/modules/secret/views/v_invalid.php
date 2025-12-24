<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Survey Page</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome/css/font-awesome.min.css') ?>">
    <!-- AdminLTE -->
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/css/AdminLTE.min.css">-->
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.css') ?>">
<!--    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/skins/_all-skins.min.css">-->
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.css') ?>">
    <style>

    </style>
</head>
<body class="hold-transition skin-red layout-top-nav">

<div class="wrapper">

    <!-- Header -->
    <header class="main-header">
        <a href="<?php echo site_url('dashboard');?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <!--span class="logo-mini"><b>A</b>LT</span-->
            <span class="logo-mini"><img src="<?php echo base_url('assets/img/logo-depan/logo_transparan-mini-white-njrm.png');?>" width="60%" height="50%" class="img-rounded"></span>
            <!-- logo for regular state and mobile devices -->
            <!--n class="logo-lg"><b>Admin</b>LTE</span-->
            <span class="logo-lg"><img src="<?php echo base_url('assets/img/logo-depan/logo_transparan.png');?>" width="100%" height="100%" class="img-rounded"></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <!--<ul class="nav navbar-nav">


                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">Alexander Pierce</span>
                        </a>
                        <ul class="dropdown-menu">

                            <li class="user-header">
                                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                <p>
                                    Alexander Pierce - Web Developer
                                    <small>Member since Nov. 2012</small>
                                </p>
                            </li>


                            <li class="user-footer">

                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>-->
            </div>
        </nav>
    </header>

    <!-- Content -->
    <div class="content-wrapper">
        <div class="container">
            <section class="content">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Terjadi kesalahan</b></h3>
                    </div>
                    <div class="box-body box-custom">
                        <h3>Ini terjadi karena url yang digunakan tidak valid atau sudah pernah digunakan. <br>Silakan gunakan url lain yang valid</h3>
                    </div>
                    <div class="box-footer">

                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.1.1
        </div>
        <strong>Copyright &copy; IT Nusantara Group <?php echo date('Y') ?> <a href="#"></a>.</strong> All rights
        reserved.
    </footer>
</div>

<!-- Scripts -->
<script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/dist/js/app.min.js') ?>"></script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/js/adminlte.min.js"></script>-->
</body>
</html>
