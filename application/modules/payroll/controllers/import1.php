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
    		$this->load->library(array('PHPExcel/PHPExcel','PHPExcel/PHPExcel/IOFactory','template','upload','zip'));
			$this->load->model(array('trans/m_absensi','trans/m_karyawan','m_import'));
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
		$this->template->display('payroll/import/v_import',$data);
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
	
	function import_thr(){			
			
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
							
							'nik'=>$rowData[0][0],
							'nominal'=>$rowData[0][2],
							'input_by'=>$this->session->userdata('nik'),
							'input_date'=>date("Y-m-d H:i:s")
						);
				
				
				$this->db->insert("sc_his.thr",$data_import);
				//echo $rowData;
				
			}
                        //echo "Import Success";
			}
                //$this->load->view('poin/register/import_view');
				//$data['title']='Import Data Outlet';
				//$data['message']='';
				//$this->template->display('poin/import/import_outlet_view',$data);
				redirect('payroll/import/index/add_success');
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
				redirect('payroll/import/add_success');
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
				redirect('payroll/import/add_success');
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
				$this->db->insert("sc_im.jadwalkerja",$data_import_jdker);
									}
				}
                        //echo "Import Success";
			}
              
				redirect('payroll/import/index/add_success');
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
				$this->db->insert("sc_im.regu_opr",$data_import_regu);
					}
				}
                        //echo "Import Success";
			}
              
				redirect('payroll/import/index/add_success');
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
				$this->db->insert("sc_im.rekap_gaji",$data_import_rekgaji);
					}
				}
                        //echo "Import Success";
			}
              
				redirect('payroll/import/index/add_success');
	}

	function e_csv(){
		$data['title']='KIRIM DATA TRANSAKSI';
		if($this->uri->segment(4)=="exist")
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada atau kode transaksi pernah di Upload</div>";
        else if($this->uri->segment(4)=="add_success")
            $data['message']="<div class='alert alert-success'>Data CSV Berhasil di export</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else if($this->uri->segment(4)=="conf_succes")
            $data['message']="<div class='alert alert-success'>Konfirmasi SUKSES</div>";
        else
            $data['message']='';
		
		$data['li_dir']=$this->m_import->e_exportcsv()->result();
		$data['dl']=$this->m_import->e_exportcsv()->row_array();
		$this->template->display('payroll/import/v_exportcsv',$data);
	}
	
	
	function e_csvall(){
		//$rows=$this->m_import->e_exportcsv()->num_rows();
		$rows=$this->m_import->e_exportcsv()->result();
		//$rows1=$this->m_import->e_exportcsv()->row_array();
		/*
		for ($i=1;$i<=$rows;$i++){
			
			//echo $rows['nodok'];
			echo $this->m_import->e_exportcsv();
		}*/
		//$tgl_awal='2016-05-01';
		//$tgl_akhir='2016-05-30';
		$tgl_awal=$this->input->post('tgl_awal');
		$tgl_akhir=$this->input->post('tgl_akhir');
		if(empty($tgl_awal) and empty($tgl_akhir)){
			$date='';
		} else if(!empty ($tgl_awal) and empty($tgl_akhir)){
			$date="where tgl_kerja='$tgl_awal'";
		} else if(empty($tgl_awal) and !empty($tgl_akhir)){
			$date="where tgl_kerja='$tgl_akhir'";
		} else{
			$date="where tgl_kerja between '$tgl_awal' and '$tgl_akhir'";
		}
			
		
		
		foreach ($rows as $i) {
			$nodokdir=trim($i->nodok);
			$patch=trim($i->dir_list);
		
				if($nodokdir=='001'){ 
					
					$this->m_import->e_csvcek_absen($date,$patch);

				} else if ($nodokdir=='002'){
					
					$this->m_import->e_csvcek_borong($date,$patch);
					
				} else if ($nodokdir=='003'){
				
					$this->m_import->e_csvcek_lembur($date,$patch);
					
				} else if ($nodokdir=='004'){
			
					$this->m_import->e_csvcek_shift($date,$patch);
			
				}	
				else if ($nodokdir=='005'){
			
					$this->m_import->e_csvjadwal_kerja($patch);
			
				}
			//echo $nodokdir;		
		}
		
		redirect('payroll/import/e_csv/add_success');
	}
	
	function e_csv_detailcsv(){
		$nodokdire=trim($this->input->post('nodokdir1'));
		$nodokdir=$nodokdire;
		$tgl_awal=$this->input->post('tgl_awal');
		$tgl_akhir=$this->input->post('tgl_akhir');
		if(empty($tgl_awal) and empty($tgl_akhir)){
			$date='';
		} else if(!empty ($tgl_awal) and empty($tgl_akhir)){
			$date="where tgl_kerja='$tgl_awal'";
		} else if(empty($tgl_awal) and !empty($tgl_akhir)){
			$date="where tgl_kerja='$tgl_akhir'";
		} else{
			$date="where tgl_kerja between '$tgl_awal' and '$tgl_akhir'";
		}
		$patcharray=$this->m_import->e_cek_patch($nodokdir)->row_array();
		$patch=$patcharray['dir_list'];
		
		
		if($nodokdir=='001'){ 
			
			$this->m_import->e_csvcek_absen($date,$patch);
			redirect('payroll/import/e_csv/add_success');
		} else if ($nodokdir=='002'){
			
			$this->m_import->e_csvcek_borong($date,$patch);
			redirect('payroll/import/e_csv/add_success');
		} else if ($nodokdir=='003'){
		
			$this->m_import->e_csvcek_lembur($date,$patch);
			redirect('payroll/import/e_csv/add_success');
		} else if ($nodokdir=='004'){
	
			$this->m_import->e_csvcek_shift($date,$patch);
			redirect('payroll/import/e_csv/add_success');
		}
		

	}
	function i_csv(){
		$data['title']='TERIMA DATA TRANSAKSI';
		if($this->uri->segment(4)=="exist")
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada atau kode transaksi pernah di Upload</div>";
        else if($this->uri->segment(4)=="add_success")
            $data['message']="<div class='alert alert-success'>Data CSV Berhasil di Import Ke Database</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else if($this->uri->segment(4)=="conf_succes")
            $data['message']="<div class='alert alert-success'>Konfirmasi SUKSES</div>";
        else
            $data['message']='';
		
		$data['li_dir']=$this->m_import->i_importcsv()->result();
		$data['dl']=$this->m_import->i_importcsv()->row_array();
		$this->template->display('payroll/import/v_importcsv',$data);
	}
	function i_csvall(){
		$rows=$this->m_import->i_importcsv()->result();
		foreach ($rows as $i) {
			$nodokdir=trim($i->nodok);
			$patch=trim($i->dir_list);
		
				if($nodokdir=='001'){ 
					
					$this->m_import->i_csvcek_absen($patch);

				} else if ($nodokdir=='002'){
					
					$this->m_import->i_csvcek_borong($patch);
					
				} else if ($nodokdir=='003'){
				
					$this->m_import->i_csvcek_lembur($patch);
					
				} else if ($nodokdir=='004'){
			
					$this->m_import->i_csvcek_shift($patch);
			
				}			
		}
		$this->db->query("update sc_tmp.cek_lembur set status='I'");
		$this->db->query("update sc_tmp.cek_lembur set status='P'");
		$this->db->query("update sc_tmp.cek_absen set status='I'");
		$this->db->query("update sc_tmp.cek_absen set status='U'");
		redirect('payroll/import/i_csv/add_success');
	}
	function i_csv_detailcsv(){
		$nodokdire=trim($this->input->post('nodokdir1'));
		$nodokdir=$nodokdire;
		//$tgl_awal=$this->input->post('tgl_awal');
		//$tgl_akhir=$this->input->post('tgl_akhir');
		$patcharray=$this->m_import->i_cek_patch($nodokdir)->row_array();
		$patch=$patcharray['dir_list'];
		if($nodokdir=='001'){ 
			$this->m_import->i_csvcek_absen($patch);
			redirect('payroll/import/i_csv/add_success');
		} else if ($nodokdir=='002'){
			
			$this->m_import->i_csvcek_borong($patch);
			redirect('payroll/import/i_csv/add_success');
		} else if ($nodokdir='003'){
		
			$this->m_import->i_csvcek_lembur($patch);
			redirect('payroll/import/i_csv/add_success');
		} else if ($nodokdir='004'){
	
			$this->m_import->i_csvcek_shift($patch);
			redirect('payroll/import/i_csv/add_success');
		}
		

	
	}	
	
	
	public function download_zip(){ //percobaan
 
        $path = 'D:/TRANSAKSI/'; // folder yang ingin kita download
        $folder_in_zip = "/";  // tujuan sementara folder zip
        $this->zip->get_files_from_folder($path, $folder_in_zip);
        $this->zip->download('transaksi.zip');
    }

	function e_csv_mstkaryawan(){
		$data['title']='KIRIM DATA MASTER KAYRAWAN';
		if($this->uri->segment(4)=="exist")
					$data['message']="<div class='alert alert-warning'>Data Sudah Ada atau kode transaksi pernah di Upload</div>";
				else if($this->uri->segment(4)=="add_success")
					$data['message']="<div class='alert alert-success'>Data CSV Berhasil di export</div>";
		else if($this->uri->segment(4)=="wrong_format")
					$data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else if($this->uri->segment(4)=="conf_succes")
					$data['message']="<div class='alert alert-success'>Konfirmasi SUKSES</div>";
				else
					$data['message']='';
		$nodokdir='MST0001';
		$data['li_dir']=$this->m_import->e_exportcsvmst()->result();
		$data['dl']=$this->m_import->e_cek_patch($nodokdir)->row_array();
		$this->template->display('payroll/import/v_e_csv_mstkaryawan',$data);
	}


	function e_csv_mstkaryawan_all(){
		//$rows=$this->m_import->e_exportcsv()->num_rows();
		$rows=$this->m_import->e_exportcsv()->result();
		//$rows1=$this->m_import->e_exportcsv()->row_array();
		/*
		for ($i=1;$i<=$rows;$i++){

		//echo $rows['nodok'];
		echo $this->m_import->e_exportcsv();
		}*/
		//$tgl_awal='2016-05-01';
		/*$tgl_akhir='2016-05-30';
		$tgl_awal=$this->input->post('tgl_awal');
		$tgl_akhir=$this->input->post('tgl_akhir');
		if(empty($tgl_awal) and empty($tgl_akhir)){
		$date='';
		} else if(!empty ($tgl_awal) and empty($tgl_akhir)){
		$date="where tglmasukkerja='$tgl_awal'";
		} else if(empty($tgl_awal) and !empty($tgl_akhir)){
		$date="where tglmasukkerja='$tgl_akhir'";
		} else{
		$date="where tglmasukkerja between '$tgl_awal' and '$tgl_akhir'";
		}*/



		foreach ($rows as $i) {
		$nodokdir=trim($i->nodok);
		$patch=trim($i->dir_list);

		if($nodokdir=='MST0001'){ 
		$this->m_import->e_csvmstkaryawan($patch);
		} else if ($nodokdir=='MST0002'){
		$this->m_import->e_csvmststatpeg($patch);
		} else if ($nodokdir=='MST0003'){
		$this->m_import->e_csvmstbpjs($patch);
		} else if ($nodokdir=='MST0004'){
		$this->m_import->e_csvmstriwkel($patch);
		} else if ($nodokdir=='MST0005'){
		$this->m_import->e_csvmstriwkes($patch);
		} else if ($nodokdir=='MST0006'){
		$this->m_import->e_csvmstriwkompt($patch);
		} else if ($nodokdir=='MST0007'){
		$this->m_import->e_csvmstriwpend($patch);
		} else if ($nodokdir=='MST0008'){
		$this->m_import->e_csvmstriwpend_nf($patch);
		} else if ($nodokdir=='MST0009'){
		$this->m_import->e_csvmstriwpeng($patch);
		} else if ($nodokdir=='MST0010'){
		$this->m_import->e_csvmstriwrkmds($patch);
		}
		}

		redirect('payroll/import/e_csv_mstkaryawan/add_success');
	}


	function i_csv_mstkaryawan(){
		$data['title']='IMPORT DATA MASTER KARYAWAN';
		if($this->uri->segment(4)=="exist")
					$data['message']="<div class='alert alert-warning'>Data Sudah Ada atau kode transaksi pernah di Upload</div>";
				else if($this->uri->segment(4)=="add_success")
					$data['message']="<div class='alert alert-success'>Data CSV Berhasil di Import Ke Database</div>";
		else if($this->uri->segment(4)=="wrong_format")
					$data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
		else if($this->uri->segment(4)=="conf_succes")
					$data['message']="<div class='alert alert-success'>Konfirmasi SUKSES</div>";
				else
					$data['message']='';
		$nodokdir='MST0001';
		$data['li_dir']=$this->m_import->i_importcsv()->result();
		$data['dl']=$this->m_import->i_cek_patch($nodokdir)->row_array();
		$this->template->display('payroll/import/v_i_csv_mstkaryawan',$data);
	}

	function i_csv_mstkaryawan_all(){
		$rows=$this->m_import->i_importcsv()->result();
		foreach ($rows as $i) {
			$nodokdir=trim($i->nodok);
			$patch=trim($i->dir_list);
			if($nodokdir=='MST0001'){ 
			$this->m_import->i_csvmstkaryawan($patch);
			} else if ($nodokdir=='MST0002'){
			$this->m_import->i_csvmststatpeg($patch);
			} else if ($nodokdir=='MST0003'){
			$this->m_import->i_csvmstbpjs($patch);
			} else if ($nodokdir=='MST0004'){
			$this->m_import->i_csvmstriwkel($patch);
			} else if ($nodokdir=='MST0005'){
			$this->m_import->i_csvmstriwkes($patch);
			} else if ($nodokdir=='MST0006'){
			$this->m_import->i_csvmstriwkompt($patch);
			} else if ($nodokdir=='MST0007'){
			$this->m_import->i_csvmstriwpend($patch);
			} else if ($nodokdir=='MST0008'){
			$this->m_import->i_csvmstriwpend_nf($patch);
			} else if ($nodokdir=='MST0009'){
			$this->m_import->i_csvmstriwpeng($patch);
			} else if ($nodokdir=='MST0010'){
			$this->m_import->i_csvmstriwrkmds($patch);
		}

		}
		redirect('payroll/import/i_csv_mstkaryawan/add_success');
	}

	
	
	
	
}