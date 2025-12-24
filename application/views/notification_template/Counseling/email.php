<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Notifikasi</title>
    <style>
        /* -------------------------------------
            GLOBAL RESETS
        ------------------------------------- */

        /*All the styling goes here*/

        img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
        }

        body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%; }
        table td {
            font-family: sans-serif;
            font-size: 14px;
            vertical-align: top;
        }

        /* -------------------------------------
            BODY & CONTAINER
        ------------------------------------- */

        .body {
            background-color: #f6f6f6;
            width: 100%;
        }

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            display: block;
            margin: 0 auto !important;
            /* makes it centered */
            max-width: 580px;
            padding: 10px;
            width: 580px;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            max-width: 580px;
            padding: 10px;
        }

        /* -------------------------------------
            HEADER, FOOTER, MAIN
        ------------------------------------- */
        .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%;
        }

        .wrapper {
            box-sizing: border-box;
            padding: 20px;
        }

        .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
        }

        .footer {
            clear: both;
            text-align: center;
            width: 100%;
        }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
            color: #999999;
            font-size: 12px;
            text-align: center;
        }

        /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        h1,
        h2,
        h3,
        h4 {
            color: #000000;
            font-family: sans-serif;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 35px;
            font-weight: 300;
            text-align: center;
            text-transform: capitalize;
        }

        p,
        ul,
        ol {
            font-family: sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px;
        }
        p li,
        ul li,
        ol li {
            list-style-position: inside;
            margin-left: 5px;
        }

        a {
            color: #3498db;
            text-decoration: underline;
        }

        /* -------------------------------------
            BUTTONS
        ------------------------------------- */
        .btn {
            box-sizing: border-box;
            width: 100%; }
        .btn > tbody > tr > td {
            padding-bottom: 15px; }
        .btn table {
            width: auto;
        }
        .btn table td {
            background-color: #ffffff;
            border-radius: 5px;
            text-align: center;
        }
        .btn a {
            background-color: #ffffff;
            border: solid 1px #3498db;
            border-radius: 5px;
            box-sizing: border-box;
            color: #3498db;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            padding: 12px 25px;
            text-decoration: none;
            text-transform: capitalize;
        }

        .btn-primary table td {
            background-color: #3498db;
        }

        .btn-primary a {
            background-color: #3498db;
            border-color: #3498db;
            color: #ffffff;
        }

        /* -------------------------------------
            OTHER STYLES THAT MIGHT BE USEFUL
        ------------------------------------- */
        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .clear {
            clear: both;
        }

        .mt0 {
            margin-top: 0;
        }

        .mb0 {
            margin-bottom: 0;
        }

        .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0;
        }

        .powered-by a {
            text-decoration: none;
        }

        hr {
            border: 0;
            border-bottom: 1px solid #f6f6f6;
            margin: 20px 0;
        }

        /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
        ------------------------------------- */
        @media only screen and (max-width: 620px) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }
            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
                font-size: 16px !important;
            }
            table[class=body] .wrapper,
            table[class=body] .article {
                padding: 10px !important;
            }
            table[class=body] .content {
                padding: 0 !important;
            }
            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important;
            }
            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }
            table[class=body] .btn table {
                width: 100% !important;
            }
            table[class=body] .btn a {
                width: 100% !important;
            }
            table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }
        }

        /* -------------------------------------
            PRESERVE THESE STYLES IN THE HEAD
        ------------------------------------- */
        @media all {
            .ExternalClass {
                width: 100%;
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }
            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }
            #MessageViewBody a {
                color: inherit;
                text-decoration: none;
                font-size: inherit;
                font-family: inherit;
                font-weight: inherit;
                line-height: inherit;
            }
            .btn-primary table td:hover {
                background-color: #34495e !important;
            }
            .btn-primary a:hover {
                background-color: #34495e !important;
                border-color: #34495e !important;
            }
            .em_padd {
                padding: 20px 10px !important;
            }
        }
        #rcorners1 {
            border-radius: 15px;
            padding: 10px;
            width: fit-content;
        }

    </style>
</head>
<body class="">
<span class="preheader">Notifikasi HRMS</span>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
        <td>&nbsp;</td>
        <td class="container">
            <div class="content">

                <!-- START CENTERED WHITE CONTAINER -->
                <table role="presentation" class="main">

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td valign="top" align="center"><img class="em_img"
                                                                         style="display:block; font-family:Arial, sans-serif; font-size:30px; line-height:34px; color:#000000; max-width:700px;"
                                                                         src="<?php echo base_url('assets/img/mail_template/image/approval_mgmt/header2.jpg') ?>"
                                                                         width="700" border="0" height="180"></td>
                                </tr>
                                <tr >
                                    <td style="padding: 10px !important;">
                                        <br>
                                        <br>
                                        <span>Yth. <?php echo $send_to ?></span>
                                        <p><?php echo $position.' '.$branchname ?></p>
                                        <br>
                                        <p><?php echo $type ?> Untuk :</p>
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <?php foreach ($transaction as $index => $item) { ?>
                                                <tr>
                                                    <td style="width: 10%; height: 19.4px;font-family:'Times'; font-size:16px;"><?php echo str_replace('_',' ', strtoupper($index)) ?></td>
                                                    <td style="width: 2%; height: 19.4px;font-family:'Times'; font-size:16px;">:</td>
                                                    <td style="width: 20%; height: 19.4px;font-family:'Times'; font-size:16px;"><?php echo strtoupper($item) ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                        <p></p>
                                        <?php
                                        switch ($status){
                                            case "P":

                                                break;
                                        }
                                        ?>
                                        <?php if ($status == 'P') {?>
                                            <div id="rcorners1" style="background-color: #E0E0E0;color: #008F60">
                                                <span style="font-size: 20px"><strong>Telah Disetujui</strong></span>
                                            </div>

                                        <?php }elseif ($status == 'C') { ?>
                                            <div id="rcorners1" style="background-color: #E0E0E0;color: #d79806">
                                                <span style="font-size: 20px"><strong>Telah Dibatalkan</strong></span>
                                            </div>
                                        <?php }?>
                                    </td>

                                </tr>
                            </table>
                            <table style="margin-top: 50px;;padding: 10px">
                                <tr>
                                    <td style="padding-bottom:16px;" valign="top" align="center">
                                        <table cellspacing="0" cellpadding="0" border="0" align="center">
                                            <tbody>
                                            <tr style="padding-left: 10px;padding-right: 10px">
                                                <td valign="top" align="center"><a href="#" target="_blank"
                                                                                   style="text-decoration:none;"><img
                                                                src="<?php echo base_url('assets/img/mail_template/icon/browser.png') ?>"
                                                                alt="yt"
                                                                style="display:block; font-family:Arial, sans-serif; font-size:12px; line-height:14px; color:#ffffff; max-width:26px;"
                                                                width="26" border="0" height="26">nusaboard.co.id</a></td>
                                                <td style="width:6px;" width="6">&nbsp;</td>
                                                <td valign="top" align="center"><a href="#" target="_blank"
                                                                                   style="text-decoration:none;"><img
                                                                src="<?php echo base_url('assets/img/mail_template/icon/fb.png') ?>"
                                                                alt="fb"
                                                                style="display:block; font-family:Arial, sans-serif; font-size:12px; line-height:14px; color:#ffffff; max-width:26px;"
                                                                width="26" border="0" height="26"> Nusaboard </a></td>
                                                <td style="width:6px;" width="6">&nbsp;</td>
                                                <td valign="top" align="center"><a href="#" target="_blank"
                                                                                   style="text-decoration:none;"><img
                                                                src="<?php echo base_url('assets/img/mail_template/icon/ig.png') ?>"
                                                                alt="tw"
                                                                style="display:block; font-family:Arial, sans-serif; font-size:12px; line-height:14px; color:#ffffff; max-width:27px;"
                                                                width="27" border="0" height="26"> @nusaboard.co.id </a>
                                                </td>
                                                <td style="width:6px;" width="6">&nbsp;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="background-color: #008F60;margin: 5px">
                                    <td style="font-family:\'Open Sans\', Arial, sans-serif; font-size:11px; line-height:18px; color:#000000;"
                                        valign="top" align="center"><a href="#" target="_blank"
                                                                       style="color:#000000; text-decoration:underline;">PRIVACY
                                            STATEMENT</a> | <a href="#" target="_blank"
                                                               style="color:#000000; text-decoration:underline;">TERMS OF
                                            SERVICE</a> | <a href="#" target="_blank"
                                                             style="color:#000000; text-decoration:underline;">RETURNS</a><br>
                                        Copyright IT Group <?php echo date('Y')?>. All Rights Reserved.<br>
                                        <p style="color: #ffffee">Mohon Jangan balas email ini, ini adalah email otomatis dari system</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- END MAIN CONTENT AREA -->
                </table>
                <!-- END CENTERED WHITE CONTAINER -->

                <!-- START FOOTER -->
                <div class="footer-test">
                    <div class="footer-content" style="background-color: #0a6332">
                    </div>
                </div>
                <!-- END FOOTER -->

            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>
