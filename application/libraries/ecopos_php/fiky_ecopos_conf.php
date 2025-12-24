<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/29/19 10:52 AM
 *  * Last Modified: 5/29/19 9:39 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

/**
 * This is a demo script for the functions of the PHP ESC/POS print driver,
 * Escpos.php.
 *
 * Most printers implement only a subset of the functionality of the driver, so
 * will not render this output correctly in all cases.
 *
 * @author Michael Billington <michael.billington@gmail.com>
 */
require __DIR__ . './autoload.php';
class Fiky_ecopos_conf
{
    public function __construct()
    {
        include_once("src\Mike42\Escpos\PrintConnectors\WindowsPrintConnector.php");
/*        use Mike42\Escpos\Printer;
        use Mike42\Escpos\PrintConnectors\FilePrintConnector;
        use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
        use Mike42\Escpos\EscposImage;*/
    }


}


?>