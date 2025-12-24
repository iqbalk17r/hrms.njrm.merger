<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Cr_sj_mob extends MX_Controller{
    
    function __construct(){
        parent::__construct();

		$this->load->model(array('m_cr_sj'));
        $this->load->library(array('form_validation','template','upload','pdf','encrypt','fiky_hexstring','image_lib','pdf','Excel_generator'));
	
/* 		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        } */
    }
	
	function index(){
			$data['title']="SELAMAT DATANG DI MENU,SILAHKAN PILIH MENU YANG ADA";
			$this->template->display('ga/cr_sj/v_index',$data);
	}
	
	
	function downloadTrx(){
		$startDate=$this->input->post('startDate');
		$endDate=$this->input->post('endDate');
		$userId=$this->input->post('userId');
		
		$param=" and fc_podate between '$startDate' and '$endDate'";
		$paramin=" and fc_entrydate between '$startDate' and '$endDate'";
		$parampopps="";
		$paramnumber="";
		$pomst = $this->m_cr_sj->pomst($param)->result();
		$podtl = $this->m_cr_sj->podtl($param)->result();
		$popps = $this->m_cr_sj->popps($param)->result();
		$inmst = $this->m_cr_sj->q_t_inmst_web($paramin)->result();
		$indtl = $this->m_cr_sj->q_t_indtl_web($paramin)->result();
		$backupnumber = $this->m_cr_sj->q_mst_backup_number_result_where($paramnumber)->result();
		header("Content-Type: text/json");
		echo json_encode(
			array(
			'success' => true,
			'message' => '',
			'body' => array(
				'po' => $pomst,
				'podtl' => $podtl,
				'popps' => $popps,
				'inmst' => $inmst,
				'indtl' => $indtl,
				'backupnumber' => $backupnumber,
			)	
			)
		, JSON_PRETTY_PRINT);
	}
	
	function downloadMst(){
		$startDate=$this->input->post('startDate');
		$endDate=$this->input->post('endDate');
		$userId=trim($this->input->post('userId'));
		//$lb=$this->m_cr_sj->q_branch()->row_array();
		//$branch=trim($lb['fc_branch']);
		
		$param="";
		//$paramuser=" and trim(username)='$userId' and trim(branch)='$branch'";
		$paramuser=" and trim(username)='$userId'";
		$paramin=" and fc_entrydate between '$startDate' and '$endDate'";
		$customer = $this->m_cr_sj->q_mst_customer($param)->result();
		$expedisi = $this->m_cr_sj->q_mst_expedisi($param)->result();
		$gudang = $this->m_cr_sj->q_mst_gudang($param)->result();
		$cabang = $this->m_cr_sj->q_mst_cabang($param)->result();
		$supplier = $this->m_cr_sj->q_mst_supplier($param)->result();
		$stock = $this->m_cr_sj->q_mst_stock($param)->result();
		$mpack = $this->m_cr_sj->q_mst_mpack($param)->result();
		$user = $this->m_cr_sj->q_mst_user($paramuser)->result();
		
		

		header("Content-Type: text/json");
		echo json_encode(
			array(
			'success' => true,
			'message' => '',
			'body' => array(
				'customer' => $customer,
				'expedisi' => $expedisi,
				'gudang' => $gudang,
				'supplier' => $supplier,
				'cabang' => $cabang,
				'user' => $user,
				'stock' => $stock,
				'mpack' => $mpack,

			)	
			)
		 , JSON_PRETTY_PRINT );
	}
	
	function uploadTrx(){

		
		log_message('info', current_url());
        $json = file_get_contents('php://input');
        log_message('info', $json);
        $array = json_decode($json);
        $branch = $array->branch;
        $userid = $array->userid;
        ///$schema = $array->schema;
        $uploaddate = date('Y-m-d H:i:s');
		$wheredel =  array(
                'fc_branch' => $branch
				/* ,'userid' => $userid */ );
        $wheredelresult = array(
            'userid' => $userid ,
            'uploadname' => 'inmstmob');
		$wheredeluserid = array(
                'userid' => $userid );
            
		$this->m_cr_sj->q_DelTmpIndtl($wheredel);
		$this->m_cr_sj->q_DelTmpInmst($wheredel);
		$this->m_cr_sj->q_DelResultUpload($wheredelresult);
		$this->m_cr_sj->q_DelBackupNumber($wheredeluserid);
		
				if (is_array($array->indtl)) {
            $info = array();
            foreach($array->indtl as $index=>$row) {
				$documen = isset($row->fc_trxno) ? $row->fc_trxno : '';
                $fc_branch     = isset($row->fc_branch    ) ? $row->fc_branch     : '';
                $fc_stockcode  = isset($row->fc_stockcode ) ? $row->fc_stockcode  : '';
                $fn_nomor      = isset($row->fn_nomor     ) ? $row->fn_nomor      : 0;
                $fn_qty        = isset($row->fn_qty       ) ? $row->fn_qty        : 0;
                $fn_qtyrec     = isset($row->fn_qtyrec    ) ? $row->fn_qtyrec     : 0;
                $fn_extra      = isset($row->fn_extra     ) ? $row->fn_extra      : 0;
                $fn_extrarec   = isset($row->fn_extrarec  ) ? $row->fn_extrarec   : 0;
                $fc_reason     = isset($row->fc_reason    ) ? $row->fc_reason     : '';
                $fm_pricelist  = isset($row->fm_pricelist ) ? $row->fm_pricelist  : 0;
                $fn_disc1p     = isset($row->fn_disc1p    ) ? $row->fn_disc1p     : 0;
                $fn_disc2p     = isset($row->fn_disc2p    ) ? $row->fn_disc2p     : 0;
                $fn_disc3p     = isset($row->fn_disc3p    ) ? $row->fn_disc3p     : 0;
                $fm_formula    = isset($row->fm_formula   ) ? $row->fm_formula    : 0;
                $fc_excludeppn = isset($row->fc_excludeppn) ? $row->fc_excludeppn : '';
                $fm_brutto     = isset($row->fm_brutto    ) ? $row->fm_brutto     : 0;
                $fm_netto      = isset($row->fm_netto     ) ? $row->fm_netto      : 0;
                $fm_dpp        = isset($row->fm_dpp       ) ? $row->fm_dpp        : 0;
                $fm_ppn        = isset($row->fm_ppn       ) ? $row->fm_ppn        : 0;
                $fm_valuestock = isset($row->fm_valuestock) ? $row->fm_valuestock : 0;
                $fc_editcost   = isset($row->fc_editcost  ) ? $row->fc_editcost   : '';
                $fc_update     = isset($row->fc_update    ) ? $row->fc_update     : '';
                $fc_docno      = isset($row->fc_docno     ) ? $row->fc_docno      : '';
                $fc_taxin      = isset($row->fc_taxin     ) ? $row->fc_taxin      : '';
                $fn_pph22      = isset($row->fn_pph22     ) ? $row->fn_pph22      : 0;
                $fm_pph22      = isset($row->fm_pph22     ) ? $row->fm_pph22      : 0;
                $fn_qtygnt     = isset($row->fn_qtygnt    ) ? $row->fn_qtygnt     : 0;
                $fn_extragnt   = isset($row->fn_extragnt  ) ? $row->fn_extragnt   : 0;
                $fn_qtygntmp   = isset($row->fn_qtygntmp  ) ? $row->fn_qtygntmp   : 0;
                $fn_extragntmp = isset($row->fn_extragntmp) ? $row->fn_extragntmp : 0;
                $ft_note       = isset($row->ft_note      ) ? $row->ft_note       : '';

                array_push($info, array(
                    'fc_branch    ' => ($fc_branch     <> '') ? $fc_branch     : '',
                    'fc_trxno     ' => ($documen      <> '') ?  $documen      : '',
                    'fc_stockcode ' => ($fc_stockcode  <> '') ? $fc_stockcode  : '',
                    'fn_nomor     ' => ($fn_nomor      <> '') ? $fn_nomor      : 0,
                    'fn_qty       ' => ($fn_qty        <> '') ? $fn_qty        : 0,
                    'fn_qtyrec    ' => ($fn_qtyrec     <> '') ? $fn_qtyrec     : 0,
                    'fn_extra     ' => ($fn_extra      <> '') ? $fn_extra      : 0,
                    'fn_extrarec  ' => ($fn_extrarec   <> '') ? $fn_extrarec   : 0,
                    'fc_reason    ' => ($fc_reason     <> '') ? $fc_reason     : '',
                    'fm_pricelist ' => ($fm_pricelist  <> '') ? $fm_pricelist  : 0,
                    'fn_disc1p    ' => ($fn_disc1p     <> '') ? $fn_disc1p     : 0,
                    'fn_disc2p    ' => ($fn_disc2p     <> '') ? $fn_disc2p     : 0,
                    'fn_disc3p    ' => ($fn_disc3p     <> '') ? $fn_disc3p     : 0,
                    'fm_formula   ' => ($fm_formula    <> '') ? $fm_formula    : 0,
                    'fc_excludeppn' => ($fc_excludeppn <> '') ? $fc_excludeppn : '',
                    'fm_brutto    ' => ($fm_brutto     <> '') ? $fm_brutto     : 0,
                    'fm_netto     ' => ($fm_netto      <> '') ? $fm_netto      : 0,
                    'fm_dpp       ' => ($fm_dpp        <> '') ? $fm_dpp        : 0,
                    'fm_ppn       ' => ($fm_ppn        <> '') ? $fm_ppn        : 0,
                    'fm_valuestock' => ($fm_valuestock <> '') ? $fm_valuestock : 0,
                    'fc_editcost  ' => ($fc_editcost   <> '') ? $fc_editcost   : '',
                    'fc_update    ' => ($fc_update     <> '') ? $fc_update     : '',
                    'fc_docno     ' => ($fc_docno      <> '') ? $fc_docno      : '',
                    'fc_taxin     ' => ($fc_taxin      <> '') ? $fc_taxin      : '',
                    'fn_pph22     ' => ($fn_pph22      <> '') ? $fn_pph22      : 0,
                    'fm_pph22     ' => ($fm_pph22      <> '') ? $fm_pph22      : 0,
                    'fn_qtygnt    ' => ($fn_qtygnt     <> '') ? $fn_qtygnt     : 0,
                    'fn_extragnt  ' => ($fn_extragnt   <> '') ? $fn_extragnt   : 0,
                    'fn_qtygntmp  ' => ($fn_qtygntmp   <> '') ? $fn_qtygntmp   : 0,
                    'fn_extragntmp' => ($fn_extragntmp <> '') ? $fn_extragntmp : 0,
                    'ft_note      ' => ($ft_note       <> '') ? $ft_note       : '',
                ));
            }

            if(!empty($info)){
                if($this->m_cr_sj->q_createTrxIndtl($info)){

                } 
            }
        } 
		
		if (is_array($array->inmst)) {
            $info = array();
            foreach($array->inmst as $index=>$row) {
                $documen = isset($row->fc_trxno) ? $row->fc_trxno : null;
                $fc_branch = isset($row->fc_branch) ? $row->fc_branch : null;
                $fd_entrydate = isset($row->fd_entrydate) ? $row->fd_entrydate : null;
                $fc_operator = isset($row->fc_operator) ? $row->fc_operator : null;
                $fc_status = isset($row->fc_status) ? $row->fc_status : null;
                $fc_loccode = isset($row->fc_loccode) ? $row->fc_loccode : null;
                $fc_from = isset($row->fc_from) ? $row->fc_from : null;
                $fc_fromno = isset($row->fc_fromno) ? $row->fc_fromno : null;
                $fv_reference = isset($row->fv_reference) ? $row->fv_reference : null;
                $fd_reftgl = isset($row->fd_reftgl) ? $row->fd_reftgl : null;
                $fc_fromcode = isset($row->fc_fromcode) ? $row->fc_fromcode : null;
                $fn_item = isset($row->fn_item) ? $row->fn_item : null;
                $fm_netto = isset($row->fm_netto) ? $row->fm_netto : null;
                $fm_dpp = isset($row->fm_dpp) ? $row->fm_dpp : null;
                $fm_ppn = isset($row->fm_ppn) ? $row->fm_ppn : null;
                $fm_valuestock = isset($row->fm_valuestock) ? $row->fm_valuestock : null;
                $fd_updatedate = isset($row->fd_updatedate) ? $row->fd_updatedate : null;
                $fc_reason = isset($row->fc_reason) ? $row->fc_reason : null;
                $fc_userupd = isset($row->fc_userupd) ? $row->fc_userupd : null;
                $ft_note = isset($row->ft_note) ? $row->ft_note : null;
                $fn_ppn = isset($row->fn_ppn) ? $row->fn_ppn : null;
                $fc_idbu = isset($row->fc_idbu) ? $row->fc_idbu : null;
                $fc_trfwh = isset($row->fc_trfwh) ? $row->fc_trfwh : null;
                $fc_hubrk = isset($row->fc_hubrk) ? $row->fc_hubrk : null;
                $fd_tglconf = isset($row->fd_tglconf) ? $row->fd_tglconf : null;
                $fc_userconf = isset($row->fc_userconf) ? $row->fc_userconf : null;
                $fn_pph22 = isset($row->fn_pph22) ? $row->fn_pph22 : null;
                $fm_ttlpph22 = isset($row->fm_ttlpph22) ? $row->fm_ttlpph22 : null;
                $fc_statusgnt = isset($row->fc_statusgnt) ? $row->fc_statusgnt : null;
                $fc_expedisi = isset($row->fc_expedisi) ? $row->fc_expedisi : null;
                $fc_nopol = isset($row->fc_nopol) ? $row->fc_nopol : null;
                $fc_namedriver = isset($row->fc_namedriver) ? $row->fc_namedriver : null;
                $fc_hpdriver = isset($row->fc_hpdriver) ? $row->fc_hpdriver : null;
                $fc_franco = isset($row->fc_franco) ? $row->fc_franco : null;
                $ft_image = isset($row->ft_image) ? $row->ft_image : null;
                $fd_uploaddate = $uploaddate;

                array_push($info, array(
                    'fc_branch' => ($fc_branch <> '') ? $fc_branch : null,
                    'fc_trxno' => ( $documen <> '') ?  $documen : null,
                    'fd_entrydate' => ($fd_entrydate <> '') ? $fd_entrydate : null,
                    'fc_operator' => ($fc_operator <> '') ? $fc_operator : null,
                    'fc_status' => ($fc_status <> '') ? $fc_status : null,
                    'fc_loccode' => ($fc_loccode <> '') ? $fc_loccode : null,
                    'fc_from' => ($fc_from <> '') ? $fc_from : null,
                    'fc_fromno' => ($fc_fromno <> '') ? $fc_fromno : null,
                    'fv_reference' => ($fv_reference <> '') ? $fv_reference : null,
                    'fd_reftgl' => ($fd_reftgl <> '') ? $fd_reftgl : null,
                    'fc_fromcode' => ($fc_fromcode <> '') ? $fc_fromcode : null,
                    'fn_item' => ($fn_item <> '') ? $fn_item : null,
                    'fm_netto' => ($fm_netto <> '') ? $fm_netto : null,
                    'fm_dpp' => ($fm_dpp <> '') ? $fm_dpp : null,
                    'fm_ppn' => ($fm_ppn <> '') ? $fm_ppn : null,
                    'fm_valuestock' => ($fm_valuestock <> '') ? $fm_valuestock : null,
                    'fd_updatedate' => ($fd_updatedate <> '') ? $fd_updatedate : null,
                    'fc_reason' => ($fc_reason <> '') ? $fc_reason : null,
                    'fc_userupd' => ($fc_userupd <> '') ? $fc_userupd : null,
                    'ft_note' => ($ft_note <> '') ? $ft_note : null,
                    'fn_ppn' => ($fn_ppn <> '') ? $fn_ppn : null,
                    'fc_idbu' => ($fc_idbu <> '') ? $fc_idbu : null,
                    'fc_trfwh' => ($fc_trfwh <> '') ? $fc_trfwh : null,
                    'fc_hubrk' => ($fc_hubrk <> '') ? $fc_hubrk : null,
                    'fd_tglconf' => ($fd_tglconf <> '') ? $fd_tglconf : null,
                    'fc_userconf' => ($fc_userconf <> '') ? $fc_userconf : null,
                    'fn_pph22' => ($fn_pph22 <> '') ? $fn_pph22 : null,
                    'fm_ttlpph22' => ($fm_ttlpph22 <> '') ? $fm_ttlpph22 : null,
                    'fc_statusgnt' => ($fc_statusgnt <> '') ? $fc_statusgnt : null,
                    'fc_expedisi' => ($fc_expedisi <> '') ? $fc_expedisi : null,
                    'fc_nopol' => ($fc_nopol <> '') ? $fc_nopol : null,
                    'fc_namedriver' => ($fc_namedriver <> '') ? $fc_namedriver : null,
                    'fc_hpdriver' => ($fc_hpdriver <> '') ? $fc_hpdriver : null,
                    'fc_franco' => ($fc_franco <> '') ? $fc_franco : null,
                    'ft_image' => ($ft_image <> '') ? $ft_image : null,
                    'fd_uploaddate' => ($fd_uploaddate <> '') ? $fd_uploaddate : null,

                )); 
            }

            if(!empty($info)){
                if($this->m_cr_sj->q_createTrxInmst($info)){
                    if($this->m_cr_sj->q_commitTrxInmst(
                        array('fc_status' => 'F'),
                        array(
                            'fc_branch' => $fc_branch,
                            'fc_operator' => $fc_operator,
                            'fc_status' => 'IM',
                        )
                    )) { }
                } 
            } 
        }  
		

		
				
		if (is_array($array->number)) {
            $info = array();
            foreach($array->number as $index=>$row) {
				$documen = isset($row->documen) ? $row->documen : '';
                $branch     = isset($row->branch    ) ? $row->branch     : '';
                $userid     = $userid;
                $part     = isset($row->part    ) ? $row->part     : '';
                $count     = isset($row->count    ) ? $row->count     : '';
                $prefix     = isset($row->prefix    ) ? $row->prefix     : '';
                $suffix     = isset($row->suffix    ) ? $row->suffix     : '';
                $docno     = isset($row->docno    ) ? $row->docno     : '';
                $increment     = isset($row->increment    ) ? $row->increment     : '';
                $comparison     = isset($row->comparison    ) ? $row->comparison     : '';
                $status     = isset($row->status    ) ? $row->status     : '';


                array_push($info, array(
                    'branch    ' => ($branch     <> '') ? $branch     : '',
                    'documen    ' => ($documen     <> '') ? $documen     : '',
                    'userid    ' => ($userid     <> '') ? $userid     : '',
                    'part    ' => ($part     <> '') ? $part     : '',
                    'count    ' => ($count     <> '') ? $count     : '',
                    'prefix    ' => ($prefix     <> '') ? $prefix     : '',
                    'suffix    ' => ($suffix     <> '') ? $suffix     : '',
                    'docno    ' => ($docno     <> '') ? $docno     : '',
                    'increment    ' => ($increment     <> '') ? $increment     : '',
                    'comparison    ' => ($comparison     <> '') ? $comparison     : '',
                    'status    ' => ($status     <> '') ? $status     : '',

                ));
            }

            if(!empty($info)){
                if($this->m_cr_sj->q_createBackupNumber($info)){

                } 
            }
        } 
		
		header("Content-Type: text/json");
		echo json_encode(
			array(
			'success' => true,
			'message' => '',
			'body' => array(
				'inmstmob' => $this->m_cr_sj->q_tmp_result_where(" and branch = '$branch' and userid='$userid' and uploadname='inmstmob'" )->result(),
				'backupnumber' => $this->m_cr_sj->q_mst_backup_number_result_where(" and branch = '$branch' and userid='$userid'" )->result()
				
			)	
			)
		, JSON_PRETTY_PRINT);
	}
	
	function UploadImage() {
		$branch = $this->input->post('branch');
		$userid = $this->input->post('userid');
		$json = $this->input->post('json');
		$image = json_decode($json);
		$config['upload_path'] = './assets/img/mobile/sj'; //path folder
	    $config['allowed_types'] = '*'; //type yang dapat diakses bisa anda sesuaikan
	    //$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
	    //$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
		//$config['max_size']	= '50000';
		//$config['max_width']  = '36240';
		//$config['max_height']  = '32000';
		
		$this->upload->initialize($config);
	    for ($i=0; $i < count($_FILES['files']['name']) ; $i++) { 
			$_FILES['file']['name'] = $_FILES['files']['name'][$i];
			$_FILES['file']['type'] = $_FILES['files']['type'][$i];
			$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
			$_FILES['file']['error'] = $_FILES['files']['error'][$i];
			$_FILES['file']['size'] = $_FILES['files']['size'][$i];
			if($this->upload->do_upload('file')){
				//log_message('info', $_FILES ['file']['name'] );
				//log_message('info', $branch );
				//log_message('info', $userid );
				log_message('info', $json );
/*                $wheredelresult = array(
                    'userid' => $userid ,
                    'uploadname' => 'timage');
                $this->m_cr_sj->q_DelResultUpload($wheredelresult);*/
                $pcek = " and docno='".$image[$i]->docno."'";
				$cektimage = $this->m_cr_sj->check_t_image($pcek)->num_rows();
				if ($cektimage < 1) {
                    $insdb = array (
                        'branch' => $image[$i]->branch,
                        'docno' => $image[$i]->docno,
                        'imagename' => $image[$i]->imagename,
                        'imagepath' => $image[$i]->imagepath,
                        'latitude' => $image[$i]->latitude,
                        'latitudereference' => $image[$i]->latitudereference,
                        'longitude' => $image[$i]->longitude,
                        'longitudereference' => $image[$i]->longitudereference,
                        'datetimetakephoto' => $image[$i]->datetimetakephoto,
                        'datestamp' => $image[$i]->datestamp,
                        'iso' => $image[$i]->iso,
                        'orientation' => $image[$i]->orientation,
                        'imagelength' => $image[$i]->imagelength,
                        'imagewidth' => $image[$i]->imagewidth,
                        'modeldevice' => $image[$i]->modeldevice,
                        'makecompany' => $image[$i]->makecompany,
                        'imagesrc' => '/assets/img/mobile/sj/'.$_FILES['file']['name'],
                        'userid' => $image[$i]->userid,
                        'status' => 'F',
                        ///'imagesrc' => base_url('/assets/img/mobile/sj/'.$_FILES['file']['name']),
                    );
                    $this->db->insert('sc_trx.t_image',$insdb);
                }


				
			}
	    } 
		
		header("Content-Type: text/json");
		echo json_encode(
			array(
			'success' => true,
			'message' => '',
			'body' => array(
				'timage' => $this->m_cr_sj->q_tmp_result_where(" and branch = '$branch' and userid='$userid' and uploadname='timage'" )->result()
				
			)	
			)
		, JSON_PRETTY_PRINT);
			
		/*
		$result = array("success" => "OKOK");
		for($i = 0; $i < count ( $_FILES ['file'] ['name'] ); $i ++) {
			try {
				log_message('info', $_FILES ['file'] ['name'] );
				if (move_uploaded_file( $_FILES ['file'] ["tmp_name"][$i], "assets/img/mobile/sj/" . $_FILES ["file"] ["name"][$i] )) {
					
					$result = array("success" => "File successfully uploaded");
				} else {
					$result = array("success" => "error uploading file");
					throw new Exception('Could not move file');
				}
			} catch (Exception $e) {
				die('File did not upload: ' . $e->getMessage());
			}
			echo json_encode($result, JSON_PRETTY_PRINT);
		}*/



	}

    function readInmstWeb(){
        $startDate=$this->input->post('startDate');
        $endDate=$this->input->post('endDate');

        $startDateN=date('Ymd',strtotime($startDate));
        $endDateN=date('Ymd',strtotime($endDate));

        $userId=$this->input->post('userId');
        $count=$this->input->post('count');
        $total=$this->input->post('total');
        $pages=$this->input->post('pages');
        $clausemobile=$this->input->post('clause');
        $offset=$pages-1;
        $query ='';// (isset($_REQUEST['search'])) ? ($_REQUEST['search']) : '';

        if ( strlen(trim($query)) > 0 ) {
            $query = str_replace(' ', '', $query);
            $clausesearch = " and ( fc_trxno like '%$query%' or to_char(fd_entrydate,'dd-mm-yyyy') like '%$query%' )" ;
        } else { $clausesearch = ' '; }

        $param=" and to_char(fd_entrydate::timestamp,'yyyymmdd') between '$startDateN' and '$endDateN' $clausesearch $clausemobile";
        $paramx=" and to_char(fd_entrydate::timestamp,'yyyymmdd') between '$startDateN' and '$endDateN' $clausemobile";
        $paramtop=" limit $count ";
        $paramoffset="	offset $count*$offset" ;

        $inmst_records = $this->m_cr_sj->q_t_inmst_web_pagin($param,$paramtop,$paramoffset)->result();
        $inmst_total = $this->m_cr_sj->q_t_inmst_web_pagin($param,'','')->num_rows();

        header("Content-Type: text/json");
        echo json_encode(
            array(
                'success' => true,
                'message' => '',
                'status' => 'success',
                'allow' =>  true,
                'date' =>  date('d-m-Y H:m:s'),
                'count' =>  $count,
                'total' =>  $inmst_total,
                'pages' =>  $pages,
                'search' => $query,
                'records' => $inmst_records,
            )
        );
    }

    function readIndtlWeb(){
        $clausemobile=$this->input->post('clause');
        $userId=$this->input->post('userId');
        $count=$this->input->post('count');
        $total=$this->input->post('total');
        $pages=$this->input->post('pages');
        $query = (isset($_REQUEST['search'])) ? ($_REQUEST['search']) : '';

        if ( strlen(trim($query)) > 0 ) {
            $query = str_replace(' ', '%', $query);
            $clausesearch = ' and ( coalesce(trim(orderid::text), \'\') like \'%'.$query.'%\' ) ';
        } else { $clausesearch = ' '; }

        $param=$clausemobile;

        $indtl_records = $this->m_cr_sj->q_t_indtl_web_online($param)->result();
        $indtl_total = $this->m_cr_sj->q_t_indtl_web_online($param)->num_rows();


        header("Content-Type: text/json");
        echo json_encode(
            array(
                'success' => true,
                'message' => '',
                'status' => 'success',
                'allow' =>  true,
                'date' =>  date('d-m-Y H:m:s'),
                'count' =>  $count,
                'total' =>  $indtl_total,
                'pages' =>  $pages,
                'search' => $query,
                'records' => $indtl_records,
            )
        );
    }

    public function ex_sj_download(){
        $startDate=$this->input->post('startDate');
        $endDate=$this->input->post('endDate');

        $startDateN=date('Ymd',strtotime($startDate));
        $endDateN=date('Ymd',strtotime($endDate));

        $userId=$this->input->post('userId');
        $clausemobile=$this->input->post('clause');


        $param = $clausemobile;
        $datane=$this->m_cr_sj->q_inmstxdtl_web_online($param);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array(
            'Branch','Trxno','Entry Date'
        ));



        $this->excel_generator->set_column(array(
            'fc_branch','fc_trxno','fd_entrydate'
        ));

        $this->excel_generator->set_width(array(
            20,20,20
        ));
        $this->excel_generator->exportTo2007('Excel SJ'.'-01');
    }

}