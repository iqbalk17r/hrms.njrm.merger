<?php
/*
	@author : Junis
	02-12-2015
*/
//error_reporting(0);

class Keldesa extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_geo','m_geo_desa'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master Kelurahan / Desa";	        
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
		//$data['list_keldesa']=$this->m_geo->list_keldesa()->result();
		$data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
		$data['list_opt_prov']=$this->m_geo->list_opt_prov()->result();
		$data['list_opt_kotakab']=$this->m_geo->list_opt_kotakab()->result();
		$data['list_opt_kec']=$this->m_geo->list_opt_kec()->result();
		$this->template->display('master/geo/keldesa/v_keldesa',$data);
    }
	
	public function ajax_list()
	{
		$list = $this->m_geo_desa->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $person->kodekeldesa;			
			$row[] = $person->namanegara;
			$row[] = $person->namaprov;	
			$row[] = $person->namakotakab;	
			$row[] = $person->namakec;				
			$row[] = $person->namakeldesa;				
			$row[] = $person->kodepos;				
			$negara=trim($person->kodenegara);
			$prov=trim($person->kodeprov); 
			$kotakab=trim($person->kodekotakab);
			$kec=trim($person->kodekec);
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="'.site_url("master/keldesa/edit/$negara/$prov/$kotakab/$kec").'/'.$person->kodekeldesa.'" title="Edit" onclick="'."return confirm('Anda Yakin Edit Data ini?')".'"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="'.site_url("master/keldesa/hps/$negara/$prov/$kotakab/$kec").'/'.$person->kodekeldesa.'" title="Hapus" onclick="'."return confirm('Anda Yakin Hapus Data ini?')".'"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_geo_desa->count_all(),
						"recordsFiltered" => $this->m_geo_desa->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	function edit($kodenegara,$kodeprov,$kodekotakab,$kodekec,$kodekeldesa){
		if (empty($kodekeldesa)){
			redirect('master/keldesa/');
		} else {
			$data['title']='EDIT DATA Kelurahan/Desa';			
			if($this->uri->segment(9)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_keldesa']=$this->m_geo->dtl_keldesa($kodenegara,$kodeprov,$kodekotakab,$kodekec,$kodekeldesa);
			$data['list_opt_neg']=$this->m_geo->list_opt_negara()->result();
			$data['list_opt_prov']=$this->m_geo->list_opt_prov()->result();
			$data['list_opt_kotakab']=$this->m_geo->list_opt_kotakab()->result();
			$data['list_opt_kec']=$this->m_geo->list_opt_kec()->result();
			$this->template->display('master/geo/keldesa/v_editkeldesa',$data);
		}		
	}
	
	function hps($kodenegara,$kodeprov,$kodekotakab,$kodekec,$kodekeldesa){	
		//$cek_delete=$this->m_geo->cek_del($kodekeldesa);
		$cek_delete=0;
		if ($cek_delete>0) {
			redirect('master/keldesa/index/del_exist');
		} else {			
			$this->db->where('kodenegara',$kodenegara);
			$this->db->where('kodeprov',$kodeprov);
			$this->db->where('kodekotakab',$kodekotakab);
			$this->db->where('kodekeldesa',$kodekeldesa);
			$this->db->delete('sc_mst.keldesa');
			redirect('master/keldesa/index/del');
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$kodekeldesa=strtoupper(trim($this->input->post('kdkeldesa')));
		$kodepos=strtoupper(trim($this->input->post('kodepos')));
		$kodenegara=trim($this->input->post('negara'));
		$kodeprov=trim($this->input->post('provinsi'));
		$kodekotakab=trim($this->input->post('kotakab'));
		$kodekec=trim($this->input->post('kec'));		
		$oldkodenegara=trim($this->input->post('oldnegara'));
		$oldkodeprov=trim($this->input->post('oldprov'));
		$oldkodekotakab=trim($this->input->post('oldkotakab'));
		$oldkec=trim($this->input->post('oldkec'));
		$namakeldesa=strtoupper($this->input->post('namakeldesa'));				
		$cek_keldesa=$this->m_geo->cek_keldesa($kodenegara,$kodeprov,$kodekotakab,$kodekec,$kodekeldesa,$namakeldesa);
		if ($tipe=='input') {
			if ($cek_keldesa>0){
				redirect('master/keldesa/index/exist');
			} else {
				$info_input=array(
					'kodenegara'=>strtoupper($kodenegara),
					'kodepos'=>$kodepos,
					'kodeprov'=>strtoupper($kodeprov),
					'kodekotakab'=>strtoupper($kodekotakab),
					'kodekec'=>strtoupper($kodekec),
					'kodekeldesa'=>strtoupper($kodekeldesa),
					'namakeldesa'=>$namakeldesa,
					'inputdate'=>date('Y-m-d H:i:s'),						
					'inputby'=>$this->session->userdata('nik')						
				);
				$this->db->insert('sc_mst.keldesa',$info_input);				
				redirect('master/keldesa/index/success');
			}			
		} else if ($tipe=='edit'){			
			$info_edit1=array(
					'kodenegara'=>strtoupper($kodenegara),
					'kodepos'=>$kodepos,
					'kodeprov'=>strtoupper($kodeprov),
					'kodekotakab'=>strtoupper($kodekotakab),					
					'namakeldesa'=>$namakeldesa,
					'updatedate'=>date('Y-m-d H:i:s'),						
					'updateby'=>$this->session->userdata('nik')	
			);	
			$this->db->where('kodenegara',$oldkodenegara);
			$this->db->where('kodeprov',$oldkodeprov);
			$this->db->where('kodekotakab',$oldkodekotakab);
			$this->db->where('kodekeldesa',$kodekeldesa);
			$this->db->update('sc_mst.keldesa',$info_edit1);			
			redirect('master/keldesa/index/success');
			//redirect("master/keldesa/edit/$kodenegara/$kodeprov/$kodekotakab/$kodekec/$kodekeldesa/upsuccess");					
		} else {
			redirect('master/keldesa/index/notacces');
		}		
	}
}