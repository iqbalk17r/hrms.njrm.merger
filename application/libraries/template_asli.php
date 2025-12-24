<?php
class Template{
    protected $_CI;
    
	function __construct(){
        $this->_CI=&get_instance();
		$this->_CI->load->model(array('master/m_user','master/m_menu'));
		
    }
	
    function display($template,$data=null){		
		//$menudata['modul_menu']=$this->_CI->m_user->list_modulusr()->result();
		$menudata['list_menu_main']=$this->_CI->m_menu->list_menu_sidebar_main()->result();
		$menudata['list_menu_sub']=$this->_CI->m_menu->list_menu_sidebar_sub()->result();
		$menudata['list_menu_submenu']=$this->_CI->m_menu->list_menu_sidebar_submenu()->result();
		$headerdata['user_menu']=$this->_CI->m_user->user_profile()->row_array();
		$headerdata['user_online']=$this->_CI->m_user->user_online()->result();
		$headerdata['jumlah_online']=$this->_CI->m_user->user_online()->num_rows();
		$headerdata['list_login']=$this->_CI->m_user->q_user_last_login()->result();
 
		$tmp['_content']=$this->_CI->load->view($template,$data,true);
        $tmp['_header']=$this->_CI->load->view('template/header_nbi',$headerdata,true);
        $tmp['_sidebar']=$this->_CI->load->view('template/sidebar',$menudata,true);
		$tmp['cek_kontrak']=$this->_CI->m_menu->q_kontrak()->num_rows();
        $tmp['cek_pensiun']=$this->_CI->m_menu->q_pensiun()->num_rows(); 
       
		
		
        $this->_CI->load->view('/template.php',$tmp);
    }
}