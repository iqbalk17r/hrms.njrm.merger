DROP FUNCTION IF EXISTS sc_trx.adjust_employee_leave();
CREATE OR REPLACE FUNCTION sc_trx.adjust_employee_leave()
    RETURNS varchar AS $$
DECLARE
    --author:: RKM
    done BOOLEAN DEFAULT FALSE;
    last_check varchar;
    emp_id varchar;
    emp_join_date DATE;
    emp_entry_date_limit DATE;
    emp_leave_last INT;
    emp_leave_adjusment INT;
    emp_record RECORD;
    count_selected INT;
    count_now INT;
    -- Declare a cursor to iterate through employees
BEGIN

    IF NOT EXISTS (SELECT FROM public.function_log WHERE function_name = 'sc_trx.adjust_employee_leave' AND actived) THEN
        emp_entry_date_limit := coalesce(value1, '2022-01-15')::date AS value1 FROM sc_mst.option WHERE kdoption = 'EMPLOYEE:ENTRY:DATE' AND group_option = 'CUTI';
        count_now = 0;
        count_selected := count(*) FROM sc_mst.karyawan WHERE TRUE

                                                          AND statuskepegawaian <> 'KO'
                                                          AND COALESCE(UPPER(grouppenggajian), '') != 'P0'
                                                          AND (
                        tglmasukkerja <= TO_CHAR(now()::DATE - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                        tglmasukkerja <= TO_CHAR((now()::DATE + INTERVAL '1 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                        tglmasukkerja <= TO_CHAR((now()::DATE + INTERVAL '2 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                        tglmasukkerja <= TO_CHAR((now()::DATE + INTERVAL '3 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                        tglmasukkerja <= TO_CHAR((now()::DATE + INTERVAL '4 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE
                );
        -- Start looping through employees
        FOR emp_record IN SELECT nik, tglmasukkerja, sisacuti FROM sc_mst.karyawan WHERE TRUE

                                                                                     AND statuskepegawaian <> 'KO'
                                                                                     AND COALESCE(UPPER(grouppenggajian), '') != 'P0'
                                                                                     AND (
                        tglmasukkerja <= TO_CHAR(now()::DATE - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                        tglmasukkerja <= TO_CHAR((now()::DATE + INTERVAL '1 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                        tglmasukkerja <= TO_CHAR((now()::DATE + INTERVAL '2 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                        tglmasukkerja <= TO_CHAR((now()::DATE + INTERVAL '3 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE OR
                        tglmasukkerja <= TO_CHAR((now()::DATE + INTERVAL '4 DAY') - INTERVAL '1 YEAR', 'YYYY-MM-DD')::DATE
                ) LOOP
                emp_id := emp_record.nik;
                emp_join_date := emp_record.tglmasukkerja;
                emp_leave_last := emp_record.sisacuti;
                emp_leave_adjusment = EXTRACT(month FROM age(concat(to_char(now(),'YYYY'),'-',to_char(emp_join_date,'MM-DD'))::date, to_char(now(),'YYYY-01-01')::date));
                -- Check if emp_leave_adjusment is 0 and set it to 12
                IF TO_DATE(concat(to_char(now(),'YYYY'),'-',to_char(emp_join_date,'MM-DD')), 'YYYY-MM-DD') <= TO_DATE(concat(to_char(now(),'YYYY'),'-',to_char(emp_join_date,'MM'),'-15'), 'YYYY-MM-DD') THEN
                    emp_leave_adjusment = emp_leave_adjusment;
                ELSE
                    emp_leave_adjusment = emp_leave_adjusment + 1;
                end if;
                -- Check the condition and perform actions accordingly
                IF emp_join_date <= emp_entry_date_limit THEN
                    -- If tgl_masukkerja is less than or equal to '2022-01-15'
                    -- Perform actions for condition 'a'
                    -- You can replace the following SELECT with your actual logic
                    INSERT INTO sc_trx.cuti_blc (
                        nik,
                        tanggal,
                        no_dokumen,
                        in_cuti,
                        out_cuti,
                        sisacuti,
                        doctype,
                        status
                    ) VALUES (
                                 emp_id,
                                 TO_CHAR(now(), 'YYYY-01-01 00:00:06')::TIMESTAMP ,
                                 concat('ADJ',to_char(now(), 'YYYY')),
                                 emp_leave_adjusment,
                                 0,
                                 emp_leave_last + emp_leave_adjusment,
                                 'IN',
                                 'ADJUSTMENT'
                             );


                    -- Add your logic here for condition 'a'
                ELSEIF emp_join_date > emp_entry_date_limit THEN
                    -- If tgl_masukkerja is greater than '2022-01-15'
                    -- Perform actions for condition 'b'
                    -- You can replace the following SELECT with your actual logic
                    INSERT INTO sc_trx.cuti_blc (
                        nik,
                        tanggal,
                        no_dokumen,
                        in_cuti,
                        out_cuti,
                        sisacuti,
                        doctype,
                        status
                    ) VALUES (
                                 emp_id,
                                 TO_CHAR(now(), 'YYYY-01-01 00:00:06')::TIMESTAMP ,
                                 concat('ADJ',to_char(now(), 'YYYY')),
                                 emp_leave_adjusment,
                                 0,
                                 emp_leave_last + emp_leave_adjusment,
                                 'IN',
                                 'ADJUSTMENT'
                             );
                    -- Add your logic here for condition 'b'
                END IF;

                -- Perform other adjustments on employee leave based on emp_id
                -- Add your common logic here for adjusting leave
                count_now := count_now + 1;
            END LOOP;
        IF count_now = count_selected then
            insert INTO "public".function_log(
                function_name,
                actived,
                actived_by,
                actived_date
            ) VALUES (
                         'sc_trx.adjust_employee_leave',
                         true,
                         'SYSTEM',
                         NOW()
                     );
            RETURN 1 ; -- Replace with appropriate return value
        else
--             rollback ;
            RETURN 0 ;
        end if;
    ELSE
        RETURN 0;
    END IF;
END;
$$ LANGUAGE plpgsql;