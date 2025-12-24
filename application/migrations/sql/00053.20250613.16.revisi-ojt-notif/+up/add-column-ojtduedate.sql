ALTER TABLE sc_tmp.status_kepegawaian ADD duedate_ojt date NULL;
ALTER TABLE sc_trx.status_kepegawaian ADD duedate_ojt date NULL;

-- DROP FUNCTION sc_tmp.pr_stspeg_after();

CREATE OR REPLACE FUNCTION sc_tmp.pr_stspeg_after()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$

declare
    vr_nomor char(30);
 /* ALTER TABLE STATUS */
begin
    delete from sc_mst.penomoran where userid = new.nodok;
    insert into sc_mst.penomoran (userid, dokumen, nomor, errorid, partid, counterid, xno)
       values (new.nodok, 'STATUS-PEG', ' ', 0, ' ', 1, 0);


    vr_nomor
        := trim(coalesce(nomor, '')) from sc_mst.penomoran where userid = new.nodok;

    if
        (trim(vr_nomor) != '') or (not vr_nomor is null) then

        INSERT INTO sc_trx.status_kepegawaian(nodok, nik, kdkepegawaian, tgl_mulai, tgl_selesai, cuti, keterangan,
                                              input_date, update_date, input_by, update_by, nosk, status, ojt, duedate_ojt)

        SELECT vr_nomor,
               nik,
               kdkepegawaian,
               tgl_mulai,
               tgl_selesai,
               cuti,
               keterangan,
               input_date,
               update_date,
               input_by,
               update_by,
               nosk,
               'B'::CHAR(4),
               ojt,
               duedate_ojt

        from sc_tmp.status_kepegawaian
        where nodok = new.nodok
          and nik = new.nik;

        delete
        from sc_tmp.status_kepegawaian
        where nodok = new.nodok
          and nik = new.nik;
		
        update sc_trx.status_kepegawaian
        set status = 'C'
        where nik = new.nik
        and nodok != vr_nomor;

    end if;


    return new;


end;

$function$
;

INSERT INTO sc_mst."option"
(kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option)
VALUES('DEFAULT-DASHBOARD-HR', 'PILIHAN DASHBOARD KHUSUS HR', '3', NULL, NULL, 'T', 'SETUP DASHBOARD AWAL UNTUK HRMS NUSA ', NULL, '0321.438', NULL, '2025-06-06 22:11:01.000', 'DASHBOARD');

INSERT INTO sc_mst."option" (kdoption, nmoption, value1, value2, value3, status, keterangan, input_by, update_by, input_date, update_date, group_option) 
 VALUES('NOTIF-OJT', 'NOTIF-OJT', '0321.438,1221.480', NULL, NULL, 'T', 'SETUP NOTIF NIK OJT BERAKHIR', '1221.480', '1020.406', '2025-03-19 01:48:15.000', '2025-04-13 23:29:03.000', 'OJT'); 

