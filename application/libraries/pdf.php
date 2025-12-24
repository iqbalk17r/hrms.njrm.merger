<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 12/13/19, 2:35 PM
 *  * Last Modified: 12/13/19, 2:33 PM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

require_once(dirname(__FILE__) . '/fiky_pdf_directory/autoload.inc.php');
Dompdf\Autoloader::register();
use Dompdf\Dompdf;

class Pdf extends Dompdf
{
    /**
     * Get an instance of CodeIgniter
     *
     * @access	protected
     * @return	void
     */
    protected function ci()
    {
        return get_instance();
    }

    /**
     * Load a CodeIgniter view into domPDF
     *
     * @access	public
     * @param	string	$view The view to load
     * @param	array	$data The view data
     * @return	void
     */
    public function load_view($view, $data = array())
    {
        $html = $this->ci()->load->view($view, $data, TRUE);
        $this->load_html($html);
    }
}
