CREATE TABLE IF NOT EXISTS sc_pk.final_report_pk (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	nik bpchar(12) NOT NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	fs1_kpi bpchar(12) NULL,
	fs1_kondite bpchar(12) NULL,
	fs1_pa bpchar(12) NULL,
	fs1_inspek bpchar(12) NULL,
	fsk1_kpi bpchar(12) NULL,
	fsk1_kondite bpchar(12) NULL,
	fsk1_pa bpchar(12) NULL,
	fsk1_inspek bpchar(12) NULL,
	b1_kpi bpchar(12) NULL,
	b1_kondite bpchar(12) NULL,
	b1_pa bpchar(12) NULL,
	b1_inspek bpchar(12) NULL,
	ttls1 bpchar(12) NULL,
	ktgs1 bpchar(12) NULL,
	fs2_kpi bpchar(12) NULL,
	fs2_kondite bpchar(12) NULL,
	fs2_pa bpchar(12) NULL,
	fs2_inspek bpchar(12) NULL,
	fsk2_kpi bpchar(12) NULL,
	fsk2_kondite bpchar(12) NULL,
	fsk2_pa bpchar(12) NULL,
	fsk2_inspek bpchar(12) NULL,
	b2_kpi bpchar(12) NULL,
	b2_kondite bpchar(12) NULL,
	b2_pa bpchar(12) NULL,
	b2_inspek bpchar(12) NULL,
	ttls2 bpchar(12) NULL,
	ktgs2 bpchar(12) NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	nodoktmp varchar NULL,
	status bpchar(12) NULL,
	p1_kpi bpchar(12) NULL,
	p1_kondite bpchar(12) NULL,
	p1_pa bpchar(12) NULL,
	p1_inspek bpchar(12) NULL,
	p2_kpi bpchar(12) NULL,
	p2_kondite bpchar(12) NULL,
	p2_pa bpchar(12) NULL,
	p2_inspek bpchar(12) NULL,
	kddept bpchar(12) NULL,
	note text NULL,
	suggestion text NULL,
	a1_approved bool NULL DEFAULT false,
	a2_approved bool NULL DEFAULT false,
	CONSTRAINT final_report_pk_pkey PRIMARY KEY (branch, idbu, nodok, periode, nik)
);

ALTER TABLE sc_pk.final_report_pk OWNER TO postgres;
GRANT ALL ON TABLE sc_pk.final_report_pk TO postgres;

CREATE OR REPLACE FUNCTION sc_pk.final_report_pk()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
--created by Fiky ::18/07/2017
--updated by DK ::
declare
    vr_nomor char(20);
    vr_cekprefix char(4);
    vr_nowprefix char(4);
begin

    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        if (new.status='E' and old.status='A') then
            vr_nomor:='FSPK'||'/'||new.periode||'/'||new.nik;

            insert into sc_pk.final_report_pk_tmp
            (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fsk1_kpi,fsk1_kondite,fsk1_pa,b1_kpi,
             b1_kondite,b1_pa,ttls1,ktgs1,description,inputdate,inputby,updatedate,updateby,nodoktmp,status,p1_kpi,p1_kondite,p1_pa)

                (select branch,idbu,NEW.UPDATEBY,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fsk1_kpi,fsk1_kondite,fsk1_pa,b1_kpi,
                        b1_kondite,b1_pa,ttls1,ktgs1,description,inputdate,inputby,updatedate,updateby,new.nodok,'E' as status,p1_kpi,p1_kondite,p1_pa
                 from sc_pk.final_report_pk where nodok=new.nodok and nik=new.nik);
         elseif (new.status='P' and old.status<>'P') then
			IF (SELECT count(*) FROM sc_pk.final_report_pk WHERE nodok=new.nodok AND status <> 'P') = 0 THEN 
				UPDATE sc_pk.rekap_final_report_pk_trx 
				SET status = 'P'
				WHERE nodok = NEW.nodok;
			END IF;
        end if;

        RETURN NEW;
    END IF;

    return new;

end;
$function$
;


DROP TRIGGER IF EXISTS tr_final_report_pk ON sc_pk.final_report_pk;
CREATE TRIGGER tr_final_report_pk AFTER
INSERT
    OR
UPDATE
    ON
    sc_pk.final_report_pk FOR EACH ROW EXECUTE PROCEDURE sc_pk.final_report_pk();

CREATE TABLE IF NOT EXISTS sc_pk.final_report_pk_tmp (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	nik bpchar(12) NOT NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	fs1_kpi varchar NULL,
	fs1_kondite varchar NULL,
	fs1_pa varchar NULL,
	fs1_inspek bpchar(12) NULL,
	fsk1_kpi varchar NULL,
	fsk1_kondite varchar NULL,
	fsk1_pa varchar NULL,
	fsk1_inspek bpchar(12) NULL,
	b1_kpi varchar NULL,
	b1_kondite varchar NULL,
	b1_pa varchar NULL,
	b1_inspek bpchar(12) NULL,
	ttls1 bpchar(12) NULL,
	ktgs1 bpchar(12) NULL,
	fs2_kpi bpchar(12) NULL,
	fs2_kondite bpchar(12) NULL,
	fs2_pa bpchar(12) NULL,
	fs2_inspek bpchar(12) NULL,
	fsk2_kpi bpchar(12) NULL,
	fsk2_kondite bpchar(12) NULL,
	fsk2_pa bpchar(12) NULL,
	fsk2_inspek bpchar(12) NULL,
	b2_kpi bpchar(12) NULL,
	b2_kondite bpchar(12) NULL,
	b2_pa bpchar(12) NULL,
	b2_inspek bpchar(12) NULL,
	ttls2 bpchar(12) NULL,
	ktgs2 bpchar(12) NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	nodoktmp varchar NULL,
	status bpchar(12) NULL,
	p1_kpi bpchar(12) NULL,
	p1_kondite bpchar(12) NULL,
	p1_pa bpchar(12) NULL,
	p1_inspek bpchar(12) NULL,
	p2_kpi bpchar(12) NULL,
	p2_kondite bpchar(12) NULL,
	p2_pa bpchar(12) NULL,
	p2_inspek bpchar(12) NULL,
	kddept bpchar(12) NULL,
	CONSTRAINT final_report_pk_tmp_pkey PRIMARY KEY (branch, idbu, nodok, periode, nik)
);

CREATE OR REPLACE FUNCTION sc_pk.final_report_pk_tmp()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
	--created by Fiky ::18/07/2017
	--MODIFIED BY DK ::16/12/2023
declare
    vr_nomor char(30);
    vr_nik char(30);
    vr_cekprefix char(4);
    vr_nowprefix char(4);
   	vr_startPeriode varchar;
   	vr_endPeriode varchar;
   	vr_kpi_score NUMERIC;
	vr_lPeriode varchar;
	vr_range_periode NUMERIC;
	vr_total_periode NUMERIC;
begin
	vr_startPeriode:= SUBSTRING(NEW.periode, 1, 6);
	vr_endPeriode:= SUBSTRING(NEW.periode, 8, 6);
	
    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        if(new.status='' and old.status!='') then
            vr_nik:= new.nik;
           	vr_range_periode:= vr_endPeriode::NUMERIC - vr_startPeriode::NUMERIC;
			vr_total_periode:= (SELECT count(*) FROM sc_pk.kpi_trx_mst where nik=vr_nik and periode BETWEEN vr_startPeriode AND vr_endPeriode);		
				
			IF vr_range_periode = vr_total_periode THEN 
	        	vr_kpi_score := (SELECT round(avg(coalesce(kpi_score::numeric,0)),2) from sc_pk.kpi_trx_mst where nik=vr_nik and periode BETWEEN vr_startPeriode AND vr_endPeriode);
	      	ELSEIF vr_range_periode > vr_total_periode AND vr_total_periode != 0 THEN
	        	vr_kpi_score:= 0;
	        	FOR vr_lperiode IN SELECT periode FROM sc_pk.kpi_trx_mst WHERE nik=vr_nik AND periode BETWEEN vr_startPeriode AND vr_endPeriode
		        LOOP
		            vr_kpi_score:= vr_kpi_score + (SELECT COALESCE(kpi_score::numeric,0) FROM sc_pk.kpi_trx_mst WHERE nik=vr_nik AND periode = vr_lperiode);
		     	END LOOP;
		     	vr_kpi_score:= round(vr_kpi_score/vr_total_periode,2);
	      	ELSE
	      		vr_kpi_score:= 0;
		  	END IF;
		  
            update  sc_pk.final_report_pk_tmp set
              fs1_kpi=vr_kpi_score,
              fs1_kondite=(select coalesce(f_ktg_fs::numeric,0) from sc_pk.kondite_trx_rekap where nik=NEW.nik and periode=NEW.periode),
              fs1_pa=(select coalesce(f_value_ktg::numeric,0) from sc_pk.pa_form_pa_trx_mst where nik=new.nik and periode=new.periode)
            where nik=new.nik and periode=new.periode;

            update  sc_pk.final_report_pk_tmp set
              b1_kpi=round(coalesce(fs1_kpi::numeric,0)*(select(value1::numeric/100)::numeric(18,2) from sc_pk.m_bobot where kdcategory='FSC1' AND kdvalue='KPI'),2),
              b1_kondite=round(coalesce(fs1_kondite::numeric,0)*(select(value1::numeric/100)::numeric(18,2) from sc_pk.m_bobot where kdcategory='FSC1' AND kdvalue='KONDITE'),2),
              b1_pa=round(coalesce(fs1_pa::numeric,0)*(select(value1::numeric/100)::numeric(18,2) from sc_pk.m_bobot where kdcategory='FSC1' AND kdvalue='PA'),2),

              fsk1_kpi=round(coalesce(fs1_kpi::numeric,0)*(select(value1::numeric/100)::numeric(18,2) from sc_pk.m_bobot where kdcategory='FSC1' AND kdvalue='KPI'),2) ,
              fsk1_kondite=round(coalesce(fs1_kondite::numeric,0)*(select(value1::numeric/100)::numeric(18,2) from sc_pk.m_bobot where kdcategory='FSC1' AND kdvalue='KONDITE'),2),
              fsk1_pa=round(coalesce(fs1_pa::numeric,0)*(select(value1::numeric/100)::numeric(18,2) from sc_pk.m_bobot where kdcategory='FSC1' AND kdvalue='PA'),2) ,

              p1_kpi=(select(value1::numeric)::numeric(18) from sc_pk.m_bobot where kdcategory='FSC1' AND kdvalue='KPI'),
              p1_kondite=(select(value1::numeric)::numeric(18) from sc_pk.m_bobot where kdcategory='FSC1' AND kdvalue='KONDITE'),
              p1_pa=(select(value1::numeric)::numeric(18) from sc_pk.m_bobot where kdcategory='FSC1' AND kdvalue='PA')              
            where nik=new.nik and periode=new.periode and nodok=new.nodok;
           
           update  sc_pk.final_report_pk_tmp set
              ttls1=round(fsk1_kpi::numeric+fsk1_kondite::numeric+fsk1_pa::numeric,2)
            where nik=new.nik and periode=new.periode and nodok=new.nodok;
           
            update  sc_pk.final_report_pk_tmp set
              ktgs1=(select kdvalue from sc_pk.m_bobot where kdcategory='PA' and ttls1::numeric BETWEEN value2::NUMERIC AND value1::numeric),
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

CREATE TRIGGER tr_final_report_pk_tmp AFTER
INSERT
    OR
UPDATE
    ON
    sc_pk.final_report_pk_tmp FOR EACH ROW EXECUTE PROCEDURE sc_pk.final_report_pk_tmp();

-- Permissions

ALTER TABLE sc_pk.final_report_pk_tmp OWNER TO postgres;
GRANT ALL ON TABLE sc_pk.final_report_pk_tmp TO postgres;

CREATE TABLE IF NOT EXISTS sc_pk.pa_report_final (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	nik bpchar(12) NOT NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	na1 bpchar(4) NULL,
	nb1 bpchar(4) NULL,
	na2 bpchar(4) NULL,
	nb2 bpchar(4) NULL,
	na3 bpchar(4) NULL,
	nb3 bpchar(4) NULL,
	na4 bpchar(4) NULL,
	nb4 bpchar(4) NULL,
	na5 bpchar(4) NULL,
	nb5 bpchar(4) NULL,
	na6 bpchar(4) NULL,
	nb6 bpchar(4) NULL,
	na7 bpchar(4) NULL,
	nb7 bpchar(4) NULL,
	na8 bpchar(4) NULL,
	nb8 bpchar(4) NULL,
	na9 bpchar(4) NULL,
	nb9 bpchar(4) NULL,
	na10 bpchar(4) NULL,
	nb10 bpchar(4) NULL,
	na11 bpchar(4) NULL,
	nb11 bpchar(4) NULL,
	na12 bpchar(4) NULL,
	nb12 bpchar(4) NULL,
	na13 bpchar(4) NULL,
	nb13 bpchar(4) NULL,
	na14 bpchar(4) NULL,
	nb14 bpchar(4) NULL,
	na15 bpchar(4) NULL,
	nb15 bpchar(4) NULL,
	ttlvalue1 bpchar(20) NULL,
	ttlvalue2 bpchar(20) NULL,
	f_value bpchar(20) NULL,
	f_value_ktg bpchar(20) NULL,
	userid bpchar(20) NOT NULL,
	CONSTRAINT pa_report_final_pkey PRIMARY KEY (branch, idbu, nodok, periode, nik, userid)
);

-- Permissions

ALTER TABLE sc_pk.pa_report_final OWNER TO postgres;
GRANT ALL ON TABLE sc_pk.pa_report_final TO postgres;

CREATE TABLE IF NOT EXISTS sc_pk.rekap_final_report_pk_tmp (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	kddept bpchar(12) NOT NULL,
	ttls1 bpchar(20) NULL,
	ttls2 bpchar(20) NULL,
	ktgs1 bpchar(20) NULL,
	ktgs2 bpchar(20) NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	approvedate timestamp NULL,
	approveby bpchar(12) NULL,
	status bpchar(12) NULL,
	CONSTRAINT rekap_final_report_pk_tmp_pkey PRIMARY KEY (branch, idbu, nodok, periode, kddept)
);

CREATE OR REPLACE FUNCTION sc_pk.rekap_final_report_pk_tmp()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
--created by Fiky ::18/07/2017
--update by Fiky ::06/11/2018
--MODIFIED BY DK ::18/12/2023
declare
    vr_nomor char(30);
    vr_nik char(30);
    vr_cekprefix char(4);
    vr_nowprefix char(4);
    vr_countdtl numeric;
    vr_sumttls1 numeric;
    vr_sumttls2 numeric;
   	vr_startPeriode varchar;
   	vr_endPeriode varchar;
   	vr_kpi_score NUMERIC;
	vr_lPeriode varchar;
	vr_range_periode NUMERIC;
	vr_total_periode NUMERIC;
BEGIN
	vr_startPeriode:= SUBSTRING(NEW.periode, 1, 6);
	vr_endPeriode:= SUBSTRING(NEW.periode, 8, 6);

    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        if (new.status='F' and old.status='I') then
            vr_nomor:='FSPK'||'/'||new.periode||'/'||new.kddept;

            insert into sc_pk.rekap_final_report_pk_trx
            (branch,idbu,nodok,periode,kddept,ttls1,ttls2,ktgs1,ktgs2,description,inputdate,
             inputby,updatedate,updateby,approvedate,approveby,status)
                (select branch,idbu,vr_nomor,periode,kddept,ttls1,ttls2,ktgs1,ktgs2,description,inputdate,
                        inputby,updatedate,updateby,approvedate,approveby,'A' as status from sc_pk.rekap_final_report_pk_tmp where nodok=new.nodok);

            insert into sc_pk.final_report_pk
            (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fs1_inspek,fsk1_kpi,fsk1_kondite,fsk1_pa,fsk1_inspek,b1_kpi,
             b1_kondite,b1_pa,b1_inspek,ttls1,ktgs1,fs2_kpi,fs2_kondite,fs2_pa,fs2_inspek,fsk2_kpi,fsk2_kondite,fsk2_pa,fsk2_inspek,b2_kpi,b2_kondite,
             b2_pa,b2_inspek,ttls2,ktgs2,description,inputdate,inputby,updatedate,updateby,nodoktmp,status,p1_kpi,p2_kpi,p1_kondite,p2_kondite,p1_pa,p2_pa,p1_inspek,p2_inspek,kddept)

                (select branch,idbu,vr_nomor  as nodok,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fs1_inspek,fsk1_kpi,fsk1_kondite,fsk1_pa,fsk1_inspek,b1_kpi,
                        b1_kondite,b1_pa,b1_inspek,ttls1,ktgs1,fs2_kpi,fs2_kondite,fs2_pa,fs2_inspek,fsk2_kpi,fsk2_kondite,fsk2_pa,fsk2_inspek,b2_kpi,b2_kondite,
                        b2_pa,b2_inspek,ttls2,ktgs2,description,inputdate,inputby,updatedate,updateby,nodoktmp,'A' as status,p1_kpi,p2_kpi,p1_kondite,p2_kondite,p1_pa,p2_pa,p1_inspek,p2_inspek,kddept
                 from sc_pk.final_report_pk_tmp where nodok=new.nodok);

            delete from sc_mst.trxerror where userid=new.nodok;
            insert into sc_mst.trxerror
            (userid,errorcode,nomorakhir1,modul) values (new.nodok,0,vr_nomor,'PKPA');

            delete from sc_pk.rekap_final_report_pk_tmp where nodok=new.nodok ;
            delete from sc_pk.final_report_pk_tmp where nodok=new.nodok ;

        elseif (new.status='F' and old.status='E') then
            vr_nomor:='FSPK'||'/'||new.periode||'/'||new.kddept;

            delete from sc_pk.rekap_final_report_pk_trx where nodok=vr_nomor ;
            delete from sc_pk.final_report_pk where nodok=vr_nomor ;

            insert into sc_pk.rekap_final_report_pk_trx
            (branch,idbu,nodok,periode,kddept,ttls1,ttls2,ktgs1,ktgs2,description,inputdate,
             inputby,updatedate,updateby,approvedate,approveby,status)
                (select branch,idbu,vr_nomor,periode,kddept,ttls1,ttls2,ktgs1,ktgs2,description,inputdate,
                        inputby,updatedate,updateby,approvedate,approveby,'A' as status from sc_pk.rekap_final_report_pk_tmp where nodok=new.nodok);

            insert into sc_pk.final_report_pk
            (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fs1_inspek,fsk1_kpi,fsk1_kondite,fsk1_pa,fsk1_inspek,b1_kpi,
             b1_kondite,b1_pa,b1_inspek,ttls1,ktgs1,fs2_kpi,fs2_kondite,fs2_pa,fs2_inspek,fsk2_kpi,fsk2_kondite,fsk2_pa,fsk2_inspek,b2_kpi,b2_kondite,
             b2_pa,b2_inspek,ttls2,ktgs2,description,inputdate,inputby,updatedate,updateby,nodoktmp,status,p1_kpi,p2_kpi,p1_kondite,p2_kondite,p1_pa,p2_pa,p1_inspek,p2_inspek,kddept)

                (select branch,idbu,vr_nomor  as nodok,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fs1_inspek,fsk1_kpi,fsk1_kondite,fsk1_pa,fsk1_inspek,b1_kpi,
                        b1_kondite,b1_pa,b1_inspek,ttls1,ktgs1,fs2_kpi,fs2_kondite,fs2_pa,fs2_inspek,fsk2_kpi,fsk2_kondite,fsk2_pa,fsk2_inspek,b2_kpi,b2_kondite,
                        b2_pa,b2_inspek,ttls2,ktgs2,description,inputdate,inputby,updatedate,updateby,nodoktmp,'A' as status,p1_kpi,p2_kpi,p1_kondite,p2_kondite,p1_pa,p2_pa,p1_inspek,p2_inspek,kddept
                 from sc_pk.final_report_pk_tmp where nodok=new.nodok);

            delete from sc_mst.trxerror where userid=new.nodok;
            insert into sc_mst.trxerror
            (userid,errorcode,nomorakhir1,modul) values (new.nodok,0,vr_nomor,'PKPA');

            delete from sc_pk.rekap_final_report_pk_tmp where nodok=new.nodok ;
            delete from sc_pk.final_report_pk_tmp where nodok=new.nodok ;
        elseif (new.status='F' and old.status='A') then
            vr_nomor:='FSPK'||'/'||new.periode||'/'||new.kddept;

            delete from sc_pk.rekap_final_report_pk_trx where nodok=vr_nomor ;
            delete from sc_pk.final_report_pk where nodok=vr_nomor ;

            insert into sc_pk.rekap_final_report_pk_trx
            (branch,idbu,nodok,periode,kddept,ttls1,ttls2,ktgs1,ktgs2,description,inputdate,
             inputby,updatedate,updateby,approvedate,approveby,status)
                (select branch,idbu,vr_nomor,periode,kddept,ttls1,ttls2,ktgs1,ktgs2,description,inputdate,
                        inputby,updatedate,updateby,approvedate,approveby,'P' as status from sc_pk.rekap_final_report_pk_tmp where nodok=new.nodok);

            insert into sc_pk.final_report_pk
            (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fs1_inspek,fsk1_kpi,fsk1_kondite,fsk1_pa,fsk1_inspek,b1_kpi,
             b1_kondite,b1_pa,b1_inspek,ttls1,ktgs1,fs2_kpi,fs2_kondite,fs2_pa,fs2_inspek,fsk2_kpi,fsk2_kondite,fsk2_pa,fsk2_inspek,b2_kpi,b2_kondite,
             b2_pa,b2_inspek,ttls2,ktgs2,description,inputdate,inputby,updatedate,updateby,nodoktmp,status,p1_kpi,p2_kpi,p1_kondite,p2_kondite,p1_pa,p2_pa,p1_inspek,p2_inspek,kddept)

                (select branch,idbu,vr_nomor  as nodok,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fs1_inspek,fsk1_kpi,fsk1_kondite,fsk1_pa,fsk1_inspek,b1_kpi,
                        b1_kondite,b1_pa,b1_inspek,ttls1,ktgs1,fs2_kpi,fs2_kondite,fs2_pa,fs2_inspek,fsk2_kpi,fsk2_kondite,fsk2_pa,fsk2_inspek,b2_kpi,b2_kondite,
                        b2_pa,b2_inspek,ttls2,ktgs2,description,inputdate,inputby,updatedate,updateby,nodoktmp,'P' as status,p1_kpi,p2_kpi,p1_kondite,p2_kondite,p1_pa,p2_pa,p1_inspek,p2_inspek,kddept
                 from sc_pk.final_report_pk_tmp where nodok=new.nodok);

            delete from sc_mst.trxerror where userid=new.nodok;
            insert into sc_mst.trxerror
            (userid,errorcode,nomorakhir1,modul) values (new.nodok,0,vr_nomor,'PKPA');

            delete from sc_pk.rekap_final_report_pk_tmp where nodok=new.nodok ;
            delete from sc_pk.final_report_pk_tmp where nodok=new.nodok ;

        elseif (new.status='' and old.status!='') then
            IF EXISTS (	select nik from sc_mst.karyawan where coalesce(statuskepegawaian,'')!='KO' and bag_dept=new.kddept and nik not in
                       (select nik from sc_pk.final_report_pk_tmp where nodok=new.nodok)) THEN
                FOR vr_nik in select (coalesce(trim(nik),'')) from sc_mst.karyawan where coalesce(statuskepegawaian,'') != 'KO' and bag_dept=new.kddept and nik not in
                       (select nik from sc_pk.final_report_pk_tmp where nodok=new.nodok) order by nik asc
                    LOOP

                        insert into sc_pk.final_report_pk_tmp
                        (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,inputdate,inputby,status,fs1_kpi,fs2_kpi,fs1_kondite,fs2_kondite,fs1_pa,fs2_pa,fs1_inspek,fs2_inspek)
                            (select * from
                                (select  new.branch,'AR'::text as idbu,new.nodok as nodok,new.periode as periode,nik,nik_atasan as nikatasan1,nik_atasan2 as nikatasan2 ,to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,new.nodok,'I'::text,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric
                                 from sc_mst.karyawan where coalesce(statuskepegawaian,'')!='KO'
                                ) as x where nik=vr_nik
                             ORDER BY periode,nik);
                        
                        vr_range_periode:= vr_endPeriode::NUMERIC - vr_startPeriode::NUMERIC;
						vr_total_periode:= (SELECT count(*) FROM sc_pk.kpi_trx_mst where nik=vr_nik and periode BETWEEN vr_startPeriode AND vr_endPeriode);		
						
						IF vr_range_periode = vr_total_periode THEN 
				        	vr_kpi_score := (SELECT round(avg(coalesce(kpi_score::numeric,0)),2) from sc_pk.kpi_trx_mst where nik=vr_nik and periode BETWEEN vr_startPeriode AND vr_endPeriode);
				      	ELSEIF vr_range_periode > vr_total_periode AND vr_total_periode != 0 THEN
				        	vr_kpi_score:= 0;
				        	FOR vr_lperiode IN SELECT periode FROM sc_pk.kpi_trx_mst WHERE nik=vr_nik AND periode BETWEEN vr_startPeriode AND vr_endPeriode
					        LOOP
					            vr_kpi_score:= vr_kpi_score + (SELECT COALESCE(kpi_score::numeric,0) FROM sc_pk.kpi_trx_mst WHERE nik=vr_nik AND periode = vr_lperiode);
					     	END LOOP;
					     	vr_kpi_score:= round(vr_kpi_score/vr_total_periode,2);
				      	ELSE
				      		vr_kpi_score:= 0;
					  	END IF;

                        update  sc_pk.final_report_pk_tmp set
			            fs1_kpi=vr_kpi_score,
			            fs1_kondite=(select coalesce(b.value2::numeric,0) from sc_pk.kondite_trx_rekap a left outer join sc_pk.m_bobot b on a.f_ktg_fs=b.value2 and b.kdcategory='KONDITE' where nik=vr_nik and periode=new.periode),
			            fs1_pa=(select coalesce(f_value_ktg::numeric,0) from sc_pk.pa_form_pa_trx_mst where nik=vr_nik and periode=new.periode),
						status=''
						where nik=vr_nik and periode=new.periode;

                        RETURN vr_nik;
                    END LOOP;

            ELSE
                update  sc_pk.final_report_pk_tmp set status='' where coalesce(status,'') != '';
            END IF;

            vr_countdtl := count(*) from sc_pk.final_report_pk_tmp where nodok=new.nodok;
            select sum(ttls1::numeric),sum(ttls2::numeric) into vr_sumttls1,vr_sumttls2 from sc_pk.final_report_pk_tmp where nodok=new.nodok;

            update  sc_pk.rekap_final_report_pk_tmp set
	            ttls1=round(vr_sumttls1/vr_countdtl),
	            ktgs1=(select kdvalue from sc_pk.m_bobot where kdcategory='PA' and value1::numeric=round(vr_sumttls1/vr_countdtl)) ,
	            ttls2=round(vr_sumttls1/vr_countdtl) ,
	            ktgs2=(select kdvalue from sc_pk.m_bobot where kdcategory='PA' and value1::numeric=round(vr_sumttls1/vr_countdtl))
            where periode=new.periode and nodok=new.nodok;
        end if;


        RETURN NEW;
    END IF;


    return new;

end;
$function$
;

-- Table Triggers

CREATE TRIGGER tr_rekap_final_report_pk_tmp AFTER
INSERT
    OR
UPDATE
    ON
    sc_pk.rekap_final_report_pk_tmp FOR EACH ROW EXECUTE PROCEDURE sc_pk.rekap_final_report_pk_tmp();

-- Permissions

ALTER TABLE sc_pk.rekap_final_report_pk_tmp OWNER TO postgres;
GRANT ALL ON TABLE sc_pk.rekap_final_report_pk_tmp TO postgres;


CREATE TABLE IF NOT EXISTS sc_pk.rekap_final_report_pk_trx (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	kddept bpchar(12) NOT NULL,
	ttls1 bpchar(20) NULL,
	ttls2 bpchar(20) NULL,
	ktgs1 bpchar(20) NULL,
	ktgs2 bpchar(20) NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	approvedate timestamp NULL,
	approveby bpchar(12) NULL,
	status bpchar(12) NULL,
	CONSTRAINT rekap_final_report_pk_trx_pkey PRIMARY KEY (branch, idbu, nodok, periode, kddept)
);

CREATE OR REPLACE FUNCTION sc_pk.rekap_final_report_pk_trx()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by Fiky ::18/07/2017
--update by Fiky ::06/11/2018
    vr_nomor char(30);
    vr_nik char(30);
    vr_cekprefix char(4);
    vr_nowprefix char(4);
    vr_countdtl numeric;
    vr_sumttls1 numeric;
    vr_sumttls2 numeric;
begin

    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        /* NO RESOURCE UPDATE */
        if (new.status='E' and old.status='A') then
            vr_nomor:='FSPK'||'/'||new.periode||'/'||new.kddept;

            insert into sc_pk.rekap_final_report_pk_tmp
            (branch,idbu,nodok,periode,kddept,ttls1,ttls2,ktgs1,ktgs2,description,inputdate,
             inputby,updatedate,updateby,approvedate,approveby,status)
                (select branch,idbu,new.updateby,periode,kddept,ttls1,ttls2,ktgs1,ktgs2,description,inputdate,
                        inputby,updatedate,updateby,approvedate,approveby,'E' as status from sc_pk.rekap_final_report_pk_trx where nodok=new.nodok);


            insert into sc_pk.final_report_pk_tmp
            (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fs1_inspek,fsk1_kpi,fsk1_kondite,fsk1_pa,fsk1_inspek,b1_kpi,
             b1_kondite,b1_pa,b1_inspek,ttls1,ktgs1,fs2_kpi,fs2_kondite,fs2_pa,fs2_inspek,fsk2_kpi,fsk2_kondite,fsk2_pa,fsk2_inspek,b2_kpi,b2_kondite,
             b2_pa,b2_inspek,ttls2,ktgs2,description,inputdate,inputby,updatedate,updateby,nodoktmp,status,p1_kpi,p2_kpi,p1_kondite,p2_kondite,p1_pa,p2_pa,p1_inspek,p2_inspek,kddept)

                (select branch,idbu,new.updateby  as nodok,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fs1_inspek,fsk1_kpi,fsk1_kondite,fsk1_pa,fsk1_inspek,b1_kpi,
                        b1_kondite,b1_pa,b1_inspek,ttls1,ktgs1,fs2_kpi,fs2_kondite,fs2_pa,fs2_inspek,fsk2_kpi,fsk2_kondite,fsk2_pa,fsk2_inspek,b2_kpi,b2_kondite,
                        b2_pa,b2_inspek,ttls2,ktgs2,description,inputdate,inputby,updatedate,updateby,nodoktmp,'I' as status,p1_kpi,p2_kpi,p1_kondite,p2_kondite,p1_pa,p2_pa,p1_inspek,p2_inspek,kddept
                 from sc_pk.final_report_pk where nodok=new.nodok);

            delete from sc_mst.trxerror where userid=new.nodok;
            insert into sc_mst.trxerror
            (userid,errorcode,nomorakhir1,modul) values (new.updateby,0,new.updateby,'PKPA');


        elseif (new.status='A1' and old.status='A') then
            vr_nomor:='FSPK'||'/'||new.periode||'/'||new.kddept;

            insert into sc_pk.rekap_final_report_pk_tmp
            (branch,idbu,nodok,periode,kddept,ttls1,ttls2,ktgs1,ktgs2,description,inputdate,
             inputby,updatedate,updateby,approvedate,approveby,status)
                (select branch,idbu,new.approveby,periode,kddept,ttls1,ttls2,ktgs1,ktgs2,description,inputdate,
                        inputby,updatedate,updateby,approvedate,approveby,'A' as status from sc_pk.rekap_final_report_pk_trx where nodok=new.nodok);


            insert into sc_pk.final_report_pk_tmp
            (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fs1_inspek,fsk1_kpi,fsk1_kondite,fsk1_pa,fsk1_inspek,b1_kpi,
             b1_kondite,b1_pa,b1_inspek,ttls1,ktgs1,fs2_kpi,fs2_kondite,fs2_pa,fs2_inspek,fsk2_kpi,fsk2_kondite,fsk2_pa,fsk2_inspek,b2_kpi,b2_kondite,
             b2_pa,b2_inspek,ttls2,ktgs2,description,inputdate,inputby,updatedate,updateby,nodoktmp,status,p1_kpi,p2_kpi,p1_kondite,p2_kondite,p1_pa,p2_pa,p1_inspek,p2_inspek,kddept)

                (select branch,idbu,new.approveby  as nodok,periode,nik,nikatasan1,nikatasan2,fs1_kpi,fs1_kondite,fs1_pa,fs1_inspek,fsk1_kpi,fsk1_kondite,fsk1_pa,fsk1_inspek,b1_kpi,
                        b1_kondite,b1_pa,b1_inspek,ttls1,ktgs1,fs2_kpi,fs2_kondite,fs2_pa,fs2_inspek,fsk2_kpi,fsk2_kondite,fsk2_pa,fsk2_inspek,b2_kpi,b2_kondite,
                        b2_pa,b2_inspek,ttls2,ktgs2,description,inputdate,inputby,updatedate,updateby,nodoktmp,'A' as status,p1_kpi,p2_kpi,p1_kondite,p2_kondite,p1_pa,p2_pa,p1_inspek,p2_inspek,kddept
                 from sc_pk.final_report_pk where nodok=new.nodok);

            delete from sc_mst.trxerror where userid=new.nodok;
            insert into sc_mst.trxerror
            (userid,errorcode,nomorakhir1,modul) values (new.approveby,0,new.approveby,'PKPA');



        end if;


        RETURN NEW;
    END IF;


    return new;

end;
$function$
;

-- Table Triggers

CREATE TRIGGER tr_rekap_final_report_pk_tmp AFTER
INSERT
    OR
UPDATE
    ON
    sc_pk.rekap_final_report_pk_trx FOR EACH ROW EXECUTE PROCEDURE sc_pk.rekap_final_report_pk_trx();

-- Permissions

ALTER TABLE sc_pk.rekap_final_report_pk_trx OWNER TO postgres;
GRANT ALL ON TABLE sc_pk.rekap_final_report_pk_trx TO postgres;