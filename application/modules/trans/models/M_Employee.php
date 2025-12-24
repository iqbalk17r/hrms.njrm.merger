<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_Employee extends CI_Model {
    function q_mst_read_where($clause = null){
        return $this->db->query($this->q_mst_txt_where($clause));
    }
    function q_mst_txt_where($clause = null){
        return sprintf(<<<'SQL'

SELECT * FROM (
SELECT 
    COALESCE(TRIM(a.branch), '') AS branch,
    COALESCE(TRIM(a.nik), '') AS nik,
    COALESCE(TRIM(a.nmlengkap), '') AS nmlengkap,
    COALESCE(TRIM(a.callname), '') AS callname,
    COALESCE(TRIM(a.jk), '') AS jk,
    COALESCE(TRIM(a.neglahir), '') AS neglahir,
    COALESCE(TRIM(a.provlahir), '') AS provlahir,
    COALESCE(TRIM(a.kotalahir), '') AS kotalahir,
    a.tgllahir,
    COALESCE(TRIM(a.kd_agama), '') AS kd_agama,
    COALESCE(TRIM(a.stswn), '') AS stswn,
    a.stsfisik,
    COALESCE(TRIM(a.ketfisik), '') AS ketfisik,
    COALESCE(TRIM(a.noktp), '') AS noktp,
    a.ktp_seumurhdp,
    COALESCE(TRIM(a.ktpdikeluarkan), '') AS ktpdikeluarkan,
    a.tgldikeluarkan,
    COALESCE(TRIM(a.status_pernikahan), '') AS status_pernikahan,
    COALESCE(TRIM(a.gol_darah), '') AS gol_darah,
    COALESCE(TRIM(a.negktp), '') AS negktp,
    COALESCE(TRIM(a.provktp), '') AS provktp,
    COALESCE(TRIM(a.kotaktp), '') AS kotaktp,
    COALESCE(TRIM(a.kecktp), '') AS kecktp,
    COALESCE(TRIM(a.kelktp), '') AS kelktp,
    COALESCE(TRIM(a.alamatktp), '') AS alamatktp,
    COALESCE(TRIM(a.negtinggal), '') AS negtinggal,
    COALESCE(TRIM(a.provtinggal), '') AS provtinggal,
    COALESCE(TRIM(a.kotatinggal), '') AS kotatinggal,
    COALESCE(TRIM(a.kectinggal), '') AS kectinggal,
    COALESCE(TRIM(a.keltinggal), '') AS keltinggal,
    COALESCE(TRIM(a.alamattinggal), '') AS alamattinggal,
    COALESCE(TRIM(a.nohp1), '') AS nohp1,
    COALESCE(TRIM(a.nohp2), '') AS nohp2,
    COALESCE(TRIM(a.npwp), '') AS npwp,
    a.tglnpwp,
    COALESCE(TRIM(a.bag_dept), '') AS bag_dept,
    COALESCE(TRIM(a.subbag_dept), '') AS subbag_dept,
    COALESCE(TRIM(a.jabatan), '') AS jabatan,
    COALESCE(TRIM(a.lvl_jabatan), '') AS lvl_jabatan,
    COALESCE(TRIM(a.grade_golongan), '') AS grade_golongan,
    COALESCE(TRIM(a.nik_atasan), '') AS nik_atasan,
    COALESCE(TRIM(a.nik_atasan2), '') AS nik_atasan2,
    COALESCE(TRIM(a.status_ptkp), '') AS status_ptkp,
    a.besaranptkp,
    a.tglmasukkerja,
    a.tglkeluarkerja,
    COALESCE(TRIM(a.masakerja), '') AS masakerja,
    COALESCE(TRIM(a.statuskepegawaian), '') AS statuskepegawaian,
    COALESCE(TRIM(a.kdcabang), '') AS kdcabang,
    COALESCE(TRIM(a.branchaktif), '') AS branchaktif,
    COALESCE(TRIM(a.grouppenggajian), '') AS grouppenggajian,
    a.gajipokok,
    a.gajibpjs,
    COALESCE(TRIM(a.callplan),'') AS callplan,
    COALESCE(TRIM(a.namabank), '') AS namabank,
    COALESCE(TRIM(a.namapemilikrekening), '') AS namapemilikrekening,
    COALESCE(TRIM(a.norek), '') AS norek,
    COALESCE(TRIM(a.tjshift), '') AS tjshift,
    COALESCE(TRIM(a.idabsen), '') AS idabsen,
    COALESCE(TRIM(a.email), '') AS email,
    a.bolehcuti,
    a.sisacuti,
    a.inputdate,
    COALESCE(TRIM(a.inputby), '') AS inputby,
    a.updatedate,
    COALESCE(TRIM(a.updateby), '') AS updateby,
    COALESCE(TRIM(a.image), '') AS image,
    COALESCE(TRIM(a.idmesin), '') AS idmesin,
    COALESCE(TRIM(a.cardnumber), '') AS cardnumber,
    COALESCE(TRIM(a.status), '') AS status,
    a.tgl_ktp,
    COALESCE(TRIM(a.costcenter), '') AS costcenter,
    a.tj_tetap,
    a.gajitetap,
    a.gajinaker,
    COALESCE(TRIM(a.tjlembur), '') AS tjlembur,
    COALESCE(TRIM(a.tjborong), '') AS tjborong,
    --COALESCE(TRIM(a.kdregu), '') AS kdregu,
    COALESCE(TRIM(a.nokk), '') AS nokk,
    COALESCE(TRIM(a.deviceid), '') AS deviceid,
    --COALESCE(TRIM(a.ukuranseragam), '') AS ukuranseragam,
    --COALESCE(TRIM(a.ukuransepatu), '') AS ukuransepatu,
    b.nmdept, 
    c.nmsubdept, 
    d.nmlvljabatan, 
    e.nmjabatan, 
    f.nmlengkap AS nmatasan, 
    g.nmlengkap AS nmatasan2,
    h.nodok,
    h.tgl_selesai,
    CASE
        WHEN COALESCE(TRIM(a.nohp1), '') != ''  AND COALESCE(TRIM(a.nohp2), '') != '' THEN CONCAT(COALESCE(TRIM(a.nohp1), ''),', ',COALESCE(TRIM(a.nohp2), ''))
        WHEN (COALESCE(TRIM(a.nohp1), '') IS NULL OR a.nohp1 = '' ) THEN COALESCE(TRIM(a.nohp2), '')
        WHEN (COALESCE(TRIM(a.nohp2), '') IS NULL OR a.nohp2 = '' ) THEN COALESCE(TRIM(a.nohp1), '')
        ELSE 'Belum diatur'
    END AS mergephone,
    CONCAT(COALESCE(TRIM(a.nik), ''), '.', COALESCE(TRIM(a.nik_atasan), ''), '.', COALESCE(TRIM(a.nik_atasan2), ''), '.') AS search
FROM sc_mst.karyawan a
LEFT OUTER JOIN sc_mst.departmen b ON a.bag_dept = b.kddept
LEFT OUTER JOIN sc_mst.subdepartmen c ON a.subbag_dept = c.kdsubdept AND c.kddept = a.bag_dept
LEFT OUTER JOIN sc_mst.lvljabatan d ON a.lvl_jabatan = d.kdlvl
LEFT OUTER JOIN sc_mst.jabatan e ON a.jabatan = e.kdjabatan AND e.kdsubdept = a.subbag_dept AND e.kddept = a.bag_dept
LEFT OUTER JOIN sc_mst.karyawan f ON a.nik_atasan = f.nik
LEFT OUTER JOIN sc_mst.karyawan g ON a.nik_atasan2 = g.nik
LEFT OUTER JOIN sc_trx.status_kepegawaian h ON a.nik= h.nik and h.status='B'
WHERE a.tglkeluarkerja IS NULL
ORDER BY nmlengkap
) as aa
WHERE TRUE 

SQL
            ).$clause;
    }

    public function signatureSetup()
    {
        $this->load->model(array('master/m_option','trans/M_Employee','master/M_Branch'));
        $defaultArr = array(
            'CONTRACT:SPECIAL:DEPARTMENT' => 'SPS,OPR,OPS,SLM',
            'CONTRACT:SIGNATURE:POSITION:KK' => 'Spv HRD',
            'CONTRACT:SIGNATURE:POSITION:KT' => 'Direktur Utama',
            'CONTRACT:SIGNATURE:USERID:KK' => '3100760',
            'CONTRACT:SIGNATURE:USERID:KT' => '3108001',
            'CONTRACT:SIGNATURE:CITY' => 'Bati-bati',
            'CONTRACT:SIGNATURE:OFFICEADDRESS' => 'Jl. A. Yani km 31 Ds Liang Anggang Kec. Bati – bati Kab. Tanah Laut Kal – sel.',
            'CONTRACT:SIGNATURE:TITLE:KK' => 'Spv HRD',
            'CONTRACT:SIGNATURE:TITLE:KT' => 'Direktur Utama',
            'CONTRACT:SIGNATURE:BRANCH' => 'BBTSNI',
            'DOK1' => 'HRD',
        );
        $parameterArr = array();
        foreach ($defaultArr as $index => $item) {
            array_push($parameterArr,$index);
        }
        $parameterIn = "'".implode("','",$parameterArr)."'";
        $getSetup = $this->m_option->q_master_read_default_array(' AND parameter IN('.$parameterIn.') ',$defaultArr);
        if (isset($getSetup['CONTRACT:SIGNATURE:USERID:KK'])){
            $employeeData = $this->M_Employee->q_mst_read_where(' AND nik = \''.$getSetup['CONTRACT:SIGNATURE:USERID:KK'].'\' ')->row();
            $getSetup['CONTRACT:SIGNATURE:USERNAME:KK'] = $employeeData->text;
            $getSetup['CONTRACT:SIGNATURE:ADDRESS:KK'] = $employeeData->alamatktp;
        }
        if (isset($getSetup['CONTRACT:SIGNATURE:USERID:KT'])){
            $employeeData = $this->M_Employee->q_mst_read_where(' AND nik = \''.$getSetup['CONTRACT:SIGNATURE:USERID:KT'].'\' ')->row();
            $getSetup['CONTRACT:SIGNATURE:USERNAME:KT'] = $employeeData->text;
            $getSetup['CONTRACT:SIGNATURE:ADDRESS:KT'] = $employeeData->alamatktp;
        }
        if (isset($getSetup['CONTRACT:SIGNATURE:BRANCH'])){
            $getSetup['CONTRACT:SIGNATURE:BRANCHNAME'] = $this->M_Branch->q_master_read_where(' AND branch = \''.$getSetup['CONTRACT:SIGNATURE:BRANCH'].'\' ')->row()->branchname;
            $getSetup['CONTRACT:SIGNATURE:BRANCHADDRESS'] = $this->M_Branch->q_master_read_where(' AND branch = \''.$getSetup['CONTRACT:SIGNATURE:BRANCH'].'\' ')->row()->address;
        }
        return $getSetup;

    }

    function q_get_employee_contact($where){
        return $this->db->query("
            SELECT * FROM(
                 select
                     COALESCE(TRIM(a.nik),'') AS employee_id,
                     COALESCE(TRIM(a.nmlengkap),'') AS employee_name,
                     COALESCE(TRIM(a.email),'') AS email,
                     a.nohp1 AS phone1,
                     a.nohp2 AS phone2,
                     a.tgllahir AS born_date,
                      COALESCE(TRIM(a.alamatktp),'') AS home_address,
                     COALESCE(TRIM(f.branchname),'') AS organization,
                     COALESCE(TRIM(d.nmjabatan),'') AS position_name,
                     g.namanegara AS country_name,
                     h.namaprov AS province_name,
                     i.namakotakab AS city_name,
                     a.alamatktp AS address
                 from sc_mst.karyawan a
                          LEFT OUTER JOIN sc_mst.departmen b ON a.bag_dept = b.kddept
                          LEFT OUTER JOIN sc_mst.subdepartmen c ON a.bag_dept = c.kddept AND a.subbag_dept = c.kdsubdept
                          LEFT OUTER JOIN sc_mst.jabatan d ON a.bag_dept = d.kddept AND a.subbag_dept = d.kdsubdept AND a.jabatan = d.kdjabatan
                          LEFT OUTER JOIN sc_mst.branch f ON a.branch = f.branch
                          LEFT OUTER JOIN sc_mst.negara g ON a.negktp = g.kodenegara
                          LEFT OUTER JOIN sc_mst.provinsi h ON a.provktp = h.kodeprov AND a.negktp = h.kodenegara
                          LEFT OUTER JOIN sc_mst.kotakab i ON a.provktp = i.kodeprov AND a.negktp = i.kodenegara AND a.kotaktp = i.kodekotakab
                 WHERE a.statuskepegawaian <> 'KO'
             ) aa WHERE TRUE
        ".$where);
    }
}
