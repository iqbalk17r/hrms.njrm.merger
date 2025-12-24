<?php
/*
	@author : Junis
	02-12-2015
*/
//error_reporting(0);

class Kec extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_geo'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master Kecamatan";	        
		if($this->uri->segment(4)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
		}
		else if($this->uri->segment(4)=="success"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(4)=="notacces"){			
            $data['message']="<div class='alert alert-success'>Anda tidak Berhak untuk mengakses modul ini</div>";
		}
		else if($this->uri->segment(4)=="del"){			
            $data['message']="<div class='alert alert-success'>Hapus Data Sukses</div>";
		}
		else if($this->uri->segment(4)=="del_exist"){			
            $data['message']="<div class='alert alert-danger'>Ada data yang terkait, Hapus child data terlebih dahulu</div>";
		}
        else {
            $data['message']='';
		}
		$data['list_kec']=$this->m_geo->list_kec()->result();
		$data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
		$data['list_opt_prov']=$this->m_geo->list_opt_prov()->result();
		$data['list_opt_kotakab']=$this->m_geo->list_opt_kotakab()->result();		
		$this->template->display('master/geo/kec/v_kec',$data);
    }
	
	public function ajax_list()
	{
		$list = $this->m_geo->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $person->kodekec;			
			$row[] = $person->namanegara;
			$row[] = $person->namaprov;	
			$row[] = $person->namakotakab;	
			$row[] = $person->namakec;				
			$negara=trim($person->kodenegara);
			$prov=trim($person->kodeprov); 
			$kotakab=trim($person->kodekotakab);
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="'.site_url("master/kec/edit/$negara/$prov/$kotakab").'/'.$person->kodekec.'" title="Edit" onclick="'."return confirm('Anda Yakin Edit Data ini?')".'"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".trim($person->kodekec)."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_geo->count_all(),
						"recordsFiltered" => $this->m_geo->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	function edit($kodenegara,$kodeprov,$kodekotakab,$kodekec){
		if (empty($kodekec)){
			redirect('master/kec/');
		} else {
			$data['title']='EDIT DATA Kecamatan';			
			if($this->uri->segment(8)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_kec']=$this->m_geo->dtl_kec($kodenegara,$kodeprov,$kodekotakab,$kodekec);
			$data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
			$data['list_opt_prov']=$this->m_geo->list_opt_prov()->result();
			$data['list_opt_kotakab']=$this->m_geo->list_opt_kotakab()->result();
			$this->template->display('master/geo/kec/v_editkec',$data);
		}		
	}
	
	function hps($kodekec){	
		//$cek_delete=$this->m_geo->cek_del($kodekec);
		$cek_delete=0;
		if ($cek_delete>0) {
			redirect('master/kec/index/del_exist');
		} else {			
			$this->db->where('kodekec',$kodekec);
			$this->db->delete('sc_mst.kec');
			redirect('master/kec/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$kodekec=strtoupper(trim($this->input->post('kdkec')));
		$kodenegara=trim($this->input->post('negara'));
		$kodeprov=trim($this->input->post('provinsi'));
		$kodekotakab=trim($this->input->post('kotakab'));
		$oldkodenegara=trim($this->input->post('oldnegara'));
		$oldkodeprov=trim($this->input->post('oldprov'));
		$oldkodekotakab=trim($this->input->post('oldkotakab'));
		$namakec=strtoupper($this->input->post('namakec'));				
		$cek_kec=$this->m_geo->cek_kec($kodenegara,$kodeprov,$kodekotakab,$kodekec,$namakec);
		if ($tipe=='input') {
			if ($cek_kec>0){
				redirect('master/kec/index/exist');
			} else {
				$info_input=array(
					'kodenegara'=>strtoupper($kodenegara),
					'kodeprov'=>strtoupper($kodeprov),
					'kodekotakab'=>strtoupper($kodekotakab),
					'kodekec'=>strtoupper($kodekec),
					'namakec'=>$namakec,
					'inputdate'=>date('Y-m-d H:i:s'),						
					'inputby'=>$this->session->userdata('nik')						
				);
				$this->db->insert('sc_mst.kec',$info_input);				
				redirect('master/kec/index/success');
			}			
		} else if ($tipe=='edit'){			
			$info_edit1=array(
					'kodenegara'=>strtoupper($kodenegara),
					'kodeprov'=>strtoupper($kodeprov),
					'kodekotakab'=>strtoupper($kodekotakab),					
					'namakec'=>$namakec,
					'updatedate'=>date('Y-m-d H:i:s'),						
					'updateby'=>$this->session->userdata('nik')	
			);	
			$this->db->where('kodenegara',$oldkodenegara);
			$this->db->where('kodeprov',$oldkodeprov);
			$this->db->where('kodekotakab',$oldkodekotakab);
			$this->db->where('kodekec',$kodekec);
			$this->db->update('sc_mst.kec',$info_edit1);			
			redirect('master/kec/index/success');
			//redirect("master/kec/edit/$kodenegara/$kodeprov/$kodekotakab/$kodekec/upsuccess");					
		} else {
			redirect('master/kec/index/notacces');
		}		
	}
}