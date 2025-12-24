<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ciqrcode
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function generateqr($data, $directory, $size)
    {
        require_once 'phpqrcode/qrlib.php';

        if (!file_exists($directory))
            mkdir($directory);

        $generatedqr = $directory . $data . '-qr.png';
        QRcode::png($data, $generatedqr, QR_ECLEVEL_H, $size);

        return $generatedqr;
    }

    public function generatebase64qr($data)
    {
        require_once 'phpqrcode/qrlib.php';

        $pngAbsoluteFilePath = tempnam(sys_get_temp_dir(), 'qrcode');
        QRcode::png($data['string'], $pngAbsoluteFilePath, QR_ECLEVEL_H, $data['size'], 0);

        $QR = file_get_contents($pngAbsoluteFilePath);
        unlink($pngAbsoluteFilePath);

        $QR = base64_encode($QR);

        return $QR;
    }

    function generateVCardQRCode($data, $filename = 'contact.png'){
        require_once 'phpqrcode/qrlib.php';
        // susun vCard versi 3.0
        $vcard  = "BEGIN:VCARD\n";
        $vcard .= "VERSION:3.0\n";
        $vcard .= "N:".$data['last_name'].";".$data['first_name'].";;".$data['prefix'].";\n";
        $vcard .= "FN:".$data['first_name']." ".$data['last_name']."\n";

        if(!empty($data['phone'])){
            $vcard .= "TEL;TYPE=cell:".$data['phone']."\n";
        }
        if(!empty($data['work_phone'])){
            $vcard .= "TEL;TYPE=WORK,VOICE:".$data['work_phone']."\n";
        }
        if(!empty($data['email'])){
            $vcard .= "EMAIL;TYPE=WORK:".$data['email']."\n";
        }
        if(!empty($data['website'])){
            $vcard .= "URL;TYPE=WORK:".$data['website']."\n";
        }
        if(!empty($data['birthday'])){
//            $vcard .= "BDAY:".$data['birthday']."\n";
        }
        if (!empty($data['address_home'])) {
            $vcard .= "ADR;TYPE=HOME:;;"
                . $data['address_home']['street'] . ";"
//                . $data['address_home']['city'] . ";"
//                . $data['address_home']['state'] . ";"
//                . $data['address_home']['postal'] . ";"
                . $data['address_home']['country'] . "\n";
        }

        if (!empty($data['address_work'])) {
            $vcard .= "ADR;TYPE=WORK:;;"
                . $data['address_work']['street'] . ";"
//                . $data['address_work']['city'] . ";"
//                . $data['address_work']['state'] . ";"
//                . $data['address_work']['postal'] . ";"
                . $data['address_work']['country'] . "\n";
        }
        if(!empty($data['website'])){
            $vcard .= "URL:".$data['website']."\n";
        }
        if(!empty($data['organization'])){
            $vcard .= "ORG:".$data['organization']."\n";
        }
        if(!empty($data['job_title'])){
            $vcard .= "TITLE:".$data['job_title']."\n";
        }
        if(!empty($data['image'])){
//            $vcard .= "TITLE:".$data['job_title']."\n";
//            $vcard .= "PHOTO;VALUE=URL;TYPE=JPEG:https://dummyimage.com/100x100/000/fff.jpg&text=dev"."\n";
        }

        $vcard .= "END:VCARD";

        // generate QR code
        QRcode::png($vcard, $filename, QR_ECLEVEL_H, 5);

        ob_start();
        QRcode::png($vcard, null, QR_ECLEVEL_H, 5);
        $imageString = base64_encode(ob_get_contents());
        ob_end_clean();

        return '<img src="data:image/png;base64,' . $imageString . '" class="qr-image" />';
    }

    function generateVCardQRCodeWithLogo($data, $filename = 'contact.png', $logoPath = null, $size = 5) {
        require_once 'phpqrcode/qrlib.php';
        $logoPath = 'assets/img/logo-depan/nusantara-center-with-border.png';
        // --- susun vCard versi 3.0
        $vcard  = "BEGIN:VCARD\n";
        $vcard .= "VERSION:3.0\n";
        $vcard .= "N:" . $data['last_name'] . ";" . $data['first_name'] . ";;" . $data['prefix'] . ";\n";
        $vcard .= "FN:" . $data['first_name'] . " " . $data['last_name'] . "\n";

        if (!empty($data['phone'])) {
            $vcard .= "TEL;TYPE=CELL:" . $data['phone'] . "\n";
        }
        if (!empty($data['work_phone'])) {
            $vcard .= "TEL;TYPE=WORK,VOICE:" . $data['work_phone'] . "\n";
        }
        if (!empty($data['email'])) {
            $vcard .= "EMAIL;TYPE=WORK:" . $data['email'] . "\n";
        }
        if (!empty($data['website'])) {
            $vcard .= "URL;TYPE=WORK:" . $data['website'] . "\n";
        }
        if (!empty($data['address_home'])) {
            $vcard .= "ADR;TYPE=HOME:;;"
                . $data['address_home']['street'] . ";"
                . $data['address_home']['city'] . ";"
                . $data['address_home']['state'] . ";"
                . $data['address_home']['postal'] . ";"
                . $data['address_home']['country'] . "\n";
        }
        if (!empty($data['address_work'])) {
            $vcard .= "ADR;TYPE=WORK:;;"
                . $data['address_work']['street'] . ";"
                . $data['address_work']['city'] . ";"
                . $data['address_work']['state'] . ";"
                . $data['address_work']['postal'] . ";"
                . $data['address_work']['country'] . "\n";
        }
        if (!empty($data['organization'])) {
            $vcard .= "ORG:" . $data['organization'] . "\n";
        }
        if (!empty($data['job_title'])) {
            $vcard .= "TITLE:" . $data['job_title'] . "\n";
        }
        if (!empty($data['image'])) {
            $vcard .= "PHOTO;VALUE=URL;TYPE=JPEG:" . $data['image'] . "\n";
        }
        $vcard .= "END:VCARD";

        // --- pastikan folder tujuan ada
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // --- Step 1: generate QR code ke file
        QRcode::png($vcard, $filename, QR_ECLEVEL_H, $size);

        // --- Step 2: kalau ada logo → tempelkan
        if ($logoPath && file_exists($logoPath)) {
            $qrImage   = imagecreatefrompng($filename);
            $qrWidth   = imagesx($qrImage);
            $qrHeight  = imagesy($qrImage);

            $logoImage = imagecreatefrompng($logoPath);
            $logoWidth  = imagesx($logoImage);
            $logoHeight = imagesy($logoImage);

            // resize logo (1/5 dari QR)
            $logoQRWidth  = $qrWidth / 5;
            $scale        = $logoWidth / $logoQRWidth;
            $logoQRHeight = $logoHeight / $scale;

            $posX = ($qrWidth - $logoQRWidth) / 2;
            $posY = ($qrHeight - $logoQRHeight) / 2;

            imagecopyresampled(
                $qrImage,
                $logoImage,
                $posX, $posY, 0, 0,
                $logoQRWidth, $logoQRHeight,
                $logoWidth, $logoHeight
            );

            imagepng($qrImage, $filename); // overwrite dengan QR + logo
            imagedestroy($qrImage);
            imagedestroy($logoImage);
        }

        // --- Step 3: return sebagai <img>
        ob_start();
        readfile($filename);
        $imageString = base64_encode(ob_get_contents());
        ob_end_clean();

        return '<img src="data:image/png;base64,' . $imageString . '" class="qr-image" />';
    }

}