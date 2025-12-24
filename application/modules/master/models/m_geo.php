<?php
class M_geo extends CI_Model{
	var $table = 'sc_mst.kec';	
	var $column = array('kodekec','namanegara','namaprov','namakotakab','namakec');	
	var $order = array('namakec' => 'asc');

    function list_negara($params = "") {
        return $this->db->query("
            SELECT * 
            FROM sc_mst.negara
            $params
        ");
    }

    function list_prov($params = "") {
        return $this->db->query("
            SELECT * 
            FROM sc_mst.provinsi a
            LEFT OUTER JOIN sc_mst.negara b ON a.kodenegara = b.kodenegara
            $params
            ORDER BY b.namanegara, namaprov
        ");
    }

    function list_kotakab($params = "") {
        return $this->db->query("
            SELECT * 
            FROM sc_mst.kotakab a
            LEFT OUTER JOIN sc_mst.negara b ON a.kodenegara = b.kodenegara
            LEFT OUTER JOIN sc_mst.provinsi c ON a.kodeprov = c.kodeprov
            $params
            ORDER BY b.namanegara, c.namaprov, a.namakotakab
        ");
    }

    function list_kec($params = "") {
        return $this->db->query("
            SELECT * 
            FROM sc_mst.kec a
            LEFT OUTER JOIN sc_mst.kotakab d ON a.kodekotakab = d.kodekotakab
            LEFT OUTER JOIN sc_mst.negara b ON a.kodenegara = b.kodenegara
            LEFT OUTER JOIN sc_mst.provinsi c ON a.kodeprov = c.kodeprov
            $params
            ORDER BY namanegara, namaprov, namakotakab, namakec
        ");
    }

    function list_keldesa($params = "") {
        return $this->db->query("
            SELECT * 
            FROM sc_mst.keldesa a
            LEFT OUTER JOIN sc_mst.kec e ON e.kodekec = a.kodekec
            LEFT OUTER JOIN sc_mst.kotakab d ON a.kodekotakab = d.kodekotakab
            LEFT OUTER JOIN sc_mst.negara b ON a.kodenegara = b.kodenegara
            LEFT OUTER JOIN sc_mst.provinsi c ON a.kodeprov = c.kodeprov
            $params
            ORDER BY namanegara, namaprov, namakotakab, namakec, namakec
        ");
    }
	//list option
	function list_opt_negara($params = "") {
        return $this->db->query("SELECT * FROM sc_mst.negara $params");
	}
	
	function list_opt_prov($params = "") {
		return $this->db->query("SELECT * FROM sc_mst.provinsi $params ORDER BY namaprov, kodeprov");
	}
	
	function list_opt_kotakab($params = "") {
		return $this->db->query("SELECT * FROM sc_mst.kotakab $params ORDER BY namakotakab, kodekotakab");
	}
	
	function list_opt_kec($params = "") {
		return $this->db->query("SELECT * FROM sc_mst.kec $params ORDER BY namakec, kodekec");
	}
	
	function list_opt_keldesa($params = "") {
		return $this->db->query("SELECT * FROM sc_mst.keldesa $params ORDER BY namakeldesa, kodekeldesa");
	}

	function user_online(){
		return $this->db->query("select * from sc_mst.user");
	}
	
	
	function dtl_negara($kodenegara){
		return $this->db->query("select * from sc_mst.negara where kodenegara='$kodenegara'")->row_array();
	}
	
	function dtl_prov($kodenegara,$kodeprov){
		return $this->db->query("select * from sc_mst.provinsi where kodenegara='$kodenegara' and kodeprov='$kodeprov'")->row_array();
	}
	
	function dtl_kotakab($kodenegara,$kodeprov,$kodekotakab){
		return $this->db->query("select * from sc_mst.kotakab where kodenegara='$kodenegara' and kodeprov='$kodeprov' and kodekotakab='$kodekotakab'")->row_array();
	}
	
	function dtl_kec($kodenegara,$kodeprov,$kodekotakab,$kodekec){
		return $this->db->query("select * from sc_mst.kec where kodenegara='$kodenegara' and kodeprov='$kodeprov' and kodekotakab='$kodekotakab' and kodekec='$kodekec'")->row_array();
	}
	
	function dtl_keldesa($kodenegara,$kodeprov,$kodekotakab,$kodekec,$kodekeldesa){
		return $this->db->query("select * from sc_mst.keldesa where kodenegara='$kodenegara' and kodeprov='$kodeprov' and kodekotakab='$kodekotakab' and kodekec='$kodekec' and kodekeldesa='$kodekeldesa'")->row_array();
	}
	//cek seblum hapus
	function cek_del_negara($kodenegara){
		return $this->db->query("select * from sc_mst.provinsi where trim(kodenegara)='$kodenegara'")->num_rows();
	}
	
	function cek_del_prov($kodenegara,$kodeprov){
		return $this->db->query("select * from sc_mst.kotakab where trim(kodenegara)='$kodenegara' and trim(kodeprov)='$kodeprov'")->num_rows();
	}
	
	function user_profile(){
		$kodenegara=$this->session->userdata('nik');
		return $this->db->query("select * from sc_mst.user where nik='$kodenegara'");
	}
	
	// cek seblum input
	function cek_negara($kodenegara){
		return $this->db->query("select * from sc_mst.negara where kodenegara='$kodenegara'")->num_rows();
	}
	
	function cek_prov($kodenegara,$kodeprov,$namaprov){
		return $this->db->query("select * from sc_mst.provinsi where kodenegara='$kodenegara' and kodeprov='$kodeprov' or namaprov='$namaprov'")->num_rows();
	}
	
	function cek_kotakab($kodenegara,$kodeprov,$kodekotakab,$namakotakab){
		return $this->db->query("select * from sc_mst.kotakab where kodenegara='$kodenegara' and kodeprov='$kodeprov' and kodekotakab='$kodekotakab' or namakotakab='$namakotakab'")->num_rows();
	}
	
	function cek_kec($kodenegara,$kodeprov,$kodekotakab,$kodekec,$namakec){
		return $this->db->query("select * from sc_mst.kec where kodenegara='$kodenegara' and kodeprov='$kodeprov' and kodekotakab='$kodekotakab' and kodekec='$kodekec' or namakec='$namakec' ")->num_rows();
	}
	
	function cek_keldesa($kodenegara,$kodeprov,$kodekotakab,$kodekec,$kodekeldesa,$namakeldesa){
		return $this->db->query("select * from sc_mst.keldesa where kodenegara='$kodenegara' and kodeprov='$kodeprov' and kodekotakab='$kodekotakab' and kodekec='$kodekec' and kodekeldesa='$kodekeldesa' or namakeldesa='$namakeldesa' ")->num_rows();
	}
	//punyane kecamatan
	private function _get_datatables_query()
	{		
		$this->db->from($this->table);
		$this->db->join('sc_mst.kotakab d', 'sc_mst.kec.kodekotakab=d.kodekotakab');
		$this->db->join('sc_mst.negara b', 'sc_mst.kec.kodenegara=b.kodenegara');
		$this->db->join('sc_mst.provinsi c', 'sc_mst.kec.kodeprov=c.kodeprov');
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


    function list_negara_param($param = null){
        return $this->db->query("select * from sc_mst.negara where kodenegara is not null $param");
    }

    function list_prov_param($param = null){
        return $this->db->query("select * from(
                                     select a.*,b.namanegara from sc_mst.provinsi a
                                     left outer join sc_mst.negara b on a.kodenegara=b.kodenegara) as x
                                     where kodeprov is not null $param
                                     order by namanegara,namaprov");
    }

    function list_kotakab_param($param = null){
        return $this->db->query("select * from (
                                    select a.*,b.namanegara,c.namaprov from sc_mst.kotakab a
                                    left outer join sc_mst.negara b on a.kodenegara=b.kodenegara
                                    left outer join sc_mst.provinsi c on a.kodeprov=c.kodeprov) as x
                                    where kodeprov is not null $param
                                    order by namanegara,namaprov,namakotakab");
    }

    function list_kec_param($param = null){
        return $this->db->query("select * from (
                                    select a.*,b.namanegara,c.namaprov,d.namakotakab from sc_mst.kec a
                                    left outer join sc_mst.kotakab d on a.kodekotakab=d.kodekotakab
                                    left outer join sc_mst.negara b on a.kodenegara=b.kodenegara
                                    left outer join sc_mst.provinsi c on a.kodeprov=c.kodeprov) as x
                                    where kodekec is not null $param
                                    order by namanegara,namaprov,namakotakab,namakec");
    }

    function list_keldesa_param($param = null){
        return $this->db->query("select * from (
                                    select a.*,b.namanegara,c.namaprov,d.namakotakab,e.namakec from sc_mst.keldesa a
                                    left outer join sc_mst.kec e on e.kodekec=a.kodekec
                                    left outer join sc_mst.kotakab d on a.kodekotakab=d.kodekotakab
                                    left outer join sc_mst.negara b on a.kodenegara=b.kodenegara
                                    left outer join sc_mst.provinsi c on a.kodeprov=c.kodeprov) as x
                                    where kodekeldesa is not null $param
                                    order by namanegara,namaprov,namakotakab,namakec,namakec,namakeldesa");
    }

}


