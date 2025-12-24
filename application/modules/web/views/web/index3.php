<!doctype html>
    <html>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script language="Javascript">
        $(document).ready(function(){
            $('input').keypress(function(e) { 
                var s = String.fromCharCode( e.which );

                if((s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey) ||
                   (s.toUpperCase() !== s && s.toLowerCase() === s && e.shiftKey)){
                    if($('#capsalert').length < 1) $(this).after('<b id="capsalert">CapsLock is on!</b>');
                } else {
                    if($('#capsalert').length > 0 ) $('#capsalert').remove();
                }
            });
        });
    </script>
        <head>
            <title>OSIN</title>
            <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
            <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
        
            <link href="<?php echo base_url('assets/css/plugins/morris/morris-0.4.3.min.css');?>" rel="stylesheet">
            <link href="<?php echo base_url('assets/css/plugins/timeline/timeline.css');?>" rel="stylesheet">
        
            
            <script src="<?php echo base_url('assets/js/jquery.js');?>"></script>
            <script src="<?php echo base_url('assets/js/bootstrap.js');?>"></script>
            <script src="<?php echo base_url('assets/js/tinymce/tinymce.min.js');?>"></script>
            <script>
                    tinymce.init({selector:'textarea'});
            </script>

        <meta charset="UTF-8">
        <title> Online Sistem Informasi | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body style="background-color: #ffffff">
	
		<div class="container">
				<div class="row clearfix" style="margin-top: 10px;">
					<div class="col-md-2">
					</div>
                    <div class="col-md-8">
						<legend><center>Selamat Datang di ONLINE SISTEM INFORMASI HR & GA NUSA </center></legend>
					</div>
				</div>
                <div class="row clearfix">
					<div class="col-md-2">
					</div>
                    <div class="col-md-5">
                        <img src="<?php echo base_url('assets/img/nusa-logo.jpg');?>" width="100%" class="img-rounded">
                    </div>
                    <div class="col-md-4 ">
					<!--atas-->
						<form class="form-horizontal" role="form" action="<?php echo site_url('web/proses');?>" method="post">
                                    <?php echo $this->session->flashdata('message');?>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">
                                            Username</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="username" class="form-control" id="inputEmail3" placeholder="Username" required>
                                        </div>
                                    </div>                                    								
									<div class="form-group">
                                        <label for="inputPassword3" class="col-sm-3 control-label">
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password" class="form-control" id="inputPassword3" 
											style="float:left;display:block;width:260px;" placeholder="Password" required>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="inputPassword3" class="col-sm-3 control-label">
                                            </label>
                                        <div class="col-sm-9">
                                            <?php echo $captcha_img;?>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="inputPassword3" class="col-sm-3 control-label">
                                            Kode</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="captcha" class="form-control" placeholder="masukan Kode" required	>										
											 <?php
											  $wrong = $this->input->get('cap_error');
											  if($wrong){											 
													echo '<span style="color:red;">Captcha yang kamu masukan salah, silahkan ulangi lagi</span>';						
											  }
											 ?>											
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"/>
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group last">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                Sign in</button>
                                                 <button type="reset" class="btn btn-default btn-sm">
                                                Reset</button>
                                        </div>
                                    </div>
                                </form>
					<!--bwah-->
                    </div>
                </div>
            </div>
			<footer style="padding: 30px 0; margin-top:197px; background-image:url('<?php echo base_url('assets/img/foternusa.png');?>');  background-size:  100% 100% ; background-repeat: no-repeat;">
				<div class="container" >
					<p align="center" style="color:#fff">Copyright © <a href="nusaboard.co.id">nusaboard.co.id</a> 2017</p>
				</div>
			</footer>

        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->       
<!-- Core Scripts - Include with every page -->
        <script src="<?php echo base_url('assets/js/holder.js');?>"></script>
    
        <script src="<?php echo base_url('assets/js/application.js');?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-1.10.2.js');?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/plugins/metisMenu/jquery.metisMenu.js');?>"></script>
        <script src="<?php echo base_url('assets/js/plugins/morris/raphael-2.1.0.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/plugins/morris/morris.js');?>"></script>
        <script src="<?php echo base_url('assets/js/sb-admin.js');?>"></script>
        <script src="<?php echo base_url('assets/js/demo/dashboard-demo.js');?>"></script>   
        </body>
    </body>
</html>
	