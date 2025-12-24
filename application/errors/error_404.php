<?php if(ENVIRONMENT === 'development'): ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <title>404 Page Not Found</title>
    <style type="text/css">

    ::selection{ background-color: #E13300; color: white; }
    ::moz-selection{ background-color: #E13300; color: white; }
    ::webkit-selection{ background-color: #E13300; color: white; }

    body {
        background-color: #fff;
        margin: 40px;
        font: 13px/20px normal Helvetica, Arial, sans-serif;
        color: #4F5155;
    }

    a {
        color: #003399;
        background-color: transparent;
        font-weight: normal;
    }

    h1 {
        color: #444;
        background-color: transparent;
        border-bottom: 1px solid #D0D0D0;
        font-size: 19px;
        font-weight: normal;
        margin: 0 0 14px 0;
        padding: 14px 15px 10px 15px;
    }

    code {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        font-size: 12px;
        background-color: #f9f9f9;
        border: 1px solid #D0D0D0;
        color: #002166;
        display: block;
        margin: 14px 0 14px 0;
        padding: 12px 10px 12px 10px;
    }

    #container {
        margin: 10px;
        border: 1px solid #D0D0D0;
        -webkit-box-shadow: 0 0 8px #D0D0D0;
    }

    p {
        margin: 12px 15px 12px 15px;
    }
    </style>
    </head>
    <body>
        <div id="container">
            <h1><?php echo $heading; ?></h1>
            <?php echo $message; ?>
        </div>
    </body>
    </html>

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
