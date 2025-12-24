<?php
class M_geo_desa extends CI_Model{
	var $table = 'sc_mst.keldesa';	
	var $column = array('kodekeldesa','namanegara','namaprov','namakotakab','namakec','namakeldesa','kodepos');	
	var $order = array('namanegara' => 'asc','namaprov' => 'asc','namakotakab' => 'asc','namakec' => 'asc','namakeldesa' => 'asc');
	
	//punyane Kelurahan Desa
	private function _get_datatables_query()
	{		
		$this->db->from($this->table);
		$this->db->join('sc_mst.negara b', 'b.kodenegara=sc_mst.keldesa.kodenegara');
		$this->db->join('sc_mst.provinsi c ', 'c.kodeprov=sc_mst.keldesa.kodeprov');
		$this->db->join('sc_mst.kotakab d', 'd.kodekotakab=sc_mst.keldesa.kodekotakab');
		$this->db->join('sc_mst.kec e ', 'e.kodekec=sc_mst.keldesa.kodekec');
		//$this->db->query("select * from sc_mst.trxtype");

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
		$this->_get_datatables_query();			
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query=$this->db->get();
		return $query->result();
	}
	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('kdtrx',$id);
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
		$this->db->where('kdtrx', $id);
		$this->db->delete($this->table);
	}
}


