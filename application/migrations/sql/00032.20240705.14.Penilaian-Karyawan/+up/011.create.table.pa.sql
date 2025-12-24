CREATE TABLE IF NOT EXISTS sc_pk.pa_form_pa_tmp_dtl (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	kdaspek bpchar(12) NOT NULL,
	kdkriteria bpchar(12) NOT NULL,
	nik bpchar(12) NOT NULL,
	tpa bpchar(12) NOT NULL,
	nomor bpchar(12) NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	value1 varchar NULL,
	value2 varchar NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	status bpchar(12) NULL,
	CONSTRAINT pa_form_pa_tmp_pkey PRIMARY KEY (branch, idbu, nodok, periode, kdaspek, kdkriteria, nik)
);

CREATE OR REPLACE FUNCTION sc_pk.tr_pa_form_pa_tmp_dtl()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
	--created by Fiky ::18/07/2017
	--modified by DK ::13/12/2023
declare
    vr_nomor char(20);
    vr_cekprefix char(4);
    vr_nowprefix char(4);
begin

    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        update sc_pk.pa_form_pa_tmp_mst a set
          ttlvalue1=b.ttlvalue1,
          ttlvalue2=b.ttlvalue2,
          f_value=b.f_value,
          f_value_ktg=b.f_value_ktg,
          f_kdvalue_ktg=(select coalesce(kdvalue,'') from sc_pk.m_bobot where kdcategory='PA' and round(b.f_value_ktg,2) BETWEEN value2::NUMERIC AND value1::NUMERIC),
          f_desc_ktg=(select coalesce(description,'') from sc_pk.m_bobot where kdcategory='PA' and round(b.f_value_ktg,2) BETWEEN value2::NUMERIC AND value1::NUMERIC)
        from (select nodok,nik,periode,round(sum(value1::numeric),2) as ttlvalue1,round(sum(value2::numeric),2) as ttlvalue2,
	        round(sum(value1::numeric),2)+round(sum(value2::numeric),2) as f_value,
	        round(((sum(value1::numeric))+(sum(value2::numeric)))/(count(nodok)+count(nodok)),2) as f_value_ktg
            from sc_pk.pa_form_pa_tmp_dtl where nodok=new.nodok and nik=new.nik and periode=new.periode
            group by nodok,nik,periode) b where a.nodok=b.nodok and a.nik=b.nik and a.periode=b.periode and
            a.nodok=new.nodok and a.nik=new.nik and a.periode=new.periode;

        if (new.status='F' and old.status='I') then
            
        end if;

        RETURN NEW;
    END IF;

    return new;

end;
$function$
;


-- Table Triggers

CREATE TRIGGER tr_pa_form_pa_tmp_dtl AFTER
INSERT
    OR
UPDATE
    ON
    sc_pk.pa_form_pa_tmp_dtl FOR EACH ROW EXECUTE PROCEDURE sc_pk.tr_pa_form_pa_tmp_dtl();

CREATE TABLE IF NOT EXISTS sc_pk.pa_form_pa_tmp_mst (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	nik bpchar(12) NOT NULL,
	tpa bpchar(12) NOT NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	ttlvalue1 varchar NULL,
	ttlvalue2 varchar NULL,
	f_value varchar NULL,
	f_value_ktg varchar NULL,
	description text NULL,
	note text NULL,
	suggestion text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	nodoktmp varchar NULL,
	status bpchar(12) NULL,
	f_kdvalue_ktg varchar NULL,
	f_desc_ktg varchar NULL,
	CONSTRAINT pa_form_pa_tmp_mst_pkey PRIMARY KEY (branch, idbu, nodok, periode, nik)
);

CREATE OR REPLACE FUNCTION sc_pk.tr_pa_form_pa_tmp_mst()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by Fiky ::18/07/2017
--modified by DK ::10/07/2024
    vr_nomor varchar;
    vr_cekprefix char(4);
    vr_nowprefix char(4);
    vr_count_option numeric;
begin

    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        /* NO RESOURCE UPDATE */
        vr_count_option:=count(*) from sc_mst.option where kdoption='PKPAAHR' and status='T' and value1='T';

        if (new.status='F' and old.status='I') then
            vr_nomor:='PA/'||new.periode||'/'||new.nik;

            if ((select count(*) from sc_pk.pa_form_pa_tmp_dtl where status='R2' and nodok=new.nodok and nik=new.nik)>=11 and vr_count_option>0)	then

                insert into sc_pk.pa_form_pa_trx_mst
                (branch,idbu,nodok,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,status,f_kdvalue_ktg,f_desc_ktg)
                    (select branch,idbu,vr_nomor,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,'P' as status,f_kdvalue_ktg,f_desc_ktg
                     from sc_pk.pa_form_pa_tmp_mst where nodok=new.nodok and nik=new.nik);

                insert into sc_pk.pa_form_pa_trx_dtl
                (branch,idbu,nodok,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status)
                    (select branch,idbu,vr_nomor,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,'P' AS status
                     from sc_pk.pa_form_pa_tmp_dtl where nodok=new.nodok and nik=new.nik);
            elseif ((select count(*) from sc_pk.pa_form_pa_tmp_dtl where status='R2' and nodok=new.nodok and nik=new.nik)>=11 and vr_count_option=0)	then

                insert into sc_pk.pa_form_pa_trx_mst
                (branch,idbu,nodok,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,status,f_kdvalue_ktg,f_desc_ktg)
                    (select branch,idbu,vr_nomor,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,'A' as status,f_kdvalue_ktg,f_desc_ktg
                     from sc_pk.pa_form_pa_tmp_mst where nodok=new.nodok and nik=new.nik);

                insert into sc_pk.pa_form_pa_trx_dtl
                (branch,idbu,nodok,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status)
                    (select branch,idbu,vr_nomor,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status
                     from sc_pk.pa_form_pa_tmp_dtl where nodok=new.nodok and nik=new.nik);
            else

                insert into sc_pk.pa_form_pa_trx_mst
                (branch,idbu,nodok,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,status,f_kdvalue_ktg,f_desc_ktg)
                    (select branch,idbu,vr_nomor,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,'A' as status,f_kdvalue_ktg,f_desc_ktg
                     from sc_pk.pa_form_pa_tmp_mst where nodok=new.nodok and nik=new.nik);


                insert into sc_pk.pa_form_pa_trx_dtl
                (branch,idbu,nodok,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status)
                    (select branch,idbu,vr_nomor,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status
                     from sc_pk.pa_form_pa_tmp_dtl where nodok=new.nodok and nik=new.nik);
            end if;

            delete from sc_pk.pa_form_pa_tmp_mst where nodok=new.nodok and nik=new.nik;
            delete from sc_pk.pa_form_pa_tmp_dtl where nodok=new.nodok and nik=new.nik;

        elseif (new.status='F' and old.status='E') then
            vr_nomor:='PA/'||new.periode||'/'||new.nik;
            delete from sc_pk.pa_form_pa_trx_mst where nodok=vr_nomor and nik=new.nik;
            delete from sc_pk.pa_form_pa_trx_dtl where nodok=vr_nomor and nik=new.nik;

            if ((select count(*) from sc_pk.pa_form_pa_tmp_dtl where status='R2' and nodok=new.nodok and nik=new.nik)>=11 and vr_count_option>0)	then

                insert into sc_pk.pa_form_pa_trx_mst
                (branch,idbu,nodok,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,status,f_kdvalue_ktg,f_desc_ktg)
                    (select branch,idbu,vr_nomor,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,'P' as status,f_kdvalue_ktg,f_desc_ktg
                     from sc_pk.pa_form_pa_tmp_mst where nodok=new.nodok and nik=new.nik);

                insert into sc_pk.pa_form_pa_trx_dtl
                (branch,idbu,nodok,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status)
                    (select branch,idbu,vr_nomor,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,'P' AS status
                     from sc_pk.pa_form_pa_tmp_dtl where nodok=new.nodok and nik=new.nik);

            elseif ((select count(*) from sc_pk.pa_form_pa_tmp_dtl where status='R2' and nodok=new.nodok and nik=new.nik)>=11 and vr_count_option=0)	then

                insert into sc_pk.pa_form_pa_trx_mst
                (branch,idbu,nodok,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,status,f_kdvalue_ktg,f_desc_ktg)
                    (select branch,idbu,vr_nomor,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,'A' as status,f_kdvalue_ktg,f_desc_ktg
                     from sc_pk.pa_form_pa_tmp_mst where nodok=new.nodok and nik=new.nik);

                insert into sc_pk.pa_form_pa_trx_dtl
                (branch,idbu,nodok,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status)
                    (select branch,idbu,vr_nomor,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status
                     from sc_pk.pa_form_pa_tmp_dtl where nodok=new.nodok and nik=new.nik);
            else

                insert into sc_pk.pa_form_pa_trx_mst
                (branch,idbu,nodok,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,status,f_kdvalue_ktg,f_desc_ktg)
                    (select branch,idbu,vr_nomor,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,'A' as status,f_kdvalue_ktg,f_desc_ktg
                     from sc_pk.pa_form_pa_tmp_mst where nodok=new.nodok and nik=new.nik);


                insert into sc_pk.pa_form_pa_trx_dtl
                (branch,idbu,nodok,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status)
                    (select branch,idbu,vr_nomor,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status
                     from sc_pk.pa_form_pa_tmp_dtl where nodok=new.nodok and nik=new.nik);
            end if;

            delete from sc_pk.pa_form_pa_tmp_mst where nodok=new.nodok and nik=new.nik;
            delete from sc_pk.pa_form_pa_tmp_dtl where nodok=new.nodok and nik=new.nik;
            
        end if;


        RETURN NEW;
    END IF;


    return new;

end;
$function$
;


-- Table Triggers

CREATE TRIGGER tr_pa_form_pa_tmp_mst AFTER
INSERT
    OR
UPDATE
    ON
    sc_pk.pa_form_pa_tmp_mst FOR EACH ROW EXECUTE PROCEDURE sc_pk.tr_pa_form_pa_tmp_mst();


CREATE TABLE IF NOT EXISTS sc_pk.pa_form_pa_trx_dtl (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	kdaspek bpchar(12) NOT NULL,
	kdkriteria bpchar(12) NOT NULL,
	nik bpchar(12) NOT NULL,
	tpa bpchar(12) NOT NULL,
	nomor bpchar(12) NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	value1 varchar NULL,
	value2 varchar NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	status bpchar(12) NULL,
	CONSTRAINT pa_form_pa_trx_dtl_pkey PRIMARY KEY (branch, idbu, nodok, periode, kdaspek, kdkriteria, nik)
);


CREATE TABLE IF NOT EXISTS sc_pk.pa_form_pa_trx_mst (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok varchar NOT NULL,
	periode varchar NOT NULL,
	nik bpchar(12) NOT NULL,
	tpa bpchar(12) NOT NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	ttlvalue1 varchar NULL,
	ttlvalue2 varchar NULL,
	f_value varchar NULL,
	f_value_ktg varchar NULL,
	description text NULL,
    note text NULL,
	suggestion text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	nodoktmp varchar NULL,
	status bpchar(12) NULL,
	f_kdvalue_ktg varchar NULL,
	f_desc_ktg varchar NULL,
	CONSTRAINT pa_form_pa_trx_mst_pkey PRIMARY KEY (branch, idbu, nodok, periode, nik)
);

CREATE OR REPLACE FUNCTION sc_pk.tr_pa_form_pa_trx_mst()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
declare
--created by Fiky ::18/07/2017
--modified by DK ::06/12/2023
    vr_nomor char(20);
    vr_cekprefix char(4);
    vr_nowprefix char(4);
begin
    IF TG_OP ='INSERT' THEN

        RETURN NEW;
    ELSEIF TG_OP ='UPDATE' THEN
        if (new.status='E' and old.status='A') then
            insert into sc_pk.pa_form_pa_tmp_mst
            (branch,idbu,nodok,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodoktmp,status,f_kdvalue_ktg,f_desc_ktg)
                (select branch,idbu,NEW.UPDATEBY,periode,nik,tpa,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,description,note,suggestion,inputdate,inputby,updatedate,updateby,nodok,'E' as status,f_kdvalue_ktg,f_desc_ktg
                 from sc_pk.pa_form_pa_trx_mst where nodok=new.nodok and nik=new.nik);
            insert into sc_pk.pa_form_pa_tmp_dtl
            (branch,idbu,nodok,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status)
                (select branch,idbu,NEW.UPDATEBY,periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2,description,inputdate,inputby,updatedate,updateby,status
                 from sc_pk.pa_form_pa_trx_dtl where nodok=new.nodok and nik=new.nik);

		ELSEIF (NEW.status='P' AND OLD.status <> 'P') THEN 
			UPDATE sc_pk.pa_form_pa_trx_dtl 
			SET status = 'P'
			WHERE nodok = NEW.nodok;
		
        end if;

        RETURN NEW;
    END IF;

    return new;

end;
$function$
;


-- Table Triggers

CREATE TRIGGER tr_pa_form_pa_trx_mst AFTER
INSERT
    OR
UPDATE
    ON
    sc_pk.pa_form_pa_trx_mst FOR EACH ROW EXECUTE PROCEDURE sc_pk.tr_pa_form_pa_trx_mst();
