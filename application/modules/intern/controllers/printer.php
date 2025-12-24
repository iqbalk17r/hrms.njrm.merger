<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Printer extends MX_Controller{
    
    function __construct(){
        parent::__construct();

		$this->load->model(array('m_cr_sj'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt','fiky_hexstring')); 
	
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU GA, SILAHKAN PILIH MENU YANG ADA";	
			$this->template->display('ga/cr_sj/v_index',$data);
	}
	
	function print_text($nodok_ecn){
		//$nodok="SBM171100007";
		$nodok=$this->encrypt->decode($this->fiky_hexstring->h2b(trim($nodok_ecn)));
		$param=" and trim(fc_trxno)='$nodok'";
		
		$jml=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB($param)->num_rows();		
		$dtl_mst=$this->m_cr_sj->q_d_transaksi_vw_T_INMST_WEB($param)->row_array();
		$dtl_branch=$this->m_cr_sj->q_branch()->row_array();
		
		$dtl_inmst=$this->m_cr_sj->q_d_transaksi_vw_T_INMST_WEB($param)->row_array();
		$dtl_indtl=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB($param)->row_array();
		$isine=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB($param)->result();
		switch ($jml) {
			case 1: $isi1=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(0); $isi2=null;$isi3=null;$isi4=null;$isi5=null;$isi6=null;$isi7=null;$isi8=null;$isi9=null;$isi10=null; break;		
			case 2: $isi1=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(0); 
					$isi2=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(1); $isi3=null;$isi4=null;$isi5=null;$isi6=null;$isi7=null;$isi8=null;$isi9=null;$isi10=null; break;
			case 3: $isi1=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(0); 
					$isi2=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(1);
					$isi3=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(2); $isi4=null;$isi5=null;$isi6=null;$isi7=null;$isi8=null;$isi9=null;$isi10=null; break;
			case 4: $isi1=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(0); 
					$isi2=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(1);
					$isi3=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(2); 
					$isi4=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(3); $isi5=null;$isi6=null;$isi7=null;$isi8=null;$isi9=null;$isi10=null; break;
			case 5: $isi1=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(0); 
					$isi2=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(1);
					$isi3=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(2); 
					$isi4=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(3); 
					$isi5=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(4); $isi6=null;$isi7=null;$isi8=null;$isi9=null;$isi10=null; break;
			case 6: $isi1=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(0); 
					$isi2=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(1);
					$isi3=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(2); 
					$isi4=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(3); 
					$isi5=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(4);
					$isi6=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(5); $isi7=null;$isi8=null;$isi9=null;$isi10=null; break;
			case 7: $isi1=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(0); 
					$isi2=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(1);
					$isi3=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(2); 
					$isi4=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(3); 
					$isi5=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(4);
					$isi6=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(5);
					$isi7=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(6); $isi8=null; $isi9=null; $isi10=null; break;
			case 8: $isi1=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(0); 
					$isi2=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(1);
					$isi3=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(2); 
					$isi4=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(3); 
					$isi5=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(4);
					$isi6=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(5);
					$isi7=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(6);
					$isi8=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(7); $isi9=null;$isi10=null; break;
			case 9: $isi1=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(0); 
					$isi2=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(1);
					$isi3=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(2); 
					$isi4=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(3); 
					$isi5=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(4);
					$isi6=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(5);
					$isi7=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(6);
					$isi8=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(7);
					$isi9=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(8); $isi10=null; break;
			case 10:$isi1=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(0); 
					$isi2=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(1);
					$isi3=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(2); 
					$isi4=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(3); 
					$isi5=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(4);
					$isi6=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(5);
					$isi7=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(6);
					$isi8=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(7);
					$isi9=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(8);
					$isi10=$this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB_PRINT($param)->row_array(9); break;
		}
		
		$hari=date('d');		
		switch (date('m')) {
			case 1: $bln='JANUARI'; break;
			case 2: $bln='FEBRUARI'; break;
			case 3: $bln='MARET'; break;
			case 4: $bln='APRIL'; break;
			case 5: $bln='MEI'; break;
			case 6: $bln='JUNI'; break;
			case 7: $bln='JULI'; break;
			case 8: $bln='AGUSTUS'; break;
			case 9: $bln='SEPTEMBER'; break;
			case 10: $bln='OKTOBER'; break;
			case 11: $bln='NOVEMBER'; break;
			case 12: $bln='DESEMBER'; break;
		}
		
		$thn=date('Y');
		$tgl=$hari.' '.$bln.' '.$thn;
		$tgl;
		//$isi2['STOCKNAME'];
		
		$kertas=chr(27).chr(67).chr(33);		
		$feed=chr(12);
		$condensed=chr(15);
		$gede=chr(15).chr(14);
		
	
$Data  = "<header size=\"FONT_32PX\">".trim($dtl_branch['fv_name'])."</header>"."\n";
$Data .= "<header size=\"FONT_32PX\">".trim($dtl_branch['fv_add1'])."</header>"."\n";
$Data .= "<header size=\"FONT_32PX\">".trim($dtl_branch['fv_city'])."</header>"."\n";
$Data .= "<header size=\"FONT_24PX\">".""."</header>"."\n";
$Data .= "<header size=\"FONT_32PX\">"."SLIP SURAT JALAN"."</header>"."\n";
$Data .= "<printdate size=\"FONT_24PX\">"."TANGGAL CETAK : "."</printdate>"."\n";
$Data .= "<line size=\"FONT_24PX\">"."----------------------------------------------------------------"."</line>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."No. Bukti     : ".$nodok." / ".date('d-m-Y', strtotime($dtl_inmst['fv_entrydate']))."</text>"." \n";  
$Data .= "<text size=\"FONT_24PX\">"."No. Pol       : ".trim($dtl_inmst['fc_nopol'])."</text>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."Sopir / Hp    : ".trim($dtl_inmst['fc_namedriver'])." / ".trim($dtl_inmst['fc_hpdriver'])."</text>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."Expedisi      : ".trim($dtl_inmst['fv_expdname'])."</text>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."Gudang        : ".trim($dtl_inmst['locname'])."</text>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."Supplier      : ".trim($dtl_inmst['fv_suppname'])."</text>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."No. PO        : ".trim($dtl_inmst['fc_fromno'])."</text>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."SJ Supp / Tgl : ".trim($dtl_inmst['fv_reference'])." / ".date('d-m-Y', strtotime($dtl_inmst['fv_reftgl']))."</text>"." \n";  
$Data .= "<text size=\"FONT_24PX\">"."Pelanggan     : ".trim($dtl_inmst['fv_custname'])."</text>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."Alamat        : ".trim($dtl_inmst['fv_custadd1'])."</text>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."Kota          : ".trim($dtl_inmst['fv_custcity'])."</text>"."\n";
$Data .= "<line size=\"FONT_24PX\">"."----------------------------------------------------------------"."</line>"."\n";
/*$Data .= "<text size=\"FONT_24PX\">"." NO |".str_pad(strtoupper(trim($isi1['STOCKNAME'])),34)."| JUMLAH  |  SATUAN   "."</text>"."\n";*/
$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim('NO')),2)." | ".str_pad(strtoupper(trim('NAMA BARANG')),36)." |  ".str_pad(strtoupper(trim('JUMLAH')),7)." | ".str_pad(strtoupper(trim('SATUAN')),8)."</text>"."\n";
$Data .= "<line size=\"FONT_24PX\">"."----------------------------------------------------------------"."</line>"."\n";
switch ($jml) {
	case 1: 
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi1['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi1['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi1['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi1['packname'])),8)."</text>"."\n";     break;
	case 2:
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi1['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi1['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi1['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi1['packname'])),8)."</text>"."\n";	
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi2['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi2['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi2['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi2['packname'])),8)."</text>"."\n";     break;
	case 3: 
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi1['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi1['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi1['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi1['packname'])),8)."</text>"."\n";	
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi2['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi2['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi2['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi2['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi3['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi3['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi3['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi3['packname'])),8)."</text>"."\n";     break;
	case 4: 
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi1['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi1['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi1['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi1['packname'])),8)."</text>"."\n";	
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi2['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi2['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi2['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi2['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi3['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi3['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi3['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi3['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi4['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi4['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi4['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi4['packname'])),8)."</text>"."\n";     break;
	case 5: 
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi1['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi1['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi1['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi1['packname'])),8)."</text>"."\n";	
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi2['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi2['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi2['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi2['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi3['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi3['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi3['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi3['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi4['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi4['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi4['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi4['packname'])),8)."</text>"."\n";     break;
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi5['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi5['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi5['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi5['packname'])),8)."</text>"."\n"; 
	case 6: 
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi1['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi1['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi1['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi1['packname'])),8)."</text>"."\n";	
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi2['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi2['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi2['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi2['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi3['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi3['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi3['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi3['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi4['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi4['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi4['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi4['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi5['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi5['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi5['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi5['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi6['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi6['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi6['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi6['packname'])),8)."</text>"."\n"; break;
	case 7: 
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi1['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi1['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi1['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi1['packname'])),8)."</text>"."\n";	
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi2['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi2['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi2['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi2['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi3['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi3['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi3['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi3['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi4['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi4['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi4['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi4['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi5['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi5['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi5['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi5['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi6['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi6['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi6['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi6['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi7['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi7['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi7['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi7['packname'])),8)."</text>"."\n"; break; 

	case 8: 
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi1['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi1['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi1['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi1['packname'])),8)."</text>"."\n";	
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi2['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi2['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi2['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi2['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi3['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi3['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi3['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi3['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi4['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi4['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi4['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi4['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi5['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi5['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi5['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi5['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi6['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi6['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi6['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi6['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi7['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi7['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi7['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi7['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi8['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi8['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi8['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi8['packname'])),8)."</text>"."\n"; break;    
	
	case 9: 
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi1['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi1['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi1['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi1['packname'])),8)."</text>"."\n";	
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi2['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi2['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi2['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi2['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi3['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi3['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi3['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi3['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi4['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi4['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi4['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi4['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi5['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi5['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi5['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi5['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi6['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi6['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi6['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi6['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi7['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi7['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi7['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi7['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi8['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi8['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi8['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi8['packname'])),8)."</text>"."\n"; 
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi9['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi9['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi9['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi9['packname'])),8)."</text>"."\n";     break;
   case 10: 
    $Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi1['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi1['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi1['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi1['packname'])),8)."</text>"."\n";	
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi2['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi2['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi2['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi2['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi3['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi3['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi3['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi3['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi4['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi4['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi4['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi4['packname'])),8)."</text>"."\n";     
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi5['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi5['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi5['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi5['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi6['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi6['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi6['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi6['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi7['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi7['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi7['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi7['packname'])),8)."</text>"."\n";
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi8['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi8['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi8['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi8['packname'])),8)."</text>"."\n"; 
	$Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi9['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi9['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi9['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi9['packname'])),8)."</text>"."\n";  
    $Data .= "<text size=\"FONT_24PX\">"." ".str_pad(strtoupper(trim($isi10['fn_nomor'])),2)." | ".str_pad(strtoupper(trim($isi10['stockname'])),36)." |  ".str_pad(strtoupper(trim($isi10['fn_qtyrec'])),7," ",STR_PAD_LEFT)." | ".str_pad(strtoupper(trim($isi10['packname'])),8)."</text>"."\n"; break;
}   
$Data .= "<line size=\"FONT_24PX\">"."----------------------------------------------------------------"."</line>"."\n";
$Data .= "<line size=\"FONT_24PX\">"."Catatan: </line>"."\n";
 
$Data .= "<line size=\"FONT_24PX\">".str_replace(PHP_EOL,'',trim($dtl_inmst['ft_note']))."</line>"."\n";
$Data .= "<line size=\"FONT_24PX\">".""."</line>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."      Operator             Sopir              Penerima          "."</text>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."                                                                "."</text>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."                                                                "."</text>"."\n";
$Data .= "<text size=\"FONT_24PX\">"."  (              )   (               )   (               )      "."</text>"."\n";
$Data .= "<line size=\"FONT_24PX\">"."----------------------------------------------------------------"."</line>"."\n";
$Data .= "<text size=\"FONT_24PX\"></text>"."\n";

			
			
		$handle = fopen("FILE.RPT", "w");
		fwrite($handle, $Data);
		fclose($handle);

		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename('FILE.RPT'));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize('FILE.RPT'));
		readfile('FILE.RPT');
		exit;	
			
		//redirect("intern/cr_sj/form_cr_sj");


	}
	
	function json_cr_sj($nodok){
		$param=" and FC_TRXNO='$nodok'";

		header('Content-Type: application/json');
        echo json_encode(array(
            'master' => $this->m_cr_sj->q_d_transaksi_vw_T_INMST_WEB($param)->result(),
            'detail' => $this->m_cr_sj->q_d_transaksi_vw_T_INDTL_WEB($param)->result(), 
            'branch' => $this->m_cr_sj->q_branch()->result(),
        
        ));
	}
	
	function cetak_cr_sj($nodok){
		$data['jsonfile'] = "intern/printer/json_cr_sj/$nodok";
		$data['report_file'] = 'assets/mrt/cetak_cr_sj.mrt';
		$this->load->view("intern/cr_sj/sti_cetak_cr_sj",$data);
	}

	
	
}