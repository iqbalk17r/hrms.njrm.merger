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

    function penempatan_karyawan($param){
        // Menggunakan query dengan parameter untuk menghindari SQL injection
        return $this->db->query("SELECT split_part(kw.desc_cabang, ' ', 1) AS cabang
                                  FROM sc_mst.karyawan k
                                  JOIN sc_mst.kantorwilayah kw ON k.kdcabang = kw.kdcabang
                                  WHERE trim(k.nmlengkap) = ?", array($param));
    }
    

    function read_trxstatuspegawai($param = ''){
        return $this->db->query("select *
from ( select x.docno,
              x.nik,
              x.docdate,
              x.status,
              x.jenis,
              x.startdate,
              x.enddate,
              x.description,
              x.olddept,
              x.oldsubdept,
              x.oldjabatan,
              x.oldlvljabatan,
              x.newdept,
              x.newsubdept,
              x.newjabatan,
              x.newlvljabatan,
              x.tgllahir,
              x.tglmasukkerja,
              x.status_kepegawaian,
              x.nmlengkap,
              x.nmnewdept,
              x.nmnewsubdept,
              x.nmnewjabatan,
              x.nmolddept,
              x.nmoldsubdept,
              x.nmoldjabatan,
              x.oldgrade,
              x.newgrade,
              x.oldgp,
              x.newgp,
              x.oldtjojt,
              x.newtjojt,
              coalesce(to_char(x.tgl_mulai_kontrak,'yyyy-mm-dd'),'-') as tgl_mulai_kontrak,
              coalesce(to_char(x.tgl_selesai_kontrak,'yyyy-mm-dd'),'-') as tgl_selesai_kontrak,
              coalesce(to_char(x.tgl_mulai_ojt,'yyyy-mm-dd'),'-') as tgl_mulai_ojt,
              coalesce(to_char(x.tgl_selesai_ojt,'yyyy-mm-dd'),'-') as tgl_selesai_ojt,
              x.urainnew,
              x.uraianold,
              x.tgl_berlaku,
              x.kabag,
              x.spv         
       from (select case
                 when trim(a.kdkepegawaian) = 'KK' then a.tgl_mulai
                 else null end                                       as tgl_mulai_kontrak,
             case
                 when trim(a.kdkepegawaian) = 'KK' then a.tgl_selesai
                 else null end                                       as tgl_selesai_kontrak,
             case
                 when trim(a.kdkepegawaian) = 'OJ' then a.tgl_mulai
                 else null end                                       as tgl_mulai_ojt,
             case
                 when trim(a.kdkepegawaian) = 'OJ' then a.tgl_selesai
                 else null end                                       as tgl_selesai_ojt,
             a.nodok as docno,
             a.nik,
             a.input_date as docdate,
             a.status,
             trim(b.statuskepegawaian) as jenis,
             a.tgl_mulai as startdate,
             a.tgl_selesai as enddate,
             a.keterangan as description,
             c.kddept as olddept,
             e.kdsubdept as oldsubdept,
             c.kdjabatan as oldjabatan,
             b.lvl_jabatan as oldlvljabatan,
             c.kddept as newdept,
             e.kdsubdept as newsubdept,
             c.kdjabatan as newjabatan,
             b.lvl_jabatan as newlvljabatan,
             b.tgllahir,
             b.tglmasukkerja,
             case
                 when trim(b.statuskepegawaian) = 'KT' then 'Tetap'
                 when trim(b.statuskepegawaian) = 'KK' then 'Kontrak'
                 when trim(b.statuskepegawaian) = 'MG' then 'Magang' end as status_kepegawaian,
             b.nmlengkap,
             d.nmdept as nmnewdept,
             e.nmsubdept as nmnewsubdept,
             c.nmjabatan as nmnewjabatan,
             d.nmdept as nmolddept,
             e.nmsubdept as nmoldsubdept,
             c.nmjabatan as nmoldjabatan,
             c.kdgrade as oldgrade,
             c.kdgrade as newgrade,
             f.total_upah as oldgp,
             f.total_upah as newgp,
             (f.tunjangan_jbt::money-f.tunjangan_jbt::money) * 50/100 as oldtjojt,
             f.tunjangan_jbt as newtjojt,
             coalesce(nullif(c.uraian,''),'-') as urainnew,
             coalesce(nullif(c.uraian,''),'-') as uraianold,
             upper(to_char(a.tgl_mulai, 'TMday, FMdd TMMonth yyyy')) as tgl_berlaku,
             r.nmlengkap as spv,
             r1.nmlengkap as kabag            
      from sc_trx.status_kepegawaian a
               left outer join sc_mst.karyawan b on b.nik = a.nik
               left outer join sc_mst.jabatan c on c.kdjabatan = b.jabatan
               left outer join sc_mst.departmen d on d.kddept = b.bag_dept
               left outer join sc_mst.subdepartmen e on e.kdsubdept = b.subbag_dept
               left outer join sc_mst.gaji f on f.kdgrade = c.kdgrade
               LEFT OUTER JOIN sc_mst.karyawan r on true and r.lvl_jabatan='03' and r.bag_dept=b.bag_dept and r.subbag_dept=b.subbag_dept and r.statuskepegawaian<>'KO'
               LEFT OUTER JOIN sc_mst.karyawan r1 on true and r1.lvl_jabatan='B' and r1.bag_dept=b.bag_dept and r1.subbag_dept=b.subbag_dept and r1.statuskepegawaian<>'KO'
      ) as x ) as y
        WHERE COALESCE(docno, '') != ''
            $param
        ");
    }

    function q_read_lvjabatan($param = '') {
        return $this->db->query("
            select *
            from (select bag_dept, subbag_dept, lvl_jabatan, nmlengkap
                  from sc_mst.lv_m_karyawan
            ) x
            where true 
            $param
        ");
    }

// Fungsi untuk mengubah angka menjadi kata
function angka_ke_kata($angka) {
    $huruf = [
        1 => 'satu', 2 => 'dua', 3 => 'tiga', 4 => 'empat', 5 => 'lima',
        6 => 'enam', 7 => 'tujuh', 8 => 'delapan', 9 => 'sembilan', 10 => 'sepuluh',
        11 => 'sebelas', 12 => 'dua belas'
    ];

    return $huruf[$angka];
}

// Fungsi untuk menghitung selisih bulan
function masa_kontrak($tgl_mulai, $tgl_selesai) {
    $date1 = new DateTime($tgl_mulai);
    $date2 = new DateTime($tgl_selesai);

    // Hitung total hari
    $interval = $date1->diff($date2);
    $total_days = $interval->days;

    // Konversi ke bulan (rata-rata 30.44 hari per bulan)
    $approx_months = round($total_days / 30.44);
	$total_bulan_kata = $this->angka_ke_kata($approx_months);

    return $approx_months . ' ('. $total_bulan_kata .') ';
}

function masa_kontrak2($tgl_mulai, $tgl_selesai) {
    // Membuat objek DateTime
    $date1 = new DateTime($tgl_mulai);
    $date2 = new DateTime($tgl_selesai);

    // Hitung selisih tahun dan bulan
    $year_diff = $date2->format('Y') - $date1->format('Y');
    $month_diff = $date2->format('m') - $date1->format('m');

    // Jika bulan selisihnya negatif, kurangi tahun dan perbaiki bulan
    if ($month_diff < 0) {
        $year_diff--;
        $month_diff += 12;
    }

    // Total bulan yang dihitung dengan menambah 1 untuk bulan pertama
    $total_months = ($year_diff * 12) + $month_diff + 1;

    // Adjust total_months if it is 7 or 13
    if ($total_months == 7) {
        $total_months = 6;
    } elseif ($total_months == 13) {
        $total_months = 12;
    } elseif ($total_months == 5) {
        $total_months = 6;
    } elseif ($total_months == 11) {
        $total_months = 12;
    }

    $total_bulan_kata = $this->angka_ke_kata($total_months);
    $result = $total_months . ' ('. $total_bulan_kata .') ';
    return $result;
}

function pkwt_terakhir($nik){
    return $this->db->query("
                select a.*,b.nmkepegawaian,b.nmkepegawaian,ROW_NUMBER() OVER (ORDER BY tgl_selesai desc) AS row_number,c.nmlengkap,to_char(a.tgl_mulai,'dd-mm-YYYY')as tgl_mulai1,
                                to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1,d.uraian as nmstatus
                                 from sc_trx.status_kepegawaian a
                                left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
                                left outer join sc_mst.karyawan c on a.nik=c.nik
                                left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='STSPEG'
                                where a.nik='$nik' and d.uraian = 'TELAH BERAKHIR' AND b.nmkepegawaian != 'KARYAWAN TETAP'
                                order by a.tgl_selesai desc
        ");

}

function jml_pkwt($nik){
    return $this->db->query("
            select a.*,b.nmkepegawaian,b.nmkepegawaian,ROW_NUMBER() OVER (ORDER BY tgl_selesai) AS row_number,c.nmlengkap,to_char(a.tgl_mulai,'dd-mm-YYYY')as tgl_mulai1,
                                            to_char(a.tgl_selesai,'dd-mm-YYYY')as tgl_selesai1,d.uraian as nmstatus
                                            from sc_trx.status_kepegawaian a
                                            left outer join sc_mst.status_kepegawaian b on a.kdkepegawaian=b.kdkepegawaian
                                            left outer join sc_mst.karyawan c on a.nik=c.nik
                                            left outer join sc_mst.trxtype d on a.status=d.kdtrx and d.jenistrx='STSPEG'
                                            where a.nik='$nik' AND b.nmkepegawaian != 'KARYAWAN TETAP' AND a.kdkepegawaian in ('PK','P1','P2','P3','P4','P5')
                                            order by a.tgl_selesai desc;
            
        ");
}

function masa_kontrak_cetak1($tgl_mulai, $tgl_selesai) {
    // Membuat objek DateTime
    $date1 = new DateTime($tgl_mulai);
    $date2 = new DateTime($tgl_selesai);

    // Hitung selisih tahun dan bulan
    $year_diff = $date2->format('Y') - $date1->format('Y');
    $month_diff = $date2->format('m') - $date1->format('m');

    // Jika bulan selisihnya negatif, kurangi tahun dan perbaiki bulan
    if ($month_diff < 0) {
        $year_diff--;
        $month_diff += 12;
    }

    // Total bulan yang dihitung dengan menambah 1 untuk bulan pertama
    $total_months = ($year_diff * 12) + $month_diff + 1;

    // Adjust total_months if it is 7 or 13
    if ($total_months == 7) {
        $total_months = 6;
    } elseif ($total_months == 13) {
        $total_months = 12;
    } elseif ($total_months == 5) {
        $total_months = 6;
    } elseif ($total_months == 11) {
        $total_months = 12;
    }

    return $total_months . ' bulan';
}

function masa_kontrak_cetak2($tgl_mulai, $tgl_selesai) {
    $date1 = new DateTime($tgl_mulai);
    $date2 = new DateTime($tgl_selesai);

    // Hitung selisih tahun dan bulan
    $year_diff = $date2->format('Y') - $date1->format('Y');
    $month_diff = $date2->format('m') - $date1->format('m');
    $day_diff = $date2->format('d') - $date1->format('d');

    // Jika bulan selisihnya negatif, kurangi tahun dan perbaiki bulan
    if ($month_diff < 0) {
        $year_diff--;
        $month_diff += 12;
    }

    // Jika hari di tanggal akhir lebih kecil dari tanggal mulai, kurangi 1 bulan
    if ($day_diff < 0) {
        $month_diff--;
        if ($month_diff < 0) {
            $month_diff += 12;
            $year_diff--;
        }
    }

    $total_months = ($year_diff * 12) + $month_diff;

    // Minimal 0 bulan
    if ($total_months < 0) $total_months = 0;

    return $total_months . ' bulan';
}


}
