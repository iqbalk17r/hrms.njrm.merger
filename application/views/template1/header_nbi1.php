	<header class="header">
            <a href="<?php echo site_url('dashboard');?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="<?php echo base_url('assets/img/nusa-logo-transparan.png');?>" width="100%" height="90%" class="img-rounded">
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">						
						<!-- Notifications: style can be found in dropdown.less -->                       
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
                                                <i class="ion ion-ios7-people info"></i><?php echo $ull->userid.' | '.$ull->nik;?>
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
                                <i class="ion ion-ios7-people info"></i>       
								
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
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php	echo $user_menu['username'];?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-green">
                                    <img src="<?php $imgr=trim($user_menu['image']); echo base_url("assets/img/profile/$imgr");?>" class="img-rounded" alt="User Image" />
                                    <p>                                        
										<?php echo $user_menu['username'];	?>
						
                                    </p>
                                </li>
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
                    </ul>
                </div>
            </nav>
        </header>
