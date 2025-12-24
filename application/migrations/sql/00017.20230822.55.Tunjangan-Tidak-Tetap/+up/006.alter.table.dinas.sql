DO
$$
    BEGIN
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'dinas' AND column_name = 'callplan' ) THEN
            ALTER TABLE sc_tmp.dinas ADD callplan boolean ;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'callplan' ) THEN
            ALTER TABLE sc_trx.dinas ADD callplan boolean ;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_tmp' AND table_name = 'dinas' AND column_name = 'tipe_transportasi' ) THEN
            ALTER TABLE sc_tmp.dinas ADD tipe_transportasi varchar ;
        END IF;
        IF NOT EXISTS (SELECT column_name FROM information_schema.columns WHERE table_schema = 'sc_trx' AND table_name = 'dinas' AND column_name = 'tipe_transportasi' ) THEN
            ALTER TABLE sc_trx.dinas ADD tipe_transportasi varchar ;
        END IF;
    END
$$;
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
                callplan,
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
                  callplan,
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
            callplan,
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
              callplan,
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

        DELETE FROM sc_tmp.dinas WHERE TRUE
                                   AND nik = NEW.nik
                                   AND nodok = NEW.nodok;
    END IF;
    RETURN NEW;
end;
$$;

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
            callplan,
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
              callplan,
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
    RETURN NEW;
END;
$$;

