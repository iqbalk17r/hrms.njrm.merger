<?php  
class Import extends CI_Controller {
   	 /*function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_borong','m_jabatan'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }*/
	
	function __construct()  {
 		parent::__construct();
    		$this->load->library(array('PHPExcel/PHPExcel','PHPExcel/PHPExcel/IOFactory','template','upload'));
			$this->load->model(array('trans/m_absensi','trans/m_karyawan'));
			$this->load->helper(array('form', 'url'));
		if(!$this->session->userdata('nik')){            
			redirect('dashboard');				
        } 
		
	}
	
	function index(){
		//echo 'test';
		$data['title']='Import';
		if($this->uri->segment(4)=="exist")
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada atau kode transaksi pernah di Upload</div>";
        else if($this->uri->segment(4)=="add_success")
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else if($this->uri->segment(4)=="conf_succes")
            $data['message']="<div class='alert alert-success'>Konfirmasi SUKSES</div>";
        else
            $data['message']='';
		$this->template->display('master/import/v_import',$data);
	}
	
	function import_data(){			
			
		   if ($this->input->post('save')) {
			$fileName = $_FILES['import']['name'];

			$config['upload_path'] = './assets/files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 10000;
			
			//unlink("./assets/files/$fileName");			
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import') )
				$this->upload->display_errors();

			$media = $this->upload->data('import');
			$inputFileName = './assets/files/'.$media['file_name'];

			//  Read your Excel workbook
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			for ($row = 2; $row <= $highestRow; $row++){  				//  Read a row of data into an array 				
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);
				//  Insert row data array into your database of choice here
				$data_import = array(
							
							'kddept'=>$rowData[0][1],
							'kdjabatan'=>$rowData[0][5],
							'nmjabatan'=>$rowData[0][6],
							'input_by'=>$this->session->userdata('nik'),
							'input_date'=>date("Y-m-d H:i:s")
						);
				
				
				$this->db->insert("sc_tmp.jabatan",$data_import);
				//echo $rowData;
				
			}
                        //echo "Import Success";
			}
                //$this->load->view('poin/register/import_view');
				//$data['title']='Import Data Outlet';
				//$data['message']='';
				//$this->template->display('poin/import/import_outlet_view',$data);
				echo 'sukses';
	}
	
	function import_formula(){			
			
		   if ($this->input->post('save')) {
			$fileName = $_FILES['import']['name'];

			$config['upload_path'] = './assets/files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 10000;
			
			//unlink("./assets/files/$fileName");			
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import') )
				$this->upload->display_errors();

			$media = $this->upload->data('import');
			$inputFileName = './assets/files/'.$media['file_name'];

			//  Read your Excel workbook
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			for ($row = 2; $row <= $highestRow; $row++){  				//  Read a row of data into an array 				
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);
				//  Insert row data array into your database of choice here
				$data_import = array(
							
							'no_urut'=>$rowData[0][0],
							'kdrumus'=>$rowData[0][1],
							'keterangan'=>$rowData[0][2],
							'tipe'=>$rowData[0][3],
							'aksi_tipe'=>$rowData[0][4],
							'aksi'=>$rowData[0][5],
							'tetap'=>$rowData[0][6],
							'taxable'=>$rowData[0][7],
							'deductible'=>$rowData[0][8],
							'regular'=>$rowData[0][9],
							'cash'=>$rowData[0][10],
							'input_by'=>$this->session->userdata('nik'),
							'input_date'=>date("Y-m-d H:i:s")
						);
				
				
				$this->db->insert("sc_his.detail_formula",$data_import);
				//echo $rowData;
				
			}
                        //echo "Import Success";
			}
                //$this->load->view('poin/register/import_view');
				//$data['title']='Import Data Outlet';
				//$data['message']='';
				//$this->template->display('poin/import/import_outlet_view',$data);
				//echo 'sukses';
				redirect('master/import/add_success');
	}
	
	
	function import_upahborong(){			
			
		   if ($this->input->post('save')) {
			$fileName = $_FILES['import']['name'];

			$config['upload_path'] = './assets/files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 10000;
			
			//unlink("./assets/files/$fileName");			
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import') )
				$this->upload->display_errors();

			$media = $this->upload->data('import');
			$inputFileName = './assets/files/'.$media['file_name'];

			//  Read your Excel workbook
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			for ($row = 2; $row <= $highestRow; $row++){  				//  Read a row of data into an array 				
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);
				//  Insert row data array into your database of choice here
				$data_import_sub = array(
							
							'kdborong'=>$rowData[0][1],
							'kdsub_borong'=>$rowData[0][2],
							'nmsub_borong'=>$rowData[0][3],
							'metrix'=>$rowData[0][4],
							'satuan'=>$rowData[0][5],
							'tarif_satuan'=>$rowData[0][6],
							'input_by'=>$this->session->userdata('nik'),
							'input_date'=>date("Y-m-d H:i:s")
						);
				$data_import_target = array(
							
							'kdborong'=>$rowData[0][1],
							'kdsub_borong'=>$rowData[0][2],
							'periode'=>'2016',
							'target1'=>$rowData[0][7],
							'target2'=>$rowData[0][8],
							'target3'=>$rowData[0][9],
							'target4'=>$rowData[0][10],
							'target5'=>$rowData[0][11],
							'target6'=>$rowData[0][12],
							'target7'=>$rowData[0][13],
							'target8'=>$rowData[0][14],
							'target9'=>$rowData[0][15],
							'target10'=>$rowData[0][16],
							'target11'=>$rowData[0][17],
							'target12'=>$rowData[0][18],
							'total_target'=>$rowData[0][19],
							'input_by'=>$this->session->userdata('nik'),
							'input_date'=>date("Y-m-d H:i:s")
						);
				
				$this->db->insert("sc_his.sub_borong",$data_import_sub);
				$this->db->insert("sc_his.target_borong",$data_import_target);
				//echo $rowData;
				
			}
                        //echo "Import Success";
			}
                //$this->load->view('poin/register/import_view');
				//$data['title']='Import Data Outlet';
				//$data['message']='';
				//$this->template->display('poin/import/import_outlet_view',$data);
				//echo 'sukses';
				redirect('master/import/add_success');
	}
	
	function import_data_departemen(){			
			
		   if ($this->input->post('save')) {
			$fileName = $_FILES['import']['name'];

			$config['upload_path'] = './assets/files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 10000;
			
			//unlink("./assets/files/$fileName");			
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import') )
				$this->upload->display_errors();

			$media = $this->upload->data('import');
			$inputFileName = './assets/files/'.$media['file_name'];

			//  Read your Excel workbook
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			for ($row = 2; $row <= $highestRow; $row++){  				//  Read a row of data into an array 				
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);
				//  Insert row data array into your database of choice here
				$data_import = array(
							
							'kddept'=>$rowData[0][0],
							'nmdept'=>$rowData[0][1],
							'input_by'=>$this->session->userdata('nik'),
							'input_date'=>date("Y-m-d H:i:s")
						);
				
				
				$this->db->insert("sc_mst.departmen",$data_import);
				//echo $rowData;
				
			}
                        //echo "Import Success";
			}
                //$this->load->view('poin/register/import_view');
				//$data['title']='Import Data Outlet';
				//$data['message']='';
				//$this->template->display('poin/import/import_outlet_view',$data);
				echo 'sukses';
	}
	
	
	function import_jadwalkerja(){			
			
		   if ($this->input->post('save')) {
			$fileName = $_FILES['import']['name'];

			$config['upload_path'] = './assets/files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 10000;
			
			//unlink("./assets/files/$fileName");			
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import') )
				$this->upload->display_errors();

			$media = $this->upload->data('import');
			$inputFileName = './assets/files/'.$media['file_name'];

			//  Read your Excel workbook
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			for ($row = 2; $row <= $highestRow; $row++){  				//  Read a row of data into an array 				
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);
				//  Insert row data array into your database of choice here
				$data_import_jdker = array(
							
							
							
							
							'tgl'=>trim($rowData[0][0]),
							'kodejamkerja'=>trim($rowData[0][1]),
							'kdregu'=>trim($rowData[0][2]),
							'inputby'=>$this->session->userdata('nik'),
							'inputdate'=>date("Y-m-d H:i:s")
						);
			
				if(!empty($data_import_jdker['tgl']) and !empty($data_import_jdker['kodejamkerja'])){
				$this->db->insert("sc_his.jadwalkerja",$data_import_jdker);
									}
				}
                        //echo "Import Success";
			}
              
				redirect('master/import/index/add_success');
	}
	
	function import_regu(){			
			
		   if ($this->input->post('save')) {
			$fileName = $_FILES['import']['name'];

			$config['upload_path'] = './assets/files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 10000;
			
			//unlink("./assets/files/$fileName");			
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import') )
				$this->upload->display_errors();

			$media = $this->upload->data('import');
			$inputFileName = './assets/files/'.$media['file_name'];

			//  Read your Excel workbook
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			for ($row = 2; $row <= $highestRow; $row++){  				//  Read a row of data into an array 				
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);
				//  Insert row data array into your database of choice here
				$data_import_regu = array(
							
							
							
							
							'kdregu'=>trim($rowData[0][0]),
							'nik'=>trim($rowData[0][1]),
							'input_by'=>$this->session->userdata('nik'),
							'input_date'=>date("Y-m-d H:i:s")
						);
			
				if(!empty(trim($data_import_regu['kdregu'])) and !empty(trim($data_import_regu['nik']))){
				$this->db->insert("sc_his.regu_opr",$data_import_regu);
					}
				}
                        //echo "Import Success";
			}
              
				redirect('master/import/index/add_success');
	}

	
	function rekap_gaji(){			
			
		   if ($this->input->post('save')) {
			$fileName = $_FILES['import']['name'];

			$config['upload_path'] = './assets/files/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']		= 10000;
			
			//unlink("./assets/files/$fileName");			
			$this->upload->initialize($config);

			if(! $this->upload->do_upload('import') )
				$this->upload->display_errors();

			$media = $this->upload->data('import');
			$inputFileName = './assets/files/'.$media['file_name'];

			//  Read your Excel workbook
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			for ($row = 2; $row <= $highestRow; $row++){  				//  Read a row of data into an array 				
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);
				//  Insert row data array into your database of choice here
				$data_import_rekgaji = array(
							
							
							
							
							'nik'=>trim($rowData[0][0]),
							'nama'=>trim($rowData[0][1]),
							'gajipokok'=>trim($rowData[0][2]),
							'tunjangantetap'=>trim($rowData[0][3]),
							'tunjangangrade'=>trim($rowData[0][4]),
							'tunjanganshift'=>trim($rowData[0][5]),
							'lembur'=>trim($rowData[0][6]),
							'koreksimasa'=>trim($rowData[0][7]),
							'jkk'=>trim($rowData[0][8]),
							'jkm'=>trim($rowData[0][9]),
							'jht'=>trim($rowData[0][10]),
							'bpjskesper'=>trim($rowData[0][11]),
							'bpjskeskar'=>trim($rowData[0][12]),
							'pph21'=>trim($rowData[0][13]),
							'jhtper'=>trim($rowData[0][14]),
							'jpper'=>trim($rowData[0][15]),
							'jpkaryawan'=>trim($rowData[0][16]),
							'periode'=>trim($rowData[0][17]),
							'input_by'=>$this->session->userdata('nik'),
							'input_date'=>date("Y-m-d H:i:s")
						);
			
				if(!empty(trim($data_import_rekgaji['nik'])) and !empty(trim($data_import_rekgaji['nama']))){
				$this->db->insert("sc_his.rekap_gaji",$data_import_rekgaji);
					}
				}
                        //echo "Import Success";
			}
              
				redirect('master/import/index/add_success');
	}


	
}