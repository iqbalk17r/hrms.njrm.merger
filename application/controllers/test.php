<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 4/29/19 1:34 PM
 *  * Last Modified: 12/18/16 10:51 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class Test extends CI_Controller{

    function __construct(){
        parent::__construct();
        //$this->load->model(array(''));
        $this->load->library(array('Fiky_ecopos_printer','upload'));

    }
    function index(){
        echo 'AKSES DENIED';
    }

    function list_printer(){

    }

    function loadprint(){
        try {
            //fopen("php://stdin", "r")
            //$connector = $this->fiky_ecopos_printer->filePrintConnector("php://stdout");
            $ip = '192.168.15.12'; // IP Komputer kita atau printer lain yang masih satu jaringan
            $printer = 'lq2190'; // Nama Printer yang di sharing
            //$connector = new WindowsPrintConnector("smb://" . $ip . "/" . $printer);
            $connector = $this->fiky_ecopos_printer->windowsprintconnector("LPT1");
            $printer = $this->fiky_ecopos_printer->printer($connector);
            $printer -> initialize();
            $printer -> text("Hello World!\n");
            $printer -> cut();

            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
        //$this->fiky_ecopos_printer->WindowsPrintConnector();
        //$this->fiky_ecopos_printer->WindowsPrintConnector("LPT1");
        //$connector = new WindowsPrintConnector("LPT1");
        //echo $printer = new Printer($connector);
    }

    public function generatecontactcard()
    {
        $this->load->library('ciqrcode');
        $data = array(
            'prefix'       => '',
            'first_name'   => 'Mail Bot 123',
            'last_name'    => 'Trial',
            'phone'        => '087826765051',
            'work_phone'   => '0000000000',
            'email'        => '4mailbot@gmail.com',
            'birthday'     => '2000-01-01',
            'address_home' => array(
                'street' => 'Jalan Merbabu',
                'city' => 'Jombang',
                'state' => 'Jawa Timur',
                'postal' => '64111',
                'country' => 'Indonesia',
            ),
            'address_work' => array(
                'street' => 'Jalan Karimun No 10',
                'city' => 'Malang',
                'state' => 'Jawa Timur',
                'postal' => '64711',
                'country' => 'Indonesia',
            ),
            'website'      => 'https://www.example.com',
            'organization' => 'IT-DEV',
            'job_title'    => 'DEV',
            'image'    => site_url('assets/img/logo-depan/Nusantara.png'),
        );

        $qrCode = $this->ciqrcode->generateVCardQRCodeWithLogo($data);
        var_dump($qrCode);
    }



}	