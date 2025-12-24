<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/29/19 10:38 AM
 *  * Last Modified: 1/20/17 2:18 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */



//require_once(dirname(__FILE__) . '/dompdf/dompdf_config.inc.php');

class Nyetak extends ecopos_php
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

//	/**
//	 * Load a CodeIgniter view into domPDF
//	 *
//	 * @access	public
//	 * @param	string	$view The view to load
//	 * @param	array	$data The view data
//	 * @return	void
//	 */
//	public function load_view($view, $data = array())
//	{
//		$html = $this->ci()->load->view($view, $data, TRUE);
//
//		$this->load_html($html);
//	}
}
