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

require_once(dirname(__FILE__) . '/mpdf_610/vendor/autoload.php');

class Fiky_pdf_mpdf_extension extends mPDF
{
	/**
	 * Get an instance of CodeIgniter
	 *
	 * @access	protected
	 * @return	void
	 */

    protected function ci()
    {
       // $mpdf = new mPDF();
        return get_instance();

    }

/*    public function __construct($param){
        new mPDF($param);
    }*/

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
        $this->WriteHTML($html);
	}

}
