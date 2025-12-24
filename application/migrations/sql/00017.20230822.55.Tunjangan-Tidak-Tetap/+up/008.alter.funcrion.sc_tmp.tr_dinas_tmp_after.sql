create OR REPLACE function sc_tmp.tr_dinas_tmp_after() returns trigger
    language plpgsql
as
$$
declare
    vr_nomor char(30);
begin
    if (new.status='F' and old.status='I') then
        delete from sc_mst.penomoran where userid=new.nodok;

        insert into sc_mst.penomoran
        (userid, dokumen, nomor, errorid, partid, counterid, xno)
        values(new.nodok, 'DINAS-LUAR', ' ', 0, ' ', 1, 0);

        vr_nomor:=trim(coalesce(nomor,'')) from sc_mst.penomoran where userid=new.nodok;

        if (trim(vr_nomor)!='') or (not vr_nomor is null) then
            INSERT INTO sc_trx.dinas (
                nik,
                nodok,
                tgl_dok,
                nmatasan,
                tgl_mulai,
                jam_mulai,
                tgl_selesai,
                jam_selesai,
                status,
                keperluan,
                tujuan_kota,
                input_date,
                input_by,
                approval_date,
                approval_by,
                delete_date,
                delete_by,
                update_by,
                update_date,
                cancel_by,
                cancel_date,
                kdkategori,
                transportasi,
                tipe_transportasi,
                jenis_tujuan,
                no_telp
            ) SELECT
                  nik,
                  vr_nomor,
                  tgl_dok,
                  nmatasan,
                  tgl_mulai,
                  jam_mulai,
                  tgl_selesai,
                  jam_selesai,
                  old.status as status,
                  keperluan,
                  tujuan_kota,
                  input_date,
                  input_by,
                  approval_date,
                  approval_by,
                  delete_date,
                  delete_by,
                  update_by,
                  update_date,
                  cancel_by,
                  cancel_date,
                  kdkategori,
                  transportasi,
                  tipe_transportasi,
                  jenis_tujuan,
                  no_telp
            from sc_tmp.dinas where TRUE
                                AND nodok = new.nodok
                                and nik = new.nik
                                and old.status = 'I';

            INSERT INTO sc_his.dinas (
                nik,
                nodok,
                tgl_dok,
                nmatasan,
                tgl_mulai,
                jam_mulai,
                tgl_selesai,
                jam_selesai,
                status,
                keperluan,
                tujuan_kota,
                input_date,
                input_by,
                approval_date,
                approval_by,
                delete_date,
                delete_by,
                update_by,
                update_date,
                cancel_by,
                cancel_date,
                kdkategori,
                transportasi,
                tipe_transportasi,
                jenis_tujuan,
                no_telp
            ) SELECT
                  nik,
                  vr_nomor,
                  tgl_dok,
                  nmatasan,
                  tgl_mulai,
                  jam_mulai,
                  tgl_selesai,
                  jam_selesai,
                  old.status as status,
                  keperluan,
                  tujuan_kota,
                  input_date,
                  input_by,
                  approval_date,
                  approval_by,
                  delete_date,
                  delete_by,
                  update_by,
                  update_date,
                  cancel_by,
                  cancel_date,
                  kdkategori,
                  transportasi,
                  tipe_transportasi,
                  jenis_tujuan,
                  no_telp
            from sc_tmp.dinas where TRUE
                                AND nodok = new.nodok
                                and nik = new.nik
                                and old.status = 'I';

            delete from sc_tmp.dinas where TRUE
                                       AND nodok = new.nodok
                                       and nik = new.nik
                                       and old.status = 'I';
        end if;
    end if;


    IF ( NEW.status = 'U' and OLD.status <> 'U' ) THEN
        DELETE FROM sc_trx.dinas WHERE TRUE
                                   AND nik = NEW.nik
                                   AND nodok = NEW.nodok;

        INSERT INTO sc_trx.dinas (
            nik,
            nodok,
            tgl_dok,
            nmatasan,
            tgl_mulai,
            jam_mulai,
            tgl_selesai,
            jam_selesai,
            status,
            keperluan,
            tujuan_kota,
            input_date,
            input_by,
            approval_date,
            approval_by,
            delete_date,
            delete_by,
            update_by,
            update_date,
            cancel_by,
            cancel_date,
            kdkategori,
            transportasi,
            tipe_transportasi,
            jenis_tujuan,
            no_telp
        ) SELECT
              nik,
              nodok,
              tgl_dok,
              nmatasan,
              tgl_mulai,
              jam_mulai,
              tgl_selesai,
              jam_selesai,
              OLD.status AS status,
              keperluan,
              tujuan_kota,
              input_date,
              input_by,
              approval_date,
              approval_by,
              delete_date,
              delete_by,
              update_by,
              update_date,
              cancel_by,
              cancel_date,
              kdkategori,
              transportasi,
              tipe_transportasi,
              jenis_tujuan,
              no_telp
        FROM sc_tmp.dinas WHERE TRUE
                            AND nik = NEW.nik
                            AND nodok = NEW.nodok;
        INSERT INTO sc_his.dinas (
            nik,
            nodok,
            tgl_dok,
            nmatasan,
            tgl_mulai,
            jam_mulai,
            tgl_selesai,
            jam_selesai,
            status,
            keperluan,
            tujuan_kota,
            input_date,
            input_by,
            approval_date,
            approval_by,
            delete_date,
            delete_by,
            update_by,
            update_date,
            cancel_by,
            cancel_date,
            kdkategori,
            transportasi,
            tipe_transportasi,
            jenis_tujuan,
            no_telp
        ) SELECT
              nik,
              vr_nomor,
              tgl_dok,
              nmatasan,
              tgl_mulai,
              jam_mulai,
              tgl_selesai,
              jam_selesai,
              old.status as status,
              keperluan,
              tujuan_kota,
              input_date,
              input_by,
              approval_date,
              approval_by,
              delete_date,
              delete_by,
              update_by,
              update_date,
              cancel_by,
              cancel_date,
              kdkategori,
              transportasi,
              tipe_transportasi,
              jenis_tujuan,
              no_telp
                                                 from sc_tmp.dinas where TRUE
                                                                     AND nodok = new.nodok
                                                                     and nik = new.nik
                                                                     and old.status = 'I';

        DELETE FROM sc_tmp.dinas WHERE TRUE
                                   AND nik = NEW.nik
                                   AND nodok = NEW.nodok;
    END IF;
    IF ( NEW.status = 'EX' and OLD.status = 'P' ) THEN
        DELETE FROM sc_trx.dinas WHERE TRUE
                                   AND nik = NEW.nik
                                   AND nodok = NEW.nodok;

        INSERT INTO sc_trx.dinas (
            nik,
            nodok,
            tgl_dok,
            nmatasan,
            tgl_mulai,
            jam_mulai,
            tgl_selesai,
            jam_selesai,
            status,
            keperluan,
            tujuan_kota,
            input_date,
            input_by,
            approval_date,
            approval_by,
            delete_date,
            delete_by,
            update_by,
            update_date,
            cancel_by,
            cancel_date,
            kdkategori,
            transportasi,
            tipe_transportasi,
            jenis_tujuan,
            no_telp
        ) SELECT
              nik,
              nodok,
              tgl_dok,
              nmatasan,
              tgl_mulai,
              jam_mulai,
              tgl_selesai,
              jam_selesai,
              'I' AS status,
              keperluan,
              tujuan_kota,
              input_date,
              input_by,
              null,
              null,
              delete_date,
              delete_by,
              update_by,
              update_date,
              cancel_by,
              cancel_date,
              kdkategori,
              transportasi,
              tipe_transportasi,
              jenis_tujuan,
              no_telp
        FROM sc_tmp.dinas WHERE TRUE
                            AND nik = NEW.nik
                            AND nodok = NEW.nodok;
        INSERT INTO sc_his.dinas (
            nik,
            nodok,
            tgl_dok,
            nmatasan,
            tgl_mulai,
            jam_mulai,
            tgl_selesai,
            jam_selesai,
            status,
            keperluan,
            tujuan_kota,
            input_date,
            input_by,
            approval_date,
            approval_by,
            delete_date,
            delete_by,
            update_by,
            update_date,
            cancel_by,
            cancel_date,
            kdkategori,
            transportasi,
            tipe_transportasi,
            jenis_tujuan,
            no_telp
        ) SELECT
              nik,
              vr_nomor,
              tgl_dok,
              nmatasan,
              tgl_mulai,
              jam_mulai,
              tgl_selesai,
              jam_selesai,
              old.status as status,
              keperluan,
              tujuan_kota,
              input_date,
              input_by,
              approval_date,
              approval_by,
              delete_date,
              delete_by,
              update_by,
              update_date,
              cancel_by,
              cancel_date,
              kdkategori,
              transportasi,
              tipe_transportasi,
              jenis_tujuan,
              no_telp
        from sc_tmp.dinas where TRUE
                            AND nodok = new.nodok
                            and nik = new.nik
                            and old.status = 'I';
        DELETE FROM sc_tmp.dinas WHERE TRUE
                                   AND nik = NEW.nik
                                   AND nodok = NEW.nodok;
    END IF;

    RETURN NEW;
end;
$$;