<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jadwal extends CI_Model {

	var $table = 'sc_trx.jadwalkerja';	
	var $column = array('kdkepegawaian','nmkepegawaian');
	var $order = array('kdkepegawaian' => 'asc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function opt_regu(){
		return $this->db->query("select * from sc_mst.regu");
	}
	
	function opt_jamkerja(){
		return $this->db->query("select * from sc_mst.jam_kerja");
	}
	
	function jadwalkerja(){
		return $this->db->query("select * from sc_trx.jadwalkerja a
								left outer join sc_mst.regu b on a.kdregu=b.kdregu
								left outer join sc_mst.jam_kerja c on c.kdjam_kerja=a.kodejamkerja");
	}
	
	function jadwalkerja_id($id){
		return $this->db->query("select to_char(tgl,'dd-mm-yyyy') as tgl,upper(cast(shift_tipe as char)) as shift_tipe,trim(nik) as nik,trim(kdregu) as kdregu,trim(kodejamkerja) as kodejamkerja,inputdate,id from sc_trx.jadwalkerja where id='$id'");		
	}
	
	private function _get_datatables_query()
	{
		
		$this->db->from('sc_trx.jadwalkerja a');
		$this->db->join('sc_mst.regu b','a.kdregu=b.kdregu');
		//$this->db->query("select * from sc_mst.status_kepegawaian");

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])				
				($i===0) ? $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value'])) : $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		//$this->_get_datatables_query();
		

		//$this->db->from($this->table);
		//$this->db->query("select * from sc_mst.status_kepegawaian");

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])				
				($i===0) ? $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value'])) : $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));			
			$column[$i] = $item;
			$i++;
		}
		
		
		/*
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
			//$orderne=" order by ".key($order)." ".$order[key($order)];
		}
		*/
		
		if($_POST['length'] != -1)
		$limit=" limit ".$_POST['length']." offset ".$_POST['start'];				

		$query = $this->db->query("select * from sc_mst.status_kepegawaian $limit");
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function cek_exist($kdregu,$kdjamkrja,$tgl){
		return $this->db->query("select * from sc_trx.jadwalkerja a
								where kdregu='$kdregu' and kodejamkerja='$kdjamkrja' and tgl='$tgl'")->num_rows();
	}
	
	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('kdkepegawaian',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		return $this->db->insert($this->table, $data);
		//return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('kdkepegawaian', $id);
		$this->db->delete($this->table);
	}


}
