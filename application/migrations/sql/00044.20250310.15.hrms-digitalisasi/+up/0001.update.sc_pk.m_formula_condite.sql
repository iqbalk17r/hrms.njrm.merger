-- =======================================update sc_pk.m_formula_condite=======================================
BEGIN TRANSACTION;

UPDATE sc_pk.m_formula_condite SET value1 = 1 WHERE objectcode = 'IP';
UPDATE sc_pk.m_formula_condite SET value1 = 0.25 WHERE objectcode = 'SD';
UPDATE sc_pk.m_formula_condite SET value1 = 4 WHERE objectcode = 'AL';
UPDATE sc_pk.m_formula_condite SET value1 = 0.75 WHERE objectcode = 'TL';
UPDATE sc_pk.m_formula_condite SET value1 = 0.5 WHERE objectcode = 'IPA';
UPDATE sc_pk.m_formula_condite SET value1 = 0 WHERE objectcode = 'CT';
UPDATE sc_pk.m_formula_condite SET value1 = 0.75 WHERE objectcode = 'ITL';
UPDATE sc_pk.m_formula_condite SET value1 = 0 WHERE objectcode = 'SP1';
UPDATE sc_pk.m_formula_condite SET value1 = 0 WHERE objectcode = 'SP2';
UPDATE sc_pk.m_formula_condite SET value1 = 0 WHERE objectcode = 'SP3';
UPDATE sc_pk.m_formula_condite SET value1 = 0 WHERE objectcode = 'IK';

COMMIT;
-- =====================================UPDATE sc_pk.m_bobot=======================================
BEGIN TRANSACTION;

UPDATE sc_pk.m_bobot SET value1 =  null WHERE kdvalue = 'SK';
UPDATE sc_pk.m_bobot SET value1 =  8.1 WHERE kdvalue = 'K';
UPDATE sc_pk.m_bobot SET value2 =  999 WHERE kdvalue = 'K';
UPDATE sc_pk.m_bobot SET value1 = 5.1 WHERE kdvalue = 'C';
UPDATE sc_pk.m_bobot SET value2 = 8 WHERE kdvalue = 'C';
UPDATE sc_pk.m_bobot SET value1 = 0.1 WHERE kdvalue = 'B';
UPDATE sc_pk.m_bobot SET value2 = 5 WHERE kdvalue = 'B';
UPDATE sc_pk.m_bobot SET value1 = 0 WHERE kdvalue = 'SB';
UPDATE sc_pk.m_bobot SET value2 = 0 WHERE kdvalue = 'SB';
UPDATE sc_pk.m_bobot SET value1 = 0 WHERE kdvalue = 'KUOTA';


COMMIT;

	BEGIN TRANSACTION;

	UPDATE sc_pk.m_bobot SET value3 =  null WHERE kdvalue = 'SK';
	UPDATE sc_pk.m_bobot SET value4 =  8.1 WHERE kdvalue = 'K';
	UPDATE sc_pk.m_bobot SET value3 =  999 WHERE kdvalue = 'K';
	UPDATE sc_pk.m_bobot SET value4 = 5.1 WHERE kdvalue = 'C';
	UPDATE sc_pk.m_bobot SET value3 = 8 WHERE kdvalue = 'C';
	UPDATE sc_pk.m_bobot SET value4 = 0.1 WHERE kdvalue = 'B';
	UPDATE sc_pk.m_bobot SET value3 = 5 WHERE kdvalue = 'B';
	UPDATE sc_pk.m_bobot SET value3 = 0 WHERE kdvalue = 'SB';
	UPDATE sc_pk.m_bobot SET value4 = 0 WHERE kdvalue = 'SB';


	COMMIT;

-- =====================================UPDATE trigger sc_pk.kondite_tmp_mst()=======================================
-- Function: sc_pk.tr_kondite_tmp_mst()

-- DROP FUNCTION sc_pk.tr_kondite_tmp_mst();

CREATE OR REPLACE FUNCTION sc_pk.tr_kondite_tmp_mst()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
    --created by Fiky ::18/07/2017
    --modified by DK ::12/12/2023
    --modified by RKM ::04/04/2024 ->> modified for autogenerate conditee
declare
    vr_nomor char(20);
    vr_cekprefix char(4);
    vr_nowprefix char(4);
    vr_periode char(6);
begin

    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        if (new.status='F' and old.status='I') then
            vr_nomor:='KDT/'||new.periode||'/'||new.nik;

            insert into sc_pk.kondite_trx_mst
            (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,ttlvalueip,ttlvaluesd,ttlvalueal,ttlvaluetl,ttlvalueitl,ttlvalueipa,ttlvaluesp1,ttlvaluesp2,ttlvaluesp3,ttlvaluect,
             ttlvalueik,c1_ttlvalueip,c1_ttlvaluesd,c1_ttlvalueal,c1_ttlvaluetl,c1_ttlvalueitl,c1_ttlvalueipa,c1_ttlvaluesp1,c1_ttlvaluesp2,c1_ttlvaluesp3,c1_ttlvaluect,c1_ttlvalueik,c2_ttlvalueip,
             c2_ttlvaluesd,c2_ttlvalueal,c2_ttlvaluetl,c2_ttlvalueitl,c2_ttlvalueipa,c2_ttlvaluesp1,c2_ttlvaluesp2,c2_ttlvaluesp3,c2_ttlvaluect,c2_ttlvalueik,f_score_k,f_ktg_fs,description,inputdate,
             inputby,updatedate,updateby,nodoktmp,status,f_desc_fs,f_kdvalue_fs)
                (select branch,idbu,vr_nomor,periode,nik,nikatasan1,nikatasan2,ttlvalueip,ttlvaluesd,ttlvalueal,ttlvaluetl,ttlvalueitl,ttlvalueipa,ttlvaluesp1,ttlvaluesp2,ttlvaluesp3,ttlvaluect,
                        ttlvalueik,c1_ttlvalueip,c1_ttlvaluesd,c1_ttlvalueal,c1_ttlvaluetl,c1_ttlvalueitl,c1_ttlvalueipa,c1_ttlvaluesp1,c1_ttlvaluesp2,c1_ttlvaluesp3,c1_ttlvaluect,c1_ttlvalueik,c2_ttlvalueip,
                        c2_ttlvaluesd,c2_ttlvalueal,c2_ttlvaluetl,c2_ttlvalueitl,c2_ttlvalueipa,c2_ttlvaluesp1,c2_ttlvaluesp2,c2_ttlvaluesp3,c2_ttlvaluect,c2_ttlvalueik,f_score_k,f_ktg_fs,description,inputdate,
                        inputby,updatedate,updateby,nodoktmp,'A' as status,f_desc_fs,f_kdvalue_fs
                 from sc_pk.kondite_tmp_mst where nodok=new.nodok and nik=new.nik AND periode=NEW.periode);
            delete from sc_mst.trxerror where userid=new.nodok;
            insert into sc_mst.trxerror
            (userid,errorcode,nomorakhir1,modul) values (new.nodok,0,vr_nomor,'PKPA');

            delete from sc_pk.kondite_tmp_mst where nodok=new.nodok and nik=new.nik AND periode=NEW.periode;

        elseif (new.status='F' and old.status='E') then
            vr_nomor:=new.nodoktmp;
            vr_periode:=new.periode;
            delete from sc_pk.kondite_trx_mst where nodok=vr_nomor and nik=new.nik and periode = vr_periode;

            insert into sc_pk.kondite_trx_mst
            (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,ttlvalueip,ttlvaluesd,ttlvalueal,ttlvaluetl,ttlvalueitl,ttlvalueipa,ttlvaluesp1,ttlvaluesp2,ttlvaluesp3,ttlvaluect,
             ttlvalueik,c1_ttlvalueip,c1_ttlvaluesd,c1_ttlvalueal,c1_ttlvaluetl,c1_ttlvalueitl,c1_ttlvalueipa,c1_ttlvaluesp1,c1_ttlvaluesp2,c1_ttlvaluesp3,c1_ttlvaluect,c1_ttlvalueik,c2_ttlvalueip,
             c2_ttlvaluesd,c2_ttlvalueal,c2_ttlvaluetl,c2_ttlvalueitl,c2_ttlvalueipa,c2_ttlvaluesp1,c2_ttlvaluesp2,c2_ttlvaluesp3,c2_ttlvaluect,c2_ttlvalueik,f_score_k,f_ktg_fs,description,inputdate,
             inputby,updatedate,updateby,nodoktmp,status,f_desc_fs,f_kdvalue_fs)
                (select branch,idbu,vr_nomor,periode,nik,nikatasan1,nikatasan2,ttlvalueip,ttlvaluesd,ttlvalueal,ttlvaluetl,ttlvalueitl,ttlvalueipa,ttlvaluesp1,ttlvaluesp2,ttlvaluesp3,ttlvaluect,
                        ttlvalueik,c1_ttlvalueip,c1_ttlvaluesd,c1_ttlvalueal,c1_ttlvaluetl,c1_ttlvalueitl,c1_ttlvalueipa,c1_ttlvaluesp1,c1_ttlvaluesp2,c1_ttlvaluesp3,c1_ttlvaluect,c1_ttlvalueik,c2_ttlvalueip,
                        c2_ttlvaluesd,c2_ttlvalueal,c2_ttlvaluetl,c2_ttlvalueitl,c2_ttlvalueipa,c2_ttlvaluesp1,c2_ttlvaluesp2,c2_ttlvaluesp3,c2_ttlvaluect,c2_ttlvalueik,f_score_k,f_ktg_fs,description,inputdate,
                        inputby,updatedate,updateby,nodoktmp,'A' as status,f_desc_fs,f_kdvalue_fs
                 from sc_pk.kondite_tmp_mst where nodok=new.nodok and nik=new.nik AND periode=NEW.periode);

            delete from sc_mst.trxerror where userid=new.nodok;
            insert into sc_mst.trxerror
            (userid,errorcode,nomorakhir1,modul) values (new.nodok,0,vr_nomor,'PKPA');

            delete from sc_pk.kondite_tmp_mst where nodok=new.nodok and nik=new.nik and periode = vr_periode;

        elseif(new.status='' and old.status!='') then
            if new.updateby = 'SYSTEM' then
                update sc_pk.kondite_tmp_mst set
                     ttlvalueip = (select coalesce(sum(jumlah_cuti),0) from sc_trx.cuti_karyawan where to_char(tgl_mulai,'yyyymm')=new.periode and tpcuti='A' AND STATUS_PTG='A2' and nik=new.nik and coalesce(status,'')='P'),
                     ttlvaluesd = (select coalesce(sum(jumlah_cuti),0) from sc_trx.cuti_karyawan where to_char(tgl_mulai,'yyyymm')=new.periode and tpcuti='B' and kdijin_khusus='AG' and nik=new.nik and coalesce(status,'')='P'),
                     ttlvalueal = (select count(*) from sc_trx.listlinkjadwalcuti where to_char(tgl,'yyyymm')=new.periode and kdpokok='AL'  and nik=new.nik and tgl <= current_date),
                     ttlvaluetl  = (select count(*) from sc_trx.listlinkjadwalcuti where to_char(tgl,'yyyymm')=new.periode and kdpokok='TL'  and nik=new.nik), --TELAT
                     ttlvalueitl  = (select count(*) from sc_trx.ijin_karyawan where to_char(tgl_kerja,'yyyymm')=new.periode and kdijin_absensi IN ('DT') and type_ijin = 'PB' and coalesce(status,'')='P' and nik=new.nik), --IJIN TELAT
                     ttlvalueipa  = (select count(*) from sc_trx.ijin_karyawan where to_char(tgl_kerja,'yyyymm')=new.periode and kdijin_absensi IN ('PA') and type_ijin = 'PB' and coalesce(status,'')='P' and nik=new.nik), --IJIN PLG AWAL
                     ttlvaluect  = (select count(*) from sc_trx.listlinkjadwalcuti where to_char(tgl,'yyyymm')=new.periode and kdpokok='CT'  and nik=new.nik),
                     ttlvalueik  = (select count(*) from sc_trx.listlinkjadwalcuti where to_char(tgl,'yyyymm')=new.periode and kdpokok='IK'  and nik=new.nik),
                     ttlvaluesp1  = (select count(*) from sc_trx.sk_peringatan where to_char(startdate,'yyyymm')=new.periode and tindakan='SP1' and nik=new.nik),
                     ttlvaluesp2  = (select count(*) from sc_trx.sk_peringatan where to_char(startdate,'yyyymm')=new.periode and tindakan='SP2' and nik=new.nik),
                     ttlvaluesp3  = (select count(*) from sc_trx.sk_peringatan where to_char(startdate,'yyyymm')=new.periode and tindakan='SP3' and nik=new.nik)
                where nik=new.nik and periode=new.periode and nodok=new.nodok;
            end if;
            update sc_pk.kondite_tmp_mst set
                                             c2_ttlvalueip = round((select value1::numeric from sc_pk.m_formula_condite where kdrumus='MRPA001' and objectcode='IP')*ttlvalueip::numeric,2),
                                             c2_ttlvaluesd = round((select value1::numeric from sc_pk.m_formula_condite where kdrumus='MRPA002' and objectcode='SD')*ttlvaluesd::numeric,2),
                                             c2_ttlvalueal = round((select value1::numeric from sc_pk.m_formula_condite where kdrumus='MRPA003' and objectcode='AL')*ttlvalueal::numeric,2),
                                             c2_ttlvaluetl = round((select value1::numeric from sc_pk.m_formula_condite where kdrumus='MRPA011' and objectcode='TL')*ttlvaluetl::numeric,2),
                                             c2_ttlvalueitl = round((select value1::numeric from sc_pk.m_formula_condite where kdrumus='MRPA004' and objectcode='ITL')*ttlvalueitl::numeric,2),
                                             c2_ttlvalueipa = round((select value1::numeric from sc_pk.m_formula_condite where kdrumus='MRPA005' and objectcode='IPA')*ttlvalueipa::numeric,2),
                                             c2_ttlvaluect = round((select value1::numeric from sc_pk.m_formula_condite where kdrumus='MRPA009' and objectcode='CT')*ttlvaluect::numeric,2),
                                             c2_ttlvalueik = round((select value1::numeric from sc_pk.m_formula_condite where kdrumus='MRPA010' and objectcode='IK')*ttlvalueik::numeric,2),
                                             c2_ttlvaluesp1 = round((select value1::numeric from sc_pk.m_formula_condite where kdrumus='MRPA006' and objectcode='SP1')*ttlvaluesp1::numeric,2),
                                             c2_ttlvaluesp2 = round((select value1::numeric from sc_pk.m_formula_condite where kdrumus='MRPA007' and objectcode='SP2')*ttlvaluesp2::numeric,2),
                                             c2_ttlvaluesp3 = round((select value1::numeric from sc_pk.m_formula_condite where kdrumus='MRPA008' and objectcode='SP3')*ttlvaluesp3::numeric,2)
            where nik=new.nik and periode=new.periode and nodok=new.nodok;

            update sc_pk.kondite_tmp_mst set
                f_score_k = round((SELECT value1::numeric FROM sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='KUOTA')+(select sum(c2_ttlvalueip::numeric+c2_ttlvaluesd::numeric+c2_ttlvalueal::numeric+ c2_ttlvaluetl::numeric+ c2_ttlvalueitl::numeric+ c2_ttlvalueipa::numeric+ c2_ttlvaluect::numeric+c2_ttlvalueik::numeric+c2_ttlvaluesp1::numeric+c2_ttlvaluesp2::numeric+c2_ttlvaluesp3::numeric) from sc_pk.kondite_tmp_mst where nik=new.nik and periode=new.periode and nodok=new.nodok),2)
            where nik=new.nik and periode=new.periode and nodok=new.nodok;

            update sc_pk.kondite_tmp_mst set
              f_ktg_fs = case
                               when f_score_k::numeric<=(select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SK')
                                   then round(f_score_k::numeric/(select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SK'),2)
                               when f_score_k::numeric BETWEEN (select value2::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='K') AND (select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='K')
                                   then round((f_score_k::numeric-(select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SK'))/((select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='K')-(select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SK')),2)+1
                               when f_score_k::numeric BETWEEN (select value2::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='C') AND (select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='C')
                                   then round((f_score_k::numeric-(select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='K'))/((select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='C')-(select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='K')),2)+2
                               when f_score_k::numeric BETWEEN (select value2::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='B') AND (select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='B')
                                   then round((f_score_k::numeric-(select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='C'))/((select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='B')-(select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='C')),2)+3
                               when f_score_k::numeric=(select value1::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SB')
                                   then (select value3::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SB')
                               ELSE f_score_k::numeric
                    END
            where nik=new.nik and periode=new.periode and nodok=new.nodok;

            update sc_pk.kondite_tmp_mst set
                                             f_desc_fs = case
                                                             when f_ktg_fs::NUMERIC BETWEEN (select value4::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='K') AND (select value3::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='K')
                                                                 then (select description from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='K')
                                                             when f_ktg_fs::NUMERIC BETWEEN (select value4::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='C') AND (select value3::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='C')
                                                                 then (select description from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='C')
                                                             when f_ktg_fs::NUMERIC BETWEEN (select value4::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='B') AND (select value3::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='B')
                                                                 then (select description from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='B')
                                                             when f_ktg_fs::NUMERIC=(select value3::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SB')
                                                                 then (select description from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SB')
                                                 end,
                                             f_kdvalue_fs = case
                                                                when f_ktg_fs::NUMERIC BETWEEN (select value4::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='K') AND (select value3::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='K')
                                                                    then (select kdvalue from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='K')
                                                                when f_ktg_fs::NUMERIC BETWEEN (select value4::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='C') AND (select value3::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='C')
                                                                    then (select kdvalue from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='C')
                                                                when f_ktg_fs::NUMERIC BETWEEN (select value4::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='B') AND (select value3::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='B')
                                                                    then (select kdvalue from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='B')
                                                                when f_ktg_fs::NUMERIC=(select value3::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SB')
                                                                    then (select kdvalue from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SB')
                                                 end,
                                             status=old.status
            where nik=new.nik and periode=new.periode and nodok=new.nodok;
        end if;

        RETURN NEW;
    END IF;

    return new;

end;
$function$
;