<?php
class M_tetap extends CI_Model{
    /* Detail Gaji */
    var $t_dtlgaji = "sc_mst.v_dtlgaji_karyawan";
    var $t_dtlgaji_column = array('nik','nmlengkap','grouppenggajian','nmjabatan','gaji','tj_jabatan','tj_masakerja','tj_prestasi','gajibpjs1','gajinaker1'); //set column field database
    var $t_dtlgaji_default_order = array('nmlengkap' => 'asc'); // default order



    function list_karyawan(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where coalesce(statuskepegawaian,'')!='KO'
								order by nmlengkap asc");
		
	}
	
	function list_karyawan_detail($nik){
		return $this->db->query("select a.*,b.nmdept from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								where  a.nik='$nik'
								order by nmlengkap asc");
		
	}

	
	function list_detail($nik,$nodok){
		return $this->db->query("select a.*,to_char(round(a.nominal,0),'999G999G999G990D00') as nominal1,b.uraian from sc_tmp.payroll_detail a
								left outer join sc_mst.trxtype b on a.aksi=b.kdtrx and b.jenistrx='KOMPONEN PAYROLL'
								where a.nik='$nik' and a.nodok='$nodok'");
	
	}
	
	function cek_gajitetap($nik){
	
		return $this->db->query("select * from sc_mst.dtlgaji_karyawan where nik='$nik'");
	}
	
	function q_gajipokok($nik){
		return $this->db->query("select gajipokok from sc_mst.karyawan where nik='$nik'");
		
	}
	
	function q_gajibpjs($nik){
		return $this->db->query("select cast(coalesce(gajibpjs,0)as integer) as gajibpjs from sc_mst.karyawan where nik='$nik'");
		
	}
	
	function q_gajinaker($nik){
		return $this->db->query("select cast(coalesce(gajinaker,0) as integer) as gajinaker from sc_mst.karyawan where nik='$nik'");
		
	}
	function tj_jabatan($nik){
		return $this->db->query("select nominal from sc_mst.dtlgaji_karyawan where no_urut='7' and nik='$nik'");
	
	}
	
	function tj_masakerja($nik){
		return $this->db->query("select nominal from sc_mst.dtlgaji_karyawan where no_urut='8' and nik='$nik'");
	
	}
	
	function tj_prestasi($nik){
		return $this->db->query("select nominal from sc_mst.dtlgaji_karyawan where no_urut='9' and nik='$nik'");
	
	}
	
	function gajitetap($nik){
		return $this->db->query("select sum(nominal) as nominal from sc_mst.dtlgaji_karyawan where nik='$nik'");
	}
	
	function all_gaji(){
	
		return $this->db->query("select t2.nik,b.nmlengkap,to_char(round(t2.gajipokok,0),'999G999G999G990D') as gajipokok,to_char(round(t2.tj_jabatan,0),'999G999G999G990D') as tj_jabatan,
								to_char(round(t2.tj_masakerja,0),'999G999G999G990D') as tj_masakerja,to_char(round(t2.tj_prestasi,0),'999G999G999G990D') as tj_prestasi,
								to_char(round(t2.gajitetap,0),'999G999G999G990D') as gajitetap,to_char(round(t2.gajibpjs,0),'999G999G999G990D') as gajibpjs,
								to_char(round(t2.gajinaker,0),'999G999G999G990D') as gajinaker from 
								(select nik,sum(gajipokok) as gajipokok,sum(nominal1) as tj_jabatan,sum(nominal2) as tj_masakerja,sum(nominal3) as tj_prestasi,sum(gajitetap) gajitetap,sum(gajibpjs) as gajibpjs,sum(gajinaker) as gajinaker from 
								(select nik,gajipokok,0 as nominal1,0 as nominal2,0 as nominal3,gajitetap,gajibpjs,gajinaker from sc_mst.karyawan 
								union all 
								select  nik,0 as gajipokok,nominal,0 as nominal2,0 as nominal3,0 as gajtetap,0 as gajibpjs,0 as gajinaker from sc_mst.dtlgaji_karyawan where no_urut=7
								union all 
								select  nik,0 as gajipokok,0 as nominal1, nominal,0 as nominal3,0 as gajitetap,0 as gajibpjs,0 as gajinaker from sc_mst.dtlgaji_karyawan where no_urut=8
								union all
								select  nik,0 as gajipokok,0 as nominal1, 0 as nominal2,nominal,0 as gajitetap,0 as gajibpjs,0 as gajinaker from sc_mst.dtlgaji_karyawan where no_urut=9) as t1
								group by nik) as t2
								left outer join sc_mst.karyawan b on t2.nik=b.nik
								where b.grouppenggajian='P1' and b.statuskepegawaian<>'KO' and b.tglkeluarkerja is null
								order by nmlengkap asc");
	}

    function q_grouppenggajian($param = null){
        return $this->db->query("select * from sc_mst.group_penggajian where kdgroup_pg is not null $param ");
    }

    function q_dtlgajikaryawan($param =  null){
        return $this->db->query("select * from sc_mst.v_dtlgaji_karyawan where nik is not null $param
                                    order by nmlengkap");
    }

    function ins_dtlgaji($nik){
        $this->db->query("insert into sc_mst.dtlgaji_karyawan (nik,no_urut,keterangan,nominal)
							select '$nik' as nik,no_urut,keterangan,0 as nominal from sc_mst.detail_formula where tetap='T' and kdrumus='PR'
							and trim('$nik'||trim(cast(no_urut as character(3)))) not in (select trim(nik||trim(cast(no_urut as character(3)))) from sc_mst.dtlgaji_karyawan)");

    }


    private function _get_t_dtlgaji_query($param)
    {
        //if(isset($param)){
            //$this->db->where(array('grouppenggajian' => $param));
            $this->db->from($this->t_dtlgaji);
       /* } else {
            $this->db->from($this->t_dtlgaji);
        }*/

        $i = 0;

        foreach ($this->t_dtlgaji_column as $item)
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
                    if(count($this->t_dtlgaji_column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket

            }
            //$x_column[$i] = $item;
            $i++;
        }

        if(isset($_POST['order']))
        {
            if ($_POST['order']['0']['column']!=0){ //diset klo post column 0
                $this->db->order_by($this->t_dtlgaji_column[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
            }
        }
        else if(isset($this->t_dtlgaji_default_order))
        {
            $order = $this->t_dtlgaji_default_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_t_dtlgaji($param = null)
    {
        $this->_get_t_dtlgaji_query($param);
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function t_dtlgaji_count_filtered($param = null)
    {
        $this->_get_t_dtlgaji_query($param);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function t_dtlgaji_all($param = null)
    {
        //$this->db->where(array('grouppenggajian' => $param));
        $this->db->from($this->t_dtlgaji);
        return $this->db->count_all_results();
    }

    public function get_t_dtlgaji_by_id($id)
    {
        $this->db->from($this->t_dtlgaji);
        $this->db->where('nik',$id);
        $query = $this->db->get();

        return $query->row();
    }
    function recalculate_gaji_wilayah(){
	    return $this->db->query("select sc_tmp.pr_capture_gaji_pokok()");
    }
    function setup_payroll($p1){
	    return $this->db->query("select * from sc_mst.option where kdoption is not null $p1");
    }

    function q_master_lvl_gp($p1){
        return $this->db->query("select * from sc_mst.m_lvlgp where kdlvlgp is not null $p1");
    }

    function q_master_wilayah_nominal($p1){
        return $this->db->query("select * from sc_mst.m_wilayah_nominal where kdwilayahnominal is not null $p1");
    }

    function q_master_m_grade_jabatan($p1)
    {
        return $this->db->query("select * from sc_mst.m_grade_jabatan where kdgradejabatan is not null $p1
        order by groupgradejabatan asc,kdgradejabatan asc
        ");
    }

    function list_karyawan_detail_x($param){
        return $this->db->query("select * from sc_mst.karyawan 
								where  nik is not null $param
								order by nmlengkap asc");

    }
}	