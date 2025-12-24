<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 4/25/19 8:49 AM
 *  * Last Modified: 4/24/19 11:44 AM.
 *  Developed By: Fiky Ashariza Powered By PHPStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

?>
<!doctype html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>OSIN| <?php echo $title;?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php echo $_ini_stylenya;?>
        <!-- CUSTOM CSS TARUH DI BAWAH SINI -->
        <style> .ratakanan { text-align : right; } </style>
        <!-- END CUSTOM CSS  -->
        <?php echo $_ini_jsnya;?>
        <?php echo $_ini_keyaccess;?>
        <?php echo $_ini_customnya;?>
        <!-- CUSTOM JS TARUH DI BAWAH SINI -->
        <script type="text/javascript">
            //<![CDATA[
            var base = function(url){
                return '<?php echo base_url();?>' + url;
            }
            var site = function(url){
                return base(url) + '.html';
            }
            var debugmode = function() {
                return <?php echo ($this->config->item('debugmode')) ? 'true' : 'false';?>;
            }
            //]]>
        </script>
        <!-- END SCRIPT HELPER -->

        <script>
            $(document).ready(function() {
                function disableBack() { window.history.forward() }

                //window.onload = disableBack();
                //window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
                var href = window.location.href,
                    idle = false,
                    timer = null;
                /*ACTIVE SIDEBAR OPEN*/
                $('.treeview').find('a[href=\'' + href + '\']')
                    .addClass('bg-info')
                    .parents('li')
                    .addClass('active')
                    .parents('ul.treeview-menu')
                    .addClass('active')
                    .addClass('open')
                    .css({ 'display': 'block' });

                var timeout;
                clearTimeout(timeout); // Remove any timers from previous clicks
                timeout = setTimeout(function() {
                    $('.x').removeClass("x").addClass("sidebar-collapse");
                }, 500000); // Schedule an event for 10 seconds in the future, and store it

                $( ":input" ).attr('autocomplete','off');
                $('form').on('focus', 'input[type=number]', function (e) {
                    $(this).on('mousewheel.disableScroll', function (e) {
                        e.preventDefault()
                    })
                });

                $('.separator').on('ready', function (e) {
                    formatangkaobjek( $(this).val());
                });

                function formatangkaobjek(objek) {
                    a = objek.value.toString();
                    //  alert(a);
                    //  alert(objek);
                    b = a.replace(/[^\d]/g,"");
                    c = "";
                    panjang = b.length;
                    j = 0;
                    for (i = panjang; i > 0; i--) {
                        j = j + 1;
                        if (((j % 3) == 1) && (j != 1)) {
                            c = b.substr(i-1,1) + "." + c;
                        } else {
                            c = b.substr(i-1,1) + c;
                        }
                    }
                    objek.value = c;
                }



            });
        </script>
        <!-- END CUSTOM JS  -->
		</head>
		<!--tambahan-->
        <!--
        skin-blue
        skin-blue-light
        skin-yellow
        skin-yellow-light
        skin-green
        skin-green-light
        skin-purple
        skin-purple-light
        skin-red
        skin-red-light
        skin-black
        skin-black-light
        -->

        <body class="hold-transition skin-green-light sidebar-mini x">
        <div class="wrapper">
            <?php echo $_header;?>
            <?php echo $_sidebar;?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content">
                <?php echo $_content;?>
                </section><!-- /.content -->
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.1.1
                </div>
                <strong>Copyright &copy; IT-Nusantara Group 2019 <a href="#"></a>.</strong> All rights
                reserved.
            </footer>
<?php /* TUTUP AJA DULU BELUM PERLU
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

                    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane" id="control-sidebar-home-tab">
                        <h3 class="control-sidebar-heading">Recent Activity</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                        <p>Will be 23 on April 24th</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-user bg-yellow"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                        <p>New phone +1(800)555-1234</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                        <p>nora@example.com</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-file-code-o bg-green"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                        <p>Execution time 5 seconds</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->

                        <h3 class="control-sidebar-heading">Tasks Progress</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Custom Template Design
                                        <span class="label label-danger pull-right">70%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Update Resume
                                        <span class="label label-success pull-right">95%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Laravel Integration
                                        <span class="label label-warning pull-right">50%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Back End Framework
                                        <span class="label label-primary pull-right">68%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->

                    </div>
                    <!-- /.tab-pane -->
                    <!-- Stats tab content -->
                    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                    <!-- /.tab-pane -->
                    <!-- Settings tab content -->

                    <div class="tab-pane" id="control-sidebar-settings-tab">
                        <form method="post">
                            <h3 class="control-sidebar-heading">General Settings</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Report panel usage
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Some information about this general settings option
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Allow mail redirect
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Other sets of options are available
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Expose author name in posts
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Allow the user to show his name in blog posts
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <h3 class="control-sidebar-heading">Chat Settings</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Show me as online
                                    <input type="checkbox" class="pull-right" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Turn off notifications
                                    <input type="checkbox" class="pull-right">
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Delete chat history
                                    <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                                </label>
                            </div>
                            <!-- /.form-group -->
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
            </aside>
           TUTUP AJA DULU BELUM PERLU */ ?>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>

		<!-- popup reminder-->
		<!--script>
					$(document).ready(function() {
				$("#one-dialog").dialog({
						title: "Reminder Karyawan Kontrak",
					autoOpen: true,
					modal: false,
					draggable: true,
					height: "auto",
					width: "auto",
					resizable: true,
					position: {
						my: "right top",
					  at: "right top",
					  of: $('.right-side')
					},
					show: {
					  effect: "blind",
					  duration: 1000
					},
					hide: {
					  effect: "explode",
					  duration: 1000
					},
					create: function (event){
					$(event.target).parent().css('position', 'fixed');
					},
					open: function() {
						//$('#object').load...
					}
				});
				$("#two-dialog").dialog({
						title: "Reminder Karyawan Pensiun",
					autoOpen: true,
					modal: false,
					draggable: true,
					height: "auto",
					width: "auto",
					resizable: true,
					position: {
						my: "right top",
					  at: "right buttom",
					  of: $('.right-side')
					},
					show: {
					  effect: "blind",
					  duration: 1000
					},
					hide: {
					  effect: "explode",
					  duration: 1000
					},
					create: function (event){
					$(event.target).parent().css('position', 'fixed');
					},
					open: function() {
						//$('#object').load...
					}
				});

						setInterval(
				function(){
				$("#one-dialog").dialog("open");
				$("#two-dialog").dialog("open");
				}, 120000);

				//$("#button-here").click(function() {
					//$("#one-dialog").dialog("open");
				//});

					});

		</script---->
	<!--?php
	$this->load->model(array('master/m_menu'));
	$nik=$this->session->userdata('nik');
	$cek_nik=$this->m_menu->q_nik_akses($nik)->num_rows();
	if($cek_nik>0) {
	?>
		<?php// if($cek_kontrak<>0) { ?>
					<div class="col-md-3" id="one-dialog">

                            <div class="small-box bg-yellow">
							   <div class="inner">
                                    <h3>

                                        Total : <?php //echo $cek_kontrak;?>
                                    </h3>
                                    <p>
                                        Reminder Karyawan Kontrak
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-calendar"></i>
                                </div>
                                <a href="<?php //echo site_url('trans/stspeg/list_karkon');?>" class="small-box-footer">
                                    Browse <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                    </div><!--
		<?php// } ?>
		<?php// if($cek_pensiun<>0) { ?>
					<div class="col-md-3" id="two-dialog">
                            <!-- small box
                            <div class="small-box bg-blue">
                                <div class="inner">
                                   <h3>
                                        Total : <?php// echo $cek_pensiun;?>
                                    </h3>
                                    <p>
                                        Reminder Karyawan Pensiun
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="<?php //echo site_url('trans/stspeg/list_karpen');?>" class="small-box-footer">
                                    Browse <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                    </div><!-- ./col
			<?php //} ?>

		<?php// } ?>
		<!-- END OF POPUP REMINDER----->




        </body>
</html>