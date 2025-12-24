<?php if(ENVIRONMENT === 'development'): ?>

    <div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

    <h4>A PHP Error was encountered</h4>

    <p>Severity: <?php echo $severity; ?></p>
    <p>Message:  <?php echo $message; ?></p>
    <p>Filename: <?php echo $filepath; ?></p>
    <p>Line Number: <?php echo $line; ?></p>

    </div>

<?php else: ?>

    <?php
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . explode('/', $_SERVER['REQUEST_URI'])[1] . "/assets/errors/serious.gif";
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Error Kesalahan Teknis</title>
        <style>
            /*======================
                404 page
            =======================*/

            .page_404 {
                padding: 40px 0;
                background: #fff;
                font-family: 'Arvo', serif;
            }

            .page_404 img {
                width:100%;
            }

            .four_zero_four_bg {
                background-image: url(<?= $actual_link ?>);
                height: 280px;
                background-position: center;
                background-repeat: no-repeat;
            }

            .contant_box_404 h1 {
                font-size: 80px;
            }

            .contant_box_404 h3 {
                font-size: 80px;
                color: #ff0000;
            }

            .contant_box_404 p {
                font-size: 20px;
            }

            .link_404 {
                color: #fff!important;
                padding: 10px 20px;
                background: #39ac31;
                margin: 20px 0;
                display: inline-block;
            }

            .contant_box_404 {
                margin-top: -50px;
            }

            .text-center {
                text-align: center;
            }
        </style>
    </head>
    <body>
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1 text-center">
                        <div class="four_zero_four_bg"></div>
                        <div class="contant_box_404">
                            <h3>Error Kesalahan Teknis</h3>
                            <p>Harap Hubungi <b>Tim IT</b> Terdekat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </body>
    </html>

<?php endif; ?>
