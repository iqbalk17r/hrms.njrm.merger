CREATE OR REPLACE FUNCTION sc_pk.pr_autogenerate_conditee(inputby character varying)
 RETURNS SETOF void
 LANGUAGE plpgsql
AS $function$
DECLARE
    employee_record RECORD;
    ttlvalueip INT;
    ttlvaluesd INT;
    ttlvalueal INT;
    ttlvaluetl INT;
    ttlvalueitl INT;
    ttlvalueipa INT;
    ttlvaluect INT;
    ttlvalueik INT;
    ttlvaluesp1 INT;
    ttlvaluesp2 INT;
    ttlvaluesp3 INT;
    vr_period varchar;
    vr_input_by varchar;
    conditee_temporary_recap_check INT;
    conditee_transaction_recap_check INT;
    conditee_temporary_master_check INT;
    conditee_transaction_master_check INT;
    vr_begin_date varchar;
BEGIN
    vr_input_by := inputby;
    vr_begin_date := case when coalesce(trim(value1),'') = '' THEN '2024-01-01' ELSE value1 END AS value1 from sc_mst.option where kdoption = 'BEGINDATE:APPRAISAL';
    FOR employee_record IN
        SELECT trim(nik) AS nik, tglmasukkerja FROM sc_mst.karyawan WHERE COALESCE(TRIM(statuskepegawaian),'') <> 'KO'  AND nik not in('5123100005')
        LOOP
            FOR vr_period IN (select
                                  TO_CHAR(date_series, 'YYYYMM') AS formatted_date
                              FROM generate_series(to_char(now(), vr_begin_date)::date, to_char(now(),'YYYY-MM-DD')::date, '1 month'::interval) AS date_series) loop
                    conditee_temporary_recap_check := count(nik) from sc_pk.kondite_tmp_rekap where trim(nik) = employee_record.nik AND periode = vr_period||'-'||vr_period;
                    conditee_transaction_recap_check := count(nik) from sc_pk.kondite_trx_rekap where trim(nik) = employee_record.nik AND periode = vr_period||'-'||vr_period;
                    conditee_temporary_master_check := count(nik) from sc_pk.kondite_tmp_mst where trim(nik) = employee_record.nik AND periode between vr_period AND vr_period;
                    conditee_transaction_master_check := count(nik) from sc_pk.kondite_trx_mst where trim(nik) = employee_record.nik AND periode between vr_period AND vr_period;
                    if to_char(employee_record.tglmasukkerja,'YYYYMM') <= vr_period then
                        if conditee_temporary_recap_check = 0 AND conditee_transaction_recap_check = 0 AND conditee_temporary_master_check = 0 AND conditee_transaction_master_check = 0 THEN
                            PERFORM sc_pk.pr_kondite_nik(vr_input_by, vr_period, employee_record.nik);
                            PERFORM sc_pk.pr_kondite_tmp_rekap(vr_input_by, vr_period||'-'||vr_period, employee_record.nik, 'INSERT');
                            update sc_pk.kondite_tmp_mst set status = '' where nodok = vr_input_by AND periode = vr_period AND nik = employee_record.nik;
                            PERFORM sc_pk.pr_kondite_tmp_rekap(vr_input_by, vr_period||'-'||vr_period, employee_record.nik, 'UPDATE');
                            update sc_pk.kondite_tmp_mst set status = 'F' where nodok = vr_input_by AND nik = employee_record.nik AND periode = vr_period;
                            update sc_pk.kondite_tmp_rekap set status = 'F' where nodok = vr_input_by AND nik = employee_record.nik AND periode = vr_period||'-'||vr_period;
                        end if;
                        if conditee_transaction_recap_check > 0 AND conditee_transaction_master_check > 0 then
                            update sc_pk.kondite_trx_mst set status = 'E',updateby = vr_input_by where nik = employee_record.nik AND periode = vr_period AND trim(status) = 'A';
                            update sc_pk.kondite_trx_rekap set status = 'E',updateby = vr_input_by where nik = employee_record.nik AND periode = vr_period||'-'||vr_period AND trim(status) = 'A';
                            update sc_pk.kondite_tmp_mst set status = '' where updateby = vr_input_by AND periode = vr_period AND nik = employee_record.nik AND status = 'E';
                            --PERFORM sc_pk.pr_kondite_tmp_rekap(vr_input_by, vr_period||'-'||vr_period, employee_record.nik, 'UPDATE');
                            update sc_pk.kondite_tmp_mst set status = 'F' where updateby = vr_input_by AND nik = employee_record.nik AND periode = vr_period AND trim(status) = 'E';
                            update sc_pk.kondite_tmp_rekap set status = 'F' where updateby = vr_input_by AND nik = employee_record.nik AND periode = vr_period||'-'||vr_period AND trim(status) = 'E';
                        end if;
                    end if;
                end loop;
            raise notice 'aaa %',employee_record.nik;
        END LOOP;

    RETURN ;
END;
$function$
;

--====================================================================================================--


CREATE OR REPLACE FUNCTION sc_pk.pr_autogenerate_conditee_recalculate_month_nik(
    inputby character varying,
    vr_nik character varying,
    begin_date character varying DEFAULT ('now'::text)::date)
  RETURNS SETOF void AS
$BODY$
DECLARE
    employee_record RECORD;
    ttlvalueip INT;
    ttlvaluesd INT;
    ttlvalueal INT;
    ttlvaluetl INT;
    ttlvalueitl INT;
    ttlvalueipa INT;
    ttlvaluect INT;
    ttlvalueik INT;
    ttlvaluesp1 INT;
    ttlvaluesp2 INT;
    ttlvaluesp3 INT;
    vr_period varchar;
    vr_input_by varchar;
    conditee_temporary_recap_check INT;
    conditee_transaction_recap_check INT;
    conditee_temporary_master_check INT;
    conditee_transaction_master_check INT;
    vr_begin_date varchar;
    vr_cut_off_date varchar;
BEGIN
    vr_input_by := inputby;
    vr_begin_date := begin_date;
    vr_cut_off_date := case when coalesce(trim(value1),'') = '' THEN '7' ELSE value1 END AS value1 from sc_mst.option where kdoption = 'AUTOAPPROVE:APPRAISAL';
    FOR employee_record IN
        SELECT trim(nik) AS nik, tglmasukkerja FROM sc_mst.karyawan WHERE COALESCE(TRIM(statuskepegawaian),'') <> 'KO' AND nik = vr_nik AND nik not in('5123100005')
        LOOP
            FOR vr_period IN (select
                                  TO_CHAR(date_series, 'YYYYMM') AS formatted_date
                              FROM generate_series(to_char(now(), vr_begin_date)::date, to_char(now(),'YYYY-MM-DD')::date, '1 month'::interval) AS date_series) loop
                    conditee_temporary_recap_check := count(nik) from sc_pk.kondite_tmp_rekap where trim(nik) = employee_record.nik AND periode = vr_period||'-'||vr_period;
                    conditee_transaction_recap_check := count(nik) from sc_pk.kondite_trx_rekap where trim(nik) = employee_record.nik AND periode = vr_period||'-'||vr_period;
                    conditee_temporary_master_check := count(nik) from sc_pk.kondite_tmp_mst where trim(nik) = employee_record.nik AND periode between vr_period AND vr_period;
                    conditee_transaction_master_check := count(nik) from sc_pk.kondite_trx_mst where trim(nik) = employee_record.nik AND periode between vr_period AND vr_period;
                    if to_char(employee_record.tglmasukkerja,'YYYYMM') <= vr_period then
                        if conditee_temporary_recap_check = 0 AND conditee_transaction_recap_check = 0 AND conditee_temporary_master_check = 0 AND conditee_transaction_master_check = 0 THEN
                            PERFORM sc_pk.pr_kondite_nik(vr_input_by, vr_period, employee_record.nik);
                            PERFORM sc_pk.pr_kondite_tmp_rekap(vr_input_by, vr_period||'-'||vr_period, employee_record.nik, 'INSERT');
                            update sc_pk.kondite_tmp_mst set status = '' where nodok = vr_input_by AND periode = vr_period AND nik = employee_record.nik;
                            PERFORM sc_pk.pr_kondite_tmp_rekap(vr_input_by, vr_period||'-'||vr_period, employee_record.nik, 'UPDATE');
                            update sc_pk.kondite_tmp_mst set status = 'F' where nodok = vr_input_by AND nik = employee_record.nik AND periode = vr_period;
                            update sc_pk.kondite_tmp_rekap set status = 'F' where nodok = vr_input_by AND nik = employee_record.nik AND periode = vr_period||'-'||vr_period;
                        end if;
                        if conditee_transaction_recap_check > 0 AND conditee_transaction_master_check > 0 then
                            delete from sc_pk.kondite_tmp_mst where nik = employee_record.nik AND periode = vr_period AND trim(status) = 'E';
                            update sc_pk.kondite_trx_mst set status = 'E',updateby = vr_input_by where nik = employee_record.nik AND periode = vr_period AND trim(status) = 'A';
--                             update sc_pk.kondite_trx_rekap set status = 'E',updateby = vr_input_by where nik = employee_record.nik AND periode = vr_period||'-'||vr_period AND trim(status) = 'A';
                            update sc_pk.kondite_tmp_mst set status = '' where updateby = vr_input_by AND periode = vr_period AND nik = employee_record.nik AND status = 'E';
                            --PERFORM sc_pk.pr_kondite_tmp_rekap(vr_input_by, vr_period||'-'||vr_period, employee_record.nik, 'UPDATE');
                            update sc_pk.kondite_tmp_mst set status = 'F' where updateby = vr_input_by AND nik = employee_record.nik AND periode = vr_period AND trim(status) = 'E';
--                             update sc_pk.kondite_tmp_rekap set status = 'F' where updateby = vr_input_by AND nik = employee_record.nik AND periode = vr_period||'-'||vr_period AND trim(status) = 'E';
                        end if;
                    end if;
                end loop;
--             raise notice 'aaa %',employee_record.nik;
            conditee_transaction_recap_check := count(nik) from sc_pk.kondite_trx_rekap where trim(nik) = employee_record.nik AND trim(status) = 'A' AND (SUBSTRING(periode FROM 1 FOR 6)::int < to_char(current_date,'YYYYMM')::int OR SUBSTRING(periode FROM 8)::int < to_char(current_date,'YYYYMM')::int );
            conditee_transaction_master_check := count(nik) from sc_pk.kondite_trx_mst where trim(nik) = employee_record.nik AND trim(status) = 'A' AND periode::int < to_char(current_date,'YYYYMM')::int;
            IF to_char(current_date,'DD')::INT = vr_cut_off_date::int THEN
                if conditee_transaction_recap_check > 0 AND conditee_transaction_master_check > 0 then
                    update sc_pk.kondite_trx_mst set status = 'P', updateby = 'SYSTEM', updatedate = to_char(now(), 'YYYY-MM-DD 00:00:01')::timestamp where nik = employee_record.nik AND trim(status) = 'A' AND periode::int < to_char(current_date,'YYYYMM')::int;
                    update sc_pk.kondite_trx_rekap set status = 'P', updateby = 'SYSTEM', updatedate = to_char(now(), 'YYYY-MM-DD 00:00:01')::timestamp where nik = employee_record.nik AND trim(status) = 'A' AND (SUBSTRING(periode FROM 1 FOR 6)::int < to_char(current_date,'YYYYMM')::int OR SUBSTRING(periode FROM 8)::int < to_char(current_date,'YYYYMM')::int );
                end if;
            END IF;
        END LOOP;

    RETURN ;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION sc_pk.pr_autogenerate_conditee_recalculate_month_nik(character varying, character varying, character varying)
  OWNER TO postgres;
