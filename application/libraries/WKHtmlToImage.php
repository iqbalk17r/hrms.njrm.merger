<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class WKHtmlToImage
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    function millitime()
    {
        $microtime = microtime();
        $comps = explode(' ', $microtime);
        return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
    }

    public function convert($html = 'Tukang Pecut Juru Ketik', $width = 300, $height = 300, $output = null, $debug = false)
    {
        $binary = $this->CI->config->item('wkhtmltopdf_binary');
        if (!file_exists($binary)) {
            $binary = FCPATH . APPPATH . 'third_party\wkhtmltopdf\bin\wkhtmltoimage.exe';
        }
        if (!file_exists('assets/data/temporary')) {
            mkdir('assets/data/temporary', 0777, true);
        }
        $temporary_html = 'assets/data/temporary/' . $this->millitime() . '.html';
        $temporary_image = is_null($output) ? 'assets/data/temporary/' . $this->millitime() . '.jpg' : $output;
        file_put_contents($temporary_html, $html);
        $command = $binary . ' --crop-w ' . $width . ' --crop-h ' . $height . ' ' . $temporary_html . ' ' . $temporary_image;
        exec($command . ' 2>&1', $outputs);
        if ($debug) {
            echo $command . '<br/>';
            foreach ($outputs as $output) {
                echo $output . '<br/>';
            }
        }

        unlink($temporary_html);
        return $temporary_image;
    }
}
