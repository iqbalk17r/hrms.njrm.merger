<?php
class M_ojt extends CI_Model
{
	var $columnspk = array('nodok', 'nodokref', 'nopol', 'nmbarang', 'nmbengkel');
	var $orderspk = array('nodokref' => 'desc', 'nodok' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function q_get_question()
	{
		$query = $this->db->query("SELECT 
				p.kd_aspect AS parent_kd_aspect,
				p.aspect_question,
				p.type,
				p.position AS parent_position,

				c.kd_aspect AS child_kd_aspect,
				c.aspect_name,
				c.aspect_desc,
				c.position AS child_position

			FROM 
				sc_pk.score_aspect_parent_ojt p
			LEFT JOIN 
				sc_pk.score_aspect_ojt c 
				ON c.kd_aspect_parent = p.kd_aspect
			WHERE 
				p.active = TRUE
				AND (c.active = TRUE OR c.kd_aspect IS NULL)
			ORDER BY 
				p.position,           -- Parent position
				c.position;           -- Child position");
					return $query;
	}

	function q_get_question_edit($kddok){
		$query = $this->db->query("SELECT 
			p.kd_aspect AS parent_kd_aspect,
			p.aspect_question,
			p.type,
			p.position AS parent_position,

			c.kd_aspect AS child_kd_aspect,
			c.aspect_name,
			c.aspect_desc,
			c.position AS child_position,

			d.score

		FROM 
			sc_pk.score_aspect_parent_ojt p
		LEFT JOIN 
			sc_pk.score_aspect_ojt c 
			ON c.kd_aspect_parent = p.kd_aspect
		LEFT JOIN 
			sc_pk.detail_ojt d 
			ON d.kd_aspect = p.kd_aspect
		WHERE 
			p.active = TRUE
			AND (c.active = TRUE OR c.kd_aspect IS NULL)
			and d.kddok = '$kddok'
		ORDER BY 
			p.position,           -- Parent position
			c.position;  		  -- Child position");
				return $query;
	}

	function q_info_identity($kddok)
	{
		return $this->db->query("SELECT 
			m.nik,
			s.aspect_question,
			c.score,
			c.desc_aspect	
		FROM 
			sc_pk.master_pk m
		JOIN 
			sc_pk.detail_pk c ON m.kddok = c.kddok
		JOIN
			sc_pk.score_aspect_pk s ON c.kd_aspect = s.kd_aspect 

		where m.kddok = '$kddok';");
	}

	function q_get_detail_penilaian_cetak($kdcontract,$kddok)
	{
		return $this->db->query("SELECT 
			ROW_NUMBER() OVER (ORDER BY c.kd_aspect) AS no,
			m.kddok,
			m.kdcontract,
			m.nik,
			m.nik_panelist,
			s.aspect_question,
			c.score
	
		FROM 
			sc_pk.master_ojt m
		JOIN 
			sc_pk.detail_ojt c ON m.kddok = c.kddok
		JOIN
			sc_pk.score_aspect_parent_ojt s ON c.kd_aspect = s.kd_aspect 

		where trim(m.kdcontract) = '$kdcontract' and trim(m.kddok) = '$kddok';
		");
	}

	function q_get_detail_lain_cetak($kdcontract,$kddok)
	{
		return $this->db->query("select 
				kddok, 
				kdcontract, 
				notes,
				nik_panelist,
				trim(status) as status,
				approvedate,
				inputdate,	
				trim(inputby) as inputby,				
				trim(approveby) as approveby
				from sc_pk.master_ojt
				where kdcontract = '$kdcontract' and kddok = '$kddok'
		");
	}


	function q_get_detail_lain_cetakrekap($kddok)
	{
		return $this->db->query("select * from sc_pk.rekap_ojt where kddok = '$kddok'");
	}

	function get_list_karyawan($kdcontract)
	{
		return $this->db->query("select a.nik, a.nmlengkap, b.nmlengkap as nmlengkapatasan1, c.nmlengkap as nmlengkapatasan2 
									from sc_mst.karyawan a
									JOIN sc_mst.karyawan b ON a.nik_atasan = b.nik 
									JOIN sc_mst.karyawan c ON a.nik_atasan2 = c.nik
									where coalesce(upper(a.statuskepegawaian),'')!='KO' 
									order by a.nmlengkap asc
		");
	}

	function get_list_ojtappr(){
		return $this->db->query("select a.*,b.nmlengkap as namakaryawan, b.nik_atasan2, c.nmlengkap as namaatasan1, d.nmlengkap as namaatasan2, e.nmlengkap as nminput, f.tgl_mulai, f.tgl_selesai,  g.nmkepegawaian, h.description as deskappr, f.status as statuskep
									from sc_pk.master_ojt a
									join sc_mst.karyawan b on a.nik = b.nik
									join sc_mst.karyawan c on b.nik_atasan = c.nik
									join sc_mst.karyawan d on b.nik_atasan2 = d.nik
									join sc_mst.karyawan e on a.inputby = e.nik
									join sc_trx.status_kepegawaian f on a.kdcontract = f.nodok
									join sc_mst.status_kepegawaian g on f.kdkepegawaian=g.kdkepegawaian
									join sc_pk.master_appr h on a.status = h.kdappr
								        where trim(a.status) != 'C' and trim(f.status) = 'B'
									order by a.status asc, a.inputdate desc
		");
	}

	function get_list_ojtpen($nik){
		return $this->db->query("SELECT 
						k.nodok AS nodok_ojt,
						k.nik AS nik_ojt,
						k.nmlengkap AS nama_ojt,
						k.nmkepegawaian,
						m.status as statusnew,
						m.kddok,
						ap.description as deskappr,
						s.*
						FROM (
						SELECT 
						a.agenda_id, 
						c.nik as nik_panelist,  
						c.status,
						b.end_date,
						CASE 
						WHEN a.ojt_status = true THEN 'karyawan'
						ELSE 'panelist' 
						END AS peserta
						FROM sc_trx.agenda_attendance a
						JOIN sc_trx.agenda b ON a.agenda_id = b.agenda_id and b.status != 'C'
						JOIN sc_trx.status_kepegawaian c ON a.nik = c.nik AND c.status = 'B' 
						WHERE b.agenda_type = 'OJT' and a.confirm_status = true
						) s
						LEFT JOIN (
						SELECT 
						a.agenda_id, 
						a.nik,
						c.nodok,
						b.nmlengkap,
						d.nmkepegawaian
						FROM sc_trx.agenda_attendance a
						JOIN sc_trx.status_kepegawaian c ON a.nik = c.nik AND c.status = 'B'
						JOIN sc_mst.karyawan b ON a.nik = b.nik 
						left outer join sc_mst.status_kepegawaian d on d.kdkepegawaian=c.kdkepegawaian
						WHERE a.ojt_status = true
						) k ON s.agenda_id = k.agenda_id
						LEFT JOIN sc_pk.master_ojt m on m.kdcontract = k.nodok and s.nik_panelist = m.nik_panelist
						left outer join sc_pk.master_appr ap on m.status = ap.kdappr
						WHERE s.peserta = 'panelist' and s.nik_panelist = '$nik' and current_date <= TO_DATE(s.end_date, 'DD-MM-YYYY') + INTERVAL '4 days'
						order by agenda_id asc

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

	function get_appr_list(){
		return $this->db->query("select nik, jobposition from sc_pk.master_appr_list")->result_array();
	}

	function get_appr_list_nm(){
		return $this->db->query("select trim(a.nik) as nik, trim(b.nmlengkap) as nama, trim(a.jobposition)as job from sc_pk.master_appr_list a 
									join sc_mst.karyawan b on a.nik = b.nik where a.jobposition = 'HRGA'");
	}

	function get_name($nik){
		return $this->db->query("select nmlengkap from sc_mst.karyawan where nik='$nik'")->row()->nmlengkap;
	}

	function check_pkstat($kddok){
			$row = $this->db->query("select status from sc_pk.master_pk where kddok='$kddok'")->row();
			$check = $row && isset($row->status) && trim($row->status) == 'C' ? true : $row->status;
			return $check;
	}

	function check_rekap($kddok){
		$row = $this->db->query("select count(*) as jml from sc_pk.rekap_ojt where kddok='$kddok'")->row();
		return $row && isset($row->jml) && $row->jml > 0 ? true : false;
	}

	function get_kddok($nik){
		return $this->db->query("select trim(nodok) as nodok from sc_trx.status_kepegawaian where nik = '$nik' and ojt = 'T'")->row()->nodok;
	}

	function list_result($nik){
		return $this->db->query("select a.*,
				b.nmlengkap as nmpenilai
				from sc_pk.master_ojt a
				join sc_mst.karyawan b on b.nik = a.nik_panelist
				where a.nik = '$nik'");
	}

	function get_notes_panelist($nik){
		return $this->db->query("select trim(a.notes) as notes, trim(b.nmlengkap) as nmpanelist from sc_pk.master_ojt a 
					join sc_mst.karyawan b on a.nik_panelist = b.nik
					where a.nik = '$nik'
				");
	}
	

	}
 