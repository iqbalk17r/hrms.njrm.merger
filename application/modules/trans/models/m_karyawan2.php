<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_karyawan extends CI_Model {

	var $table = 'sc_tmp.karyawan';
	var $tablemst = 'sc_mst.lv_m_karyawan';
	var $column = array('nik','nmlengkap','image','nmdept','nmjabatan','tglmasukkerja1','kdcabang');
	var $order = array('nmlengkap' => 'asc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{

        $this->db->where(array("coalesce(statuskepegawaian,'') !=" => 'KO'));
        $this->db->from($this->tablemst);
        $i = 0;
        foreach ($this->column as $item)
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start();
                    $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
                }
                else
                {
                    $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
                }
                if(count($this->column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket

            }
            //$x_column[$i] = $item;
            $i++;
        }
        if(isset($_POST['order']))
        {
            if ($_POST['order']['0']['column']!=0){ //diset klo post column 0
                $this->db->order_by($this->column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

	}

    function list_lvkaryawan($params = "") {
        return $this->db->query("
            SELECT * 
            FROM sc_mst.lv_m_karyawan
            $params
        ");
    }

    function list_karyawan(){
        return $this->db->query("select a.*,a.nik,a.nmlengkap,b.nmjabatan,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmgrade,g1.nmagama,g2.namanegara,g3.namaprov as nmprovlahir,g4.namakotakab as nmkotalahir,
                                        h1.namaprov as nmprovktp,
                                        h2.namakotakab as nmkotaktp,
                                        h3.namakec as nmkecktp,
                                        h4.namakeldesa as nmdesaktp,
                                        i1.namaprov as nmprovtinggal,
                                        i2.namakotakab as nmkotatinggal,
                                        i3.namakec as nmkectinggal,
                                        i4.namakeldesa as nmdesatinggal
                                        from sc_mst.karyawan a
                                            left outer join sc_mst.departmen c on a.bag_dept=c.kddept  
                                            left outer join sc_mst.subdepartmen d on a.subbag_dept=d.kdsubdept and a.bag_dept=d.kddept
                                            left outer join sc_mst.jabatan b on a.subbag_dept=b.kdsubdept and a.bag_dept=b.kddept and a.jabatan=b.kdjabatan 
                                            left outer join sc_mst.lvljabatan e on a.lvl_jabatan=e.kdlvl
                                            left outer join sc_mst.jobgrade f on a.grade_golongan=f.kdgrade
                                    
                                            left outer join sc_mst.agama g1 on a.kd_agama=g1.kdagama
                                            left outer join sc_mst.negara g2 on a.neglahir=g2.kodenegara
                                            left outer join sc_mst.provinsi g3 on a.provlahir=g3.kodeprov
                                            left outer join sc_mst.kotakab g4 on a.kotalahir=g4.kodekotakab and g4.kodeprov=g3.kodeprov
                                            left outer join sc_mst.negara g5 on a.negktp=g5.kodenegara
                                            
                                            left outer join sc_mst.provinsi h1 on a.provktp=h1.kodeprov
                                            left outer join sc_mst.kotakab h2 on a.kotaktp=h2.kodekotakab and h2.kodeprov=h1.kodeprov
                                            left outer join sc_mst.kec h3 on a.kecktp=h3.kodekec
                                            left outer join sc_mst.keldesa h4 on a.kelktp=h4.kodekeldesa
                                    
                                            left outer join sc_mst.provinsi i1 on a.provtinggal=i1.kodeprov 
                                            left outer join sc_mst.kotakab i2 on a.kotatinggal=i2.kodekotakab and i2.kodeprov=i1.kodeprov
                                            left outer join sc_mst.kec i3 on a.kectinggal=i3.kodekec
                                            left outer join sc_mst.keldesa i4 on a.keltinggal=i4.kodekeldesa
                                            where coalesce(a.statuskepegawaian,'')!='KO'");
    }

    function list_karyawan_resign(){
        return $this->db->query("select a.*,a.nik,a.nmlengkap,b.nmjabatan,c.nmdept,d.nmsubdept,e.nmlvljabatan,f.nmgrade,g1.nmagama,g2.namanegara,g3.namaprov as nmprovlahir,g4.namakotakab as nmkotalahir,
                                        h1.namaprov as nmprovktp,
                                        h2.namakotakab as nmkotaktp,
                                        h3.namakec as nmkecktp,
                                        h4.namakeldesa as nmdesaktp,
                                        i1.namaprov as nmprovtinggal,
                                        i2.namakotakab as nmkotatinggal,
                                        i3.namakec as nmkectinggal,
                                        i4.namakeldesa as nmdesatinggal
                                        from sc_mst.karyawan a
                                            left outer join sc_mst.departmen c on a.bag_dept=c.kddept  
                                            left outer join sc_mst.subdepartmen d on a.subbag_dept=d.kdsubdept and a.bag_dept=d.kddept
                                            left outer join sc_mst.jabatan b on a.subbag_dept=b.kdsubdept and a.bag_dept=b.kddept and a.jabatan=b.kdjabatan 
                                            left outer join sc_mst.lvljabatan e on a.lvl_jabatan=e.kdlvl
                                            left outer join sc_mst.jobgrade f on a.grade_golongan=f.kdgrade
                                    
                                            left outer join sc_mst.agama g1 on a.kd_agama=g1.kdagama
                                            left outer join sc_mst.negara g2 on a.neglahir=g2.kodenegara
                                            left outer join sc_mst.provinsi g3 on a.provlahir=g3.kodeprov
                                            left outer join sc_mst.kotakab g4 on a.kotalahir=g4.kodekotakab and g4.kodeprov=g3.kodeprov
                                            left outer join sc_mst.negara g5 on a.negktp=g5.kodenegara
                                            
                                            left outer join sc_mst.provinsi h1 on a.provktp=h1.kodeprov
                                            left outer join sc_mst.kotakab h2 on a.kotaktp=h2.kodekotakab and h2.kodeprov=h1.kodeprov
                                            left outer join sc_mst.kec h3 on a.kecktp=h3.kodekec
                                            left outer join sc_mst.keldesa h4 on a.kelktp=h4.kodekeldesa
                                    
                                            left outer join sc_mst.provinsi i1 on a.provtinggal=i1.kodeprov 
                                            left outer join sc_mst.kotakab i2 on a.kotatinggal=i2.kodekotakab and i2.kodeprov=i1.kodeprov
                                            left outer join sc_mst.kec i3 on a.kectinggal=i3.kodekec
                                            left outer join sc_mst.keldesa i4 on a.keltinggal=i4.kodekeldesa
                                            where coalesce(a.statuskepegawaian,'')='KO'");
    }

	function list_karyresgn(){
		return $this->db->query("select a.*,a.nik,a.nmlengkap,b.nmjabatan,c.nmdept from sc_mst.karyawan a
		left outer join sc_mst.jabatan b on a.jabatan=b.kdjabatan and a.subbag_dept=b.kdsubdept
		left outer join sc_mst.departmen c on a.bag_dept=c.kddept where coalesce(a.statuskepegawaian,'')='KO' order by a.tglkeluarkerja desc");
	}

	function q_finger(){
		return $this->db->query("select * from sc_mst.fingerprint order by kodecabang asc");
	}

	function q_kanwil(){
		return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang asc");
	}

	function list_karyborong(){
		return $this->db->query("select a.*,a.nik,a.nmlengkap,b.nmjabatan,c.nmdept from sc_mst.karyawan a
		left outer join sc_mst.jabatan b on a.jabatan=b.kdjabatan
		left outer join sc_mst.departmen c on a.bag_dept=c.kddept where a.tjborong='t' and coalesce(a.statuskepegawaian,'')<>'KO'");
	}


	function cek_exist($nik){
		return $this->db->query("select * from sc_mst.karyawan where nik='$nik'")->num_rows();
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$query = $this->db->get();
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

	public function get_dtl_id($id)
	{
		return $this->db->query("select * from sc_mst.lv_m_karyawan where nik='$id'");
	}

	public function get_by_id($id)
	{
		return $this->db->query("select * from  sc_mst.lv_m_karyawan where nik='$id'");
	}

	public function save($data)
	{
		return $this->db->insert('sc_tmp.karyawan', $data);
		//return $this->db->insert_id();
	}

	public function save_foto($nip,$info)
	{
		$this->db->where('nik',$nip);
		$this->db->update('sc_mst.karyawan', $info);
	}

	public function update($where, $data)
	{
		$this->db->update('sc_mst.karyawan', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		//$this->db->where('nik', $id);
		return $this->db->query("update sc_mst.karyawan set status='D' where nik='$id'");
	}

	function list_ptkp(){
		return $this->db->query("select * from sc_mst.status_nikah order by kdnikah");
	}

	function q_besaranptkp($status_ptkp){
		return $this->db->query("select cast(besaranpertahun as numeric(18,0)) from sc_mst.ptkp where kodeptkp='$status_ptkp'");

	}

    function q_regu(){
        return $this->db->query("select * from sc_mst.regu order by nmregu");

    }
    function q_wilayah_nominal($param){
	    return $this->db->query("select * from sc_mst.m_wilayah_nominal where c_hold='NO' $param");
    }

    function q_karyawan_read($where){
        return $this->db
            ->select('*')
            ->where($where)
            ->get('sc_mst.karyawan');
    }
    function q_karyawan_exist($where){
        return $this->db
                ->select('*')
                ->where($where)
                ->get('sc_mst.karyawan')
                ->num_rows() > 0;
    }

}
