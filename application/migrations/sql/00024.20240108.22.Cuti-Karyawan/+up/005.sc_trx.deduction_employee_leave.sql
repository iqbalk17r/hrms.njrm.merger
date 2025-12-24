CREATE OR REPLACE FUNCTION sc_trx.deduction_employee_leave()
    RETURNS INT AS $$
DECLARE
    --author:: RKM
    done BOOLEAN DEFAULT FALSE;
    emp_id varchar;
    emp_join_date DATE;
    emp_entry_date_limit DATE;
    emp_leave_last INT;
    emp_leave_deduction INT;
    emp_record RECORD;
    count_selected INT;
    last_year_balance INT;
    sisa_cuti_lalu INT;
    count_now INT;
    -- Declare a cursor to iterate through employees
BEGIN
    count_now = 0;
    emp_entry_date_limit := coalesce(value1, '2022-01-15')::date AS value1 FROM sc_mst.option WHERE kdoption = 'EMPLOYEE:ENTRY:DATE' AND group_option = 'CUTI';
    count_selected := count(*) FROM sc_mst.karyawan WHERE TRUE

                                                      AND statuskepegawaian <> 'KO'
                                                      AND COALESCE(UPPER(grouppenggajian), '') != 'P0';
    IF NOT EXISTS (SELECT FROM public.function_log WHERE function_name = 'sc_trx.deduction_employee_leave' AND actived) THEN
        -- Start looping through employees
        FOR emp_record IN SELECT nik, tglmasukkerja, sisacuti FROM sc_mst.karyawan WHERE TRUE

                                                                                     AND statuskepegawaian <> 'KO'
                                                                                     AND COALESCE(UPPER(grouppenggajian), '') != 'P0'
            LOOP
                emp_id := emp_record.nik;
                emp_join_date := emp_record.tglmasukkerja;
                emp_leave_last := emp_record.sisacuti;
                --emp_leave_deduction := coalesce(sisacuti,0) - coalesce(in_cuti,0) FROM sc_trx.cuti_blc WHERE nik = emp_id AND doctype = 'IN' AND no_dokumen = 'ADJ2024';
                -- Check if emp_leave_adjusment is 0 and set it to 12
				emp_leave_deduction := coalesce(last_year_balanced, 0) - coalesce(out_balance, 0) as balance
                         from (select SUM(out_cuti) over (partition by nik) as out_balance,
                                      nik
                               from sc_trx.cuti_blc a
                               where TRUE
                                 AND nik = emp_id
                                 and tanggal <= '2024-03-01'::date
                                 AND tanggal >= '2024-01-01'::date
                                 and no_dokumen ilike '%CT%'
                               ORDER BY tanggal DESC
                               limit 1) as aa
                               left join lateral (
                             select coalesce(sisacuti, 0) - coalesce(in_cuti, 0) AS last_year_balanced,
                                    nik
                             from sc_trx.cuti_blc a
                             where TRUE
                               AND nik = emp_id
                               AND no_dokumen = 'ADJ2024'
                             ORDER BY tanggal DESC
                             LIMIt 1
                             ) bb ON aa.nik = bb.nik;
				
                last_year_balance := coalesce(last_year_balanced, 0) - coalesce(out_balance, 0) as balance
                                     from (select SUM(out_cuti) over (partition by nik) as out_balance,
                                                  nik
                                           from sc_trx.cuti_blc a
                                           where TRUE
                                             AND nik = emp_id
                                             and tanggal < '2024-03-01'::date
                                             AND tanggal >= '2024-01-01'::date
                                             and no_dokumen ilike '%CT%'
                                           ORDER BY tanggal DESC
                                           LIMIt 1) aa
                                              left join lateral (
                                         select coalesce(sisacuti, 0) - coalesce(in_cuti, 0) AS last_year_balanced,
                                                nik
                                         from sc_trx.cuti_blc a
                                         where TRUE
                                           AND nik = emp_id
                                           AND no_dokumen = 'ADJ2024'
                                         ORDER BY tanggal DESC
                                         LIMIt 1
                                         ) bb ON aa.nik = bb.nik;

                sisa_cuti_lalu = SUM(out_cuti) over (partition by nik) as out_balance
                                 from sc_trx.cuti_blc a
                                 where TRUE
                                   AND nik = emp_id
                                   and tanggal <= '2024-01-03'::Date
                                   AND tanggal >= '2024-01-01'::date
                                 ORDER BY tanggal DESC
                                 LIMIt 1;
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
                                 TO_CHAR(now(), 'YYYY-03-01 00:00:07')::TIMESTAMP ,
                                 concat('HGS',to_char(now(), 'YYYY')),
                                 0,
                                 (select case when (last_year_balance) > 0 THEN last_year_balance ELSE 0 END AS balanced ),
                                 emp_leave_last - sisa_cuti_lalu,
                                 'HGS',
                                 'HANGUS CUTI '||TO_CHAR(now() - INTERVAL '1 YEAR', 'YYYY')
                             );
                    -- Add your logic here for condition 'a'

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
                         'sc_trx.deduction_employee_leave',
                         true,
                         'SYSTEM',
                         NOW()
                     );
            RETURN 11; -- Replace with appropriate return value
        else
            rollback ;
            RETURN 0 ;
        end if;
    ELSE
        RETURN 0;
    END IF;
END;
$$ LANGUAGE plpgsql;