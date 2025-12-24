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
                                              input_date, update_date, input_by, update_by, nosk, status)

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
               'B'::CHAR(4)

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