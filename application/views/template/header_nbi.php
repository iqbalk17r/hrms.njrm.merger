<!doctype html>
<html>
<head>
<!--Timer CSS -->
<!--link href="<?php echo base_url('assets/css/timer/timeTo.css');?>" rel="stylesheet" type="text/css" /-->

<!-- TIMER JS --->
<!--script src="<?php echo base_url('assets/js/plugins/timer/jquery.time-to.js');?>" type="text/javascript"></script--->
<!--script src="<?php echo base_url('assets/js/plugins/timer/Gulpfile.js');?>" type="text/javascript"></script--->
  <!-- HIGH CHARTS-->
  <script src="<?php echo base_url('assets/js/highcharts.js');?>" type="text/javascript"></script>
<style>

</style>
</head>
<body></body>
</html>
<!--Start of Tawk.to Script-->
<!--script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5b5828f4df040c3e9e0bf006/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script--->
<!--End of Tawk.to Script-->
<script type="text/javascript">
    $(function() {
        //$('#demo').timeTo(180, function(){ alert('Countdown finished'); });

     /*
        $('#TimeSession').timeTo(
        {  // font family
                            countdown: true,
                            fontFamily: "Verdana, sans-serif",
                            fontSize: 15,
                            lang: 'en',
                            seconds: 300,
                            start: true,
                            theme: "none",
                            captionSize: 0,
                            callback: null,
        }, function(){ alert('Sesi Berakhir, Reload Akan Dilakukan Setelah Menekan Tombol OK!'); window.location.reload(); });
       // $('#demo').timeTo();

        function getRelativeDate(days, hours, minutes){
            var date = new Date(Date.now() + 60000 /!* milisec *!/ * 60 /!* minutes *!/ * 24 /!* hours *!/ * days /!* days *!/);

            date.setHours(hours || 0);
            date.setMinutes(minutes || 0);
            date.setSeconds(0);

            return date;
        }*/


       /* setTimeout(function () {
           /// window.location.reload();
            //window.location = "http://www.smkproduction.eu5.org";
            //window.open("<!?php echo site_url('dashboard');?>","_blank");
            //$('body').load(window.location.href,'body');
            parent.window.location.reload();
           // target = "_blank";
        }, 60); */


    });


    /*setInterval(function() {
        console.log("tick");
       // parent.window.location.reload();
        $.ajax({
            url : "<!?php echo site_url('/web/updatesession')?>",
            type: "POST",
            dataType: "json",
            success: function(data)
            {
                console.log('Sukses');

            } ,
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log('GAGAL');
                //window.location.replace("<!?php echo site_url('/payroll/generate/utama/gaji_failed')?>");

            }
        });
    }, 1000*60*1);*/
            //parent.window.location.reload();
       // $.ajax({
         //   url : "<!?php echo base_url('/dashboard')?>",
            //type: "POST",
           ////dataType: "json",
           //success: function(data)
           //{
           //    console.log('Sukses');

           //} ,
           //error: function (jqXHR, textStatus, errorThrown)
           //{
           //    console.log('GAGAL');
           //    //window.location.replace("<!?php echo site_url('/payroll/generate/utama/gaji_failed')?>");

           //}


        /*setTimeout(function() {
            //parent.window.location.reload();

            $.ajax({
                url : "<!?php echo site_url('/dashboard')?>",
                type: "POST",
                dataType: "json",
                success: function(data)
                {
                    console.log('Sukses');

                } ,
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log('GAGAL');
                    //window.location.replace("<!?php echo site_url('/payroll/generate/utama/gaji_failed')?>");

                }
            });
        }, 1000*10*1);*/


    /*function rels(){
        console.log("tick");
        setTimeout(function() {
            //parent.window.location.reload();

            $.ajax({
                url : "<!?php echo site_url('/dashboard')?>",
                type: "POST",
                dataType: "TEXT",
                success: function(data)
                {
                    console.log('Sukses');

                } ,
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log('GAGAL');
                    //window.location.replace("<!?php echo site_url('/payroll/generate/utama/gaji_failed')?>");

                }
            });
        }, 1000*10*1);

    }

    setInterval(rels(), 1000);*/
</script>
<header class="header">
            <a href="<?php echo site_url('dashboard');?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="<?php echo base_url('assets/img/logo-depan/logo_transparan.png');?>" width="100%" height="75%" class="img-rounded">
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
                <!--div class="navbar-right" id="TimeSession"></div><div class="navbar-right"> Sesi Berakhir : </div-->
            </nav>
        </header>
