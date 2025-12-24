create OR REPLACE function sc_trx.tr_dinas_after_update() returns trigger
    language plpgsql
as
$$
DECLARE
    number VARCHAR;
BEGIN
    IF ( NEW.status = 'U' and OLD.status <> 'U' ) THEN
        DELETE FROM sc_tmp.dinas WHERE TRUE
                                   AND nik = NEW.nik
                                   AND nodok = NEW.nodok;

        INSERT INTO sc_tmp.dinas (
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
        FROM sc_trx.dinas WHERE TRUE
                            AND nik = NEW.nik
                            AND nodok = NEW.nodok;

        UPDATE sc_trx.dinas SET
                                status = OLD.status,
                                update_by = OLD.update_by,
                                update_date = OLD.update_date
        WHERE TRUE
          AND nik = NEW.nik
          AND nodok = NEW.nodok;
    END IF;
    IF ( NEW.status = 'P' and OLD.status <> 'P' ) THEN
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
        from sc_trx.dinas where TRUE
                            AND nodok = new.nodok
                            and nik = new.nik;
    END IF;
    IF ( NEW.status = 'D' and OLD.status <> 'D' ) THEN
        update sc_trx.approvals_system set status='C',asstatus='C' where docno = new.nodok;
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
        from sc_trx.dinas where TRUE
                            AND nodok = new.nodok
                            and nik = new.nik;
    END IF;
	
	IF ( NEW.status = 'C' and OLD.status <> 'C' ) THEN
        update sc_trx.approvals_system set status='C',asstatus='C' where docno = new.nodok;
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
        from sc_trx.dinas where TRUE
                            AND nodok = new.nodok
                            and nik = new.nik;
    END IF;

    IF ( NEW.status = 'A' and OLD.status <> 'A' ) THEN
        perform sc_trx.pr_capture_approvals_system();
    end if;
    RETURN NEW;
END;
$$;

