<!doctype html>
<!--[if lt IE 7]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->

<head>
    <meta charset="UTF-8">
    <title>Nusapoin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="shortcut icon" href="<?php echo base_url('assets/poin_temp/');?>/favicon.png">

    <link rel="stylesheet" href="<?php echo base_url('assets/poin_temp/css/bootstrap.css');?>">
    
    <link rel="stylesheet" href="<?php echo base_url('assets/poin_temp/');?>/css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/poin_temp/');?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/poin_temp/');?>/css/slick.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/poin_temp/');?>/js/rs-plugin/css/settings.css">

    <script type="text/javascript" src="<?php echo base_url('assets/poin_temp/');?>js/modernizr.custom.32033.js"></script>
    
    <link rel="stylesheet" href="<?php echo base_url('assets/poin_temp/');?>/css/eco.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>

<body>

    <div class="pre-loader">
        <div class="load-con">
            <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/logo.png" class="animated fadeInDown" alt="">
            <div class="spinner">
              <div class="bounce1"></div>
              <div class="bounce2"></div>
            </div>
        </div>
    </div>
	
	

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<center><h4 class="modal-title" id="myModalLabel">Login</h4></center>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" role="form" action="<?php echo site_url('web/proses');?>" method="post">
				<?php echo $this->session->flashdata('message');?>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-3 control-label">
						Username</label>
					<div class="col-sm-9">
						<input type="text" name="username"  id="inputEmail3" placeholder="Username" required>
					</div>
				</div>				
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-3 control-label">
						Password
					</label>
					<div class="col-sm-9">
						<input type="password" name="password" id="inputPassword3" placeholder="Password" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-3 control-label">
						</label>
					<div class="col-sm-9">
						<?php echo $captcha_img;?>						
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-3 control-label">
						Kode</label>
					<div class="col-sm-9">
						 <input name="captcha" placeholder="masukan kode di atas" required>
						 <?php
						  $wrong = $this->input->get('cap_error');
						  if($wrong){
						 ?>
						  <span style="color:red;">Captcha yang kamu masukan salah, silahkan ulangi lagi</span>
						 <?php
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
		  </div>
		</div>
	  </div>
	</div>
   
    <header>
        
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="fa fa-bars fa-lg"></span>
                        </button>
                        <a class="navbar-brand" href="#">
                            <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/logo.png" alt="" class="logo">
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#about">Perhitungan Poin</a>
                            </li>
                            <li><a href="#features">Syarat dan Ketentuan</a>
                            </li>                            
                            <li><a href="#screens">Hadiah</a>
                            </li> 							
                            <li><a class="getApp" href="#" data-toggle="modal" data-target="#myModal">Login</a>								
							</li>							
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-->
        </nav>

        
        <!--RevSlider-->
        <div class="tp-banner-container">
            <div class="tp-banner" >
                <ul>
                    <!-- SLIDE  -->
                    <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
                        <!-- MAIN IMAGE -->
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/transparent.png"  alt="slidebg1"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
                        <!-- LAYERS -->
                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption lfl fadeout hidden-xs"
                            data-x="left"
                            data-y="bottom"
                            data-hoffset="30"
                            data-voffset="0"
                            data-speed="500"
                            data-start="700"
                            data-easing="Power4.easeOut" style="height: 100%; margin-left: 150px">
                            <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/Slides/hand-eco.png" alt="">
                        </div>						
                        <div class="tp-caption large_white_bold sft" 
							data-x="550" 
							data-y="center" 
							data-hoffset="0" 
							data-voffset="-80" 
							data-speed="500" 
							data-start="1200" 
							data-easing="Power4.easeOut">
                            Nusa Poin
                        </div>
                        <div class="tp-caption large_white_light sfb" 
							data-x="550" 
							data-y="center" 
							data-hoffset="0" 
							data-voffset="0" 
							data-speed="1000" 
							data-start="1500" 
							data-easing="Power4.easeOut">
                            Berbagai Hadiah Menarik Menanti Anda
                        </div>

                        <div class="tp-caption sfb hidden-xs" 
							data-x="550" 
							data-y="center" 
							data-hoffset="0" 
							data-voffset="85" 
							data-speed="1000" 
							data-start="1700" 
							data-easing="Power4.easeOut">
                            <a href="#about" class="btn btn-primary inverse btn-lg">SELENGKAPNYA</a>
                        </div>

                    </li>
                    <!-- SLIDE 2 -->
                    <li data-transition="zoomout" data-slotamount="7" data-masterspeed="1000" >
                        <!-- MAIN IMAGE -->
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/transparent.png"  alt="slidebg1"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
                        <!-- LAYERS -->
                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption lfb fadeout hidden-xs"
                            data-x="center"
                            data-y="bottom"
                            data-hoffset="0"
                            data-voffset="0"
                            data-speed="1000"
                            data-start="900"
                            data-easing="Power4.easeOut">
                            <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/Slides/eco-slide2.png" alt="">
                        </div>

                        
                        <div class="tp-caption large_white_bold sft" 
							data-x="center" 
							data-y="200" 
							data-hoffset="0" 
							data-voffset="0" 
							data-speed="1000" 
							data-start="700" 
							data-easing="Power4.easeOut">
                            Hadiah Utama
                        </div>
                    </li>
                    
                </ul>
            </div>
        </div>


    </header>


    <div class="wrapper">

        <section id="about">
            <div class="container">
                <center>
					<div class="row" style="margin-top: 20px">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/perhitungan.png" alt="">
						</div>
					</div>
				</center>
            </div>
        </section>

        <section id="features">
            <div class="container">
                <div class="section-heading scrollpoint sp-effect3">
                    <h1>Syarat dan Ketentuan</h1>
                    <div class="divider"></div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 scrollpoint sp-effect2">
                        <div class="media feature">
                            <a class="pull-left" href="#">
                                <i class="fa fa-adjust fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">
								Program Promo "NusaPoin 2015" PT. Nusa Unggul Sarana Adicipta (PT.NUSA) ini berlaku selama 6 bulan 
								mulai realisasi: 1 April 2015 s/d 30 september 2015 untuk toko-toko yang berlangganan produk-produk 
								PT. Nusa Unggul Sarana Adicipta (PT. NUSA) di seluruh wilayah Indonesia yang telah tercatat di database PT. NUSA
								</h4>
                            </div>
                        </div>
                        <div class="media feature">
                            <a class="pull-left" href="#">
                                <i class="fa fa-adjust fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">
								Untuk ikut serta dalam program ini pelanggan diwajibkan mengisi Formulir Aplikasi NusaPoin 2015 
								PT. NUSA yang kemudian dapat dikirim melalui :</h4>
								<h4>a. Distributor PT. NUSA</h4>
								<h4>b. Sales Representatif PT. NUSA</h4>
								<h4>c. Dikirimkan ke alamat :
								PT. Nusa Unggul Sarana Adicipta
								Jln. Raya Semarang – Demak KM. 17
								Ds. Wonokerto, Kec. Karangtengah
								Demak – Jawa Tengah 59561
								Telp. 0291-690108
								</h4>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row" style="margin-top: 20px">
                    <div class="col-md-12 col-sm-12 scrollpoint sp-effect2">
						<a class="pull-left" href="<?php echo base_url('assets/poin_temp/');?>/pdf/brosur.pdf">
							<i class="fa fa-file-pdf-o"></i> Download Brosur
						</a>
					</div>
				</div>
            </div>
        </section>

        
        <section id="screens">
            <div class="container">
                <div class="section-heading scrollpoint sp-effect3">
                    <h1>Hadiah</h1>                                        
                </div>
                <div class="filter scrollpoint sp-effect3">
                    <a href="javascript:void(0)" class="button js-filter-all active">Semua Hadiah</a>
                    <a href="javascript:void(0)" class="button js-filter-one">Kendaraan</a>
                    <a href="javascript:void(0)" class="button js-filter-two">Elektronik</a>
                    <a href="javascript:void(0)" class="button js-filter-three">Gadget</a>
                    <a href="javascript:void(0)" class="button js-filter-four">Produk NBI & NMI </a>
                    <a href="javascript:void(0)" class="button js-filter-five">Souvenir & Voucher</a>
                </div>
                <div class="slider filtering scrollpoint sp-effect5" >
                    <div class="one">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/gran max.png" alt="">
                    </div>
                    <div class="one">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/ninja.png" alt="">
                    </div>
                    <div class="one">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/viar.png" alt="">
                    </div>
                    <div class="one">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/beat.png" alt="">
                    </div>
                    <div class="one">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/vega.png" alt="">
                    </div>
                    <div class="three">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/samsung.png" alt="">
                    </div>
                    <div class="three">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/vaio.png" alt="">
                    </div>
					<div class="three">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/nikon.png" alt="">
					</div>	
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/kulkas.png" alt="">
                    </div>	
                    <div class="four">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/nusaboard.png" alt="">
                    </div>
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/mesin cuci.png" alt="">
                    </div>	
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/tv.png" alt="">
                    </div>
					<div class="one">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/sepeda.png" alt="">
                    </div>
					<div class="one">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/sepedah.png" alt="">
                    </div>
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/tv led.png" alt="">
                    </div>
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/panasonic.png" alt="">
                    </div>
					<div class="three">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/asus.png" alt="">
                    </div>
					<div class="three">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/camdig.png" alt="">
                    </div>
					<div class="five">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/voucher.png" alt="">
                    </div>
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/polytron.png" alt="">
                    </div>
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/dvd.png" alt="">
                    </div>
					<div class="five">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/indomart.png" alt="">
                    </div>
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/blender.png" alt="">
                    </div>
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/kipas.png" alt="">
                    </div>
					<div class="four">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/metalco.png" alt="">
                    </div>
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/sanyo.png" alt="">
                    </div>
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/setrika.png" alt="">
                    </div>
					<div class="two">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/dispenser.png" alt="">
                    </div>
					<div class="five">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/mug.png" alt="">
                    </div>
					<div class="five">
                        <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/screens/payung.png" alt="">
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="container">
                <a href="#" class="scrollpoint sp-effect3">
                    <img src="<?php echo base_url('assets/poin_temp/');?>/img/eco/logo.png" alt="" class="logo">
                </a>
				<div class="rights">
				<h4 style="color: #fff;">PT. Nusa Unggul Sarana Adicipta</h4>
				<p>Jl. Margomulyo Indah III Blok A No 7A</p>
				<p>Surabaya</p>
				<p>Telp: (031) 7491856-58</p>
				</div>
                <div class="social">
                    <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-twitter fa-lg"></i></a>
                    <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-google-plus fa-lg"></i></a>
                    <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-facebook fa-lg"></i></a>
                </div>
                <div class="rights">
                    <p>Copyright &copy; 2015</p>
                </div>
            </div>
        </footer>

    </div>
    <script src="<?php echo base_url('assets/poin_temp/');?>/js/jquery-1.11.1.min.js"></script>
    <script src="<?php echo base_url('assets/poin_temp/');?>/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/poin_temp/');?>/js/slick.min.js"></script>
    <script src="<?php echo base_url('assets/poin_temp/');?>/js/placeholdem.min.js"></script>
    <script src="<?php echo base_url('assets/poin_temp/');?>/js/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
    <script src="<?php echo base_url('assets/poin_temp/');?>/js/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    <script src="<?php echo base_url('assets/poin_temp/');?>/js/waypoints.min.js"></script>
    <script src="<?php echo base_url('assets/poin_temp/');?>/js/scripts.js"></script>
    <script>
        $(document).ready(function() {
            appMaster.preLoader();
        });
    </script>
</body>

</html>
