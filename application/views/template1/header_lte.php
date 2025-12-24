<header class="main-header  skin-green ">
    <!-- Logo -->
    <a href="<?php echo site_url('dashboard');?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <!--span class="logo-mini"><b>A</b>LT</span-->
        <span class="logo-mini"><img src="<?php echo base_url('assets/img/logo-depan/logo_transparan-mini.png');?>" width="60%" height="50%" class="img-rounded"></span>
        <!-- logo for regular state and mobile devices -->
        <!--n class="logo-lg"><b>Admin</b>LTE</span-->
        <span class="logo-lg"><img src="<?php echo base_url('assets/img/logo-depan/logo_transparan.png');?>" width="100%" height="100%" class="img-rounded"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-smile-o"></i>
                        <span class="label label-warning"><?php echo $jumlah_online;?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">User Online</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php foreach ($user_online as $ull){?>
                                    <li>
                                        <a href="#">

                                            <!--h7 style="font-family:'Times New Roman';font-size:100%;">
                                                <strong-->
                                            <div class="row">
                                                <div class="col-xs-2 col-md-2 text-nowrap"> <img src="<?php
                                                    $imo=trim($ull->image);
                                                    echo base_url("assets/img/profile/$imo");
                                                    ?>" alt="HTML5 Icon" width="45" height="45"></div>
                                                <div class="col-xs-2 col-md-5 text-nowrap"><strong><?php echo $ull->userid;?></strong> </div>
                                                <div class="col-xs-5 col-md-5 text-nowrap"><strong><?php echo $ull->nik;?></strong> </div>
                                            </div>
                                            <!--?php echo '  '.$ull->userid.' | '.$ull->nik;?-->
                                            <!--/strong>
                                        </h7-->
                                            <!--i img src="<!?php echo base_url("assets/img/profile".'/'.$ull->image);?>" height="42" width="42"></i><!?php echo $ull->userid.' | '.$ull->nik;?-->
                                        </a>
                                    </li>
                                <?php }?>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="ion-ios-people info"></i>

                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">5 User Online Terakhir</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php foreach ($list_login as $ab){ ?>
                                    <li>
                                        <a href="#">
                                            <i class="ion ion-ios7-people info"></i><?php echo $ab->tgl.' | '.$ab->username;?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <!--<li class="footer"><a href="<?php echo base_url('log/last_login'); ?>">Lihat Semua</a></li>-->
                    </ul>
                </li>


                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php $imgr=trim($user_menu['image']); echo base_url("assets/img/profile/$imgr");?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $user_menu['username'];	?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php $imgr=trim($user_menu['image']); echo base_url("assets/img/profile/$imgr");?>" class="img-circle" alt="User Image">

                            <p>
                                <?php echo $user_menu['username'];	?>
                            </p>
                        </li>
                        <!-- Menu Body -->
                       <!-- <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>

                        </li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php $nik=trim($user_menu['nik']); $username=trim($user_menu['username']); echo site_url('master/user/editprofile/'.$nik.'/'.$username);?>" class="btn btn-default btn-flat">Ubah Password</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo site_url('dashboard/logout');?>" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-off"></i>Log out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <?php if(trim($user_menu["level_akses"]) == "A" && in_array($_SERVER["REMOTE_ADDR"], ["127.0.0.1", "::1"])) { ?>
                    <li>
                        <a href="<?php echo site_url('update');?>" title="Cek Update"><i class="fa fa-gears"></i></a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>
