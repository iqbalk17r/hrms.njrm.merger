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
use Dompdf\Options;

class Fiky_pdf extends Dompdf
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
	public function what_u_can_see($view, $data = array())
	{
        $html = $this->ci()->load->view($view, $data, TRUE);
        $this->load_html($html);
	}

	public function set_what_u_have_paper($type,$orientation)
    {
	    $this->set_paper($type,$orientation);
    }
    public function set_what_u_will_generate()
    {
        $this->render();
    }
    public function set_option_parser($param)
    {
        $options = new Options();
        $options->set('enable_html5_parser', $param);
        new Dompdf($options);
    }

}
