<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/29/19 10:54 AM
 *  * Last Modified: 4/15/19 8:31 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */


//require_once(dirname(__FILE__) . '/ecopos_php/fiky_ecopos_conf.php');
require_once(dirname(__FILE__) . '/ecopos_php/autoload.php');
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\EscposImage;

class Fiky_ecopos_printer
{

    private $CI;
    private $connector;
    private $printer;
    // TODO: printer settings
    // Make this configurable by printer (32 or 48 probably)
    private $printer_width = 32;
    function __construct()
    {
        $this->CI =& get_instance(); // This allows you to call models or other CI objects with $this->CI->...
    }
    function windowsprintconnector($p = null){
        return $this->connector = new WindowsPrintConnector($p);

    }
    function printer($p = null){
        return $this->printer = new Printer($this->connector);
    }
    function connect($ip_address, $port)
    {
        $this->connector = new NetworkPrintConnector($ip_address, $port);
        $this->printer = new Printer($this->connector);
    }
    private function check_connection()
    {
        if (!$this->connector OR !$this->printer OR !is_a($this->printer, 'Mike42\Escpos\Printer')) {
            throw new Exception("Tried to create receipt without being connected to a printer.");
        }
    }

    private function check_lpt()
    {
        if (!$this->connector OR !$this->printer OR !is_a($this->printer, 'Mike42\Escpos\Printer')) {
            throw new Exception("Tried to create receipt without being connected to a printer.");
        }
    }

    public function close_after_exception()
    {
        if (isset($this->printer) && is_a($this->printer, 'Mike42\Escpos\Printer')) {
            $this->printer->close();
        }
        $this->connector = null;
        $this->printer = null;
        $this->emc_printer = null;
    }
    // Calls printer->text and adds new line
    private function add_line($text = "", $should_wordwrap = true)
    {
        $text = $should_wordwrap ? wordwrap($text, $this->printer_width) : $text;
        $this->printer->text($text."\n");
    }
    public function print_test_receipt($text = "")
    {
        $this->check_connection();
        $this->printer->setJustification(Printer::JUSTIFY_CENTER);
        $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $this->add_line("TESTING");
        $this->add_line("Receipt Print");
        $this->printer->selectPrintMode();
        $this->add_line(); // blank line
        $this->add_line($text);
        $this->add_line(); // blank line
        $this->add_line(date('Y-m-d H:i:s'));
        $this->printer->cut(Printer::CUT_PARTIAL);
        $this->printer->close();
    }

    public function print_test_lpt($text = "")
    {
        //$this->check_lpt();
        //$this->printer->setJustification(Printer::JUSTIFY_CENTER);
        //$this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $this->add_line("TESTING");
        $this->add_line("Receipt Print");
        $this->printer->selectPrintMode();
        $this->add_line(); // blank line
        $this->add_line($text);
        $this->add_line(); // blank line
        $this->add_line(date('Y-m-d H:i:s'));
        $this->printer->cut(Printer::CUT_PARTIAL);
        $this->printer->close();
    }
}
