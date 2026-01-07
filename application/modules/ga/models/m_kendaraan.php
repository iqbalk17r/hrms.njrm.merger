<?php
class M_kendaraan extends CI_Model{

    function q_versidb($kodemenu){
        return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
    }

    function q_ceksckendaraan($kdgroup){
        return $this->db->query("select * from sc_mst.mgroup where kdgroup='$kdgroup'");
    }

    function q_sckendaraan(){
        return $this->db->query("select * from sc_mst.mgroup where left(kdgroup,3)='KDN' order by nmgroup");
    }

    function q_scsubkendaraan(){
        return $this->db->query("select * from sc_mst.msubgroup where left(kdgroup,3)='KDN' order by nmsubgroup");
    }

    function q_mstkendaraan(){
        return $this->db->query("SELECT a.*, b.locaname
            FROM sc_mst.mbarang a
            LEFT OUTER JOIN sc_mst.mgudang b ON a.kdgudang = b.loccode
            WHERE LEFT(a.kdgroup, 3) = 'KDN' 
            AND (a.expstnkb - INTERVAL '1 MONTH' <= NOW() OR a.exppkbstnkb - INTERVAL '1 MONTH' <= NOW()) AND a.hold_item = 'NO'");
    }
	
	function q_masterkendaraan(){
        return $this->db->query("SELECT a.*, b.locaname
            FROM sc_mst.mbarang a
            LEFT OUTER JOIN sc_mst.mgudang b ON a.kdgudang = b.loccode
            WHERE LEFT(a.kdgroup, 3) = 'KDN' 
			");
    }
	
	function q_kirkendaraan() {
        return $this->db->query("
            select a.*,b.nmbarang,b.nopol,b.jenisid,b.modelid,b.tahunpembuatan,b.nodok,b.hold_item,c.locaname from sc_his.kir_mst a
			left outer join sc_mst.mbarang b on b.nodok=a.stockcode
			LEFT OUTER JOIN sc_mst.mgudang c ON b.kdgudang = c.loccode
            where to_char(a.expkir,'YYYYMM') between to_char(now() - interval '15 days','YYYYMMDD') and  to_char(now() + interval '15 days','YYYYMMDD') AND b.hold_item = 'NO'
            ORDER BY nmbarang
        ");
    }
	
    function q_cekkendaraan($kdrangka){
        return $this->db->query("select * from sc_mst.mbarang where left(kdgroup,3)='KDN' and nodok='$kdrangka' order by nmbarang");
    }

    function q_mstkendaraanwil($param1){
        return $this->db->query("select a.*,b.locaname from sc_mst.mbarang a
                                    left outer join sc_mst.mgudang b on a.kdgudang=b.loccode
                                    where left(a.kdgroup,3)='KDN' $param1  order by nmbarang");
    }

    function q_mstkantor(){
        return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang asc");
    }

    function q_gudangwilayah(){
        return $this->db->query("select * from sc_mst.mgudang order by locaname");
    }

    function q_gudangwilayah_param($param){
        return $this->db->query("select * from sc_mst.mgudang where loccode is not null $param order by locaname");
    }

    function q_masuransi($param){
        return $this->db->query("select * from (
									select a.*,coalesce(b.rowdtl,0) as rowdtl  from sc_mst.masuransi a
									left outer join (select count(*) as rowdtl, kdasuransi from sc_mst.msubasuransi where kdasuransi<>'' group by kdasuransi) b
									on a.kdasuransi=b.kdasuransi) x where kdasuransi is not null $param
									order by nmasuransi");
    }

    function q_msubasuransi($param){
        return $this->db->query("select * from 
									(select a.*,coalesce(b.rowdtl,0) as rowdtl from sc_mst.msubasuransi a
									left outer join (select count(*) as rowdtl, kdsubasuransi from sc_mst.mbarang where kdsubasuransi<>'' group by kdsubasuransi) b
									on a.kdsubasuransi=b.kdsubasuransi) x where kdsubasuransi is not null $param
									order by kdsubasuransi desc");
    }

    function q_his_stnkb(){
        return $this->db->query("	select nodok,tgldok,dokref,kdrangka,kdmesin,nopol,kdgroup,nmkendaraan,nmpemilik,addpemilik,hppemilik,typeid,jenisid,modelid,tahunpembuatan,silinder,warna,bahanbakar,
									warnatnkb,tahunreg,nobpkb,kdlokasi,expstnkb,exppkbstnkb,nopkb,nominalpkb,noskum,nokohir,old_nopol,old_kdgroup,old_nmkendaraan,old_nmpemilik,old_addpemilik,old_hppemilik,
									old_typeid,old_jenisid,old_modelid,old_tahunpembuatan,old_silinder,old_warna,old_bahanbakar,old_warnatnkb,old_tahunreg,old_nobpkb,old_kdlokasi,old_expstnkb,old_exppkbstnkb,
									old_nopkb,old_nominalpkb,old_noskum,old_nokohir,keterangan,status,inputdate,inputby,updatedate,updateby,jenispengurusan
									from ((select 1 as urut,nodok,tgldok,dokref,kdrangka,kdmesin,nopol,kdgroup,nmkendaraan,nmpemilik,addpemilik,hppemilik,typeid,jenisid,modelid,tahunpembuatan,silinder,warna,bahanbakar,
										warnatnkb,tahunreg,nobpkb,kdlokasi,expstnkb,exppkbstnkb,nopkb,nominalpkb,noskum,nokohir,old_nopol,old_kdgroup,old_nmkendaraan,old_nmpemilik,old_addpemilik,old_hppemilik,
										old_typeid,old_jenisid,old_modelid,old_tahunpembuatan,old_silinder,old_warna,old_bahanbakar,old_warnatnkb,old_tahunreg,old_nobpkb,old_kdlokasi,old_expstnkb,old_exppkbstnkb,
										old_nopkb,old_nominalpkb,old_noskum,old_nokohir,keterangan,status,inputdate,inputby,updatedate,updateby,jenispengurusan from sc_tmp.stnkb order by nodok desc) 
										union all
										(select 2 as urut,nodok,tgldok,dokref,kdrangka,kdmesin,nopol,kdgroup,nmkendaraan,nmpemilik,addpemilik,hppemilik,typeid,jenisid,modelid,tahunpembuatan,silinder,warna,bahanbakar,
										warnatnkb,tahunreg,nobpkb,kdlokasi,expstnkb,exppkbstnkb,nopkb,nominalpkb,noskum,nokohir,old_nopol,old_kdgroup,old_nmkendaraan,old_nmpemilik,old_addpemilik,old_hppemilik,
										old_typeid,old_jenisid,old_modelid,old_tahunpembuatan,old_silinder,old_warna,old_bahanbakar,old_warnatnkb,old_tahunreg,old_nobpkb,old_kdlokasi,old_expstnkb,old_exppkbstnkb,
										old_nopkb,old_nominalpkb,old_noskum,old_nokohir,keterangan,status,inputdate,inputby,updatedate,updateby,jenispengurusan from sc_his.stnkb order by nodok desc )) as x");
    }

    function q_his_stnkb_param($param){
        return $this->db->query("select nodok,tgldok,dokref,kdrangka,kdmesin,nopol,kdgroup,nmkendaraan,nmpemilik,addpemilik,hppemilik,typeid,jenisid,modelid,tahunpembuatan,
									silinder,warna,bahanbakar,warnatnkb,tahunreg,nobpkb,kdlokasi,expstnkb,exppkbstnkb,nopkb,nominalpkb,noskum,nokohir,
									old_nopol,old_kdgroup,old_nmkendaraan,old_nmpemilik,old_addpemilik,old_hppemilik,old_typeid,old_jenisid,old_modelid,old_tahunpembuatan,old_silinder,old_warna,
									old_bahanbakar,old_warnatnkb,old_tahunreg,old_nobpkb,old_kdlokasi,old_expstnkb,old_exppkbstnkb,old_nopkb,old_nominalpkb,old_noskum,old_nokohir,
									keterangan,status,inputdate,inputby,updatedate,updateby,jenispengurusan,nodoktmp,b.uraian as nmstatus,case when jenispengurusan='1T' then 'PAJAK TAHUNAN' when jenispengurusan='5T' then 'PAJAK & PEMBAHARUAN STNK' end as nmjenispengurusan from sc_his.stnkb a
									left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='STNKB'
									where nodok is not null $param");
    }

    function q_tmp_stnkb_param($param){
        return $this->db->query("select nodok,tgldok,dokref,kdrangka,kdmesin,nopol,kdgroup,nmkendaraan,nmpemilik,addpemilik,hppemilik,typeid,jenisid,modelid,tahunpembuatan,
									silinder,warna,bahanbakar,warnatnkb,tahunreg,nobpkb,kdlokasi,expstnkb,exppkbstnkb,nopkb,nominalpkb,noskum,nokohir,
									old_nopol,old_kdgroup,old_nmkendaraan,old_nmpemilik,old_addpemilik,old_hppemilik,old_typeid,old_jenisid,old_modelid,old_tahunpembuatan,old_silinder,old_warna,
									old_bahanbakar,old_warnatnkb,old_tahunreg,old_nobpkb,old_kdlokasi,old_expstnkb,old_exppkbstnkb,old_nopkb,old_nominalpkb,old_noskum,old_nokohir,
									keterangan,status,inputdate,inputby,updatedate,updateby,jenispengurusan,nodoktmp,b.uraian as nmstatus,case when jenispengurusan='1T' then 'PAJAK TAHUNAN' when jenispengurusan='5T' then 'PAJAK & PEMBAHARUAN STNK' end as nmjenispengurusan from sc_tmp.stnkb a
									left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='STNKB'
									where nodok is not null $param");
    }


    function q_inquirystnk($kdrangka,$kdmesin){
        return $this->db->query("select nodok,tgldok,dokref,kdrangka,kdmesin,nopol,kdgroup,nmkendaraan,nmpemilik,addpemilik,hppemilik,typeid,jenisid,modelid,tahunpembuatan,silinder,warna,bahanbakar,
									warnatnkb,tahunreg,nobpkb,kdlokasi,expstnkb,exppkbstnkb,nopkb,nominalpkb,noskum,nokohir,old_nopol,old_kdgroup,old_nmkendaraan,old_nmpemilik,old_addpemilik,old_hppemilik,
									old_typeid,old_jenisid,old_modelid,old_tahunpembuatan,old_silinder,old_warna,old_bahanbakar,old_warnatnkb,old_tahunreg,old_nobpkb,old_kdlokasi,old_expstnkb,old_exppkbstnkb,
									old_nopkb,old_nominalpkb,old_noskum,old_nokohir,keterangan,status,inputdate,inputby,updatedate,updateby,jenispengurusan from sc_his.stnkb 
									where status='P' and kdmesin='$kdmesin' and kdrangka='$kdrangka'
									order by tgldok desc ");
    }

    function q_trxgbengkel(){
        return $this->db->query("select * from sc_mst.trxtype where jenistrx='GBENGKEL' order by uraian asc");
    }



    function q_mbengkel($param){
        return $this->db->query("select * from (
									select a.*,coalesce(b.numdtl,0) as numdtl from sc_mst.mbengkel a left outer join 
									(select count(*) as numdtl,kdbengkel from sc_mst.msubbengkel 
									group by kdbengkel) b on a.kdbengkel=b.kdbengkel) as x
									where kdbengkel is not null $param order by kdbengkel desc");
    }

    function q_msubbengkel($param){
        return $this->db->query("select * from sc_mst.msubbengkel  where kdsubbengkel is not null  $param order by kdbengkel desc");
    }

    function insert_tmp_stnkb($nama,$jenispkb,$param_insert){
        return $this->db->query("insert into sc_tmp.stnkb (nodok,tgldok,dokref,kdrangka,kdmesin,nopol,kdgroup,nmkendaraan,nmpemilik,addpemilik,hppemilik,typeid,jenisid,modelid,tahunpembuatan,
									silinder,warna,bahanbakar,warnatnkb,tahunreg,nobpkb,kdlokasi,expstnkb,exppkbstnkb,nopkb,nominalpkb,noskum,nokohir,
									old_nopol,old_kdgroup,old_nmkendaraan,old_nmpemilik,old_addpemilik,old_hppemilik,old_typeid,old_jenisid,old_modelid,old_tahunpembuatan,old_silinder,old_warna,
									old_bahanbakar,old_warnatnkb,old_tahunreg,old_nobpkb,old_kdlokasi,old_expstnkb,old_exppkbstnkb,old_nopkb,old_nominalpkb,old_noskum,old_nokohir,
									keterangan,status,inputdate,inputby,updatedate,updateby,jenispengurusan,nodoktmp)
									select 
									'$nama',to_char(now(),'yyyy-mm-dd')::date,'',kdrangka,kdmesin,nopol,kdgroup,nmbarang,nmpemilik,addpemilik,hppemilik,typeid,jenisid,modelid,tahunpembuatan,silinder,warna,
									bahanbakar,warnatnkb,tahunreg,nobpkb,kdlokasi,expstnkb,exppkbstnkb,nopkb,nominalpkb,'' as noskum,'', 
									nopol,kdgroup,nmbarang,nmpemilik,addpemilik,hppemilik,typeid,jenisid,modelid,tahunpembuatan,silinder,warna,
									bahanbakar,warnatnkb,tahunreg,nobpkb,kdlokasi,expstnkb,exppkbstnkb,nopkb,nominalpkb,'' as noskum,'' as nokohir,
									'' as keterangan,'I' as status,to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,'$nama',null,null,'$jenispkb','' from sc_mst.mbarang 
									where kdgroup='KDN' $param_insert");
    }

    function q_trxerror($paramtrxerror){
        return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
    }

    function q_deltrxerror($paramtrxerror){
        return $this->db->query("delete from sc_mst.trxerror where userid is not null $paramtrxerror");
    }

    function q_master_branch(){
        return $this->db->query("select 
								coalesce(branch    ,'')::text as branch      ,
								coalesce(branchname,'')::text as branchname  ,
								coalesce(address   ,'')::text as address     ,
								coalesce(phone1    ,'')::text as phone1      ,
								coalesce(phone2    ,'')::text as phone2      ,
								coalesce(fax       ,'')::text as fax from sc_mst.branch where branch='NJRBJM'");
    }

    function q_json_stnkb_param($param){
        return $this->db->query("select trim(coalesce(nodok       ::text),'') as nodok             ,
								trim(coalesce(tgldok             ::text),'') as tgldok            ,
								trim(coalesce(dokref             ::text),'') as dokref            ,
								trim(coalesce(kdrangka           ::text),'') as kdrangka          ,
								trim(coalesce(kdmesin            ::text),'') as kdmesin           ,
								trim(coalesce(nopol              ::text),'') as nopol             ,
								trim(coalesce(kdgroup            ::text),'') as kdgroup           ,
								trim(coalesce(nmkendaraan        ::text),'') as nmkendaraan       ,
								trim(coalesce(nmpemilik          ::text),'') as nmpemilik         ,
								trim(coalesce(addpemilik         ::text),'') as addpemilik        ,
								trim(coalesce(hppemilik          ::text),'') as hppemilik         ,
								trim(coalesce(typeid             ::text),'') as typeid            ,
								trim(coalesce(jenisid            ::text),'') as jenisid           ,
								trim(coalesce(modelid            ::text),'') as modelid           ,
								trim(coalesce(tahunpembuatan     ::text),'') as tahunpembuatan    ,
								trim(coalesce(silinder           ::text),'') as silinder          ,
								trim(coalesce(warna              ::text),'') as warna             ,
								trim(coalesce(bahanbakar         ::text),'') as bahanbakar        ,
								trim(coalesce(warnatnkb          ::text),'') as warnatnkb         ,
								trim(coalesce(tahunreg           ::text),'') as tahunreg          ,
								trim(coalesce(nobpkb             ::text),'') as nobpkb            ,
								trim(coalesce(kdlokasi           ::text),'') as kdlokasi          ,
								trim(coalesce(expstnkb           ::text),'') as expstnkb          ,
								trim(coalesce(exppkbstnkb        ::text),'') as exppkbstnkb       ,
								trim(coalesce(nopkb              ::text),'') as nopkb             ,
								trim(coalesce(nominalpkb         ::text),'') as nominalpkb        ,
								trim(coalesce(noskum             ::text),'') as noskum            ,
								trim(coalesce(nokohir            ::text),'') as nokohir           ,
								trim(coalesce(old_nopol          ::text),'') as old_nopol         ,
								trim(coalesce(old_kdgroup        ::text),'') as old_kdgroup       ,
								trim(coalesce(old_nmkendaraan    ::text),'') as old_nmkendaraan   ,
								trim(coalesce(old_nmpemilik      ::text),'') as old_nmpemilik     ,
								trim(coalesce(old_addpemilik     ::text),'') as old_addpemilik    ,
								trim(coalesce(old_hppemilik      ::text),'') as old_hppemilik     ,
								trim(coalesce(old_typeid         ::text),'') as old_typeid        ,
								trim(coalesce(old_jenisid        ::text),'') as old_jenisid       ,
								trim(coalesce(old_modelid        ::text),'') as old_modelid       ,
								trim(coalesce(old_tahunpembuatan ::text),'') as old_tahunpembuatan,
								trim(coalesce(old_silinder       ::text),'') as old_silinder      ,
								trim(coalesce(old_warna          ::text),'') as old_warna         ,
								trim(coalesce(old_bahanbakar     ::text),'') as old_bahanbakar    ,
								trim(coalesce(old_warnatnkb      ::text),'') as old_warnatnkb     ,
								trim(coalesce(old_tahunreg       ::text),'') as old_tahunreg      ,
								trim(coalesce(old_nobpkb         ::text),'') as old_nobpkb        ,
								trim(coalesce(old_kdlokasi       ::text),'') as old_kdlokasi      ,
								trim(coalesce(old_expstnkb       ::text),'') as old_expstnkb      ,
								trim(coalesce(old_exppkbstnkb    ::text),'') as old_exppkbstnkb   ,
								trim(coalesce(old_nopkb          ::text),'') as old_nopkb         ,
								trim(coalesce(old_nominalpkb     ::text),'') as old_nominalpkb    ,
								trim(coalesce(old_noskum         ::text),'') as old_noskum        ,
								trim(coalesce(old_nokohir        ::text),'') as old_nokohir       ,
								trim(coalesce(keterangan         ::text),'') as keterangan        ,
								trim(coalesce(status             ::text),'') as status            ,
								trim(coalesce(inputdate          ::text),'') as inputdate         ,
								trim(coalesce(inputby            ::text),'') as inputby           ,
								trim(coalesce(updatedate         ::text),'') as updatedate        ,
								trim(coalesce(updateby           ::text),'') as updateby          ,
								trim(coalesce(jenispengurusan    ::text),'') as jenispengurusan   ,
								trim(coalesce(nodoktmp           ::text),'') as nodoktmp          ,
								trim(coalesce(nmstatus           ::text),'') as nmstatus          ,
								trim(coalesce(nmjenispengurusan  ::text),'') as nmjenispengurusan ,
								trim(coalesce(docdate_s          ::text),'') as docdate_s         ,
								trim(coalesce(expstnkb_s         ::text),'') as expstnkb_s        ,
								trim(coalesce(exppkbstnkb_s      ::text),'') as exppkbstnkb_s from 
								(select nodok,tgldok,dokref,kdrangka,kdmesin,nopol,kdgroup,nmkendaraan,nmpemilik,addpemilik,hppemilik,typeid,jenisid,modelid,tahunpembuatan,
									silinder,warna,bahanbakar,warnatnkb,tahunreg,nobpkb,kdlokasi,expstnkb,exppkbstnkb,nopkb,nominalpkb,noskum,nokohir,
									old_nopol,old_kdgroup,old_nmkendaraan,old_nmpemilik,old_addpemilik,old_hppemilik,old_typeid,old_jenisid,old_modelid,old_tahunpembuatan,old_silinder,old_warna,
									old_bahanbakar,old_warnatnkb,old_tahunreg,old_nobpkb,old_kdlokasi,old_expstnkb,old_exppkbstnkb,old_nopkb,old_nominalpkb,old_noskum,old_nokohir,
									keterangan,status,inputdate,inputby,updatedate,updateby,jenispengurusan,nodoktmp,b.uraian as nmstatus,case when jenispengurusan='1T' then 'PAJAK TAHUNAN' when jenispengurusan='5T' then 'PAJAK & PEMBAHARUAN STNK' end as nmjenispengurusan,
									to_char(tgldok,'dd-mm-yyyy') as docdate_s, to_char(expstnkb,'dd-mm-yyyy') as expstnkb_s, to_char(exppkbstnkb,'dd-mm-yyyy') as exppkbstnkb_s
									from sc_his.stnkb a
									left outer join sc_mst.trxtype b on a.status=b.kdtrx and b.jenistrx='STNKB') as x
									where nodok is not null $param");
    }

    function q_excel_stnkb($param){
        return $this->db->query("select * from 
									(SELECT to_char(a.tgldok,'DD-MM-YYYY') as tanggal,a.nmkendaraan,a.nopol,a.tahunpembuatan,
									case when a.jenispengurusan='5T' then to_char(a.expstnkb,'DD-MM-YYYY')
									else '' end AS MASA5,
									case when a.jenispengurusan='1T' then to_char(a.exppkbstnkb,'DD-MM-YYYY') 
									else '' end AS  masa1,a.nominalpkb,b.kdgudang as kdcabang
									FROM 
									SC_HIS.STNKB a left outer join sc_mst.mbarang b on a.kdrangka=b.nodok) as x
									WHERE tanggal IS NOT NULL $param order by tanggal asc");
    }
	
	function q_excel_mstkendaraan(){
        return $this->db->query("SELECT A.NOPOL,NMPEMILIK,BRAND,TAHUNPEMBUATAN,KDRANGKA,KDMESIN,TO_CHAR(EXPSTNKB,'DD-MM-YYYY') AS MASABERLAKUSTNK,TO_CHAR(EXPPKBSTNKB,'DD-MM-YYYY') AS MASABERLAKUPAJAK,LOCANAME,NMLENGKAP
								from sc_mst.mbarang a
								left outer join sc_mst.mgudang b on a.kdgudang=b.loccode
								LEFT OUTER JOIN SC_MST.KARYAWAN C ON A.USERPAKAI=C.NIK
								where left(a.kdgroup,3)='KDN'  order by nmbarang");
	}
	
}	