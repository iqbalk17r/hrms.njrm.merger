CREATE TABLE IF NOT EXISTS sc_pk.kondite_tmp_mst (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	nik bpchar(12) NOT NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	ttlvalueip bpchar(20) NULL,
	ttlvaluesd bpchar(20) NULL,
	ttlvalueal bpchar(20) NULL,
	ttlvaluetl bpchar(20) NULL,
	ttlvaluesp1 bpchar(20) NULL,
	ttlvaluesp2 bpchar(20) NULL,
	ttlvaluesp3 bpchar(20) NULL,
	ttlvaluect bpchar(20) NULL,
	ttlvalueik bpchar(20) NULL,
	c1_ttlvalueip bpchar(20) NULL,
	c1_ttlvaluesd bpchar(20) NULL,
	c1_ttlvalueal bpchar(20) NULL,
	c1_ttlvaluetl bpchar(20) NULL,
	c1_ttlvaluesp1 bpchar(20) NULL,
	c1_ttlvaluesp2 bpchar(20) NULL,
	c1_ttlvaluesp3 bpchar(20) NULL,
	c1_ttlvaluect bpchar(20) NULL,
	c1_ttlvalueik bpchar(20) NULL,
	c2_ttlvalueip bpchar(20) NULL,
	c2_ttlvaluesd bpchar(20) NULL,
	c2_ttlvalueal bpchar(20) NULL,
	c2_ttlvaluetl bpchar(20) NULL,
	c2_ttlvaluesp1 bpchar(20) NULL,
	c2_ttlvaluesp2 bpchar(20) NULL,
	c2_ttlvaluesp3 bpchar(20) NULL,
	c2_ttlvaluect bpchar(20) NULL,
	c2_ttlvalueik bpchar(20) NULL,
	f_score_k bpchar(20) NULL,
	f_ktg_fs bpchar(20) NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	nodoktmp varchar NULL,
	status bpchar(12) NULL,
	f_desc_fs bpchar(20) NULL,
	f_kdvalue_fs bpchar(20) NULL,
	c1_ttlvalueitl bpchar(20) NULL,
	c1_ttlvalueipa bpchar(20) NULL,
	c2_ttlvalueitl bpchar(20) NULL,
	c2_ttlvalueipa bpchar(20) NULL,
	ttlvalueitl bpchar(20) NULL,
	ttlvalueipa bpchar(20) NULL,
	CONSTRAINT kondite_tmp_mst_pkey PRIMARY KEY (branch, idbu, nodok, periode, nik)
);

CREATE OR REPLACE FUNCTION sc_pk.tr_kondite_tmp_mst()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
	--created by Fiky ::18/07/2017
	--modified by DK ::12/12/2023
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
                         when f_ktg_fs::NUMERIC<=(select value3::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SK') 
                         then (select description from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SK')
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
                        when f_ktg_fs::NUMERIC<=(select value3::numeric from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SK') 
                         then (select kdvalue from sc_pk.m_bobot where kdcategory='KONDITE' and kdvalue='SK')
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


-- Table Triggers

CREATE TRIGGER tr_kondite_tmp_mst AFTER
INSERT
    OR
UPDATE
    ON
    sc_pk.kondite_tmp_mst FOR EACH ROW EXECUTE PROCEDURE sc_pk.tr_kondite_tmp_mst();

-- Permissions

ALTER TABLE sc_pk.kondite_tmp_mst OWNER TO postgres;
GRANT ALL ON TABLE sc_pk.kondite_tmp_mst TO postgres;

CREATE TABLE IF NOT EXISTS sc_pk.kondite_tmp_rekap (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	nik bpchar(12) NOT NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	f_score_k bpchar(20) NULL,
	f_ktg_fs bpchar(20) NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	nodoktmp varchar NULL,
	status bpchar(12) NULL,
	f_desc_fs bpchar(20) NULL,
	f_kdvalue_fs bpchar(20) NULL,
	CONSTRAINT kondite_tmp_rekap_pkey PRIMARY KEY (branch, idbu, nodok, periode, nik)
);


CREATE OR REPLACE FUNCTION sc_pk.tr_kondite_trx_rekap()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by DK ::05/12/2023
    vr_nomor varchar;
    vr_cekprefix char(4);
    vr_nowprefix char(4);
   	vr_periode varchar;
begin

    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        if (new.status='E' and old.status='A') then
            insert into sc_pk.kondite_tmp_rekap
            select branch,idbu,NEW.UPDATEBY,periode,nik,nikatasan1,nikatasan2,f_score_k,f_ktg_fs,description,inputdate,inputby,updatedate,updateby,nodok,'E',f_desc_fs,f_kdvalue_fs
            from sc_pk.kondite_trx_rekap where nodok=new.nodok and nik=new.nik;
        end if;

        RETURN NEW;
    END IF;

    return new;

end;
$function$
;

-- Permissions

ALTER TABLE sc_pk.kondite_tmp_rekap OWNER TO postgres;
GRANT ALL ON TABLE sc_pk.kondite_tmp_rekap TO postgres;

CREATE TABLE IF NOT EXISTS sc_pk.kondite_trx_mst (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	nik bpchar(12) NOT NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	ttlvalueip bpchar(20) NULL,
	ttlvaluesd bpchar(20) NULL,
	ttlvalueal bpchar(20) NULL,
	ttlvaluetl bpchar(20) NULL,
	ttlvaluesp1 bpchar(20) NULL,
	ttlvaluesp2 bpchar(20) NULL,
	ttlvaluesp3 bpchar(20) NULL,
	ttlvaluect bpchar(20) NULL,
	ttlvalueik bpchar(20) NULL,
	c1_ttlvalueip bpchar(20) NULL,
	c1_ttlvaluesd bpchar(20) NULL,
	c1_ttlvalueal bpchar(20) NULL,
	c1_ttlvaluetl bpchar(20) NULL,
	c1_ttlvaluesp1 bpchar(20) NULL,
	c1_ttlvaluesp2 bpchar(20) NULL,
	c1_ttlvaluesp3 bpchar(20) NULL,
	c1_ttlvaluect bpchar(20) NULL,
	c1_ttlvalueik bpchar(20) NULL,
	c2_ttlvalueip bpchar(20) NULL,
	c2_ttlvaluesd bpchar(20) NULL,
	c2_ttlvalueal bpchar(20) NULL,
	c2_ttlvaluetl bpchar(20) NULL,
	c2_ttlvaluesp1 bpchar(20) NULL,
	c2_ttlvaluesp2 bpchar(20) NULL,
	c2_ttlvaluesp3 bpchar(20) NULL,
	c2_ttlvaluect bpchar(20) NULL,
	c2_ttlvalueik bpchar(20) NULL,
	f_score_k bpchar(20) NULL,
	f_ktg_fs bpchar(20) NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	nodoktmp varchar NULL,
	status bpchar(12) NULL,
	f_desc_fs bpchar(20) NULL,
	f_kdvalue_fs bpchar(20) NULL,
	a1_approved bool NULL DEFAULT false,
	a2_approved bool NULL DEFAULT false,
	c1_ttlvalueitl bpchar(20) NULL,
	c1_ttlvalueipa bpchar(20) NULL,
	c2_ttlvalueitl bpchar(20) NULL,
	c2_ttlvalueipa bpchar(20) NULL,
	ttlvalueitl bpchar(20) NULL,
	ttlvalueipa bpchar(20) NULL,
	CONSTRAINT kondite_trx_mst_pkey PRIMARY KEY (branch, idbu, nodok, periode, nik)
);

CREATE OR REPLACE FUNCTION sc_pk.tr_kondite_trx_mst()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by Fiky ::18/07/2017
    vr_nomor char(20);
    vr_cekprefix char(4);
    vr_nowprefix char(4);
begin

    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        if (new.status='E' and old.status='A') then

            insert into sc_pk.kondite_tmp_mst
            (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,ttlvalueip,ttlvaluesd,ttlvalueal,ttlvaluetl,ttlvalueitl,ttlvalueipa,ttlvaluesp1,ttlvaluesp2,ttlvaluesp3,ttlvaluect,
             ttlvalueik,c1_ttlvalueip,c1_ttlvaluesd,c1_ttlvalueal,c1_ttlvaluetl,c1_ttlvalueitl,c1_ttlvalueipa,c1_ttlvaluesp1,c1_ttlvaluesp2,c1_ttlvaluesp3,c1_ttlvaluect,c1_ttlvalueik,c2_ttlvalueip,
             c2_ttlvaluesd,c2_ttlvalueal,c2_ttlvaluetl,c2_ttlvalueitl,c2_ttlvalueipa,c2_ttlvaluesp1,c2_ttlvaluesp2,c2_ttlvaluesp3,c2_ttlvaluect,c2_ttlvalueik,f_score_k,f_ktg_fs,description,inputdate,
             inputby,updatedate,updateby,nodoktmp,status,f_desc_fs,f_kdvalue_fs)
                (select branch,idbu,NEW.UPDATEBY,periode,nik,nikatasan1,nikatasan2,ttlvalueip,ttlvaluesd,ttlvalueal,ttlvaluetl,ttlvalueitl,ttlvalueipa,ttlvaluesp1,ttlvaluesp2,ttlvaluesp3,ttlvaluect,
                        ttlvalueik,c1_ttlvalueip,c1_ttlvaluesd,c1_ttlvalueal,c1_ttlvaluetl,c1_ttlvalueitl,c1_ttlvalueipa,c1_ttlvaluesp1,c1_ttlvaluesp2,c1_ttlvaluesp3,c1_ttlvaluect,c1_ttlvalueik,c2_ttlvalueip,
                        c2_ttlvaluesd,c2_ttlvalueal,c2_ttlvaluetl,c2_ttlvalueitl,c2_ttlvalueipa,c2_ttlvaluesp1,c2_ttlvaluesp2,c2_ttlvaluesp3,c2_ttlvaluect,c2_ttlvalueik,f_score_k,f_ktg_fs,description,inputdate,
                        inputby,updatedate,updateby,nodok,'E' as status,f_desc_fs,f_kdvalue_fs
                 from sc_pk.kondite_trx_mst where nodok=new.nodok and nik=new.nik AND periode=NEW.periode);
        end if;


        RETURN NEW;
    END IF;


    return new;

end;
$function$
;


-- Table Triggers

CREATE TRIGGER tr_kondite_trx_mst AFTER
INSERT
    OR
UPDATE
    ON
    sc_pk.kondite_trx_mst FOR EACH ROW EXECUTE PROCEDURE sc_pk.tr_kondite_trx_mst();

-- Permissions

ALTER TABLE sc_pk.kondite_trx_mst OWNER TO postgres;
GRANT ALL ON TABLE sc_pk.kondite_trx_mst TO postgres;

CREATE TABLE IF NOT EXISTS sc_pk.kondite_trx_rekap (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	nik bpchar(12) NOT NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	f_score_k bpchar(20) NULL,
	f_ktg_fs bpchar(20) NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	nodoktmp varchar NULL,
	status bpchar(12) NULL,
	f_desc_fs bpchar(20) NULL,
	f_kdvalue_fs bpchar(20) NULL,
	a1_approved bool NULL DEFAULT false,
	a2_approved bool NULL DEFAULT false,
	CONSTRAINT kondite_trx_rekap_pkey PRIMARY KEY (branch, idbu, nodok, periode, nik)
);

CREATE OR REPLACE FUNCTION sc_pk.tr_kondite_trx_rekap()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by DK ::05/12/2023
    vr_nomor varchar;
    vr_cekprefix char(4);
    vr_nowprefix char(4);
   	vr_periode varchar;
begin

    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        if (new.status='E' and old.status='A') then
            insert into sc_pk.kondite_tmp_rekap
            select branch,idbu,NEW.UPDATEBY,periode,nik,nikatasan1,nikatasan2,f_score_k,f_ktg_fs,description,inputdate,inputby,updatedate,updateby,nodok,'E',f_desc_fs,f_kdvalue_fs
            from sc_pk.kondite_trx_rekap where nodok=new.nodok and nik=new.nik;
        end if;

        RETURN NEW;
    END IF;

    return new;

end;
$function$
;


-- Table Triggers

CREATE TRIGGER tr_kondite_trx_rekap AFTER
INSERT
    OR
UPDATE
    ON
    sc_pk.kondite_trx_rekap FOR EACH ROW EXECUTE PROCEDURE sc_pk.tr_kondite_trx_rekap();

-- Permissions

ALTER TABLE sc_pk.kondite_trx_rekap OWNER TO postgres;
GRANT ALL ON TABLE sc_pk.kondite_trx_rekap TO postgres;
