

CREATE OR REPLACE FUNCTION sc_pk.final_report_pk(vr_nama character, vr_periode character, vr_nik character)
 RETURNS SETOF void
 LANGUAGE plpgsql
AS $function$
--create by Fiky Ashariza
--12-01-2018
--FINAL SCORE ALL
--update view max inspex max
--modified by DK::18/12/2023
DECLARE 
    vr_ceknik char(20);
    vr_nomor char(20);
    vr_branch char(6);
    vr_startPeriode varchar;
	vr_endPeriode varchar;
	vr_kpi_score NUMERIC;
	vr_lPeriode varchar;
	vr_range_periode NUMERIC;
	vr_total_periode NUMERIC;
BEGIN
	vr_startPeriode:= SUBSTRING(vr_periode, 1, 6);
	vr_endPeriode:= SUBSTRING(vr_periode, 8, 6);
    vr_branch:=coalesce(branch,'') from sc_mst.branch limit 1;

    IF NOT EXISTS (		select * from (
                             select nik,periode from sc_pk.final_report_pk where nik=vr_nik and periode=vr_periode and status in ('P','A')
                             union all
                             select nik,periode from sc_pk.final_report_pk_tmp where nik=vr_nik and periode=vr_periode) as x
                           where nik=vr_nik and periode=vr_periode
                           group by nik,periode) THEN
        insert into sc_pk.final_report_pk_tmp
        (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,inputdate,inputby,status,fs1_kpi,fs2_kpi,fs1_kondite,fs2_kondite,fs1_pa,fs2_pa,fs1_inspek,fs2_inspek)
            (select * from
                (select  vr_branch as branch,'AR'::text as idbu,vr_nama as nodok,vr_periode as periode,nik,nik_atasan as nikatasan1,nik_atasan2 as nikatasan2 ,to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,vr_nama,'I'::text,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric
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
            fs1_kondite=(select coalesce(b.value2::numeric,0) from sc_pk.kondite_trx_rekap a left outer join sc_pk.m_bobot b on a.f_ktg_fs=b.value2 and b.kdcategory='KONDITE' where nik=vr_nik and periode=vr_periode),
            fs1_pa=(select coalesce(f_value_ktg::numeric,0) from sc_pk.pa_form_pa_trx_mst where nik=vr_nik and periode=vr_periode),
            status=''
        where nik=vr_nik and periode=vr_periode;
    END IF;

    RETURN;
END;
$function$
;


CREATE OR REPLACE FUNCTION sc_pk.final_report_pk_perdept(vr_nama character, vr_periode character, vr_department character)
 RETURNS SETOF void
 LANGUAGE plpgsql
AS $function$
--create by Fiky Ashariza
--12-01-2018
--FINAL SCORE ALL
--update view max inspex max
--modified by DK::18/12/2023
DECLARE 
    vr_ceknik char(30);
    vr_branch char(6);
    vr_nik char(30);
    vr_startPeriode varchar;
	vr_endPeriode varchar;
	vr_kpi_score NUMERIC;
	vr_lPeriode varchar;
	vr_range_periode NUMERIC;
	vr_total_periode NUMERIC;
BEGIN
	vr_startPeriode:= SUBSTRING(vr_periode, 1, 6);
	vr_endPeriode:= SUBSTRING(vr_periode, 8, 6);
    vr_branch:=coalesce(branch,'') from sc_mst.branch limit 1;

    FOR vr_nik in select (coalesce(trim(nik),'')) from sc_mst.karyawan where coalesce(statuskepegawaian,'') != 'KO' and bag_dept=vr_department order by nik asc
        LOOP

            IF NOT EXISTS (		select * from (
                                     select nik,periode from sc_pk.final_report_pk where nik=vr_nik and periode=vr_periode and status in ('P')
                                     union all
                                     select nik,periode from sc_pk.final_report_pk_tmp where nik=vr_nik and periode=vr_periode) as x
                                   where nik=vr_nik and periode=vr_periode
                                   group by nik,periode) THEN
                
                delete from sc_pk.final_report_pk where nik=vr_nik and periode=vr_periode and status in ('A');
                delete from sc_pk.final_report_pk_tmp where nik=vr_nik and periode=vr_periode;

                insert into sc_pk.final_report_pk_tmp
                (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,inputdate,inputby,status,fs1_kpi,fs2_kpi,fs1_kondite,fs2_kondite,fs1_pa,fs2_pa,fs1_inspek,fs2_inspek)
                    (select * from
                        (select  vr_branch,'AR'::text as idbu,vr_nama as nodok,vr_periode as periode,nik,nik_atasan as nikatasan1,nik_atasan2 as nikatasan2 ,to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,vr_nama,'I'::text,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric
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
                    fs1_kondite=(select coalesce(b.value2::numeric,0) from sc_pk.kondite_trx_rekap a left outer join sc_pk.m_bobot b on a.f_ktg_fs=b.value2 and b.kdcategory='KONDITE' where nik=vr_nik and periode=vr_periode),
                    fs1_pa=(select coalesce(f_value_ktg::numeric,0) from sc_pk.pa_form_pa_trx_mst where nik=vr_nik and periode=vr_periode),
                    status=''
                where nik=vr_nik and periode=vr_periode;

                update sc_pk.final_report_pk_tmp set status='F'	where nik=vr_nik and nodok=vr_nama;
            END IF;

            RETURN NEXT vr_nik;
        END LOOP;

    RETURN;
END;
$function$
;


CREATE OR REPLACE FUNCTION sc_pk.final_report_pk_perdept_tmp(vr_nama character, vr_periode character, vr_department character)
 RETURNS SETOF void
 LANGUAGE plpgsql
AS $function$
--create by Fiky Ashariza
--12-01-2018
--FINAL SCORE ALL 
--update view max inspex max
--modified by DK::16/12/2023
DECLARE 
	vr_ceknik char(30);
	vr_branch char(6);
	vr_nik char(30);
	vr_nodok varchar;
	vr_startPeriode varchar;
	vr_endPeriode varchar;
	vr_kpi_score NUMERIC;
	vr_lPeriode varchar;
	vr_range_periode NUMERIC;
	vr_total_periode NUMERIC;	
BEGIN
	vr_startPeriode:= SUBSTRING(vr_periode, 1, 6);
	vr_endPeriode:= SUBSTRING(vr_periode, 8, 6);
	
	vr_branch:=coalesce(branch,'') from sc_mst.branch limit 1;
	IF NOT EXISTS (select * from sc_pk.rekap_final_report_pk_tmp where periode=vr_periode and kddept=vr_department) THEN
		insert into sc_pk.rekap_final_report_pk_tmp
		(branch,idbu,nodok,periode,kddept,inputdate,inputby,status)
		values
		(vr_branch,'AR',vr_nama,vr_periode,vr_department,to_char(now(),'YYYY-MM-DD HH24:MI:SS')::timestamp,vr_nama,'I');
	ELSE 	
		vr_nodok := nodok from sc_pk.rekap_final_report_pk_tmp where periode=vr_periode and kddept=vr_department;
	
		delete from sc_mst.trxerror where userid=vr_nama and modul='PKPA';
		insert into sc_mst.trxerror(userid,errorcode,modul,nomorakhir1) values (vr_nama,1,'PKPA', vr_nodok);
	END IF;
	
	FOR vr_nik in select (coalesce(trim(nik),'')) from sc_mst.karyawan where coalesce(statuskepegawaian,'') != 'KO' and bag_dept=vr_department order by nik asc
	LOOP
			IF NOT EXISTS (select * from (
						select nik,periode from sc_pk.final_report_pk where nik=vr_nik and periode=vr_periode and status in ('P')
						union all
						select nik,periode from sc_pk.final_report_pk_tmp where nik=vr_nik and periode=vr_periode) as x
						where nik=vr_nik and periode=vr_periode
						group by nik,periode) THEN 

				delete from sc_pk.final_report_pk where nik=vr_nik and periode=vr_periode and status in ('A');
				delete from sc_pk.final_report_pk_tmp where nik=vr_nik and periode=vr_periode;
				
				INSERT INTO sc_pk.final_report_pk_tmp 
					(branch, idbu, nodok, periode, nik, nikatasan1, nikatasan2, inputdate, inputby, status, fs1_kpi, fs1_kondite, fs1_pa, kddept)
				SELECT vr_branch AS branch, 'AR'::text AS idbu, vr_nama AS nodok, vr_periode AS periode, a.nik, a.nik_atasan AS nikatasan1, a.nik_atasan2 AS nikatasan2,
						to_char(now(), 'yyyy-mm-dd hh24:mi:ss')::timestamp, vr_nama AS inputby, 'I'::text AS status, 0::numeric AS fs1_kpi, 0::numeric AS fs1_kondite, 0::numeric AS fs1_pa, a.bag_dept
				FROM sc_mst.karyawan a
				WHERE coalesce(a.statuskepegawaian, '') != 'KO' and a.nik = vr_nik;
			
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
	            fs1_kondite=(select coalesce(f_ktg_fs::numeric,0) from sc_pk.kondite_trx_rekap where nik=vr_nik and periode=vr_periode),
	            fs1_pa=(select coalesce(f_value_ktg::numeric,0) from sc_pk.pa_form_pa_trx_mst where nik=vr_nik and periode=vr_periode),
				status=''
				where nik=vr_nik and periode=vr_periode;
		
			END IF;	

		RETURN NEXT vr_nik;
	END LOOP;

	RETURN;
END;
$function$
;


CREATE OR REPLACE FUNCTION sc_pk.hitung_final_report_pk_perdept_tmp(vr_nama character, vr_periode character, vr_department character)
 RETURNS SETOF void
 LANGUAGE plpgsql
AS $function$
    --create by Fiky Ashariza
    --12-01-2018
    --FINAL SCORE ALL
    --update view max inspex max
	--modified by DK::16/12/2023
DECLARE 
    vr_ceknik char(30);
    vr_branch char(6);
    vr_nik char(30);
	vr_startPeriode varchar;
   	vr_endPeriode varchar;
   	vr_kpi_score NUMERIC;
	vr_lPeriode varchar;
	vr_range_periode NUMERIC;
	vr_total_periode NUMERIC;
BEGIN 
	vr_startPeriode:= SUBSTRING(vr_periode, 1, 6);
	vr_endPeriode:= SUBSTRING(vr_periode, 8, 6);

    vr_branch:=coalesce(branch,'') from sc_mst.branch limit 1;
    IF NOT EXISTS (select * from sc_pk.rekap_final_report_pk_tmp where periode=vr_periode and kddept=vr_department) THEN
        insert into sc_pk.rekap_final_report_pk_tmp
        (branch,idbu,nodok,periode,kddept,inputdate,inputby,status)
        values
            (vr_branch,'AR',vr_nama,vr_periode,vr_department,to_char(now(),'YYYY-MM-DD HH24:MI:SS')::timestamp,vr_nama,'I');

    ELSE

        delete from sc_mst.trxerror where userid=vr_nama and modul='PKPA';
        insert into sc_mst.trxerror(userid,errorcode,modul,nomorakhir1) values (vr_nama,1,'PKPA',(select nodok from sc_pk.rekap_final_report_pk_tmp where periode=vr_periode and kddept=vr_department));

    END IF;

    FOR vr_nik in select (coalesce(trim(nik),'')) from sc_mst.karyawan where coalesce(statuskepegawaian,'') != 'KO' and bag_dept=vr_department order by nik asc
        LOOP
            IF NOT EXISTS (		select * from (
                                     select nik,periode from sc_pk.final_report_pk where nik=vr_nik and periode=vr_periode and status in ('P')
                                     union all
                                     select nik,periode from sc_pk.final_report_pk_tmp where nik=vr_nik and periode=vr_periode) as x
                                   where nik=vr_nik and periode=vr_periode
                                   group by nik,periode) THEN

                delete from sc_pk.final_report_pk where nik=vr_nik and periode=vr_periode and status in ('A');
                delete from sc_pk.final_report_pk_tmp where nik=vr_nik and periode=vr_periode;

                insert into sc_pk.final_report_pk_tmp
                (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,inputdate,inputby,status,fs1_kpi,fs2_kpi,fs1_kondite,fs2_kondite,fs1_pa,fs2_pa,fs1_inspek,fs2_inspek,kddept)
                    (select * from
                        (select  vr_branch,'AR'::text as idbu,vr_nama as nodok,vr_periode as periode,nik,nik_atasan as nikatasan1,nik_atasan2 as nikatasan2 ,to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,vr_nama,'I'::text,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,0::numeric,bag_dept
                         from sc_mst.karyawan where coalesce(statuskepegawaian,'')!='KO'
                        ) as x where nik=vr_nik
                     ORDER BY periode,nik);

            END IF;

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
		    
		    update  sc_pk.final_report_pk_tmp a1 set
		        fs1_kpi=vr_kpi_score,
		        fs1_kondite=(select coalesce(f_ktg_fs::numeric,0) from sc_pk.kondite_trx_rekap where nik=vr_nik and periode=vr_periode),
		        fs1_pa=(select coalesce(f_value_ktg::numeric,0) from sc_pk.pa_form_pa_trx_mst where nik=vr_nik and periode=vr_periode),
		        status=''
		    where a1.nik=vr_nik and a1.periode=vr_periode;
           
           RETURN NEXT vr_nik;
       END LOOP;

    RETURN;
END;
$function$
;

CREATE OR REPLACE FUNCTION sc_pk.pr_kondite_nik(vr_nama character, vr_periode character, vr_nik character)
 RETURNS SETOF void
 LANGUAGE plpgsql
AS $function$
    --create by Fiky Ashariza
	--12-01-2018
	--updated by DK 
	--05-12-2023
DECLARE 
	vr_ceknik char(12);

BEGIN

    IF EXISTS(select * from sc_pk.kondite_trx_mst where periode=vr_periode and nik=vr_nik) THEN
        delete from sc_mst.trxerror where userid=vr_nama and modul='PK_PA';
        insert into sc_mst.trxerror
        (userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
            (vr_nama,1,vr_periode,'','PK_PA');
    ELSE
        insert into sc_pk.kondite_tmp_mst (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,description,status,inputdate,inputby)
        select * from
            (select  'SBYNSA' as branch,'AR' as idbu,vr_nama,vr_periode as periode,nik,nik_atasan as nikatasan1,nik_atasan2 as nikatasan2 , '' AS description,'I'::text,to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,vr_nama
             from sc_mst.karyawan where coalesce(statuskepegawaian,'')!='KO'
            ) as x where nik=vr_nik
        ORDER BY periode,nik;

        update sc_pk.kondite_tmp_mst set
	         ttlvalueip = (select coalesce(sum(jumlah_cuti),0) from sc_trx.cuti_karyawan where to_char(tgl_mulai,'yyyymm')=vr_periode and tpcuti='A' AND STATUS_PTG='A2' and nik=vr_nik and coalesce(status,'')='P'),
	         ttlvaluesd = (select coalesce(sum(jumlah_cuti),0) from sc_trx.cuti_karyawan where to_char(tgl_mulai,'yyyymm')=vr_periode and tpcuti='B' and kdijin_khusus='AG' and nik=vr_nik and coalesce(status,'')='P'), 
	         ttlvalueal = (select count(*) from sc_trx.listlinkjadwalcuti where to_char(tgl,'yyyymm')=vr_periode and kdpokok='AL'  and nik=vr_nik),
	         ttlvaluetl  = (select count(*) from sc_trx.listlinkjadwalcuti where to_char(tgl,'yyyymm')=vr_periode and kdpokok='TL'  and nik=vr_nik), --TELAT
	         ttlvalueitl  = (select count(*) from sc_trx.ijin_karyawan where to_char(tgl_kerja,'yyyymm')=vr_periode and kdijin_absensi IN ('DT') and type_ijin = 'PB' and coalesce(status,'')='P' and nik=vr_nik), --IJIN TELAT
	         ttlvalueipa  = (select count(*) from sc_trx.ijin_karyawan where to_char(tgl_kerja,'yyyymm')=vr_periode and kdijin_absensi IN ('PA') and type_ijin = 'PB' and coalesce(status,'')='P' and nik=vr_nik), --IJIN PLG AWAL
	         ttlvaluect  = (select count(*) from sc_trx.listlinkjadwalcuti where to_char(tgl,'yyyymm')=vr_periode and kdpokok='CT'  and nik=vr_nik),
	         ttlvalueik  = (select count(*) from sc_trx.listlinkjadwalcuti where to_char(tgl,'yyyymm')=vr_periode and kdpokok='IK'  and nik=vr_nik),
	         ttlvaluesp1  = (select count(*) from sc_trx.sk_peringatan where to_char(startdate,'yyyymm')=vr_periode and tindakan='SP1' and nik=vr_nik),
	         ttlvaluesp2  = (select count(*) from sc_trx.sk_peringatan where to_char(startdate,'yyyymm')=vr_periode and tindakan='SP2' and nik=vr_nik),
	         ttlvaluesp3  = (select count(*) from sc_trx.sk_peringatan where to_char(startdate,'yyyymm')=vr_periode and tindakan='SP3' and nik=vr_nik),
	         status='' where nik=vr_nik and periode=vr_periode and nodok=vr_nama;
    END IF;

    RETURN;
END;
$function$
;


CREATE OR REPLACE FUNCTION sc_pk.pr_kondite_tmp_rekap(vr_nama character, vr_periode character, vr_nik character, vr_state character)
 RETURNS SETOF void
 LANGUAGE plpgsql
AS $function$
    --created by DK
	--04-12-2023
    --updateed by DK
	--13-12-2023
DECLARE 
	vr_ceknik char(12);
	vr_startPeriode char(6);
	vr_endPeriode char(6);

BEGIN
	vr_startPeriode := SUBSTRING(vr_periode FROM 1 FOR 6);
    vr_endPeriode := SUBSTRING(vr_periode FROM 8);
   
   IF vr_state ='INSERT' THEN
	    IF EXISTS(select * from sc_pk.kondite_trx_rekap where periode=vr_periode and nik=vr_nik) THEN
	        delete from sc_mst.trxerror where userid=vr_nama and modul='PK_PA';
	        insert into sc_mst.trxerror
	        (userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
	            (vr_nama,1,vr_periode,'','PK_PA');
	    ELSE
	        insert into sc_pk.kondite_tmp_rekap (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,description,status,inputdate,inputby)
	        select * from
	            (select  'SBYNSA' as branch,'AR' as idbu,vr_nama,vr_periode as periode,nik,nik_atasan as nikatasan1,nik_atasan2 as nikatasan2 , '' AS description,'I'::text,to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,vr_nama
	             from sc_mst.karyawan where coalesce(statuskepegawaian,'')!='KO'
	            ) as x where nik=vr_nik
	        ORDER BY periode,nik;
	    END IF;
    END IF;
	
   	update sc_pk.kondite_tmp_rekap set
	         f_score_k = round((SELECT avg(f_score_k::numeric) FROM sc_pk.kondite_tmp_mst WHERE nik=vr_nik and periode BETWEEN vr_startPeriode AND vr_endPeriode and nodok=vr_nama),2)
	where nik=vr_nik and periode=vr_periode and nodok=vr_nama;	
   
	update sc_pk.kondite_tmp_rekap set
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
     where nik=vr_nik and periode=vr_periode and nodok=vr_nama;	

    update sc_pk.kondite_tmp_rekap set
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
         	end
     where nik=vr_nik and periode=vr_periode and nodok=vr_nama;	
    RETURN;
END;
$function$
;


CREATE OR REPLACE FUNCTION sc_pk.pr_pk_generate_all_karyawan_kriteria(vr_periode character)
 RETURNS SETOF void
 LANGUAGE plpgsql
AS $function$
    --create by Fiky Ashariza
    --12-01-2018
DECLARE 
    vr_ceknik char(12);

BEGIN
    IF EXISTS(select * from sc_pk.pa_form_pa_trx where periode=vr_periode) THEN

        delete from sc_mst.trxerror where userid=new.nodok and modul='PK_PA';
        insert into sc_mst.trxerror
        (userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
            (vr_periode,1,vr_periode,'','PK_PA');
    ELSE

        insert into sc_pk.pa_form_pa_trx (  branch, idbu, periode,kdaspek,kdkriteria,nik,tpa, niktpa,value, description)
        select * from
            (select  branch,idbu,vr_periode as periode, kdaspek,kdkriteria,b.nik,'A1' AS tpa,nik_atasan as niktpa ,0 as value, description
             from sc_pk.m_aspek_kriteria a left outer join sc_mst.karyawan b on coalesce(b.statuskepegawaian,'')!='KO'
             union all
             select  branch,idbu,vr_periode as periode, kdaspek,kdkriteria,b.nik,'A2' AS tpa,nik_atasan2 as niktpa ,0 as value, description
             from sc_pk.m_aspek_kriteria a left outer join sc_mst.karyawan b on coalesce(b.statuskepegawaian,'')!='KO') as x
        ORDER BY periode,nik,tpa,kdaspek,kdkriteria;
    END IF;

    RETURN;
END;
$function$
;


CREATE OR REPLACE FUNCTION sc_pk.pr_pk_generate_all_karyawan_kriteria(vr_nama character, vr_periode character)
 RETURNS SETOF void
 LANGUAGE plpgsql
AS $function$
    --create by Fiky Ashariza
    --12-01-2018
DECLARE 
    vr_ceknik char(12);

BEGIN

    IF EXISTS(select * from sc_pk.pa_form_pa_trx where periode=vr_periode) THEN

        delete from sc_mst.trxerror where userid=vr_nama and modul='PK_PA';
        insert into sc_mst.trxerror
        (userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
            (vr_nama,1,vr_periode,'','PK_PA');
    ELSE

        insert into sc_pk.pa_form_pa_trx (  branch, idbu, periode,kdaspek,kdkriteria,nik,tpa, niktpa,value, description)
        select * from
            (select  branch,idbu,vr_periode as periode, kdaspek,kdkriteria,b.nik,'A1' AS tpa,nik_atasan as niktpa ,0 as value, description
             from sc_pk.m_aspek_kriteria a left outer join sc_mst.karyawan b on coalesce(b.statuskepegawaian,'')!='KO'
             union all
             select  branch,idbu,vr_periode as periode, kdaspek,kdkriteria,b.nik,'A2' AS tpa,nik_atasan2 as niktpa ,0 as value, description
             from sc_pk.m_aspek_kriteria a left outer join sc_mst.karyawan b on coalesce(b.statuskepegawaian,'')!='KO') as x
        ORDER BY periode,nik,tpa,kdaspek,kdkriteria;
    END IF;

    RETURN;
END;
$function$
;


CREATE OR REPLACE FUNCTION sc_pk.pr_pk_generate_nik(vr_nama character, vr_periode character, vr_nik character)
 RETURNS SETOF void
 LANGUAGE plpgsql
AS $function$
    --create by Fiky Ashariza
    --12-01-2018
    --modified by DK 
    --09-07-2024
DECLARE 
    vr_ceknik char(12);

BEGIN
    IF EXISTS(select * from sc_pk.pa_form_pa_trx_mst where periode=vr_periode and nik=vr_nik) THEN

        delete from sc_mst.trxerror where userid=vr_nama and modul='PK_PA';
        insert into sc_mst.trxerror
        (userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
            (vr_nama,1,vr_periode,'','PK_PA');
    ELSE

        insert into sc_pk.pa_form_pa_tmp_mst (  branch, idbu, nodok,periode,nik,tpa, nikatasan1,nikatasan2,ttlvalue1,ttlvalue2, description,status)
        select * from
            (select  'SBYNSA' as branch,'AR' as idbu,vr_nama,vr_periode as periode,nik,''::text as tpa,nik_atasan as nikatasan1,nik_atasan2 as nikatasan2 ,0::numeric as value1,0::numeric as value2, '' AS description,'I'::text
             from sc_mst.karyawan where coalesce(statuskepegawaian,'')!='KO'
            ) as x where nik=vr_nik
        ORDER BY periode,nik;

        insert into sc_pk.pa_form_pa_tmp_dtl (  branch, idbu,nodok, periode,kdaspek,kdkriteria,nik,tpa,nomor,nikatasan1,nikatasan2,value1,value2, description,status)
        select * from
            (select  a.branch,idbu,vr_nama,vr_periode as periode, kdaspek,kdkriteria,b.nik,''::text AS tpa,orderid as nomor,nik_atasan as nikatasan1,nik_atasan2 as nikatasan2 ,0::numeric as value1,0::numeric as value2, description,'I'::text
             from sc_pk.m_aspek_kriteria a left outer join sc_mst.karyawan b on coalesce(b.statuskepegawaian,'')!='KO'
             WHERE CASE 
                        WHEN b.lvl_jabatan IN (
                            SELECT unnest(string_to_array(VALUE1, ','))
                            FROM sc_mst.option 
                            WHERE kdoption IN ('PKPALE')
                        ) THEN 
                            a.kdkriteria NOT IN (
                            SELECT unnest(string_to_array(VALUE1, ','))
                                FROM sc_mst.option 
                                WHERE kdoption IN ('PKPAQE')
                            )
                        ELSE 
                            a.kdkriteria IS NOT NULL
                    END
            ) as x where nik=vr_nik
        ORDER BY periode,nik,tpa,kdaspek,kdkriteria;
    END IF;

    RETURN;
END;
$function$
;


CREATE OR REPLACE FUNCTION sc_pk.pr_report_final(vr_nama character, vr_periode character)
 RETURNS SETOF void
 LANGUAGE plpgsql
AS $function$
    --create by Fiky Ashariza
    --12-01-2018
DECLARE 
    vr_ceknik char(20);
    vr_nomor char(30);

BEGIN
    DELETE FROM sc_pk.pa_report_final where userid=vr_nama and periode=vr_periode;

    insert into sc_pk.pa_report_final
    (branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,userid)
        (select branch,idbu,nodok,periode,nik,nikatasan1,nikatasan2,ttlvalue1,ttlvalue2,f_value,f_value_ktg,vr_nama from sc_pk.pa_form_pa_trx_mst where status='P' and periode=vr_periode);

    FOR vr_ceknik in select (coalesce(trim(nik),'')) from sc_pk.pa_form_pa_trx_mst where periode=vr_periode order by nik asc
        LOOP
            --select * from sc_pk.pa_form_pa_trx_mst order by nik,kdkriteria asc
            FOR vr_nomor in select (coalesce(nomor,'')) from sc_pk.pa_form_pa_trx_dtl where nik=vr_ceknik and periode=vr_periode order by nik,kdkriteria asc
                LOOP
                    if (vr_nomor::integer=1) then
                        update sc_pk.pa_report_final a set na1=b.value1 , nb1=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=2) then
                        update sc_pk.pa_report_final a set na2=b.value1 , nb2=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=3) then
                        update sc_pk.pa_report_final a set na3=b.value1 , nb3=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=4) then
                        update sc_pk.pa_report_final a set na4=b.value1 , nb4=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=5) then
                        update sc_pk.pa_report_final a set na5=b.value1 , nb5=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=6) then
                        update sc_pk.pa_report_final a set na6=b.value1 , nb6=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=7) then
                        update sc_pk.pa_report_final a set na7=b.value1 , nb7=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=8) then
                        update sc_pk.pa_report_final a set na8=b.value1 , nb8=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=9) then
                        update sc_pk.pa_report_final a set na9=b.value1 , nb9=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=10) then
                        update sc_pk.pa_report_final a set na10=b.value1 , nb10=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=11) then
                        update sc_pk.pa_report_final a set na11=b.value1 , nb11=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=12) then
                        update sc_pk.pa_report_final a set na12=b.value1 , nb12=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    elseif (vr_nomor::integer=13) then
                        update sc_pk.pa_report_final a set na13=b.value1 , nb13=b.value2 from sc_pk.pa_form_pa_trx_dtl b where a.nik=b.nik and a.periode=b.periode and  b.nomor=vr_nomor and b.nik=vr_ceknik and b.periode=vr_periode;
                    end if;

                    RETURN NEXT vr_nomor;
                END LOOP;

            RETURN NEXT vr_ceknik;
        END LOOP;

    RETURN;
END;
$function$
;

