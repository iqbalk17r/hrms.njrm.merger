CREATE TABLE IF NOT EXISTS sc_pk.kpi_tmp_mst (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok bpchar(20) NOT NULL,
	periode bpchar(12) NOT NULL,
	nik bpchar(12) NOT NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	kpi_point numeric NULL,
	kpi_score numeric NULL,
	kpi_ktg_fs bpchar(20) NULL,
	kpi_desc_fs bpchar(20) NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	nodoktmp bpchar(20) NULL,
	status bpchar(12) NULL,
	CONSTRAINT kpi_tmp_mst_pkey PRIMARY KEY (branch, idbu, nodok, periode, nik)
);

CREATE OR REPLACE FUNCTION sc_pk.tr_kpi_tmp_mst()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
	--created by dk ::04/11/2023
	--modified by DK ::14/12/2023
declare
    vr_nomor char(20);
begin

    IF TG_OP ='INSERT' then
    	vr_nomor:='KPI/'||new.periode||'/'||new.nik;
		insert into sc_pk.kpi_trx_mst (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,kpi_score,kpi_point,kpi_ktg_fs,kpi_desc_fs,inputdate,inputby,status)
		select a.branch,a.idbu,vr_nomor,a.periode,a.nik,b.nik_atasan,b.nik_atasan2,round(a.kpi_score,2),a.kpi_point,c.kdvalue as kpi_ktg_fs,
		c.description as kpi_desc_fs, a.inputdate, a.inputby, a.status 
		from sc_pk.kpi_tmp_mst a 
		join sc_mst.karyawan b on a.nik = b.nik 
		LEFT OUTER JOIN sc_pk.m_bobot c ON c.kdcategory = 'KPI' AND round(a.kpi_score,2) BETWEEN c.value2::NUMERIC AND c.value1::numeric
		where a.nodok = new.nodok and a.nik = new.nik and a.periode = new.periode;
		
		delete from sc_pk.kpi_tmp_mst where nodok = new.nodok and periode = new.periode and nik = new.nik;
	
    END IF; 
   
    return new;

end;
$function$
;


-- Table Triggers

CREATE TRIGGER tr_kpi_tmp_mst AFTER
INSERT
    ON
    sc_pk.kpi_tmp_mst FOR EACH ROW EXECUTE PROCEDURE sc_pk.tr_kpi_tmp_mst();


CREATE TABLE IF NOT EXISTS sc_pk.kpi_trx_mst (
	branch bpchar(12) NOT NULL,
	idbu bpchar(12) NOT NULL,
	nodok bpchar(20) NOT NULL,
	periode bpchar(12) NOT NULL,
	nik bpchar(12) NOT NULL,
	nikatasan1 bpchar(12) NULL,
	nikatasan2 bpchar(12) NULL,
	kpi_point numeric NULL,
	kpi_score numeric NULL,
	kpi_ktg_fs bpchar(20) NULL,
	kpi_desc_fs bpchar(20) NULL,
	description text NULL,
	inputdate timestamp NULL,
	inputby bpchar(12) NULL,
	updatedate timestamp NULL,
	updateby bpchar(12) NULL,
	nodoktmp bpchar(20) NULL,
	status bpchar(12) NULL,
	CONSTRAINT kpi_trx_mst_pkey PRIMARY KEY (branch, idbu, nodok, periode, nik)
);

CREATE OR REPLACE FUNCTION sc_pk.tr_kpi_trx_mst()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
	--created by dk ::04/11/2023
	--modified by DK ::14/12/2023
declare
    vr_nomor char(20);
begin

    IF TG_OP ='UPDATE' then
		update sc_pk.kpi_trx_mst a
		set kpi_ktg_fs = c.kdvalue,
			kpi_desc_fs = c.description
		from sc_pk.m_bobot c where c.kdcategory = 'KPI' AND round(a.kpi_score,2) BETWEEN c.value2::NUMERIC AND c.value1::numeric
			AND a.nodok = old.nodok and a.nik = old.nik and a.periode = old.periode;
			
    END IF; 
   
    return new;

end;
$function$
;

-- Table Triggers

CREATE TRIGGER tr_kpi_trx_mst AFTER
UPDATE
    ON
    sc_pk.kpi_trx_mst FOR EACH ROW
    WHEN ((new.kpi_score IS DISTINCT
FROM
    old.kpi_score)) EXECUTE PROCEDURE sc_pk.tr_kpi_trx_mst();

